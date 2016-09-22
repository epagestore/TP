<?php
class order_transaction_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}
	public function insertProduct($data,$image)
	{
		echo $data['supplier_ids'];
		
		if($image=='0')
		{$image="";}
		else
		$image="image ='".$image."'";
		$this->db->query("INSERT INTO `product_trade_information` SET min_order_qty = ".$data['min_order'].", min_order_qty_unit = '".$data['min_order_unit']."', supply_quantity = ".$data['supply_amount'].", supply_unit = '".$data['supply_unit']."', supply_time = '".$data['supply_time']."', price_min = ".$data['min_price'].", price_max = ".$data['max_price'].", price_unit = '".$data['price_unit']."', price_currency = ".$data['price_currency'].", port = '".$data['port']."',payment_terms = '".implode(',',$data['payment_term'])."', delivery_time = '".$data['delivery_time']."', packaging_details = '".$data['pack_details']."'");
		$product_trade_id=$product_id=$this->db->insert_id();
		$this->db->query("INSERT INTO `product` SET product_name = '".$data['product_name']."' , keywords = '".$data['product_keywords']."', listing_description ='".$data['description']."' ".$image.", detail_description = '".addslashes($data['message'])."', product_trade_id = ".$product_trade_id.", date_added = NOW(), date_modified =NOW()");
		$product_id=$this->db->insert_id();
		$i=0;
		foreach($data['attribute'] as $attribute){
			$this->db->query("INSERT INTO `attribute` SET  name = '".$attribute."', value = '".$data['attribute_value'][$i]."'");
			$attribute_id=$this->db->insert_id();
			$this->db->query("INSERT INTO `product_attribute` SET product_id = ".$product_id.", attribute_id = ".$attribute_id);
			$i++;
		}
		// supplier id is remained 
		$this->db->query("INSERT INTO `product_to_supplier` SET supplier_id =". $data['supplier_ids'].", product_id = ".$product_id);
		$prod_to_sup_id=$this->db->insert_id();
		$this->db->query("INSERT INTO `product_to_category` SET category_id =".$data['category_id'].", product_id = ".$product_id);
		
		
		$i=0;
		foreach($data['product_data'] as $product_data){
			$this->db->query("INSERT INTO `product_quick_details` SET product_id = ".$product_id.", product_data = '".$product_data."', product_data_value = '".$data['product_data_value'][$i]."'");
			$i++;
		}
	}
	public function getUnit()
	{
		$query=$this->db->query("SELECT * FROM `unit`");		
		return $query->result_array();
	}
	public function regnerateCode($order_product_id)
	{
		$this->db->query("INSERT INTO `order_product_oldcode` (payer_code,payee_code,date_changed,order_product_id) SELECT payer_code,payee_code,NOW(),".$order_product_id." from order_product where order_product_id = ".$order_product_id);
		$this->db->query("UPDATE `order_product` SET payer_code='".random_string('alpha', 5)."', payee_code='".random_string('alpha', 5)."' where order_product_id =".$order_product_id);
	}
	public function getOrderTransaction($keyword='',$page_limit='',$order_id=''){
		$where='';
		// supplier id remained
		if($order_id!='')
		{
			$where=' AND o.order_id ='.$order_id;
		}
		if($keyword!='')
		$keyword=" having (Company_name like '%".$keyword."%' or payee_name like '%".$keyword."%' or Payer_name like '%".$keyword."%')";
		
		$query=$this->db->query("SELECT o.*, (Select company_name from customer_company where o.company_id = customer_id) as Company_name, (Select CONCAT(first_name,' ',last_name) from customer where o.payer_id = customer_id) as Payer_name,(Select CONCAT(first_name,' ',last_name) from customer where o.payee_id = customer_id) as Payee_name  FROM `order` o where 1=1 ".$where." ".$keyword." ".$page_limit);
				
		$query_total=$this->db->query("SELECT o.*, (Select company_name from customer_company where o.company_id = customer_id) as Company_name, (Select CONCAT(first_name,' ',last_name) from customer where o.payer_id = customer_id) as Payer_name,(Select CONCAT(first_name,' ',last_name) from customer where o.payee_id = customer_id) as Payee_name  FROM `order` o where 1=1 ".$where." ".$keyword." ");

		return array(  'results' => $query->result_array(), 'num_results' =>$query_total->num_rows());
		//return $query->result_array();
	}
	
	public function getOrderProducts($order_id){
		$query=$this->db->query("SELECT * FROM `order_product` WHERE order_id =".$order_id);
		return $query->result_array();
	}

	public function getOrderMilestones($order_id){
		$query=$this->db->query("SELECT * FROM `order_milestone` WHERE order_id =".$order_id);
		return $query->result_array();
	}

	public function getProductPerOrder($order_product_id){
		$query=$this->db->query("SELECT * FROM `order_product` WHERE order_product_id =".$order_product_id);
		return $query->result_array();
	}
	
	public function getProductStatus($order_product_status_id){
		$query=$this->db->query("SELECT * FROM `order_status` WHERE order_status_id =".$order_product_status_id);
		
		$result = $query->row();

		return $result->name;		
	}
	
	public function getReleasedByName($released_by){
		$query=$this->db->query("SELECT * FROM `user` WHERE user_id =".$released_by);
		
		$result = $query->row();

		return $result->username;		
	}

	public function getProductPerMilestone($milestone_id){
		$query=$this->db->query("SELECT * FROM `order_milestone` WHERE milestone_id =".$milestone_id);
		return $query->result_array();
	}


	public function updateOrderTransaction($data){
		$query=$this->db->query("UPDATE `order` set total_amount =".$data['total']." WHERE order_id = ".$data['order_id']);
		
	}

	public function getOrderStatus(){
		$query=$this->db->query("SELECT * FROM `order_status`");
		return $query->result_array();
	}

	public function updateProduct($order_product_id,$data){
		$query=$this->db->query("UPDATE `order_product` set quantity =".$data['quantity'].", order_product_status_id =".$data['order_status']." WHERE order_product_id = ".$order_product_id);
		
	}


	public function updateMilestone($milestone_id,$data){
		$query=$this->db->query("UPDATE `order_milestone` set amount =".$data['amount'].", status =".$data['order_status']." WHERE milestone_id = ".$milestone_id);
		
	}



	public function getProductTradeInfoPlaceOrder($product_id){
		$query=$this->db->query("SELECT * FROM `product_trade_information` WHERE prod_type = '1' and product_id =".$product_id);
		return $query->result_array();
	}
	
	public function getProductTradeInfoRetail($product_id){
		$query=$this->db->query("SELECT * FROM `product_trade_information` WHERE prod_type = '2' and sell_type = '1' and product_id =".$product_id);
		return $query->result_array();
	}	

	public function getProductTradeInfoWholesale($product_id){
		$query=$this->db->query("SELECT * FROM `product_trade_information` WHERE prod_type = '2' and sell_type = '2' and product_id =".$product_id);
		return $query->result_array();
	}	


	public function getProductQuickDetails($product_id){
		$query=$this->db->query("SELECT * FROM `product_quick_details` WHERE product_id =".$product_id);
		return $query->result_array();
	}
	public function getProductAttribute($product_id){
		$query=$this->db->query("SELECT pa.product_id,a.attribute_id,name,value FROM `product_attribute` pa ,`attribute` a where pa.attribute_id=a.attribute_id AND product_id = ".$product_id);
		return $query->result_array();
	}
	public function deleteOrder($order_id){
			
			$this->db->query(" DELETE FROM `order` where order_id = ".$order_id);
	}
	
}?>
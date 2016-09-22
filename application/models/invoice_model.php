<?php
class invoice_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}
	public function sendOrderMail($current_orders,$customer_id)
	{
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'From: Trustedpayer <info@trustedpayer.com>' . "\r\n";
		$payer_message=$payee_message=$message_body='';
		$message_header='<table bgcolor="#f6f6f6" width="100%" style="font-family:Arial, Helvetica, sans-serif; font-size:13px;"><tbody><tr><td><table><tr><td>You recently purchased the following items from Yehki.com  with the transaction details  below :</td></tr></table><table cellpadding="5" cellspacing="0" width="100%" border="0" bordercolor="#1996E6" style="border-collapse:collapse; border:1px solid #1996E6; font-family:Arial, Helvetica, sans-serif; font-size:13px;"><thead bgcolor="#1996E6"><tr><th width="59">Date</th><th width="40">TP order Id</th><th width="62">Payment To</th><th width="44">Order Id</th><th width="64">Order Amount</th><th width="64">Order Summary</th><th width="64"></th><th width="50"></th><th width="66"></th></tr></thead>';
		$message_header1='<table bgcolor="#f6f6f6" width="100%" style="font-family:Arial, Helvetica, sans-serif; font-size:13px;"><tbody><tr><td><table><tr><td>Your have received a purchase order  from Iyke Idukpaye @Yehki.com with the following details </td></tr></table><table cellpadding="5" cellspacing="0" width="100%" border="0" bordercolor="#1996E6" style="border-collapse:collapse; border:1px solid #1996E6; font-family:Arial, Helvetica, sans-serif; font-size:13px;"><thead bgcolor="#1996E6"><tr><th width="59">Date</th><th width="40">TP order Id</th><th width="62">Payment To</th><th width="44">Order Id</th><th width="64">Order Amount</th><th width="64">Order Summary</th><th width="64"></th><th width="50"></th><th width="66"></th></tr></thead>';
		
		$query = $this->db->query(" select * from currency where currency_id=".$this->session->userdata('currency_id'));
		$currency = $query->row();
		
		foreach($current_orders as $order)
		{

			$query_order=$this->db->query("SELECT company_id, payer_code, payee_code,  order_key, payer_id, payee_id, shipping_method, shipping_firstname, shipping_address_1, total_amount, order_status_id, date_added, date_modified from `order` where order_id=".$order);
			$order_placed=$query_order->result_array();
			$message_body.='<tbody style="color:black;"><tr align="center">';
			//Date added
			$message_body.='<td valign="baseline" cellspacing="0">'.date('F jS Y',strtotime($order_placed[0]['date_added'])).'<br>'. date('g:i:s A',strtotime($order_placed[0]['date_added'])).'</td>';
			//TP order id
			$message_body.='<td style="">'.$order.'</td>';
			// Payment To
			$query_company=$this->db->query("SELECT company_name from `customer_company` where customer_id=".$order_placed[0]['company_id']);
			$company_info=$query_company->result_array();
			$message_body.='<td style="">'.$company_info[0]['company_name'].'</td>';
			//Order Id
			$message_body.='<td style="">'.$order_placed[0]['order_key'].'</td>';
			//Order Amount
			$message_body.='<td>'.$currency->symbol." ".($order_placed[0]['total_amount']*$currency->value).'</td>';
			// Order Summary
			$message_body.='<td><b>Product name</b></td><td><b>Price</b></td><td><b>Status</b></td><td><b>Order keys</b></td></tr>';
			$query_order_product=$this->db->query("SELECT order_id ,product_key , transaction_id , payer_code, payee_code, name, quantity , price , shipping_cost , total , order_product_status_id ,complete_order_time,complete_order_unit from `order_product` where order_id=".$order);
			$order_product=$query_order_product->result_array();
			foreach($order_product as $product)
			{
				
				$message_body.='<tr align="center"><td></td><td><span style="display:none"></span></td><td><span style="display:none"></span></td><td><span style="display:none"></span></td><td><span style="display:none"></span></td>';
				//product name
				$message_body.='<td>'.$product['name'].' </td>';
				//price
				$message_body.='<td>'.$currency->symbol." ".($product['total']*$currency->value).'</td>';
				//status
				$message_body.='<td>Paid</td>';
				//order keys
				$payer_message.=$message_body.'<td>'.$product['payer_code'].'</td></tr>';
				$payee_message.=$message_body.'<td>'.$product['payee_code'].'</td></tr>';
				$message_body='';
				
			}
			$payer_message.='</tbody>';
			$payee_message.='</tbody>';
			$message_body='';
			
			$message_footer='</table><table><tr><td>';
			$message_footer.='Your secret code for Order '.$order_placed[0]['order_key'].' is important and REQUIRED TO CONFIRM DELIVERY OF YOUR PRODUCT TO YOUR CUSTOMER/BUYER ; It should be kept securely to complete your order . Do not share this code for any reason. You can only share your code with your shipper  if you are not shipping by your self ; this is neccessary  to enable your shipper to complete and confirm delivery of the product to the buyer instantly  Any request for it from anyone aprt from your shipper is a scam.';
			$message_footer.='<br />You or your shipper   should only exchange/share your secret code with your buyer on delivery of your item  to confirm delivery and demand  release of payment from your buyer. Please click on complete order on your marketplace or online store to release payments,  once you have delivered  your product; "Please note that a release of your codes signifies your acceptance of the  terms and conditions governing the Trustedpayer service. ';
			$message_footer.='</td></tr></table></td></tr></table>';
			
			$payee_final_message=$message_header1.$payee_message.$message_footer;
			
			$payee_query=$this->db->query("SELECT email from `customer` where customer_id=".$order_placed[0]['payee_id']);
			$payee_customer=$payee_query->result_array();
			$to=$payee_customer[0]['email'];
			$subject="Order Product Key";
			$flag=mail($to, $subject, urldecode($payee_final_message), $headers);
			$payee_message='';
		}
		$message_footer='</table><table><tr><td>';
		$message_footer.='Your secret code for Order '.$order_placed[0]['order_key'].' is important and should be kept securely to complete your order . Do not share this code for any reason. Any request for it from anyone aprt from your seller  is a scam."';
		$message_footer.='<br />You should only exchange/share your secret code with your product supplier/shipper on delivery of your item and on completion of the order to release paymeny to your seller. Please click on complete order to release payments once you are satisfied with your item: "Please note that a release of your codes signifies your acceptance of the goods and/or services provider by the seller". ';
		$message_footer.='</td></tr></table></td></tr></table>';
		
		$payer_final_message=$message_header.$payer_message.$message_footer;
		
		
		$payer_query=$this->db->query("SELECT email from `customer` where customer_id=".$customer_id);
		$payer_customer=$payer_query->result_array();
		$to=$payer_customer[0]['email'];
		$subject="Order Product Key";
		
		
		
		$flag=mail($to, $subject, urldecode($payer_final_message), $headers);
		
	}
	public function sendInvoice($customer_id,$data)
	{
		$cr= isset($this->session->userdata['current_currency']['value'])?$this->session->userdata['current_currency']['value']:'1'; 
		if($cr)
		{
			$cr=$cr;
		}else{
			$cr=1;
		}	
		
		$unique_key=date('dmy')."".random_string('alnum', 5)."".date('his');
		$this->db->query("INSERT INTO `invoice` SET customer_id=$customer_id,`key`='".$unique_key."', send_to='".$data['send_to']."', payment_terms='".$data['pay_terms']."',due_date='".$data['due_date']."',terms='".$data['term_condi']."',notes='".$data['note']."',total='".($data['total'])/($cr)."',discount='".$data['discount']."',discount_type='%',shipping='".($data['shipping'])/($cr)."',memo='".$data['memo']."',status=2, date_added=NOW()  ");
		$invoice_id=$this->db->insert_id();
		
		$i=0;
		foreach($data['qty'] as $qty)
		{
			$this->db->query("INSERT INTO `invoice_order` SET invoice_id=$invoice_id, tax='".$data['tax'][$i]."', item='".$data['item_name'][$i]."', quantity='".$data['qty'][$i]."', description='".addslashes($data['disc'][$i])."',unit_price='".($data['unit_price'][$i])/($cr)."', status=1 ");
			$i++;
		}
		$opt=$this->get_geolocation();
		
		$query = $this->db->query(" select * from currency where currency_id=".$this->session->userdata('currency_id'));
		$currency = $query->row();
		
		$payer=$this->db->query("select * from customer where email='".$data['send_to']."'")->row();
		$current_orders=array();
		$this->db->query("INSERT INTO `order` SET is_milestone=2, currency_code='".$currency->code."',currency_value=".$currency->value.", currency_id=".$currency->currency_id." , payer_code='".random_string('alpha', 5)."', payee_code='".random_string('alpha', 5)."',  order_key =".$invoice_id.", payer_id = ".$payer->customer_id.", payee_id = ".$customer_id.",  total_amount =".($data['total'])/($cr).", order_status_id  =1,ip='".$this->input->ip_address()."',city='".$opt['city']."',country='".$opt['country']."',countryCode='".$opt['countryCode']."',late='".$opt['late']."', region='".$opt['region']."',regionName='".$opt['regionName']."',zip='".$opt['zip']."',lon='".$opt['long']."', date_added = NOW(), date_modified = NOW()");
		$order_id=$this->db->insert_id();
		$current_orders[]=$order_id;
		$this->db->query("update invoice set order_id='".$order_id."' where invoice_id='".$invoice_id."'");
		$merchant=$this->db->query("select * from customer where customer_id=".$customer_id)->row();
		$i=0;		
		foreach($data['qty'] as $qty)
		{
			$payer_code=random_string('alpha', 5);
			$payee_code=random_string('alpha', 5);
			
			$this->db->query("INSERT INTO `order_product` SET order_id =".$order_id.", payer_code='".$payer_code."', payee_code='".$payee_code."', name = '".$data['item_name'][$i]."', quantity = ".$data['qty'][$i].", price = ".($data['unit_price'][$i])/($cr).", shipping_cost = ".($data['shipping'])/($cr).", total = ".($data['unit_price'][$i]*$data['qty'][$i])/($cr).", order_product_status_id  =0 , tp_plan='".$merchant->merchant."',tp_amount='".((($data['unit_price'][$i])/($cr)*$merchant->merchant)/100)."',tax='".$data['tax'][$i]."'");
			$i++;
		}
		
		return $invoice_id;
		
		
	}
	public function get_geolocation()
	{
		$url = 'http://ip-api.com/json/'.($this->input->ip_address()=='127.0.0.1'?'122.179.147.63':$this->input->ip_address());		
		/* Geo Location API */
		$ch = curl_init();
		// Disable SSL verification
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		// Will return the response, if false it print the response
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		// Set the url
		curl_setopt($ch, CURLOPT_URL,$url);
		// Execute
		$result=curl_exec($ch);
		// Closing
		
		curl_close($ch);
		$result = json_decode($result, true);
		$data=$result;
		if($result['status'] != 'fail')
		{
			$data['city'] = $result['city'] ;
			$data['country'] = $result['country'] ;
			$data['countryCode'] = $result['countryCode'] ;
			$data['late'] = $result['lat'] ;
			$data['long'] = $result['lon'] ;
			$data['region'] = $result['region'] ;
			$data['regionName'] = $result['regionName'] ;
			$data['zip'] = $result['zip'] ;
		}
		return $data;
		/* Geo Location API */
		
	}
	public function sendInvoiceNow($invoice_id)
	{
		$this->db->query("UPDATE `invoice` SET status=2 WHERE invoice_id=".$invoice_id);
	}
	public function saveInvoice($customer_id,$data)
	{
		$cr= isset($this->session->userdata['current_currency']['value'])?$this->session->userdata['current_currency']['value']:'1'; 
		if($cr)
		{
			$cr=$cr;
		}else{
			$cr=1;
		}	
		$unique_key=date('dmy')."".random_string('alnum', 5)."".date('his');
		$this->db->query("INSERT INTO `invoice` SET customer_id=$customer_id,`key`='".$unique_key."', send_to='".$data['send_to']."', payment_terms=".$data['pay_terms'].",due_date='".$data['due_date']."',terms='".$data['term_condi']."',notes='".$data['note']."',total=".($data['total'])/($cr).",discount=".$data['discount'].",discount_type='%',shipping=".($data['shipping'])/($cr).",memo='".$data['memo']."',status=1, date_added=NOW() ");
		$invoice_id=$this->db->insert_id();
		$i=0;
		foreach($data['qty'] as $qty)
		{
			$this->db->query("INSERT INTO `invoice_order` SET invoice_id=$invoice_id, tax='".$data['tax'][$i]."', item='".$data['item_name'][$i]."', description='".addslashes($data['disc'][$i])."', quantity=".$data['qty'][$i].",unit_price='".($data['unit_price'][$i])/($cr)."', status=1 ");
			$i++;
		}
		
		$opt=$this->get_geolocation();
		
		$query = $this->db->query(" select * from currency where currency_id=".$this->session->userdata('currency_id'));
		$currency = $query->row();
		
		$payer=$this->db->query("select * from customer where email='".$data['send_to']."'")->row();
		$current_orders=array();
		$this->db->query("INSERT INTO `order` SET is_milestone=2, currency_code='".$currency->code."',currency_value=".$currency->value.", currency_id=".$currency->currency_id." , payer_code='".random_string('alpha', 5)."', payee_code='".random_string('alpha', 5)."',  order_key =".$invoice_id.", payer_id = ".$payer->customer_id.", payee_id = ".$customer_id.",  total_amount =".($data['total'])/($cr).", order_status_id  =1,ip='".$this->input->ip_address()."',city='".$opt['city']."',country='".$opt['country']."',countryCode='".$opt['countryCode']."',late='".$opt['late']."', region='".$opt['region']."',regionName='".$opt['regionName']."',zip='".$opt['zip']."',lon='".$opt['long']."', date_added = NOW(), date_modified = NOW()");
		$order_id=$this->db->insert_id();
		$current_orders[]=$order_id;
		$this->db->query("update invoice set order_id='".$order_id."' where invoice_id='".$invoice_id."'");
		$merchant=$this->db->query("select * from customer where customer_id=".$customer_id)->row();
		$i=0;		
		foreach($data['qty'] as $qty)
		{
			$payer_code=random_string('alpha', 5);
			$payee_code=random_string('alpha', 5);
			
			$this->db->query("INSERT INTO `order_product` SET order_id =".$order_id.", payer_code='".$payer_code."', payee_code='".$payee_code."', name = '".$data['item_name'][$i]."', quantity = ".$data['qty'][$i].", price = ".($data['unit_price'][$i])/($cr).", shipping_cost = ".($data['shipping'])/($cr).", total = ".($data['total_product_amount'][$i])/($cr).", order_product_status_id  =0, tp_plan='".$merchant->merchant."',tp_amount='".((($data['unit_price'][$i]*$data['qty'][$i])/($cr)*$merchant->merchant)/100)."'");
			$i++;
		}
		
	}
	public function payInvoice($invoice_id)
	{
		$query=$this->db->query("UPDATE `invoice` SET status=3,date_paid=NOW() WHERE invoice_id=$invoice_id");
		$data=$this->getInvoice($invoice_id);
		$this->db->query("INSERT INTO `customer_transaction`  SET customer_id=".$data['invoice'][0]['customer_id'].", amount=+".$data['invoice'][0]['total'].", description='Invoice amount received', date_added = NOW()");
		$transaction_id=$this->db->insert_id();
		$query=$this->db->query("SELECT customer_id from `customer_account_balance`  where customer_id = ".$data['invoice'][0]['customer_id']);
		$exist=$query->result_array();
		if(!count($exist))
		$this->db->query("INSERT INTO `customer_account_balance` SET customer_id = ".$data['invoice'][0]['customer_id'].", total_balance = ".str_replace(",","",$data['invoice'][0]['total']).", date_modified = NOW()");
		else
		$this->db->query("UPDATE `customer_account_balance` SET total_balance=total_balance+".str_replace(",","",$data['invoice'][0]['total']).", date_modified = NOW() where customer_id = ".$data['invoice'][0]['customer_id']);
	
		$o=$this->db->query("select * from invoice where invoice_id='".$invoice_id."'")->row();
		$this->db->query("update order_product set transaction_id='".$transaction_id."', order_product_status_id=1 where order_id='".$o->order_id."'");
		$this->db->query("update `order` set transaction_id='".$transaction_id."' where order_id='".$o->order_id."'");
		$current_orders=array();
		$current_orders[]=$o->order_id;
		//$this->sendOrderMail($current_orders,$this->session->userdata('customer_id'));
	}
	public function getInvoices($customer_id)
	{
		$query=$this->db->query("SELECT * from `invoice` where customer_id=$customer_id order by date_added desc");
		return $query->result_array();
	}
	public function getInvoice($invoice_id)
	{
		$query=$this->db->query("SELECT q.*,cust.first_name,cust.customer_phone,cust.last_name,cust.email as personal_email,cust.photo,cust_cmpny.company_name,cust_cmpny.company_website from ( SELECT * from `invoice` where invoice_id=$invoice_id ) q LEFT JOIN `customer` cust ON q.customer_id=cust.customer_id LEFT JOIN `customer_company` cust_cmpny ON cust_cmpny.customer_id=cust.customer_id ");
		$query1=$this->db->query("SELECT * from `invoice_order` where invoice_id='".$invoice_id."'");
		return array('invoice'=>$query->result_array(),'invoice_order'=>$query1->result_array());
	}
	public function getInvoiceByKey($key)
	{
		$query=$this->db->query("SELECT q.*,cust.first_name,cust.customer_phone,cust.last_name,cust.email as personal_email,cust.photo,cust_cmpny.company_name,cust_cmpny.company_website from (SELECT * from `invoice` where `key`='$key' ) q LEFT JOIN `customer` cust ON q.customer_id=cust.customer_id LEFT JOIN `customer_company` cust_cmpny ON cust_cmpny.customer_id=cust.customer_id ");
		$invoice=$query->result_array();
		$query1=$this->db->query("SELECT * from `invoice_order` where invoice_id='".$invoice[0]['invoice_id']."'");
		return array('invoice'=>$invoice,'invoice_order'=>$query1->result_array());
	}
}?>
<?php
class order_transaction extends CI_Controller{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->helper('url');
		if(!isset($this->session->userdata['is_logged_in'])) { 
				redirect('login');
		}
		$this->load->model('order_transaction_model');
		
		$this->load->helper('form');
		$this->load->library('form_validation');
	}
	public function index() {
		$this->manageOrderTransactionForm();
	}
	public function delete($order_id){
				
		$ord_id=explode('--',$order_id);
		foreach($ord_id as $id)
		{
			$this->order_transaction_model->deleteOrder($id);
		}
		redirect('order_transaction');
	}
	public function manageOrderTransactionForm($page='1',$keyword=''){
		
		$keyword='';
		if($this->input->server('REQUEST_METHOD')=='POST')
		{
			$keyword=$this->input->post('keyword');
		}
		$data='';
		
		if(isset($_GET['keyword'])){
			
			$keyword = urldecode($_GET['keyword']);
			
		}
		$data['keyword']=$keyword;	
		
		$page_limit='LIMIT '.(($page-1)*10).',10';
		
		$orders=$this->order_transaction_model->getOrderTransaction($keyword,$page_limit);
		
		$data['orders']=$orders['results'];
		$data['page_total']=ceil($orders['num_results']/10);
		
/*		echo '<pre>';
		print_r($data['page_total']);
		exit;
	*/	
		
		/* Kinnari */
		$this->load->model('customer_model');
		$cust_detail=$this->customer_model->get_customer($customer_id); 
		$data['cust_detail']=$cust_detail;
		/* Kinnari */
		$this->load->view('header',$data);
		$this->load->view('order_transaction_list',$data);
		$this->load->view('footer',$data);
	}
	public function page($page,$filters='') {
		
		if(isset($_GET['keyword'])){
			$keyword = urldecode($_GET['keyword']);
			$this->manageOrderTransactionForm($page,$keyword);			
		} else { 
			$this->manageOrderTransactionForm($page);			
		}
		
	}
	public function regnerate_code($order_product_id)
	{
		$this->order_transaction_model->regnerateCode($order_product_id);
		$this->load->model('customer_model');
		$orders=$this->order_transaction_model->getProductPerOrder($order_product_id);	
		$orders_result=$this->order_transaction_model->getOrderTransaction('','',$orders[0]['order_id']);
		
		$payer=$this->customer_model->emailById($orders_result['results'][0]['payer_id']);
		$payee=$this->customer_model->emailById($orders_result['results'][0]['payee_id']);
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'From: Trustedpayer <info@trustedpayer.com>' . "\r\n";
		$flag=mail($payer[0]['email'], "Trusted Payer Secret Code", "New code generate For :<br>order number : ".$orders_result['results'][0]['order_id']."<br>New code : ".$orders[0]['payer_code'], $headers);
		$flag=mail($payee[0]['email'], "Trusted Payer Secret Code", "New code generate For :<br>order number : ".$orders_result['results'][0]['order_id']."<br>New code : ".$orders[0]['payee_code'], $headers);
		
		/* sms send */
		//Payer
		$message="New code generate For :<br>order number : ".$orders_result['results'][0]['order_id']."<br>New code : ".$orders[0]['payer_code'];
		if($payer[0]['verify'])
		{			
			$this->sms->send($message,urlencode("+".$payer[0]['phonecode'].$payer[0]['customer_phone']));
		}
		//Payee
		$message="New code generate For :<br>order number : ".$orders_result['results'][0]['order_id']."<br>New code : ".$orders[0]['payee_code'];
		if($payer[0]['verify'])
		{
			$this->sms->send($message,urlencode("+".$payee[0]['phonecode'].$payee[0]['customer_phone']));
		}
		/* sms send */
		
		$this->session->set_flashdata('message', 'New code generated successfully!');
		redirect('order_transaction/postingProduct/'.$order_product_id);
	}
	public function posting($order_id='') {
		
		if($this->input->server('REQUEST_METHOD')=='POST')
		{			
			if($order_id!='')
			{
				
				$this->order_transaction_model->updateOrderTransaction($this->input->post());
			}
			
			redirect('order_transaction');
		}
		else{
		
			$data='';
			$data['product_id']='';
			$data['product_name']='';
			$data['product_keywords']='';
			$data['description']='';
			$data['image']='';
			$data['category_id']='';	
			$data['min_order']='';
			$data['min_order_unit']='';
			$data['price_currency']='';
			$data['min_price']='';
			$data['max_price']='';
			$data['price_unit']='';
			$data['port']='';
			$data['payment_terms']='';
			$data['supply_amount']='';
			$data['supply_unit']='';
			$data['supply_time']='';
			$data['delivery_time']='';
			$data['pack_details']='';
			$data['message']='';
			$data['category_path']='';
			$data['status']='';
			$data['quick_product']=array();
			$data['product_attribute']=array();
			$data['product_trade_id']='';

			if($order_id!='')
			{
				$data['order_id']=$order_id;
				//$products_result=$this->product_model->getProduct($product_id);
				$orders_result=$this->order_transaction_model->getOrderTransaction('','',$order_id);				
				$data['orders']=$orders_result['results'];
								
				foreach($data['orders'] as $order){
					$data['order_id']=$order['order_id'];
					$data['transaction_id']=$order['transaction_id'];
					$data['is_milestone']=$order['is_milestone'];
					$data['total_amount']=$order['total_amount'];
					$data['company_id']=$order['company_id'];
					$data['Company_name']=$order['Company_name'];
					$data['payer_id']=$order['payer_id'];
					$data['payee_id']=$order['payee_id'];
					$data['Payer_name']=$order['Payer_name'];
					$data['Payee_name']=$order['Payee_name'];
					$data['payer_code']=$order['payer_code'];
					$data['payee_code']=$order['payee_code'];					
					
					if($order['is_milestone'] == 0){
						
						$data['product_results'] = $this->order_transaction_model->getOrderProducts($order['order_id']);	
					
					} else if($order['is_milestone'] == 1){
						
						$data['milestone_results'] = $this->order_transaction_model->getOrderMilestones($order['order_id']);	
					
					}
					
				}
			}
			/* Kinnari */
			$this->load->model('customer_model');
			$cust_detail=$this->customer_model->get_customer($customer_id); 
			$data['cust_detail']=$cust_detail;
			/* Kinnari */
			$this->load->view('header',$data);
			$this->load->view('order_transaction_form',$data);
			$this->load->view('footer',$data);
		}
	}

	public function postingProduct($order_product_id='') {
		
		if($this->input->server('REQUEST_METHOD')=='POST')
		{			
			if($order_product_id!='')
			{
				
				$this->order_transaction_model->updateProduct($order_product_id,$this->input->post());
			}
			
			redirect('order_transaction');
		}
		else{
		
			$data='';
			$data['product_id']='';
			$data['product_name']='';
			$data['product_keywords']='';
			$data['description']='';
			$data['image']='';
			$data['category_id']='';	
			$data['min_order']='';
			$data['min_order_unit']='';
			$data['price_currency']='';
			$data['min_price']='';
			$data['max_price']='';
			$data['price_unit']='';
			$data['port']='';
			$data['payment_terms']='';
			$data['supply_amount']='';
			$data['supply_unit']='';
			$data['supply_time']='';
			$data['delivery_time']='';
			$data['pack_details']='';
			$data['message']='';
			$data['category_path']='';
			$data['status']='';
			$data['quick_product']=array();
			$data['product_attribute']=array();
			$data['product_trade_id']='';
						
			if($order_product_id!='')
			{
				$data['order_product_id']=$order_product_id;
				//$products_result=$this->product_model->getProduct($product_id);
				$orders_result=$this->order_transaction_model->getProductPerOrder($order_product_id);				
								
				foreach($orders_result as $order){
					$data['order_id']=$order['order_id'];
					$data['transaction_id']=$order['transaction_id'];
					$data['name']=$order['name'];
					$data['quantity']=$order['quantity'];
					$data['price']=$order['price'];
					$data['total']=$order['total'];
					$data['payer_code']=$order['payer_code'];
					$data['payee_code']=$order['payee_code'];					
					$data['order_product_status_id']=$order['order_product_status_id'];					
					
					$data['status'] = $this->order_transaction_model->getProductStatus($order['order_product_status_id']);

					$data['order_statuses'] = $this->order_transaction_model->getOrderStatus();
										
				if($order['released_by'] != 0){
					
					if($order['order_product_status_id'] == 2){
						
						$data['releasedByName'] = $this->order_transaction_model->getReleasedByName($order['released_by']);
					
					}					
				}
				}
				

			}
			/* Kinnari */
			$this->load->model('customer_model');
			$cust_detail=$this->customer_model->get_customer($customer_id); 
			$data['cust_detail']=$cust_detail;
			/* Kinnari */
			$this->load->view('header',$data);
			$this->load->view('order_transaction_product_form',$data);
			$this->load->view('footer',$data);
		}
	}	
	
	
	public function postingMilestone($milestone_id='') {
		
		if($this->input->server('REQUEST_METHOD')=='POST')
		{			
			if($milestone_id!='')
			{
				
/*				echo '<pre>';
				print_r($this->input->post());
				exit;
*/				
				$this->order_transaction_model->updateMilestone($milestone_id,$this->input->post());
			}
			
			redirect('order_transaction');
		}
		else{
		
			$data='';
			$data['product_id']='';
			$data['product_name']='';
			$data['product_keywords']='';
			$data['description']='';
			$data['image']='';
			$data['category_id']='';	
			$data['min_order']='';
			$data['min_order_unit']='';
			$data['price_currency']='';
			$data['min_price']='';
			$data['max_price']='';
			$data['price_unit']='';
			$data['port']='';
			$data['payment_terms']='';
			$data['supply_amount']='';
			$data['supply_unit']='';
			$data['supply_time']='';
			$data['delivery_time']='';
			$data['pack_details']='';
			$data['message']='';
			$data['category_path']='';
			$data['status']='';
			$data['quick_product']=array();
			$data['product_attribute']=array();
			$data['product_trade_id']='';
						
			if($milestone_id!='')
			{
				$data['milestone_id']=$milestone_id;
				//$products_result=$this->product_model->getProduct($product_id);
				$orders_result=$this->order_transaction_model->getProductPerMilestone($milestone_id);				
													
				foreach($orders_result as $order){
					$data['order_id']=$order['order_id'];
					$data['milestone_id']=$order['milestone_id'];
					$data['description']=$order['description'];
					$data['transaction_id']=$order['transaction_id'];
					$data['amount']=$order['amount'];
					$data['payer_code']=$order['payer_code'];
					$data['payee_code']=$order['payee_code'];					
					$data['order_stat']=$order['status'];					
					
					$data['status'] = $this->order_transaction_model->getProductStatus($order['status']);

					$data['order_statuses'] = $this->order_transaction_model->getOrderStatus();

					
				if($order['released_by'] != 0){
					if($order['status'] == 2){
						
						$data['releasedByName'] = $this->order_transaction_model->getReleasedByName($order['released_by']);
					
					}					
				
					}
				}
			}
			
			
			/* Kinnari */
			$this->load->model('customer_model');
			$cust_detail=$this->customer_model->get_customer($customer_id); 
			$data['cust_detail']=$cust_detail;
			/* Kinnari */
			$this->load->view('header',$data);
			$this->load->view('order_transaction_milestone_form',$data);
			$this->load->view('footer',$data);
		}
	}	
		
}
?>
<?php
ob_start();
class Order extends CI_Controller{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->helper('url');	
		if(!isset($_GET['id']))
		{
			if(!$this->session->userdata('customer_id'))
			{
				redirect('home');
			}
		}/*else if(!$this->session->userdata('customer_id'))
		{
			redirect('home?id='.urlencode($_GET['id']).'&redirect='.$this->uri->segment(1).'/'.$this->uri->segment(2));
		}*/
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->model('order_model');
		$this->load->library('encrypt');
		$this->load->model('currencies_model');
		//$this->currency();
		
	}
	public function product_dispatcher_status()
	{
		print_r($this->input->post());
		if($this->input->post())
		{
			foreach($this->input->post('dispatcher_status') as $ds){
				if($this->input->post('transfer'))
				{
					$this->db->query("insert into dispatch set dispatch_status=5 ,dispatch_from=".$this->session->userdata('customer_id').", dispatch_to=".$this->input->post('dispatch').", order_product_id=".$ds.",date_time='".date("Y-m-d H:i:s")."', ip_address='".$this->input->ip_address()."'");
				}else{
					$this->db->query("insert into dispatch set dispatch_status=1 , dispatch_from=".$this->session->userdata('customer_id').", dispatch_to=".$this->input->post('dispatch').", order_product_id=".$ds." ,date_time='".date("Y-m-d H:i:s")."' , ip_address='".$this->input->ip_address()."'");
				}
				$this->db->query("update order_product set dispatcher_status=1,dispatcher_id='".$this->input->post('dispatch')."',dispatcher_date='".date('Y-m-d H:i:s')."' where order_product_id=".$ds);
			}
		}
	}
	
	public function milestone_dispatcher_status()
	{
		print_r($this->input->post());
		if($this->input->post())
		{
			foreach($this->input->post('dispatcher_status') as $ds){
				if($this->input->post('transfer'))
				{
					$this->db->query("insert into dispatch set dispatch_status=5 , dispatch_from=".$this->session->userdata('customer_id').", dispatch_to=".$this->input->post('dispatch').", milestone_id=".$ds.",date_time='".date("Y-m-d H:i:s")."', ip_address='".$this->input->ip_address()."'");
				}else{
					$this->db->query("insert into dispatch set dispatch_status=1 , dispatch_from=".$this->session->userdata('customer_id').", dispatch_to=".$this->input->post('dispatch').", milestone_id=".$ds." ,date_time='".date("Y-m-d H:i:s")."' , ip_address='".$this->input->ip_address()."'");
				}
				$this->db->query("update order_milestone set dispatcher_status=1,dispatcher_id='".$this->input->post('dispatch')."', dispatcher_date='".date('Y-m-d H:i:s')."' where milestone_id=".$ds);
			}
		}
	}
	
	
	
	function currency()
	{
		$data = array();
		$this->load->model('currencies_model');
		if($this->session->userdata('currency_id')){
			$currency_id = $this->session->userdata('currency_id');		
		} else { 
			$currency_id = '4';				
		}
		$currencies= $this->currencies_model->getCurrencies();
	
		foreach($currencies as $currency)
		{
					
				$this->currency['currencies'][] = array(
				'currency_id' => $currency['currency_id'],
				'currency_symbol'          => $currency['symbol'],
				'code'          => $currency['code'],	
				'status'          => $currency['status']										
				);
		}		
		
		$this->session->set_userdata($this->currency);
		$currency_detail = $this->currencies_model->getCurrencyInfo($currency_id);		
		$data['currency_symbol'] = $currency_detail->symbol;				
		$data['currency_title'] = $currency_detail->title;		
		$value = $currency_detail->value;			
		$data['value'] = $value;
		
		return $data ; 
	}
	public function index(){
		$customer_id=$this->session->userdata('customer_id');
		
		if($this->input->server('REQUEST_METHOD')=='POST')
		{
			$this->load->model('balance_manager_model');
			$customer_balance=$this->balance_manager_model->getCurrentBalance($customer_id);
			if($customer_balance[0]['amount']>=($this->input->post('quantity')*$this->input->post('unitPrice')))
			{
				$payee=$this->order_model->getCustomerByKey($this->input->post('payee_key'));
				$this->order_model->insertOrder($customer_id,$payee[0]['customer_id'],$this->input->post());
				redirect('order/order_list');
			}
			else
			{
				redirect('balance_manager');
			}
		}
		$data='';
		foreach($this->currency() as $key => $cr)
		$data[$key]  = $cr;
		
		/* Kinnari */
		$this->load->model('customer_model');
		$cust_detail=$this->customer_model->get_customer($customer_id); 
		$data['cust_detail']=$cust_detail;
		/* Kinnari */
		$this->load->view('header',$data);
		$this->load->view('order_place',$data);
		$this->load->view('footer',$data);
	}
	public function receive_details($order_id)
	{
		$data='';
		$customer_id=$this->session->userdata('customer_id');
		$data['orders']=$this->order_model->getOrder('',$order_id,'',$customer_id);
		$transaction=$this->order_model->expireOrder($order_id);
		if(isset($transaction[0]))
		$data['transaction']=$transaction;
		else
		$data['transaction']='';
		foreach($this->currency() as $key => $cr)
		$data[$key]  = $cr;
		$data['back']="order/recived_order_list";
		$data['title']="Order Received Details";
		$this->load->view('header',$data);
		$this->load->view('order_details',$data);
		$this->load->view('footer',$data);
	}
	public function placed_details($order_id)
	{
		$data='';
		$customer_id=$this->session->userdata('customer_id');
		$group="groupby";
		$data['orders']=$this->order_model->getOrder($customer_id,$order_id,'','','',$group);
		
		
		$transaction=$this->order_model->expireOrder($order_id);
		if(isset($transaction))
		$data['transaction']=$transaction;
		else
		$data['transaction']='';
		foreach($this->currency() as $key => $cr)
		$data[$key]  = $cr;
		$data['back']="order/order_list";
		$data['title']="Order Placed Details";
		
		
		/* Kinnari */
		$this->load->model('customer_model');
		$cust_detail=$this->customer_model->get_customer($customer_id); 
		$data['cust_detail']=$cust_detail;
		/* Kinnari */
		$this->load->view('header',$data);
		$this->load->view('order_details',$data);
		$this->load->view('footer',$data);
	}
	public function order_list()
	{	
		//$this->sms->send('library function check','+918905007481');
		
		$data='';
		$customer_id=$this->session->userdata('customer_id');
		$t=$this->order_model->getOrder($customer_id);
		$a=array();
		$i=0;
		$merchant=array();	
		$company=array();	
		foreach($t as $order)	
		{
			if($i!=0 && $merchant[($i-1)]['id']!=$order['payer_id'] )
			{
				$merchant[$i]['name']=$order['payee_name'].'@'.$order['company_website'];
				$merchant[$i]['id'] = $order['payee_id'];
				$merchant[$i]['company_id'] = $order['company_id'];
				$company[$i]['company_id'] = $order['company_id'];
				$company[$i]['company_name'] = $order['company_name'];
				$i++;
			}
			else
			{
				$merchant[$i]['name']=$order['payee_name'].'@'.$order['company_website'];
				$merchant[$i]['id'] = $order['payee_id'];
				$merchant[$i]['company_id'] = $order['company_id'];
				$company[$i]['company_id'] = $order['company_id'];
				$company[$i]['company_name'] = $order['company_name'];
				$a['order_id']=$order['order_id'];
				$a['company_id']=$order['company_id'];
				$a['company_name']=$order['company_name'];
				$i++;
			}
		}
		
		//$data['orders']=$this->order_model->getOrder($customer_id);		
		$cmp=$this->input->get('c_id') ? $this->input->get('c_id'): '';
		$m_id=$this->input->get('m_id') ? $this->input->get('m_id'):'';
		$o_id=$this->input->get('o_id') ? $this->input->get('o_id'):'';
		$product_name=$this->input->get('product_name') ? $this->input->get('product_name'):'';
		$milestone=$this->input->get('milestone') ? $this->input->get('milestone'):'0';
		$text=$this->input->get('text') ? $this->input->get('text'):'';
		$limit=$this->input->get('limit') ? $this->input->get('limit'):'0';
		$data['orders']=$this->order_model->getOrderFilter($customer_id,$cmp,$m_id,$o_id,$milestone,$product_name,$text,$limit,true);
		
		
		
		$unique = array_map("unserialize", array_unique(array_map("serialize", $merchant)));
		$company = array_map("unserialize", array_unique(array_map("serialize", $company)));
		$data['marchant_list']=$unique;	
		$data['company_list']=$company;	
		
		foreach($this->currency() as $key => $cr)
		$data[$key]  = $cr;		
		
		/* Kinnari */
		$this->load->model('customer_model');
		$cust_detail=$this->customer_model->get_customer($customer_id); 
		$data['cust_detail']=$cust_detail;
		/* Kinnari */
		$data['milestone']=$milestone;
		if($m_id=='')
		$this->load->view('header',$data);
		$this->load->view('order_list',$data);
		if($m_id=='')
		$this->load->view('footer',$data);
	}
	public function recived_order_list()
	{
		
		$data='';
		$customer_id=$this->session->userdata('customer_id');
		$t=$this->order_model->getOrder('','','',$customer_id);
		$a=array();
		$merchant=array();	
		$company=array();	
		$i=0;
		
		foreach($t as $order)	
		{
			if($i!=0 && $merchant[($i-1)]['id']!=$order['payer_id'] )
			{
				$merchant[$i]['name']=$order['payer_name'].'@'.$order['company_website'];
				$merchant[$i]['id'] = $order['payer_id'];
				$merchant[$i]['company_id'] = $order['company_id'];
				$company[$i]['company_id'] = $order['company_id'];
				$company[$i]['company_name'] = $order['company_name'];
				$i++;
			}
			else
			{
				$merchant[$i]['name']=$order['payer_name'].'@'.$order['company_website'];
				$merchant[$i]['id'] = $order['payer_id'];
				$merchant[$i]['company_id'] = $order['company_id'];
				$company[$i]['company_id'] = $order['company_id'];
				$company[$i]['company_name'] = $order['company_name'];
				$a['order_id']=$order['order_id'];
				$a['company_id']=$order['company_id'];
				$a['company_name']=$order['company_name'];
				$i++;
			}
			
		}
				
		//$data['orders']=$this->order_model->getOrder($customer_id);	

		$cmp=$this->input->get('c_id') ? $this->input->get('c_id'): '';
		$m_id=$this->input->get('m_id') ? $this->input->get('m_id'):'';
		$o_id=$this->input->get('o_id') ? $this->input->get('o_id'):'';
		$product_name=$this->input->get('product_name') ? $this->input->get('product_name'):'';
		$milestone=$this->input->get('milestone') ? $this->input->get('milestone'):'0';
		$text=$this->input->get('text') ? $this->input->get('text'):'';
		$limit=$this->input->get('limit') ? $this->input->get('limit'):'0';
		$data['orders']=$this->order_model->getReciveOrder($customer_id,$m_id,$cmp,$o_id,$milestone,$product_name,$text,$limit,true);
		
		
		//$unique = array_map("unserialize", array_unique(array_map("serialize", $merchant)));
		//$company = array_map("unserialize", array_unique(array_map("serialize", $company)));
		//$data['marchant_list']=$unique;	
		//$data['company_list']=$company;	

		
		$pendingamount=$this->order_model->getPendingAmount($customer_id);
		$data['pending_amount']=$pendingamount[0]['pnamount'];
		if($pendingamount[0]['pnamount']=='')
		$data['pending_amount']='0';
		foreach($this->currency() as $key => $cr)
		$data[$key]  = $cr;
		
		/* Kinnari */
		$this->load->model('customer_model');
		$cust_detail=$this->customer_model->get_customer($customer_id); 
		$data['cust_detail']=$cust_detail;
		/* Kinnari */
		$data['milestone']=$milestone;
		if($m_id=='')
		$this->load->view('header',$data);
		$this->load->view('recived_order_list',$data);
		if($m_id=='')
		$this->load->view('footer',$data);
	}
	public function release_payment($order_id)
	{
		$customer_id=$this->session->userdata('customer_id');
		$transaction_id=$this->order_model->release_payment($customer_id,$order_id);
		return $transaction_id;
		//redirect('balance_manager');
	}
	public function release_product_payment($order_product_id)
	{
		$customer_id=$this->session->userdata('customer_id');
		$transaction_id=$this->order_model->release_product_payment($customer_id,$order_product_id);
		return $transaction_id;
		//redirect('balance_manager');
	}
	public function milestone_payment(){
		
		if($this->session->userdata('customer_id'))
		{
			//redirect('home?id='.urlencode($_GET['id']));
		
		$this->load->model('balance_manager_model');
		$customer_id=$this->session->userdata('customer_id');
		$data['suffi_balance']=1;
		}
		if($this->input->server('REQUEST_METHOD')=='POST')
		{
			
			$this->form_validation->set_rules('first_milestone', 'first_milestone', 'required');
			if ($this->form_validation->run() !== FALSE)
			{
				$orders= json_decode(urldecode($this->encrypt->decode($this->input->post('key'))),true);
				$order=$this->order_model->getTransactionOrder($orders['txn_id']);
				//print_r($order);
				//echo $order[0]['total_amount'];
				//die();
				$order=$order[0];
				$currency_detail = $this->currencies_model->getCurrencyInfo($this->session->userdata('currency_id'));		
				$balance=$this->balance_manager_model->getCurrentBalance($customer_id);
				//first_milestone is actually not first milestone name in view is first_milestone we need to change it later				
				
				if($this->input->post('first_milestone')>$order['total_amount'])
				{
					echo "You cant create milstone more than order price<br>";
				}
				else if($this->input->post('first_milestone')!='' && $this->input->post('first_milestone')<=($balance[0]['amount']*$currency_detail->value))
				{
					$milestone=$this->input->post('first_milestone');
					$customer_id=$this->session->userdata('customer_id');
					$txn_id=$this->order_model->insertMilestone($customer_id,$milestone,$order['order_id'],'',$orders['description'],$orders['milestone_id']);
					
					$this->session->set_userdata('secure_pass',random_string('alnum', 5));				
					$message='Your TP transaction secure code is: '.$this->session->userdata('secure_pass');
					$uc = $this->db->query("select * from customer where customer_id=".$customer_id)->row();
					if($uc->verify)
					{
						$this->sms->send($message,urlencode("+".$uc->phonecode.$uc->customer_phone));		
					}
					$this->order_model->sendMail($customer_id,'TP Transaction secure code',$message);
				
					redirect($orders['sucess_redirect_url']."?txn=".$txn_id);
				}
				else
				{
					echo 'Insufficient Balance<a  href="'.base_url().'index.php/order/deposit_amount?id='.urlencode($this->input->post('key')).'">Deposit amount</a>!<br><br>';
				}
			}
		}
		$orders= json_decode(urldecode($this->encrypt->decode($_GET['id'])),true);		
		foreach ($this->session->userdata['currencies'] as $currency){ 
			if($currency['code'] == $orders['currency_code'])
			{
				$this->session->set_userdata('currency_id',$currency['currency_id']);			
			}
			
		}
		$order=$this->order_model->getTransactionOrder($orders['txn_id']);
		
		if($this->session->userdata('customer_id'))
		{
			$balance=$this->balance_manager_model->getCurrentBalance($customer_id);
		}
		
		
		$data['milestone']=$orders['milestone'];
		$company=$this->order_model->getCustomerByKey($orders['company_key']);
		$data['company_logo']=$company[0]['photo'];
		$data['company_name']=$company[0]['company_name'];
		$data['company_website']=$company[0]['company_website'];
		$this->load->model('customer_model');
		$payee=$this->customer_model->get_customer($order[0]['payee_id']);
		$data["supplier_name"]=$payee[0]['first_name']." ".$payee[0]['last_name'];
		$data['name']=$order[0]['shipping_firstname'];
		$data['total_amount']=$order[0]['total_amount'];
		$data['product_desc']=$order[0]['product_name'];
		$data['quantity']=$order[0]['product_quantity'];
		$data['cancel']=urlencode($orders['cancel_redirect_url']);
		foreach($this->currency() as $key => $cr)
		$data[$key]  = $cr;
		$this->load->view('payment_new',$data);
	}
	public function payment(){
		/*if(!$this->session->userdata('customer_id'))
		{
			redirect('home?id='.urlencode($_GET['id']));
		}*/
		$this->load->model('currencies_model');
		if($this->session->userdata('customer_id'))
		{
			$this->load->model('balance_manager_model');
			$customer_id=$this->session->userdata('customer_id');
			$data['suffi_balance']=0;
		}
		if($this->input->server('REQUEST_METHOD')=='POST')
		{
			$milestone='';
			if($this->input->post('first_milestone')!==FALSE)
			{
				$this->form_validation->set_rules('first_milestone', 'first_milestone', 'required');
				if ($this->form_validation->run() !== FALSE)
				{
					$order= json_decode(urldecode($this->encrypt->decode($this->input->post('key'))),true);
					$currency_detail = $this->currencies_model->getCurrencyInfo($this->session->userdata('currency_id'));		
					$balance=$this->balance_manager_model->getCurrentBalance($customer_id);
					if($this->input->post('first_milestone')>$order['total_amount'])
					{
						echo "You cant create milstone more than order price<br>";
					}
					else if($this->input->post('first_milestone')!='' && $this->input->post('first_milestone')<=($balance[0]['amount']*$currency_detail->value))
					{
						$milestone=$this->input->post('first_milestone');
						$this->get_api($this->input->post('key'),$milestone);
					}
					else
					{
						echo 'Insufficient Balance<a  href="'.base_url().'index.php/order/deposit_amount">Deposit amount</a>!<br><br>';
					}
				}
			}
			else
			{
				$this->get_api($this->input->post('key'),$milestone);
			}
		}
		$order= json_decode(urldecode($this->encrypt->decode($_GET['id'])),true);
		foreach ($this->session->userdata['currencies'] as $currency){ 
			if($currency['code'] == $order['currency_code'])
			{
				$this->session->set_userdata('currency_id',$currency['currency_id']);			
			}
			
		}
		if($this->session->userdata('customer_id'))
		{
			$balance=$this->balance_manager_model->getCurrentBalance($customer_id);
		}
		if(!(isset($order['milestone'])))
		{
			if((isset($balance[0]) && $balance[0]['amount']>=$order['total_amount']))
			{
				$data['suffi_balance']=1;
			}
			else
			$data['suffi_balance']=0;
		}
		else{
			$data['milestone']=1;
		}
		$data['name']=$order['name'];
		$company=$this->order_model->getCustomerByKey($order['company_key']);
		$payee=$this->order_model->getCustomerByKey($order['payee_key']);
		$data["supplier_name"]=$payee[0]['first_name']." ".$payee[0]['last_name'];
		$data['company_logo']=$company[0]['photo'];
		$data['company_name']=$company[0]['company_name'];
		$data['company_website']=$company[0]['company_website'];
		if(isset($order['milestone']))
		$data['milestone']=$order['milestone'];
		$data['total_amount']=$order['total_amount'];
		$data['shipping_address']=$order['shipping_address'];
		$data['shipping_city']=$order['shipping_city'];
		$data['product_desc']=$order['product_desc'];
		$data['quantity']=$order['quantity'];
		$data['cancel']=urlencode($order['cancel_redirect_url']);
		foreach($this->currency() as $key => $cr)
		$data[$key]  = $cr;
		$this->load->view('payment',$data);
	}
	public function order_payment(){	
		$this->currency();
		
		$data['cust_login']=0;
		if($this->session->userdata('customer_id'))
		{
			$this->load->model('balance_manager_model');
			$customer_id=$this->session->userdata('customer_id');
			$data['suffi_balance']=0;
			$_GET['c_l']=1;
		
		}
		if(isset($_GET['c_l']))
		{
			$data['cust_login']=$_GET['c_l'];
		}
		if($this->input->server('REQUEST_METHOD')=='POST')
		{			
				if($this->input->post('secure_code')==$this->session->userdata('secure_pass'))
				{
					$this->session->unset_userdata('secure_pass');
					$this->get_product_api($this->input->post('key'));
				}
				else
				{
					$this->session->set_flashdata('secure_error', 'Invalid code please try again!');
					$data['cust_login']=0;
					redirect($_SERVER['HTTP_REFERER']);
					
				}
		}
		$order= json_decode(urldecode($this->encrypt->decode($_GET['id'])),true);	
		
		if($this->session->userdata('customer_id'))
		{
		$balance=$this->balance_manager_model->getCurrentBalance($customer_id);
		
		}		
		foreach ($this->session->userdata['currencies'] as $currency){ 
			if($currency['code'] == $order['currency_code'])
			{
				$this->session->set_userdata('currency_id',$currency['currency_id']);			
			}
			
		}		
		
		$data['name']=$order['name'];
		$data['total_amount']=0;
		$data['shipping_address']=$order['shipping_address'];
		$data['shipping_city']=$order['shipping_city'];
		$company=$this->order_model->getCustomerByKey($order['company_key']);
		$data['company_logo']=$company[0]['photo'];
		$data['company_name']=$company[0]['company_name'];
		$data['company_website']=$company[0]['company_website'];
		$currency_detail = $this->currencies_model->getCurrencyInfo($this->session->userdata('currency_id'));		
		foreach($order['product'] as $product)
		{
			$payee=$this->order_model->getCustomerByKey($product['payee_key']);
			
			$data['product_desc']=$product['product_desc'];
			$data['quantity']=$product['quantity'];
			$data['product_amount']=$product['amount'];
			$data['total_amount']+=$product['total_amount'];
			$data['product'][]=array('description'=>$data['product_desc'],'quantity'=>$data['quantity'],'product_amount'=>$data['product_amount'],"supplier_name"=>$payee[0]['first_name']." ".$payee[0]['last_name'],'shipping_cost'=>$product['shipping_cost'],'taxes'=>$product['taxes'],'total_amount'=>$product['total_amount']);
		}
		
		if((isset($balance[0]) && $balance[0]['amount']>=($data['total_amount']*$currency_detail->value)))
		{
			$data['suffi_balance']=1;
			if(!$this->session->userdata('secure_pass'))
			{				
				$this->session->set_userdata('secure_pass',random_string('alnum', 5));
				$message='Your TP transaction secure code is: '.$this->session->userdata('secure_pass');
				$uc = $this->db->query("select * from customer where customer_id=".$customer_id)->row();
				if($uc->verify)
				{
					$this->sms->send($message,urlencode("+".$uc->phonecode.$uc->customer_phone));		
				}	
						
				$this->order_model->sendMail($customer_id,'TP Transaction secure code',$message);
			}
		}
		else
		$data['suffi_balance']=0;
		foreach($this->currency() as $key => $cr)
		$data[$key]  = $cr;
		$data['cancel']=urlencode($order['cancel_redirect_url']);
		$this->load->view('prod_payment_new',$data);
	}
	
	public function deposit_amount()
	{
		$order= json_decode(urldecode($this->encrypt->decode($_GET['id'])),true);
		$opts = array('http'=>array('header' => "User-Agent:MyAgent/1.0\r\n"));
		$context = stream_context_create($opts);
		$msg=urlencode('insuffecient balance');
		//file_get_contents('http://localhost/yehki.com/index.php/payment_response?status='.$msg.'&order_id=6',false,$context);
		//echo 'http://localhost/yehki.com/index.php/payment_response?status='.$msg.'&order_id=6';
		if(isset($order['order_id']))
		file_get_contents($order['sucess_redirect_url'].'?status='.$msg.'&order_id='.$order['order_id'],false,$context);
		else
		file_get_contents($order['sucess_redirect_url'].'?status='.$msg.'&milestone_id='.$order['milestone_id'],false,$context);
		redirect('balance_manager');
	}
	public function get_geolocation()
	{
		$url = 'http://ip-api.com/json/'.$_SERVER['REMOTE_ADDR'];		
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
	public function get_api($key,$milestone=''){
		
		//$data= urldecode($this->encrypt->decode($_GET['id']));
		
		$data= json_decode(urldecode($this->encrypt->decode($key)),true);
		$opt=$this->get_geolocation();
		$data=array_merge($data,$opt);
		/*print_r($data);
		die();*/
		//if($this->input->server('REQUEST_METHOD')=='POST')
		{
			$payer_id=$this->session->userdata('customer_id');
			$payee=$this->order_model->getCustomerByKey($data['payee_key']);
			$company=$this->order_model->getCustomerByKey($data['company_key']);
			$txn_id=$this->order_model->insertApiOrder($payer_id,$payee[0]['customer_id'],$data,$company[0]['customer_id'],$milestone);
			redirect($data['sucess_redirect_url']."?txn=".$txn_id);
		}
		//redirect('order/order_list');
		//echo "http://localhost/trustedpayer.com/index.php/balance_manager";
	}
	public function get_product_api($key){
		
		//$data= urldecode($this->encrypt->decode($_GET['id']));
		
		$data= json_decode(urldecode($this->encrypt->decode($key)),true);
		$opt=$this->get_geolocation();
		$data=array_merge($data,$opt);
		
		$payer_id=$this->session->userdata('customer_id');
		$company=$this->order_model->getCustomerByKey($data['company_key']);
		$txn_id=$this->order_model->insertProductApiOrder($payer_id,$data,$company[0]['customer_id']);
		$fields_string=http_build_query($txn_id);
		redirect($data['sucess_redirect_url']."?txn=1&".$fields_string);
		
		
	}
	public function milestone_release()
	{
		$data['cust_login']=0;
		if(isset($_GET['c_l']))
		{
			$data['cust_login']=$_GET['c_l'];
		}		
		if($this->input->server('REQUEST_METHOD')=='POST')
		{
			$milestone= json_decode(urldecode($this->encrypt->decode($this->input->post('key'))),true);
			
			$order=$this->order_model->getTransactionMilestone($milestone['milestone_transaction']);
			//print_R($order);exit;
			$customer_id=$this->session->userdata('customer_id');
			$valid=$this->order_model->validateMilestoneKey($customer_id,$order[0]['milestone_id'],$this->input->post());
			if(isset($valid[0]))
			{
				//echo $customer_id.'  - '.$order[0]['order_id'].'  - '.$order[0]['milestone_id']." - ".$order[0]['payer_id'];		
				
				//bug new added $order[0]['payee_id'] id;
				
				if($customer_id==$order[0]['payer_id'])
				{
					$this->order_model->insertOrderKey($customer_id,$this->input->post('order_id'),$order[0]['milestone_id'],$this->input->post(),$order[0]['payee_id']);
				}
				else
				{
					$this->order_model->insertOrderKey('',$this->input->post('order_id'),$order[0]['milestone_id'],$this->input->post(),$customer_id);
				}
				//$this->order_model->insertOrderKey($cust`omer_id,$order[0]['order_id'],$order[0]['milestone_id'],$this->input->post());
				//$this->order_model->release_payment($customer_id,$order[0]['order_id'],$order[0]['milestone_id']);
				$this->order_model->completeMilestoneOrder($order[0]['milestone_id']);
				redirect($milestone['sucess_redirect_url']."?txn=".$milestone['milestone_transaction']);
			}
			else
			{
				$data['error_message']='<div style="color:red">Invalid Keys</div>'; 
				$data['key']=$this->input->post('key');
			}
		}
		else
		{
		$milestone= json_decode(urldecode($this->encrypt->decode($_GET['id'])),true);
		
		$order=$this->order_model->getTransactionMilestone($milestone['txn_id']);
	//	print_R($order);exit;
		$data['key']=$_GET['id'];
		}
		//print_r($order);
		//redirect('order/release_milestone/'.$order[0]['order_id'].'/'.$order[0]['milestone_id']);
		$customer_id=$this->session->userdata('customer_id');
		$milestone_id=$order[0]['milestone_id'];
		$order_id=$order[0]['order_id'];
		$this->load->model('order_model');
		$milest=$this->order_model->getMilestone('',$milestone_id);
		$data['order_id']=$order_id;
		$orders=$this->order_model->getOrder('',$order_id);
		$this->load->model('customer_model');
		foreach($this->currency() as $key => $cr)
		$data[$key]  = $cr;
		if($customer_id==$orders[0]['payer_id'])
		{
			$payee=$this->customer_model->get_customer($orders[0]['payee_id']);
			$data['product_name']=$orders[0]['product_name'];
			$data['payee_name']=$payee[0]['first_name']." ".$payee[0]['last_name'];
			$company=$this->customer_model->get_customer($orders[0]['company_id']);
			$data['company_logo']=$company[0]['photo'];
			$data['company_name']=$company[0]['company_name'];
		$data['company_website']=$company[0]['company_website'];
			//$this->load->view('header',$data);
			$this->load->view('complete_order',$data);
		}
		else if($customer_id==$orders[0]['payee_id'])
		{
			$payer=$this->customer_model->get_customer($orders[0]['payer_id']);
			$data['product_name']=$orders[0]['product_name'];
			$data['payer_name']=$payer[0]['first_name']." ".$payer[0]['last_name'];
			$company=$this->customer_model->get_customer($orders[0]['company_id']);
			$data['company_logo']=$company[0]['photo'];
			$data['company_name']=$company[0]['company_name'];
		$data['company_website']=$company[0]['company_website'];
			//$this->load->view('header',$data);
			$this->load->view('payee_complete_order',$data);
		}
		else
		{
			if($this->session->userdata('customer_id'))
			{
				
				echo "You login with wrong account!";
			}
			else{
			$payee=$this->customer_model->get_customer($orders[0]['payee_id']);
			$data['product_name']=$orders[0]['product_name'];
			$data['payee_name']=$payee[0]['first_name']." ".$payee[0]['last_name'];
			$company=$this->customer_model->get_customer($orders[0]['company_id']);
			$data['company_logo']=$company[0]['photo'];
			$data['company_name']=$company[0]['company_name'];
		$data['company_website']=$company[0]['company_website'];
			$this->load->view('complete_order',$data);
			}
		}
		//$this->load->view('footer',$data);
	}
	public function release_milestone($order_id,$milestone)
	{
		
		if($this->input->server('REQUEST_METHOD')=='POST')
		{
			$customer_id=$this->session->userdata('customer_id');
			$valid=$this->order_model->validateOrderKey($customer_id,$order_id,$this->input->post());
			if(isset($valid[0]))
			{
				//$this->order_model->insertOrderKey($customer_id,$order_id,$this->input->post());
				$this->order_model->release_payment($customer_id,$order_id,$milestone);
			}
			else
			{
				echo  '<div style="color:red">Invalid Keys</div>';
			}
		}
		$data='';
		$this->load->model('order_model');
		$milest=$this->order_model->getMilestone('',$milestone);
		$data['order_id']=$order_id;
		$orders=$this->order_model->getOrder('',$order_id);
		$this->load->model('customer_model');
		$payee=$this->customer_model->get_customer($orders[0]['payee_id']);
		$data['product_name']=$orders[0]['product_name'];
		$data['payee_name']=$payee[0]['first_name']." ".$payee[0]['last_name'];
		foreach($this->currency() as $key => $cr)
		$data[$key]  = $cr;
		
		/* Kinnari */
		$this->load->model('customer_model');
		$cust_detail=$this->customer_model->get_customer($customer_id); 
		$data['cust_detail']=$cust_detail;
		/* Kinnari */
		$this->load->view('header',$data);
		$this->load->view('complete_order',$data);
		$this->load->view('footer',$data);
	}
	
	public function complete_order()
	{
		if($this->input->server('REQUEST_METHOD')=='POST')
		{
			$customer_id=$this->session->userdata('customer_id');
			$this->load->model('customer_model');
			$customer_detail=$this->customer_model->get_customer($customer_id);
			$customer_key=$customer_detail[0]['customer_unique_id'];
			$orders=$this->order_model->getOrder('',$this->input->post('order_id'));
			$payee=$this->customer_model->get_customer($orders[0]['payee_id']);
			$payer=$this->customer_model->get_customer($orders[0]['payer_id']);
			if($customer_id==$orders[0]['payer_id'])
			{
				$valid=$this->order_model->validateOrderKey($customer_id,$this->input->post('order_id'),$this->input->post());
			}
			else
			{
				$valid=$this->order_model->validateOrderKey('',$this->input->post('order_id'),$this->input->post(),$customer_id);
			}
			if(isset($valid[0]))
			{
				$this->order_model->insertOrderKey($customer_id,$this->input->post('order_id'),$this->input->post());
				$transaction_id =$this->release_payment($this->input->post('order_id'));
				redirect($this->input->post('sucess')."?txn=".$this->input->post('txn_id'));
			}
			else
			{
				echo  '<div style="color:red">Invalid Keys</div>';
			}
		}
		
		$data='';
		if(isset($_GET['id']))
		{
			$orders= json_decode(urldecode($this->encrypt->decode($_GET['id'])),true);
			$order=$this->order_model->getTransactionOrder($orders['txn_id']);		
			$order_id=$order[0]['order_id'];
			$data['order_id']=$order_id;
			$data['txn_id']=$orders['txn_id'];
			$data['cancle']=$orders['cancel_redirect_url'];
			$data['sucess']=$orders['sucess_redirect_url'];
		}
		else if($this->input->post('order_id'))
		{ 
			$order_id=$this->input->post('order_id');
			$data['txn_id']=$this->input->post('txn_id');
			$data['cancle']=$this->input->post('cancle');
			$data['sucess']=$this->input->post('sucess');
			$data['order_id']=$order_id;
		}
		
		
		$orders=$this->order_model->getOrder('',$order_id);
		$this->load->model('customer_model');
		$payee=$this->customer_model->get_customer($orders[0]['payee_id']);
		$payer=$this->customer_model->get_customer($orders[0]['payer_id']);
		foreach($this->currency() as $key => $cr)
		$data[$key]  = $cr;
		$company=$this->order_model->getCustomerByKey($orders['company_key']);
		$data['company_logo']=$company[0]['photo'];
		$data['company_name']=$company[0]['company_name'];
		$data['company_website']=$company[0]['company_website'];
		$customer_id=$this->session->userdata('customer_id');
		$customer_detail=$this->customer_model->get_customer($customer_id);
		$customer_key=$customer_detail[0]['customer_unique_id'];
		/* Kinnari */
		$this->load->model('customer_model');
		$cust_detail=$this->customer_model->get_customer($customer_id); 
		$data['cust_detail']=$cust_detail;
		/* Kinnari */
		if($customer_id==$orders[0]['payer_id'])
		{
			$data['product_name']=$orders[0]['product_name'];
			$data['payee_name']=$payee[0]['first_name']." ".$payee[0]['last_name'];
			
			$this->load->view('header',$data);
			$this->load->view('complete_order',$data);
			$this->load->view('footer',$data);
		}
		else{
			$data['product_name']=$orders[0]['product_name'];
			$data['payer_name']=$payer[0]['first_name']." ".$payer[0]['last_name'];
			$this->load->view('header',$data);
			$this->load->view('payee_complete_order',$data);
			$this->load->view('footer',$data);
		}
	}
	public function complete_product_order()
	{
		$data='';
		foreach($this->currency() as $key => $cr)
		$data[$key]  = $cr;
		$data['cust_login']=0;
		/*if(!$this->session->userdata('customer_id'))
		{
			redirect('home?id='.urlencode($_GET['id']).'&redirect='.$this->uri->segment(1).'/'.$this->uri->segment(2));
		}*/
		if(isset($_GET['c_l']))
		{
			$data['cust_login']=$_GET['c_l'];
		}
		elseif($this->input->post('cust_login'))
		{
			$data['cust_login']=$this->input->post('cust_login');
		}
		if($this->session->userdata('customer_id'))
		{
			$data['cust_login']=1;
		}
		if($this->input->server('REQUEST_METHOD')=='POST')
		{
			
			$customer_id=$this->session->userdata('customer_id');
			$this->load->model('customer_model');
			$customer_detail=$this->customer_model->get_customer($customer_id);
			$customer_key=$customer_detail[0]['customer_unique_id'];
			$orders=$this->order_model->getOrder('',$this->input->post('order_id'));
			$payee=$this->customer_model->get_customer($orders[0]['payee_id']);
			$payer=$this->customer_model->get_customer($orders[0]['payer_id']);
			if($customer_id==$orders[0]['payer_id'])
			{
				$valid=$this->order_model->validateOrderProductKey($customer_id,$this->input->post('order_product_id'),$this->input->post());
			}
			else if($customer_id==$orders[0]['payee_id'])
			{
				$valid=$this->order_model->validateOrderProductKey('',$this->input->post('order_product_id'),$this->input->post(),$customer_id);
			}
			else{
				$data['cust_login']=0;
				$invalid_cust=1;
			}
			if(isset($valid[0]))
			{
				if($customer_id==$orders[0]['payer_id'])
				{
					$this->order_model->insertProductOrderKey($customer_id,$this->input->post('order_id'),$this->input->post('order_product_id'),$this->input->post());
				}
				else
				{
					$this->order_model->insertProductOrderKey('',$this->input->post('order_id'),$this->input->post('order_product_id'),$this->input->post(),$customer_id);
				}
				$this->order_model->completeProductOrder($this->input->post('order_product_id'));
				//$transaction_id =$this->release_product_payment($this->input->post('order_product_id'));
				redirect($this->input->post('sucess')."?txn=1&txn_id[0]=".$this->input->post('txn_id')."&product_key[0]=".$this->input->post('product_key'));
			}
			else
			{
				if(isset($invalid_cust))
				$data['error_message']='<div style="color:red">Invalid User Login</div>'; 
				else
				$data['error_message']='<div style="color:red">Invalid Keys</div>'; 
			}
		}
		
		
		if(isset($_GET['id']))
		{
			$orders= json_decode(urldecode($this->encrypt->decode($_GET['id'])),true);
			$order=$this->order_model->getTransactionOrderProduct($orders['txn_id']);
			if($order[0]['order_product_status_id']==7 || $order[0]['order_product_status_id']==8)		
			{
				redirect($orders['sucess_redirect_url']."?txn=1&txn_id[0]=".$orders['txn_id']."&product_key[0]=".$order[0]['product_key']);
			}
			$order_id=$order[0]['order_id'];
			$data['order_id']=$order_id;
			$order_product_id=$data['order_product_id']=$order[0]['order_product_id'];
			$data['product_key']=$order[0]['product_key'];
			$data['txn_id']=$orders['txn_id'];
			$data['cancle']=$orders['cancel_redirect_url'];
			$data['sucess']=$orders['sucess_redirect_url'];
			$data['company_key']=$orders['company_key'];
			$company=$this->order_model->getCustomerByKey($orders['company_key']);
			$data['company_logo']=$company[0]['photo'];
			$data['company_name']=$company[0]['company_name'];
		$data['company_website']=$company[0]['company_website'];
		}
		else if($this->input->post('order_id'))
		{ 
			$order_id=$this->input->post('order_id');
			$data['order_product_id']=$this->input->post('order_product_id');
			$data['product_key']=$this->input->post('product_key');
			$data['txn_id']=$this->input->post('txn_id');
			$data['cancle']=$this->input->post('cancle');
			$data['sucess']=$this->input->post('sucess');
			$data['company_logo']=$this->input->post('company_logo');
			$data['order_id']=$order_id;
			$data['company_key']=$this->input->post('company_key');
			$company=$this->order_model->getCustomerByKey($this->input->post('company_key'));
			$data['company_logo']=$company[0]['photo'];
			$data['company_name']=$company[0]['company_name'];
			$data['company_website']=$company[0]['company_website'];
		}
		else{
			echo "Error 404: Page not Found ";
			die();
		}
		
		
		$orders=$this->order_model->getOrder('',$order_id,'','',$order_product_id);
		$this->load->model('customer_model');
		//echo $orders[0]['payer_id'];
		$payee=$this->customer_model->get_customer($orders[0]['payee_id']);
		$payer=$this->customer_model->get_customer($orders[0]['payer_id']);
		if($this->session->userdata('customer_id'))
		{
			$customer_id=$this->session->userdata('customer_id');
			$customer_detail=$this->customer_model->get_customer($customer_id);
			$customer_key=$customer_detail[0]['customer_unique_id'];
			
			if($customer_id==$orders[0]['payer_id'])
			{
				$data['product_name']=$orders[0]['product_name'];
				$data['payee_name']=$payee[0]['first_name']." ".$payee[0]['last_name'];
				
				//$this->load->view('header',$data);
				$this->load->view('complete_order',$data);
				//$this->load->view('footer',$data);
			}
			else if($customer_id==$orders[0]['payee_id']){
				$data['product_name']=$orders[0]['product_name'];
				$data['payer_name']=$payer[0]['first_name']." ".$payer[0]['last_name'];
				//$this->load->view('header',$data);
				$this->load->view('payee_complete_order',$data);
				//$this->load->view('footer',$data);
			}
			else{
				$invalid_cust=1;
				$data['cust_login']=0;
				$data['error_message']='<div style="color:red">Invalid User Login</div>'; 
				
				$data['product_name']=$orders[0]['product_name'];
				$data['payee_name']=$payee[0]['first_name']." ".$payee[0]['last_name'];
				
				//$this->load->view('header',$data);
				$this->load->view('complete_order',$data);
			}
		}
		else{
			$data['product_name']=$orders[0]['product_name'];
				$data['payee_name']=$payee[0]['first_name']." ".$payee[0]['last_name'];
				
				//$this->load->view('header',$data);
				$this->load->view('complete_order',$data);
		}
	}
/*	public function complete_order($order_id)
	{
		if($this->input->server('REQUEST_METHOD')=='POST')
		{
			$customer_id=$this->session->userdata('customer_id');
			$valid=$this->order_model->validateOrderKey($customer_id,$order_id,$this->input->post());
			if(isset($valid[0]))
			{
				$this->order_model->insertOrderKey($customer_id,$order_id,$this->input->post());
				$this->release_payment($order_id);
			}
			else
			{
				echo  '<div style="color:red">Invalid Keys</div>';
			}
		}
		$data='';
		$data['order_id']=$order_id;
		$orders=$this->order_model->getOrder('',$order_id);
		$this->load->model('customer_model');
		$payee=$this->customer_model->get_customer($orders[0]['payee_id']);
		$data['product_name']=$orders[0]['product_name'];
		$data['payee_name']=$payee[0]['first_name']." ".$payee[0]['last_name'];
		$this->load->view('header',$data);
		$this->load->view('complete_order',$data);
		$this->load->view('footer',$data);
	}*/
	public function payee_complete_order($order_id)
	{
		
		$data='';
		
		$data['cust_login']=0;
		if(isset($_GET['c_l']))
		{
			$data['cust_login']=$_GET['c_l'];
		}
		elseif($this->input->post('cust_login'))
		{
			$data['cust_login']=$this->input->post('cust_login');
		}
		if($this->input->server('REQUEST_METHOD')=='POST')
		{
			$customer_id=$this->session->userdata('customer_id');
			$valid=$this->order_model->validateOrderKey('',$order_id,$this->input->post(),$customer_id);
			if(isset($valid[0]))
			{
				$this->order_model->insertOrderKey('',$order_id,$this->input->post(),$customer_id);
				$this->release_payment($order_id);
			}
			else
			{
				//$data['cust_login']=0;
				echo  '<div style="color:red">Invalid Keys</div>';
			}
		}
		foreach($this->currency() as $key => $cr)
		$data[$key]  = $cr;
		$data['order_id']=$order_id;
		$orders=$this->order_model->getOrder('',$order_id);
		$this->load->model('customer_model');
		$payer=$this->customer_model->get_customer($orders[0]['payer_id']);
		$data['product_name']=$orders[0]['product_name'];
		$data['payer_name']=$payer[0]['first_name']." ".$payer[0]['last_name'];
		
		/* Kinnari */
		$this->load->model('customer_model');
		$cust_detail=$this->customer_model->get_customer($customer_id); 
		$data['cust_detail']=$cust_detail;
		/* Kinnari */
		$this->load->view('header',$data);
		$this->load->view('payee_complete_order',$data);
		$this->load->view('footer',$data);
	}
	public function getmilestone()
	{
		$order_id=$this->input->get_post('order_id');
		//$milestone_id=$this->input->post('mileston_id');
		$milestone_id='';
		if($order_id)
		{
			$transaction=$this->order_model->getMilestoneDetail($order_id,$milestone_id);
			//print_R($transaction);exit;
			echo json_encode($transaction);
		}
		else if($this->input->get_post('mileston_id'))
		{
			$transaction=$this->order_model->getMilestoneDetail('',$this->input->get_post('mileston_id'));
			//print_R($transaction);exit;
			echo json_encode($transaction);
		}
		else
		{
					echo "Invalid Data";
		}
	}
	public function getproduct()
	{
		$order_id=$this->input->get_post('order_id');
		//$product_id=$this->input->post('product_id');
		$product_id='';
		if($order_id)
		{
			$transaction=$this->order_model->getproductDetail($order_id,$product_id);
			//print_R($transaction);exit;
			echo json_encode($transaction);
		}
		else if($this->input->get_post('product_id'))
		{
			$transaction=$this->order_model->getproductDetail('',$this->input->get_post('product_id'));
			echo json_encode($transaction);
		}
		else
		{
					echo "Invalid Data";
		}
	}
	public function getinvoice()
	{
		$order_id=$this->input->get_post('order_id');
		//$product_id=$this->input->post('product_id');
		$product_id='';
		if($order_id)
		{
			$transaction=$this->order_model->getinvoiceDetail($order_id,$product_id);
			//print_R($transaction);exit;
			echo json_encode($transaction);
		}
		else if($this->input->get_post('product_id'))
		{
			$transaction=$this->order_model->getproductDetail('',$this->input->get_post('product_id'));
			print_R($transaction);exit;
			echo json_encode($transaction);
		}
		else
		{
					echo "Invalid Data";
		}
	}
	public function autocomplete($p)
	{	
		$customer=$this->session->userdata('customer_id');
		$payer_id	= $customer;
		$company_id	= "7";
		$payee_id	= $this->input->get('pe')?$this->input->get('pe'):'';
		$text= $this->input->get('search')?$this->input->get('search'):'';
		//$aResult = $this->order_model->autocomplete($payer_id,$company_id,$payee_id,$text);
		$product=$this->db->query("select (op.name)as name ,op.order_product_id from order_product op left join `order` o on op.order_id = o.order_id where o.is_milestone=".$p." and op.name like '%".$text."%' and o.payer_id=".$payer_id." group by name limit 0,5");
		$product = $product->result_array();
		
		$seller1=$this->db->query("select distinct(c.customer_id) ,o.payee_id,CONCAT(c.first_name,' ',c.last_name)as name ,op.order_product_id from order_product op left join `order` o on op.order_id = o.order_id left join customer c on c.customer_id=o.payee_id where o.is_milestone=".$p." and (c.first_name like '".$text."%' || c.last_name like '%".$text."%') and o.payer_id=".$payer_id." group by c.first_name limit 0,5");
		$seller1 = $seller1->result_array();
		
		$company=$this->db->query("select (c.company_name)as name ,o.company_id,op.order_product_id from order_product op left join `order` o on op.order_id = o.order_id left join customer_company c on c.customer_id=o.company_id where o.is_milestone=".$p." and c.company_name like '%".$text."%' and o.payer_id=".$payer_id." group by c.company_name limit 0,5");
		
		$company = $company->result_array();
		$seller="Seller";
		$seller_product="Product";
		if($p==1)
		{
			$seller="Service Provider";
			$seller_product="Services";
		}	
		$aResult=array();
		$i=0;
		if(count($product))
		{
			
			foreach($product as $pt)
			{
				
				$aResult["product_"]= array("id" =>"product_", "key" => $seller_product, "suggestion" =>" &lt;span class=\"extra text-orange\"> ".$seller_product."&lt;/span>", "suggestable" => "true");
				
				$aResult["product_".$pt['order_product_id']]= array("id" =>"product_".$pt['order_product_id'], "key" => $pt['name'], "suggestion" => $pt['name'], "suggestable" => "true");
			}
		}	
		
		if(count($seller1))
		{
			
			foreach($seller1 as $pt)
			{
				$aResult["seller_"]= array("id" =>"seller_", "key" => $seller, "suggestion" =>" &lt;span class=\"extra text-orange\"> ".$seller."&lt;/span>", "suggestable" => "true");
				
				$aResult["seller_".$pt['payee_id']]= array("id" =>"seller_".$pt['payee_id'], "key" => $pt['name'], "suggestion" => $pt['name'], "suggestable" => "true");
			}
		}	
		
		if(count($company))
		{
			
			foreach($company as $pt)
			{
				$aResult["company_"]= array("id" =>"company_", "key" => 'company_', "suggestion" =>" &lt;span class=\"extra text-orange\"> Store &lt;/span>", "suggestable" => "true");
				
				$aResult["company_".$pt['company_id']]= array("id" =>"company_".$pt['company_id'], "key" => $pt['name'], "suggestion" => $pt['name'], "suggestable" => "true");
			}
		}
		
		//echo json_encode($aResult,true);
		if (count($aResult) == 0){
			echo "{}";
		 }
		  else{
			echo json_encode($aResult);
		}
		
	}
	
	public function autocomplete_payee($p)
	{	
		$customer=$this->session->userdata('customer_id');
		$payee_id = $customer;
		$company_id	= "7";
		$text= $this->input->get('search')?$this->input->get('search'):'';
		//$aResult = $this->order_model->autocomplete($payer_id,$company_id,$payee_id,$text);
		$product=$this->db->query("select (op.name)as name ,op.order_product_id from order_product op left join `order` o on op.order_id = o.order_id where o.is_milestone=".$p." and op.name like '%".$text."%' and o.payee_id=".$payee_id." group by name limit 0,5");
		$product = $product->result_array();
		
		$buyer=$this->db->query("select distinct(c.customer_id) ,o.payer_id,CONCAT(c.first_name,' ',c.last_name)as name ,op.order_product_id from order_product op left join `order` o on op.order_id = o.order_id left join customer c on c.customer_id=o.payer_id where o.is_milestone=".$p." and (c.first_name like '".$text."%' || c.last_name like '%".$text."%') and o.payee_id=".$payee_id." group by c.first_name limit 0,5");
		$buyer = $buyer->result_array();
		
		$company=$this->db->query("select (c.company_name)as name ,o.company_id,op.order_product_id from order_product op left join `order` o on op.order_id = o.order_id left join customer_company c on c.customer_id=o.company_id where o.is_milestone=".$p." and c.company_name like '%".$text."%' and o.payee_id=".$payee_id." group by c.company_name limit 0,5");
		
		$company = $company->result_array();
		$seller="Buyer";
		$seller_product="Product";
		if($p==1)
		{
			$seller="Service Buyer";
			$seller_product="Services";
		}	
		$aResult=array();
		$i=0;
		if(count($product))
		{
			
			foreach($product as $pt)
			{
				
				$aResult["product_"]= array("id" =>"product_", "key" => $seller_product, "suggestion" =>" &lt;span class=\"extra text-orange\"> ".$seller_product."&lt;/span>", "suggestable" => "true");
				
				$aResult["product_".$pt['order_product_id']]= array("id" =>"product_".$pt['order_product_id'], "key" => $pt['name'], "suggestion" => $pt['name'], "suggestable" => "true");
			}
		}	
		
		if(count($buyer))
		{
			
			foreach($buyer as $pt)
			{
				$aResult["buyer_"]= array("id" =>"buyer_", "key" => $seller, "suggestion" =>" &lt;span class=\"extra text-orange\"> ".$seller."&lt;/span>", "suggestable" => "true");
				
				$aResult["buyer_".$pt['payer_id']]= array("id" =>"buyer_".$pt['payer_id'], "key" => $pt['name'], "suggestion" => $pt['name'], "suggestable" => "true");
			}
		}	
		
		if(count($company))
		{
			
			foreach($company as $pt)
			{
				$aResult["company_"]= array("id" =>"company_", "key" => 'company_', "suggestion" =>" &lt;span class=\"extra text-orange\"> Store &lt;/span>", "suggestable" => "true");
				
				$aResult["company_".$pt['company_id']]= array("id" =>"company_".$pt['company_id'], "key" => $pt['name'], "suggestion" => $pt['name'], "suggestable" => "true");
			}
		}
		
		//echo json_encode($aResult,true);
		if (count($aResult) == 0){
			echo "{}";
		 }
		  else{
			echo json_encode($aResult);
		}
		
	}
	
	public function withdraw()
	{
		
		$this->load->model('withdraw_model');
		$this->load->model('balance_manager_model');
		if(!$this->session->userdata('customer_id'))
		{
			redirect('home?redirect='.urlencode(uri_string()));
		}	
		$customer_id=$this->session->userdata('customer_id');
		
		$balance = $this->balance_manager_model->getCurrentBalance($customer_id);
		
		$user=$this->db->query('select cu.*,c.name as bank_country_name from  customer cu left join country c on c.country_id=cu.bank_country where customer_id='.$customer_id)->result_array();
		$data['userinfo']=$user[0];
		foreach($this->currency() as $key => $cr)
		$data[$key]  = $cr;		
		
		if($this->input->server('REQUEST_METHOD')=='POST')
		{
			$opt = $this->db->query("select * from withdraw_amount where status=0 and customer_id = '".$customer_id."'")->row();
			if(count($opt)>0)
			{
				$this->session->set_flashdata('errormsg', 'You have already send Request For withdraw');
				redirect('balance_manager');
			}
			$data['currency_id']=$this->input->post('currency_id');
			$data['amount']=str_replace(',','',$this->input->post('amount'));
			if($data['amount'] > $balance[0]['amount'])
			{
				$this->session->set_flashdata('errormsg', 'Insufficient Balance!');
				redirect('balance_manager');
			}
			$data['ip_address']=$this->input->ip_address();;
			$opt=$this->get_geolocation();
			$data=array_merge($data,$opt);	
			$balance = $this->withdraw_model->withdrawRequest($customer_id,$data);
			$message='Your withdrawal Request of '.$data['amount'].' Sent Successfully';
			//$this->session->set_flashdata('success', 'Request Sent successfully!');
			$to_query=$this->db->query("SELECT * from `customer` where customer_id=".$customer_id);
			$to_customer=$to_query->result_array();
			
			if(@isset($to_customer[0]['verify']) && $to_customer[0]['verify'])
			{
				$dt = $this->sms->send($message,urlencode("+".$to_customer[0]['phonecode'].	$to_customer[0]['customer_phone']));
			}
			redirect('thankyou',$data);
		}
		$data['current_balance']=$balance[0];
		$data['currencies']=$this->session->userdata('currencies');
	
		/* Kinnari */
		$this->load->model('customer_model');
		$cust_detail=$this->customer_model->get_customer($customer_id); 
		$data['cust_detail']=$cust_detail;
		/* Kinnari */
	//	echo "<pre>";
		
		$this->load->view('header',$data);
		$this->load->view('withdraw',$data);
		$this->load->view('footer',$data);
	}
	
}?>
<?php
define('API_ACCESS_TOKEN',' Bearer sk_test_bfe132a9881153f2080a2a9549065cb7bb8b58e5');
class Balance_manager extends CI_Controller{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url');	
		$this->load->library('session');
		
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->model('balance_manager_model');
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
				'currency_symbol' => $currency['symbol'],
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
		if(!$this->session->userdata('customer_id'))
		{
			redirect('home');
		}
		$this->session->userdata('redirect_success_url');
		
		if(isset($_GET['trxref']))
		{
			$this->curl_post($_GET['trxref']);
		
			if($this->session->userdata('session_temp_id'))
			{
					$opt = $this->db->query('select * from session_temp where customer_id="'.$this->session->userdata('customer_id').'" and session_id = "'.$this->session->userdata('session_temp_id').'" ')->row();
					$url=$opt->data;//$this->session->userdata('call_url');
					$this->session->unset_userdata('session_temp_id');
					$this->session->set_userdata('de_trans','1');
					redirect($url);
					
			}
			else
			{
					redirect($this->config->item('redirect_success_url'));
			}
			
		}
		
		$customer_id=$this->session->userdata('customer_id');
		
		if($this->input->server('REQUEST_METHOD')=='POST')
		{
			if($this->input->post('testing'))
			{
				$da=$this->input->post();
				$dat = array_merge($da,array('deposite_by'=>'Test'));
				$this->balance_manager_model->transferAmount($customer_id,$dat);
				$this->session->set_flashdata('success', 'Deposit transfer successfully..');
				
			redirect('dashboard');
			}
			else{
			$amount=$this->input->post('amount');
			if($amount!='' && $amount>0)
			{
			$ch = curl_init();
			$clientId = "AST0bRAWCHvGi_XyLdniDdKDkuaBznaJsDZUtqLQvo4Qyngty55AMRhtMH3n";
			$secret = "EJsqmBAQTR_vni8vmrtXFFtu_IYnRxxJ_xK816faVzxQL37m6O5mHFGkYjVh";
			
			
			$ch = curl_init();
			$data =array ( "USER" => "ceo-facilitator_api1.udsltdonline.com",
							"PWD" => "1391241086",
							"SIGNATURE" => "AFcWxV21C7fd0v3bYYYRCpSSRl31A9Wc67aYWxrbF91NxP3GmkejgqLD",
							"METHOD" => "SetExpressCheckout",
							"RETURNURL" => base_url()."index.php/paypal_notification",
							"CANCELURL" => base_url()."index.php/balance_manager",
							"VERSION" => "93",
							
							
							
							"PAYMENTREQUEST_0_CURRENCYCODE" => "USD",
							"PAYMENTREQUEST_0_AMT" => $amount,
							"PAYMENTREQUEST_0_ITEMAMT" => $amount,
							"PAYMENTREQUEST_0_SHIPPINGAMT" => "0",
							"PAYMENTREQUEST_0_HANDLINGAMT" => "0",
							"PAYMENTREQUEST_0_TAXAMT" => "0",
							"PAYMENTREQUEST_0_DESC" => "Transfer Money to TrustedPayer Account :$".$amount,
							"PAYMENTREQUEST_0_INSURANCEAMT" => "0",
							"PAYMENTREQUEST_0_SHIPDISCAMT" => "0",
							"PAYMENTREQUEST_0_SELLERPAYPALACCOUNTID" => "hitesh251086@gmail.com",
							"PAYMENTREQUEST_0_INSURANCEOPTIONOFFERED" => "false",
							"PAYMENTREQUEST_0_PAYMENTACTION" => "Sale",
							"PAYMENTREQUEST_0_PAYMENTREQUESTID" => "Transfer_".$customer_id
							
							
							
							 );
			$data=http_build_query($data);
			
			curl_setopt($ch, CURLOPT_URL, "https://api-3t.sandbox.paypal.com/nvp");
			curl_setopt($ch, CURLOPT_HEADER, false);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
			
			$result = curl_exec($ch);
			if(empty($result))die("Error: No response.");
			else
			{
				 parse_str(urldecode($result),$output);
				
				 header("LOCATION: https://www.sandbox.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token=".$output['TOKEN']);
				
			}
			curl_close($ch);

			}
			else
			{
				echo "amount Should be valid";
			}
			}
			/*	$da=$this->input->post();
				$dat = array_merge($da,array('deposite_by','Test'));
			$this->balance_manager_model->transferAmount($customer_id,$dat);
			redirect('dashboard');*/
		}
		$data='';
		$balance=$this->balance_manager_model->getCurrentBalance($customer_id);
		
		if(isset($balance[0])){
			$data['balance']=$balance[0];
			$data['current_balance']=$balance[0];
		}
		else
		$data['balance']=0;
		$this->load->model('customer_model');
		$cust_detl=$this->customer_model->get_customer($customer_id);
		$data['email']=$cust_detl[0]['email'];
		$this->load->model('order_model');
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
		$user=$this->db->query('select cu.*,c.name as bank_country_name from  customer cu left join country c on c.country_id=cu.bank_country where customer_id='.$customer_id)->result_array();
		$data['userinfo']=$user[0];
		$this->load->view('header',$data);
		$this->load->view('balance_manager',$data);
		$this->load->view('footer',$data);
	}
	public function getCurrentBalance()
	{
		if($this->session->userdata('customer_id'))
		{
		$customer_id=$this->session->userdata('customer_id');
		$this->load->model('balance_manager_model');
		$balance=$this->balance_manager_model->getCurrentBalance($customer_id);
		if(isset($balance[0]))
		echo $balance[0]['amount'];
		else 
		echo "0";
		}
		echo "";
	}
	public function get_data()
	{
		$customer_id=$this->session->userdata('customer_id');
		function getStatus($transref,$mertid,$type='',$sign){
		$request = 'mertid='.$mertid.'&transref='.$transref.'&respformat='.$type.'&signature='.$sign; //initialize the request variables
		$url = 'https://www.cashenvoy.com/sandbox/?cmd=requery'; //this is the url of the gateway's test api
		//$url = 'https://www.cashenvoy.com/webservice/?cmd=requery'; //this is the url of the gateway's live api
		
		//print($request);exit;
		$ch = curl_init(); //initialize curl handle
		curl_setopt($ch, CURLOPT_URL, $url); //set the url
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,true); //return as a variable
		curl_setopt($ch, CURLOPT_POST, 1); //set POST method
		curl_setopt($ch, CURLOPT_POSTFIELDS, $request); //set the POST variables
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		$response = curl_exec($ch); // grab URL and pass it to the browser. Run the whole process and return the response
		curl_close($ch); //close the curl handle
		return $response;	
		}
		$key = 'a0663da2476e33edd484e0f9e2a11aa0';
		
		$transref = $this->session->userdata('transaction_id') ? $this->session->userdata('transaction_id') :  'A1123651522132133248';
		$mertid =3379;
		$type = 'json'; //Data return format. Options are xml or json. leave blank if you want data returned in string format.
		$cdata = $key.$transref.$mertid;
		$signature = hash_hmac('sha256', $cdata, $key, false);
		$response = getStatus($transref,$mertid,$type,$signature);
		
		
		$res = json_decode($response);
		
		if($res->TransactionStatus=='C00')
		{
			$this->session->set_flashdata('success', 'Transaction SuccessFull');
			$data=$this->input->post();
			$data['amount']=($this->input->post('ce_amount')*1)/199.33;
			$this->balance_manager_model->transferAmount($customer_id,$data);
		}
		else
		{
			$this->session->set_flashdata('errormsg', 'Transaction Fail');
		}
		redirect('dashboard');
		
	}
	
	public function c_post()
	{
		
		
		$customer_id=$this->session->userdata('customer_id');
		$this->load->model('customer_model');
		$cust_detail=$this->customer_model->get_customer($customer_id); 
		$data['cust_detail']=$cust_detail;
		$url = $this->input->post('callback_url')?$this->input->post('callback_url') : base_url()."balance_manager";
		
		$op1 = $this->db->query('select * from currency where currency_id ="'.$this->session->userdata('currency_id').'" ')->row();
		$ar = array('amount'=>(str_replace(',','',$this->input->post('amount'))*100),'email'=>$cust_detail[0]['email'],"callback_url"=>$url);
		$ar1=json_encode($ar);
		
		$headers = array
		(
			'Authorization: '.API_ACCESS_TOKEN,
			'Content-Type: application/json'
		);
		
		$ch = curl_init();
		curl_setopt( $ch,CURLOPT_URL, 'https://api.paystack.co/transaction/initialize' );
		curl_setopt( $ch,CURLOPT_POST, true );
		curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
		curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
		curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $ar ) );
		$result = curl_exec($ch );
		curl_close( $ch );
		$result = json_decode($result);
		
		$data = array("status"=>$result->status,"url"=>$result->data->authorization_url,"access_code"=>$result->data->access_code,"reference"=>$result->data->reference);
		echo json_encode($data);exit;
	}
	public function curl_post($reference_id)
	{
		$customer_id=$this->session->userdata('customer_id');
		$headers = array
		(
			'Authorization:'.API_ACCESS_TOKEN,
			'Content-Type: application/json'
		);
		$ch = curl_init();
		curl_setopt( $ch,CURLOPT_URL, 'https://api.paystack.co/transaction/verify/'.$reference_id );
		curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
		curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
		$result = curl_exec($ch );
		curl_close( $ch );
		$result = json_decode($result);
		if($result->status)
		{
			$this->session->set_flashdata('success', 'Transaction SuccessFull');
			$data=$this->input->post();
			$op1 = $this->db->query('select * from currency where currency_id ="'.$this->session->userdata('currency_id').'" ')->row();
			$op = $this->db->query('select * from currency where code ="NGN" ')->row();
			$data['amount']=(($result->data->amount*1)/($op->value*100));
			$data['deposite_by']='Paystack';
			if($op1->value!=0)
				$data['amount']=(($result->data->amount*1)/($op->value*100))/$op1->value;
				
			$this->balance_manager_model->transferAmount($customer_id,$data);
		}
		
	}
}?>
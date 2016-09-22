<?php
class Request_money extends CI_Controller{
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url');	
		$this->load->library('session');
		
		$this->load->model('request_money_model');
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
		if(!$this->session->userdata('customer_id'))
		{
			redirect('home');
		}
		$customer_id=$this->session->userdata('customer_id');
		
		$data='';
		$this->load->model('request_money_model');
		if($this->input->server('REQUEST_METHOD')=='POST')
		{			
			if($this->input->post('request_to')=='mobile' &&!is_numeric($this->input->post('contact')))
			{
				$this->session->set_flashdata('errormsg',"Invalid transaction mobile number please check details and try again!");
				redirect('request_money');
			}
			$result =$this->request_money_model->request($customer_id,$this->input->post());
			if($result['status']=='Success')
			{
				$headers  = 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
				$headers .= 'From: Trustedpayer <info@trustedpayer.com>' . "\r\n";
				$message = 'You request for money to contact info : '.$this->input->post('contact');
				/* sms */
				$to_query=$this->db->query("SELECT * from `customer` where email='".$result['reciver_email']."' ");
				$to_customer=$to_query->result_array();
				if(isset($to_customer[0]['verify']) && $to_customer[0]['verify'])
				{
					$this->sms->send($message,urlencode("+".$to_customer[0]['phonecode'].$to_customer[0]['customer_phone']));
				}
				/* sms send */
				$flag=mail($result['reciver_email'], 'Send money', urldecode($message), $headers);
				$headers  = 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
				$headers .= 'From: Trustedpayer <info@trustedpayer.com>' . "\r\n";
				$message = 'You got money request from :'.$this->session->userdata('first_name');
				$message .= 'To accept request click <a href="'.base_url().'index.php/request_money/approve_request/'.$result['id'].'">HERE</a>';
				/* sms */
				$to_query=$this->db->query("SELECT * from `customer` where email='".$result['sender_email']."' ");
				$to_customer=$to_query->result_array();
				if(isset($to_customer[0]['verify']) && $to_customer[0]['verify'])
				{
					$this->sms->send(urlencode($message),urlencode("+".$to_customer[0]['phonecode'].$to_customer[0]['customer_phone']));
				}
				/* sms send */
				$flag=mail($result['sender_email'], 'Send money', urldecode($message), $headers);
				$this->session->set_flashdata('success',"Transaction Successful!");
				redirect('request_money');
			}
			else
			{
				$this->session->set_flashdata('errormsg',"Invalid transaction please check details and try again!");
				$data['error']="Invalid transaction please check details and try again!";
			}
		}
		$this->load->model('balance_manager_model');
		$data['balance']=$this->balance_manager_model->getCurrentBalance($customer_id);
		$data['reasons']=$this->request_money_model->reason();
		foreach($this->currency() as $key => $cr)
		$data[$key]  = $cr;
		
		
		$currencies= $this->currencies_model->getCurrencies();
		$cf_array=array();
		foreach($currencies as $cf)
		{
			if($cf['status']==1)
			$cf_array[$cf['code']]=$cf['value'];
		}
		
		$data['cf_array']=$cf_array;
		$c_u= $this->db->query('select * from customer where customer_id='.$this->session->userdata('customer_id'))->row();
		
		$arr= array();
		$arr[]=$c_u->email;
		
		if(!$c_u->customer_phone)
		$arr[]=$c_u->email;
		else
		$arr[]=$c_u->customer_phone;
		 if(isset($_GET['received'])){
		$data['receieved_list']=$this->request_money_model->getDetails_list($arr); 
		 }else{
				$data['request_list']=$this->request_money_model->getDetails_list_Req($this->session->userdata('customer_id'));  
		 }
		$this->load->model('customer_model');
		$cust_detail=$this->customer_model->get_customer($customer_id); 
		$data['cust_detail']=$cust_detail;
		
		$this->load->view('header',$data);
		$this->load->view('request-money',$data);
		$this->load->view('footer',$data);
	}
	public function approve_request($id)
	{
		if(!$id)
		{
			$this->session->set_flashdata('errormsg',"Invalid transaction or it has been expired!");
			redirect('request_money');
		}	
		if(!$this->session->userdata('customer_id'))
		{
			redirect('home?redirect=request_money/approve_request/'.$id);
		}
		$customer_id=$this->session->userdata('customer_id');
		$data='';
		foreach($this->currency() as $key => $cr)
		$data[$key]  = $cr;
		$this->load->model('request_money_model');
		if($this->input->server('REQUEST_METHOD')=='POST')
		{	
			if($this->input->post('ok'))
			{
				$this->request_money_model->approveRequest($customer_id,$id);
				$this->session->set_flashdata('success',"It is approved!");
			}
			else if($this->input->post('cancel'))
			{
				$this->request_money_model->declineRequest($customer_id,$id);
				$this->session->set_flashdata('errormsg',"It is cancelled!");
			}
			redirect('send_money?requested');
		}
		
		/* Kinnari */
		$this->load->model('customer_model');
		$cust_detail=$this->customer_model->get_customer($customer_id); 
		$data['cust_detail']=$cust_detail;
		/* Kinnari */
		$request=$this->request_money_model->getRequest($customer_id,$id);
		if($request['status']=='Success')
		{
			$data['request']=$request['result'];
			$this->load->view('header',$data);
			$this->load->view('approve-request-money',$data);
			$this->load->view('footer',$data);
		}
		else
		{
			$this->session->set_flashdata('errormsg',"Invalid transaction or expired!");
			redirect('request_money');
		}
		
	}
}?>
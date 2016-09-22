<?php
class Send_money extends CI_Controller{
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url');	
		$this->load->library('session');
		
		$this->load->model('send_money_model');
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
		$this->load->model('send_money_model');
		if($this->input->server('REQUEST_METHOD')=='POST')
		{			
		
			$result =$this->send_money_model->send($customer_id,$this->input->post());
				
			if($this->input->post('send_to')=='mobile' && $result['status']=='Success')
			{
		
				if(!is_numeric($this->input->post('contact')))
				{
					$this->session->set_flashdata('errormsg',"Invalid transaction mobile number please check details and try again!");
					
					redirect('send_money');
				}
				$message = 'You recive money from '.$this->session->userdata('first_name').";  To accept and receive the money please click <a href='".base_url()."index.php/send_money/confirm/".$result['invoice_id']."'>HERE</a>";
				$sms_message = "You recive money from - ".$this->session->userdata('first_name')." to accept please click here ".base_url()."index.php/send_money/confirm/".$result['invoice_id'];
				$uc = $this->db->query("select * from customer where customer_phone=".$this->input->post('contact'))->row();
				if($uc->verify)
				{
					$this->sms->send($sms_message,urlencode("+".$uc->phonecode.$uc->customer_phone));		
				}
				$this->session->set_flashdata('success',"Transaction has been Successful!");
				/* redirect('send_money'); */
			}	
		
			if($result['status']=='Success')
			{
					$headers  = 'MIME-Version: 1.0' . "\r\n";
					$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
					$headers .= 'From: Trustedpayer <info@trustedpayer.com>' . "\r\n";
					
					$message = 'You send money to contact info :'.$this->input->post('contact')."; Key : ".$result['key'];
					
					$sms_message = 'You have sent $ '.$result['sent_amount'].' to contact info - '.$this->input->post('contact')."\n Key : ".$result['key'];
					$to_query=$this->db->query("SELECT * from `customer` where email='".$result['sender_email']."' ");
					$to_customer=$to_query->result_array();
					if(@$to_customer[0]['verify'])
					{
						$this->sms->send($sms_message,urlencode($to_customer[0]['phonecode'].$to_customer[0]['customer_phone']));
					}
					$flag=mail($result['sender_email'], 'Sent money', urldecode($message), $headers);
					
					$headers  = 'MIME-Version: 1.0' . "\r\n";
					$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
					$headers .= 'From: Trustedpayer <info@trustedpayer.com>' . "\r\n";
					$message = 'You recive money from :'.$this->session->userdata('first_name')." to accept please click <a href='".base_url()."index.php/send_money/confirm/".$result['invoice_id']."'>HERE</a>";
					$sms_message = 'You recive money from :'.$this->session->userdata('first_name')." to accept please click ".base_url()."index.php/send_money/confirm/".$result['invoice_id'];
					$to_query=$this->db->query("SELECT * from `customer` where email='".$result['reciver_email']."' ");
					$to_customer=$to_query->result_array();
					if(isset($to_customer[0]['verify']))
					{
						$this->sms->send($sms_message,urlencode("+".$to_customer[0]['phonecode'].$to_customer[0]['customer_phone']));
					}
					$flag=mail($result['reciver_email'], 'Recived money', urldecode($message), $headers);
					$this->session->set_flashdata('success',"Transaction has been Successful!");
					redirect('send_money');
			}
			else
			{
				$customer_id = $this->session->userdata('customer_id');
				$to_query=$this->db->query("SELECT * from `customer` where customer_id='".$customer_id."' ")->row();
				$message = $to_query->first_name.' wants to send you money from TrustedPayer, Please register now to accept the Request : https://trustedpayer.com ';
				$this->sms->send($message,urlencode("+".$this->input->post('phonecode').$this->input->post('contact')));
				$this->session->set_flashdata('errormsg',"Invalid transaction Please check details and try again!");
				$data['error']="<i class='fa fa-exclamation-triangle'></i> Invalid transaction Please check details and try again!";
			}
		}
		$this->load->model('balance_manager_model');
		$data['balance']=$this->balance_manager_model->getCurrentBalance($customer_id);
		$data['reasons']=$this->send_money_model->reason();
		foreach($this->currency() as $key => $cr)
		$data[$key]  = $cr;
		$data['phonecode']=$this->db->query('select iso,phonecode from country group by phonecode order by phonecode')->result_array(); 
		$currencies= $this->currencies_model->getCurrencies();
		$cf_array=array();
		foreach($currencies as $cf)
		{
			if($cf['status']==1)
			$cf_array[$cf['code']]=$cf['value'];
		}
		$data['cf_array']=$cf_array;
		/* Kinnari */
		$this->load->model('customer_model');
		$cust_detail=$this->customer_model->get_customer($customer_id); 
		$data['cust_detail']=$cust_detail;
		/* Kinnari */
		 if(!isset($_GET['requested'])){
		$data['send_list']=$this->send_money_model->getDetails_list($customer_id); 
		
		
				$c_u= $this->db->query('select * from customer where customer_id='.$this->session->userdata('customer_id'))->row();
				$arr= array();
				$arr[]=$c_u->email;
				
				if(!$c_u->customer_phone)
				$arr[]=$c_u->email;
				else
				$arr[]=$c_u->customer_phone;
				$data['requested_list_count']=$this->send_money_model->getDetails_list_Req($arr,1); 
		 }else{
			 $c_u= $this->db->query('select * from customer where customer_id='.$this->session->userdata('customer_id'))->row();
		
				$arr= array();
				$arr[]=$c_u->email;
				
				if(!$c_u->customer_phone)
				$arr[]=$c_u->email;
				else
				$arr[]=$c_u->customer_phone;
			 $data['request_list']=$this->send_money_model->getDetails_list_Req($arr); 
		 } 
		$this->load->view('header',$data);
		$this->load->view('send-money',$data);
		$this->load->view('footer',$data);
	}
	public function confirm($invoice_id)
	{
		if(!$this->session->userdata('customer_id'))
		{
			redirect('home?redirect=send_money/confirm/'.$invoice_id);
		}
		
		if(!$invoice_id)
		{
			$this->session->set_flashdata('errormsg',"Invalid transaction or it has been expired!");
			redirect('request_money?received');
		}
		
		$customer_id=$this->session->userdata('customer_id');
		
		$data='';
		$this->load->model('send_money_model');
		if($this->input->server('REQUEST_METHOD')=='POST')
		{
			$valid=$this->send_money_model->reciveMoney($customer_id,$invoice_id,$this->input->post('key'));
			if(!$valid)
			{
				$this->session->set_flashdata('errormsg',"Invalid transaction Key , try again!");
				$data['error']='Invalid Key';
				
			}
			else
			{
				$this->session->set_flashdata('success',"Transaction has been successful!");
				redirect('request_money?received');
			}
			
		}
		
		$valid=$this->send_money_model->valid($customer_id,$invoice_id);
		if(!isset($valid[0]))
		{
			$data['page']='Invalid User login,Please Login with valid account !';
			$this->session->set_flashdata('errormsg',"Invalid User account!");
			
		}	
		
		else if($valid[0]['status']=='2')
		{
			$this->session->set_flashdata('success',"Amount Already received!");
			$data['page']='Amount Already has been received';			
		}
		
		$data['details']=$this->send_money_model->getDetails($invoice_id);
		foreach($this->currency() as $key => $cr)
		$data[$key]  = $cr;
		/* Kinnari */
		$this->load->model('customer_model');
		$cust_detail=$this->customer_model->get_customer($customer_id); 
		$data['cust_detail']=$cust_detail;
		/* Kinnari */
		$this->load->view('header',$data);
		$this->load->view('confirm-send-money',$data);
		$this->load->view('footer',$data);
	}
}?>
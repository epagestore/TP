<?php
class Business extends CI_Controller{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->library('form_validation');		
	}
	function email_exists($email)
	{
		$this->load->model('customer_model');
		$this->form_validation->set_message('email_exists','The %s already exists.');
		return $this->customer_model->email_exists($email);
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
	public function index() {
		$data='';
		if($this->input->server('REQUEST_METHOD')=='POST')
		{
			$this->form_validation->set_rules('email', 'Email Address', 'required|valid_email|callback_email_exists');
			if ($this->form_validation->run() !== FALSE)
			{
				$this->load->model('customer_model');
				$this->customer_model->insertCustomerQuick($this->input->post(),$user_type='cmp');
				
				$validCustomer=$this->customer_model->validate_customer($this->input->post());
				$this->session->unset_userdata('customer_id');
				$this->session->unset_userdata('customer_name');
				$this->session->set_userdata('customer_id',$validCustomer[0]['customer_id']);
				$this->session->set_userdata('first_name',$validCustomer[0]['first_name']);
				$this->session->set_userdata('customer_group_id',$validCustomer[0]['customer_group_id']);
				redirect('dashboard');
			}
			
		}
		$data['redirect']="";
		foreach($this->currency() as $key => $cr)
		$data[$key]  = $cr;
		
		/* Kinnari */
		$this->load->model('customer_model');
		$cust_detail=$this->customer_model->get_customer($customer_id); 
		$data['cust_detail']=$cust_detail;
		/* Kinnari */
		$this->load->view('header',$data);
		$this->load->view('business',$data);
		$this->load->view('footer',$data);
	}
}?>
<?php
class Customer extends CI_Controller{
	public function __construct()
	{
		parent::__construct();		
		$this->load->library('session');	
		$this->load->helper('url');	
		$this->load->helper('form');
		$this->load->helper('string');
		$this->load->library('form_validation');
		$this->load->model('customer_model');
		$this->load->library('encrypt');
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
		if($this->input->server('REQUEST_METHOD')=='POST')
		{			
			$this->customer_model->insertCustomer($this->input->post());
			
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
		$this->load->view('customer_registration',$data);
		$this->load->view('footer',$data);
	}
	public function personal(){
		if($this->input->server('REQUEST_METHOD')=='POST')
		{
			
			$this->customer_model->insertCustomer($this->input->post(),$user_type='indv');
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
		$this->load->view('personal_registration',$data);
		$this->load->view('footer',$data);
	}
	public function business(){
		if($this->input->server('REQUEST_METHOD')=='POST')
		{
			
			$this->customer_model->insertCustomer($this->input->post(),$user_type='cmp');
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
		$this->load->view('business_registration',$data);
		$this->load->view('footer',$data);
	}
	public function get_api(){
		if($this->input->server('REQUEST_METHOD')=='POST')
		{
			$this->customer_model->insertCustomerApi($this->input->post());
		}
	}
	
}?>
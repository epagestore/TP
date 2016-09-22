<?php
class Notification extends CI_Controller{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->helper('url');		
		if(!$this->session->userdata('customer_id'))
		{
			redirect('home');
		}
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->model('options_model');
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
		
		
		
	public function index()
	{
		$customer_id=$this->session->userdata('customer_id');
		$data='';
		foreach($this->currency() as $key => $cr)
		$data[$key]  = $cr;
		
		function compare_func($a, $b)
		{
			// CONVERT $a AND $b to DATE AND TIME using strtotime() function
			$t1 = strtotime($a["date_added"]);
			$t2 = strtotime($b["date_added"]);
		
			return ($t2 - $t1);
		}
		/* Kinnari */
		$this->load->model('customer_model');
		$cust_detail=$this->customer_model->get_customer($customer_id); 
		$data['notif'] = $this->options_model->notif($customer_id);
		$data['cust_detail']=$cust_detail;
		/* Kinnari */
		$this->load->view('header',$data);
		$this->load->view('inner_menu',$data);
		$this->load->view('notification',$data);
		$this->load->view('footer',$data);
	}
	
}?>
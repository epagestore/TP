<?php
class Forget_password extends CI_Controller{
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->library('session');
		$this->load->helper('form');
		$this->load->library('form_validation');		
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
		$data='';
		$data['redirect']='';
		
		if(!(isset($_GET['email']) && isset($_GET['confirm_code'])))
			show_404();
		$email=$_GET['email'];
		$confirm_code=$_GET['confirm_code'];
		$this->load->model('forget_model');
		$customer=$this->forget_model->validateForget($email,$confirm_code);
		
		if(!isset($customer[0]))
		show_404();
		
		if($this->input->server('REQUEST_METHOD')=='POST')
		{
			$this->form_validation->set_rules('pass', 'New Password', 'required');
			$this->form_validation->set_rules('confirm_pass', 'Confirm Password', 'required|matches[pass]');
			if ($this->form_validation->run() == TRUE)
			{
				$this->forget_model->changePass($customer[0]['customer_id'],$this->input->post());
				redirect('home');
			}
		}
		if($this->session->userdata('customer_id') && $this->session->userdata('customer_id')!=$customer[0]['customer_id'])
		{
			$this->session->sess_destroy();
		}
		
		$data='';
		$id=$this->db->query("select customer_id from customer where email='".$email."'")->row();
		foreach($this->currency() as $key => $cr)
		$data[$key]  = $cr;
		$customer_id=$id->customer_id;
		/* Kinnari */
		$this->load->model('customer_model');
		$cust_detail=$this->customer_model->get_customer($customer_id); 
		$data['cust_detail']=$cust_detail;
		/* Kinnari */
		$this->load->view('header',$data);
		$this->load->view('forget_password');
		$this->load->view('footer');
	}
}?>
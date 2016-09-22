<?php class Amount_transaction extends CI_Controller{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->helper('url');
			$this->load->helper('form');
		$this->load->library('form_validation');
		if(!isset($this->session->userdata['is_logged_in'])) { 
				redirect('login');
		}
		$this->load->model('amount_transaction_model');
	}
	public function index() {
		$customer_name='';
		if($this->input->server('REQUEST_METHOD')=='POST')
		{
			$customer_name=$this->input->post('customer_name');
		}
		$data='';
		$data['customer_name']=$customer_name;
		$data['transactions']=$this->amount_transaction_model->getAmountTransaction($customer_name);
		
		/* Kinnari */
		$this->load->model('customer_model');
		$cust_detail=$this->customer_model->get_customer($customer_id); 
		$data['cust_detail']=$cust_detail;
		/* Kinnari */
		$this->load->view('header');
		$this->load->view('amount_transaction',$data);
		$this->load->view('footer');
	}
}?>
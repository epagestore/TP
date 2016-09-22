<?php
class Sign_out extends CI_Controller{
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url');	
		$this->load->library('session');
	}
	public function index() {
		$this->load->model('customer_model');
		$customer_id=$this->session->userdata('customer_id');
		$this->session->sess_destroy();
		
		redirect('home');
	}
}
?>
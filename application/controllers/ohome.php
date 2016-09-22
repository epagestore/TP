<?php
class Home extends CI_Controller{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->helper('url');		
		if($this->session->userdata('customer_id'))
		{
			redirect('dashboard');
		}
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->library('encrypt');	
	}
	function email_exists($email)
	{
		$this->load->model('customer_model');
		$this->form_validation->set_message('email_exists','The %s already exists.');
		return $this->customer_model->email_exists($email);
	}
	function email_not_exists($email)
	{
		$this->load->model('customer_model');
		$this->form_validation->set_message('email_not_exists','The %s not exists.');
		if($this->customer_model->email_exists($email))
		return FALSE;
		else
		return TRUE;		
	}
	public function index() {
		$data='';
		if($this->input->server('REQUEST_METHOD')=='POST')
		{
			if($this->input->post('forget_pass'))
			{
				
				$this->form_validation->set_rules('forget_email', 'Email Address', 'required|valid_email|callback_email_not_exists');
				if ($this->form_validation->run() == TRUE)
				{
					$this->load->model('customer_model');
					$confirm_code=$this->customer_model->forgetPassword($this->input->post());
					$headers  = 'MIME-Version: 1.0' . "\r\n";
					$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
					$headers .= 'From: Trustedpayer <info@trustedpayer.com>' . "\r\n";
					$message = 'Reset your password from <a href="http://tp.epagestore.in/index.php/forget_password?email='.$this->input->post('forget_email').'&confirm_code='.$confirm_code.'">Here</a>';
					
					$flag=mail($this->input->post('forget_email'), 'trustedPayer Reset password', urldecode($message), $headers);
					$this->session->set_flashdata('forget_pass:success', 'Password reset link sent to you email address sucesfully!');
					redirect('home#popup','refresh');
				}
				else
				{
					$this->session->set_flashdata('forget_pass:error', form_error('forget_email'));
					redirect('home#popup','refresh');
				}
			}
			else
			{
				$this->form_validation->set_rules('email', 'Email Address', 'required|valid_email|callback_email_exists');
				if ($this->form_validation->run() !== FALSE)
				{
					$this->load->model('customer_model');
					$this->customer_model->insertCustomerQuick($this->input->post());
					
					$validCustomer=$this->customer_model->validate_customer($this->input->post());
					$this->session->unset_userdata('customer_id');
					$this->session->unset_userdata('customer_name');
					$this->session->set_userdata('customer_id',$validCustomer[0]['customer_id']);
					$this->session->set_userdata('first_name',$validCustomer[0]['first_name']);
					$this->session->set_userdata('customer_group_id',$validCustomer[0]['customer_group_id']);
					redirect('dashboard');
				}
			}
			
		}
		if($this->session->userdata('customer_id'))
		{
			redirect('dashboard');
		}
		$data['redirect']="";
		$this->load->view('header',$data);
		$this->load->view('home',$data);
		$this->load->view('footer',$data);
	}
}?>
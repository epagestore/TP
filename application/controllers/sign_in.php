<?php
class Sign_in extends CI_Controller{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('customer_model');
		
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->helper('url');	
		
		$this->load->library('session');
	}
	public function index() {
		if($this->input->server('REQUEST_METHOD')=='POST')
		{			
			$validCustomer=$this->customer_model->validate_customer($this->input->post());
			if($validCustomer &&($this->input->post('email') && $this->input->post('password')))
			{
				if($this->session->userdata('customer_id'))
				$this->session->unset_userdata('customer_id');
				
				if($this->session->userdata('customer_name'))
				$this->session->unset_userdata('customer_name');
				
				if($this->session->userdata('customer_group_id'))
				{
					$this->session->unset_userdata('customer_group_id');
					$this->session->sess_destroy();
					$this->session->sess_create();
				}
				$ip='';
				if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
				{
				  $ip=$_SERVER['HTTP_CLIENT_IP'];
				}
				elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
				{
				  $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
				}
				else
				{
				  $ip=$_SERVER['REMOTE_ADDR'];
				}
				$xml = simplexml_load_file("http://www.geoplugin.net/xml.gp?ip".$ip);
				
				$ip_con=$xml->geoplugin_countryName ;
				$ip_city=$xml->geoplugin_city ;
				$rslt=$this->customer_model->get_cust_ip($validCustomer[0]['customer_id']);
				if(sizeof($rslt)==1)
				{
					$last_ip=$rslt[0]['ip'];
					$last_country=$rslt[0]['country'];
					$last_city=$rslt[0]['city'];
					$this->customer_model->update_cust_id($ip,$last_ip,$last_country,$last_city,$ip_con,$validCustomer[0]['customer_id']);
				}
				else
				{
					$this->customer_model->insert_cust_id($ip,$validCustomer[0]['customer_id'],$ip_con,$ip_city);
				}
				
				
				$this->session->set_userdata('customer_id',$validCustomer[0]['customer_id']);
				$this->session->set_userdata('first_name',$validCustomer[0]['first_name']);
				$this->session->set_userdata('customer_group_id',$validCustomer[0]['customer_group_id']);
				$this->load->model('balance_manager_model');
				$balance=$this->balance_manager_model->getCurrentBalance($validCustomer[0]['customer_id']);
				if(isset($balance[0]))
				$this->session->set_userdata('balance',$balance[0]['amount']);
				else
				$this->session->set_userdata('balance','0');
				
				if($this->input->post('api_key')!='')
				redirect($this->input->post('api_redirect').'?id='.urlencode($this->input->post('api_key')).'&c_l=1');
				else
				{
					if($this->input->post('redirect')!="")
					{
						redirect($this->input->post('redirect'));
					}
					else
					{
						redirect('dashboard');
					}
				}
				
			}else{
				$this->session->set_flashdata('message', 'Incorrect Password/Email!');
				if($this->input->post('redirect'))
				$data['redirect']=urldecode($this->input->post('redirect'));
				else
				$data['redirect']="";
				if($this->input->post('api_key'))
				redirect($this->input->post('api_redirect').'?id='.urlencode($this->input->post('api_key')).'&redirect='.$this->input->post('api_redirect').'&c_l=0');	
				else
				redirect('');	
			}
		}
		else{
			$data='';
			if(isset($_GET['redirect']))
			$data['redirect']=urldecode($_GET['redirect']);
			else
			$data['redirect']="";
			$this->load->view('sign_in',$data);
		}
	}
	public function validCustomer()
	{
		
		$validCustomer=$this->customer_model->validate_customer($this->input->post());
		if(count($validCustomer)>0)
		{
			echo "Successfully Logged in...";
			
		}
		else
		{
			echo "Email or Password is wrong...!!!!";
			
		}
		
	}
	public function validate_email()
	{
		$this->load->model('customer_model');
		$d = $this->customer_model->email_exists($this->input->post('email'));
		print_R(count($d));
		
	}
	public function fg()
	{
		if($this->input->server('REQUEST_METHOD')=='POST')
		{
			if($this->input->post('forget_pass'))
			{
				$data='';
				$this->form_validation->set_rules('forget_email', 'Email Address', 'required|valid_email|callback_email_not_exists');
				if ($this->form_validation->run() == TRUE)
				{
					$this->load->model('customer_model');
					$confirm_code=$this->customer_model->forgetPassword($this->input->post());
					$headers  = 'MIME-Version: 1.0' . "\r\n";
					$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
					$headers .= 'From: TrustedPayer <info@trustedpayer.com>' . "\r\n";
					$message = 'Reset your password from <a href="http://trustedpayer.com/index.php/forget_password?email='.$this->input->post('forget_email').'&confirm_code='.$confirm_code.'">Here</a>';
					//$flag=mail($this->input->post('forget_email'), 'trustedPayer Reset password', urldecode($message), $headers);
					$data=array("status"=>1,"message"=>"Password reset link sent to you email address sucesfully!");
				}
				else
				{
					
					$data=array("status"=>0,"message"=>"InvalidEmail");
					
				}
				echo json_encode($data);
			}
		}
	}
	public function getDetailOfUserLog()
	{	
		$this->load->model('customer_model');
		if($this->session->userdata('customer_id'))
		{
			$rslt=$this->customer_model->get_cust_ip($this->session->userdata('customer_id'));
			echo json_encode($rslt);
		}else
		{
			echo 1; 
		}
	}
}
?>
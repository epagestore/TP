<?php
class Profile extends CI_Controller{
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url');	
		$this->load->library('session');
		if(!$this->session->userdata('customer_id'))
		{
			redirect('home');
		}
		$this->load->helper('form');
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
	public function opt()
	{
		$otp=mt_rand(100000, 999999);
		$txt="OTP code is ".$otp." ";	
		$this->session->set_userdata('otp',$otp);		
		$s= $this->sms->send($txt,$this->input->get('number'));
		if($s=='1')
		{
			echo "OPT sent successful!";
		}else{
			echo "Failed! Invalid mobile number or not supported!";
		}
		
		
	}
	public function opt_verify()
	{
		if($this->session->userdata('otp')==$this->input->get('otp'))
		{
			$i=0;
			if(!$this->input->get('index'))
			{
				$i='';
			}else{
				$i=$this->input->get('index');
			}	
			$this->db->query("update customer set verify".$i."=1 ,customer_phone".$i."=".$this->input->get('mobile').",phonecode".$i."=".$this->input->get('phonecode')." where customer_id=".$this->session->userdata('customer_id'));
			echo "1";
		}else{
			echo "0";
		}	
	}
	
	public function removePhone($i)
	{
		$this->db->query("update customer set verify".$i."=0,customer_phone".$i."='0',phonecode".$i."='0' where customer_id=".$this->session->userdata('customer_id'));
	}
	
	public function index(){
		$customer_id=$this->session->userdata('customer_id');
		$profile=$this->customer_model->get_customer($customer_id);
		$data['profile']=$profile[0];
		$data['edit']="not-allow";
		$data['customer_key']=$profile[0]['customer_unique_id'];
		
		$this->load->model('paypal_model');
		$data['paypal_email']="";
		$key=$this->paypal_model->getPaypalEmail($customer_id);
		if(isset($key[0]))
		$data['paypal_email']=$key[0]['paypal_email'];
		foreach($this->currency() as $key => $cr)
		$data[$key]  = $cr;
		
		/* Kinnari */
		$this->load->model('customer_model');
		$cust_detail=$this->customer_model->get_customer($customer_id); 
		$data['cust_detail']=$cust_detail;
		/* Kinnari */
		$this->load->view('header',$data);
		$this->load->view('profile',$data);
		$this->load->view('footer',$data);
	}
	
	public function edit(){
		
		$customer_id=$this->session->userdata('customer_id');
		$this->load->model('paypal_model');
		if($this->input->server('REQUEST_METHOD')=='POST')
		{
			//print_R($this->input->post());exit;
			if (!file_exists('upload')) 
				mkdir('upload', 0777, true);
			if(isset($_FILES["profile_photo"]["name"]) && $_FILES["profile_photo"]["name"])
			{
				
				$allowedExts = array("gif", "jpeg", "jpg", "png");
				$temp = explode(".", $_FILES["profile_photo"]["name"]);
				$extension = end($temp);
				
				if ((($_FILES["profile_photo"]["type"] == "image/gif")|| ($_FILES["profile_photo"]["type"] == "image/jpeg")
				|| ($_FILES["profile_photo"]["type"] == "image/jpg")|| ($_FILES["profile_photo"]["type"] == "image/pjpeg")
				|| ($_FILES["profile_photo"]["type"] == "image/x-png")|| ($_FILES["profile_photo"]["type"] == "image/png"))
				&& in_array($extension, $allowedExts))
				 {
						if ($_FILES["profile_photo"]["error"] > 0)
						  {
						  echo "Error: " . $_FILES["profile_photo"]["error"] . "<br>";
						  }
							else
						  { 
							
							move_uploaded_file($_FILES["profile_photo"]["tmp_name"],"upload/". $_FILES["profile_photo"]["name"]);
							$profile_photo="upload/" . $_FILES["profile_photo"]["name"];
							$this->db->query('update customer set photo="'.$profile_photo.'" where customer_id="'.$this->session->userdata('customer_id').'" ');
							redirect('profile/edit');
						  }
						  
				  }
				  else{
					  echo "Invalid profile photo File";
					  die();
					}
			}
			if($this->input->post('form_name')=='dispatcher')
			{
				$data=$this->input->post();
				
				$validCustomer=$this->customer_model->validate_customer($this->input->post());
					
				if(!$validCustomer)
				{
					$this->session->set_flashdata('errormsg', 'Invalid Password!');
					redirect('profile/edit#Dispatcher');
				}
					
				if(!isset($data['dispatcher_location']))
				{
					$this->session->set_flashdata('errormsg', 'Please Select any one Jurisdiction!');
					redirect('profile/edit#Dispatcher');
				}
				$data['dispatcher']=isset($data['dispatcher_location'])?'1' : '0';
				
				$dsp='';
				if(isset($data['dispatcher']))
				{
					$dsp='TDP'.$this->session->userdata('customer_id');
					foreach($data['dispatcher_location'] as $tf)
					{
						$dsp.=$tf[0];
					}
				}
				$this->db->query("update customer set dispatcher_id='".$dsp."', dispatcher ='".$data['dispatcher']."', dispatcher_location ='".json_encode($data['dispatcher_location'])."' where customer_id='".$this->session->userdata('customer_id')."'");
				$this->session->set_flashdata('success', 'Updated successfully!');
				redirect('profile#Dispatcher');
			}
			if($this->input->post('form_name')=='personal')
			{
				$this->form_validation->set_rules('first_name', 'First Name', 'required');
				$this->form_validation->set_rules('last_name', 'Last Category', 'required');
				if ($this->form_validation->run() == TRUE)
				{
					$validCustomer=$this->customer_model->validate_customer($this->input->post());
					if(!$validCustomer)
					{
						$this->session->set_flashdata('errormsg', 'Invalid Password!');
						redirect('profile/edit');
					}
					$fname=$this->input->post('first_name');
					$lname=$this->input->post('last_name');
					$email=$this->input->post('email');
					$address=$this->input->post('customer_add');
					$b_info=$this->input->post('business_info');
					$b_type=$this->input->post('business_type');
						
					$this->db->query('update customer set first_name="'.$fname.'",last_name="'.$lname.'",email="'.$email.'",customer_add="'.$address.'",business_info="'.$b_info.'",business_type="'.$b_type.'" where customer_id="'.$this->session->userdata('customer_id').'" ');
					$this->session->set_flashdata('success', 'Updated successfully!');
					redirect('profile');
				}
				else
				{
					redirect('profile/edit');
					
				}
			}
			elseif($this->input->post('form_name')=='bank')
			{
				$validCustomer=$this->customer_model->validate_customer($this->input->post());
				if(!$validCustomer)
				{
					$this->session->set_flashdata('errormsg', 'Invalid Password!');
					redirect('profile/edit');
				}
				$customer_id=$this->session->userdata('customer_id');
				$bank_ac=$this->input->post('bank_ac');
				$dr_cr_card=$this->input->post('dr_cr_card');
				$purpose_code=$this->input->post('purpose_code');
				$bank_ac_name=$this->input->post('bank_ac_name');
				$bank_ac_type=$this->input->post('bank_ac_type');
				$bank_ac_address1=$this->input->post('bank_ac_address1');
				$bank_name=$this->input->post('bank_name');
				$routing_no=$this->input->post('routing_no');
				$bank_country=$this->input->post('bank_country');
				$bank_ac_address2=$this->input->post('bank_ac_address2');
				$bank_address=$this->input->post('bank_address');
		
				
				$this->db->query('update customer set bank_ac="'.$bank_ac.'",dr_cr_card="'.$dr_cr_card.'",purpose_code="'.$purpose_code.'",`bank_ac_name` = "'.$bank_ac_name.'", `bank_ac_address1` = "'.$bank_ac_address1.'", `bank_name` = "'.$bank_name.'", `routing_no` = "'.$routing_no.'", `bank_address` = "'.$bank_address.'", `bank_country` = "'.$bank_country.'", `bank_ac_address2` = "'.$bank_ac_address2.'", `bank_ac_type` = "'.$bank_ac_type.'" where customer_id="'.$this->session->userdata('customer_id').'" ');
				$email=$this->paypal_model->getPaypalEmail($customer_id);
				
				if(isset($email[0]))
				{
					$this->paypal_model->updatePaypalEmail($customer_id,$this->input->post('paypal_email'));
				}
				else
				{
					$this->paypal_model->insertPaypalEmail($customer_id,$this->input->post('paypal_email'));
				}
				$this->session->set_flashdata('success', 'Bank Deteail successfully!');
				redirect('profile');
			}
			
			
			$this->form_validation->set_rules('first_name', 'First Name', 'required');
			$this->form_validation->set_rules('last_name', 'Last Category', 'required');
			$this->form_validation->set_rules('paypal_email', 'Paypal Email', 'required|valid_email');
		
			if ($this->form_validation->run() == TRUE)
			{
				$validCustomer=$this->customer_model->validate_customer($this->input->post());
				if(!$validCustomer)
				{
					$this->session->set_flashdata('message', 'Invalid Password!');
					redirect('profile/edit');
				}
				
				
				mkdir('upload', 0777, true);
				
				$profile_photo="0";
				if(!isset($_FILES["profile_photo"]["name"]))
				$profile_photo="";
				if(isset($_FILES["profile_photo"]["name"]) && $_FILES["profile_photo"]["name"])
				{
					$allowedExts = array("gif", "jpeg", "jpg", "png");
					$temp = explode(".", $_FILES["profile_photo"]["name"]);
					$extension = end($temp);
					
					if ((($_FILES["profile_photo"]["type"] == "image/gif")|| ($_FILES["profile_photo"]["type"] == "image/jpeg")
					|| ($_FILES["profile_photo"]["type"] == "image/jpg")|| ($_FILES["profile_photo"]["type"] == "image/pjpeg")
					|| ($_FILES["profile_photo"]["type"] == "image/x-png")|| ($_FILES["profile_photo"]["type"] == "image/png"))
					&& in_array($extension, $allowedExts))
					 {
							if ($_FILES["profile_photo"]["error"] > 0)
							  {
							  echo "Error: " . $_FILES["profile_photo"]["error"] . "<br>";
							  }
							else
							  { move_uploaded_file($_FILES["profile_photo"]["tmp_name"],
								"upload/" . $_FILES["profile_photo"]["name"]);
								$profile_photo="upload/" . $_FILES["profile_photo"]["name"];
							  }
							  
					  }
					  else{
						  echo "Invalid profile photo File";
						  die();
						}
				}
				$this->customer_model->editProfile($customer_id,$this->input->post(),$profile_photo);
				$email=$this->paypal_model->getPaypalEmail($customer_id);
				
				if(isset($email[0]))
				{
					$this->paypal_model->updatePaypalEmail($customer_id,$this->input->post('paypal_email'));
					$this->session->set_flashdata('success:paypal', 'Inserted successfully!');
				}
				else
				{
					$this->paypal_model->insertPaypalEmail($customer_id,$this->input->post('paypal_email'));
					$this->session->set_flashdata('success:paypal', 'Updated successfully!');
				}
				redirect("profile");
			}
		}
		$data['paypal_email']="";
		$key=$this->paypal_model->getPaypalEmail($customer_id);
		if(isset($key[0]))
		$data['paypal_email']=$key[0]['paypal_email'];
		$profile=$this->customer_model->get_customer($customer_id);
		$data['profile']=$profile[0];
		$data['edit']="allow";
		$data['customer_key']=$profile[0]['customer_unique_id'];
		foreach($this->currency() as $key => $cr)
		$data[$key]  = $cr;
		
		/* Kinnari */
		$this->load->model('customer_model');
		$data['phonecode']=$this->db->query('select iso,phonecode from country group by phonecode order by phonecode')->result_array(); 
		$data['country_code']=$this->db->query('select * from country')->result_array(); 
		$cust_detail=$this->customer_model->get_customer($customer_id); 
		$data['cust_detail']=$cust_detail;
		/* Kinnari */
		$this->load->view('header',$data);
		$this->load->view('profile_edit',$data);
		$this->load->view('footer',$data);
	}
	
	public function validate_password()
	{
		if($this->input->post('password') )
		{
			$data = $this->db->query('select * from customer where customer_id="'.$this->session->userdata('customer_id').'" and password = "'.md5($this->input->post('password')).'"  ')->result_array();
			if(count($data)>0)
			{
				echo "1";
			}
			else
			{
				echo "0";
			}
		}
		
	}
}?>
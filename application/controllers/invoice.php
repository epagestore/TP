<?php
class Invoice extends CI_Controller{
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url');	
		$this->load->library('session');
		$this->load->library('email');
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
			$this->session->set_userdata('currency_id',$currency_id);
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
		foreach($this->currency() as $key => $cr)
		$data[$key]  = $cr;
		$customer_id=$this->session->userdata('customer_id');
		/*$this->load->model('invoice_model');
		$msg_data=$this->invoice_model->getInvoice(1);
		print_r($msg_data['invoice'][0]);
		$this->load->view('invoice-letter', $msg_data['invoice'][0]);*/
		
		if($this->input->server('REQUEST_METHOD')=='POST')
		{
			
			$this->load->model('invoice_model');
			$this->form_validation->set_rules('send_to', 'Email ID','required|valid_email|callback_has_email[email]|xss_clean'); 
			 $this->form_validation->set_rules('due_date[]', 'Due Date', 'required|xss_clean'); 
			 $this->form_validation->set_rules('item_name[]', 'Item Name/ID', 'required|xss_clean'); 
			 $this->form_validation->set_rules('qty[]', 'item qty', 'required|xss_clean'); 
			 $this->form_validation->set_rules('unit_price[]', 'Unit Price', 'required|xss_clean'); 
			$this->form_validation->set_error_delimiters('<li class="error text-danger" style="color:#FE0A0A;">', '</li>');
			if($this->form_validation->run() != FALSE)
			{	
				if($this->input->post('send'))
				{	
					$invoice_id=$this->invoice_model->sendInvoice($customer_id,$this->input->post());
					$msg_data=$this->invoice_model->getInvoice($invoice_id);
					$headers  = 'MIME-Version: 1.0' . "\r\n";
					$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
					$headers .= 'From: Trustedpayer <info@trustedpayer.com>' . "\r\n";
					$message = $this->load->view('invoice-letter', $msg_data['invoice'][0], true);
					$flag=mail($this->input->post('send_to'), 'TrustedPayer Invoice', urldecode($message), $headers);
					
				}
				else if($this->input->post('save'))
				{
					$this->invoice_model->saveInvoice($customer_id,$this->input->post());
				}
				redirect('invoice/list_all');
			 }
		}
		$this->load->model('customer_model');
		$cust_details=$this->customer_model->get_customer($customer_id);
		$data['personal_details']=$cust_details[0];
		
		
		/* Kinnari */
		$this->load->model('customer_model');
		$cust_detail=$this->customer_model->get_customer($customer_id); 
		$data['cust_detail']=$cust_detail;
		/* Kinnari */
		$this->load->view('header',$data);
		$this->load->view('invoice',$data);
		$this->load->view('footer',$data);
	}
	public function has_email($str)
	{
		$d= $this->db->query("select * from customer where email='".$str."'")->num_rows();
		if($d)
		{
			
			return True;
		}
		else
		{
			$this->form_validation->set_message('has_email', 'This '.$str.' %s  is not register!');
			return False;
		}
	}
	public function list_all()
	{
		if(!$this->session->userdata('customer_id'))
		{
			redirect('home');
		}
		$data='';
		$customer_id=$this->session->userdata('customer_id');
		$this->load->model('invoice_model');
		$data['invoices']=$this->invoice_model->getInvoices($customer_id);
		foreach($this->currency() as $key => $cr)
		$data[$key]  = $cr;
		
		/* Kinnari */
		$this->load->model('customer_model');
		$cust_detail=$this->customer_model->get_customer($customer_id); 
		$data['cust_detail']=$cust_detail;
		/* Kinnari */
		$this->load->view('header',$data);
		$this->load->view('invoice_list',$data);
		$this->load->view('footer',$data);
	}
	public function view($invoice_id)
	{
		if(!$this->session->userdata('customer_id'))
		{
			redirect('home');
		}
		$data='';
		$customer_id=$this->session->userdata('customer_id');
		$this->load->model('invoice_model');
		
		if($this->input->post('send'))
		{
			$result=$this->invoice_model->getInvoice($invoice_id);
			$this->invoice_model->sendInvoiceNow($invoice_id);
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$headers .= 'From: Trustedpayer <info@trustedpayer.com>' . "\r\n";
			$message = $this->load->view('invoice-letter', $result['invoice'][0], true);
			
			$flag=mail($result['invoice'][0]['send_to'], 'TrustedPayer Invoice', urldecode($message), $headers);
		}
		$result=$this->invoice_model->getInvoice($invoice_id);
		$data['invoice']=$result['invoice'];
		$data['invoice_order']=$result['invoice_order'];
		foreach($this->currency() as $key => $cr)
		$data[$key]  = $cr;
		/* Kinnari */
		$this->load->model('customer_model');
		$cust_detail=$this->customer_model->get_customer($customer_id); 
		$data['cust_detail']=$cust_detail;
		/* Kinnari */
		$this->load->view('header',$data);
		$this->load->view('invoice_view',$data);
		$this->load->view('footer',$data);
	}
	public function view_frame($invoice_id)
	{
		if(!$this->session->userdata('customer_id'))
		{
			redirect('home');
		}
		$data='';
		$customer_id=$this->session->userdata('customer_id');
		$this->load->model('invoice_model');
		
		if($this->input->post('send'))
		{
			$result=$this->invoice_model->getInvoice($invoice_id);
			$this->invoice_model->sendInvoiceNow($invoice_id);
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$headers .= 'From: Trustedpayer <info@trustedpayer.com>' . "\r\n";
			$message = $this->load->view('invoice-letter', $result['invoice'][0], true);
			
			$flag=mail($result['invoice'][0]['send_to'], 'TrustedPayer Invoice', urldecode($message), $headers);
		}
		foreach($this->currency() as $key => $cr)
		$data[$key]  = $cr;
		$result=$this->invoice_model->getInvoice($invoice_id);
		$data['invoice']=$result['invoice'];
		$data['invoice_order']=$result['invoice_order'];
		//$this->load->view('header',$data);
		$this->load->view('invoice_view_frame',$data);
		//$this->load->view('footer',$data);
	}
	public function api_invoice($invoice_id,$customer_id)
	{
		
		$data='';
		
		$this->load->model('invoice_model');
		
		if($this->input->post('send'))
		{
			$result=$this->invoice_model->getInvoice($invoice_id);
			$this->invoice_model->sendInvoiceNow($invoice_id);
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$headers .= 'From: Trustedpayer <info@trustedpayer.com>' . "\r\n";
			$message = $this->load->view('invoice-letter', $result['invoice'][0], true);
			
			$flag=mail($result['invoice'][0]['send_to'], 'TrustedPayer Invoice', urldecode($message), $headers);
		}
		foreach($this->currency() as $key => $cr)
		$data[$key]  = $cr;
		$result=$this->invoice_model->getInvoice($invoice_id);
		$data['invoice']=$result['invoice'];
		$data['invoice_order']=$result['invoice_order'];
		if($result['invoice'][0]['customer_id']!=$customer_id)
		echo stripslashes(json_encode(array("status"=>"failed","msg"=>"Invalid")));
		else
		$this->load->view('invoice_view_frame',$data);
		//$this->load->view('footer',$data);
	}
	public function send_now($invoice_id)
	{
		if(!$this->session->userdata('customer_id'))
		{
			redirect('home');
		}
		$data='';
		$customer_id=$this->session->userdata('customer_id');
		$this->load->model('invoice_model');
		foreach($this->currency() as $key => $cr)
		$data[$key]  = $cr;
		$result=$this->invoice_model->getInvoice($invoice_id);
		$this->invoice_model->sendInvoiceNow($invoice_id);
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'From: Trustedpayer <info@trustedpayer.com>' . "\r\n";
		$message = $this->load->view('invoice-letter', $result['invoice'][0], true);
		
		$flag=mail($result['invoice'][0]['send_to'], 'TrustedPayer Invoice', urldecode($message), $headers);
		echo $this->load->view('invoice-letter', $result['invoice'][0], true); exit;
		redirect('invoice/list_all');
	}
	public function trusted_pay($key)
	{	
		if(!$this->session->userdata('customer_id'))
		{
			redirect('home?redirect=invoice/trusted_pay/'.$key);
		}
		$this->load->model('invoice_model');
		$this->load->model('balance_manager_model');
		$this->load->model('customer_model');
		
		$customer_id=$this->session->userdata('customer_id');		
		
		$cust_detail=$this->customer_model->get_customer($customer_id); 
		$data['cust_detail']=$cust_detail;
		$result=$this->invoice_model->getInvoiceByKey($key);
		$result=$result['invoice'];
		$key1=$key;
		foreach($this->currency() as $key => $cr)
		$data[$key]  = $cr;
		
		$user=$cust_detail;
		if($result[0]['status']=='2')
		{
			if(strtolower($user[0]['email'])!=strtolower($result[0]['send_to']))
			{
				$this->session->set_flashdata('errormsg',"Invalid User login,Please Login with valid account!");
				$data['page']="You have not allow access this Invoice payment ,<br /> Please Logout & Login with valid account!";
			}else{
				
				$deduct = $this->balance_manager_model->deduct_transferAmount($customer_id,array('amount'=>$result[0]['total']),$result[0]['invoice_id']);
				if($deduct)
				{
					$this->invoice_model->payInvoice($result[0]['invoice_id']);
					$this->session->set_flashdata('success',"Your Invoice payment transaction has been successful!");
					redirect('invoice/pay/'.$key1."?success");
				}else{
					$this->session->set_flashdata('errormsg',"Your account has been insufficient balance! Please add amount in your main account.!");
					$data['page']="Your account has been insufficient balance! Please add amount in your main account.";
				}
			}		
		}else{
			redirect('invoice/pay/'.$key1);
		}		
		$this->load->view('header',$data);
		$this->load->view('trusted_pay',$data);
		$this->load->view('footer',$data);
	}
	public function pay($key)
	{
		$data='';
		$data['redirect']="";
		$this->load->model('invoice_model');
		$result=$this->invoice_model->getInvoiceByKey($key);
		$data['invoice']=$result['invoice'];
		$data['invoice_order']=$result['invoice_order'];

		if($this->input->server('REQUEST_METHOD')=='POST')
		{
		
			if($this->input->post('pay'))
			{
					$ch = curl_init();
					$clientId = "AST0bRAWCHvGi_XyLdniDdKDkuaBznaJsDZUtqLQvo4Qyngty55AMRhtMH3n";
					$secret = "EJsqmBAQTR_vni8vmrtXFFtu_IYnRxxJ_xK816faVzxQL37m6O5mHFGkYjVh";
					
					
					$ch = curl_init();
					$amount=round($data['invoice'][0]['total'],2);
					$data =array ( "USER" => "ceo-facilitator_api1.udsltdonline.com",
									"PWD" => "1391241086",
									"SIGNATURE" => "AFcWxV21C7fd0v3bYYYRCpSSRl31A9Wc67aYWxrbF91NxP3GmkejgqLD",
									"METHOD" => "SetExpressCheckout",
									"RETURNURL" => base_url()."index.php/paypal_invoice_notification",
									"CANCELURL" => base_url()."index.php/invoice/pay/".$key,
									"VERSION" => "93",
																		
									"PAYMENTREQUEST_0_CURRENCYCODE" => "USD",
									"PAYMENTREQUEST_0_AMT" => $amount,
									"PAYMENTREQUEST_0_ITEMAMT" => $amount,
									"PAYMENTREQUEST_0_SHIPPINGAMT" => "0",
									"PAYMENTREQUEST_0_HANDLINGAMT" => "0",
									"PAYMENTREQUEST_0_TAXAMT" => "0",
									"PAYMENTREQUEST_0_DESC" => "Transfer Money to ".$data['invoice'][0]['company_name']." Account :$".$amount,
									"PAYMENTREQUEST_0_INSURANCEAMT" => "0",
									"PAYMENTREQUEST_0_SHIPDISCAMT" => "0",
									"PAYMENTREQUEST_0_SELLERPAYPALACCOUNTID" => "hitesh251086@gmail.com",
									"PAYMENTREQUEST_0_INSURANCEOPTIONOFFERED" => "false",
									"PAYMENTREQUEST_0_PAYMENTACTION" => "Sale",
									"PAYMENTREQUEST_0_PAYMENTREQUESTID" => "Transfer_".$data['invoice'][0]['invoice_id']
									
									
									
									 );
					$data=http_build_query($data);
					
					curl_setopt($ch, CURLOPT_URL, "https://api-3t.sandbox.paypal.com/nvp");
					curl_setopt($ch, CURLOPT_HEADER, false);
					curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
					curl_setopt($ch, CURLOPT_POST, true);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
					curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
					
					$result = curl_exec($ch);
					if(empty($result))die("Error: No response.");
					else
					{
						 parse_str(urldecode($result),$output);
						
						 header("LOCATION: https://www.sandbox.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token=".$output['TOKEN']);
						
					}
					curl_close($ch);
			}
			else if($this->input->post('send'))
			{
				$invoice_id=$data['invoice'][0]['invoice_id'];
				$this->invoice_model->sendInvoiceNow($invoice_id);
				$msg_data=$this->invoice_model->getInvoice($invoice_id);
				$headers  = 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
				$headers .= 'From: Trustedpayer <info@trustedpayer.com>' . "\r\n";
				$message = $this->load->view('invoice-letter', $msg_data['invoice'][0], true);
				$flag=mail($this->input->post('send_to'), 'TrustedPayer Invoice', urldecode($message), $headers);
			}
		}
		$data['key1']=$key;
			foreach($this->currency() as $key => $cr)
		$data[$key]  = $cr;
		
		//$this->load->view('header',$data);
		$this->load->view('pay_invoice',$data);
		//$this->load->view('footer',$data);
	}
	public function pdf_export($invoice_id)
	{
		if(!$this->session->userdata('customer_id'))
		{
			redirect('home');
		}
		$data='';
		$customer_id=$this->session->userdata('customer_id');
		$this->load->model('invoice_model');
		$result=$this->invoice_model->getInvoice($invoice_id);
		$data['invoice']=$result['invoice'];
		$data['invoice_order']=$result['invoice_order'];
		
		
		$filename='abcd';
		
		ini_set('memory_limit','300M'); // boost the memory limit if it's low <img src="http://davidsimpson.me/wp-includes/images/smilies/icon_wink.gif" alt=";)" class="wp-smiley"> 
		
		$filename ="InvoiceReport.pdf";
		foreach($this->currency() as $key => $cr)
		$data[$key]  = $cr;		
		$html =$this->load->view('invoice_view_frame',$data, true); // render the view into HTML
			
			 
		$this->load->library('pdf');
		$pdf = $this->pdf->load(); 
		$pdf->SetFooter($_SERVER['HTTP_HOST'].'|{PAGENO}|'.date(DATE_RFC822)); // Add a footer for good measure <img src="http://davidsimpson.me/wp-includes/images/smilies/icon_wink.gif" alt=";)" class="wp-smiley"> 
		$pdf->WriteHTML($html); // write the HTML into the PDF
		$pdf->output($filename,'D');
			
	}
}?>
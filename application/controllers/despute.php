<?php
class Despute extends CI_Controller{
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
		$this->load->library('encrypt');
		$this->load->model('despute_model');
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
		
		$customer_id=$this->session->userdata('customer_id');
		$data="";
		$this->load->model('order_model');
		if($this->input->server('REQUEST_METHOD')=='POST')
		{
			//print_r($this->input->post());exit;
			
			$attachment=0;
			if(isset($_FILES["attachment"]["name"]) && $_FILES["attachment"]["name"])
			{
				$allowedExts = array("gif", "jpeg", "jpg", "png");
				$temp = explode(".", $_FILES["attachment"]["name"]);
				$extension = end($temp);
				 {
						if ($_FILES["attachment"]["error"] > 0)
						  {
						  echo "Error: " . $_FILES["attachment"]["error"] . "<br>";
						  }
						else
						  {
						   move_uploaded_file($_FILES["attachment"]["tmp_name"],
							"upload/" . $_FILES["attachment"]["name"]);
							$attachment="upload/" . $_FILES["attachment"]["name"];
						  }
						  
				  }
			}
			//$orders= json_decode(urldecode($this->encrypt->decode($this->input->post('key'))),true);
			$txn_id=$this->input->post('key');
			$order=$this->order_model->getTransactionOrderProduct($txn_id);
			if($order[0]['order_product_status_id']==5)
			$pre_delivery=0;
			else
			$pre_delivery=1;
			if($customer_id==$order[0]['payer_id'])
			{
				$milestone_id='';
				$product_total= $order[0]['product_total'];
				if(isset($order[0]['is_milestone'])&&$order[0]['is_milestone']==1)
				{
					$product_total=$order[0]['amount'];
					$milestone_id=$order[0]['milestone_id'];
				}	
				$despute_id=$this->despute_model->insertDespute($pre_delivery,$this->input->post(),$attachment,$customer_id,$order[0]['payee_id'],$customer_id,$product_total,$milestone_id);
			}else if($customer_id==$order[0]['payee_id']){
				
				$milestone_id='';				
				if(isset($order[0]['is_milestone'])&&$order[0]['is_milestone']==1)
				{					
					$milestone_id=$order[0]['milestone_id'];
				}	
				
				$despute_id=$this->despute_model->insertDespute($pre_delivery,$this->input->post(),$attachment,$order[0]['payer_id'],$customer_id,$customer_id,$milestone_id);
			}
			
			
			$despute=$this->despute_model->getDespute($despute_id);
			
			$this->load->model('message_model');
			if($this->input->post('cont_prev_desp'))
			{
				$despute_exist=$this->despute_model->getDespute('',$order[0]['order_product_id']);
				$despute_exist_message=$this->message_model->getMessages($despute_exist[0]['despute_id']);
				foreach($despute_exist_message as $msg)
				{
					$this->message_model->sendMessage($msg['payer_id'],$msg['payee_id'],$msg['sender_id'],$despute_id,$msg['message_body'],$msg['added_on']);
				}
			}
			$this->message_model->sendMessage($despute[0]['payer_id'],$despute[0]['payee_id'],$customer_id,$despute_id,$this->input->post('despute_desc'));
			
			$opts = array('http'=>array('header' => "User-Agent:MyAgent/1.0\r\n"));
			$context = stream_context_create($opts);
			//file_get_contents($orders['sucess_redirect_url'].'?txn=1&status=sucess&order_status=despute&txn_id='.$orders['txn_id'],false,$context);
			//file_get_contents($orders['sucess_redirect_url'].'?txn=1&status=sucess&order_status=despute&txn_id[0]='.$orders['txn_id']."&product_key[0]=".$orders['product_id'],false,$context);
			redirect('despute/negotiate/'.$despute_id);
		}
		
		$this->load->model('customer_model');
		//$orders= json_decode(urldecode($this->encrypt->decode($_GET['id'])),true);
		$txn_id=$_GET['txn_id'];
		$order=$this->order_model->getTransactionOrderProduct($txn_id);
		
		//$order=$this->order_model->getTransactionMilestone($txn_id);
		$payee=$this->customer_model->get_customer($order[0]['payee_id']);
		$payer=$this->customer_model->get_customer($order[0]['payer_id']);	
		$data['despute_exist']=0;	
		
		$despute_exist=$this->despute_model->getDespute('',$order[0]['order_product_id']);	
	
		if(isset($despute_exist[0]) && $despute_exist[0]['order_product_status_id']!=5)
		{
			//redirect('despute/negotiate/'.$despute_exist[0]['despute_id']);
			$data['despute_exist']=1;
		}
		
		$data['key']=$_GET['txn_id'];		
		if($customer_id==$order[0]['payer_id'])
		{
			$data['order_product_id']=$order[0]['order_product_id'];
			$data['product_name']=$order[0]['product_name'];
			if(isset($order[0]['is_milestone'])&&$order[0]['is_milestone']==1)
			$data['amount']=$order[0]['amount'];
			else
			$data['amount']=$order[0]['product_total'];
			$data['payee_name']=$payee[0]['first_name']." ".$payee[0]['last_name'];
			$data['payer']=1;
		}else if($customer_id==$order[0]['payee_id']){
			$data['order_product_id']=$order[0]['order_product_id'];
			$data['product_name']=$order[0]['product_name'];
			if(isset($order[0]['is_milestone'])&&$order[0]['is_milestone']==1)
			$data['amount']=$order[0]['amount'];
			else
			$data['amount']=$order[0]['product_total'];
			$data['payer_name']=$payer[0]['first_name']." ".$payer[0]['last_name'];
			$data['payee']=1;
		}
		else
		echo "Login from wrong Account ";
		
		if($order[0]['order_product_status_id']==5)
		{
			$data['pre_delivery']=0;
			$data['despute_reasons']=$this->despute_model->getDesputeReason($data['pre_delivery']);
		}
		else
		{
			$data['pre_delivery']=1;
			$data['despute_reasons']=$this->despute_model->getDesputeReason($data['pre_delivery']);
		}
		
		$data['remedy_discounts']=$this->despute_model->getRemedyDiscount();
		$data['remedy_replacements']=$this->despute_model->getRemedyReplacement();
		$data['remedy_cancelations']=$this->despute_model->getRemedyCancelation();
		
		$order_id=$order[0]['order_id'];
		$data['order_id']=$order_id;
		$data['txn_id']=$_GET['txn_id'];
		//$data['cancle']=$orders['cancel_redirect_url'];
		//$data['sucess']=$orders['sucess_redirect_url'];
		foreach($this->currency() as $key => $cr)
		$data[$key]  = $cr;
		
		/* Kinnari */
		$this->load->model('customer_model');
		$cust_detail=$this->customer_model->get_customer($customer_id); 
		$data['cust_detail']=$cust_detail;
		/* Kinnari */
		$this->load->view('header',$data);
		$this->load->view('despute',$data);
		$this->load->view('footer',$data);
	}
	public function closeDespute($despute_id)
	{
		$this->despute_model->closeDespute($despute_id);
		redirect('despute/negotiate/'.$despute_id);
	}
	public function acceptOffer($despute_id)
	{
		$this->despute_model->acceptOffer($despute_id);
		redirect('despute/negotiate/'.$despute_id);
	}
	public function negotiate($despute_id)
	{
		
		$data="";
		foreach($this->currency() as $key => $cr)
		$data[$key]  = $cr;
		$customer_id=$this->session->userdata('customer_id');
		$despute=$this->despute_model->getDespute($despute_id);
		
		$amount_p=0;
		if(!isset($despute[0]))
		redirect("/despute/generate_list");
		
		if($this->input->server('REQUEST_METHOD')=='POST')
		{
			
			$currnt_currency = $this->session->userdata('current_currency');
			
			
			if($this->input->post('pay_amount'))
			{
				$amount_p=$this->input->post('pay_amount');
				if(($despute[0]['remedy']=='Discount' && $despute[0]['payee_amount']<=$this->input->post('pay_amount')) || ($despute[0]['remedy']!='Discount' && $despute[0]['payee_amount']==$this->input->post('pay_amount')))
				{
					
					$this->despute_model->finalDesputePayer($despute_id,$this->input->post());
				}
				else
				$this->despute_model->updateDesputePayer($despute_id,$this->input->post());
			}
			else if($this->input->post('receive_amount'))
			{
				if($this->session->userdata('current_currency'))
					$_POST['receive_amount'] = round($this->input->post('receive_amount')/$currnt_currency['value']);
				
				//$_POST['receive_amount'] = round($this->input->post('receive_amount')/$currnt_currency['value']);
				$amount_p=$this->input->post('receive_amount');
				if(($despute[0]['remedy']=='Discount' && $despute[0]['payer_amount']>=$this->input->post('receive_amount')) || ($despute[0]['remedy']!='Discount' && $despute[0]['payer_amount']==$this->input->post('receive_amount')))
				{
					$this->despute_model->finalDesputePayee($despute_id,$this->input->post());
				}
				else
				$this->despute_model->updateDesputePayee($despute_id,$this->input->post());
			}
			
		$this->load->model('message_model');
		$message=$this->message_model->sendMessage($despute[0]['payer_id'],$despute[0]['payee_id'],$customer_id,$despute_id,'Amount has been updated to $'.$amount_p.' .');
		
			redirect('despute/negotiate/'.$despute_id);
		}
		
		$data['despute']=$despute[0];
		
		if($despute[0]['pre_delivery']==1)
		$future_datetime =date('Y-m-d H:i:s', strtotime('+4 day', strtotime($despute[0]['despute_date_added'])));
		else
		$future_datetime =date('Y-m-d H:i:s', strtotime('+1 day', strtotime($despute[0]['despute_date_added'])));
		//$future_datetime=$despute[0]['despute_date_added'];
		$future = strtotime($future_datetime); //future datetime in seconds
		$now_datetime = $despute[0]['now'];
		$now = strtotime($now_datetime); //now datetime in seconds
		$data['future_datetime']=$future_datetime;
		$data['now_datetime']=$now_datetime;
		//The math for calculating the difference in hours, minutes and seconds
		$difference = $future - $now;
		$second = 1;
		$minute = 60 * $second;
		$hour = 60 * $minute;
		$difference_hours = floor($difference/$hour);
		$remainder = $difference - ($difference_hours * $hour);
		$difference_minutes = floor($remainder/$minute);
		$remainder = $remainder - ($difference_minutes * $minute);
		$difference_seconds = $remainder;
		
		//echo "<br>$difference_hours hours, $difference_minutes min and $difference_seconds sec";
		if($despute[0]['despute_status']!='1')
		redirect("/despute/final_offer/".$despute_id);
		
		if($difference_hours<0)
		{
			//echo $difference_hours;
			$this->despute_model->closeDespute($despute_id);
			redirect("/despute/final_offer/".$despute_id);
		}
		
		
		
		if($data['despute']['payer_id']==$customer_id)
		{
			$data['payer']=1;
			
		}
		else if($data['despute']['payee_id']==$customer_id)
		{
			$data['payee']=1;
		}
		else
		{
			redirect("/despute/receive_list");
		}
		if($data['despute']['generate_by']==$customer_id)
			{
				$data['own_despute']=1;
			}
			//print_r($data['despute']);
		$data['remedy_discounts']=$this->despute_model->getRemedyDiscount();
		$data['remedy_replacements']=$this->despute_model->getRemedyReplacement();
		$data['remedy_cancelations']=$this->despute_model->getRemedyCancelation();
		$this->load->model('message_model');
		$data['messages']=$this->message_model->getMessages($despute_id);
		
		/* Kinnari */
		$this->load->model('customer_model');
		$cust_detail=$this->customer_model->get_customer($customer_id); 
		$data['cust_detail']=$cust_detail;
		/* Kinnari */
		$this->load->view('header',$data);
		$this->load->view('despute_negotiation',$data);
		$this->load->view('footer',$data);
	}
	public function final_offer($despute_id)
	{
		$data="";
		$customer_id=$this->session->userdata('customer_id');
		$despute=$this->despute_model->getDespute($despute_id);
		
		/* print_r($despute); 
		exit;  */
		if(!isset($despute[0]))
		redirect("/despute/generate_list");
		$data['despute']=$despute[0];
		
		if($data['despute']['payer_id']==$customer_id)
		{
			$data['payer']=1;
			$data['key_exist']=$this->despute_model->checkPayer($customer_id,$despute[0]['order_product_id'],$despute[0]['milestone_id']);
			$data['key_complete']=$this->despute_model->checkPayee($data['despute']['payee_id'],$despute[0]['order_product_id'],$despute[0]['milestone_id']); 
		}
		else if($data['despute']['payee_id']==$customer_id)
		{
			$data['payee']=1;
			$data['key_exist']=$this->despute_model->checkPayee($customer_id,$despute[0]['order_product_id'],$despute[0]['milestone_id']);
			$data['key_complete']=$this->despute_model->checkPayer($data['despute']['payer_id'],$despute[0]['order_product_id'],$despute[0]['milestone_id']);
		}
		else
		{
			redirect("/despute/receive_list");
		}
		if($data['despute']['generate_by']==$customer_id)
		{
			$data['own_despute']=1;
		}
		
		if($this->input->server('REQUEST_METHOD')=='POST')
		{
			$this->load->model('order_model');
			if($data['despute']['payer_id']==$customer_id)
			{	
				if($despute[0]['milestone_id'])
				$valid=$this->order_model->validateMilestoneKey($customer_id,$despute[0]['milestone_id'],$this->input->post());	
				else
				$valid=$this->order_model->validateOrderProductKey($customer_id,$this->input->post('order_product_id'),$this->input->post());
			}
			else if($data['despute']['payee_id']==$customer_id)
			{
				
				if($despute[0]['milestone_id'])
					$valid=$this->order_model->validateMilestoneKey('',$despute[0]['milestone_id'],$this->input->post(),$customer_id);
				else
				$valid=$this->order_model->validateOrderProductKey('',$this->input->post('order_product_id'),$this->input->post(),$customer_id);
			}
			
			if(isset($valid[0]))
			{
				if($customer_id==$data['despute']['payer_id'])
				{
					if(!$despute[0]['milestone_id'])
					$this->order_model->insertProductOrderKey($customer_id,$this->input->post('order_id'),$this->input->post('order_product_id'),$this->input->post());
					else
					{
						$mle = $this->despute_model->mileston_data($despute[0]['milestone_id']);
						$this->order_model->insertOrderKey($customer_id,$this->input->post('order_id'),$despute[0]['milestone_id'],$this->input->post(),$mle[0]['payee_id']);
					}	
					
					
				}
				else if($data['despute']['payee_id']==$customer_id)
				{
					if(!$despute[0]['milestone_id'])
					$this->order_model->insertProductOrderKey('',$this->input->post('order_id'),$this->input->post('order_product_id'),$this->input->post(),$customer_id);
					else
					{	
					$mle = $this->despute_model->mileston_data($despute[0]['milestone_id']);
					$this->order_model->insertOrderKey($mle[0]['payer_id'],$this->input->post('order_id'),$despute[0]['milestone_id'],$this->input->post(),$customer_id);
					}
				}
				if($despute[0]['milestone_id'])
				$this->despute_model->completeMilestoneOrder($despute[0]['milestone_id']);
				else
				$this->despute_model->completeProductOrder($this->input->post('order_product_id'));
				
			}
			else
			{
				$this->session->set_flashdata('message', 'Invalid Key!');
				
			}
			redirect('despute/final_offer/'.$despute_id);
			//$this->despute_model->completeOrderProduct($despute_id);
		}
		
		if($despute[0]['despute_status']=='3' )
		$data['despute_resolved']=1;
		else if($despute[0]['despute_status']=='4')
		$data['despute_resolved']=2;
		else if($despute[0]['despute_status']!='2')
		redirect('despute/negotiate/'.$despute_id);
		
		$this->load->model('message_model');
		$data['messages']=$this->message_model->getMessages($despute_id);
		foreach($this->currency() as $key => $cr)
		$data[$key]  = $cr;
		
		/* Kinnari */
		$this->load->model('customer_model');
		$cust_detail=$this->customer_model->get_customer($customer_id); 
		$data['cust_detail']=$cust_detail;
		/* Kinnari */
		$this->load->view('header',$data);
		$this->load->view('despute_final_offer',$data);
		$this->load->view('footer',$data);
	}
	public function receive_list()
	{
		$customer_id=$this->session->userdata('customer_id');
		$data['desputes']=$this->despute_model->getDesputeReceiveList($customer_id);
		/*print_r($data['desputes'][0]);
		die();*/
		foreach($data['desputes'] as $despute)
		{
			if($despute['status']=='1')
			{
				if($despute['pre_delivery']==1)
				$future_datetime =date('Y-m-d H:i:s', strtotime('+4 day', strtotime($despute['date_added'])));
				else
				$future_datetime =date('Y-m-d H:i:s', strtotime('+1 day', strtotime($despute['date_added'])));
				//$future_datetime=$despute[0]['despute_date_added'];
				$future = strtotime($future_datetime); //future datetime in seconds
				$now_datetime = $despute['now'];
				$now = strtotime($now_datetime); //now datetime in seconds
				$data['future_datetime']=$future_datetime;
				$data['now_datetime']=$now_datetime;
				//The math for calculating the difference in hours, minutes and seconds
				$difference = $future - $now;
				$second = 1;
				$minute = 60 * $second;
				$hour = 60 * $minute;
				$difference_hours = floor($difference/$hour);
				$remainder = $difference - ($difference_hours * $hour);
				$difference_minutes = floor($remainder/$minute);
				$remainder = $remainder - ($difference_minutes * $minute);
				$difference_seconds = $remainder;
				
				if($difference_hours<0)
				{
					$this->despute_model->closeDespute($despute['despute_id']);
				}
			}
		}
		$data['desputes']=$this->despute_model->getDesputeReceiveList($customer_id);
		$data['heading']='DISPUTE RECEIVED,';
		foreach($this->currency() as $key => $cr)
		$data[$key]  = $cr;
		
		/* Kinnari */
		$this->load->model('customer_model');
		$cust_detail=$this->customer_model->get_customer($customer_id); 
		$data['cust_detail']=$cust_detail;
		/* Kinnari */
		$this->load->view('header',$data);
		$this->load->view('despute_list',$data);
		$this->load->view('footer',$data);
	}
	public function generate_list()
	{
		$customer_id=$this->session->userdata('customer_id');
		$data['desputes']=$this->despute_model->getDesputeGenerateList($customer_id);
		foreach($data['desputes'] as $despute)
		{
			if($despute['status']=='1')
			{
				if($despute['pre_delivery']==1)
				$future_datetime =date('Y-m-d H:i:s', strtotime('+4 day', strtotime($despute['date_added'])));
				else
				$future_datetime =date('Y-m-d H:i:s', strtotime('+1 day', strtotime($despute['date_added'])));
				//$future_datetime=$despute[0]['despute_date_added'];
				$future = strtotime($future_datetime); //future datetime in seconds
				$now_datetime = $despute['now'];
				$now = strtotime($now_datetime); //now datetime in seconds
				$data['future_datetime']=$future_datetime;
				$data['now_datetime']=$now_datetime;
				//The math for calculating the difference in hours, minutes and seconds
				$difference = $future - $now;
				$second = 1;
				$minute = 60 * $second;
				$hour = 60 * $minute;
				$difference_hours = floor($difference/$hour);
				$remainder = $difference - ($difference_hours * $hour);
				$difference_minutes = floor($remainder/$minute);
				$remainder = $remainder - ($difference_minutes * $minute);
				$difference_seconds = $remainder;
				
				if($difference_hours<0)
				{
					$this->despute_model->closeDespute($despute['despute_id']);
				}
			}
		}
		$data['desputes']=$this->despute_model->getDesputeGenerateList($customer_id);
		$data['heading']='DISPUTE GENERATED,';
		foreach($this->currency() as $key => $cr)
		$data[$key]  = $cr;
		
		/* Kinnari */
		$this->load->model('customer_model');
		$cust_detail=$this->customer_model->get_customer($customer_id); 
		$data['cust_detail']=$cust_detail;
		/* Kinnari */
		
		$this->load->view('header',$data);
		$this->load->view('despute_list',$data);
		$this->load->view('footer',$data);
	}
	public function regenrate_despute($despute_id)
	{
		$customer_id=$this->session->userdata('customer_id');
		$data['desputes']=$this->despute_model->regenrateDespute($despute_id);
		redirect('despute/negotiate/'.$despute_id);
	}
	public function sendReply($despute_id,$message)
	{
		$this->load->model('message_model');
		$customer_id=$this->session->userdata('customer_id');
		$despute=$this->despute_model->getDespute($despute_id);
		$message=$this->message_model->sendMessage($despute[0]['payer_id'],$despute[0]['payee_id'],$customer_id,$despute_id,urldecode($message));
		$this->load->model('message_model');
		$messages=$this->message_model->getMessages($despute_id);
		echo json_encode(array("result"=>$messages));
	}
	public function loadMessage($despute_id)
	{
		$this->load->model('message_model');
		$despute=$this->despute_model->getDespute($despute_id);
		$messages=$this->message_model->getMessages($despute_id);
		echo json_encode(array("result"=>$messages,"payer_amount"=>$despute[0]['payer_amount'],"payee_amount"=>$despute[0]['payee_amount'],"dispute_status"=>$despute[0]['despute_status']));
		
	}}?>
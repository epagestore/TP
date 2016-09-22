<?php
header('HTTP/1.1 200 OK'); 
class Paypal_notification extends CI_Controller{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->helper('url');
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
		foreach($this->currency() as $key => $cr)
		$data[$key]  = $cr;
		
		if(isset($_GET['PayerID']))
		{
			
			$payer_id = $_GET['PayerID'];
			$token=$_GET['token'];
			//print_r($headers);
			$ch = curl_init();
			
			curl_setopt($ch, CURLOPT_URL, "https://api-3t.sandbox.paypal.com/nvp");
			curl_setopt($ch, CURLOPT_HEADER, false);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
			/*curl_setopt($ch, CURLOPT_HTTPHEADER, array(
						'Authorization: Bearer '.$token,
						'Accept: application/json',
						'Content-Type: application/json'
						));*/
			curl_setopt($ch, CURLOPT_POSTFIELDS, "USER=ceo-facilitator_api1.udsltdonline.com&PWD=1391241086&SIGNATURE=AFcWxV21C7fd0v3bYYYRCpSSRl31A9Wc67aYWxrbF91NxP3GmkejgqLD&METHOD=GetExpressCheckoutDetails&VERSION=93&TOKEN=".$token);
			
			$result = curl_exec($ch);
			$output="";
			parse_str($result,$output);
			//print_r($output);
			if(empty($result)){ echo "<br>".$result."<br>"; die("Error: No response1.");}
			else
			{
				//$json = $result;
				//echo urldecode($result);
				
				parse_str(urldecode($result),$output);
			}
			
			curl_close($ch);
			$append='';
			if($output['ACK']=="Success")
			{
					
				$append.="&PAYMENTREQUEST_0_AMT=".$output['PAYMENTREQUEST_0_AMT']."&PAYMENTREQUEST_0_CURRENCYCODE=USD&PAYMENTREQUEST_0_SELLERPAYPALACCOUNTID=".$output['PAYMENTREQUEST_0_SELLERPAYPALACCOUNTID']."&PAYMENTREQUEST_0_PAYMENTREQUESTID=".$output['PAYMENTREQUEST_0_PAYMENTREQUESTID'];
				
				
				$token=$_GET['token'];
				//print_r($headers);
				$ch = curl_init();
				
				curl_setopt($ch, CURLOPT_URL, "https://api-3t.sandbox.paypal.com/nvp");
				curl_setopt($ch, CURLOPT_HEADER, false);
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
				curl_setopt($ch, CURLOPT_POST, true);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
				/*curl_setopt($ch, CURLOPT_HTTPHEADER, array(
							'Authorization: Bearer '.$token,
							'Accept: application/json',
							'Content-Type: application/json'
							));*/
				curl_setopt($ch, CURLOPT_POSTFIELDS, "USER=ceo-facilitator_api1.udsltdonline.com&PWD=1391241086&SIGNATURE=AFcWxV21C7fd0v3bYYYRCpSSRl31A9Wc67aYWxrbF91NxP3GmkejgqLD&METHOD=DoExpressCheckoutPayment&VERSION=93&TOKEN=".$token."&PAYERID=".$payer_id.$append);	
				$result1 = curl_exec($ch);
				parse_str($result1,$output1);
				//print_r($output1);
				if(empty($result1)){ echo "<br>".$result1."<br>"; die("Error: No response1.");}
				else
				{
					//print_r($output1);
					//echo urldecode($result);
					$customer_id=str_replace('Transfer_','',$output['PAYMENTREQUEST_0_PAYMENTREQUESTID']);
					//echo $customer_id;
				//die();
					//$json = $result;
					//echo stripslashes($result1);
				//$customer_id=str_repeat('Transfer_','',$output['PAYMENTREQUEST_0_PAYMENTREQUESTID']);
						$this->load->model('balance_manager_model');
						
							if($output1['PAYMENTINFO_0_ERRORCODE']=="0" && $output1['PAYMENTINFO_0_ACK']=="Success")
							{
								$this->balance_manager_model->transferAmount($customer_id,array('amount'=>$output1['PAYMENTINFO_0_AMT']));
								redirect('dashboard');
							}
							else{
								echo "error";
							}
				}
			}
			else
			{
				
				print_r($output);
				die();
			}
			redirect('dashboard');
		}
		else
		{
			echo "error: something goes wrong";
		}
	}
}?>
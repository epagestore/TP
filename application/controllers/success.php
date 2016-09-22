<?php
header('HTTP/1.1 200 OK'); 
class success extends CI_Controller{
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
		if(isset($_REQUEST['OrderID']) && isset($_REQUEST['TransactionReference'])){
                 $order_id = $_REQUEST['OrderID'];
                // $order_ref =$_REQUEST['TransactionReference'];
           

                    $merchant_id ="00011";
                    $request="MERCHANT_ID=".$merchant_id."&ORDER_ID=".$order_id;
                   
                        $curl = curl_init('https://cipg.diamondbank.com/cipg/MerchantServices/UpayTransactionStatus.ashx?'.$request);
                        curl_setopt($curl, CURLOPT_PORT, 443);                     


                        curl_setopt($curl, CURLOPT_HEADER, 0);

                        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
                        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                        curl_setopt($curl, CURLOPT_FORBID_REUSE, 1);
                        curl_setopt($curl, CURLOPT_FRESH_CONNECT, 1);
                        curl_setopt($curl, CURLOPT_POST, 1);
                        curl_setopt($curl, CURLOPT_POSTFIELDS, $request);

                        $response = curl_exec($curl);

                        curl_close($curl);

                          $response_info = new SimpleXMLElement($response);

                         $status = $response_info->StatusCode;
						 echo $status;
		}
	}
}?>
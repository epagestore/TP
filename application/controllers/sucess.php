<?php
header('HTTP/1.1 200 OK'); 
class sucess extends CI_Controller{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->helper('url');
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
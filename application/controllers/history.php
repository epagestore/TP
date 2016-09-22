<?php
class History extends CI_Controller{
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url');	
		$this->load->library('session');
		if(!$this->session->userdata('customer_id'))
		{
			redirect('home');
		}
		$this->load->model('balance_manager_model');
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
		
		$data='';
		$data['customer_id']=$customer_id;
		$balance=$this->balance_manager_model->getCurrentBalance($customer_id);
		if(isset($balance[0]))
		$data['balance']=$balance[0];
		else
		$data['balance']=0;
		$this->load->model('order_model');
		$pendingamount=$this->order_model->getPendingAmount($customer_id);
		$data['pending_amount']=$pendingamount[0]['pnamount'];
		if($pendingamount[0]['pnamount']=='')
		$data['pending_amount']='0';
		
		$this->load->model('transaction_model');
		$data['transactions']=$this->transaction_model->getTransaction($customer_id);
		foreach($this->currency() as $key => $cr)
		$data[$key]  = $cr;
					
		/* Kinnari */
		$this->load->model('customer_model');
		$cust_detail=$this->customer_model->get_customer($customer_id); 
		$data['cust_detail']=$cust_detail;
		/* Kinnari */
		$this->load->view('header',$data);
		$this->load->view('history',$data);
		$this->load->view('footer',$data);
	}
	public function excel_export()
	{
		$sno=$txn=$ord=$vendor=$amt=$desc=$fromDate=$toDate='';
		if(isset($_GET['sno']))
		{
			$sno=$_GET['sno'];
		}
		if(isset($_GET['txn']))
		{
			$txn=$_GET['txn'];
		}
		if(isset($_GET['ord']))
		{
			$ord=$_GET['ord'];
		}
		if(isset($_GET['vendor']))
		{
			$vendor=$_GET['vendor'];
		}
		if(isset($_GET['amt']))
		{
			$amt=$_GET['amt'];
		}
		if(isset($_GET['desc']))
		{
			$desc=$_GET['desc'];
			
		}
		if(isset($_GET['fromDate']) && $_GET['fromDate']!='')
		{
			$fromDate=date('Y-m-d',strtotime($_GET['fromDate']));
			
			
		}
		if(isset($_GET['toDate']) && $_GET['toDate']!='')
		{
			$toDate=date('Y-m-d',strtotime($_GET['toDate']));
			
		}
		
		$filename ="excelHistoryreport.xls";
		$customer_id=$this->session->userdata('customer_id');
		$contents = "Transaction Id \t Vendor \t Amount \t Description \t Date \t \n";
		$this->load->model('transaction_model');
		$transactions=$this->transaction_model->getTransactionSearch($customer_id,$sno,$txn,$ord,$vendor,$amt,$desc,$fromDate,$toDate);
		$vendor=' ';
	
		foreach($transactions as $transaction){
			//if(!isset($transaction['payer_id1'])){if($customer_id=$transaction['payer_id']){$vendor= $transaction['payee_name'];}else{$vendor= $transaction['payer_name'];}} else{if($customer_id=$transaction['payer_id1']){$vendor= $transaction['payee_name1'];}else{$vendor= $transaction['payer_name1'];}}
			
			$contents .= $transaction['transaction_id']." \t ".$transaction['company_name']." \t $".abs($transaction['amount'])." \t ".$transaction['description']." \t ".date('d M Y',strtotime($transaction['date_added']))."\n";
		}
		header('Content-type: application/ms-excel');
		header('Content-Disposition: attachment; filename='.$filename);
		echo $contents;
	}
	public function pdf_export()
	{
		$filename='abcd';
		$sno=$txn=$ord=$vendor=$amt=$desc=$fromDate=$toDate='';
		$data['page_title'] = 'Transactio History'; // pass data to the view
	 
		ini_set('memory_limit','1000M'); 
		// boost the memory limit if it's low <img src="http://davidsimpson.me/wp-includes/images/smilies/icon_wink.gif" alt=";)" class="wp-smiley"> 
		
		if(isset($_GET['sno']))
		{
			$sno=$_GET['sno'];
		}
		if(isset($_GET['txn']))
		{
			$txn=$_GET['txn'];
		}
		if(isset($_GET['ord']))
		{
			$ord=$_GET['ord'];
		}
		if(isset($_GET['vendor']))
		{
			$vendor=$_GET['vendor'];
		}
		if(isset($_GET['amt']))
		{
			$amt=$_GET['amt'];
		}
		if(isset($_GET['desc']))
		{
			$desc=$_GET['desc'];
			
		}
		if(isset($_GET['fromDate']) && $_GET['fromDate']!='')
		{
			$fromDate=date('Y-m-d',strtotime($_GET['fromDate']));
			
			
		}
		if(isset($_GET['toDate']) && $_GET['toDate']!='')
		{
			$toDate=date('Y-m-d',strtotime($_GET['toDate']));
			
		}
		
		$filename ="excelHistoryreport.pdf";
		$customer_id=$this->session->userdata('customer_id');
		$contents = "<table><tbody><tr><th>Transaction Id</th><th>Vendor</th><th> Amount</th><th> Description</th><th> Date </th></tr>";
		$this->load->model('transaction_model');
		$transactions=$this->transaction_model->getTransactionSearch($customer_id,$txn,$ord,$vendor,$amt,$desc,$fromDate,$toDate);
		$vendor=' ';
		
		foreach($transactions as $transaction){
			//if(!isset($transaction['payer_id1'])){if($customer_id=$transaction['payer_id']){$vendor= $transaction['payee_name'];}else{$vendor= $transaction['payer_name'];}} else{if($customer_id=$transaction['payer_id1']){$vendor= $transaction['payee_name1'];}else{$vendor= $transaction['payer_name1'];}}
			$contents .= "<tr><td>".$transaction['transaction_id']." </td><td> ".$transaction['company_name']." </td><td> $".abs($transaction['amount'])." </td><td>".$transaction['description']." </td><td>".date('d M Y',strtotime($transaction['date_added']))."</td></tr>";
		}
			 $html ="<html><body>".$contents."</tbody></table></body></html>"; // render the view into HTML
			
			 
			$this->load->library('pdf');
			$pdf = $this->pdf->load(); 
			$pdf->SetFooter($_SERVER['HTTP_HOST'].'|{PAGENO}|'.date(DATE_RFC822)); // Add a footer for good measure <img src="http://davidsimpson.me/wp-includes/images/smilies/icon_wink.gif" alt=";)" class="wp-smiley"> 
			$pdf->WriteHTML($html); // write the HTML into the PDF
			$pdf->output($filename,'D');
			//$pdf->Output();
			//echo $pdf; // save to file because we can
		
		 
		//redirect("/downloads/reports/$filename.pdf"); 
	}
	public function csv_export()
	{
		$sno=$txn=$vendor=$amt=$desc='';
		if(isset($_GET['sno']))
		{
			$sno=$_GET['sno'];
		}
		if(isset($_GET['txn']))
		{
			$txn=$_GET['txn'];
		}
		if(isset($_GET['ord']))
		{
			$ord=$_GET['ord'];
		}
		if(isset($_GET['vendor']))
		{
			$vendor=$_GET['vendor'];
		}
		if(isset($_GET['amt']))
		{
			$amt=$_GET['amt'];
		}
		if(isset($_GET['desc']))
		{
			$desc=$_GET['desc'];
			
		}
		
		$filename ="excelHistoryreport.xls";
		$customer_id=$this->session->userdata('customer_id');
		$this->load->model('transaction_model');
		$transactions=$this->transaction_model->getTransactionSearch($customer_id,$sno,$txn,$vendor,$amt,$desc);
		
		
		header('Content-Type: text/csv; charset=utf-8');
		header('Content-Disposition: attachment; filename=data.csv');
		
		$output = fopen('php://output', 'w');
	
		fputcsv($output, array('Transaction Id', 'Vendor','Amount', 'Description','Date'));
		
		
	
		$vendor=' ';
		foreach($transactions as $transaction){
			//if(!isset($transaction['payer_id1'])){if($customer_id=$transaction['payer_id']){$vendor= $transaction['payee_name'];}else{$vendor= $transaction['payer_name'];}} else{if($customer_id=$transaction['payer_id1']){$vendor= $transaction['payee_name1'];}else{$vendor= $transaction['payer_name1'];}}
			$row=array( 
			$transaction['transaction_id'],
			$transaction['company'],
			abs($transaction['amount']),
			$transaction['description'],
			date('d M Y',strtotime($transaction['date_added']))
			);
			fputcsv($output, $row);
		}
		
		//fputcsv($output, $row);
	}
}?>
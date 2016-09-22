<?php
class Dashboard extends CI_Controller{
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
		$this->load->model('send_money_model');
	}
	public function setCurrency($currency_id){
		
		$redirect = $_GET['redirect'];
		
		$this->session->set_userdata('currency_id',$currency_id);				

		$this->load->model('currencies_model');
		
		$currency_detail = $this->currencies_model->getCurrencyInfo($currency_id);		
			
				$this->currency_current['current_currency'] = array(
				'currency_id' => $currency_id,
				'currency_symbol'          => $currency_detail->symbol,
				'code'          => $currency_detail->code,	
				'value'          => $currency_detail->value										
				);
		$this->session->set_userdata($this->currency_current);		
		redirect($redirect);
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
		
		/* Kinnari */
		$this->load->model('customer_model');
		$cust_detail=$this->customer_model->get_customer($customer_id); 
		$data['cust_detail']=$cust_detail;
		/* Kinnari */
		
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
		$page_limit='LIMIT 0,5';
		$data['transactions']=$this->transaction_model->getTransaction($customer_id,$page_limit);
		
		foreach($this->currency() as $key => $cr)
		$data[$key]  = $cr;		
		$this->load->view('header',$data);		
		$this->load->view('dashboard',$data);
		$this->load->view('footer',$data);
	}
	function clear_all_notif()
	{
		$customer_id=	$this->session->userdata('customer_id');
		$this->load->model('options_model');
		$this->options_model->clearNotif($customer_id);
	}	
	
	function count_notif()
	{
		error_reporting(0);
		foreach($this->currency() as $key => $cr)
		$$key  = $cr;
		$customer_id=	$this->session->userdata('customer_id');
		$this->load->model('options_model');
		$notif=$this->options_model->notif($customer_id);
		$notif_details=array();
		$i=0;
		$count=0;
		foreach($notif['transaction'] as $details)
		{
			$notif_details[$i]['photo']=base_url().$details['photo'];
			$notif_details[$i]['amount']=$currency_symbol.sprintf("%.2f", (abs($details['amount']))*$value);
			$notif_details[$i]['description']=$details['description'];
			$notif_details[$i]['read']=$details['read'];
			if($details['read']==0)
			$count++;
			$notif_details[$i]['date_added']=date('F jS Y g:i:s A',strtotime($details['date_added']));;
			$notif_details[$i]['org_date_added']=$details['date_added'];
			if($details['order_id']!=NULL)
			{
				$notif_details[$i]['description'].=' on Order :'.$details['order_id'];
				if($details['payer_id']==$details['customer_id'])
				$notif_details[$i]['url']=base_url().'index.php/order/placed_details/'.$details['order_id'];
				else
				$notif_details[$i]['url']=base_url().'index.php/order/receive_details/'.$details['order_id'];
			}
			else
			$notif_details[$i]['url']=base_url().'index.php/history';
			
			$i++;
		}
		foreach($notif['despute_msg'] as $details)
		{

			$notif_details[$i]['photo']=base_url().$details['photo'];
			$notif_details[$i]['amount']='';
			$notif_details[$i]['description']='Despute message received : '.$details['message_body'];
			$notif_details[$i]['read']=$details['read'];
			if($details['read']==0)
			$count++;
			$notif_details[$i]['date_added']=date('F jS Y g:i:s A',strtotime($details['added_on']));
			$notif_details[$i]['org_date_added']=$details['added_on'];
			$notif_details[$i]['url']=base_url().'index.php/despute/negotiate/'.$details['despute_id'];
			
			$i++;
		}
		
		/* foreach($notif['dispatch_recived'] as $details)
		{
			$notif_details[$i]['photo']=base_url().$details['photo'];
			$notif_details[$i]['amount']='';
			$notif_details[$i]['description']='Dispatch message received : '.$details['dispatch_status'];
			$notif_details[$i]['read']=$details['read'];
			if($details['read']==0)
			$count++;
			$notif_details[$i]['date_added']=date('F jS Y g:i:s A',strtotime($details['added_on']));
			$notif_details[$i]['org_date_added']=$details['added_on'];
			$notif_details[$i]['url']=base_url().'index.php/despute/negotiate/'.$details['despute_id'];
			
			$i++;
		} */
		
		foreach($notif['despute_recive'] as $details)
		{
			$notif_details[$i]['photo']=base_url().$details['photo'];
			
			if($details['payer_id']==$details['generate_by'])
				$notif_details[$i]['amount']=$currency_symbol.sprintf("%.2f", (abs($details['payee_amount']))*$value);
			else
				$notif_details[$i]['amount']=$currency_symbol.sprintf("%.2f", (abs($details['payer_amount']))*$value);
			$notif_details[$i]['description']="Despute generated on order : ".$details['order_id'];
			$notif_details[$i]['read']=$details['read'];
			if($details['read']==0)
			$count++;
			$notif_details[$i]['date_added']=date('F jS Y g:i:s A',strtotime($details['date_added']));
			$notif_details[$i]['org_date_added']=$details['date_added'];
			$notif_details[$i]['url']=base_url().'index.php/despute/negotiate/'.$details['despute_id'];
			
			$i++;
		}
		function compare_func($a, $b)
		{
			// CONVERT $a AND $b to DATE AND TIME using strtotime() function
			$t1 = strtotime($a["org_date_added"]);
			$t2 = strtotime($b["org_date_added"]);
		
			return ($t2 - $t1);
		}
		
		usort($notif_details, "compare_func");
		
		$total=count($notif_details) ;
		//print_r($notif_details);
		$query=$this->db->query("SELECT NOW() as now,od.despute_id as id,od.date_added from (SELECT *  from `order_despute` od where (payer_id=".$customer_id." OR payee_id =".$customer_id.") AND  od.status=1 ) od LEFT join customer cus on cus.customer_id=od.generate_by LEFT JOIN  `order_despute_reason` odr ON od.reason = odr.reason_id order by od.date_added asc ");
		$total_dispute=$query->result_array();
		
		$total_dispute1='';
		/*if(count($total_dispute)>0)
		{
			$total_dispute1[0]['total_dispute']=$query->num_rows();
			$total_dispute1[0]['date_added']=$total_dispute?date('Y-m-d H:i:s', strtotime('+4 day', strtotime($total_dispute[0]['date_added']))):'';
			//$total_dispute1[0]['date_added']=$total_dispute?date("Y/m/d H:i:s",strtotime($total_dispute[0]['date_added'])):'';
			$total_dispute1[0]['now']=$total_dispute?date("Y/m/d H:i:s",strtotime($total_dispute[0]['now'])):'';
			$total_dispute1[0]['id']=$total_dispute[0]['id'];
		} */ // manu
		
		// Minir
		if(count($total_dispute)>0)
		{	
			$total_dispute1[0]['total_dispute']=$query->num_rows();
			for($i=0;$i<count($total_dispute);$i++)
			{
				$total_dispute1[$i]['date_added']=$total_dispute?date('Y-m-d H:i:s', strtotime('+4 day', strtotime($total_dispute[$i]['date_added']))):'';
				//$total_dispute1[0]['date_added']=$total_dispute?date("Y/m/d H:i:s",strtotime($total_dispute[0]['date_added'])):'';
				$total_dispute1[$i]['now']=$total_dispute?date("Y/m/d H:i:s",strtotime($total_dispute[$i]['now'])):'';
				$total_dispute1[$i]['id']=$total_dispute[$i]['id'];
			}
			

		}// code added by mihir end
		
		
		
		
		$t=array();
		foreach($total_dispute as $ta)
		{
			$a=array();
			$a['date_added'] = date('d/m/Y H:i:s', strtotime('+4 day', strtotime($ta['date_added'])));
			$a['now'] = date("d/m/Y H:i:s",strtotime($ta['now']));
			$a['id'] = $ta['id'];
			$t[]=$a;
		}
		
		//		Total Requste Money
		$c_u= $this->db->query('select * from customer where customer_id='.$this->session->userdata('customer_id'))->row();
		$arr= array();
		$arr[]=$c_u->email;
		
		if(!$c_u->customer_phone)
		$arr[]=$c_u->email;
		else
		$arr[]=$c_u->customer_phone;
		$count_total_invoice_paid = $this->db->query("select * from invoice where status=3 and customer_id = '".$this->session->userdata('customer_id')."'")->num_rows();
		$count_total_requested_money = $this->send_money_model->getDetails_list_Req($arr,1); 
		$quicksettler= $count_total_invoice_paid + $count_total_requested_money;
		
		//Dispatch
		$dispatch_received = $this->db->query('select distinct(d1.order_product_id) as number  from dispatch d1 left join dispatch d2 on d1.order_product_id=d2.order_product_id where  d1.dispatch_status=1  and d1.dispatch_to ="'.$this->session->userdata('customer_id').'" and d2.dispatch_from !="'.$this->session->userdata('customer_id').'" ')->result_array();
		$status=0;
		if(count($dispatch_received)>0){
		foreach($dispatch_received  as $a)
		{
			
			$st = $this->db->query('select dispatch_status  from dispatch d1  where   order_product_id = "'.$a['number'].'"  order by dispatch_status desc limit 1 ')->row();
			if($st->dispatch_status==1)
				$status++;
			//$status[] = $st->dispatch_status;
		}
		}
		
		$dispatch_received=$status;
		$total=$total + $dispatch_received + $quicksettler;
		echo json_encode(array("notify_details"=>$notif_details,"count"=>$count,"total"=>$total,"total_dispute"=>$total_dispute1,"dispute"=>$t,"quicksettler"=>$quicksettler,"dispatch_received"=>$dispatch_received));
	}
}?>
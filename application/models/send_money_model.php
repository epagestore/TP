<?php
class Send_money_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}
	public function send($customer_id,$data)
	{
		
		$query_own=$this->db->query("SELECT email from `customer` where customer_id=".$customer_id);
		$sender=$query_own->result_array();
		if($data['send_to']=='email')
			$query=$this->db->query("SELECT customer_id,email from `customer` where email = '".$data['contact']."'");
		else if($data['send_to']=='mobile')
			$query=$this->db->query("SELECT * from customer where phonecode = '".$data['phonecode']."' and customer_phone = '".trim($data['contact'])."'");
		
		
			//$query=$this->db->query("SELECT cust.customer_id,email from `customer` cust,`address` adrs where cust.address=adrs.address_id and cust.customer_phone='".trim($data['contact'])."'");
		$contact_customer=$query->result_array();
		
		
		
		if(isset($contact_customer[0]) && $contact_customer[0]['customer_id']!=$customer_id)
		{
			$unique_key=date('dmy')."".random_string('alnum', 5)."".date('his');
			$this->db->query("INSERT INTO `send_money_transaction` SET customer_id=".$customer_id.",`key`='".$unique_key."', send_to='".$data['send_to']."', contact='".$data['contact']."',amount =".str_replace(',','',$data['amount']).",currency='".$data['currency']."', reason=".$data['reason'].",status=1, date_added = NOW(), date_modefied = NOW()");
			$invoice_id=$this->db->insert_id();
			return array('status'=>"Success","sender_email"=>$sender[0]['email'],"reciver_email"=>$contact_customer[0]['email'],'key'=>$unique_key,'invoice_id'=>$invoice_id,"sent_amount"=>str_replace(',','',$data['amount']));
		}
		else
		{
			return array('status'=>"Fail");
		}
	}
	public function reason()
	{
		$query=$this->db->query("SELECT * from `send_money_reason`");
		return $query->result_array();
	}
	public function getDetails($invoice_id)
	{
		$query=$this->db->query("SELECT st.*,concat(cust.first_name,concat(' ',cust.last_name)) as sender_name from `send_money_transaction` st,`customer` cust where cust.customer_id=st.customer_id and st.invoice_id=".$invoice_id);
		return $query->result_array();
	}
	
	public function getDetails_list_Req($customer_id,$count='')
	{
		if($count!='')
		{
			$c=" st.contact='".$customer_id[0]."' or st.contact='".$customer_id[1]."' ";  
			$query=$this->db->query("SELECT sr.* , st.*,concat(cust.email) as requester_name from  `request_money_transaction` st,`customer` cust ,request_money_reason sr where st.status=1 and sr.reason_id=st.reason and ($c) and cust.customer_id=st.customer_id order by st.invoice_id desc");
			return $query->num_rows();
		}
		else{
		$c=" st.contact='".$customer_id[0]."' or st.contact='".$customer_id[1]."' ";  
		$query=$this->db->query("SELECT sr.* , st.*,concat(cust.email) as requester_name from  `request_money_transaction` st,`customer` cust ,request_money_reason sr where sr.reason_id=st.reason and ($c) and cust.customer_id=st.customer_id order by st.invoice_id desc");
		return $query->result_array();
		}
	}
	
	public function getDetails_list($customer_id)
	{
		$query=$this->db->query("SELECT sr.* , st.*,concat(cust.first_name,concat(' ',cust.last_name)) as sender_name from  `send_money_transaction` st,`customer` cust ,send_money_reason sr where sr.reason_id=st.reason and cust.customer_id=st.customer_id and st.customer_id=".$customer_id." order by st.invoice_id desc");
		return $query->result_array();
	}
	
	public function reciveMoney($reciver_id,$invoice_id,$key)
	{
			$query=$this->db->query("SELECT customer_id,amount,`key` from `send_money_transaction` where status=1 and invoice_id=".$invoice_id);
			$sender=$query->result_array();
			if($key==$sender[0]['key'])
			{
				$this->db->query("UPDATE `send_money_transaction` SET status=2 where status=1 and invoice_id=".$invoice_id );
			$this->db->query("INSERT INTO `customer_transaction`  SET customer_id=".$sender[0]['customer_id'].", amount=-".str_replace(',','',$sender[0]['amount']).", description='Amount sent', date_added = NOW()");
			$this->db->query("UPDATE `customer_account_balance` SET total_balance=total_balance-".$sender[0]['amount'].", date_modified = NOW() where customer_id = ".$sender[0]['customer_id']);
			
			$this->db->query("INSERT INTO `customer_transaction`  SET customer_id=".$reciver_id.", amount=+".$sender[0]['amount'].", description='Amount received', date_added = NOW()");
			$this->db->query("UPDATE `customer_account_balance` SET total_balance=total_balance+".$sender[0]['amount'].", date_modified = NOW() where customer_id = ".$reciver_id);
			return true;
			}
			else
			return false;
	}
	public function valid($customer_id,$invoice_id)
	{
		$query_own=$this->db->query("SELECT q.*,adrs.mobile FROM(SELECT cust.email,address from `customer` cust WHERE customer_id=".$customer_id.") q LEFT JOIN `address` adrs ON q.address=adrs.address_id ");
		$sender=$query_own->result_array();
		
		$query=$this->db->query("SELECT status from `send_money_transaction` where ((contact='".$sender[0]['email']."'  and send_to='email' ) OR (contact='".$sender[0]['mobile']."'  and send_to='mobile' )) and invoice_id=".$invoice_id);
		return $query->result_array();
		
	}
}?>
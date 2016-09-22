<?php
class Request_money_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}
	public function request($customer_id,$data)
	{
		$query_own=$this->db->query("SELECT email from `customer` where customer_id=".$customer_id);
		$reciver=$query_own->result_array();
		if($data['request_to']=='email')
		$query=$this->db->query("SELECT customer_id,email from `customer` where email='".$data['contact']."'");
		else if($data['request_to']=='mobile')
		$query=$this->db->query("SELECT cust.customer_id,email from `customer` cust,`address` adrs where cust.address=adrs.address_id and customer_phone='".$data['contact']."'");
		
		$contact_customer=$query->result_array();
		if(isset($contact_customer[0]) && $contact_customer[0]['customer_id']!=$customer_id)
		{
			$this->db->query("INSERT INTO `request_money_transaction` SET customer_id=".$customer_id.", request_to='".$data['request_to']."', contact='".$data['contact']."',amount =".$data['amount'].",currency='".$data['currency']."', reason=".$data['reason'].",status=1, date_added = NOW(), date_modefied = NOW()");
			$id=$this->db->insert_id();
			/*$this->db->query("INSERT INTO `customer_transaction`  SET customer_id=".$customer_id.", amount=-".$data['amount'].", description='Amount request', date_added = NOW()");
			$this->db->query("UPDATE `customer_account_balance` SET total_balance=total_balance-".$data['amount'].", date_modified = NOW() where customer_id = ".$customer_id);
			
			$this->db->query("INSERT INTO `customer_transaction`  SET customer_id=".$contact_customer[0]['customer_id'].", amount=+".$data['amount'].", description='Amount received', date_added = NOW()");
			$this->db->query("UPDATE `customer_account_balance` SET total_balance=total_balance+".$data['amount'].", date_modified = NOW() where customer_id = ".$contact_customer[0]['customer_id']);*/
			return array('status'=>"Success","reciver_email"=>$reciver[0]['email'],"sender_email"=>$contact_customer[0]['email'],"id"=>$id);
		}
		else
		{
			return array('status'=>"Fail");
		}
	}
	public function getDetails_list_Req($customer_id)
	{
		$query=$this->db->query("SELECT sr.* , st.*,concat(cust.first_name,concat(' ',cust.last_name)) as sender_name from  `request_money_transaction` st,`customer` cust ,request_money_reason sr where sr.reason_id=st.reason and cust.customer_id=st.customer_id and st.customer_id=".$customer_id." order by st.invoice_id desc");
		return $query->result_array();
	}
	public function getDetails_list($customer_id)
	{
		$c=" st.contact='".$customer_id[0]."' or st.contact='".$customer_id[1]."' ";  
		$query=$this->db->query("SELECT sr.* , st.*,concat(cust.email) as receiever_name from `send_money_transaction` st,`customer` cust ,send_money_reason sr where sr.reason_id=st.reason and cust.customer_id=st.customer_id and ($c) order by st.invoice_id desc");
		return $query->result_array();
	}
	
	public function getRequest($customer_id,$id)
	{
		$query=$this->db->query("SELECT concat(s.first_name,concat(' ',s.last_name)) as request_name,q.* FROM (SELECT * from `request_money_transaction` where invoice_id =$id and status=1) q LEFT JOIN `customer` s ON s.customer_id=q.customer_id");
		$request=$query->result_array();
		if(isset($request[0]))
		{
			$data=$request[0];
			if($data['request_to']=='email')
			$query=$this->db->query("SELECT customer_id,email from `customer` where email='".$data['contact']."'");
			else if($data['request_to']=='mobile')
			$query=$this->db->query("SELECT cust.customer_id,email from `customer` cust,`address` adrs where cust.customer_id=adrs.customer_id and mobile='".$data['contact']."'");
			$contact_customer=$query->result_array();
			if(isset($contact_customer[0]) && $contact_customer[0]['customer_id']==$customer_id)
			{
				return array('status'=>"Success","result"=>$request);
			}
			else
			{
				return array('status'=>"Fail");
			}
		}
		else
		{
			return array('status'=>"Fail");
		}
		return $query->result_array();
	}
	public function reason()
	{
		$query=$this->db->query("SELECT * from `request_money_reason`");
		return $query->result_array();
	}
	public function approveRequest($customer_id,$id)
	{
		$query=$this->db->query("SELECT concat(s.first_name,concat(' ',s.last_name)) as request_name,q.* FROM (SELECT * from `request_money_transaction` where invoice_id =$id) q LEFT JOIN `customer` s ON s.customer_id=q.customer_id");
		$request=$query->result_array();
		$data=$request[0];
		if($data['request_to']=='email')
		$query=$this->db->query("SELECT customer_id,email from `customer` where customer_id=".$data['customer_id']."");
		else if($data['request_to']=='mobile')
		$query=$this->db->query("SELECT cust.customer_id,email from `customer` cust,`address` adrs where cust.customer_id=adrs.customer_id and customer_id=".$data['customer_id']."'");
		$contact_customer=$query->result_array();
		
		$query_own=$this->db->query("SELECT email from `customer` where customer_id=".$customer_id);
		$reciver=$query_own->result_array();
		
		$this->db->query("UPDATE `request_money_transaction` SET status=2, date_modefied = NOW() where invoice_id=".$id."");
		
		$this->db->query("INSERT INTO `customer_transaction`  SET customer_id=".$customer_id.", amount=-".$data['amount'].", description='Amount request', date_added = NOW()");
		$this->db->query("UPDATE `customer_account_balance` SET total_balance=total_balance-".$data['amount'].", date_modified = NOW() where customer_id = ".$customer_id);
		
		$this->db->query("INSERT INTO `customer_transaction`  SET customer_id=".$contact_customer[0]['customer_id'].", amount=+".$data['amount'].", description='Amount received', date_added = NOW()");
		$this->db->query("UPDATE `customer_account_balance` SET total_balance=total_balance+".$data['amount'].", date_modified = NOW() where customer_id = ".$contact_customer[0]['customer_id']);
		return array('status'=>"Success","reciver_email"=>$reciver[0]['email'],"sender_email"=>$contact_customer[0]['email'],"id"=>$id);
	}
	public function declineRequest($customer_id,$id)
	{
		$this->db->query("UPDATE `request_money_transaction` SET status=-1 where invoice_id=".$id);
	}
}?>
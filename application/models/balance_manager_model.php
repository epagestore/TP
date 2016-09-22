<?php
class Balance_manager_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}
	public function transferAmount($customer_id,$data)
	{
		$da='';
		if(isset($data['deposite_by']))
		{
			$da = ", deposite_by ='".$data['deposite_by']."'";
		}
		
		$this->db->query("INSERT INTO `customer_transaction`  SET customer_id = ".$customer_id.", amount = ".str_replace(",","",$data['amount']).", description ='Amount has been deposited ' ".$da." , date_added = NOW()");
		$query=$this->db->query("SELECT customer_id from `customer_account_balance`  where customer_id = ".$customer_id);
		$exist=$query->result_array();
		if(!count($exist))
		$this->db->query("INSERT INTO `customer_account_balance` SET customer_id = ".$customer_id.", total_balance = ".str_replace(",","",$data['amount']).", date_modified = NOW()");
		else
		$this->db->query("UPDATE `customer_account_balance` SET total_balance = total_balance +".str_replace(",","",$data['amount']).", date_modified = NOW() where customer_id = ".$customer_id);
		$this->session->set_userdata('balance',$this->session->userdata('balance')+str_replace(",","",$data['amount']));
	}
	
	public function deduct_transferAmount($customer_id,$data,$id)
	{	
		$query=$this->db->query("SELECT * from `customer_account_balance`  where customer_id = ".$customer_id);
		$exist=$query->result_array();
		print_r($exist);
		if(!count($exist) || $exist[0]['total_balance']<str_replace(",","",$data['amount']))
		{
			return false;
		}
		else
		{
			$a = "<a href=".mysql_real_escape_string(base_url())."index.php/invoice/view/".$id.">Detail</a>";
			$this->db->query("INSERT INTO `customer_transaction`  SET customer_id = ".$customer_id.", amount = -".str_replace(",","",$data['amount']).", description ='Invoice payment Amount has been deducted from main account!Invoice Id ".$a."', date_added = NOW()");
			$this->db->query("UPDATE `customer_account_balance` SET total_balance = total_balance -".str_replace(",","",$data['amount']).", date_modified = NOW() where customer_id = ".$customer_id);
			$this->session->set_userdata('balance',$this->session->userdata('balance')-str_replace(",","",$data['amount']));
			return true;
		}	
		
	}
	
	public function getCurrentBalance($customer_id){
		$query=$this->db->query("SELECT total_balance + balance_in_process as amount from `customer_account_balance` where customer_id =".$customer_id);
		return $query->result_array();
	}
}?>
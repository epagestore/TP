<?php
class Withdraw_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}
	public function withdrawRequest($customer_id,$data)
	{
		$description = 'Withdraw Request sent for amount '.$data['amount'];
		//$this->db->query("INSERT INTO `customer_transaction`  SET customer_id = ".$customer_id.", amount = ".$data['amount'].", description = '".$description."', date_added = NOW()");
		$transaction_id='1277';//$this->db->insert_id();
		//$this->db->query("UPDATE `customer_account_balance` SET balance_in_process =balance_in_process - ".$amount.", date_modified = NOW() where customer_id = ".$customer_id);
		$this->db->query("INSERT INTO `withdraw_amount` SET  currency_id='".$data['currency_id']."',amount='".$data['amount']."',description='".$description."',customer_id='".$customer_id."',status=0,ip_address='".$data['ip_address']."', date_added = NOW(), date_updated = NOW()");
	}
}?>
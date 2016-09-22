<?php
class Amount_transaction_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}
	public function getAmountTransaction($customer_name='')
	{
		if($customer_name!='')
		$customer_name=" having customer_name like '%".$customer_name."%'";
		$query=$this->db->query("SELECT ct.*,CONCAT(cus.first_name,CONCAT(' ',cus.last_name)) as customer_name FROM customer_transaction ct,customer cus where cus.customer_id=ct.customer_id and description like 'Amount deposited' or 'Amount withdraw' ".$customer_name." order by transaction_id desc");
		return $query->result_array();
	}
}?>
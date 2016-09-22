<?php
class Options_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}
	public function notif($customer_id){
		$query_notif=$this->db->query("SELECT * from `notification` where customer_id=$customer_id");
		$notif=$query_notif->result_array();
		if(!isset($notif[0]))
		$notif[0]['clear_all']='0000-00-00 00:00:00';
		$query_trans=$this->db->query("SELECT ct.*,ordr.order_id,ordr.payer_id,ordr.payee_id,concat(cust.first_name,concat(' ',cust.last_name)) as customer_name,cust.photo FROM(SELECT * FROM `customer_transaction` where customer_id=$customer_id and date_added>'".$notif[0]['clear_all']."') ct LEFT JOIN `customer` cust on cust.customer_id=ct.customer_id   LEFT JOIN `order_product` op on op.transaction_id=ct.transaction_id LEFT JOIN `order` ordr on ordr.order_id=op.order_id LEFT JOIN `order` ordr1 on ordr1.transaction_id=ct.transaction_id left join `customer_company` company on ordr.company_id=company.customer_id");
		$transaction=$query_trans->result_array();
		$query_despute_msg=$this->db->query("SELECT q.*,concat(cust.first_name,concat(' ',cust.last_name)) as customer_name,cust.photo FROM(SELECT * FROM `message` where (payer_id=$customer_id or payee_id=$customer_id) and sender_id!=$customer_id and added_on>'".$notif[0]['clear_all']."') q LEFT JOIN `customer` cust ON cust.customer_id=sender_id");
		$despute_msg=$query_despute_msg->result_array();
		$query_despute_recive=$this->db->query("SELECT q.*,concat(cust.first_name,concat(' ',cust.last_name)) as customer_name,cust.photo FROM(SELECT * FROM `order_despute` where (payer_id=$customer_id or payee_id=$customer_id) and generate_by!=$customer_id and date_added>'".$notif[0]['clear_all']."') q LEFT JOIN `customer` cust ON cust.customer_id=q.generate_by");
		$despute_recive=$query_despute_recive->result_array();
		return array("transaction"=>$transaction,"despute_msg"=>$despute_msg,"despute_recive"=>$despute_recive);
	}
	public function clearNotif($customer_id)
	{
		$query_notif=$this->db->query("SELECT * from `notification` where customer_id=$customer_id");
		$notif=$query_notif->result_array();
		if(!isset($notif[0]))
		$this->db->query("INSERT INTO `notification` SET customer_id=$customer_id , clear_all=NOW(),status=1");
		else
		$this->db->query("UPDATE `notification` SET clear_all=NOW(),status=1 where customer_id=$customer_id");
	}
	
}?>
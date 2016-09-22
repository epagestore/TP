<?php
class Paypal_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}
	public function insertPaypalEmail($customer_id,$email)
	{
		$this->db->query("INSERT INTO `paypal_credentials`   SET customer_id =".$customer_id.", paypal_email = '".$email."'");
	}
	public function updatePaypalEmail($customer_id,$email)
	{
		$this->db->query("UPDATE `paypal_credentials`  SET paypal_email = '".$email."' where customer_id =".$customer_id);
	}
	public function getPaypalEmail($customer_id)
	{
		$query = $this->db->query("SELECT * FROM `paypal_credentials` where customer_id =".$customer_id);
		return $query->result_array();
	}
}?>
<?php
class forget_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}
	public function validateForget($email,$confirm_code)
	{
		$query=$this->db->query("SELECT customer_id from `customer` where email='$email' and confirmation_code='$confirm_code' and is_forget_password=1");
		$customer= $query->result_array();
		return $customer;
	}
	public function changePass($customer_id,$data)
	{
		$query=$this->db->query("UPDATE `customer` SET confirmation_code='', is_forget_password=0, password='".md5($data['pass'])."' where customer_id=$customer_id");
	}
}?>
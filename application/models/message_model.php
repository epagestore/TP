<?php
class Message_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}
	public function sendMessage($payer_id,$payee_id,$sender_id,$despute_id,$message,$date='')
	{
		if($date=='')
		$query=$this->db->query("INSERT INTO `message` SET payer_id = ".$payer_id.",payee_id = ".$payee_id.",despute_id = ".$despute_id.",sender_id = ".$sender_id.",message_body = '".mysql_real_escape_string($message)."', added_on = NOW(), message_type ='Normal',`read` = 0");
		else
		$query=$this->db->query("INSERT INTO `message` SET payer_id = ".$payer_id.",payee_id = ".$payee_id.",despute_id = ".$despute_id.",sender_id = ".$sender_id.",message_body = '".mysql_real_escape_string($message)."', added_on = '".$date."', message_type ='Normal',`read` = 0");
			
			
		//return $query->result_array();
	}
	public function getMessages($despute_id)
	{
		$query=$this->db->query("select q1.*,sender.first_name as sender_name,sender.photo from(SELECT * from `message` where despute_id =".$despute_id.") q1 left join `customer` sender on q1.sender_id=sender.customer_id");
		$customer_id=	$this->session->userdata('customer_id');
		$this->db->query("UPDATE `message` SET `read`=1 where despute_id =".$despute_id." and sender_id!=$customer_id");
		return $query->result_array();
		
	}
}?>
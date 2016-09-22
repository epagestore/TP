<?php
class currencies_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}
	
	public function get_currency()
	{
		$query=$this->db->query("SELECT * from currency");
		return $query->result_array();	
			
	}
	
	public function addCurrency($data) {
		$this->db->query("INSERT INTO currency SET title = '" . $data['title']  . "', symbol = '" . $data['symbol']. "', status = '" . (int)$data['status'] . "', date_modified = NOW()");
	
	}
	
	public function getCurrency($currency_id) {
		$query = $this->db->query("SELECT * from currency WHERE currency_id = '" . (int)$currency_id . "'");
		
		return $query->result_array();
	}
	
	public function getCurrencies() {

		$query = $this->db->query("SELECT * from currency");
		
		return $query->result_array();
		
	}

	public function getCurrencyInfo($currency_id) {
		
		$query = $this->db->query("SELECT * from currency WHERE currency_id = '" . (int)$currency_id . "'");
		
		$result = $query->row();
		
		return $result;
	}


	public function deleteCurrency($currency_id) {	
			$this->db->query("DELETE FROM currency WHERE currency_id = '" . (int)$currency_id . "'");

	}
	
	public function editCurrency($currency_id, $data) {
	
/*	$desc = str_replace("'","'",$data['message']);
	echo $desc;
*/	
		$this->db->query("UPDATE currency SET title = '" . $data['title']  . "', symbol = '" . $data['symbol']. "', status = '" . (int)$data['status']  . "', date_modified = NOW() WHERE currency_id = '" . (int)$currency_id . "'");
		
	}
	
}?>
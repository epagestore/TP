<?php
class Customer_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}
	public function insertCustomerQuick($data,$user_type='')
	{
		if(!isset($data['fname']))
		$data['fname']=$data['company_name'];
	
		$data['dispatcher']=isset($data['dispatcher'])? $data['dispatcher'] : '0';
		$this->db->query("Insert into `customer` set password ='".md5($data['password'])."', first_name ='".$data['fname']."', email ='".$data['email']."', dispatcher ='".$data['dispatcher']."', dispatcher_location ='".json_encode($data['dispatcher_location'])."',phonecode='".$data['phonecode']."',customer_phone='".$data['customer_phone']."', date_added = NOW()");
		$customer_id=$this->db->insert_id();
		$unique_id=date('dmy')."".random_string('alnum', 2)."".date('his');
		$dsp='';
		if(isset($data['dispatcher']) && isset($data['dispatcher_location']))
		{
			$dsp='TDP'.$customer_id;
			foreach($data['dispatcher_location'] as $tf)
			{
				$dsp.=$tf[0];
			}
		}
		$this->db->query("UPDATE `customer` SET dispatcher_id='".$dsp."', customer_unique_id ='".$unique_id."' where customer_id =".$customer_id);
		if($user_type =='cmp')
		{
			$this->db->query("UPDATE `customer` SET  is_company ='1' where customer_id ='".$customer_id."'");
			
			$this->db->query("Insert into `customer_company` set customer_id = ".$customer_id.", company_name ='".$data['company_name']."'");
		}
	}
	public function insertCustomer($data,$user_type=''){
		
		$this->db->query("Insert into `address` set contact_name = '".$data['fname']." ".$data['lname']."', country_id = '".$data['country']."', state = '".$data['state']."', address = '".$data['address']."', postcode = '".$data['post_code']."', mobile = '".$data['mobile']."'");
		$address=$this->db->insert_id();
		$this->db->query("Insert into `customer` set password ='".md5($data['pass'])."', first_name ='".$data['fname']."', last_name ='".$data['lname']."', email ='".$data['email']."', address =".$address.", date_added = NOW()");
		$customer_id=$this->db->insert_id();
		$unique_id=date('dmy')."".random_string('alnum', 2)."".date('his');
		$this->db->query("UPDATE `customer` SET  customer_unique_id ='".$unique_id."' where customer_id =".$customer_id);
		if($user_type =='cmp' || isset($data['user_type']))
		{
			$this->db->query("UPDATE `customer` SET  is_company ='1' where customer_id =".$customer_id);
			$this->db->query("Insert into `address` set contact_name = '".$data['company_name']."', country_id = '".$data['country']."', state = '".$data['cmp_state']."', address = '".$data['cmp_address']."', postcode = '".$data['cmp_post_code']."'");
			$cmp_address=$this->db->insert_id();
			$this->db->query("Insert into `customer_company` set customer_id = ".$customer_id.", company_name ='".$data['company_name']."' , company_website ='".$data['company_website']."', company_address =".$cmp_address);
		}
	}
	/*public function insertCustomerApi($data){
		$this->db->query("Insert into `address` set contact_name = '".$data['fname']." ".$data['lname']."', country_id = '".$data['country']."', state = '".$data['state']."', mobile = '".$data['mobile']."'");
		$address=$this->db->insert_id();
		$this->db->query("Insert into `customer` set first_name ='".$data['fname']."', last_name ='".$data['lname']."', email ='".$data['email']."', address =".$address);
		
	}*/
	public function validate_customer($data){	
		$query =$this->db->query("SELECT customer_id,first_name,customer_group_id FROM `customer` where email = '".$data['email']."' and password = '".md5($data['password'])."'");
		return $query->result_array();
	}
	public function get_customer($customer_id)
	{
		$query =$this->db->query("SELECT c.*,cn.name as bankname from `customer` c left join country cn on c.bank_country=cn.country_id where customer_id =".$customer_id);
		return $query->result_array();
	}
	public function validateCompanyKey($key)
	{
		$query=$this->db->query("SELECT customer_id from `customer` where is_company = 1 and customer_unique_id ='".$key."'");
		return $query->result_array();
	}
	public function editProfile($customer_id,$data,$profile_photo)
	{
		if($profile_photo=='0')
		$profile_photo="";
		else
		$profile_photo=", photo='".$profile_photo."'";
		
		$data['dispatcher']=isset($data['dispatcher_location'])?'1' : '0';
		
		/*$query=$this->db->query("UPDATE `customer` SET first_name='".$data['first_name']."'".$profile_photo.",last_name='".$data['last_name']."' where customer_id = ".$customer_id);*/
		$query=$this->db->query("UPDATE `customer` SET first_name='".$data['first_name']."'".$profile_photo.",last_name='".$data['last_name']."',customer_add='".$data['customer_add']."',customer_phone='".$data['customer_phone']."',business_info='".$data['business_info']."',business_type='".$data['business_type']."',bank_ac='".$data['bank_ac']."',dr_cr_card='".$data['dr_cr_card']."',purpose_code='".$data['purpose_code']."',dispatcher ='".$data['dispatcher']."', dispatcher_location ='".json_encode($data['dispatcher_location'])."', password='".md5($data['password1'])."' where customer_id = ".$customer_id);
	}
	function email_exists($email)
	{
   		$this->db->where('email',$email);
    	$query = $this->db->get('customer');
    	if ($query->num_rows() > 0){
		
        	return FALSE;
    	}
		else{
			return TRUE;
		}
	}
	public function forgetPassword($data)
	{
		$confirm_code=random_string('alnum', 7);
		$query=$this->db->query("UPDATE `customer` SET is_forget_password =1, confirmation_code='".$confirm_code."' where email='".$data['forget_email']."'");
		return $confirm_code;
		
	}
	public function get_cust_ip($cust_id)
	{
		$query =$this->db->query("SELECT * FROM `customer_ip` where customer_id = ".$cust_id);
		return $query->result_array();
	}

	public function update_cust_id($ip,$last_ip,$last_country,$last_city,$ip_con,$customer_id)
	{
		$dt=date('Y-m-d');
		$this->db->query("UPDATE `customer_ip` SET ip = '".$ip."',customer_last_id='".$last_ip."',last_country='".$last_country."',last_city='".$last_city."',country='".$ip_con."',date_added='".$dt."' where customer_id = ".$customer_id);
	}

	public function insert_cust_id($ip,$customer_id,$con)
	{
		$dt=date('Y-m-d');
		$this->db->query("INSERT INTO `customer_ip` SET ip = '".$ip."',customer_last_id='".$ip."',customer_id =".$customer_id.",country='".$con."',last_country='".$con."',date_added='".$dt."'");
	}
}?>
<?php
class Service extends CI_Controller{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->helper('url');
		$this->load->model('service_model');
		
		$this->load->helper('form');
		$this->load->library('form_validation');		
		
	}
	public function index() {
		/* if(!$this->session->userdata('customer_id'))
		redirect(home); */
				
		$data='';
		
		$data['customer_id'] = $this->session->userdata('customer_id');
		
		if(!$data['customer_id']){
			$data['logged_in'] = '1';			
		} else {
			$data['logged_in'] = '0';
		}
		
			$this->load->model('currencies_model');
		if(!$this->session->userdata("currencies"))
		{
			if($this->session->userdata('currency_id')){
			$currency_id = $this->session->userdata('currency_id');		
			} else { 
				$currency_id = '2';				
			}
			$this->session->set_userdata("currencies",$this->currencies_model->getCurrencies());
			$this->session->set_userdata('currency_id',$currency_id);		
		}
		if($this->session->userdata('currency_id')){
		$currency_id = $this->session->userdata('currency_id');		
		} else { 
			$currency_id = '2';				
		}
		$currency_detail = $this->currencies_model->getCurrencyInfo($currency_id);		
		$data['currency_symbol'] = $currency_detail->symbol_left!=''?$currency_detail->symbol_left:$currency_detail->symbol_right;
				
		$data['currency_title'] = $currency_detail->title;
		
		$value = $currency_detail->value;	
		
		$data['value'] = $value;
		
						
		$this->load->model('category_model');
		$categories=$this->category_model->get_categories('0');
		$data['categories'] = array();
		$service_category_id='';		
		if(isset($_GET['category_id']))
		{$service_category_id=$_GET['category_id'];
		$data['selected_category_id']=$_GET['category_id'];		
		}
		foreach($categories as $category){
			$children_data = array();
			$children=$this->category_model->get_categories($category['category_id']);
			if($service_category_id == $category['category_id'])
			$data['selected_service']=$category['name'];
			foreach($children as $child)
			{
				if($service_category_id == $child['category_id'])
				$data['selected_service']=$child['name'];
			
				$children_data[] = array(
					'category_id' => $child['category_id'],
					'name'        => $child['name'] 
				);	
			}
			
			$data['categories'][] = array(
				'category_id' => $category['category_id'],
				'name'        => $category['name'] ,
				'children'    => $children_data
			);	
		}
		$this->load->model('service_model');
		
		if(isset($_GET['page']))
		$page=$_GET['page'];
		else
		$page=1;
		
		if(isset($_GET['limit']))
		$limit=$_GET['limit'];
		else
		$limit=10;
		
		$data['page']=$page;
		$data['limit']=$limit;
		$page_limit='LIMIT '.(($page-1)*$limit).','.$limit;		
		if(isset($_GET['offer']))
		{
			$data['serviceTxt']=$this->service_model->getServiceTxt($service_category_id,1);
			$services=$this->service_model->get_accepted_offer($service_category_id,'','',$page_limit,'',1);
		}
		else
		{
			$services=$this->service_model->get_services($service_category_id,'','',$page_limit);
			$data['serviceTxt']=$this->service_model->getServiceTxt($service_category_id);
		}
		$data['services']=$services['result'];
		$data['total']=$services['total'];		
		
		/* Kinnari */
		$this->load->model('customer_model');
		$cust_detail=$this->customer_model->get_customer($customer_id); 
		$data['cust_detail']=$cust_detail;
		/* Kinnari */
		$this->load->view('header',$data);
		if(isset($_GET['offer']))
		$this->load->view('offer_list',$data);
		else
		$this->load->view('service_list',$data);
		$this->load->view('footer',$data);
	}
	public function offerBidAccept($bid_id,$customer_id,$service_id)
	{
		$services=$this->service_model->offerBidAccept($service_id,$customer_id,$bid_id);		
		redirect("service/details/".$service_id."/offer");
	}
	public function bid($service_id){
		$customer_id=$this->session->userdata('customer_id');
		$data['own_service']='no';
		$services=$this->service_model->get_services('',$service_id);
		$data['bids']=$this->service_model->getBid('',$service_id);
		$data['bidexist']=array();
		
		$award=$this->service_model->getAward($service_id,$customer_id);
		$data['awarded']=$award;
		
		if($customer_id!='')
		{
			$data['bidexist']=$this->service_model->getBid($customer_id,$service_id);
			$data['login']='yes';
		}
		else
		$data['login']='no';
		
		$data['services']=$services[0];
		if(($data['services']['customer_id']==$customer_id || $this->session->userdata('customer_group_id')==2 )&& $customer_id!='')
		$data['bidexist']=array(1);
		if($data['services']['customer_id']==$customer_id )
		$data['own_service']='yes';
		$data['bids']=$this->service_model->getBid('',$service_id);
		
		/* Kinnari */
		$this->load->model('customer_model');
		$cust_detail=$this->customer_model->get_customer($customer_id); 
		$data['cust_detail']=$cust_detail;
		/* Kinnari */
		$this->load->view('header',$data);
		$this->load->view('bid_manage',$data);
		$this->load->view('footer',$data);
	}
	public function manage(){
		$data='';
		$customer_id=$this->session->userdata('customer_id');
		$data['services']=$this->service_model->get_services('','',$customer_id);
		
		/* Kinnari */
		$this->load->model('customer_model');
		$cust_detail=$this->customer_model->get_customer($customer_id); 
		$data['cust_detail']=$cust_detail;
		/* Kinnari */
		$this->load->view('header',$data);
		$this->load->view('service_manage',$data);
		$this->load->view('footer',$data);
	}
	
	public function details($service_id,$offer=''){
		$customer_id=$this->session->userdata('customer_id');		
		if($this->input->server('REQUEST_METHOD')=='POST')
		{
			if(!$this->session->userdata('customer_id'))
			{
				redirect('sign_in');
			}
			if($this->service_model->matchService($customer_id,$this->input->post('category_id')))
			{
				$this->load->model('message_model');
				$from=$this->message_model->getEmail($customer_id);
				$to=$this->message_model->getEmail($this->input->post('service_buyer_id'));
				$snd_msg=array('service_id'=>$service_id,'sender_id'=>$customer_id,'service_provider_id'=>$customer_id,'service_buyer_id'=>$this->input->post('service_buyer_id'),'subject'=>'Bid On your product','message'=>$this->input->post('message_body'),'from'=>$from[0]['email'],'to'=>$to[0]['email']);
				$this->message_model->insert_message($snd_msg);
				
				$this->service_model->insertBid($service_id,$this->input->post(),$customer_id);
				
				$receiver_email = $to[0]['email'];
				
				$service_name = $this->service_model->getServiceName($service_id);		
						
				$subject = 'Bid for Service Posted';
				
				$msg_body = 'There is one bid for your service '.$service_name;
												
				$headers  = 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
				$headers .= 'From: Trustedpayer <info@trustedpayer.com>' . "\r\n";
				$flag=mail($receiver_email, $subject, $msg_body, $headers);

			}
			else{
				$this->session->set_flashdata('bid-message', 'Service category not match with your profile!<br>Click <a href="'.base_url().'index.php/profile/edit">HERE</a> to Update profile');
			}
			if(!$offer)
			redirect('service/details/'.$service_id);
			else
			redirect('service/details/'.$service_id."/offer");
		}
		
		$data='';
		$data['own_service']='no';
		
		if(!$offer)
		{	
			$services=$this->service_model->get_services('',$service_id);			
		}else
		{			
			$services=$this->service_model->get_services('',$service_id,'','','',1);		
		}

		$customer_group_id=$this->session->userdata('customer_group_id');

if($customer_group_id == 2){
	
		$data['bids']=$this->service_model->getBid('',$service_id);
} else {
		$data['bids']=$this->service_model->getBid($customer_id,$service_id);

}

/*		echo '<pre>';
		print_r($data['bids']);
		exit;
*/						
	
	

//echo $this->session->userdata('customer_group_id');exit;


		/*	$data['Buyer']=$this->service_model->getCustomerRequirement($service_id);	
$posted_custID = $data['Buyer'][0]['customer_id'];*/

	
		$data['bidexist']=array();
		
		$data['ownbidexist']=array();
		if($customer_id!='')
		{
			// Change by RAVI to solve error eddited -> from bidexist to ownbidexist
			$data['ownbidexist']=$this->service_model->getBid($customer_id,$service_id);
			
			$data['login']='yes';
		}
		else
		$data['login']='no';
		
/*echo '<pre>';
		print_r($data['milestones']);
		exit;
*/		
//$data['milestones']=$this->service_model->getMilestones($service_id);
		if(!$services[0])
		redirect(home);
		 $data['services']=$services[0];	
				
		$customer_id=$this->session->userdata('customer_id');		
/*echo $customer_id;
		echo '<pre>';
		print_r($data['services']);
		exit;
		
	*/	
		if(($data['services']['customer_id']==$customer_id || $this->session->userdata('customer_group_id')==2 )&& $customer_id!='' || count($data['ownbidexist']))
		$data['bidexist']=array(1);
/*		echo '<pre>';
		print_r(count($data['bidexist']));
		exit;
*/		
		if(($data['services']['customer_id']==$customer_id || $this->session->userdata('customer_group_id')==1 )&& $customer_id!='')
		$data['bidexist_Provider']=array(1);
		
		if($data['services']['customer_id']==$customer_id )
		$data['own_service']='yes';
		
	
	$data['user_group']='not buyer';
		if($this->session->userdata('customer_group_id')==2 )
		{
			$data['user_group']= 'buyer';
		}
	
		$data['customer_group_id'] = $customer_group_id;
		
		if($customer_group_id == 3){
			
		$data['Buyer']=$this->service_model->getCustomerRequirement($service_id);	
		
			if($data['Buyer'][0]['customer_id'] == $customer_id){				
				$this->session->set_userdata('customer_group_id','2');		
			} else {
				$this->session->set_userdata('customer_group_id','1');		
			}
		}
		
		
		//$results=$this->service_model->getMilestones($service_id);
//		echo count($bids);
		
		if($customer_group_id == 1)
			$bidexistForService = $this->service_model->getBidExistForService($service_id,$customer_id);
		else
			$bidexistForService = '';
		/*
		echo '<pre>';
		print_r($bidexistForService);
		echo count($bidexistForService);
		exit;*/
		
		
if(count($data['bidexist'])){	
		if(count($bidexistForService)){				
			if($customer_group_id == 2){
					$results=$this->service_model->getMilestonesPerBid($service_id);			
			} else {
					$bid_customerid = $this->service_model->getCustomerPerBid($customer_id,$service_id);
					$results=$this->service_model->getMilestonesPerBid($service_id,$bid_customerid);			
			}


		$data['milestones'] = array();
		foreach ($results as $data1) {
  			$id = $data1['bid_id'];
			$customer_id = $this->service_model->getBidCustomer($id);
			$award_status = $this->service_model->getBidStatus($id);			
			$data['milestones'][$id]['messages'] = $this->service_model->getMessages($customer_id,$service_id);	
			$data['milestones'][$id]['service_id'] = $service_id;	
			
		$data['messagesReceiver']=  $this->service_model->getMessagesReceiverIfBuyer($service_id,$id);
		
		
		$data['messagesReceiverProvider']=  $this->service_model->getMessagesReceiverIfProvider($service_id);
			
			if($data['user_group']== 'buyer')
				$data['recvr_id'] = $data['messagesReceiver'][0]['customer_id'];
			else		
				$data['recvr_id'] = $data['messagesReceiverProvider'][0]['customer_id'];		
								
			
			
			$data['milestones'][$id]['receiver_id'] = $data['recvr_id'];	
			
			$data['milestones'][$id]['bid_id'] = $id;	
			$data['milestones'][$id]['award_status'] = $award_status;	
  			if (isset($data['milestones'][$id])) {
     			$data['milestones'][$id]['milestone'][] = $data1;
				
  			} else {				
     			$data['milestones'][$id]['milestone'] = array($data1);
				
 			}

		} 
	}
}
	/*	echo '<pre>';
		print_r($data['milestones']);
		exit;
 */
/*		$data['messages']=  $this->service_model->getMessages($customer_id,$service_id);
		
		$data['messagesReceiver']=  $this->service_model->getMessagesReceiverIfBuyer($service_id);
		
		$data['messagesReceiverProvider']=  $this->service_model->getMessagesReceiverIfProvider($service_id);
*/


/*echo '<pre>';
 print_r($data['messages']);
	exit;
*/	
	//	echo $customer_id.'hihi'.$service_id;

 //   $data['recvr_id']=$customer_id;
	$data['service_id']=$service_id;
		
		$customer_id=$this->session->userdata('customer_id');		

		$data['customerInfo']=  $this->service_model->getCustomerInfo($customer_id);
		
		$data['pic'] = $data['customerInfo'][0]['photo'];
				
		$data['customer_name'] = $data['customerInfo'][0]['customer_name'];
	
/*		if(count($data['messages'])){

			if($data['user_group']== 'buyer')
				$data['recvr_id'] = $data['messagesReceiver'][0]['supplier_id'];
			else		
				$data['recvr_id'] = $data['messagesReceiverProvider'][0]['customer_id'];		
					}
*/					
					
/*			echo $data['recvr_id'];
			exit;		
*///echo $data['messagesReceiver'][0]['supplier_id'];exit;
		
		
/*		echo $this->session->userdata('customer_group_id');
		exit;
*/				$bids=$this->service_model->serviceAvailableProvider($service_id);

	// Change by RAVI to solve error added --> && ($data['own_service']=='yes' || count($data['ownbidexist']))
	if(count($data['bids']) && ($data['own_service']=='yes' || count($data['ownbidexist']))){
		if (count($data['ownbidexist'])){ 
			$this->session->set_userdata('customer_group_id','1');
				$award=$this->service_model->getAwardForProvider($service_id,$customer_id);
				$data['awarded_provider']=$award;
			$data['final_award'] = $award;
		} else if($data['own_service']=='yes') {
			$this->session->set_userdata('customer_group_id','2');
				$award=$this->service_model->getAwardForBuyer($service_id,$customer_id);				
				$data['awarded_buyer']=$award; 		
			$data['final_award'] = $award;
				
		}}
		$data['mou']=$this->service_model->mu();
		$data['termAgreement'] = $this->service_model->ta($service_id);
		if(isset($data['termAgreement'][0]['availabity']))
		$serviceJob = (json_decode($data['termAgreement'][0]['availabity'],true));		
		$data['country1']='';
		$data['country2']='';
		$data['state1']='';
		$data['state2']='';
		$aa = array();
		$aa1 = array();
		$c1 = array();
		$c2 = array();	
		if(isset($serviceJob['country']))
		{
			
			foreach($serviceJob['country'][1] as $key=> $sd)
			{
				if($sd=='*')				
				$aa[]='';
				else
				$aa[]=$this->service_model->get_contry($sd);
				
				if($serviceJob['state'][2][$key] =="*")	
				$c1[]='';
				else
				$c1[]=$this->service_model->get_zone($serviceJob['state'][1][$key]);
				
			}
			foreach($serviceJob['country'][2] as $key=> $sd)
			{
				if($sd=='*')
				$aa[]='*';
				else
				$aa1[]=$this->service_model->get_contry($sd);
				
				if($serviceJob['state'][2][$key] =="*")
				$c1[]='';
				else
				$c2[]=$this->service_model->get_zone($serviceJob['state'][2][$key]);				
			}
		}			
		$data['country1']=$aa;
		$data['country1']=$aa1;
		$data['state1']=$c1;
		$data['state2']=$c2;
		$this->load->model('currencies_model');
	if(!$this->session->userdata("currencies"))
	{
		if($this->session->userdata('currency_id')){
		$currency_id = $this->session->userdata('currency_id');		
		} else { 
			$currency_id = '2';				
		}
		$this->session->set_userdata("currencies",$this->currencies_model->getCurrencies());
		$this->session->set_userdata('currency_id',$currency_id);		
	}
	if($this->session->userdata('currency_id')){
	$currency_id = $this->session->userdata('currency_id');		
	} else { 
		$currency_id = '2';				
	}
	$currency_detail = $this->currencies_model->getCurrencyInfo($currency_id);		
	$data['currency_symbol'] = $currency_detail->symbol_left!=''?$currency_detail->symbol_left:$currency_detail->symbol_right;
			
	$data['currency_title'] = $currency_detail->title;
	
	$value = $currency_detail->value;	
	
	$data['value'] = $value;
	
		/* Kinnari */
		$this->load->model('customer_model');
		$cust_detail=$this->customer_model->get_customer($customer_id); 
		$data['cust_detail']=$cust_detail;
		/* Kinnari */
		
		
		$this->load->view('header',$data);
		$this->load->view('service_detail',$data);
		$this->load->view('footer',$data);
	}

	


	public function sendReply($receiver_id,$message,$product_id) {
				
		$sender_id=$this->session->userdata('customer_id');
		$this->load->model('message_model');
		$receiver_details=  $this->message_model->receiver_details($receiver_id,$message,$product_id);
		$cus_id=$this->session->userdata('customer_id');	
		$userType=$this->message_model->getSenderDetail($cus_id);
		$group_id=$this->session->userdata('customer_group_id');
	if($group_id==1){
		//supplier login -> buyer messages	
			
		$receiver_email=$receiver_details[0]['customer_email'];
		$supplier_email=$receiver_details[0]['supplier_email'];
		$reply_id=$receiver_details[0]['id'];
		$subject=$receiver_details[0]['subject'];
		$msg_body=urldecode($message);
		$sender_id=$receiver_details[0]['supplier_id'];
		$customer_receiver_id=$receiver_details[0]['customer_id'];
		
		$msseger_name=$receiver_details[0]['customer_name'];
		$message_rows='<li>';
		if($receiver_details[0]['photo']=='')
		$message_rows.='<img src="'.base_url().'img/unknown.png " alt="">';
		else
        $message_rows.='<img src="'.base_url().$receiver_details[0]['photo'].'" alt="">';
        $message_rows.=' <div class="details" style="float: none;">
                                <div class="name"><strong>'.$msseger_name.'</strong></div>
                                <div class="massage-display">
                                 '.$msg_body.'
                                </div>
                                </div>
							
  							</li>';
		//Inserting data
		$this->db->query("INSERT INTO `message` SET customer_id = ".$customer_receiver_id.", supplier_id = ".$sender_id.", product_id = ".$product_id." ,subject = '".$subject."',message_body = '".$msg_body."' ,customer_email = '".$receiver_email."',supplier_email = '".$supplier_email."' ,added_on='".date("Y-m-d H:i:s")."',message_type='Reply' ,reply_id=".$reply_id." ,sender_id=".$sender_id."");
		$this->db->query("UPDATE `message` SET `read` = 1 where supplier_id = ".$sender_id." and product_id = ".$product_id." and sender_id <> ".$sender_id);
		//end
		
		
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'From: Trustedpayer <info@trustedpayer.com>' . "\r\n";
		//$flag=mail($receiver_email, $subject, $msg_body, $headers);
	}
	else
	{
		//buyer login -> supplier messages
		$receiver_email=$receiver_details[0]['supplier_email'];
		$customer_email=$receiver_details[0]['customer_email'];
		$customer_id=$receiver_details[0]['customer_id'];
		$supplier_id=$receiver_details[0]['supplier_id'];
	
		$reply_id=$receiver_details[0]['id'];
		$subject=$receiver_details[0]['subject'];
		$msg_body=urldecode($message);
		$sender_id=$receiver_details[0]['customer_id'];
		
		$msseger_name=$receiver_details[0]['customer_name'];
		//$message_rows="<li><strong>".$msseger_name."</strong>:".$msg_body."</li>";
		
		$message_rows='<li>';
		if($receiver_details[0]['photo']=='')
		$message_rows.='<img src="'.base_url().'img/unknown.png " alt="">';
		else
        $message_rows.='<img src="'.base_url().$receiver_details[0]['photo'].'" alt="">';
                            
                           
                                 $message_rows.='<div class="details" style="float: none;">
                                <div class="name"><strong>'.$msseger_name.'</strong></div>
                                <div class="massage-display">
                                 '.$msg_body.'
                                </div>
                                </div>
							
  							</li>';
		
		//Inserting data
		$this->db->query("INSERT INTO `message` SET customer_id = ".$customer_id.", supplier_id = ".$supplier_id.", product_id = ".$product_id." ,subject = '".$subject."',message_body = '".$msg_body."' ,customer_email = '".$customer_email."',supplier_email = '".$receiver_email."' ,added_on='".date("Y-m-d H:i:s")."',message_type='Reply' ,reply_id=".$reply_id." ,sender_id=".$sender_id."");
		$this->db->query("UPDATE `message` SET `read` = 1 where customer_id = ".$customer_id." and product_id = ".$product_id." and sender_id <> ".$sender_id);
		//end
		
		
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'From: Trustedpayer <info@trustedpayer.com>' . "\r\n";
		//$flag=mail($receiver_email, $subject, $msg_body, $headers);
	}
		
		
		echo json_encode(array("Result"=>1,"message_item"=>$message_rows,"receiver_id"=>$receiver_id,"product_id"=>$product_id));
		
	}



	
	
	
	public function award($bid_id,$bidder_id,$service_id,$offer=''){
		
		$this->load->model('currencies_model');
		$currncy = $this->currencies_model->getCurrencyInfo($this->session->userdata("currency_id"));	
		$customer_id=$this->session->userdata('customer_id');
		$bid=$this->service_model->getBid('',$service_id);		
		if($offer=='')		
			$service=$this->service_model->get_services('',$service_id);
		else		
			$service=$this->service_model->get_services('',$service_id,'','','',1);	
		$milestone=$this->service_model->getMilestones('','',$bid_id);
		$payee_key=$this->service_model->getKeybyId($bid[0]['customer_id']);
		$fields = array(
						'order_id' => $bid_id,
						'company_key'=> '251113Zy103013',
						'name'=> $bid[0]['customer_name'],
						'total_amount' => $bid[0]['bid_amount'],
						'shipping_address' => '',
						'shipping_city' => '',
						'shipping_country' => '',
						'quantity' => 1,
						'milestone' => $bid[0]['milestone'],
						'milestone_id' => $milestone[0]['milestone_id'],
						'product_id' => $service_id,
						'product_desc' => $service[0]['service_name'],
						'payee_key' => urlencode($payee_key),
						'sucess_redirect_url' => base_url().'index.php/payment_response',
						'cancel_redirect_url' => base_url().'index.php/payment_response',
						'currency_code'=>$currncy->code
				);
		//print_r($fields);
		//die();
		$url = 'http://trustedpayer.com/index.php/api/key/format/json';		
		$fields_string='';
		foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
		rtrim($fields_string, '&');
		
		//open connection
		$ch = curl_init();
		
		//set the url, number of POST vars, POST data
		curl_setopt($ch,CURLOPT_URL, $url);
		curl_setopt($ch,CURLOPT_POST, count($fields));
		curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_NOBODY, false);
		//execute post
		$result = curl_exec($ch);
		
		//close connection
		curl_close($ch);
		$res=json_decode($result,true);
		if($res['status']=='success')
		{
			$url = 'http://trustedpayer.com/index.php/order/payment?id='.$res['key'];
			redirect($url);
		}
		else
		{
			echo 'failed';
			die();
		}
		
		//$this->service_model->insertAward($bid_id);
		//	redirect('service/details/'.$service_id);
	}
	
	public function acceptAward($bid_id,$bidder_id,$service_id){
		$customer_id=$this->session->userdata('customer_id');
		
/*echo $bid_id;
echo $bidder_id;
echo $customer_id;
exit;
*/
		$this->service_model->acceptAward($bid_id);

		$receiver_email = $this->service_model->getCustomerEmail($service_id);
		
		$service_name = $this->service_model->getServiceName($service_id);		
				
		$subject = 'Accpetance of Service Request';
		
		$msg_body = 'Your Request for the service '.$service_name.' has been accepted';
						
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'From: Trustedpayer <info@trustedpayer.com>' . "\r\n";
		$flag=mail($receiver_email, $subject, $msg_body, $headers);
		
		/* sms */
		$to_query=$this->db->query("SELECT * from `customer` where email='".$receiver_email."' ");
		$to_customer=$to_query->result_array();
		if(isset($to_customer[0]['verify']) && $to_customer[0]['verify'])
		{
			$this->sms->send($msg_body,urlencode("+".$to_customer[0]['phonecode'].$to_customer[0]['customer_phone']));
		}
		/* sms */
			redirect('service/details/'.$service_id);
	}	
	public function acceptMilestone($service_id,$milestone_id,$bid_id)
	{
		$this->load->model('order_model');
		$this->load->model('currencies_model');
		$txn=$this->order_model->getTransactionId($bid_id);
		$bid=$this->service_model->getMilestones('',$milestone_id);
		$currncy = $this->currencies_model->getCurrencyInfo($this->session->userdata("currency_id"));		
		$fields = array(
						'txn_id' => $txn,
						'company_key'=> '251113Zy103013',
						'milestone' => $bid[0]['title'],
						'description' =>$bid[0]['description'],
						'product_id' => $service_id,
						'milestone_id' =>$milestone_id,
						'sucess_redirect_url' => base_url().'index.php/milestone_response',
						'cancel_redirect_url' => base_url().'index.php/service/details/'.$service_id,
						'currency_code'=>$currncy->code
				);
		
		$url = 'http://trustedpayer.com/index.php/api/key/format/json';			
		$fields_string='';
		foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
		rtrim($fields_string, '&');
		
		//open connection
		$ch = curl_init();
		
		//set the url, number of POST vars, POST data
		curl_setopt($ch,CURLOPT_URL, $url);
		curl_setopt($ch,CURLOPT_POST, count($fields));
		curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_NOBODY, false);
		//execute post
		$result = curl_exec($ch);
		
		//close connection
		curl_close($ch);
		$res=json_decode($result,true);
		if($res['status']=='success')
		{
			$url = 'http://trustedpayer.com/index.php/order/milestone_payment?id='.$res['key'];
			redirect($url);
		}
		else
		{
			echo 'failed';
			die();
		}
	}
	public function sendMilestone($status){
		
		$service_id = $this->input->post('service_id');
		$customer_id=$this->session->userdata('customer_id');
		if($status=='created')
		$status='Incomplete';
			else
		{
			$this->load->model('message_model');
			$service_buyer=$this->service_model->getServiceCustomer($service_id);
			$from=$this->message_model->getEmail($customer_id);
			$to=$this->message_model->getEmail($service_buyer[0]['customer_id']);
			$snd_msg=array('service_id'=>$service_id,'sender_id'=>$customer_id,'service_provider_id'=>$customer_id,'service_buyer_id'=>$service_buyer[0]['customer_id'],'subject'=>'Accept Your Bid','message'=>'Milestone is requested !','from'=>$from[0]['email'],'to'=>$to[0]['email']);
			$this->message_model->insert_message($snd_msg);
		
				$receiver_email = $to[0]['email'];
				
				$service_name = $this->service_model->getServiceName($service_id);		
						
				$subject = 'Milestone Requested';
				
				$msg_body = 'Milestone has been Requested';
												
				$headers  = 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
				$headers .= 'From: Trustedpayer <info@trustedpayer.com>' . "\r\n";
				$flag=mail($receiver_email, $subject, $msg_body, $headers);
				/* sms */
				$to_query=$this->db->query("SELECT * from `customer` where email='".$receiver_email."' ");
				$to_customer=$to_query->result_array();
				if(isset($to_customer[0]['verify']) && $to_customer[0]['verify'])
				{
					$this->sms->send($msg_body,urlencode("+".$to_customer[0]['phonecode'].$to_customer[0]['customer_phone']));
				}
				/* sms */
		}
		$milestone_id=$this->service_model->insertMilestone($this->input->post(),$status);
		if($status=='Incomplete')
			$this->acceptMilestone($service_id,$milestone_id,$this->input->post('bid_id'));
		if($this->input->post('offer')>0)
		redirect('service/details/'.$service_id."/offer");
		else
		redirect('service/details/'.$service_id);
	}
	
	public function ReleaseMilestone($service_id,$milestone_id,$bid_id){
		
		$this->load->model('order_model');
		$txn=$this->order_model->getTransactionId($bid_id);
		$bid=$this->service_model->getMilestones('',$milestone_id);
		$fields = array(
						'txn_id' => $txn,
						'company_key'=> '251113Zy103013',
						'milestone_transaction' => $bid[0]['payment_transaction_id'],
						'sucess_redirect_url' => base_url().'index.php/milestone_response',
						'cancel_redirect_url' => base_url().'index.php/milestone_response',
				);
		//print_r($fields);
//		die();
		$url = 'http://trustedpayer.com/index.php/api/key/format/json';		
		$fields_string='';
		foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
		//$fields_string.="company_name=manish&company_website=www.epagestore.com&";
		rtrim($fields_string, '&');
		
		//open connection
		$ch = curl_init();
		
		//set the url, number of POST vars, POST data
		curl_setopt($ch,CURLOPT_URL, $url);
		curl_setopt($ch,CURLOPT_POST, count($fields));
		curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_NOBODY, false);
		//execute post
		echo $result = curl_exec($ch);
		
		//close connection
		curl_close($ch);
		//echo $fields_string;		
	 $res=json_decode($result,true);		
		if($res['status']=='success')
		{
			$url = 'http://trustedpayer.com/index.php/order/milestone_release?id='.$res['key'];
			redirect($url);
		}
		else
		{
			echo 'failed';
			die();
		}
		/*$this->service_model->releaseMilestone($milestone_id);
			redirect('service/details/'.$service_id);*/
	}	

	public function sendReview_comment($service_id,$receiver_id,$review_comment){

			$customer_id=$this->session->userdata('customer_id');

			$review_exist=$this->service_model->getReview($service_id,$customer_id,$receiver_id);
										
			if(empty($review_exist))
				$temp = 0;
			else
				$temp = 1;
			
												
			if($temp == 0)
			{
				$this->service_model->insertReviewComment($service_id,$customer_id,$receiver_id,urldecode($review_comment));
			} else { 
				$this->service_model->updateReviewComment($service_id,$customer_id,$receiver_id,urldecode($review_comment));			
			}
	}

	public function star($service_id,$receiver_id){
		
			$id = preg_replace("/[^0-9]/","",$_REQUEST['id']);
			$stars = preg_replace("/[^0-9]/","",$_REQUEST['stars']);
			
/*			echo $id;
			echo $stars;
			echo $service_id;
			echo $receiver_id;
			exit;		
*/
			$customer_id=$this->session->userdata('customer_id');

/*echo $customer_id;
exit;
*/
			$review_exist=$this->service_model->getReview($service_id,$customer_id,$receiver_id);
			
			if(empty($review_exist))
				$temp = 0;
			else
				$temp = 1;
			
			if($id == 1)
				$criteria = 'delivery_time';
			else if($id == 2)
				$criteria = 'professionality';
			
			if($temp == 0)
			{
				$this->service_model->insertReview($service_id,$customer_id,$receiver_id,$criteria,$stars);
			} else { 
				$this->service_model->updateReview($service_id,$customer_id,$receiver_id,$criteria,$stars);			
			}
			
				
/*			$q=mysql_num_rows(mysql_query("select id from ratings where id=$id_sent"));
			if(!$q)mysql_query("insert into ratings (id,date) values ($id_sent,curdate())");
			if ($vote_sent > $units) die("Sorry, vote appears to be invalid."); // kill the script because normal users will never see this.
			
			//connecting to the database to get some information
			$query = mysql_query("SELECT total_votes, total_value, used_ips FROM $rating_dbname.$rating_tableName WHERE id='$id_sent' ")or die(" Error: ".mysql_error());
			$numbers = mysql_fetch_assoc($query);
			$checkIP = unserialize($numbers['used_ips']);
			$count = $numbers['total_votes']; //how many votes total
			$current_rating = $numbers['total_value']; //total number of rating added together and stored
			$sum = $vote_sent+$current_rating; // add together the current vote value and the total vote value
			$tense = ($count==1) ? "vote" : "votes"; //plural form votes/vote
			
			// checking to see if the first vote has been tallied
			// or increment the current number of votes
			($sum==0 ? $added=0 : $added=$count+1);
			
			// if it is an array i.e. already has entries the push in another value
			((is_array($checkIP)) ? array_push($checkIP,$ip) : $checkIP=array($ip));
			$insertip=serialize($checkIP);
			
			//IP check when voting
			if(!isset($_COOKIE['rating_'.$id_sent])){
			$voted=mysql_num_rows(mysql_query("SELECT used_ips FROM $rating_dbname.$rating_tableName WHERE used_ips LIKE '%".$ip."%' AND id='".$id_sent."' "));
												}
			else $voted=1;									
			if(!$voted) {     //if the user hasn't yet voted, then vote normally...
			
				if (($vote_sent >= 1 && $vote_sent <= $units)) { // keep votes within range, make sure IP matches 
			
					$update = "UPDATE $rating_tableName SET total_votes='".$added."', total_value='".$sum."', used_ips='".$insertip."' WHERE id='$id_sent'";
					$result = mysql_query($update);	
					if($result)	setcookie("rating_".$id_sent,1, time()+ 2592000);
				} 
			} //end for the "if(!$voted)"
			// these are new queries to get the new values!
			$newtotals = mysql_query("SELECT total_votes, total_value, used_ips FROM $rating_tableName WHERE id='$id_sent' ")or die(" Error: ".mysql_error());
			$numbers = mysql_fetch_assoc($newtotals);
			$count = $numbers['total_votes'];//how many votes total
			$current_rating = $numbers['total_value'];//total number of rating added together and stored
			$tense = ($count==1) ? "vote" : "votes"; //plural form votes/vote
			
*/			// $new_back is what gets 'drawn' on your page after a successful 'AJAX/Javascript' vote
	/*		if($voted){$sum=$current_rating; $added=$count;}
			$new_back = array();
			for($i=0;$i<5;$i++){
				$j=$i+1;
				if($i<@number_format($current_rating/$count,1)) $class="ratings_stars ratings_vote";
				else $class="ratings_stars";
			$new_back[] .= '<div class="star_'.$j.' '.$class.'"></div>';
								  }*/

//		if($temp == 1){$sum=$current_rating; $added=$count;}
			$new_back = array();
			for($i=0;$i<5;$i++){
				$j=$i+1;
				if($j<=$stars) $class="ratings_stars ratings_vote";
				else $class="ratings_stars";
			$new_back[] .= '<div class="star_'.$j.' '.$class.'"></div>';
			}
			
/*			$new_back[] .= ' <div class="total_votes"><p class="voted"> Rating: <strong>'.@number_format($sum/$added,1).'</strong>/'.$units.' ('.$count.' '.$tense.' cast) ';
			if(!$voted)$new_back[] .= '<span class="thanks">Thanks for voting!</span></p>';
			else {$new_back[] .= '<span class="invalid">Already voted for this item</span></p></div>';}
*/			$allnewback = join("\n", $new_back);
			
			
			
			// ========================
			
			$output = $allnewback;
			echo $output;
}
public function search()
{
	$data='';
		
	$data['customer_id'] = $this->session->userdata('customer_id');
	
	if(!$data['customer_id']){
		$data['logged_in'] = '1';			
	} else {
		$data['logged_in'] = '0';
	}
					
	$this->load->model('category_model');
	$categories=$this->category_model->get_categories('0');
	$data['categories'] = array();
	$service_category_id='';		
	if(isset($_GET['category_id']))
	{$service_category_id=$_GET['category_id'];
	$data['selected_category_id']=$_GET['category_id'];		
	}
	foreach($categories as $category){
		$children_data = array();
		$children=$this->category_model->get_categories($category['category_id']);
		if($service_category_id == $category['category_id'])
		$data['selected_service']=$category['name'];
		foreach($children as $child)
		{
			if($service_category_id == $child['category_id'])
			$data['selected_service']=$child['name'];
		
			$children_data[] = array(
				'category_id' => $child['category_id'],
				'name'        => $child['name'] 
			);	
		}
		
		$data['categories'][] = array(
			'category_id' => $category['category_id'],
			'name'        => $category['name'] ,
			'children'    => $children_data
		);	
	}
	$this->load->model('service_model');
	
	if(isset($_GET['page']))
	$page=$_GET['page'];
	else
	$page=1;
	
	if(isset($_GET['limit']))
	$limit=$_GET['limit'];
	else
	$limit=10;
	
	$data['page']=$page;
	$data['limit']=$limit;
	$page_limit='LIMIT '.(($page-1)*$limit).','.$limit;		
	if(isset($_GET['offer']))
	{		
		$services=$this->service_model->get_accepted_offer($service_category_id,'',''," LIMIT 0, 100",'',1,$this->input->get());
	}
	else
	{
		$services=$this->service_model->get_services($service_category_id,'',''," LIMIT 0, 100",'',0,$this->input->get());		
	}
	$this->load->model('currencies_model');
	if(!$this->session->userdata("currencies"))
	{
		if($this->session->userdata('currency_id')){
		$currency_id = $this->session->userdata('currency_id');		
		} else { 
			$currency_id = '2';				
		}
		$this->session->set_userdata("currencies",$this->currencies_model->getCurrencies());
		$this->session->set_userdata('currency_id',$currency_id);		
	}
	if($this->session->userdata('currency_id')){
	$currency_id = $this->session->userdata('currency_id');		
	} else { 
		$currency_id = '2';				
	}
	$currency_detail = $this->currencies_model->getCurrencyInfo($currency_id);		
	$data['currency_symbol'] = $currency_detail->symbol_left!=''?$currency_detail->symbol_left:$currency_detail->symbol_right;
			
	$data['currency_title'] = $currency_detail->title;
	
	$value = $currency_detail->value;	
	
	$data['value'] = $value;
	if(isset($services['result']))
	$data['services']=$services['result'];
	if(isset($services['total']))
	$data['total']=$services['total'];	
	if(isset($_GET['offer']))
	$this->load->view('offer_search',$data);
	else
	$this->load->view('search',$data);
}

}
?>
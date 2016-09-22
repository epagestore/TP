<?php
class Order_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}
	public function insertOrder($customer_id,$payee_id,$data)
	{	$this->db->query("INSERT INTO `address` SET contact_name = '".$data['fname']." ".$data['lname']."', country_id = ".$data['country'].", address = '".$data['address']."', postcode = '".$data['post_code']."', mobile = '".$data['mobile']."'");
		$address_id=$this->db->insert_id();
		$this->db->query("INSERT INTO `customer_transaction`  SET customer_id = ".$customer_id.", amount = -".$data['amount'].", description ='Order Amount Paid', date_added = NOW()");
		$transaction_id=$this->db->insert_id();
		
		$this->db->query("INSERT INTO `order` SET  order_key =".$data['order_key'].", payer_id = ".$customer_id.", transaction_id =".$transaction_id.", payee_id = ".$payee_id.", shipping_firstname ='".$data['fname']."', shipping_lastname ='".$data['lname']."', shipping_address_1 =".$address_id.", total_amount =".$data['amount'].", order_status_id  =1");
		//$order_id=$this->db->insert_id();
		//$this->db->query("INSERT INTO `order_product` SET order_id =".$order_id.", name = '".$data['product_desc']."', quantity = ".$data['quantity'].", price = ".$data['unitPrice'].", total = ".($data['quantity']*$data['unitPrice'])."");
		
		$this->db->query("UPDATE `customer_account_balance` SET balance_in_process =balance_in_process - ".$data['amount'].", date_modified = NOW() where customer_id = ".$customer_id);
	}
	function aasort (&$array, $key) {
		$sorter=array();
		$ret=array();
		reset($array);
		foreach ($array as $ii => $va) {
			$sorter[$ii]=$va[$key];
		}
		asort($sorter);
		foreach ($sorter as $ii => $va) {
			$ret[$ii]=$array[$ii];
		}
		$array=$ret;
	}

	public function insertApiOrder($customer_id,$payee_id,$data,$company_id,$milestone='')
	{	$trns_desc='';
		$query = $this->db->query(" select * from currency where currency_id=".$this->session->userdata('currency_id'));
		$currency = $query->row();
		
		$amount=$data['total_amount'];
		$is_milestome="";
		if($milestone!='')
		{
			$trns_desc="(Milestone)";
			$amount=$milestone;
			$is_milestome="is_milestone = '1' ,";
		}
		$this->db->query("INSERT INTO `address` SET contact_name = '".$data['name']."', country_id = '".$data['shipping_country']."', address = '".$data['shipping_address']."'");
		$address_id=$this->db->insert_id();
		
		$merchant=$this->db->query("select * from customer where customer_id=".$payee_id)->row();
	//	print_r($data);exit;
		$this->db->query("INSERT INTO `customer_transaction`  SET customer_id = ".$customer_id.", amount = -".$amount.", description ='Order Amount Paid ".$trns_desc."', date_added = NOW()");
		$transaction_id=$this->db->insert_id();
		$this->db->query("INSERT INTO `order` SET ".$is_milestome."company_id=".$company_id.", currency_code='".$currency->code."',currency_value=".$currency->value.", currency_id=".$currency->currency_id.",payer_code='".random_string('alpha', 5)."', payee_code='".random_string('alpha', 5)."',  order_key =".$data['order_id'].", payer_id = ".$customer_id.", transaction_id =".$transaction_id.", payee_id = '".$payee_id."', shipping_firstname ='".$data['name']."', shipping_address_1 ='".$address_id."', total_amount =".$data['total_amount'].", order_status_id  =1,ip='".$data['ip']."',city='".$data['city']."',country='".$data['country']."',countryCode='".$data['countryCode']."',late='".$data['late']."', region='".$data['region']."',regionName='".$data['regionName']."',zip='".$data['zip']."',commission='".$data['commission']."',lon='".$data['long']."', date_added = NOW(), date_modified = NOW()");
		
		$order_id=$this->db->insert_id();
		$this->db->query("INSERT INTO `order_product` SET order_id =".$order_id.", name = '".$data['product_desc']."', quantity = ".$data['quantity'].", total = ".$data['total_amount']." , tp_plan='".$merchant->merchant."',tp_amount='".(($data['total_amount']*$merchant->merchant)/100)."'");
		
		$this->db->query("UPDATE `customer_account_balance` SET balance_in_process =balance_in_process - ".$amount.", date_modified = NOW() where customer_id = ".$customer_id);
		if($milestone!='')
		{
			$this->insertMilestone('',$milestone,$order_id,$transaction_id,'',$data['milestone_id']);
		}
		return $transaction_id;
	}
	public function insertProductApiOrder($customer_id,$data,$company_id)
	{	$trns_desc='';
		$amount=$data['total_amount'];
		
		$this->db->query("INSERT INTO `address` SET contact_name = '".$data['name']."', country_id = '".$data['shipping_country']."', address = '".$data['shipping_address']."'");
		$address_id=$this->db->insert_id();
		
		$query = $this->db->query(" select * from currency where currency_id=".$this->session->userdata('currency_id'));
		$currency = $query->row();
		$prod_trns_id=array();
		$products=$data['product'];
		$this->aasort($products,"payee_key");
		$tmp_id=0;
		$order_id='';
		$current_orders=array();
		//$payee_message=$payer_message='';
		
		foreach($products as $product)
		{
			$payee=$this->getCustomerByKey($product['payee_key']);
			/*if($tmp_id!=0 && $tmp_id!=$payee[0]['customer_id'])
				{
					$to=$payee[0]['email'];
					$subject="Order Product Key";
					$this->sendKeyMail($to,$subject,$payee_message);
					
					$payer_query=$this->db->query("SELECT email from `customer` where customer_id=".$customer_id);
					$payer_customer=$payer_query->result_array();
					$to=$payer_customer[0]['email'];
					$subject="Order Product Key";
					$this->sendKeyMail($to,$subject,$payer_message);
				}
			$payee=$this->getCustomerByKey($product['payee_key']);
			if($tmp_id!=$payee[0]['customer_id'] && $tmp_id!=0){
				
				$payee_message=$payer_message='';
			}*/
			if($tmp_id!=$payee[0]['customer_id'] || $tmp_id==0)
			{
				$product_amount=0;
				$merchant=$this->db->query("select * from customer where customer_id=".$payee[0]['customer_id'])->row();
				$this->db->query("INSERT INTO `order` SET currency_code='".$currency->code."',currency_value=".$currency->value.", currency_id=".$currency->currency_id.",company_id=".$company_id.", payer_code='".random_string('alpha', 5)."', payee_code='".random_string('alpha', 5)."',  order_key =".$data['order_id'].", payer_id = ".$customer_id.", payee_id = ".$payee[0]['customer_id'].", shipping_method ='".$data['shipping_method']."', shipping_firstname ='".$data['name']."', shipping_address_1 =".$address_id.", total_amount =".$data['total_amount'].", order_status_id  =1,ip='".$data['ip']."',city='".$data['city']."',country='".$data['country']."',countryCode='".$data['countryCode']."',late='".$data['late']."', region='".$data['region']."',regionName='".$data['regionName']."',zip='".$data['zip']."',commission='".$data['commission']."',lon='".$data['long']."', date_added = NOW(), date_modified = NOW()");
				$order_id=$this->db->insert_id();
				$current_orders[]=$order_id;
				//email message start from HERE
				//$payee_message=$payer_message.='Your Secrect Keys of order id:'.$order_id;
				
			}
				$this->db->query("INSERT INTO `customer_transaction`  SET customer_id = ".$customer_id.", amount = -".($product['total_amount']).", description ='Order Amount Paid ".$trns_desc."', date_added = NOW()");
				$transaction_id=$this->db->insert_id();
				$prod_trns_id['txn_id'][]=$transaction_id;
				$prod_trns_id['product_key'][]=$product['product_id'];
				if(isset($product['complete_order_time']))
				{
					$complete_order_time=$product['complete_order_time'];
					$complete_order_unit=$product['complete_order_unit'];
				}
				else
				{
					$complete_order_time='1';
					$complete_order_unit='day';
				}
				
				$payer_code=random_string('alpha', 5);
				$payee_code=random_string('alpha', 5);
				
				$this->db->query("INSERT INTO `order_product` SET order_id =".$order_id.",product_key = '".$product['product_id']."', transaction_id =".$transaction_id.", payer_code='".$payer_code."', payee_code='".$payee_code."', name = '".$product['product_desc']."', quantity = ".$product['quantity'].", price = ".$product['amount'].", shipping_cost = ".$product['shipping_cost'].", total = ".$product['total_amount'].", order_product_status_id  =1,complete_order_time='".$complete_order_time."',complete_order_unit='".$complete_order_unit."' , tp_plan='".$merchant->merchant."',tp_amount='".(($product['total_amount']*$merchant->merchant)/100)."'");
				$order_product_id=$this->db->insert_id();
				
				//email message continue... from HERE
				//$payee_message.="<br>Secret Key of (".$product['product_desc'].") order product id :<b>".$product['product_id']."</b> is : ".$payee_code;
				
				//$payer_message.="<br>Secret Key of (".$product['product_desc'].") order product id :<b>".$product['product_id']."</b> is : ".$payer_code;
				
				$product_amount+=$product['total_amount'];
				$this->db->query("UPDATE `order` SET total_amount =".$product_amount." where order_id =".$order_id);
				
				
			
				$tmp_id=$payee[0]['customer_id'];
		}
				//$to=$payee[0]['email'];
				//$subject="Order Product Key";
				//$this->sendKeyMail($to,$subject,$payee_message);
				
				//$payer_query=$this->db->query("SELECT email from `customer` where customer_id=".$customer_id);
				//$payer_customer=$payer_query->result_array();
				//$to=$payer_customer[0]['email'];
				//$subject="Order Product Key";
				//$this->sendKeyMail($to,$subject,$payer_message);
			$current_orders['payee_id']=$tmp_id;
		$this->db->query("UPDATE `customer_account_balance` SET balance_in_process =balance_in_process - ".$amount.", date_modified = NOW() where customer_id = ".$customer_id);
		$this->sendOrderMail($current_orders,$customer_id);
		return $prod_trns_id;
	}
	public function sendOrderMail($current_orders,$customer_id)
	{
		
		
		$payee_d=$this->db->query("SELECT * from `customer` where customer_id=".$current_orders['payee_id'])->row();
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'From: Trustedpayer <info@trustedpayer.com>' . "\r\n";
		$payer_message=$payee_message=$message_body='';
		$message_header='<table bgcolor="#f6f6f6" width="100%" style="font-family:Arial, Helvetica, sans-serif; font-size:13px;">
							<tbody>
									<tr>
										<td>
											<table>
											<tr>
												<td>Dear,'.$this->session->userdata('first_name').' <br>You recently purchased the following items from Yehki.com  with the transaction details  below :</td>
											</tr>
											</table>
											<table cellpadding="5" cellspacing="0" width="100%" border="0" bordercolor="#1996E6" style="border-collapse:collapse; border:1px solid #1996E6; font-family:Arial, Helvetica, sans-serif; font-size:13px;">
												<thead bgcolor="#4472C4">
												<tr>
													<th width="59" style="color:#fff">Date</th>
													<th width="40" style="color:#fff">TP order Id</th>
													<th width="62" style="color:#fff">Payment To</th>
													<th width="44" style="color:#fff">Order Id</th>
													<th width="64" style="color:#fff">Order Amount</th>
													<th width="64" style="color:#fff">Order Summary</th>
													<th width="64" style="color:#fff"></th>
													<th width="50" style="color:#fff"></th><th width="66"></th>
												</tr>
												</thead>';
		$message_header1='<table bgcolor="#f6f6f6" width="100%" style="font-family:Arial, Helvetica, sans-serif; font-size:13px;">
							<tbody>
								<tr>
									<td>
										<table>
											<tr>
												<td>Dear,'.$payee_d->first_name.' <br>Your have received a purchase order  from Iyke Idukpaye@Yehki.com with the following details </td>
											</tr>
										</table>
										<table cellpadding="5" cellspacing="0" width="100%" border="0" bordercolor="#1996E6" style="border-collapse:collapse; border:1px solid #1996E6; font-family:Arial, Helvetica, sans-serif; font-size:13px;">
											<thead bgcolor="#4472C4">
												<tr>
													<th width="59" style="color:#fff">Date</th>
													<th width="40" style="color:#fff">TP order Id</th>
													<th width="62" style="color:#fff">Payment To</th>
													<th width="44" style="color:#fff">Order Id</th>
													<th width="64" style="color:#fff">Order Amount</th>
													<th width="64" style="color:#fff">Order Summary</th>
													<th width="64" style="color:#fff"></th>
													<th width="50" style="color:#fff"></th>
													<th width="66" style="color:#fff"></th>
												</tr>
											</thead>';
		
		$query = $this->db->query(" select * from currency where currency_id=".$this->session->userdata('currency_id'));
		$currency = $query->row();
		
		foreach($current_orders as $order)
		{

			$query_order=$this->db->query("SELECT company_id, payer_code, payee_code,  order_key, payer_id, payee_id, shipping_method, shipping_firstname, shipping_address_1, total_amount, order_status_id, date_added, date_modified from `order` where order_id=".$order);
			$order_placed=$query_order->result_array();
			$message_body.='<tbody style="color:black;"><tr align="center">';
			//Date added
			$message_body.='<td valign="baseline" cellspacing="0">'.date('F jS Y',strtotime($order_placed[0]['date_added'])).'<br>'. date('g:i:s A',strtotime($order_placed[0]['date_added'])).'</td>';
			//TP order id
			$message_body.='<td style="">'.$order.'</td>';
			// Payment To
			$query_company=$this->db->query("SELECT company_name from `customer_company` where customer_id=".$order_placed[0]['company_id']);
			$company_info=$query_company->result_array();
			$message_body.='<td style="">'.$company_info[0]['company_name'].'</td>';
			//Order Id
			$message_body.='<td style="">'.$order_placed[0]['order_key'].'</td>';
			//Order Amount
			$message_body.='<td>'.$currency->symbol." ".($order_placed[0]['total_amount']*$currency->value).'</td>';
			// Order Summary
			$message_body.='<td><b>Product name</b></td><td><b>Price</b></td><td><b>Status</b></td><td><b>Order keys</b></td></tr>';
			$query_order_product=$this->db->query("SELECT order_id ,product_key , transaction_id , payer_code, payee_code, name, quantity , price , shipping_cost , total , order_product_status_id ,complete_order_time,complete_order_unit from `order_product` where order_id=".$order);
			$order_product=$query_order_product->result_array();
			foreach($order_product as $product)
			{
				
				$message_body.='<tr align="center"><td style="border:none"></td><td style="border:none"><span style="display:none"></span></td><td style="border:none"><span style="display:none"></span></td><td><span style="display:none"></span></td><td style="border:none"><span style="display:none"></span></td>';
				//product name
				$message_body.='<td>'.$product['name'].' </td>';
				//price
				$message_body.='<td>'.$currency->symbol." ".($product['total']*$currency->value).'</td>';
				//status
				$message_body.='<td>Paid</td>';
				//order keys
				$payer_message.=$message_body.'<td>'.$product['payer_code'].'</td></tr>';
				$payee_message.=$message_body.'<td>'.$product['payee_code'].'</td></tr>';
				$message_body='';
				
			}
			$payer_message.='</tbody>';
			$payee_message.='</tbody>';
			$message_body='';
			
			
			
			
			
			$message_footer='</table><table><tr><td style="text-align:center">';
			$message_footer.='Your secret code for Order '.$order_placed[0]['order_key'].' is important and REQUIRED TO CONFIRM DELIVERY OF YOUR PRODUCT TO YOUR CUSTOMER/BUYER ; It should be kept securely to complete your order . Do not share this code for any reason. You can only share your code with your shipper  if you are not shipping by your self ; this is neccessary  to enable your shipper to complete and confirm delivery of the product to the buyer instantly  Any request for it from anyone aprt from your shipper is a scam.';
			$message_footer.='<br />You or your shipper   should only exchange/share your secret code with your buyer on delivery of your item  to confirm delivery and demand  release of payment from your buyer. Please click on complete order on your marketplace or online store to release payments,  once you have delivered  your product; "Please note that a release of your codes signifies your acceptance of the  terms and conditions governing the Trustedpayer service. ';
			$message_footer.='</td></tr>';
			$message_footer.='<tr bgcolor="#4472C4" style="display:block"><td colspan="9"></td></tr>';
			$message_footer.='</table></td></tr></table>';
			
			
			$payee_final_message=$message_header1.$payee_message.$message_footer;
			
			$payee_query=$this->db->query("SELECT email from `customer` where customer_id=".$order_placed[0]['payee_id']);
			$payee_customer=$payee_query->result_array();
			$to=$payee_customer[0]['email'];
			$subject="Order Product Key";
			echo $payee_final_message.'<br><br>';
			$flag=mail($to, $subject, urldecode($payee_final_message), $headers);
			$payee_message='';
		}
		$message_footer='</table><table><tr><td style="text-align:center">';
		$message_footer.='Your secret code for Order '.$order_placed[0]['order_key'].' is important and should be kept securely to complete your order . Do not share this code for any reason. Any request for it from anyone aprt from your seller  is a scam."';
		$message_footer.='<br />You should only exchange/share your secret code with your product supplier/shipper on delivery of your item and on completion of the order to release paymeny to your seller. Please click on complete order to release payments once you are satisfied with your item: "Please note that a release of your codes signifies your acceptance of the goods and/or services provider by the seller". ';
		$message_footer.='</td></tr>';
		$message_footer.='<tr bgcolor="#4472C4" style="display:block"><td colspan="9"></td></tr>';
		$message_footer.='</table></td></tr></table>';
		$payer_final_message=$message_header.$payer_message.$message_footer;
		
		
		$payer_query=$this->db->query("SELECT email from `customer` where customer_id=".$customer_id);
		$payer_customer=$payer_query->result_array();
		$to=$payer_customer[0]['email'];
		$subject="Order Product Key";
		
		
		//echo $payer_final_message;exit;
		$flag=mail($to, $subject, urldecode($payer_final_message), $headers);
		
	}
	public function sendKeyMail($to,$subject,$message)
	{
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'From: Trustedpayer <info@trustedpayer.com>' . "\r\n";
		$flag=mail($to, $subject, urldecode($message), $headers);
	}
	public function sendMail($customer_id,$subject,$message)
	{
		$to_query=$this->db->query("SELECT email from `customer` where customer_id=".$customer_id);
		$to_customer=$to_query->result_array();
		$to=$to_customer[0]['email'];
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'From: Trustedpayer <info@trustedpayer.com>' . "\r\n";
		$flag=mail($to, $subject, urldecode($message), $headers);
		/* sms send */
		if(isset($to_customer[0]['verify']))
		{
			$this->sms->send(urlencode($message),urlencode("+".$to_customer[0]['phonecode'].	$to_customer[0]['customer_phone']));
		}
		/* sms send */
	}
	public function getOrder($payer_id='',$order_id='',$transaction_id='',$payee_id='',$order_product_id='',$filter='')
	{
		$where='';
		if($payer_id!='')
		$where.=" and ordr.payer_id =".$payer_id;
		if($payee_id!='')
		$where.=" and ordr.payee_id =".$payee_id;
		if($order_id!='')
		$where.=" and ordr.order_id =".$order_id;
		if($order_product_id!='')
		$where.=" and op.order_product_id =".$order_product_id;
		
		if($transaction_id!='')
		$where.=" and ordr.transaction_id =".$transaction_id;
		
		if(isset($company_id) && $company_id!='')
		$where.=" and company.company_id =".$company_id;
		
		$groupby= $filter!='' ? 'group by omile.milestone_id ' : '';
	//bug add new query
		$query=$this->db->query("select od.despute_id,payer.first_name as payer_name,payer.email as payer_email,payee.first_name as payee_name,payee.email as payee_email,company.company_website,company.company_name,omile.transaction_id as milestone_transaction_id, omile.payer_code as milestone_payer_code, omile.add_date as milestone_date, omile.description as milestone_description,omile.payee_code as milestone_payee_code,omile.status as milestone_status,omile.milestone_id, amount AS milestone_amount, add_date AS milestone_added, q1.*,os.name as order_status_name from( select ordr.*,op.order_product_id,op.name as product_name,op.order_product_status_id,op.transaction_id as product_transaction_id,op.quantity as product_quantity,op.payee_code as product_payee_code,op.price,op.total as product_amount from `order` ordr, `order_product` op where ordr.order_id=op.order_id ".$where.") as q1 Left join `order_status` os  on q1.order_status_id = os.order_status_id LEFT join `order_milestone` omile ON q1.order_id=omile.order_id LEFT join `customer_company` company on company.customer_id=company_id LEFT JOIN `order_despute`  od on od.order_id=q1.order_id LEFT JOIN `customer` payer ON payer.customer_id=q1.payer_id LEFT JOIN `customer` payee ON payee.customer_id=q1.payee_id ".$groupby." ORDER BY `q1`.`order_id` DESC  ");
		
		
		/* $query=$this->db->query("select od.despute_id,payer.first_name as payer_name,payer.email as payer_email,payee.first_name as payee_name,payee.email as payee_email,company.company_website,company.company_name,omile.transaction_id as milestone_transaction_id, omile.payer_code as milestone_payer_code, omile.description as milestone_description,omile.payee_code as milestone_payee_code,omile.status as milestone_status,omile.milestone_id, amount AS milestone_amount, add_date AS milestone_added, q1.*,os.name as order_status_name from( select ordr.*,op.order_product_id,op.product_key,op.name as product_name,op.quantity as product_quantity,op.transaction_id as product_transaction_id,op.payer_code as product_payer_code,op.payee_code as product_payee_code,op.price,op.total as product_amount,op.order_product_status_id from `order` ordr, `order_product` op where ordr.order_id=op.order_id ".$where.") as q1 Left join `order_status` os  on q1.order_status_id = os.order_status_id LEFT join `order_milestone` omile ON q1.order_id=omile.order_id LEFT JOIN `order_despute`  od on od.order_id=q1.order_id LEFT join `customer_company` company on company.customer_id=company_id LEFT JOIN `customer` payer ON payer.customer_id=q1.payer_id  LEFT JOIN `customer` payee ON payee.customer_id=q1.payee_id  group by q1.order_product_id ORDER BY `q1`.`order_id` DESC"); */
		//$query=$this->db->query("select q1.*,os.name as order_status_name from( select ordr.* from `order` ordr where ".$where.") as q1 Left join `order_status` os  on q1.order_status_id = os.order_status_id ");
		//echo $this->db->last_query();
		return $query->result_array();
	}
	public function expireOrder($order_id)
	{
		$query=$this->db->query("SELECT op.order_id,op.order_product_id,op.complete_order_time,op.complete_order_unit,p.date_added,adddate(p.date_added,INTERVAL op.complete_order_time hour) as expire_time,NOW() as now FROM `order_product` op, `payee` p where op.order_product_id=p.order_product_id and op.order_id=".$order_id);
		
		return $result=$query->result_array();
	}
	public function validateOrderKey($payer_id='',$order_id,$data,$payee_id='')
	{
		$where='';
		if($payer_id!='')
		$where.=" AND payer_id = ".$payer_id;
		if($payee_id!='')
		$where.=" AND payee_id = ".$payee_id;
		$query=$this->db->query("SELECT order_id FROM `order` WHERE order_id = ".$order_id." ".$where." AND payee_code ='".$data['payee_key']."' AND payer_code ='".$data['payer_key']."'");
		
		return $query->result_array();
	}
	public function validateOrderProductKey($payer_id='',$order_product_id,$data,$payee_id='')
	{
		$where='';
		/*if($payer_id!='')
		$where.=" AND payer_id = ".$payer_id;
		if($payee_id!='')
		$where.=" AND payee_id = ".$payee_id;*/
		$query=$this->db->query("SELECT order_product_id FROM `order_product` WHERE order_product_id = ".$order_product_id." ".$where." AND payee_code ='".$data['payee_key']."' AND payer_code ='".$data['payer_key']."'");
		
		return $query->result_array();
	}
	public function validateMilestoneKey($payer_id='',$milestone_id,$data,$payee_id='')
	{
		$where='';
		$query=$this->db->query("SELECT milestone_id FROM `order_milestone` WHERE milestone_id = ".$milestone_id." ".$where." AND payee_code ='".$data['payee_key']."' AND payer_code ='".$data['payer_key']."'");
		
		return $query->result_array();
	}
	public function insertProductOrderKey($payer_id='',$order_id,$order_product_id,$data,$payee_id='')
	{
		if($payer_id!='')
		$this->db->query("INSERT INTO `payer` SET customer_id =".$payer_id.", order_id = ".$order_id.", order_product_id = ".$order_product_id.", own_code = '".$data['payer_key']."', code_recived ='".$data['payee_key']."',date_added = NOW()");
		else
		$this->db->query("INSERT INTO `payee` SET customer_id =".$payee_id.", order_id = ".$order_id.", order_product_id = ".$order_product_id.", own_code = '".$data['payee_key']."', code_recived ='".$data['payer_key']."',date_added = NOW()");
	}
	public function insertOrderKey($payer_id='',$order_id,$milestone_id,$data,$payee_id='')
	{
		if($payer_id!='')
		$this->db->query("INSERT INTO `payer` SET customer_id =".$payer_id.", order_id = ".$order_id.", milestone_id = ".$milestone_id.", own_code = '".$data['payer_key']."', code_recived ='".$data['payee_key']."',date_added = NOW()");
		//bug comment else condition
		//else
		$this->db->query("INSERT INTO `payee` SET customer_id =".$payee_id.", order_id = ".$order_id.", milestone_id = ".$milestone_id.", own_code = '".$data['payee_key']."', code_recived ='".$data['payer_key']."',date_added = NOW()");
	}
	
	public function getPendingAmount($payee_id)
	{
		$query=$this->db->query("select sum(q1.total_amount) as pnamount from( select ordr.* from `order` ordr where ordr.payee_id =".$payee_id." and ordr.order_status_id = 1) as q1 Left join `order_status` os  on q1.order_status_id = os.order_status_id ");
		return $query->result_array();
	}
	public function getAddress($address_id)
	{
		
	}
	public function getCustomerByKey($key)
	{
		$query=$this->db->query("SELECT company.company_website,company.company_name,cust.customer_id,first_name,last_name,photo,email from `customer` cust  LEFT join `customer_company` company on company.customer_id=cust.customer_id  where customer_unique_id = '".$key."'");
		
		return $query->result_array();
	}
	public function release_product_payment($customer_id,$order_product_id,$milestone_id='')
	{
		$query=$this->db->query("SELECT op.total as total_amount,payee_id from `order` ordr,`order_product` op where op.order_id= op.order_id and op.order_product_id =".$order_product_id);
		$order=$query->result_array();
		
			$this->db->query("UPDATE  `customer_account_balance` SET total_balance = ( total_balance - ".$order[0]['total_amount']."), balance_in_process = ( balance_in_process + ".$order[0]['total_amount'].") where customer_id = ".$customer_id);
			$this->db->query("UPDATE `customer_account_balance`  SET  total_balance = ( total_balance + ".$order[0]['total_amount'].") where customer_id = ".$order[0]['payee_id']);
			$this->db->query("INSERT INTO `customer_transaction`  SET customer_id = ".$order[0]['payee_id'].", amount = ".$order[0]['total_amount'].", description ='Order Amount Received', date_added = NOW()");
			$transaction_id=$this->db->insert_id();
			$this->db->query("UPDATE `order_product` SET order_product_status_id =6 where order_product_id = ".$order_product_id);
			
			return $transaction_id;
		
	}
	public function release_payment($customer_id,$order_id,$milestone_id='')
	{
		$query=$this->db->query("SELECT total_amount,payee_id,is_milestone from `order` where order_id =".$order_id);
		$order=$query->result_array();
		$valid=1;
		if($order[0]['is_milestone'])
		{
			$query=$this->db->query("SELECT IFNULL(sum(amount),0) as total_amount from `order_milestone` where status=2 and order_id =".$order_id);
			$milestone=$query->row();
			if($milestone_id==''){
			if($order[0]['total_amount']>$milestone->total_amount)
			{
				$valid=0;
			}
			}
			else{
				$query=$this->db->query("SELECT amount  from `order_milestone` where milestone_id =".$milestone_id);
				$milestone=$query->row();
				$order[0]['total_amount']=$milestone->amount;
			}
		}
		if($valid)
		{
			$this->db->query("UPDATE  `customer_account_balance` SET total_balance = ( total_balance - ".$order[0]['total_amount']."), balance_in_process = ( balance_in_process + ".$order[0]['total_amount'].") where customer_id = ".$customer_id);
			$this->db->query("UPDATE `customer_account_balance`  SET  total_balance = ( total_balance + ".$order[0]['total_amount'].") where customer_id = ".$order[0]['payee_id']);
			$this->db->query("INSERT INTO `customer_transaction`  SET customer_id = ".$order[0]['payee_id'].", amount = ".$order[0]['total_amount'].", description ='Order Amount Recived', date_added = NOW()");
			$transaction_id=$this->db->insert_id();
			if($milestone_id=='')
			$this->db->query("UPDATE `order` SET order_status_id =6 where order_id = ".$order_id);
			else
			$this->db->query("UPDATE `order_milestone` SET status =2 where milestone_id = ".$milestone_id);
			return $transaction_id;
		}
		else
		{
			echo "Something goes wrong!<br>Mismatch total amount(".$order[0]['total_amount'].") and milestone amount(".$milestone->total_amount."). Redirect from <a href=".$_SERVER['HTTP_REFERER'].">Here</a>";
			die();
		}
	}
	public function getTransactionOrder($txn)
	{
		$query=$this->db->query("select tbl1.*,op.order_product_id,op.name as product_name,quantity as product_quantity from (SELECT ordr.*,os.name order_status_value FROM `customer_transaction` ct, `order` ordr, `order_status` os where ordr.transaction_id = ct.transaction_id and os.order_status_id=ordr.order_status_id and ct.transaction_id = ".$txn.")as tbl1 LEFT JOIN `order_product` op on tbl1.order_id = op.order_id");
		
		return $query->result_array();
	}
	public function getTransactionOrderProduct($txn)
	{
		//bug added new milestone desput
		$query=$this->db->query("SELECT ordr.*,os.name order_status_value,op.order_product_id,op.product_key,op.transaction_id as product_transaction_id,op.name as product_name,quantity as product_quantity,op.order_product_status_id,op.total as product_total FROM `customer_transaction` ct, `order` ordr, `order_status` os,`order_product` op where op.transaction_id = ct.transaction_id and os.order_status_id=op.order_product_status_id and ordr.order_id = op.order_id and op.transaction_id =  ".$txn);
		$product = $query->result_array();
		if(!$product){		
			$query=$this->db->query("SELECT ordr.*,os.name order_status_value,op.order_product_id,op.product_key,op.transaction_id as product_transaction_id,op.name as product_name,quantity as product_quantity,op.order_product_status_id,op.total as product_total,om.* FROM `customer_transaction` ct, `order` ordr, `order_status` os,`order_product` op , order_milestone om where om.transaction_id = ct.transaction_id and os.order_status_id=op.order_product_status_id and ordr.order_id = op.order_id and ordr.order_id = om.order_id and om.transaction_id =".$txn);
			$product = $query->result_array();
		}
		return $product;
	}
	
	public function getTransactionMilestone($txn)
	{		
		$query=$this->db->query("select ordr.*,trns.*,om.payee_code as m_payee_key,om.payer_code as m_payer_key,om.milestone_id,om.amount as milestone_amount,om.description as milestone_description,om.milestone_key,status as milestone_status from `order` ordr,`customer_transaction` trns,order_milestone om where trns.transaction_id=om.transaction_id and ordr.order_id = om.order_id and trns.transaction_id =".$txn);
		
		return $query->result_array();
	}
	public function getMilestone($order_id='',$milestone_id='')
	{
		$where='';
		if($order_id!='')
		$where .="om.order_id =".$order_id;
		if($milestone_id!='')
		$where .="om.milestone_id =".$milestone_id;
		$query=$this->db->query("SELECT * from `order_milestone` om left join `order` ordr on ordr.order_id = om.order_id where ".$where);
		return $query->result_array();
	}
	public function insertMilestone($customer_id,$amount,$order_id,$transaction_id='',$description='',$milestone_key='')
	{
		
		if($customer_id!='')
		{
			$this->db->query("INSERT INTO `customer_transaction`  SET customer_id = ".$customer_id.", amount = -".$amount.", description ='milestone created', date_added = NOW()");
			$transaction_id=$this->db->insert_id();
			$this->db->query("UPDATE `customer_account_balance` SET balance_in_process =balance_in_process - ".$amount.", date_modified = NOW() where customer_id = ".$customer_id);
		}
		
		$payer_code=random_string('alpha', 5);
		$payee_code=random_string('alpha', 5);
		
		$pay_customer = $this->db->query("select * from `order` where order_id=".$order_id)->row();
		
		$merchant=$this->db->query("select * from customer where customer_id=".$pay_customer->payee_id)->row();
				
		$this->db->query("INSERT INTO `order_milestone` SET order_id = ".$order_id.", amount = ".$amount.",description = '".$description."',milestone_key = '".$milestone_key."', add_date = NOW(),transaction_id=".$transaction_id.", status=1, payer_code ='".$payer_code."', payee_code = '".$payee_code."' ,tp_plan='".$merchant->merchant."',tp_amount='".(($amount*$merchant->merchant)/100)."'");
		
		
		
		$message='Your TP Milestone transaction secure code is: '.$payer_code;				
		$this->sendMail($pay_customer->payer_id,'TP Transaction secure code',$message);
		$message='Your TP Milestone transaction secure code is: '.$payee_code;		
		//payee_id		not show;		
		$this->sendMail($pay_customer->payee_id,'TP Transaction secure code',$message);
		
		return $transaction_id;
	}
	public function completeOrder($order_id)
	{
		$this->db->query("UPDATE `order` SET order_status_id =6 where order_id = ".$order_id);
	}
	public function completeMilestoneOrder($milestone_id)
	{
		$query=$this->db->query("SELECT pyr.confirm_id as payer_confirm_id,pye.confirm_id as payee_confirm_id FROM `payer` pyr,`payee` pye where pyr.milestone_id=".$milestone_id." and pye.milestone_id=".$milestone_id);
		$result=$query->result_array();
		if(isset($result[0]))
		$this->db->query("UPDATE `order_milestone` SET status =6 where milestone_id = ".$milestone_id);
		else
		$this->db->query("UPDATE `order_milestone` SET status =5 where milestone_id = ".$milestone_id);
	}
	public function completeProductOrder($order_product_id)
	{
		//$query=$this->db->query("SELECT pyr.confirm_id as payer_confirm_id,pye.confirm_id as payee_confirm_id FROM `payer` pyr,`payee` pye where pyr.order_product_id=".$order_product_id." and pye.order_product_id=".$order_product_id);
		$query1=$this->db->query("SELECT pyr.confirm_id as payer_confirm_id FROM `payer` pyr where pyr.order_product_id=".$order_product_id);
		$result1=$query1->result_array();
		$query2=$this->db->query("SELECT pye.confirm_id as payee_confirm_id FROM `payee` pye where pye.order_product_id=".$order_product_id);
		$result2=$query2->result_array();
		if(isset($result1[0]) && isset($result2[0]))
		$this->db->query("UPDATE `order_product` SET order_product_status_id =6 where order_product_id = ".$order_product_id);
		else
		$this->db->query("UPDATE `order_product` SET order_product_status_id =5 where order_product_id = ".$order_product_id);
		$this->sendcompleteProductOrderMail($order_product_id);
		
	}
	public function sendcompleteProductOrderMail($order_product_id)
	{
		if($this->session->userdata('currency_id'))
			$currency_id1 =   $this->session->userdata('currency_id');
		else
			$currency_id1 =  "4";
		
		$query = $this->db->query(" select * from currency where currency_id=".$currency_id1);
		$currency = $query->row();
		$payer_message=$payee_message=$message_body='';
		$message_header='<table bgcolor="#f6f6f6" style=" font-family:Arial, Helvetica, sans-serif; font-size:13px;"><tbody><tr><td><table><tr><td>Your recently purchased order  from Yehki.com  has been  delivered with the transaction details:with the transaction details  below :</td></tr></table><table cellpadding="5" cellspacing="0" width="100%" border="0" bordercolor="#1996E6" style="border-collapse:collapse; border:1px solid #1996E6; font-family:Arial, Helvetica, sans-serif; font-size:13px;"><thead bgcolor="#1996E6"><tr><th width="">Date</th><th width="">TP order Id</th><th width="">Payment To</th><th width="">Order Id</th> <th width="">Order Amount</th><th width="">Order Summary</th><th width=""></th><th width=""></th><th width=""></th><th width=""></th></tr></thead>';
		$message_header1='<table bgcolor="#f6f6f6" style=" font-family:Arial, Helvetica, sans-serif; font-size:13px;"><tbody><tr><td><table><tr><td>	Your  purchase order  from  @Yehki.com  has been  delivered with the transaction details:</td></tr></table><table cellpadding="5" cellspacing="0" width="100%" border="0" bordercolor="#1996E6" style="border-collapse:collapse; border:1px solid #1996E6; font-family:Arial, Helvetica, sans-serif; font-size:13px;"><thead bgcolor="#1996E6"><tr><th width="">Date</th><th width="">TP order Id</th><th width="">Payment To</th><th width="">Order Id</th> <th width="">Order Amount</th><th width="">Order Summary</th><th width=""></th><th width=""></th><th width=""></th><th width=""></th></tr></thead>';
						//foreach($current_orders as $order)
		{
			$query_order_product=$this->db->query("SELECT  NOW() as now,order_id ,product_key , transaction_id , payer_code, payee_code, name, quantity , price , shipping_cost , total , order_product_status_id ,complete_order_time,complete_order_unit from `order_product` where order_product_id=".$order_product_id);
			$order_product=$query_order_product->result_array();
			
			$query_order=$this->db->query("SELECT company_id, payer_code, payee_code,  order_key, payer_id, payee_id, shipping_method, shipping_firstname, shipping_address_1, total_amount, order_status_id, date_added, date_modified from `order` where order_id=".$order_product[0]['order_id']);
			$order_placed=$query_order->result_array();
			$message_body.='<tbody style="color:black;"><tr align="center"><td valign="baseline" cellspacing="0"></td><td style=""></td><td style=""></td><td style=""></td><td></td><td><b></b></td><td><b></b></td><td><b></b></td><td><b></b></td><td><b>Action Required</b></td></tr><tr align="center">';
			//Date added
			$message_body.='<td valign="baseline" cellspacing="0">'.date('F jS Y',strtotime($order_placed[0]['date_added'])).'<br>'. date('g:i:s A',strtotime($order_placed[0]['date_added'])).'</td>';
			//TP order id
			$message_body.='<td style="">'.$order_product[0]['order_id'].'</td>';
			// Payment To
			$query_company=$this->db->query("SELECT company_name from `customer_company` where customer_id=".$order_placed[0]['company_id']);
			$company_info=$query_company->result_array();
			$message_body.='<td style="">'.$company_info[0]['company_name'].'</td>';
			//Order Id
			$message_body.='<td style="">'.$order_placed[0]['order_key'].'</td>';
			//Order Amount
			$message_body.='<td>'.$currency->symbol." ".($order_placed[0]['total_amount']*$currency->value).'</td>';
			// Order Summary
			$message_body.='<td><b>Product name</b></td><td><b>Price</b></td><td><b>Status</b></td><td><b>Order keys</b></td><td><b>Release payment within</b></td></tr>';
			
			foreach($order_product as $product)
			{
				
				$future_datetime =date('Y-m-d H:i:s', strtotime('+1 day', strtotime($product['complete_order_time'])));
				//$future_datetime=$despute[0]['despute_date_added'];
				$future = strtotime($future_datetime); //future datetime in seconds
				$now_datetime = $product['now'];
				$now = strtotime($now_datetime); //now datetime in seconds
				
				//The math for calculating the difference in hours, minutes and seconds
				$difference = $future - $now;
				$second = 1;
				$minute = 60 * $second;
				$hour = 60 * $minute;
				$difference_hours = floor($difference/$hour);
				$remainder = $difference - ($difference_hours * $hour);
				$difference_minutes = floor($remainder/$minute);
				$remainder = $remainder - ($difference_minutes * $minute);
				$difference_seconds = $remainder;
				
				$message_body.='<tr align="center"><td></td><td><span style="display:none"></span></td><td><span style="display:none"></span></td><td><span style="display:none"></span></td><td><span style="display:none"></span></td>';
				//product name
				$message_body.='<td>'.$product['name'].' </td>';
				//price
				$message_body.='<td>'.$currency->symbol." ".($product['total']*$currency->value).'</td>';
				//status
				$message_body.='<td>Paid</td>';
				//complete time
				if($difference_hours>0)
				$complete_time=$difference_hours.' Hours';
				else
				$complete_time=$difference_minutes.' Minutes';
				//order keys
				$payer_message.=$message_body.'<td>'.$product['payer_code'].'</td><td>'.$complete_time.'</td></tr>';
				$payee_message.=$message_body.'<td>'.$product['payee_code'].'</td></tr>';
				
			}
			$payer_message.='</tbody>';
			$payee_message.='</tbody>';
			$message_body='';
			
			$message_footer='</table><table><tr><td>';
			$message_footer.='Your secret code for Order '.$order_product[0]['order_id'].' is important and REQUIRED TO CONFIRM DELIVERY OF YOUR PRODUCT TO YOUR CUSTOMER/BUYER ; It should be kept securely to complete your order . Do not share this code for any reason. You can only share your code with your shipper  if you are not shipping by your self ; this is neccessary  to enable your shipper to complete and confirm delivery of the product to the buyer instantly  Any request for it from anyone aprt from your shipper is a scam.';
			$message_footer.='<br />You or your shipper   should only exchange/share your secret code with your buyer on delivery of your item  to confirm delivery and demand  release of payment from your buyer. Please click on complete order on your marketplace or online store to release payments,  once you have delivered  your product; "Please note that a release of your codes signifies your acceptance of the  terms and conditions governing the Trustedpayer service.';
			$message_footer.='</td></tr></table></td></tr></table>';
			
			$payee_final_message=$message_header1.$payee_message.$message_footer;
			$payee_query=$this->db->query("SELECT email from `customer` where customer_id=".$order_placed[0]['payee_id']);
			$payee_customer=$payee_query->result_array();
			$to=$payee_customer[0]['email'];
			$subject="Order Product Key";
			$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'From: Trustedpayer <info@trustedpayer.com>' . "\r\n";
			$flag=mail($to, $subject, ($payee_final_message), $headers);
		}
		$message_footer='</tbody></table><table><tr><td>';
		$message_footer.='Your secret code for Order '.$order_product[0]['order_id'].' is important and should be kept securely to complete your order . Do not share this code for any reason. Any request for it from anyone aprt from your seller  is a scam."<br />';
		$message_footer.='You should only exchange/share your secret code with your product supplier/shipper on delivery of your item and on completion of the order to release paymeny to your seller. Please click on Release Payment to release payments once you are satisfied with your item: "Please note that a release of your codes signifies your acceptance of the goods and/or services provider by the seller". You have '.$complete_time.' to complete your order ; if payment is not released by the deadline you will be deemed by trustedpayer.com to have agreed to the release if the payment in full to the supplier.';
		$message_footer.='<br /><b>	*Forgot your code ? Text \'order number, transaction id" to 38842 to generate new codes or log on to tp and click generate on your particular order</b></tr></table></td></td></tr></table>';
		
		$payer_final_message=$message_header.$payer_message.$message_footer;
		
		
		$payer_query=$this->db->query("SELECT email from `customer` where customer_id=".$order_placed[0]['payer_id']);
		$payer_customer=$payer_query->result_array();
		$to=$payer_customer[0]['email'];
		$subject="Order Product Key";
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'From: Trustedpayer <info@trustedpayer.com>' . "\r\n";
		$flag=mail($to, $subject, ($payer_final_message), $headers);
	}
	public function getReciveOrder($payee_id,$payer_id='',$company='',$order_id='',$milestone='',$product_name='',$text='',$limit=20,$count=false)
	{
		
		if($count==true && $milestone!=1)
		{
			$count='(select count(*) from order_product where order_product.order_id=ordr.order_id)as counter,';
			$count.='(select count(*) from order_product where order_product.order_id=ordr.order_id and order_product.dispatcher_status=0)as dispatch_counter,';
			$sort=" group ";
			$mile_count='';
		}else if($count==true && $milestone==1){
			$mile_count='(select count(*) from order_milestone where order_milestone.order_id=q1.order_id)as counter,';
			$mile_count.='(select count(*) from order_milestone where order_milestone.order_id=q1.order_id and order_milestone.dispatcher_status=0)as dispatch_counter,';
			$sort=" group ";
			$count='';
		}else{
			$count='';
			$sort=" order ";
			$mile_count='';
		}
		
		$limit= " Limit ".$limit.",20";
		$where='';
		 if(isset($payer_id) && $payer_id!=''){			
				$where.=" and ordr.payer_id ='".$payer_id."' ";
		 }
		if(isset($company) && $company!=''){			
				$where.=" and ordr.company_id ='".$company."' ";
			
		} 
		if($order_id!='')
		$where.=" and ordr.order_id < ".$order_id;
	
		if($milestone!='')
		$where.=" and ordr.is_milestone =".$milestone;
		if($product_name!='')
		$where.=" and op.name like '".$product_name."%' ";
		$where1="";
		
		if($text!='')
		{
			$where.=" and op.name like '%".$text."%' ";
			//$where1.=" where company.company_name like '%".$text."%' or concat(payee.first_name,'',payee.last_name) like '%".$text."%'";
		}
		
	
		$query=$this->db->query("select despute_id,company.company_name,".$mile_count."company.company_website,payer.first_name as payer_name,payer.email as payer_email,payee.first_name as payee_name,payee.email as payee_email,omile.transaction_id as milestone_transaction_id ,omile.payer_code as milestone_payer_code, omile.description as milestone_description,omile.payee_code as milestone_payee_code,omile.status as milestone_status,omile.milestone_id, amount AS milestone_amount, add_date AS milestone_added,q1.*,os.name as order_status_name from( select ordr.*,op.order_product_id,".$count."op.name as product_name,op.order_product_status_id,op.transaction_id as product_transaction_id,op.quantity as product_quantity,op.payee_code as product_payee_code,op.price,op.total as product_amount from `order` ordr, `order_product` op where ordr.order_id=op.order_id and ordr.payee_id =".$payee_id.$where." ORDER BY `ordr`.`order_id` DESC) as q1 Left join `order_status` os  on q1.order_status_id = os.order_status_id LEFT join `order_milestone` omile ON q1.order_id=omile.order_id LEFT join `customer_company` company on company.customer_id=company_id LEFT JOIN `order_despute`  od on od.order_id=q1.order_id LEFT JOIN `customer` payer ON payer.customer_id=q1.payer_id LEFT JOIN `customer` payee ON payee.customer_id=q1.payee_id $sort BY `q1`.`order_id` DESC ".$limit);
		//echo $this->db->last_query();
		return $query->result_array();
	}
	
	public function getOrderFilter($payer_id='',$company_id='',$payee_id='',$order_id='',$milestone='',$product_name='',$text='',$limit=20,$count=false)
	{		
		if($count==true && $milestone!=1)
		{
			$count='(select count(*) from order_product where order_product.order_id=ordr.order_id)as counter,';
			$count.='(select count(*) from order_product where order_product.order_id=ordr.order_id and order_product.dispatcher_status=0)as dispatch_counter,';
			$sort=" group ";
			$mile_count='';
		}else if($count==true && $milestone==1){
			$mile_count='(select count(*) from order_milestone where order_milestone.order_id=q1.order_id)as counter,';
			$mile_count.='(select count(*) from order_milestone where order_milestone.order_id=q1.order_id and order_milestone.dispatcher_status=0)as dispatch_counter,';
			$sort=" group ";
			$count='';
		}else{
			$count='';
			$sort=" order ";
			$mile_count='';
		}
		
		$limit= $limit.",20";
		$where='';
		if($payer_id!='')
		$where.=" and ordr.payer_id =".$payer_id;
		if($company_id!='')
		$where.=" and ordr.company_id =".$company_id;
		if($payee_id!='')
		$where.=" and ordr.payee_id =".$payee_id;
		if($order_id!='')
		$where.=" and ordr.order_id < ".$order_id;
		if($milestone!='')
		$where.=" and ordr.is_milestone =".$milestone;
		if($product_name!='')
		$where.=" and op.name like '".$product_name."%' ";
		$where1="";
		
		if($text!='')
		{
			$where.=" and op.name like '%".$text."%' ";
			//$where1.=" where company.company_name like '%".$text."%' or concat(payee.first_name,'',payee.last_name) like '%".$text."%'";
		}	
		
		
		
	//bug add new query
		$query=$this->db->query("select od.despute_id,payer.first_name as payer_name,".$mile_count." payer.email as payer_email,payee.first_name as payee_name,payee.email as payee_email,company.company_website,company.company_name,omile.transaction_id as milestone_transaction_id, omile.payer_code as milestone_payer_code, omile.description as milestone_description,omile.payee_code as milestone_payee_code,omile.status as milestone_status,omile.milestone_id, amount AS milestone_amount, add_date AS milestone_added, q1.*,os.name as order_status_name from( select ordr.*,op.order_product_id,".$count."op.name as product_name,op.order_product_status_id,op.transaction_id as product_transaction_id,op.quantity as product_quantity,op.payee_code as product_payee_code,op.price,op.total as product_amount from `order` ordr, `order_product` op where ordr.order_id=op.order_id ".$where." ) as q1 Left join `order_status` os  on q1.order_status_id = os.order_status_id LEFT join `order_milestone` omile ON q1.order_id=omile.order_id LEFT join `customer_company` company on company.customer_id=company_id LEFT JOIN `order_despute`  od on od.order_id=q1.order_id LEFT JOIN `customer` payer ON payer.customer_id=q1.payer_id LEFT JOIN `customer` payee ON payee.customer_id=q1.payee_id ".$where1." $sort BY `q1`.`order_id` DESC  LIMIT ".$limit);
		//echo $this->db->last_query();
		return $query->result_array();
	}
	public function getMilestoneDetail($order_id='',$milestone_id='')
	{
		$where='';
		if($order_id!='')
		$where .="om.order_id =".$order_id;
		if($milestone_id!='')
		$where .=" om.milestone_id =".$milestone_id;
		
		$dispatch_from= "(select d.dispatch_to from dispatch d where d.dispatch_status=0 and om.milestone_id=d.milestone_id order by d.dispatch_id desc limit 0,1) as dispatch_from," ;
		
		$query=$this->db->query("SELECT distinct (om.milestone_id) as id,od.despute_id as d_id,".$dispatch_from." (select amount from order_despute_tmp where od.despute_id=order_despute_tmp.despute_id order by tmp_id asc limit 0,1) as product_main_amount,(select payer_amount from order_despute_tmp where od.despute_id=order_despute_tmp.despute_id order by tmp_id desc limit 0,1) as paid_amount, om.*,od.*,ordr.commission as cmp_commission,ordr.order_key,ordr.total_amount,om.amount as milestone_amount,om.description as milestone_description,om.transaction_id as milestone_transaction_id,om.dispatcher_status,om.dispatcher_id, cm.company_website as company_url,op.order_id,cm.company_name,c_pr.first_name as payer_name,c_pr.email as payer_email,c_p.first_name as payee_name,c_p.email as payee_email,om.status as milestone_status,op.order_product_id,op.quantity as quantity,op.name as product_name from order_milestone om left join `order` ordr on om.order_id=ordr.order_id  left join order_despute od on od.milestone_id = om.milestone_id  left join customer c_p on ordr.payee_id=c_p.customer_id  left join customer_company cm on ordr.company_id=cm.customer_id left join customer c_pr on ordr.payer_id=c_pr.customer_id left join order_product op on om.order_id=op.order_id  where ".$where." group by om.milestone_id");
		//ECHO $this->db->last_query();
		return $query->result_array();
		
	}
	public function getproductDetail($order_id='',$product_id='')
	{
		$where='';
		if($order_id!='')
		$where .="op.order_id =".$order_id;
		if($product_id!='')
		$where .=" op.order_product_id =".$product_id; 
		
		$dispatch_from= "(select d.dispatch_to from dispatch d where d.dispatch_status=0 and op.order_product_id=d.order_product_id order by d.dispatch_id desc limit 0,1) as dispatch_from," ;
		$query=$this->db->query("SELECT ordr.commission, od.remedy, op.tp_plan,op.tp_amount,op.order_product_id as id,".$dispatch_from." (select amount from order_despute_tmp where order_despute_tmp.despute_id=(select xdd.despute_id from order_despute xdd where xdd.order_product_id=op.order_product_id order by xdd.despute_id asc limit 0,1) order by order_despute_tmp.tmp_id asc limit 0,1) as product_main_amount,(select payer_amount from order_despute_tmp where order_despute_tmp.despute_id=od.despute_id order by tmp_id desc limit 0,1) as paid_amount,  op.*,ordr.order_key,ordr.date_added,op.transaction_id as product_transaction_id,c_pr.first_name as payer_name,cm.company_name,c_pr.email as payer_email,cm.company_website as company_url,c_p.first_name as payee_name,c_p.email as payee_email,op.order_product_status_id as product_status,op.order_product_id,op.name as product_name,od.despute_id,od.status,od.payer_amount,od.payee_amount,od.final_amount,od.description as od_desc from order_product op left join `order` ordr on op.order_id=ordr.order_id left join customer_company cm on ordr.company_id=cm.customer_id left join customer c_p on ordr.payee_id=c_p.customer_id  left join customer c_pr on ordr.payer_id=c_pr.customer_id left join order_despute od on od.order_product_id=op.order_product_id and od.despute_id=(select xd.despute_id from order_despute xd where xd.order_product_id=op.order_product_id order by xd.despute_id desc limit 0,1) where ".$where." group by op.order_product_id");
		//echo $this->db->last_query();
		
		return $query->result_array();
		
	}
	public function getinvoiceDetail($order_id='',$product_id='')
	{
		$where='';
		if($order_id!='')
		$where .="op.order_id =".$order_id;
		if($product_id!='')
		$where .=" op.order_product_id =".$product_id; 
		
		$dispatch_from= "(select d.dispatch_to from dispatch d where d.dispatch_status=0 and op.order_product_id=d.order_product_id order by d.dispatch_id desc limit 0,1) as dispatch_from," ;
		$query=$this->db->query("SELECT ordr.commission, od.remedy, op.tp_plan,op.tp_amount,op.order_product_id as id,".$dispatch_from." (select amount from order_despute_tmp where order_despute_tmp.despute_id=(select xdd.despute_id from order_despute xdd where xdd.order_product_id=op.order_product_id order by xdd.despute_id asc limit 0,1) order by order_despute_tmp.tmp_id asc limit 0,1) as product_main_amount,(select payer_amount from order_despute_tmp where order_despute_tmp.despute_id=od.despute_id order by tmp_id desc limit 0,1) as paid_amount,  op.*,ordr.order_key,ordr.date_added,op.transaction_id as product_transaction_id,c_pr.first_name as payer_name,cm.company_name,c_pr.email as payer_email,cm.company_website as company_url,c_p.first_name as payee_name,c_p.email as payee_email,op.order_product_status_id as product_status,op.order_product_id,op.name as product_name,od.despute_id,od.status,od.payer_amount,od.payee_amount,od.final_amount,od.description as od_desc from order_product op left join `order` ordr on op.order_id=ordr.order_id left join customer_company cm on ordr.company_id=cm.customer_id left join customer c_p on ordr.payee_id=c_p.customer_id  left join customer c_pr on ordr.payer_id=c_pr.customer_id left join order_despute od on od.order_product_id=op.order_product_id and od.despute_id=(select xd.despute_id from order_despute xd where xd.order_product_id=op.order_product_id order by xd.despute_id desc limit 0,1) where ".$where." group by op.order_product_id");
		//echo $this->db->last_query();
		
		return $query->result_array();
		
	}
	public function getDspatchMilestone($limit=20,$payee_id='',$req_user='')
	{
		$where='';
		if($payee_id!='')
		$where.=" dp.dispatch_to!=0 and (dp.dispatch_from =".$payee_id." or ordr.payee_id =".$payee_id.")";
		$trf="";
		if($req_user!='')
		{
			$where.=" dp.dispatch_to =".$req_user." ";
			$trf=" (select trf.dispatcher_id from customer trf left join dispatch dtp on trf.customer_id=dtp.dispatch_from where (dtp.dispatch_status=1 or dtp.dispatch_status=5 )and om.milestone_id=dtp.milestone_id and dtp.dispatch_to=".$req_user." order by dtp.dispatch_id desc limit 0,1)as transferrer_code, ";
		}
		
		$limit= " Limit ".$limit.",20";
		$query=$this->db->query("SELECT distinct (om.milestone_id) as id,(dsp.dispatcher_id)as dispatcher_code,".$trf." om.*, om.tp_plan,om.tp_amount,,od.*,ordr.order_key,ordr.total_amount,om.description as milestone_description,om.transaction_id as milestone_transaction_id,(select dp1.dispatch_status from dispatch dp1 where dp1.milestone_id=om.milestone_id order by dp1.dispatch_id desc limit 0,1 ) as dispatcher_status,(select dp1.dispatch_from from dispatch dp1 where dp1.milestone_id=om.milestone_id order by dp1.dispatch_id desc limit 0,1 ) as dispatch_from, (select dp1.dispatch_to from dispatch dp1 where dp1.milestone_id=om.milestone_id order by dp1.dispatch_id desc limit 0,1 ) as dispatch_to,om.dispatcher_date,om.dispatcher_id, cm.company_website as company_url,op.order_id,cm.company_name,c_pr.first_name as payer_name,c_pr.email as payer_email,c_p.first_name as payee_name,c_p.email as payee_email,om.status as milestone_status,op.order_product_id,op.quantity as quantity,op.name as product_name from order_milestone om left join `order` ordr on om.order_id=ordr.order_id  left join order_despute od on om.order_id = od.order_id  left join customer c_p on ordr.payee_id=c_p.customer_id  left join customer_company cm on ordr.company_id=cm.customer_id left join customer c_pr on ordr.payer_id=c_pr.customer_id left join order_product op on om.order_id=op.order_id left join customer dsp on dsp.customer_id=om.dispatcher_id left join dispatch dp on dp.milestone_id=om.milestone_id where ".$where." group by dp.milestone_id desc order by dp.date_time desc".$limit);
		return $query->result_array();
	}
	public function getDspatchProduct($limit=20,$payee_id='',$req_user='',$inv=0)
	{
		$where='ordr.is_milestone='.$inv.' and ';
		
		$limit= " Limit ".$limit.",20";		
		if($payee_id!='')
		$where.=" dp.dispatch_to!=0 and (dp.dispatch_from =".$payee_id." or ordr.payee_id =".$payee_id.")";
		$trf='';
		if($req_user!='')
		{
			$where.=" dp.dispatch_to =".$req_user." ";
			$trf=" (select trf.dispatcher_id from customer trf left join dispatch dtp on trf.customer_id=dtp.dispatch_from where (dtp.dispatch_status=1 or dtp.dispatch_status=5 ) and op.order_product_id=dtp.order_product_id and dtp.dispatch_to=".$req_user." order by dtp.dispatch_id desc limit 0,1)as transferrer_code, ";
		}
		
		/* if($product_id!='')
		$where .=" and op.order_product_id =".$product_id; */
		$query=$this->db->query("SELECT (dsp.dispatcher_id)as dispatcher_code,".$trf." op.order_product_id as id, op.*,(select dp1.dispatch_status from dispatch dp1 where dp1.order_product_id=op.order_product_id order by dp1.dispatch_id desc limit 0,1 ) as dispatcher_status,(select dp1.dispatch_from from dispatch dp1 where dp1.order_product_id=op.order_product_id order by dp1.dispatch_id desc limit 0,1 ) as dispatch_from, (select dp1.dispatch_to from dispatch dp1 where dp1.order_product_id=op.order_product_id order by dp1.dispatch_id desc limit 0,1 ) as dispatch_to, ordr.order_key,ordr.date_added,op.transaction_id as product_transaction_id,c_pr.first_name as payer_name,cm.company_name,c_pr.email as payer_email,cm.company_website as company_url,c_p.first_name as payee_name,c_p.email as payee_email,op.order_product_status_id as product_status,op.order_product_id,op.name as product_name from order_product op left join `order` ordr on op.order_id=ordr.order_id left join customer_company cm on ordr.company_id=cm.customer_id left join customer c_p on ordr.payee_id=c_p.customer_id  left join customer c_pr on ordr.payer_id=c_pr.customer_id  left join customer dsp on dsp.customer_id=op.dispatcher_id left join dispatch dp on dp.order_product_id=op.order_product_id where ".$where." group by dp.order_product_id desc order by op.dispatcher_date desc".$limit);
		//echo $this->db->last_query();
		
		return $query->result_array();
	}
}?>
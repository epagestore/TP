<?php
class Despute_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}
	public function insertDespute($pre_delivery,$data,$attachment,$payer_id,$payee_id,$generate_by,$product_total='',$milestone_id='')
	{
		if($payee_id==$generate_by)
		$amount=",payee_amount =".$data['claim_amount'];
		if($payer_id==$generate_by)
		$amount=",payee_amount =".$product_total.",payer_amount =".$data['claim_amount'];
		
		if($milestone_id!='')
		$amount.=",milestone_id =".$milestone_id;
	
		$remedy_id="";
		$remedy="";
		if($payer_id==$generate_by && $pre_delivery==0){
			if($data['remedy']=='Discount')
			{
				$remedy_id=", remedy_discount =".$data['remedyDiscount'];
			}
			else if($data['remedy']=='Replacemnt')
			{
				$remedy_id=", remedy_replacement =".$data['remedyReplacement'];
			}
			else 
			{
				$remedy_id=", remedy_cancelation =".$data['remedyCancelation'];
			}
			$remedy=", remedy ='".$data['remedy']."'";
		}
		$generate_for=(($payee_id+$payer_id)-$generate_by);
		$generate_by1=($generate_by);
		if($payee_id!='')
		$payee_id=", payee_id =".$payee_id;
		if($payer_id!='')
		$payer_id=", payer_id =".$payer_id;
		if($generate_by!='')
		$generate_by =", generate_by =".$generate_by;
		
		
		$this->db->query("INSERT INTO `order_despute` SET pre_delivery=".$pre_delivery.",order_id =".$data['order_id'].$remedy.$remedy_id.", order_product_id = ".$data['order_product_id'].$amount.",reason='".$data['despute_reason']."',description = '".stripslashes($data['despute_desc'])."',attachment='".$attachment."',date_added=NOW(),status=1 ".$payer_id.$payee_id.$generate_by);
		
		$despute_id=$this->db->insert_id();
		
		$query=$this->db->query("UPDATE `order_product` SET order_product_status_id = 8 where order_product_id = ".$data['order_product_id']);
		
		if($milestone_id!='')
		$this->db->query("UPDATE `order_milestone` SET status = 8 where milestone_id = ".$milestone_id);
	
		$for_query=$this->db->query("SELECT concat(first_name,concat(' ',last_name)) as name from `customer` where customer_id=".$generate_for);
		$for_customer=$for_query->result_array();
		$by_query=$this->db->query("SELECT concat(first_name,concat(' ',last_name)) as name from `customer` where customer_id=".$generate_by1);
		$by_customer=$by_query->result_array();
		$subject="Despute Generated on TP";
		$despute=$this->despute_model->getDespute($despute_id);
		$despute=$despute[0];
		
		$css="<style>table > tr > td { border:1px solid #000;}</style>";
		
		$message="Despute Generated on TP BY ".$by_customer[0]['name']." on ".$for_customer[0]['name'].":- <br>order_id : <b>".$despute['order_id']."</b> <br>order_product_id : <b>".$despute['order_product_id']."</b><br> Let's Check this despute from <a href='".base_url()."despute/negotiate/".$despute_id."'>HERE</a>";
		$Buyer_message="Dear ".$despute['payer_name'].",<br>You have generated a dispute in trustedpayer for the following product/service:</b>
		<table class='table' style='border-style:solid; border-width:1px; border-color:#000000;'>	
			<tr>				
				<td>Title</td>
				<td>".$despute['despute_reason']."</td>
				<td></td><td></td>
			</tr>
			<tr>				
				<td>Product /Service Name</td>
				<td>".$despute['name']."</td>
				<td></td><td></td>
			</tr>
			<tr>				
				<td>Seller</td>
				<td>".$despute['payee_name']."</td>
				<td></td><td></td>
			</tr>
			<tr>				
				<td>Order  ID </td>
				<td>".$despute['order_id']."</td>
				<td></td><td></td>
			</tr>
			<tr>				
				<td>Vendor</td>
				<td>".$despute['company_website']."</td>
				<td></td><td></td>
			</tr>
			<tr>				
				<td>Payment ID</td>
				<td>".$despute['order_product_id']."</td>
				<td></td><td></td>
			</tr>	
		</table>	
		<br> Please click <a href='".base_url()."despute/negotiate/".$despute_id."'>here</a> to review your seller's response ";
		
		$seller_message="Dear ".$despute['payee_name'].",<br>A dispute has been generated in TrustedPAYER on  your product/service by ".$by_customer[0]['name']."@".$by_customer[0]['name'].".com  with the following details : <br> 
		<table class='table' style='border-style:solid; border-width:1px; border-color:#000000;'>	
			<tr>				
				<td>Title</td>
				<td>".$despute['despute_reason']."</td>
				<td></td><td></td>
			</tr>
			<tr>				
				<td>Product /Service Name</td>
				<td>".$despute['name']."</td>
				<td></td><td></td>
			</tr>
			<tr>				
				<td>Seller</td>
				<td>".$despute['payee_name']."</td>
				<td></td><td></td>
			</tr>
			<tr>				
				<td>Order  ID </td>
				<td>".$despute['order_id']."</td>
				<td></td><td></td>
			</tr>
			<tr>				
				<td>Vendor</td>
				<td>".$despute['company_website']."</td>
				<td></td><td></td>
			</tr>
			<tr>				
				<td>Payment ID</td>
				<td>".$despute['order_product_id']."</td>
				<td></td><td></td>
			</tr>	
		</table>	
		<br> Please click  <a href='".base_url()."despute/negotiate/".$despute_id."'>here</a> to respond ";
		//$this->sendMail($generate_for,$subject,$seller_message);
		$this->sendMail($generate_by1,$subject,$css.$Buyer_message);
		return $despute_id;
	}
	public function regenrateDespute($despute_id)
	{
		$this->db->query("UPDATE `order_despute`  SET payer_amount=0,status=1 where despute_id = ".$despute_id);
	}
	public function acceptOffer($despute_id)
	{
		$this->db->query("UPDATE `order_despute` SET payer_amount=payee_amount,final_amount =payee_amount, status = 3 where despute_id = ".$despute_id);
		
		$p = $this->db->query("select * from `order_despute` where despute_id = ".$despute_id)->row();	
		
		$p_q=$this->db->query("select * from `order_product` where order_product_id =".$p->order_product_id)->row();
		
		if(isset($p->mileston_id))
			$p_m=$this->db->query("select * from `order_milestone` where mileston_id =".$p->mileston_id)->row();
		
		$data=array();
		$data['ip_address']=$this->input->ip_address();
		$data["date_added"]=date("Y-m-d H:i:s");
		$data['despute_id']=$despute_id;
		$data['payer_amount']=$p->payer_amount;
		$data['payee_amount']=$p->payee_amount;
		if(isset($p->mileston_id))
			$data['mileston_id']=$p->mileston_id;
		if(isset($p->mileston_id))
			$data['amount']=$p_m->amount;
		else
			$data['amount']=$p_q->total;
		$data['generated_by']=$p->generate_by;
		$data['reason']=$p->reason;
		$this->db->insert("order_despute_tmp",$data);
		
		$query=$this->db->query("UPDATE `order_product` SET order_product_status_id = 9 , total='".$p->final_amount."' where order_product_id =".$p->order_product_id);
		
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
		if(isset($to_customer[0]['verify']) && $to_customer[0]['verify'])
		{
			$this->sms->send($message,urlncode("+".$to_customer[0]['phonecode'].$to_customer[0]['customer_phone']));
		}
		/* sms send */
		
	}
	public function updateDesputePayer($despute_id,$data)
	{
		$this->db->query("UPDATE `order_despute` SET payer_amount=".str_replace("",",",$data['pay_amount'])." where despute_id = ".$despute_id);
	}
	public function updateDesputePayee($despute_id,$data)
	{
		$this->db->query("UPDATE `order_despute` SET payee_amount=".str_replace(",","",$data['receive_amount'])." where despute_id = ".$despute_id);
	}
	public function closeDespute($despute_id)
	{
		$this->db->query("UPDATE `order_despute` SET status=2 where despute_id = ".$despute_id);
	}
	public function finalDesputePayer($despute_id,$data)
	{
		$this->db->query("UPDATE `order_despute` SET payer_amount=".$data['pay_amount'].",final_amount =".$data['pay_amount'].", status = 3 where despute_id = ".$despute_id);
		
		$qr = $this->db->query(" select * from `order_despute` where despute_id = ".$despute_id)->row();
		$query=$this->db->query("UPDATE `order_product` SET order_product_status_id = 9 where order_product_id =".$qr->order_product_id);
		
		$p_q=$this->db->query("select * from `order_product` where order_product_status_id = 9  and order_product_id =".$qr->order_product_id)->row();	
		if(isset($qr->mileston_id))
			$p_m=$this->db->query("select * from `order_milestone` where mileston_id =".$qr->mileston_id)->row();
		
		$data=array();
		if(isset($qr->mileston_id))
			$data['mileston_id']=$qr->mileston_id;
		if(isset($qr->mileston_id))
			$data['amount']=$p_m->amount;
		else
			$data['amount']=$p_q->total;
		$data['ip_address']=$this->input->ip_address();
		$data["date_added"]=date("Y-m-d H:i:s");
		$data['despute_id']=$despute_id;
		$data['payer_amount']=$qr->payer_amount;
		$data['payee_amount']=$qr->payee_amount;
		$data['amount']=$p_q->total;
		$data['generated_by']=$qr->generate_by;
		$data['reason']=$qr->reason;		
		$this->db->insert("order_despute_tmp",$data);
		
		if($qr->milestone_id)
		$this->db->query("UPDATE `order_milestone` SET status = 9 where milestone_id =".$qr->milestone_id);
	}
	public function finalDesputePayee($despute_id,$data)
	{
		$this->db->query("UPDATE `order_despute` SET payee_amount=".$data['receive_amount'].",final_amount =".$data['receive_amount'].", status = 3 where despute_id = ".$despute_id);
		
		$qr = $this->db->query(" select * from `order_despute` where despute_id = ".$despute_id)->row();
		$query=$this->db->query("UPDATE `order_product` SET order_product_status_id = 9 where order_product_id =".$qr->order_product_id);

		$p_q=$this->db->query("select * from `order_product` where order_product_status_id = 9  and order_product_id =".$qr->order_product_id)->row();		
		$data=array();
		if(isset($qr->mileston_id))
			$p_m=$this->db->query("select * from `order_milestone` where mileston_id =".$qr->mileston_id)->row();
		if(isset($qr->mileston_id))
			$data['mileston_id']=$qr->mileston_id;
		if(isset($qr->mileston_id))
			$data['amount']=$p_m->amount;
		else
			$data['amount']=$p_q->total;
		
		$data['ip_address']=$this->input->ip_address();
		$data["date_added"]=date("Y-m-d H:i:s");
		$data['despute_id']=$despute_id;
		$data['payer_amount']=$qr->payer_amount;
		$data['payee_amount']=$qr->payee_amount;
		$data['amount']=$p_q->total;
		$data['generated_by']=$qr->generate_by;
		$data['reason']=$qr->reason;		
		$this->db->insert("order_despute_tmp",$data);
		
		if($qr->milestone_id)
		$this->db->query("UPDATE `order_milestone` SET status = 9 where milestone_id =".$qr->milestone_id);
	}
	public function getDespute($despute_id='',$order_product_id='')
	{
		if($despute_id!='')
		$despute_id=" and od.despute_id=".$despute_id;
		if($order_product_id!='')
		$order_product_id=" and op.order_product_id=".$order_product_id;
		$query=$this->db->query("SELECT NOW() as now,od.despute_id,od.payer_id,od.pre_delivery,od.payee_id,od.status as despute_status,od.payer_amount,od.final_amount,od.payee_amount,od.description as despute_description,od.generate_by,date_added as despute_date_added,op.* from `order_despute` od,`order_product` op where op.order_product_id=od.order_product_id ".$order_product_id.$despute_id);
		
		$query=$this->db->query("select q.*,om.amount as milestone_amount,cc.company_website ,odt.amount as total_despute_amount,payer_cust.first_name as payer_name,payer_cust.email as payer_email,payee_cust.email as payee_email,payee_cust.first_name as payee_name,odr.description AS despute_reason,ord.discount from (SELECT NOW() as now,od.remedy, od.reason,od.pre_delivery,od.remedy_discount,od.despute_id,od.payer_id,od.payee_id,od.status as despute_status,od.payer_amount,od.final_amount,od.payee_amount,od.description as despute_description,od.generate_by,date_added as despute_date_added,op.* ,od.milestone_id from `order_despute` od,`order_product` op where op.order_product_id=od.order_product_id ".$order_product_id.$despute_id.") q Left join `order_remedy_discount` ord on q.remedy_discount=ord.reason_id LEFT JOIN  `order_despute_reason` odr ON q.reason = odr.reason_id LEft join `customer` payee_cust on payee_cust.customer_id=q.payee_id LEFT JOIN  `order_milestone` om ON q.milestone_id = om.milestone_id LEFT JOIN  `order` ordr ON q.order_id = ordr.order_id LEFT JOIN  `customer_company` cc ON ordr.company_id = cc.customer_id LEFT JOIN  `order_despute_tmp` odt ON q.despute_id = odt.despute_id LEft join `customer` payer_cust on payer_cust.customer_id=q.payer_id");
		$this->db->query("UPDATE `order_despute` od SET `read`=1 where 1 ".str_replace("op.","od.",$despute_id.$order_product_id));
		return $query->result_array();
	}
	public function getDesputeReceiveList($customer_id)
	{
		$query=$this->db->query("SELECT NOW() as now,cus.first_name as generate_by_name,od.*,odr.description AS despute_reason from (SELECT * from `order_despute` od where (payer_id=".$customer_id." OR payee_id =".$customer_id.") AND generate_by !=".$customer_id.") od LEFT join customer cus on cus.customer_id=od.generate_by LEFT JOIN  `order_despute_reason` odr ON od.reason = odr.reason_id order by despute_id desc");
		return $query->result_array();
	}
	public function getDesputeGenerateList($customer_id)
	{
		$query=$this->db->query("SELECT NOW() as now,cus.first_name as generate_for_name,od.*,odr.description AS despute_reason from (SELECT * from `order_despute` od where (payer_id=".$customer_id." OR payee_id =".$customer_id.") AND generate_by =".$customer_id.") od LEFT join customer cus on cus.customer_id=((od.payer_id+od.payee_id)-".$customer_id.") LEFT JOIN  `order_despute_reason` odr ON od.reason = odr.reason_id order by despute_id desc");
		return $query->result_array();
	}
	public function checkPayer($payer_id,$order_product_id,$milestone='')
	{
		if(!$milestone)
		$query=$this->db->query("SELECT confirm_id from `payer` where customer_id = ".$payer_id." and order_product_id = ".$order_product_id);
		else
		$query=$this->db->query("SELECT confirm_id from `payer` where customer_id = ".$payer_id." and milestone_id = ".$milestone);	
		return $query->result_array();
	}
	public function checkPayee($payee_id,$order_product_id,$milestone='')
	{
		if(!$milestone)
		$query=$this->db->query("SELECT confirm_id from `payee` where customer_id = ".$payee_id." and order_product_id = ".$order_product_id);
		else
		$query=$this->db->query("SELECT confirm_id from `payee` where customer_id = ".$payee_id." and milestone_id = ".$milestone);	
		return $query->result_array();
	}
	public function completeProductOrder($order_product_id)
	{
		$query=$this->db->query("SELECT pyr.confirm_id as payer_confirm_id,pye.confirm_id as payee_confirm_id FROM `payer` pyr,`payee` pye where pyr.order_product_id=".$order_product_id." and pye.order_product_id=".$order_product_id);
		$result=$query->result_array();
		$fnl=$this->db->query("SELECT final_amount from `order_despute` where order_product_id = ".$order_product_id);
		$amount=$fnl->result_array();
		if(isset($result[0]))
		$this->db->query("UPDATE `order_product` SET order_product_status_id =9,total=".$amount[0]['final_amount']." where order_product_id = ".$order_product_id);
		else
		$this->db->query("UPDATE `order_product` SET order_product_status_id =5,total=".$amount[0]['final_amount']." where order_product_id = ".$order_product_id);
	}
	
	public function completeMilestoneOrder($milestone_id)
	{
		$query=$this->db->query("SELECT pyr.confirm_id as payer_confirm_id,pye.confirm_id as payee_confirm_id FROM `payer` pyr,`payee` pye where pyr.milestone_id=".$milestone_id." and pye.milestone_id=".$milestone_id);
		$result=$query->result_array();
		$fnl=$this->db->query("SELECT final_amount from `order_despute` where milestone_id = ".$milestone_id);
		$amount=$fnl->result_array();
		if(isset($result[0]))
		$this->db->query("UPDATE `order_milestone` SET status=9,amount=".$amount[0]['final_amount']." where milestone_id = ".$milestone_id);
		else
		$this->db->query("UPDATE `order_milestone` SET status_id =5,amount=".$amount[0]['final_amount']." where milestone_id = ".$milestone_id);
	}
	
	public function getDesputeReason($pre_delivery)
	{
		$query=$this->db->query("SELECT * from `order_despute_reason` where pre_delivery=".$pre_delivery);
		return $query->result_array();
	}
	public function getRemedyDiscount()
	{
		$query=$this->db->query("SELECT * from `order_remedy_discount`");
		return $query->result_array();
	}
	public function getRemedyReplacement()
	{
		$query=$this->db->query("SELECT * from `order_remedy_replacement`");
		return $query->result_array();
	}
	public function getRemedyCancelation()
	{
		$query=$this->db->query("SELECT * from `order_remedy_cancelation`");
		return $query->result_array();
	}
	public function mileston_data($mileston_id)
	{
		$query=$this->db->query("SELECT od.* from `order_milestone` om left join `order` od on om.order_id=od.order_id where om.milestone_id=".$mileston_id);
		return $query->result_array();
	}
	
}?>
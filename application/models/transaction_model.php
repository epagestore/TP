<?php
class Transaction_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}
	public function getTransaction($customer_id,$page_limit='',$transaction_id='')
	{
		$where='';
		if($transaction_id!='')
		$where=" AND transaction_id=".$transaction_id;
		$query=$this->db->query("select company.company_name,ct.*,ordr.currency_code,ordr.payer_id,IF(ordr.order_id IS NULL or ordr.order_id = '', substring_index(substring_index(ct.description,'ID',-1),'/',1), ordr.order_id) as order_id ,(select company.company_name from `customer_company` company where company.customer_id=(select oc.company_id from `order` oc where oc.order_id=IF(ordr.order_id IS NULL or ordr.order_id = '', substring_index(substring_index(ct.description,'ID',-1),'/',1), ordr.order_id))) as company_name FROM( SELECT * FROM `customer_transaction` where customer_id=".$customer_id.$where." order by transaction_id desc ".$page_limit."  ) ct LEFT JOIN `order_product` op on op.transaction_id=ct.transaction_id LEFT JOIN `order` ordr on ordr.order_id=op.order_id LEFT JOIN `order` ordr1 on ordr1.transaction_id=ct.transaction_id left join `customer_company` company on ordr.company_id=company.customer_id where ct.description NOT LIKE '%Commission Amount%'")->result_array();
		
		$arr=array();
		$arr[]=$query;
		$query=$this->db->query("select ct.*,ordr.currency_code,ordr.payer_id,IF(ordr.order_id IS NULL or ordr.order_id = '', substring_index(substring_index(ct.description,'ID',-1),'/',1), ordr.order_id) as order_id ,(select company.company_name from `customer_company` company where company.customer_id=(select oc.company_id from `order` oc where oc.order_id=IF(ordr.order_id IS NULL or ordr.order_id = '', substring_index(substring_index(ct.description,'ID',-1),'/',1), ordr.order_id))) as company_name,(select cr.email from customer cr where cr.customer_id=(select oc.payee_id from `order` oc where oc.order_id=IF(ordr.order_id IS NULL or ordr.order_id = '', substring_index(substring_index(ct.description,'ID',-1),'/',1), ordr.order_id))) as payee_name  FROM( SELECT * FROM `customer_transaction` where customer_id=".$customer_id.$where." order by transaction_id desc ".$page_limit."  ) ct LEFT JOIN `order_product` op on op.transaction_id=ct.transaction_id LEFT JOIN `order` ordr on ordr.order_id=op.order_id LEFT JOIN `order` ordr1 on ordr1.transaction_id=ct.transaction_id where ct.description LIKE '%Commission Amount%'")->result_array();
		$arr[]=$query;
		//$query=$this->db->query("select company.company_name,ct.*,ordr.payer_id,ordr.order_id,ordr.payee_id,concat(payer.first_name,concat(' ',payer.last_name)) as payer_name,concat(payee.first_name,concat(' ',payee.last_name)) as payee_name,ordr1.payer_id as payer_id1,ordr1.payee_id as payee_id1,concat(payer1.first_name,concat(' ',payer1.last_name)) as payer_name1,concat(payee1.first_name,concat(' ',payee1.last_name)) as payee_name1 FROM( SELECT * FROM `customer_transaction` where 1 and customer_id=".$customer_id.$where." order by transaction_id desc ".$page_limit."  ) ct LEFT JOIN `order_product` op on op.transaction_id=ct.transaction_id LEFT JOIN `order` ordr on ordr.order_id=op.order_id LEFT JOIN `order` ordr1 on ordr1.transaction_id=ct.transaction_id left join `customer` payer on ordr.payer_id=payer.customer_id left join `customer` payee on ordr.payee_id=payee.customer_id left join `customer` payer1 on ordr1.payer_id=payer1.customer_id left join `customer` payee1 on ordr1.payee_id=payee1.customer_id left join `customer_company` company on ordr.company_id=company.customer_id");
		$this->db->query("UPDATE `customer_transaction` SET `read`=1 where customer_id=$customer_id ".$where);
		return $arr;
	}
	public function getTransactionSearch($customer_id,$sno='',$txn='',$ord='',$vendor='',$amt='',$desc='',$fromDate='',$toDate='')
	{
		$having='';
		$where='';
		/*if($txn!='')
		$where=" AND transaction_id=".$transaction_id;*/
		if($txn!='')
		$where.=" AND transaction_id like '%".$txn."%'";
		//if($vendor!='')
		//$having=" having (payer_name like '%$vendor%' || payee_name like  '%$vendor%' || payer_name1 like  '%$vendor%' || payee_name1 like  '%$vendor%')";
		if($vendor!='')
		$having=" having company_name like '%$vendor%'";
		if($amt!='')
		$where.=" AND amount like '%$amt%'";
		if($desc!='')
		$where.=" AND description like '%$desc%'";
		if($fromDate!='')
		$where.=" AND date_added >= '$fromDate'";
		if($toDate!='')
		$where.=" AND date_added <= '$toDate'";
		$query=$this->db->query("select company.company_name,ct.*,ordr.payer_id,ordr.order_id FROM( SELECT * FROM `customer_transaction` where 1 and customer_id=".$customer_id.$where." order by transaction_id desc ) ct LEFT JOIN `order_product` op on op.transaction_id=ct.transaction_id LEFT JOIN `order` ordr on ordr.order_id=op.order_id LEFT JOIN `order` ordr1 on ordr1.transaction_id=ct.transaction_id left join `customer_company` company on ordr.company_id=company.customer_id".$having);
//		$query=$this->db->query("select ct.*,ordr.payer_id,ordr.payee_id,concat(payer.first_name,concat(' ',payer.last_name)) as payer_name,concat(payee.first_name,concat(' ',payee.last_name)) as payee_name,ordr1.payer_id as payer_id1,ordr1.payee_id as payee_id1,concat(payer1.first_name,concat(' ',payer1.last_name)) as payer_name1,concat(payee1.first_name,concat(' ',payee1.last_name)) as payee_name1 FROM( SELECT * FROM `customer_transaction` where 1 and customer_id=".$customer_id.$where." order by transaction_id desc ) ct LEFT JOIN `order_product` op on op.transaction_id=ct.transaction_id LEFT JOIN `order` ordr on ordr.order_id=op.order_id LEFT JOIN `order` ordr1 on ordr1.transaction_id=ct.transaction_id left join `customer` payer on ordr.payer_id=payer.customer_id left join `customer` payee on ordr.payee_id=payee.customer_id left join `customer` payer1 on ordr1.payer_id=payer1.customer_id left join `customer` payee1 on ordr1.payee_id=payee1.customer_id ".$having);
		$this->db->query("UPDATE `customer_transaction` SET `read`=1 where customer_id=$customer_id ".$where);
		return $query->result_array();
	}
	public function getTransaction_bckup($customer_id,$page_limit='')
	{
		$query=$this->db->query("SELECT * FROM customer_transaction where customer_id = ".$customer_id." order by transaction_id desc ".$page_limit." ");
		return $query->result_array();
	}
}?>
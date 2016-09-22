<?php 
/* Total Commissions 
Total paid Commissions 
No of Commissions receieved 
No of Commissions made 
Total received Commissions 
Total number of transactions  */
$customer_id= $this->session->userdata('customer_id');
$ci = &get_instance();
function total_order_sent($payer_id='',$company_id='',$payee_id='',$order_id='',$milestone='',$product_name='',$text='',$count=false,$total_amount=false,$group=false)
{		
	$ci = &get_instance();
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
	$amount='';
	if($text!='')
	{
		$where.=" and op.name like '%".$text."%' ";
		//$where1.=" where company.company_name like '%".$text."%' or concat(payee.first_name,'',payee.last_name) like '%".$text."%'";
	}	
	
	
	
//bug add new query
	if($total_amount==true)
	{
		$amount="sum(ordr.total_amount) as sent_amount,";
	}	
	$g='';
	if($group==true)
	{
		$g = " group by YEAR(ordr.date_added) desc";
	}	
	$query=$ci->db->query("select  od.despute_id,payer.first_name as payer_name,".$mile_count." payer.email as payer_email,payee.first_name as payee_name,payee.email as payee_email,company.company_website,company.company_name,omile.transaction_id as milestone_transaction_id, omile.payer_code as milestone_payer_code, omile.description as milestone_description,omile.payee_code as milestone_payee_code,omile.status as milestone_status,omile.milestone_id, amount AS milestone_amount, add_date AS milestone_added, q1.*,os.name as order_status_name from( select ".$amount." ordr.*,op.order_product_id,".$count."op.name as product_name,op.order_product_status_id,op.transaction_id as product_transaction_id,op.quantity as product_quantity,op.payee_code as product_payee_code,op.price,op.total as product_amount from `order` ordr, `order_product` op where ordr.order_id=op.order_id ".$where.$g." ) as q1 Left join `order_status` os  on q1.order_status_id = os.order_status_id LEFT join `order_milestone` omile ON q1.order_id=omile.order_id LEFT join `customer_company` company on company.customer_id=company_id LEFT JOIN `order_despute`  od on od.order_id=q1.order_id LEFT JOIN `customer` payer ON payer.customer_id=q1.payer_id LEFT JOIN `customer` payee ON payee.customer_id=q1.payee_id  ".$where1." $sort BY `q1`.`order_id` DESC");
	//echo $this->db->last_query();
	if($group==true)
	{
		
		return $query->result();
	}else if($total_amount==true)
	{
		if($group==true)
		return $query->result_array();
		else
		return $query->row();
	}	
	return $query->num_rows();
}

function total_order_received($payee_id,$payer_id='',$company='',$order_id='',$milestone='',$product_name='',$text='',$count=false,$total_amount=false,$group=false)
{
	$ci = &get_instance();
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
	$amount='';
	if($total_amount==true)
	{
		$amount="sum(ordr.total_amount) as sent_amount,";
	}
	$g='';
	if($group==true)
	{
		$g = " group by YEAR(ordr.date_added) desc";
	}	
	$query=$ci->db->query("select  despute_id,company.company_name,".$mile_count."company.company_website,payer.first_name as payer_name,payer.email as payer_email,payee.first_name as payee_name,payee.email as payee_email,omile.transaction_id as milestone_transaction_id ,omile.payer_code as milestone_payer_code, omile.description as milestone_description,omile.payee_code as milestone_payee_code,omile.status as milestone_status,omile.milestone_id, amount AS milestone_amount, add_date AS milestone_added,q1.*,os.name as order_status_name from( select ".$amount." ordr.*,op.order_product_id,".$count."op.name as product_name,op.order_product_status_id,op.transaction_id as product_transaction_id,op.quantity as product_quantity,op.payee_code as product_payee_code,op.price,op.total as product_amount from `order` ordr, `order_product` op where ordr.order_id=op.order_id and ordr.payee_id =".$payee_id.$where.$g." ORDER BY `ordr`.`order_id` DESC) as q1 Left join `order_status` os  on q1.order_status_id = os.order_status_id LEFT join `order_milestone` omile ON q1.order_id=omile.order_id LEFT join `customer_company` company on company.customer_id=company_id LEFT JOIN `order_despute`  od on od.order_id=q1.order_id LEFT JOIN `customer` payer ON payer.customer_id=q1.payer_id LEFT JOIN `customer` payee ON payee.customer_id=q1.payee_id $sort BY `q1`.`order_id` DESC ");
	//echo $this->db->last_query();
	if($group==true)
	{
		
		return $query->result();
	}else if($total_amount==true)
	{
		if($group==true)
		return $query->result_array();
		else
		return $query->row();
	}	
	return $query->num_rows();
}	
// sent order
$total_order_payer_p=total_order_sent($customer_id,'','','',0,'','',true);
$total_order_payer_m=total_order_sent($customer_id,'','','',1,'','',true);

$amount1=total_order_sent($customer_id,'','','',0,'','',true,true);
$amount2 = total_order_sent($customer_id,'','','',1,'','',true,true);

$total_order_payer_p_amount=$amount1->sent_amount;
$total_order_payer_m_amount=$amount2->sent_amount;

// received order
$total_order_payee_p=total_order_received($customer_id,'','','',0,'','',true);
$total_order_payee_m=total_order_received($customer_id,'','','',1,'','',true);

$amount3=total_order_received($customer_id,'','','',0,'','',true,true);
$amount4 = total_order_received($customer_id,'','','',1,'','',true,true);

$total_order_payer_p_amount=$amount3->sent_amount;
$total_order_payer_m_amount=$amount4->sent_amount;

// order number
$total_order=$total_order_payer_p+$total_order_payer_m+$total_order_payee_p+$total_order_payee_m;
$total_order_sent1=$total_order_payer_p+$total_order_payer_m;
$total_order_received=$total_order_payee_p+$total_order_payee_m;
$total_transaction=$total_order;

// order amount 
$total_order_amount=$amount1->sent_amount+$amount2->sent_amount+$amount3->sent_amount+$amount4->sent_amount;
$total_order_sent_amount=$amount1->sent_amount+$amount2->sent_amount;
$total_order_received_amount=$amount3->sent_amount+$amount4->sent_amount;
//$total_transaction_amount=$total_order_amount;
	

$total_order_payer_p_year=total_order_sent($customer_id,'','','',0,'','',true,true,true);
$total_order_payer_m_year=total_order_sent($customer_id,'','','',1,'','',true,true,true);
$yarr_sent_p=array();
if($total_order_sent_amount){
	foreach($total_order_payer_p_year as $ty)
	{
		$arr = array();
		$arr['year']=date("Y",strtotime($ty->date_added));
		$arr['amount']=round(($ty->sent_amount/$total_order_sent_amount)*100,2);
		foreach($total_order_payer_m_year as $ty1)
		{
			if(date("Y",strtotime($ty->date_added))==date("Y",strtotime($ty1->date_added)))
			{
				//$arr['amount_m']=round(($ty1->sent_amount/$total_order_amount)*100,2);
				break;
			}	
			
		}
		$yarr_sent_p[]=$arr;
		
	}
}
$yarr_sent_m=array();
if($total_order_received_amount)
{	
foreach($total_order_payer_m_year as $ty)
	{
		$arr = array();
		$arr['year']=date("Y",strtotime($ty->date_added));
		$arr['amount']=round(($ty->sent_amount/$total_order_received_amount)*100,2);
		$yarr_sent_m[]=$arr;
	}

}

?>

<?php 
// map-------------------
// day wise order
// total order day wise 

//$query=$this->db->query("select ct.*,ordr.currency_code,ordr.payer_id,IF(ordr.order_id IS NULL or ordr.order_id = '', substring_index(substring_index(ct.description,'ID',-1),'/',1), ordr.order_id) as order_id ,(select company.company_name from `customer_company` company where company.customer_id=(select oc.company_id from `order` oc where oc.order_id=IF(ordr.order_id IS NULL or ordr.order_id = '', substring_index(substring_index(ct.description,'ID',-1),'/',1), ordr.order_id))) as company_name,(select cr.email from customer cr where cr.customer_id=(select oc.payee_id from `order` oc where oc.order_id=IF(ordr.order_id IS NULL or ordr.order_id = '', substring_index(substring_index(ct.description,'ID',-1),'/',1), ordr.order_id))) as payee_name  FROM( SELECT * FROM `customer_transaction` where customer_id=".$customer_id.$where." order by transaction_id desc ".$page_limit."  ) ct LEFT JOIN `order_product` op on op.transaction_id=ct.transaction_id LEFT JOIN `order` ordr on ordr.order_id=op.order_id LEFT JOIN `order` ordr1 on ordr1.transaction_id=ct.transaction_id where ct.description LIKE '%Commission Amount%'")->result_array();


//$t_d_o=$ci->db->query('select sum(total_amount) as amount ,'.$dateForamte.' as date_added from `order` where (payer_id='.$customer_id." or payee_id=".$customer_id.") group by  ".$dateForamte." desc")->result_array();

$t_d_o=$ci->db->query("select  sum(ct.amount) as amount ,".str_replace("date_added","ct.date_added",$dateForamte)." as date_added  FROM( SELECT * FROM `customer_transaction` where customer_id=".$customer_id.$where." order by transaction_id) ct LEFT JOIN `order_product` op on op.transaction_id=ct.transaction_id LEFT JOIN `order` ordr on ordr.order_id=op.order_id LEFT JOIN `order` ordr1 on ordr1.transaction_id=ct.transaction_id where ct.description LIKE '%Commission Amount%' and ct.customer_id=".$customer_id)->result_array();

$total_transaction_amount=$ci->db->query("select  sum(ct.amount) as amount FROM( SELECT * FROM `customer_transaction` where customer_id=".$customer_id.$where." order by transaction_id) ct LEFT JOIN `order_product` op on op.transaction_id=ct.transaction_id LEFT JOIN `order` ordr on ordr.order_id=op.order_id LEFT JOIN `order` ordr1 on ordr1.transaction_id=ct.transaction_id where ct.description LIKE '%Commission Amount%' and ct.customer_id=".$customer_id)->row();

$no_c=$ci->db->query("select  count(ct.transaction_id) as no FROM( SELECT * FROM `customer_transaction` where customer_id=".$customer_id.$where." order by transaction_id) ct LEFT JOIN `order_product` op on op.transaction_id=ct.transaction_id LEFT JOIN `order` ordr on ordr.order_id=op.order_id LEFT JOIN `order` ordr1 on ordr1.transaction_id=ct.transaction_id where ct.description LIKE '%Commission Amount%' and ct.customer_id=".$customer_id)->row();

$no_c = $no_c->no;
$total_transaction_amount=$total_transaction_amount->amount;
// total paid Commissions
$t_d_o_p=$ci->db->query('select sum(total_amount) as amount ,'.$dateForamte.'as date_added from `order` where payer_id='.$customer_id." group by ".$dateForamte." desc")->result_array();

// total received Commissions 
$t_d_o_m=$ci->db->query('select sum(total_amount) as amount , '.$dateForamte.' as date_added from `order` where payee_id='.$customer_id." group by ".$dateForamte." desc")->result_array();

//No of Commissions paid 
$t_d_o_p_n=$ci->db->query('select count(*)as number ,'.$dateForamte.' as date_added from `order` where  payer_id='.$customer_id." group by ".$dateForamte."desc")->result_array();

//No of Commissions received 
$t_d_o_m_n=$ci->db->query('select count(*)as number ,'.$dateForamte.' as date_added from `order` where payee_id='.$customer_id." group by ".$dateForamte." desc")->result_array();

//Total number of transactions
$t_d_o_n=$ci->db->query('select count(*)as number ,'.$dateForamte.' as date_added  from `order` where payer_id='.$customer_id." or payee_id=".$customer_id." group by ".$dateForamte." desc")->result_array();
// map-------------------

//No of Commissions paid 
$total_paid=$ci->db->query('select count(*)as number  from `order` where  payer_id='.$customer_id)->row();

//No of Commissions received 
$total_received=$ci->db->query('select count(*)as number  from `order` where  payee_id='.$customer_id)->row();
$compare_chart=array();
$compare_chart[]=array("Order"=>"Number of paid Commissions", "Number"=>$total_paid->number);
$compare_chart[]=array("Order"=>"Number of received Commissions", "Number"=>$total_received->number);
?>

			<!-- BEGIN PAGE HEAD -->
			<div class="page-head">
				<!-- BEGIN PAGE TITLE -->
				<div class="page-title">
					<h1>Commission <small>statistics & reports</small></h1>
				</div>
				<!-- END PAGE TITLE -->
				<!-- BEGIN PAGE TOOLBAR -->
				
				<!-- END PAGE TOOLBAR -->
			</div>
			<!-- END PAGE HEAD -->
			<!-- BEGIN PAGE BREADCRUMB -->
			
			<!-- END PAGE BREADCRUMB -->
			<!-- BEGIN PAGE CONTENT INNER -->
			
			<div class="row margin-top-10">
				<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
					<div class="dashboard-stat2">
						<div class="display">
							<div class="number">
								<h3 class="font-red-sharp">
								   
									<span data-value="<?php echo $no_c; ?>" data-counter="counterup"><?php echo $no_c; ?></span>
									
								</h3>
								<small>TOTAL NO of Commissions</small>
							</div>
							<div class="icon">
								<i class="icon-pie-chart"></i>
							</div>
						</div>
						<div class="progress-info">
							<div class="progress">
								<span style="width: 100%;" class="progress-bar progress-bar-success red-sharp">
								<span class="sr-only">100% </span>
								</span>
							</div>
							<div class="status">
								<div class="status-title">
									 
								</div>
								<div class="status-number">
									 100%
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
					<div class="dashboard-stat2">
						<div class="display">
							<div class="number">
								<h3 class="font-green-sharp">
								   <?php echo $currency_symbol;?>
									<span data-value="<?php echo number_format(sprintf("%.2f", ($total_transaction_amount)*$value),2); ?>" data-counter="counterup"><?php echo sprintf("%.2f", ($total_transaction_amount)*$value); ?></span>
									
								</h3>
								<small>TOTAL Commissions</small>
							</div>
							<div class="icon">
								<i class="icon-pie-chart"></i>
							</div>
						</div>
						<div class="progress-info">
							<div class="progress">
								<span style="width: 100%;" class="progress-bar progress-bar-success green-sharp">
								<span class="sr-only">100% </span>
								</span>
							</div>
							<div class="status">
								<div class="status-title">
									 
								</div>
								<div class="status-number">
									 100%
								</div>
							</div>
						</div>
					</div>
				</div>
				
				<div class="row text-center col-md-12 col-sm-12">
				<div class="btn-group btn-toggle"> 
					<button class="btn btn-success active " data-toggle="collapse" data-target="#collapsible">Show Graph</button>
					<button class="btn btn-danger" data-toggle="collapse" data-target="#collapsible">Hide Graph</button>
				</div>				
				</div>
				<div class="well row collapse in" id="collapsible">
				<div class="portlet-title">
					<div class="caption">
						<span class="caption-subject bold uppercase font-dark"></span>
						<span class="caption-helper"></span>
					</div>					   
				 </div>
				<div class="col-md-12 portlet-body portlet light bordered">
					
					<div  id="order_amount" class="CSSAnimationChart"></div>
				</div>
				
				
			</div>
			</div>
			
			
<!-- graph start --->
          
<!-- graph Ends -->	
					



<script>
$(document).ready(function(){
	//comp_chart();
	order_amount();
	//order_paid_amount();
	//order_milestone_amount();
	//t_d_o_p_n();
	//t_d_o_m_n();
	//order_total_transection();
});
// order compare
var comp_chart= function(){
	if ("undefined" != typeof AmCharts && 0 !== $("#comp_chart").size()) {
		
		AmCharts.makeChart("comp_chart", {
		type : "pie",
		theme : "light",
		fontFamily : "Open Sans",
		color : "#888",
		dataProvider :<?php echo json_encode($compare_chart); ?>,
		valueField : "Number",
		titleField : "Order",
		exportConfig : {
			menuItems : [{
					icon : App.getGlobalPluginsPath() + "amcharts/amcharts/images/export.png",
					format : "png"
				}
			]
		}
	});
	}
	
};
 

// order-graph
var order_amount = function () {
if ("undefined" != typeof AmCharts && 0 !== $("#order_amount").size()) {
	AmCharts.makeChart("order_amount", {
		type : "serial",
		addClassNames : !0,
		theme : "light",
		path : "",
		autoMargins : !1,
		marginLeft : 100,
		marginRight : 8,
		marginTop : 10,
		marginBottom : 100,
		balloon : {
			adjustBorderColor : !1,
			horizontalPadding : 10,
			verticalPadding : 8,
			color : "#ffffff"
		},
		dataProvider :<?php echo json_encode($t_d_o); ?>,
		valueAxes : [{
				axisAlpha : 0,
				title: "<?php echo $currency_symbol;?>Amount"
			}
		],
		startDuration : 1,
		graphs : [{
				alphaField : "alpha",
				balloonText : "<span style='font-size:12px;'>[[title]] in [[category]]:<br><span style='font-size:20px;'>[[value]]</span> [[additional]]</span>",
				fillAlphas : 1,
				title : "Total Order Amount",
				type : "column",
				valueField : "amount",
				dashLengthField : "dashLengthColumn"
			}/* , {
				id : "graph2",
				balloonText : "<span style='font-size:12px;'>[[title]] in [[category]]:<br><span style='font-size:20px;'>[[value]]</span> [[additional]]</span>",
				bullet : "round",
				lineThickness : 3,
				bulletSize : 7,
				bulletBorderAlpha : 1,
				bulletColor : "#FFFFFF",
				useLineColorForBulletBorder : !0,
				bulletBorderThickness : 3,
				fillAlphas : 0,
				lineAlpha : 1,
				title : "Total paid Commissions",
				valueField : "amount"
			} */
		],
		chartCursor : {	
			cursorColor:'#000000',
						
			zoomable : !0,
			
		},
		categoryField : "date_added",
		categoryAxis : {
			gridPosition : "start",
			axisAlpha : 0,
			title:"<?php echo $map_x; ?>",labelRotation:60
		},
		"export" : {
			enabled : !0
		}
	})
}
};
//order_paid_amount
var order_paid_amount = function () {
if ("undefined" != typeof AmCharts && 0 !== $("#order_paid_amount").size()) {
	AmCharts.makeChart("order_paid_amount", {
		type : "serial",
		addClassNames : !0,
		theme : "light",
		path : "",
		autoMargins : !1,
		marginLeft : 100,
		marginRight : 8,
		marginTop : 10,
		marginBottom : 100,
		balloon : {
			adjustBorderColor : !1,
			horizontalPadding : 10,
			verticalPadding : 8,
			color : "#ffffff"
		},
		dataProvider :<?php echo json_encode($t_d_o_p); ?>,
		valueAxes : [{
				axisAlpha : 0,
				title: "<?php echo $currency_symbol;?>Amount"
			}
		],
		startDuration : 1,
		graphs : [{
				alphaField : "alpha",
				balloonText : "<span style='font-size:12px;'>[[title]] in [[category]]:<br><span style='font-size:20px;'>[[value]]</span> [[additional]]</span>",
				fillAlphas : 1,
				title : "Total paid Order Amount",
				type : "column",
				valueField : "amount",
				dashLengthField : "dashLengthColumn"
			}/* , {
				id : "graph2",
				balloonText : "<span style='font-size:12px;'>[[title]] in [[category]]:<br><span style='font-size:20px;'>[[value]]</span> [[additional]]</span>",
				bullet : "round",
				lineThickness : 3,
				bulletSize : 7,
				bulletBorderAlpha : 1,
				bulletColor : "#FFFFFF",
				useLineColorForBulletBorder : !0,
				bulletBorderThickness : 3,
				fillAlphas : 0,
				lineAlpha : 1,
				title : "Total paid Commissions",
				valueField : "amount"
			} */
		],
		chartCursor : {		
			cursorColor:'#000000',
						
			zoomable : !0,
			
		},
		categoryField : "date_added",
		categoryAxis : {
			gridPosition : "start",
			axisAlpha : 0,
			title:"<?php echo $map_x; ?>",labelRotation:60
		},
		"export" : {
			enabled : !0
		}
	})
}
};

//order_milestone_amount
var order_milestone_amount = function () {
if ("undefined" != typeof AmCharts && 0 !== $("#order_milestone_amount").size()) {
	AmCharts.makeChart("order_milestone_amount", {
		type : "serial",
		addClassNames : !0,
		theme : "light",
		path : "",
		autoMargins : !1,
		marginLeft : 100,
		marginRight : 8,
		marginTop : 10,
		marginBottom : 100,
		balloon : {
			adjustBorderColor : !1,
			horizontalPadding : 10,
			verticalPadding : 8,
			color : "#ffffff"
		},
		dataProvider :<?php echo json_encode($t_d_o_m); ?>,
		valueAxes : [{
				axisAlpha : 0,
				title: "<?php echo $currency_symbol;?>Amount"
			}
		],
		startDuration : 1,
		graphs : [{
				alphaField : "alpha",
				balloonText : "<span style='font-size:12px;'>[[title]] in [[category]]:<br><span style='font-size:20px;'>[[value]]</span> [[additional]]</span>",
				fillAlphas : 1,
				title : "Total Received Order Amount",
				type : "column",
				valueField : "amount",
				dashLengthField : "dashLengthColumn"
			}/* , {
				id : "graph2",
				balloonText : "<span style='font-size:12px;'>[[title]] in [[category]]:<br><span style='font-size:20px;'>[[value]]</span> [[additional]]</span>",
				bullet : "round",
				lineThickness : 3,
				bulletSize : 7,
				bulletBorderAlpha : 1,
				bulletColor : "#FFFFFF",
				useLineColorForBulletBorder : !0,
				bulletBorderThickness : 3,
				fillAlphas : 0,
				lineAlpha : 1,
				title : "Total paid Commissions",
				valueField : "amount"
			} */
		],
		chartCursor : {
			cursorColor:'#000000',
						
			zoomable : !0,
			
		},
		categoryField : "date_added",
		categoryAxis : {
			gridPosition : "start",
			axisAlpha : 0,
			title:"<?php echo $map_x; ?>",labelRotation:60
		},
		"export" : {
			enabled : !0
		}
	})
}
};


//order_total_transection
var order_total_transection = function () {
if ("undefined" != typeof AmCharts && 0 !== $("#order_total_transection").size()) {
	AmCharts.makeChart("order_total_transection", {
		type : "serial",
		addClassNames : !0,
		theme : "light",
		path : "",
		autoMargins : !1,
		marginLeft : 100,
		marginRight : 8,
		marginTop : 10,
		marginBottom : 100,
		balloon : {
			adjustBorderColor : !1,
			horizontalPadding : 10,
			verticalPadding : 8,
			color : "#ffffff"
		},
		dataProvider :<?php echo json_encode($t_d_o_n); ?>,
		valueAxes : [{
				axisAlpha : 0,
				title: "Number"
			}
		],
		startDuration : 1,
		graphs : [{
				alphaField : "alpha",
				balloonText : "<span style='font-size:12px;'>[[title]] in [[category]]:<br><span style='font-size:20px;'>[[value]]</span> [[additional]]</span>",
				fillAlphas : 1,
				title : "Total number of transactions",
				type : "column",
				valueField : "number",
				dashLengthField : "dashLengthColumn"
			}/* , {
				id : "graph2",
				balloonText : "<span style='font-size:12px;'>[[title]] in [[category]]:<br><span style='font-size:20px;'>[[value]]</span> [[additional]]</span>",
				bullet : "round",
				lineThickness : 3,
				bulletSize : 7,
				bulletBorderAlpha : 1,
				bulletColor : "#FFFFFF",
				useLineColorForBulletBorder : !0,
				bulletBorderThickness : 3,
				fillAlphas : 0,
				lineAlpha : 1,
				title : "Total paid Commissions",
				valueField : "amount"
			} */
		],
		chartCursor : {
			cursorColor:'#000000',
						
			zoomable : !0,
			
		},
		categoryField : "date_added",
		categoryAxis : {
			gridPosition : "start",
			axisAlpha : 0,
			title:"<?php echo $map_x; ?>",labelRotation:60
		},
		"export" : {
			enabled : !0
		}
	})
}
};
//total paid Commissions numbers
var t_d_o_p_n = function () {
if ("undefined" != typeof AmCharts && 0 !== $("#t_d_o_p_n").size()) {
	AmCharts.makeChart("t_d_o_p_n", {
		type : "serial",
		addClassNames : !0,
		theme : "light",
		path : "",
		autoMargins : !1,
		marginLeft : 100,
		marginRight : 8,
		marginTop : 10,
		marginBottom : 100,
		balloon : {
			adjustBorderColor : !1,
			horizontalPadding : 10,
			verticalPadding : 8,
			color : "#ffffff"
		},
		dataProvider :<?php echo json_encode($t_d_o_n); ?>,
		valueAxes : [{
				axisAlpha : 0,
				title: "Number"
			}
		],
		startDuration : 1,
		graphs : [{
				alphaField : "alpha",
				balloonText : "<span style='font-size:12px;'>[[title]] in [[category]]:<br><span style='font-size:20px;'>[[value]]</span> [[additional]]</span>",
				fillAlphas : 1,
				title : "No of Commissions paid",
				type : "column",
				valueField : "number",
				dashLengthField : "dashLengthColumn"
			}/* , {
				id : "graph2",
				balloonText : "<span style='font-size:12px;'>[[title]] in [[category]]:<br><span style='font-size:20px;'>[[value]]</span> [[additional]]</span>",
				bullet : "round",
				lineThickness : 3,
				bulletSize : 7,
				bulletBorderAlpha : 1,
				bulletColor : "#FFFFFF",
				useLineColorForBulletBorder : !0,
				bulletBorderThickness : 3,
				fillAlphas : 0,
				lineAlpha : 1,
				title : "Total paid Commissions",
				valueField : "amount"
			} */
		],
		chartCursor : {	
			cursorColor:'#000000',
						
			zoomable : !0,
			
		},
		categoryField : "date_added",
		categoryAxis : {
			gridPosition : "start",
			axisAlpha : 0,
			title:"<?php echo $map_x; ?>",labelRotation:60
		},
		"export" : {
			enabled : !0
		}
	})
}
};

//total No of Commissions received
var t_d_o_m_n = function () {
if ("undefined" != typeof AmCharts && 0 !== $("#t_d_o_m_n").size()) {
	AmCharts.makeChart("t_d_o_m_n", {
		type : "serial",
		addClassNames : !0,
		theme : "light",
		path : "",
		autoMargins : !1,
		marginLeft : 100,
		marginRight : 8,
		marginTop : 10,
		marginBottom : 100,
		balloon : {
			adjustBorderColor : !1,
			horizontalPadding : 10,
			verticalPadding : 8,
			color : "#ffffff"
		},
		dataProvider :<?php echo json_encode($t_d_o_m_n); ?>,
		valueAxes : [{
				axisAlpha : 0,
				title: "Number"
			}
		],
		startDuration : 1,
		graphs : [{
				alphaField : "alpha",
				balloonText : "<span style='font-size:12px;'>[[title]] in [[category]]:<br><span style='font-size:20px;'>[[value]]</span> [[additional]]</span>",
				fillAlphas : 1,
				title : "No of Commissions received",
				type : "column",
				valueField : "number",
				dashLengthField : "dashLengthColumn"
			}/* , {
				id : "graph2",
				balloonText : "<span style='font-size:12px;'>[[title]] in [[category]]:<br><span style='font-size:20px;'>[[value]]</span> [[additional]]</span>",
				bullet : "round",
				lineThickness : 3,
				bulletSize : 7,
				bulletBorderAlpha : 1,
				bulletColor : "#FFFFFF",
				useLineColorForBulletBorder : !0,
				bulletBorderThickness : 3,
				fillAlphas : 0,
				lineAlpha : 1,
				title : "Total paid Commissions",
				valueField : "amount"
			} */
		],
		chartCursor : {	
			cursorColor:'#000000',
						
			zoomable : !0,
			
		},
		categoryField : "date_added",
		categoryAxis : {
			gridPosition : "start",
			axisAlpha : 0,
			title:"<?php echo $map_x; ?>",labelRotation:60
		},
		"export" : {
			enabled : !0
		}
	})
}
};


</script>
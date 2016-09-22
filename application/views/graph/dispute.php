<?php $ci = &get_instance();?>

<?php
$customer_id=$this->session->userdata('customer_id');

//Dispute
$total_dispute = $ci->db->query("select distinct(op.order_id),od.order_id,od.* from order_despute od left join order_product op on op.order_id = od.order_id where  (od.payer_id = '".$customer_id."' or od.payee_id = '".$customer_id."' ) ")->num_rows();

if($_GET && isset($_GET['view']) && $_GET['view'] == 'week')
{

	//Email Money 
	$emailsent=$this->db->query("select  count(*)as number, WEEK(`date_added`)  as date_added from send_money_transaction where send_to='email' and customer_id = '".$customer_id."' group by   WEEK(`date_added`)  desc  ")->result_array();

	$emailreceived=$this->db->query("select  count(*)as number,WEEK(`date_added`) as date_added from request_money_transaction where request_to='email' and customer_id = '".$customer_id."' group by  WEEK(`date_added`) desc  ")->result_array();

}
else
{
	$order_dispute_genrated = $ci->db->query("select count(*)as number,DATE_FORMAT(od.date_added, '%d-%M') as date_added1,DATE_FORMAT(od.date_added, '%d-%M') as date_added from order_despute od  where  generate_by = '".$customer_id."'   group by  DATE_FORMAT(od.date_added, '%Y-%m-%d') desc ")->result_array();
	$order_dispute_received =  $ci->db->query("select count(*)as number,DATE_FORMAT(od.date_added, '%d-%M') as date_added1,DATE_FORMAT(od.date_added, '%d-%M') as date_added from order_despute od where (payer_id = '".$customer_id."' or payee_id = '".$customer_id."')  and generate_by != '".$customer_id."'   group by  DATE_FORMAT(od.date_added, '%Y-%m-%d') desc")->result_array();
	$order_dispute_resolved = $ci->db->query("select  count(*)as number,DATE_FORMAT(od.date_added, '%d-%M') as date_added1,DATE_FORMAT(od.date_added, '%d-%M') as date_added from order_despute od where status=3 and (payer_id = '".$customer_id."' or payee_id = '".$customer_id."')  group by  DATE_FORMAT(od.date_added, '%Y-%m-%d') desc")->result_array();
	$order_dispute_pending = $ci->db->query("select count(*)as number,DATE_FORMAT(od.date_added, '%d-%M') as date_added1,DATE_FORMAT(od.date_added, '%d-%M') as date_added from order_despute od where status=1 and (payer_id = '".$customer_id."' or payee_id = '".$customer_id."')   group by  DATE_FORMAT(od.date_added, '%Y-%m-%d') desc")->result_array();

}

$count_order_dispute_genrated =$ci->db->query("select od.order_id from order_despute od  where (payer_id = '".$customer_id."' or payee_id = '".$customer_id."')  and generate_by = '".$customer_id."'")->num_rows();
$count_order_dispute_received =$ci->db->query("select od.order_id from order_despute od where (payer_id = '".$customer_id."' or payee_id = '".$customer_id."')  and generate_by != '".$customer_id."' ")->num_rows();
$count_order_dispute_resolved =$ci->db->query("select od.order_id from order_despute od where status=3 and (payer_id = '".$customer_id."' or payee_id = '".$customer_id."') ")->num_rows();
$count_order_dispute_pending =$ci->db->query("select od.order_id from order_despute od where status=1 and (payer_id = '".$customer_id."' or payee_id = '".$customer_id."') ")->num_rows();


//compare Chart
$total_genrated =$ci->db->query("select count(*) as number  from order_despute od  where (payer_id = '".$customer_id."' or payee_id = '".$customer_id."')  and generate_by = '".$customer_id."'")->row();
$total_received =$ci->db->query("select count(*) as number  from order_despute od where (payer_id = '".$customer_id."' or payee_id = '".$customer_id."')  and generate_by != '".$customer_id."' ")->row();
$compare_chart=array();
$compare_chart[]=array("Order"=>"Total Dispute Genrated", "Number"=>$total_genrated->number);
$compare_chart[]=array("Order"=>"Total Dispute Resolved", "Number"=>$total_received->number);

?>

			<!-- BEGIN PAGE HEAD -->
			<div class="page-head">
				<!-- BEGIN PAGE TITLE -->
				<div class="page-title">
					<h1>Dispute <small>statistics & reports</small></h1>
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
				<!-- Total Dispute-->
				<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
					<div class="dashboard-stat2">
						<div class="display">
							<div class="number">
								<h3 class="font-green-sharp" data-value="<?php echo $total_dispute; ?>" data-counter="counterup"><?php echo $total_dispute; ?><small class="font-green-sharp">$</small></h3>
								<small>total dispute</small>
							</div>
							<div class="icon">
								<i class="icon-pie-chart"></i>
							</div>
						</div>
						<div class="progress-info">
							<div class="progress">
								<span style="width:100%" class="progress-bar progress-bar-success green-sharp">
								<span class="sr-only"> 100%</span>
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
				<!-- Total Dispute-->
				<!-- Total Dispute Genrated-->
				<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
					<div class="dashboard-stat2">
						<div class="display">
							<div class="number">
								<h3 class="font-blue-sharp" data-value="<?php echo $count_order_dispute_genrated; ?>" data-counter="counterup"><?php echo $order_dispute_genrated; ?><small class="font-green-sharp">$</small></h3>
								<small>order disputegenrated</small>
							</div>
							<div class="icon">
								<i class="icon-pie-chart"></i>
							</div>
						</div>
						<div class="progress-info">
							<div class="progress">
								<span style="width: <?php echo $total_dispute?(int)(($count_order_dispute_genrated/$total_dispute)*100):0; ?>%;" class="progress-bar progress-bar-success blue-sharp">
								<span class="sr-only">  <?php echo $total_dispute?(int)(($count_order_dispute_genrated/$total_dispute)*100):0; ?>%</span>
							</div>
							<div class="status">
								<div class="status-title">
									 
								</div>
								<div class="status-number">
									<?php echo $total_dispute?(int)(($count_order_dispute_genrated/$total_dispute)*100):0; ?>%
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- Total Dispute Genrated-->					
				<!-- Total Dispute receieved-->
				<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
					<div class="dashboard-stat2">
						<div class="display">
							<div class="number">
								<h3 class="font-red-haze"  data-value="<?php echo $count_order_dispute_received; ?>" data-counter="counterup"><?php echo $count_order_dispute_received; ?></h3>
								<small>order dispute Receive</small>
							</div>
							<div class="icon">
								<i class="icon-like"></i>
							</div>
						</div>
						<div class="progress-info">
							<div class="progress">
								<span style="width: <?php echo $total_dispute?(int)(($count_order_dispute_received/$total_dispute)*100):0; ?>%;" class="progress-bar progress-bar-success red-haze">
								<span class="sr-only">  <?php echo $total_dispute?(int)(($count_order_dispute_received/$total_dispute)*100):0; ?>%</span>
							</div>
							<div class="status">
								<div class="status-title">
									 
								</div>
								<div class="status-number">
									<?php echo $total_dispute?(int)(($count_order_dispute_received/$total_dispute)*100):0; ?>%
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- Total Dispute receieved-->
				<!-- Total Dispute Resolved-->
				<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
					<div class="dashboard-stat2">
						<div class="display">
							<div class="number">
								<h3 class="font-purple-soft"  data-value="<?php echo $count_order_dispute_resolved; ?>" data-counter="counterup"><?php echo $count_order_dispute_resolved; ?></h3>
								<small>order dispute Resolved</small>
							</div>
							<div class="icon">
								<i class="icon-like"></i>
							</div>
						</div>
						<div class="progress-info">
							<div class="progress">
								<span style="width: <?php echo $total_dispute?(int)(($count_order_dispute_resolved/$total_dispute)*100):0; ?>%;" class="progress-bar progress-bar-success purple-soft">
								<span class="sr-only">  <?php echo $total_dispute?(int)(($count_order_dispute_resolved/$total_dispute)*100):0; ?>%</span>
							</div>
							<div class="status">
								<div class="status-title">
									 
								</div>
								<div class="status-number">
									<?php echo $total_dispute?(int)(($count_order_dispute_resolved/$total_dispute)*100):0; ?>%
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- Total Dispute Resolved-->
				<!-- Total Dispute pending-->
				<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
					<div class="dashboard-stat2">
						<div class="display ">
							<div class="number ">
								<h3 class="font-yellow-haze dispute_pending"  data-value="<?php echo $count_order_dispute_pending; ?>" data-counter="counterup"><?php echo $count_order_dispute_pending; ?></h3>
								<small>order dispute pending</small>
							</div>
							<div class="icon">
								<i class="icon-like"></i>
							</div>
						</div>
						<div class="progress-info">
							<div class="progress">
								<span style="width: <?php echo $total_dispute?(int)(($count_order_dispute_pending/$total_dispute)*100):0; ?>%;" class="progress-bar progress-bar-success yellow-haze">
								<span class="sr-only">  <?php echo $total_dispute?(int)(($count_order_dispute_pending/$total_dispute)*100):0; ?>%</span>
							</div>
							<div class="status">
								<div class="status-title">
									 
								</div>
								<div class="status-number">
									<?php echo $total_dispute?(int)(($count_order_dispute_pending/$total_dispute)*100):0; ?>%
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
				<div class="row collapse in" id="collapsible">
				<!-- Total Dispute pending-->
				<div class="col-md-12 portlet-body">
					<div class="portlet-title">
						<div class="caption">
							<span class="caption-subject bold uppercase font-dark">Dispute Genrated </span>
							<span class="caption-helper"></span>
						</div>					   
					 </div>
					
				</div>
				<div class="col-md-12 portlet-body portlet light bordered">
					<div  id="order_dispute_genrated" class="CSSAnimationChart"></div>
				</div>
				<div class="col-md-12 portlet-body">
					<div class="portlet-title">
						<div class="caption">
							<span class="caption-subject bold uppercase font-dark">Dispute receieved </span>
							<span class="caption-helper"></span>
						</div>					   
					 </div>
					
				</div>
				<div class="col-md-12 portlet-body portlet light bordered">
					<div  id="order_dispute_received" class="CSSAnimationChart"></div>
				</div>
				<div class="col-md-12 portlet-body">
					<div class="portlet-title">
						<div class="caption">
							<span class="caption-subject bold uppercase font-dark">Dispute resolved</span>
							<span class="caption-helper"></span>
						</div>					   
					 </div>
					
				</div>
				<div class="col-md-12 portlet-body portlet light bordered">
						<div  id="order_dispute_resolved" class="CSSAnimationChart"></div>
				</div>
				<?php if($count_order_dispute_pending>0){?>
				<div class="col-md-12 portlet-body">
					<div class="portlet-title">
						<div class="caption">
							<span class="caption-subject bold uppercase font-dark">Dispute pending</span>
							<span class="caption-helper"></span>
						</div>					   
					 </div>
					
				</div>
				<div class="col-md-12 portlet-body portlet light bordered">
					<div  id="order_dispute_pending" class="CSSAnimationChart"></div>
				</div>
				<?php }?>
				<div class="col-md-12 portlet-body">
					<div class="portlet-title">
						<div class="caption">
							<span class="caption-subject bold uppercase font-dark">Dispute Genrated Vs Dispute Resolved</span>
							<span class="caption-helper"></span>
						</div>					   
					 </div>
					
				</div>
				<div class="col-md-12 portlet-body portlet light bordered">
					<div  id="comp_chart" class="CSSAnimationChart"></div>
				</div>
			</div>
			</div>
			
			
<!-- graph start --->
          
<!-- graph Ends -->	


<script>
$(document).ready(function(){
	comp_chart();
	order_dispute_genrated();
	order_dispute_received();
	order_dispute_resolved();
	if($('.dispute_pending').attr('data-value') > 0)
	 order_dispute_pending();
});
var order_dispute_genrated = function () {
if ("undefined" != typeof AmCharts && 0 !== $("#order_dispute_genrated").size()) {
	AmCharts.makeChart("order_dispute_genrated", {
		type : "serial",
		addClassNames : !0,
		theme : "",
		path : "",
		autoMargins : !1,
		marginLeft : 100,
		marginRight : 8,
		marginTop : 10,
		marginBottom : 26,
		balloon : {
			adjustBorderColor : !1,
			horizontalPadding : 10,
			verticalPadding : 8,
			color : "#ffffff"
		},
		dataProvider :<?php echo json_encode($order_dispute_genrated); ?>,
		valueAxes : [{
				axisAlpha : 0,
				position : "left",
				title:""
			}],
		startDuration : 1,
		graphs : [{
				alphaField : "alpha",
				balloonText : "<span style='font-size:12px;'>[[title]] in [[category]]:<br><span style='font-size:20px;'>[[value]]</span> [[additional]]</span>",
				fillAlphas : 1,
				title : "No of Monies Send",
				type : "column",
				valueField : "number",
				dashLengthField : "dashLengthColumn"
			} ,  /* {
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
				title : "Dispute Genrated",
				valueField : "number"
			}  */
		],
		categoryField : "date_added",
		categoryAxis : {
			gridPosition : "start",
			axisAlpha : 0,
			tickLength : 0
		},
		"export" : {
			enabled : !0
		}
	})
}
};
var order_dispute_received = function () {
if ("undefined" != typeof AmCharts && 0 !== $("#order_dispute_received").size()) {
	AmCharts.makeChart("order_dispute_received", {
		type : "serial",
		addClassNames : !0,
		theme : "",
		path : "",
		autoMargins : !1,
		marginLeft : 100,
		marginRight : 8,
		marginTop : 10,
		marginBottom : 26,
		balloon : {
			adjustBorderColor : !1,
			horizontalPadding : 10,
			verticalPadding : 8,
			color : "#ffffff"
		},
		dataProvider :<?php echo json_encode($order_dispute_received); ?>,
		valueAxes : [{
				axisAlpha : 0,
				position : "left"
			}
		],
		startDuration : 1,
		graphs : [{
				alphaField : "alpha",
				balloonText : "<span style='font-size:12px;'>[[title]] in [[category]]:<br><span style='font-size:20px;'>[[value]]</span> [[additional]]</span>",
				fillAlphas : 1,
				title :"No of Monies Receive",
				type : "column",
				valueField : "number",
				dashLengthField : "dashLengthColumn"
			} , /* {
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
				title : "No of Monies Receive",
				valueField : "number"
			} */
		],
		categoryField : "date_added",
		categoryAxis : {
			gridPosition : "start",
			axisAlpha : 0,
			tickLength : 0
		},
		"export" : {
			enabled : !0
		}
	})
}
};

// Order Resolved
var order_dispute_resolved = function () {
if ("undefined" != typeof AmCharts && 0 !== $("#order_dispute_resolved").size()) {
	AmCharts.makeChart("order_dispute_resolved", {
		type : "serial",
		addClassNames : !0,
		theme : "",
		path : "",
		autoMargins : !1,
		marginLeft : 100,
		marginRight : 8,
		marginTop : 10,
		marginBottom : 26,
		balloon : {
			adjustBorderColor : !1,
			horizontalPadding : 10,
			verticalPadding : 8,
			color : "#ffffff"
		},
		dataProvider :<?php echo json_encode($order_dispute_resolved); ?>,
		valueAxes : [{
				axisAlpha : 0,
				position : "left"
			}
		],
		startDuration : 1,
		graphs : [{
				alphaField : "alpha",
				balloonText : "<span style='font-size:12px;'>[[title]] in [[category]]:<br><span style='font-size:20px;'>[[value]]</span> [[additional]]</span>",
				fillAlphas : 1,
				title :"No of Monies Receive",
				type : "column",
				valueField : "number",
				dashLengthField : "dashLengthColumn"
			} ,/*  {
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
				title : "No of Monies Receive",
				valueField : "number"
			} */
		],
		categoryField : "date_added",
		categoryAxis : {
			gridPosition : "start",
			axisAlpha : 0,
			tickLength : 0
		},
		"export" : {
			enabled : !0
		}
	})
}
};
var order_dispute_pending = function () {
if ("undefined" != typeof AmCharts && 0 !== $("#order_dispute_pending").size()) {
	AmCharts.makeChart("order_dispute_pending", {
		type : "serial",
		addClassNames : !0,
		theme : "",
		path : "",
		autoMargins : !1,
		marginLeft : 100,
		marginRight : 8,
		marginTop : 10,
		marginBottom : 26,
		balloon : {
			adjustBorderColor : !1,
			horizontalPadding : 10,
			verticalPadding : 8,
			color : "#ffffff"
		},
		dataProvider :<?php echo json_encode($order_dispute_pending); ?>,
		valueAxes : [{
				axisAlpha : 0,
				position : "left"
			}
		],
		startDuration : 1,
		graphs : [{
				alphaField : "alpha",
				balloonText : "<span style='font-size:12px;'>[[title]] in [[category]]:<br><span style='font-size:20px;'>[[value]]</span> [[additional]]</span>",
				fillAlphas : 1,
				title :"No of Monies Receive",
				type : "column",
				valueField : "number",
				dashLengthField : "dashLengthColumn"
			} , /* {
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
				title : "No of Monies Receive",
				valueField : "number"
			} */
		],
		categoryField : "date_added",
		categoryAxis : {
			gridPosition : "start",
			axisAlpha : 0,
			tickLength : 0
		},
		"export" : {
			enabled : !0
		}
	})
}
};
//Compare Dispute Receive And Dispute Genrated
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
</script>
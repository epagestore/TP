<?php $ci = &get_instance();?>

<?php
$customer_id=$this->session->userdata('customer_id');

//Invoice
$count_total_invoice=$this->db->query("select * from invoice where customer_id = '".$customer_id."'")->num_rows();
$count_total_invoice_paid=$this->db->query("select * from invoice where status=3 and customer_id = '".$customer_id."'")->num_rows();
$count_total_invoice_sent=$this->db->query("select * from invoice where status=2 and customer_id = '".$customer_id."'")->num_rows();
$count_total_invoice_pending=$this->db->query("select * from invoice where status=1 and customer_id = '".$customer_id."'")->num_rows();



$total_invoice=$ci->db->query("select count(*)as number,".$dateForamte." as date_added from invoice where customer_id = '".$customer_id."' group by  ".$dateForamte." desc ")->result_array();
$total_invoice_paid=$this->db->query("select count(*)as number,".$dateForamte." as date_added from invoice where status=3 and customer_id = '".$customer_id."' group by  ".$dateForamte." desc ")->result_array();
$total_invoice_sent=$this->db->query("select count(*)as number,".$dateForamte." as date_added  from invoice where status=2 and customer_id = '".$customer_id."' group by  ".$dateForamte." desc ")->result_array();
$total_invoice_pending=$this->db->query("select count(*)as number,".$dateForamte." as date_added  from invoice where status=1 and customer_id = '".$customer_id."' group by  ".$dateForamte." desc ")->result_array();



//compare Chart
$invoice_paid =$ci->db->query("select count(*) as number from invoice where customer_id = '".$customer_id."'")->row();
$invoice_pending =$ci->db->query("select count(*) as number  from invoice where customer_id = '".$customer_id."'")->row();
$compare_chart=array();
$compare_chart[]=array("Order"=>"Total invoives paid ", "Number"=>$invoice_paid->number);
$compare_chart[]=array("Order"=>"Total invoices pending", "Number"=>$invoice_pending->number);
?>


		<div class="page-content">
			<!-- BEGIN PAGE HEAD -->
			<div class="page-head">
				<!-- BEGIN PAGE TITLE -->
				<div class="page-title">
					<h1>Invoice  <small>statistics & reports</small></h1>
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
								<h3 class="font-yellow-gold" data-value="<?php echo $count_total_invoice; ?>" data-counter="counterup"><?php echo $count_total_invoice; ?><small class="font-green-sharp">$</small></h3>
								<small>Total Invoice</small>
							</div>
							<div class="icon">
								<i class="icon-pie-chart"></i>
							</div>
						</div>
						<div class="progress-info">
							<div class="progress">
								<span style="width:100%" class="progress-bar progress-bar-success yellow-gold">
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
								<h3 class="font-green-sharp" data-value="<?php echo $count_total_invoice_paid; ?>" data-counter="counterup"><?php echo $count_total_invoice_paid; ?><small class="font-green-sharp">$</small></h3>
								<small>Total Invoice Paid</small>
							</div>
							<div class="icon">
								<i class="icon-pie-chart"></i>
							</div>
						</div>
						<div class="progress-info">
							<div class="progress">
								<span style="width: <?php echo $count_total_invoice?(int)(($count_total_invoice_paid/$count_total_invoice)*100):0; ?>%;" class="progress-bar progress-bar-success green-sharp">
								<span class="sr-only">  <?php echo $count_total_invoice?(int)(($count_total_invoice_paid/$count_total_invoice)*100):0; ?>%</span>
							</div>
							<div class="status">
								<div class="status-title">
									 
								</div>
								<div class="status-number">
									<?php echo $count_total_invoice?(int)(($count_total_invoice_paid/$count_total_invoice)*100):0; ?>%
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
								<h3 class="font-purple"  data-value="<?php echo $count_total_invoice_sent; ?>" data-counter="counterup"><?php echo $count_total_invoice_sent; ?></h3>
								<small>count total invoice sent</small>
							</div>
							<div class="icon">
								<i class="icon-like"></i>
							</div>
						</div>
						<div class="progress-info">
							<div class="progress">
								<span style="width: <?php echo $count_total_invoice?(int)(($count_total_invoice_sent/$count_total_invoice)*100):0; ?>%;" class="progress-bar progress-bar-success purple">
								<span class="sr-only">  <?php echo $count_total_invoice?(int)(($count_total_invoice_sent/$count_total_invoice)*100):0; ?>%</span>
							</div>
							<div class="status">
								<div class="status-title">
									 
								</div>
								<div class="status-number">
									<?php echo $count_total_invoice?(int)(($count_total_invoice_sent/$count_total_invoice)*100):0; ?>%
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
								<h3 class="font-blue-hoki"  data-value="<?php echo $count_total_invoice_pending; ?>" data-counter="counterup"><?php echo $count_total_invoice_pending; ?></h3>
								<small>count total invoice pending</small>
							</div>
							<div class="icon">
								<i class="icon-like"></i>
							</div>
						</div>
						<div class="progress-info">
							<div class="progress">
								<span style="width: <?php echo $count_total_invoice?(int)(($count_total_invoice_pending/$count_total_invoice)*100):0; ?>%;" class="progress-bar progress-bar-success blue-hoki">
								<span class="sr-only">  <?php echo $count_total_invoice?(int)(($count_total_invoice_pending/$count_total_invoice)*100):0; ?>%</span>
							</div>
							<div class="status">
								<div class="status-title">
									 
								</div>
								<div class="status-number">
									<?php echo $count_total_invoice?(int)(($count_total_invoice_pending/$count_total_invoice)*100):0; ?>%
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- count_total_invoice-->
				<!-- Total Dispute pending-->
				<div class="row text-center col-md-12 col-sm-12">
				<div class="btn-group btn-toggle"> 
					<button class="btn btn-success active " data-toggle="collapse" data-target="#collapsible">Show Graph</button>
					<button class="btn btn-danger" data-toggle="collapse" data-target="#collapsible">Hide Graph</button>
				</div>				
				</div>
				<div class="row collapse in" id="collapsible">
				<div class="col-md-12 portlet-body">
					<div class="portlet-title">
						<div class="caption">
							<span class="caption-subject bold uppercase font-dark">Total Invoice </span>
							<span class="caption-helper"></span>
						</div>					   
					 </div>
				</div>
				<div class="col-md-12 portlet-body portlet light bordered">
					<div  id="total_invoice" class="CSSAnimationChart"></div>
				</div>
				<div class="col-md-12 portlet-body">
					<div class="portlet-title">
						<div class="caption">
							<span class="caption-subject bold uppercase font-dark">Total Invoice Paid </span>
							<span class="caption-helper"></span>
						</div>					   
					 </div>
				</div>
				<div class="col-md-12 portlet-body portlet light bordered">
					<div  id="total_invoice_paid" class="CSSAnimationChart"></div>
				</div>
				<div class="col-md-12 portlet-body">
					<div class="portlet-title">
						<div class="caption">
							<span class="caption-subject bold uppercase font-dark">Total Invoice sent</span>
							<span class="caption-helper"></span>
						</div>					   
					 </div>
				</div>
				<div class="col-md-12 portlet-body portlet light bordered">
					<div  id="total_invoice_sent" class="CSSAnimationChart"></div>
				</div>
				<div class="col-md-12 portlet-body">
					<div class="portlet-title">
						<div class="caption">
							<span class="caption-subject bold uppercase font-dark">Total Invoice Pending</span>
							<span class="caption-helper"></span>
						</div>					   
					 </div>
				</div>
				<div class="col-md-12 portlet-body portlet light bordered">
					<div  id="total_invoice_pending" class="CSSAnimationChart"></div>
				</div>				
				<div class="col-md-12 portlet-body">
					<div class="portlet-title">
						<div class="caption">
							<span class="caption-subject bold uppercase font-dark">Total invoives paid vs total invoices pending</span>
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
					
			
				
			
			
		
	</div>
	
	</div>
	<!-- END CONTENT -->
</div>
</section>

<script>
$(document).ready(function(){
	comp_chart();
	total_invoice();
	total_invoice_paid();
	total_invoice_sent();
	total_invoice_pending();
});
var total_invoice = function () {
if ("undefined" != typeof AmCharts && 0 !== $("#total_invoice").size()) {
	AmCharts.makeChart("total_invoice", {
		type : "serial",
		addClassNames : !0,
		theme : "",
		path : "",
		autoMargins : !1,
		marginLeft : 100,
		marginRight : 8,
		marginTop : 10,
		marginBottom : 110,
		balloon : {
			adjustBorderColor : !1,
			horizontalPadding : 10,
			verticalPadding : 8,
			color : "#ffffff"
		},
		dataProvider :<?php echo json_encode($total_invoice); ?>,
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
				title : "No of total_invoice",
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
		],chartCursor : {	
			cursorColor:'#000000',
						
			zoomable : !0,
			
		},
		categoryField : "date_added",
		categoryAxis : {
			gridPosition : "start",
			axisAlpha : 0,
			tickLength : 0,title:"<?php echo $map_x; ?>",labelRotation:60
		},
		"export" : {
			enabled : !0
		}
	})
}
};
var total_invoice_paid = function () {
if ("undefined" != typeof AmCharts && 0 !== $("#total_invoice_paid").size()) {
	AmCharts.makeChart("total_invoice_paid", {
		type : "serial",
		addClassNames : !0,
		theme : "",
		path : "",
		autoMargins : !1,
		marginLeft : 100,
		marginRight : 8,
		marginTop : 10,
		marginBottom : 110,
		balloon : {
			adjustBorderColor : !1,
			horizontalPadding : 10,
			verticalPadding : 8,
			color : "#ffffff"
		},
		dataProvider :<?php echo json_encode($total_invoice_paid); ?>,
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
				title :"No of total_invoice_paid",
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
		],chartCursor : {	
			cursorColor:'#000000',
						
			zoomable : !0,
			
		},
		categoryField : "date_added",
		categoryAxis : {
			gridPosition : "start",
			axisAlpha : 0,
			tickLength : 0,title:"<?php echo $map_x; ?>",labelRotation:60
		},
		"export" : {
			enabled : !0
		}
	})
}
};

// Order Resolved
var total_invoice_sent = function () {
if ("undefined" != typeof AmCharts && 0 !== $("#total_invoice_sent").size()) {
	AmCharts.makeChart("total_invoice_sent", {
		type : "serial",
		addClassNames : !0,
		theme : "",
		path : "",
		autoMargins : !1,
		marginLeft : 100,
		marginRight : 8,
		marginTop : 10,
		marginBottom : 110,
		balloon : {
			adjustBorderColor : !1,
			horizontalPadding : 10,
			verticalPadding : 8,
			color : "#ffffff"
		},
		dataProvider :<?php echo json_encode($total_invoice_sent); ?>,
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
				title :"No of total_invoice_sent",
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
		],chartCursor : {	
			cursorColor:'#000000',
						
			zoomable : !0,
			
		},
		categoryField : "date_added",
		categoryAxis : {
			gridPosition : "start",
			axisAlpha : 0,
			tickLength : 0,title:"<?php echo $map_x; ?>",labelRotation:60
		},
		"export" : {
			enabled : !0
		}
	})
}
};
var total_invoice_pending = function () {
if ("undefined" != typeof AmCharts && 0 !== $("#total_invoice_pending").size()) {
	AmCharts.makeChart("total_invoice_pending", {
		type : "serial",
		addClassNames : !0,
		theme : "",
		path : "",
		autoMargins : !1,
		marginLeft : 100,
		marginRight : 8,
		marginTop : 10,
		marginBottom : 110,
		balloon : {
			adjustBorderColor : !1,
			horizontalPadding : 10,
			verticalPadding : 8,
			color : "#ffffff"
		},
		dataProvider :<?php echo json_encode($total_invoice_pending); ?>,
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
				title :"No of total_invoice_pending",
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
		chartCursor : {	
			cursorColor:'#000000',
						
			zoomable : !0,
			
		},
		categoryField : "date_added",
		categoryAxis : {
			gridPosition : "start",
			axisAlpha : 0,
			tickLength : 0,title:"<?php echo $map_x; ?>",labelRotation:60
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
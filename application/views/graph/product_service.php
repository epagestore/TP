<?php 

/* Total orders 
Total paid orders 
No of orders receieved 
No of orders made 
Total received orders 
Total number of transactions  */
$customer_id= $this->session->userdata('customer_id');
$ci = &get_instance();


$products_ordered = $this->db->query('select (select sum(quantity) from order_product opt where ord.order_id=opt.order_id) as number,'.$dateForamte.' as date_added from order_product op left join `order` ord on op.order_id=ord.order_id where ord.payer_id ="'.$customer_id.'" group by '.$dateForamte.' desc')->result_array();

$products_received = $this->db->query('select (select sum(quantity) from order_product opt where ord.order_id=opt.order_id) as number,'.$dateForamte.' as date_added from order_product op left join `order` ord on op.order_id=ord.order_id where ord.payee_id ="'.$customer_id.'" group by '.$dateForamte.' desc')->result_array();

$services_ordered = $this->db->query('select (select count(*) from order_milestone opt where ord.order_id=opt.order_id) as number,'.$dateForamte.' as date_added from order_milestone op left join `order` ord on op.order_id=ord.order_id where ord.payer_id ="'.$customer_id.'" group by '.$dateForamte.' desc')->result_array();

$services_received = $this->db->query('select (select count(*) from order_milestone opt where ord.order_id=opt.order_id) as number,'.$dateForamte.' as date_added from order_milestone op left join `order` ord on op.order_id=ord.order_id where ord.payee_id ="'.$customer_id.'" group by '.$dateForamte.' desc')->result_array();

//No of orders received 
$total_product_order=$ci->db->query('select count(*) as number,DATE_FORMAT(ord.date_added, "%Y-%m-%d") as date_added from order_product op left join `order` ord on op.order_id=ord.order_id where ord.payer_id ='.$customer_id)->row();

$total_product_received=$ci->db->query('select count(*) as number,DATE_FORMAT(ord.date_added, "%Y-%m-%d") as date_added from order_product op left join `order` ord on op.order_id=ord.order_id where ord.payee_id ='.$customer_id)->row();

$total_service_order=$ci->db->query('select count(*) as number,DATE_FORMAT(ord.date_added, "%Y-%m-%d") as date_added from order_milestone op left join `order` ord on op.order_id=ord.order_id where ord.payer_id ='.$customer_id)->row();

$total_service_received=$ci->db->query('select count(*) as number,DATE_FORMAT(ord.date_added, "%Y-%m-%d") as date_added from order_milestone op left join `order` ord on op.order_id=ord.order_id where ord.payee_id ='.$customer_id)->row();


$no_product_order	 = $total_product_order->number;
$no_product_received = $total_product_received->number;
$no_service_order = $total_service_order->number;
$no_service_received = $total_service_received->number;
$no_product = ($no_product_order+$no_product_received);
$no_service = ($no_service_received+$no_service_order);

$product_comp_chart=array();
$product_comp_chart[]=array("Order"=>"Number of Product Order", "Number"=>$total_product_order->number);
$product_comp_chart[]=array("Order"=>"Number of Product Received", "Number"=>$total_product_received->number);

$service_comp_chart=array();
$service_comp_chart[]=array("Order"=>"Number of Services Order", "Number"=>$total_service_order->number);
$service_comp_chart[]=array("Order"=>"Number of Services Received ", "Number"=>$total_service_received->number);
?>
			<!-- BEGIN PAGE HEAD -->
			<div class="page-head">
				<!-- BEGIN PAGE TITLE -->
				<div class="page-title">
					<h1>Products & Services<small>statistics & reports</small></h1>
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
								<h3 class="font-green-sharp" data-value="<?php echo $no_product; ?>" data-counter="counterup"><?php echo $no_product; ?><small class="font-green-sharp"></small></h3>
								<small>Total number of product</small>
							</div>
							<div class="icon">
								<i class="icon-pie-chart"></i>
							</div>
						</div>
						<div class="progress-info">
							<div class="progress">
								<span style="width: 100%;" class="progress-bar progress-bar-success green-sharp">
								<span class="sr-only"> 100%</span>
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
				<!-- Total Dispute Genrated-->					
				<!-- Total Dispute receieved-->
				<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
					<div class="dashboard-stat2">
						<div class="display">
							<div class="number">
								<h3 class="font-red-haze"  data-value="<?php echo $no_product_order; ?>" data-counter="counterup"><?php echo $no_product_order; ?></h3>
								<small>Total number of Product order</small>
							</div>
							<div class="icon">
								<i class="icon-like"></i>
							</div>
						</div>
						<div class="progress-info">
							<div class="progress">
								<span style="width: <?php echo $no_product?(int)(($no_product_order/$no_product)*100):0; ?>%;" class="progress-bar progress-bar-success red-haze">
								<span class="sr-only">  <?php echo $no_product?(int)(($no_product_order/$no_product)*100):0; ?>%</span>
							</div>
							<div class="status">
								<div class="status-title">
									 
								</div>
								<div class="status-number">
									<?php echo $no_product?(int)(($no_product_order/$no_product)*100):0; ?>%
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
								<h3 class="font-purple-soft"  data-value="<?php echo $no_product_received; ?>" data-counter="counterup"><?php echo $no_product_received; ?></h3>
								<small>Total number of Product Received</small>
							</div>
							<div class="icon">
								<i class="icon-like"></i>
							</div>
						</div>
						<div class="progress-info">
							<div class="progress">
								<span style="width: <?php echo $no_product?(int)(($no_product_received/$no_product)*100):0; ?>%;" class="progress-bar progress-bar-success purple-soft">
								<span class="sr-only">  <?php echo $no_product?(int)(($no_product_received/$no_product)*100):0; ?>%</span>
							</div>
							<div class="status">
								<div class="status-title">
									 
								</div>
								<div class="status-number">
									<?php echo $no_product?(int)(($no_product_received/$no_product)*100):0; ?>%
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
					<div class="dashboard-stat2">
						<div class="display">
							<div class="number">
								<h3 class="font-grey-mint" data-value="<?php echo $no_service; ?>" data-counter="counterup"><?php echo $no_service; ?><small class="font-grey-mint"></small></h3>
								<small>Total number of service</small>
							</div>
							<div class="icon">
								<i class="icon-pie-chart"></i>
							</div>
						</div>
						<div class="progress-info">
							<div class="progress">
								<span style="width: 100%;" class="progress-bar progress-bar-success grey-mint">
								<span class="sr-only"> 100%</span>
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
				<!-- Total Dispute Genrated-->					
				<!-- Total Dispute receieved-->
				<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
					<div class="dashboard-stat2">
						<div class="display">
							<div class="number">
								<h3 class="font-yellow-haze"  data-value="<?php echo $no_service_order; ?>" data-counter="counterup"><?php echo $no_service_order; ?></h3>
								<small>Total number of service order</small>
							</div>
							<div class="icon">
								<i class="icon-like"></i>
							</div>
						</div>
						<div class="progress-info">
							<div class="progress">
								<span style="width: <?php echo $no_service?(int)(($no_service_order/$no_service)*100):0; ?>%;" class="progress-bar progress-bar-success yellow-haze">
								<span class="sr-only">  <?php echo $no_service?(int)(($no_service_order/$no_service)*100):0; ?>%</span>
							</div>
							<div class="status">
								<div class="status-title">
									 
								</div>
								<div class="status-number">
									<?php echo $no_service?(int)(($no_service_order/$no_service)*100):0; ?>%
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
								<h3 class="font-red-soft"  data-value="<?php echo $no_service_received; ?>" data-counter="counterup"><?php echo $no_service_received; ?></h3>
								<small>Total number of service Received</small>
							</div>
							<div class="icon">
								<i class="icon-like"></i>
							</div>
						</div>
						<div class="progress-info">
							<div class="progress">
								<span style="width: <?php echo $no_service?(int)(($no_service_received/$no_service)*100):0; ?>%;" class="progress-bar progress-bar-success red-soft">
								<span class="sr-only">  <?php echo $no_service?(int)(($no_service_received/$no_service)*100):0; ?>%</span>
							</div>
							<div class="status">
								<div class="status-title">
									 
								</div>
								<div class="status-number">
									<?php echo $no_service?(int)(($no_service_received/$no_service)*100):0; ?>%
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
				
				<div class="portlet-title">
					<div class="caption">
						<span class="caption-subject bold uppercase font-dark">products ordered</span>
						<span class="caption-helper"></span>
					</div>					   
				 </div>
				<div class="col-md-12 portlet-body portlet light bordered">
					
					<div  id="products_ordered" class="CSSAnimationChart"></div>
				</div>
				<div class="portlet-title">
					<div class="caption">
						<span class="caption-subject bold uppercase font-dark">products received</span>
						<span class="caption-helper"></span>
					</div>					   
				 </div>
				<div class="col-md-12 portlet-body portlet light bordered">
					
					<div  id="products_received" class="CSSAnimationChart"></div>
				</div>
				<div class="portlet-title">
					<div class="caption">
						<span class="caption-subject bold uppercase font-dark">services ordered</span>
						<span class="caption-helper"></span>
					</div>					   
				 </div>
				<div class="col-md-12 portlet-body portlet light bordered">
					
					<div  id="services_ordered" class="CSSAnimationChart"></div>
				</div>
				<div class="portlet-title">
					<div class="caption">
						<span class="caption-subject bold uppercase font-dark">services received</span>
						<span class="caption-helper"></span>
					</div>					   
				 </div>
				<div class="col-md-12 portlet-body portlet light bordered">
					
					<div  id="services_received" class="CSSAnimationChart"></div>
				</div>
				<div class="portlet-title">
					<div class="caption">
						<span class="caption-subject bold uppercase font-dark">Products Compare Chart</span>
						<span class="caption-helper"></span>
					</div>					   
				 </div>
				<div class="col-md-12 portlet-body portlet light bordered">
					<div  id="product_comp_chart" class="CSSAnimationChart"></div>
				</div>
				<div class="portlet-title">
					<div class="caption">
						<span class="caption-subject bold uppercase font-dark">Services Compare Chart</span>
						<span class="caption-helper"></span>
					</div>					   
				 </div>
				<div class="col-md-12 portlet-body portlet light bordered">
					<div  id="service_comp_chart" class="CSSAnimationChart"></div>
				</div>
				
			</div>
			</div>
			
			
<!-- graph start --->
          
<!-- graph Ends -->	

<script>
$(document).ready(function(){
	product_comp_chart();
	service_comp_chart();
	products_ordered();
	products_received();
	services_ordered();
	services_received();
	
});
// Product compare
var product_comp_chart= function(){
	if ("undefined" != typeof AmCharts && 0 !== $("#product_comp_chart").size()) {
		
		AmCharts.makeChart("product_comp_chart", {
		type : "pie",
		theme : "light",
		fontFamily : "Open Sans",
		color : "#888",
		dataProvider :<?php echo json_encode($product_comp_chart); ?>,
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
 // Services compare
var service_comp_chart= function(){
	if ("undefined" != typeof AmCharts && 0 !== $("#service_comp_chart").size()) {
		
		AmCharts.makeChart("service_comp_chart", {
		type : "pie",
		theme : "light",
		fontFamily : "Open Sans",
		color : "#888",
		dataProvider :<?php echo json_encode($service_comp_chart); ?>,
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
 

// products_ordered
var products_ordered = function () {
if ("undefined" != typeof AmCharts && 0 !== $("#products_ordered").size()) {
	AmCharts.makeChart("products_ordered", {
		type : "serial",
		addClassNames : !0,
		theme : "light",
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
		dataProvider :<?php echo json_encode($products_ordered); ?>,
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
				title : "Products Ordered",
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
				title : "Total paid orders",
				valueField : "amount"
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

//products_received
var products_received = function () {
if ("undefined" != typeof AmCharts && 0 !== $("#products_received").size()) {
	AmCharts.makeChart("products_received", {
		type : "serial",
		addClassNames : !0,
		theme : "light",
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
		dataProvider :<?php echo json_encode($products_received); ?>,
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
				title : "Products  received ",
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
				title : "Total paid orders",
				valueField : "amount"
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
// services_ordered
var services_ordered = function () {
if ("undefined" != typeof AmCharts && 0 !== $("#services_ordered").size()) {
	AmCharts.makeChart("services_ordered", {
		type : "serial",
		addClassNames : !0,
		theme : "light",
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
		dataProvider :<?php echo json_encode($services_ordered); ?>,
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
				title : "services ordered",
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
				title : "Total paid orders",
				valueField : "amount"
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

// services_received
var services_received = function () {
if ("undefined" != typeof AmCharts && 0 !== $("#services_received").size()) {
	AmCharts.makeChart("services_received", {
		type : "serial",
		addClassNames : !0,
		theme : "light",
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
		dataProvider :<?php echo json_encode($services_received); ?>,
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
				title : "Number of Services Order ",
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
				title : "Total paid orders",
				valueField : "amount"
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
</script>
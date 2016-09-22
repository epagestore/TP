<?php 
ini_set('default_charset', 'utf-8');
/* Total orders 
Total paid orders 
No of orders receieved 
No of orders made 
Total received orders 
Total number of transactions  */
$customer_id= $this->session->userdata('customer_id');
$ci = &get_instance();


$total_sent_pending = $this->db->query('select count(*) as number,'.$dateForamte.' as date_added from `order` where order_status_id<5 and payer_id ="'.$customer_id.'" group by '.$dateForamte.' desc')->result_array();

$total_received_pending = $this->db->query('select count(*) as number,'.$dateForamte.' as date_added from `order` where order_status_id<5 and payee_id ="'.$customer_id.'" group by '.$dateForamte.' desc')->result_array();


//No of orders received 
$total_sent=$ci->db->query('select count(*) as number,'.$dateForamte.' as date_added from `order` where order_status_id<5 and payer_id ='.$customer_id)->row();
$total_received=$ci->db->query('select count(*) as number,'.$dateForamte.' as date_added from `order` where order_status_id<5 and payee_id ='.$customer_id)->row();

$region_total_order = $this->db->query('select ip,city,country,countryCode,late,lon,region,regionName,zip from `order` where payer_id ="'.$customer_id.'" or payee_id="'.$customer_id.'" group by regionName')->result_array();


$maparr=array();
	foreach($region_total_order as $rto)
	{
		if($rto['ip']!='')
		{
			$t=array();
			$t['latLng']=array($rto['late'],$rto['lon']);
			$total_order = $this->db->query('select * from `order` where regionName= "'.$rto['regionName'].'" and  payer_id ="'.$customer_id.'" or payee_id="'.$customer_id.'" group by regionName')->num_rows();
			$t['name']=$rto['regionName'].' Total Order : '.$total_order;
			$t['status']='pin';
			$maparr[]=$t;
		}
	}
//echo json_encode($maparr);exit;
$compare_chart=array();
$compare_chart[]=array("Order"=>"Number of send payments pending", "Number"=>$total_sent->number);
$compare_chart[]=array("Order"=>"Number of Received payments pending ", "Number"=>$total_received->number);

?>
			<!-- BEGIN PAGE HEAD -->
		
			<div class="page-head">
				<!-- BEGIN PAGE TITLE -->
				<div class="page-title">
					<h1>Orders  by region <small>statistics & reports</small> </h1>
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
								<h3 class="font-red-haze" data-value="<?php echo $total_sent->number+$total_received->number; ?>" data-counter="counterup"><?php echo ($total_sent->number+$total_received->number); ?></h3>
								<small>Total number of payements</small>
							</div>
							<div class="icon">
								<i class="icon-like"></i>
							</div>
						</div>
						<div class="progress-info">
							<div class="progress">
								<span style="width: 100%;" class="progress-bar progress-bar-success red-haze">
									<span class="sr-only">100%</span>
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
									<span data-value="<?php echo $total_sent->number; ?>" data-counter="counterup"><?php echo $total_sent->number; ?></span>
								</h3>
								<small>Total Sent Payment</small>
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
				<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
					<div class="dashboard-stat2">
						<div class="display">
							<div class="number">
								<h3 class="font-purple-soft" data-value="<?php echo $total_received->number; ?>" data-counter="counterup"><?php echo $total_received->number; ?></h3>
								<small>Total of Received Payment</small>
							</div>
							<div class="icon">
								<i class="icon-like"></i>
							</div>
						</div>
						<div class="progress-info">
							<div class="progress">
								<span style="width: 100%;" class="progress-bar progress-bar-success purple-soft">
									<span class="sr-only">100%</span>
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
				<div class="row collapse in" id="collapsible">
				
				<div class="portlet-title">
					<div class="caption">
						<span class="caption-subject bold uppercase font-dark">send payments pending</span>
						<span class="caption-helper"></span>
					</div>					   
				 </div>
				<div class="col-md-12 portlet-body portlet light bordered">
					
					<div  id="total_sent_pending" class="CSSAnimationChart"></div>
				</div>
				<div class="portlet-title">
					<div class="caption">
						<span class="caption-subject bold uppercase font-dark">received payments pending</span>
						<span class="caption-helper"></span>
					</div>					   
				 </div>
				<div class="col-md-12 portlet-body portlet light bordered">
					
					<div  id="total_received_pending" class="CSSAnimationChart"></div>
				</div>
				<div class="portlet-title">
					<div class="caption">
						<span class="caption-subject bold uppercase font-dark">Orders pending Compare Chart</span>
						<span class="caption-helper"></span>
					</div>					   
				 </div>
				<div class="col-md-12 portlet-body portlet light bordered">
					
					<div  id="comp_chart" class="CSSAnimationChart"></div>
				</div>
				<div class="col-md-12 portlet-body">
					<div class="portlet-title">
						<div class="caption">
							<span class="caption-subject bold uppercase font-dark">Order Region Map</span>
							<div class="caption-helper" ></d>
						</div>					   
					 </div>
				</div>
				<div class="col-md-12 portlet-body portlet light bordered " >
					<div  id="mapplic" class="widget-map-mapplic mapplic-element mapplic-dark"></div>
				</div>
				
			</div>
			</div>
			</div>
			
			
<!-- graph start --->
          
<!-- graph Ends -->	
  
<script>

	

$(document).ready(function(){
	comp_chart();
	total_sent_pending();
	total_received_pending();
	initWorldMapStats(); 
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
var total_sent_pending = function () {
if ("undefined" != typeof AmCharts && 0 !== $("#total_sent_pending").size()) {
	AmCharts.makeChart("total_sent_pending", {
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
		dataProvider :<?php echo json_encode($total_sent_pending); ?>,
		valueAxes : [{
				axisAlpha : 0,
				position : "left",
				title: "Number"
			}
		],
		startDuration : 1,
		graphs : [{
				alphaField : "alpha",
				balloonText : "<span style='font-size:12px;'>[[title]] in [[category]]:<br><span style='font-size:20px;'>[[value]]</span> [[additional]]</span>",
				fillAlphas : 1,
				title : "Number of send payments pending",
				type : "column",
				valueField : "number",
				dashLengthField : "dashLengthColumn"
			}
		],
		chartCursor : {	
			cursorColor:'#000000',
						
			zoomable : !0,
			
		},
		categoryField : "date_added",
		categoryAxis : {
			gridPosition : "start",
			axisAlpha : 0,
			tickLength : 0,
			title:"<?php echo $map_x; ?>",labelRotation:60
		},
		"export" : {
			enabled : !0
		}
	})
}
};

// order-graph
var total_received_pending = function () {
if ("undefined" != typeof AmCharts && 0 !== $("#total_received_pending").size()) {
	AmCharts.makeChart("total_received_pending", {
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
		dataProvider :<?php echo json_encode($total_received_pending); ?>,
		valueAxes : [{
				axisAlpha : 0,
				position : "left",
				title: "Number"
			}
		],
		startDuration : 1,
		graphs : [{
				alphaField : "alpha",
				balloonText : "<span style='font-size:12px;'>[[title]] in [[category]]:<br><span style='font-size:20px;'>[[value]]</span> [[additional]]</span>",
				fillAlphas : 1,
				title : "Number of requestpayments  pending ",
				type : "column",
				valueField : "number",
				dashLengthField : "dashLengthColumn"
			}
		],
		chartCursor : {	
			cursorColor:'#000000',
						
			zoomable : !0,
			
		},
		categoryField : "date_added",
		categoryAxis : {
			gridPosition : "start",
			axisAlpha : 0,
			tickLength : 0,
			title:"<?php echo $map_x; ?>",labelRotation:60
		},
		"export" : {
			enabled : !0
		}
	})
}
};



/* Total Orders Map  */
var initWorldMapStats= function () {
	
	
	var mmarker=<?php echo json_encode($maparr);?>;
	var mapm='';
	
	if(mmarker.length >1)
		mapm = mmarker;
	else
		mapm = [
      {latLng: [41.90, 12.45], name: 'Vatican City',status:'pin'},
      {latLng: [18.5333, 73.8667], name: '10 % orders rejected in india',status:'pin'},
      {latLng: [43.73, 7.41], name: 'Monaco',status:'pin'},
      {latLng: [-0.52, 166.93], name: 'Nauru',status:'pin'},
      {latLng: [-8.51, 179.21], name: 'Tuvalu',status:'pin'},
      {latLng: [43.93, 12.46], name: 'San Marino',status:'pin'},
      {latLng: [47.14, 9.52], name: 'Liechtenstein',status:'pin'},
      {latLng: [7.11, 171.06], name: 'Marshall Islands',status:'pin'},
      {latLng: [17.3, -62.73], name: 'Saint Kitts and Nevis',status:'pin'},
      {latLng: [3.2, 73.22], name: 'Maldives',status:'pin'},
      {latLng: [35.88, 14.5], name: 'Malta',status:'pin'},
      {latLng: [12.05, -61.75], name: 'Grenada',status:'pin'},
      {latLng: [13.16, -61.23], name: 'Saint Vincent and the Grenadines',status:'pin'},
      {latLng: [13.16, -59.55], name: 'Barbados',status:'pin'},
      {latLng: [17.11, -61.85], name: 'Antigua and Barbuda',status:'pin'},
      {latLng: [-4.61, 55.45], name: 'Seychelles',status:'pin'},
      {latLng: [7.35, 134.46], name: 'Palau',status:'pin'},
      {latLng: [42.5, 1.51], name: 'Andorra',status:'pin'},
      {latLng: [14.01, -60.98], name: 'Saint Lucia',status:'pin'},
      {latLng: [6.91, 158.18], name: 'Federated States of Micronesia',status:'pin'},
      {latLng: [1.3, 103.8], name: 'Singapore',status:'pin'},
      {latLng: [1.46, 173.03], name: 'Kiribati',status:'pin'},
      {latLng: [-21.13, -175.2], name: 'Tonga',status:'pin'},
      {latLng: [15.3, -61.38], name: 'Dominica',status:'pin'},
      {latLng: [-20.2, 57.5], name: 'Mauritius',status:'pin'},
      {latLng: [26.02, 50.55], name: 'Bahrain',status:'pin'},
      {latLng: [0.33, 6.73], name: 'São Tomé and Príncipe',status:'pin'}
    ];
		if ("undefined" != typeof AmCharts &&	0 !== $("#mapplic").size()){
			$('#mapplic').css({"width":"100%","height":"450px"});
				$('#mapplic').vectorMap({
					map: 'world_mill_en',
					backgroundColor: '#67B7DC',
					color: '#ffffff',
					hoverOpacity: 1,
					selectedColor: '#000',
					enableZoom: true,
					showTooltip: true,
					values: sample_data,
					scaleColors: ['#C8EEFF', '#006491'],
					normalizeFunction: 'polynomial',
					markerStyle: {
					  initial: {
						fill: '#F8E23B',
						stroke: '#383f47'
					  }
					},
					 markers: mapm,
					 
					 series: {
					  markers: [{
						attribute: 'image',
						scale: {
						  'pin': '<?php echo base_url()?>/css/graph/pin-orange.png'
						},
						values: mapm.reduce(function(p, c, i){ p[i] = c.status; return p }, {}),
						legend: {
						  horizontal: true,
						  title: 'Region',
						  labelRender: function(v){
							return {  pin: '' }[v];
						  }
						}
					  }]
					}
			  });
			  
					
			};
};



</script>
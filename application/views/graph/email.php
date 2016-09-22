<?php $ci = &get_instance();?>

<?php

$customer_id=$this->session->userdata('customer_id');


	//Email Money 
	$emailsent=$this->db->query("select  count(*)as number,DATE_FORMAT(date_added, '%m-%Y') as date_added from send_money_transaction where send_to='email' and customer_id = '".$customer_id."' group by MONTH(date_added)  ")->result_array();

	$emailreceived=$this->db->query("select  count(*)as number,DATE_FORMAT(date_added, '%m-%Y') as date_added from request_money_transaction where request_to='email' and customer_id = '".$customer_id."' group by  MONTH(date_added)   ")->result_array();
//compare Send Vs Receive Monies
$send_money=$ci->db->query('select count(*)as number  from `send_money_transaction` where  customer_id = "'.$customer_id.'"')->row();
$received_money=$ci->db->query('select count(*)as number  from `request_money_transaction` where  customer_id = "'.$customer_id.'"')->row();
$compare_chart=array();
$compare_chart[]=array("Order"=>"Send Monies", "Number"=>$send_money->number);
$compare_chart[]=array("Order"=>"Receive Monies", "Number"=>$received_money->number);
?>

			<!-- BEGIN PAGE HEAD -->
			<div class="page-head">
				<!-- BEGIN PAGE TITLE -->
				<div class="page-title">
					<h1>Send/Receive Money By Email<small>statistics & reports</small></h1>
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
								<h3 class="font-green-sharp" data-value="<?php echo count($emailsent); ?>" data-counter="counterup"><?php echo $emailsent; ?><small class="font-green-sharp">$</small></h3>
								<small>EMAIL Send Money</small>
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
								<h3 class="font-red-haze"  data-value="<?php echo count($emailreceived); ?>" data-counter="counterup"><?php echo $emailreceived; ?></h3>
								<small>EMAIL Receive Money</small>
							</div>
							<div class="icon">
								<i class="icon-like"></i>
							</div>
						</div>
						<div class="progress-info">
							<div class="progress">
								<span style="width: 100%;" class="progress-bar progress-bar-success red-haze">
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
				<div class="row collapse in" id="collapsible">
				<div class="col-md-12 portlet-body">
					<div class="portlet-title">
						<div class="caption">
							<span class="caption-subject bold uppercase font-dark">Monies Send </span>
							<span class="caption-helper"></span>
						</div>					   
					 </div>
					
				</div>
				<div class="col-md-12 portlet-body portlet light bordered">
					<div  id="emailsent" class="CSSAnimationChart"></div>
				</div>
				
				<div class="col-md-12 portlet-body">
					<div class="portlet-title">
						<div class="caption">
							<span class="caption-subject bold uppercase font-dark">Monies receieved </span>
							<span class="caption-helper"></span>
						</div>					   
					 </div>
				</div>
				<div class="col-md-12 portlet-body portlet light bordered">
					<div  id="emailreceived" class="CSSAnimationChart"></div>
				</div>
				
				<div class="col-md-12 portlet-body">
					<div class="portlet-title">
						<div class="caption">
							<span class="caption-subject bold uppercase font-dark">Email Send Monies Vs Email Receive Monies</span>
							<span class="caption-helper"></span>
						</div>					   
					 </div>
				</div>
				<div class="col-md-12 portlet-body portlet light bordered">
					<div  id="comp_chart" class="CSSAnimationChart"></div>
				</div>
				<div class="col-md-12 portlet-body">
					<div class="portlet-title">
						<div class="caption">
							<span class="caption-subject bold uppercase font-dark">Map </span>
							<span class="caption-helper"></span>
						</div>					   
					 </div>
				</div>
				<div class="col-md-12 portlet-body portlet light bordered">
					<div  id="mapplic" class="portlet light portlet-fit bordered"></div>
				</div>
			</div>
			</div>
			
			
<!-- graph start --->
          
<!-- graph Ends -->	
			
<script>
$(document).ready(function(){
	initWorldMapStats(); 
	comp_chart();
	emailsent();
	emailreceived();
	/* initAmChart2();
	initAmChart3(); */
});

var initWorldMapStats= function () {
	// demi data------------
	var mapm =[
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
            return {
              pin: ''
            }[v];
          }
        }
      }]
    }
  });
  
		
};
};
var emailsent = function () {
if ("undefined" != typeof AmCharts && 0 !== $("#emailsent").size()) {
	AmCharts.makeChart("emailsent", {
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
		dataProvider :<?php echo json_encode($emailsent); ?>,
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
				title : "No of Monies Send",
				type : "column",
				valueField : "number",
				dashLengthField : "dashLengthColumn"
			} , 
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
var emailreceived = function () {
if ("undefined" != typeof AmCharts && 0 !== $("#emailreceived").size()) {
	AmCharts.makeChart("emailreceived", {
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
		dataProvider :<?php echo json_encode($emailreceived); ?>,
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
			} , 
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
		color : "#666",
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
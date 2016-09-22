<?php error_reporting(0); 
	if(isset($_GET['ft'])&&($_GET['ft']))
	{
		$this->session->set_userdata("ft",$_GET['ft']);
	}else{
		if(!$this->session->userdata("ft"))
		{
			$this->session->set_userdata("ft",'m');
		}	
	}

	if($this->session->userdata("ft")=="d")
	{
		$dateForamte=' DATE_FORMAT(date_added, "%Y-%b-%D") '	;
		$map_x="Days";
	}	
	elseif($this->session->userdata("ft")=="m")
	{
		
		$dateForamte=' DATE_FORMAT(date_added, "%Y-%b") '	;
		$map_x="Month(s)";
		
	}elseif($this->session->userdata("ft")=="y"){
		$dateForamte=' DATE_FORMAT(date_added, "%Y") '	;
		$map_x="Year(s)";
	}
?>
<section class="container  page-container-bg-solid page-content-white " style="background-color:#eef1f5;">
<div class="page-container">
<!-- BEGIN CONTAINER -->
	<div class="page-content-wrapper">
		<div class="page-content">
		<div class="btn-group pull-right">
			<div class="btn  btn-success" onclick="javscript:window.location.href='<?php echo base_url()."dashboard?chart=".(isset($_GET['chart'])?$_GET['chart']:'')."&ft=d"?>'">Day</div>
				<div class="btn   btn-info" onclick="javscript:window.location.href='<?php echo base_url()."dashboard?chart=".(isset($_GET['chart'])?$_GET['chart']:'')."&ft=m"?>'">Month</div>
				<div class="btn  btn-danger" onclick="javscript:window.location.href='<?php echo base_url()."dashboard?chart=".(isset($_GET['chart'])?$_GET['chart']:'')."&ft=y"?>'">Year</div>
			<div class="dropdown pull-right">
			  <div class="btn btn-primary dropdown-toggle" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
			   <?php if(isset($_GET['chart']) && $_GET['chart']){ echo strtoupper(str_replace("_"," ",$_GET['chart']));} else echo "ORDER"; ?>
				<span class="caret"></span>
			  </div>
			  <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
				<li><a <?php if(isset($_GET['chart']) &&  ($_GET['chart']=='order' || $_GET['chart']=='')){ echo "selected";} ?> href="<?php echo site_url("dashboard"); ?>?chart=order">Orders</a></li>
				<li role="separator" class="divider"></li>
				<li><a href="<?php echo site_url("dashboard"); ?>?chart=orders_region">Orders  by region</a></li>
				<li role="separator" class="divider"></li>
				<li><a href="<?php echo site_url("dashboard"); ?>?chart=dispatch">Dispatch </a></li>
				<li role="separator" class="divider"></li>
				<li><a href="<?php echo site_url("dashboard"); ?>?chart=email">Email Money </a></li>
				<li role="separator" class="divider"></li>
				<li><a href="<?php echo site_url("dashboard"); ?>?chart=dispute">Dispute</a></li>
				<li role="separator" class="divider"></li>
				<li><a href="<?php echo site_url("dashboard"); ?>?chart=product_service">Products & Services</a></li>
				<li role="separator" class="divider"></li>
				<li><a href="<?php echo site_url("dashboard"); ?>?chart=invoice">Invoice</a></li>
				<li role="separator" class="divider"></li>
				<li><a href="<?php echo site_url("dashboard"); ?>?chart=commission">Commission</a></li>
			  </ul>
			  </div>
		</div>
		
		

<!--<script type="text/javascript" src="//code.jquery.com/ui/1.10.3/jquery-ui.js"></script>-->

<link href="<?php echo base_url(); ?>css/graph/plugins.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url(); ?>css/graph/layout.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url(); ?>css/graph/components.css" rel="stylesheet" id="style_components" type="text/css">
<script src="<?php echo base_url(); ?>css/graph/app.js"></script>
<script src="<?php echo base_url(); ?>css/graph/hammer.min.js"></script>

<link href="<?php echo base_url(); ?>css/graph/jqvmap/jqvmap.css" media="screen" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url(); ?>css/graph/jqvmap/jquery.vmap.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>css/graph/jqvmap/maps/jquery.vmap.world.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>css/graph/jqvmap/data/jquery.vmap.sampledata.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>css/graph/jqvmap/jquery-jvectormap-world-mill-en.js" type="text/javascript"></script>

<script src="<?php echo base_url(); ?>css/graph/amcharts.js"></script>
<script src="<?php echo base_url(); ?>css/graph/pie.js"></script>

<link href="<?php echo base_url(); ?>css/graph/flickity.css" rel="stylesheet" >
<link href="<?php echo base_url(); ?>css/graph/animate.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>css/graph/queries.css" rel="stylesheet">
<script src="<?php echo base_url(); ?>css/graph/morris.js"></script>
<script src="<?php echo base_url(); ?>css/graph/serial.js"></script>
<script src="<?php echo base_url(); ?>css/graph/jquery.fancybox.pack.js"></script>
<script src="<?php echo base_url(); ?>css/graph/jquery.fitvids.js"></script>
<script src="<?php echo base_url(); ?>css/graph/jquery.fitvids.js"></script>
<script src="<?php echo base_url(); ?>css/graph/dashboard.min.js"></script>
<script src="<?php echo base_url(); ?>css/graph/jquery_016.js"></script>
<script src="<?php echo base_url(); ?>css/graph/light.js"></script>


<style>
.note-text{
 display: block; /* Fallback for non-webkit */
  display: -webkit-box;
  max-width: 200px;
  height: 100px /* Fallback for non-webkit */
  margin: 0 auto;
  font-size: 14px;
  line-height:16px;
  -webkit-line-clamp:2;
  -webkit-box-orient: vertical;
  overflow: hidden;
  text-overflow: ellipsis;
}
.page-content-wrapper .page-content {
    margin-left:0px !important;}
.page-container {
    margin: 0;
    padding:0px !important;}
.page-content-wrapper .page-content {padding:0px !important;}



.Dispatcher,.Dispatcher:hover{
    border-color: transparent;
    color: #fff!important;
    background: #f5821f!important;
}
.glyphicon-bell 
{
    font-size:1.5rem;
}
.dropdown-menu .divider {
    /* background-color: transparent; */
    height: 1px;
    margin: 9px 0;
overflow: hidden;}

.notifications {
   min-width:420px !important; 
  }
  
  .notifications-wrapper {
     overflow:auto;
      max-height:250px;
    }
.glyphicon-circle-arrow-right {
      margin-left:10px;     
   }
  /* .notification-heading{
	   background:#0082C8;
  } */
        
.dropdown-menu.divider {
  margin:5px 0;          
  }

#content_2 .item-info{
	font-size:12px;
	
}
    
.notification-item {
 padding:10px;
 margin:5px;

}
.notification-footer
{
 border-radius:4px;
 }
 .fa {
  font-family: 'FontAwesome';
  font-style: normal;
}
 .curr_bal_amt
 {
	font-family: Agency FB;
	src: url('../layout-1/fonts/Agency_FB.ttf');
	font-size:28px;
 }
</style>
<?php 
if(!isset($_GET['chart']) || $_GET['chart']=='order')
include("order.php");
else if($_GET['chart']=='dispatch')
include("dispatch.php");
else if($_GET['chart']=='orders_region')
include("orders_region.php");
else if($_GET['chart']=='email')
include("email.php");
else if($_GET['chart']=='dispute')
include("dispute.php");
else if($_GET['chart']=='product_service')
include("product_service.php");
else if($_GET['chart']=='invoice')
include("invoice.php");
else if($_GET['chart']=='commission')
include("commission.php");
else{
	include("order.php");
}	
?>
<script>
$('.btn-toggle').click(function() {
	$('.btn-toggle .btn').addClass("hidden");
	$('.btn-toggle .btn.active').removeClass("hidden");
	
    $(this).find('.btn').toggleClass('active');  
    
    /* if ($(this).find('.btn-primary').size()>0) {
    	$(this).find('.btn').toggleClass('btn-primary');
    }
    if ($(this).find('.btn-danger').size()>0) {
    	$(this).find('.btn').toggleClass('btn-danger');
    }
    if ($(this).find('.btn-success').size()>0) {
    	$(this).find('.btn').toggleClass('btn-success');
    }
    if ($(this).find('.btn-info').size()>0) {
    	$(this).find('.btn').toggleClass('btn-info');
    }
    
    $(this).find('.btn').toggleClass('btn-default');	 */
});
$(document).ready(function(){
	$('.btn-toggle').click();
	$("#collapsible").removeClass('in');
	$("#collapsible").css({"width":"100%"});
});
</script>
</div>
		
	</div>
	
	</div>
	<!-- END CONTENT -->
</section>
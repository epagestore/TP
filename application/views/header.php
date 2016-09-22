<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Trusted Payer NEW</title>

    <!-- Bootstrap -->
    <link href="<?php echo base_url();?>layout-1/css/bootstrap.min.css" rel="stylesheet">
	<link href="<?php echo base_url();?>css/font-awesome.min.css" rel="stylesheet">
	<link href="<?php echo base_url();?>layout-1/css/style.css" rel="stylesheet">
	
	
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<meta name="author" content="Iyke" />
		<!-- Bootstrap -->
		<script src="<?php echo base_url();?>layout-1/js/modernizr.custom.js"></script>
		<link href="<?php echo base_url();?>css/ladda.min.css" rel="stylesheet" >
		<link href="<?php echo base_url();?>layout-1/css/jquery.fancybox.css" rel="stylesheet">
		<link href="<?php echo base_url();?>layout-1/css/flickity.css" rel="stylesheet" >
		<link href="<?php echo base_url();?>layout-1/css/animate.css" rel="stylesheet">
		<link href="<?php echo base_url();?>css/font-awesome.min.css" rel="stylesheet">
		<!--<link href="<?php echo base_url();?>layout-1/css/styles.css" rel="stylesheet">-->
		<link href="<?php echo base_url();?>layout-1/css/queries.css" rel="stylesheet">
	
		<link href="<?php echo base_url();?>stylesheets/flags16.css" rel="stylesheet">
		<link rel="stylesheet" href="<?php echo base_url();?>layout-1/css/bootstrap-select.css">
		<link rel="stylesheet" href="<?php echo base_url();?>layout-1/css/bootstrap-select.min.css">
		<!-- Facebook and Twitter integration -->
		<meta property="og:title" content=""/>
		<meta property="og:image" content=""/>
		<meta property="og:url" content=""/>
		<meta property="og:site_name" content=""/>
		<meta property="og:description" content=""/>
		<meta name="twitter:title" content="" />
		<meta name="twitter:image" content="" />
		<meta name="twitter:url" content="" />
		<meta name="twitter:card" content="" />
	
		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
		<script src="<?php echo base_url();?>layout-1/js/jquery.min.js"></script>
		<!-- Include all compiled plugins (below), or include individual files as needed -->
		<script src="<?php echo base_url();?>layout-1/js/bootstrap.min.js"></script>
			<script type="text/javascript" src="<?php echo base_url();?>layout-1/js/bootstrap-select.min.js"></script>
		<script src="<?php echo base_url();?>layout-1/js/min/toucheffects-min.js"></script>
		<script src="<?php echo base_url();?>css/skdslider.min.js"></script>
		<link href="<?php echo base_url();?>css/skdslider.css" rel="stylesheet" />
		<script src="<?php echo base_url();?>js/jquery.validate.js"></script>
		<script type="text/javascript" src="<?php echo base_url();?>js/jquery.popup.js"></script>
		<script type="text/javascript" src="<?php echo base_url();?>js/jquery.reveal.js"></script>
		<link rel="stylesheet" href="<?php echo base_url();?>css/jquery.popup.css" type="text/css">
		<script src="<?php echo base_url();?>layout-1/js/flickity.pkgd.min.js"></script>
		<script src="<?php echo base_url();?>layout-1/js/jquery.fancybox.pack.js"></script>
		<!-- Include all compiled plugins (below), or include individual files as needed -->
		<script src="<?php echo base_url();?>layout-1/js/retina.js"></script>
		<script src="<?php echo base_url();?>layout-1/js/waypoints.min.js"></script>
		<link rel="stylesheet" href="<?php echo base_url();?>new-css/jquery.bxslider.css">
		<script src="<?php echo base_url();?>layout-1/js/min/scripts-min.js"></script>
		<script src="<?php echo base_url();?>js/jquery.price_format.2.0.min.js"></script>
		<script src="<?php echo base_url();?>js/autoNumeric-min.js"></script>
		<script src="<?php echo base_url();?>js/jquery.plugin.min.js"></script>
		<script src="<?php echo base_url();?>js/jquery.countdown.min.js"></script>
		
		<script type="text/javascript">
			jQuery(document).ready(function(){
				jQuery('#demo').skdslider({'delay':5000, 'fadeSpeed': 2000,'showNextPrev':true,'showPlayButton':true,'autoStart':true});
				jQuery('#demo1').skdslider({'delay':5000, 'fadeSpeed': 2000,'autoStart':true,'pauseOnHover':true});
				$(".js__p_start, .js__p_another_start").simplePopup();
			});
			
		</script>

</head>

<body>
<?php if($this->session->flashdata('success')){ ?>
<div class="alert alert-success alert-dismissible alert-box" role="alert" style="position:absolute;top:0px;z-index:111;width:100%;">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <strong><?php echo $this->session->flashdata('success') ?></strong>
</div>
<?php } ?>
<?php if($this->session->flashdata('errormsg')){ ?>
<div class="alert alert-danger alert-dismissible alert-box" role="alert" style="position:absolute;top:0px;z-index:111;width:100%;">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <strong><?php echo $this->session->flashdata('errormsg') ?></strong>
</div>
<?php } ?>
<nav class="navbar navbar-default custom-nav  hidden-xs   ">
  <div class="container">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header col-sm-2">
		<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</button>
      <a class="navbar-brand" href="<?php echo base_url(); ?>"><img src="<?php echo base_url(); ?>layout-1/img/logo.png" class="img-resposive "></a>
    </div>
	
    <!-- Collect the nav links, forms, and other content for toggling -->
    <?php 
	$tp_menu=$this->config->item("tp_menu");
	$uSt='';
	if($this->uri->segment(1))
	{
		$uSt.=$this->uri->segment(1);
	}	
	if($this->uri->segment(2))
	{
		$uSt.="/".$this->uri->segment(2);
	}
	
	$main_menu=array("dashboard"=>"MyAccount","order/order_list"=>"PaymentsMade","order/recived_order_list"=>"PaymentsReceived","send_money"=>"QuickSettler","notification"=>"","despute"=>"");
	 if($cust_detail[0]['dispatcher_location']!='null' && $cust_detail[0]['dispatcher_location']){		
	$main_menu['dispatcher']='Dispatcher';
	 }
	 
	$page_name='';
	$page_key='';
	foreach($tp_menu as $im)
	{
		if($im[0]==$uSt)
		{
			 $page_name=$im[0];
			 $page_key=$im[1];
			 break;
		}
	}
	?>
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
		<?php foreach($main_menu as $key=>$im)
		{
			if(in_array($key,array("notification","despute")))
			continue;
		?> 
		<?php if($page_name){?>	
	   <li class="<?php echo ($page_key==$key)?"active":''; ?>">
			<?php if($im=='Dispatcher'){?>
				<a class="<?php echo $im; ?>" href="<?php  echo $page_key!=$key?site_url($key).'?m=0':site_url($key).'?m=0';?>">
					<?php echo $im; ?>
				</a>
			<?php }else{?>
				<a class="<?php echo $im; ?>" href="<?php  echo $page_key!=$key?site_url($key):site_url($key);?>">
					<?php echo $im; ?>
				</a>
			<?php }?>
		</li>
		<?php }else{?>
		 <li><a class="<?php echo $im; ?>" href="<?php echo site_url($key);?>"><?php echo $im; ?></a></li>
		<?php } } ?>
        
      </ul>
      <?php $query = $_SERVER['QUERY_STRING'] ? '?'.$_SERVER['QUERY_STRING'] : '';  ?> 
      <ul class="nav navbar-nav navbar-right">
        
        <li class="dropdown ">
          <a href="#" class="f16 dropdown-toggle border-box" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
			<?php if(!$this->session->userdata('currency_id')){ ?>
			  <img src="<?php echo base_url(); ?>layout-1/img/flag-1.png" width="20px"> 
			  $USD
			  <span class="caret large-caret text-orange" style="font-size:20px;"></span>
			<?php }else{?>
				<?php 	foreach ($this->session->userdata('currencies') as $currency){ 
				if($this->session->userdata('currency_id') == $currency['currency_id']) {?>
			  <div class="flag <?php echo strtolower($currency['code']);?> pull-left" style="height:16px;width:16px;margin: 3px 4px 0px 0px;"></div>
			  <?php echo $currency['code'];?>
			  <span class="caret large-caret text-orange" style="font-size:20px;"></span>
				<?php } } }?>
		  </a>
          <ul class="dropdown-menu" >
		  <?php	foreach ($this->session->userdata('currencies') as $currency){ 
					if($this->session->userdata('currency_id') == $currency['currency_id']) {	
							if($currency['status'] == '1'){ ?>                              
								 
						<?php }
					} 
					else 
					{ 
						if($currency['status'] == '1'){ ?>          
						<?php	if($this->session->userdata('currency_id') != $currency['currency_id']) {?>
								 <li ><a href="<?php echo base_url();?>index.php/dashboard/setCurrency/<?php echo $currency['currency_id'];?>?redirect=<?php echo urlencode($this->uri->uri_string().$query); ?>">

							<?php echo $currency['currency_symbol']; ?>  <?php echo $currency['code']; ?></a></li>
						
						<?php }} }?>	
				<?php } ?>
          </ul>
        </li>
		<li  class="dropdown"><a class="msg" href="#" id="dLabel" role="button" data-toggle="dropdown" data-target="#"><i style="font-size:36px;"class="fa fa-envelope text-orange "></i> </a><span class="round img-circle text-center" id="total_count">0</span>
			  <ul class="dropdown-menu notifications col-md-4" role="menu" aria-labelledby="dLabel"><span class="top-caret"></span>
				<div class="notification-heading"><h4 class="menu-title" id="base_total" >Notifications</h4><a href="<?php echo base_url();?>index.php/notification"></a>
				</div>
				<li class="divider col-md-12" ></li>
			   <div class="notifications-wrapper col-md-12"  style="" id="content_2">
			   </div>
			   <li class="divider col-md-12" ></li>
				<div class="notification-footer">
					<a href="<?php echo base_url();?>index.php/notification"><h4 class="menu-title">View all<i class="glyphicon glyphicon-circle-arrow-right"></i></h4></a>
					<a href="#"><h4 class="menu-title pull-right" id="clear-all-notif">Clear All</h4></a>
				</div>
			  </ul>
			  
			
		
		
		</li>
		<!--Kinnari!-->
		
		<li class="profile-img dropdown"  ><a data-toggle="dropdown"  class="dropdown-toggle" href="#" aria-expanded="true" >
		  <img data-toggle="tooltip" title="Welcome, <?php echo isset($cust_detail[0]) ? $cust_detail[0]['first_name'].' ':''; echo isset($cust_detail[0]) ? $cust_detail[0]['last_name'] : ''; ?>" data-placement="top" class="img-circle img-resposive" src="<?php echo isset($cust_detail[0]['photo']) && @getimagesize(base_url().$cust_detail[0]['photo']) ?base_url().$cust_detail[0]['photo']:base_url().'img/Team/user_placeholder.png'; ?>"></a>
		  <ul class="dropdown-menu text-center">
              <!-- User image -->
              <li class="user-header">
				<img alt="User Image" class="img-circle img-resposive" src="<?php echo isset($cust_detail[0]['photo']) && @getimagesize(base_url().$cust_detail[0]['photo']) ? base_url().$cust_detail[0]['photo']:base_url().'img/Team/user_placeholder.png'; ?>" height="80" width="80" />
				<p class="text-white">
                  <?php echo isset($cust_detail[0]) ? $cust_detail[0]['first_name']:''; echo isset($cust_detail[0]) ? $cust_detail[0]['last_name'] : ''; ?><br>
                  <small><?php $mydate =  isset($cust_detail[0]) ? $cust_detail[0]['date_added'] : '';  $month = date("M",strtotime($mydate)); $year = date("Y",strtotime($mydate)); ?>Member since <?php echo $month.".".$year; ?></small>
                </p>
              </li>
             <li class="user-footer">
                <div class="pull-left bottom-margin">
                  <a class="btn btn-Primary" href="<?php echo base_url(); ?>profile">Profile</a>
                </div>
                <div class="pull-right bottom-margin">
                  <a class="btn btn-Primary" href="<?php echo base_url(); ?>index.php/sign_out">Sign out</a>
                </div>
				<a class="btn btn-warning btn-block btn-link" href="<?php echo base_url();?>balance_manager#withdraw">Withdraw Amount</a>
              </li>
            </ul>
		</li> 
		<!--Kinnari!-->
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
  <nav class="navbar navbar-default mobile-nav visible-xs ">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header row">
	
	<div class="mobile-right col-xs-12 col-sm-12">
	  <a class="navbar-brand mob-brand" href="<?php echo site_url("dashboard"); ?>"><img src="<?php echo base_url(); ?>layout-1/img/logo.png" class="brand-img"></a>
	<ul class="nav   mn  text-right">
        
        <li class="dropdown mnl">
          <a href="#" class=" f16 dropdown-toggle border-box  demo111" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
			<?php if(!$this->session->userdata('currency_id')){ ?>
			  <img src="<?php echo base_url(); ?>layout-1/img/flag-1.png" width="20px"> 
			  $USD
			  <span class="caret large-caret text-orange" style="font-size:20px;"></span>
			<?php }else{?>
				<?php 	foreach ($this->session->userdata('currencies') as $currency){ 
				if($this->session->userdata('currency_id') == $currency['currency_id']) {?>
			  <div class="flag <?php echo strtolower($currency['code']);?> pull-left" style="height:16px;width:16px;margin: 3px 4px 0px 0px;"></div>
			  <?php echo $currency['code'];?>
			  <span class="caret large-caret text-orange" style="font-size:20px;"></span>
				<?php } } }?>
		  </a>
          <ul class="dropdown-menu " >
		  <?php	foreach ($this->session->userdata('currencies') as $currency){ 
					if($this->session->userdata('currency_id') == $currency['currency_id']) {	
							if($currency['status'] == '1'){ ?>                              
								 
						<?php }
					} 
					else 
					{ 
						if($currency['status'] == '1'){ ?>          
						<?php	if($this->session->userdata('currency_id') != $currency['currency_id']) {?>
								 <li ><a href="<?php echo base_url();?>index.php/dashboard/setCurrency/<?php echo $currency['currency_id'];?>?redirect=<?php echo urlencode($this->uri->uri_string().$query); ?>">

							<?php  echo $currency['currency_symbol']; ?>  <?php echo $currency['code']; ?></a></li>
						
						<?php }} }?>	
				<?php } ?>
          </ul>
        </li>
		<li  class="demoo dropdown mnl"><a class="msg" href="#" id="dLabel" role="button" data-toggle="dropdown" data-target="#"><i class="fa fa-envelope text-orange "></i> </a><span class="mround img-circle text-center" id="total_count">0</span>
			  <ul class="dropdown-menu dpmenu1" role="menu" aria-labelledby="dLabel"><span class="top-caret"></span>
				<div class="notification-heading"><h4 class="menu-title pull-left">Notifications</h4><a href="<?php echo base_url();?>index.php/notification"></a>
				</div>
				<li class="divider col-md-12" ></li>
			   <div class="notifications-wrapper col-md-12"  style="" id="content_2">
			   </div>
			   <li class="divider col-md-12" ></li>
				<div class="notification-footer">
					<a href="<?php echo base_url();?>notification"><h4 class="menu-title">View all<i class="glyphicon glyphicon-circle-arrow-right"></i></h4></a>
					<a href="#"><h4 class="menu-title pull-right" id="clear-all-notif">Clear All</h4></a>
				</div>
			  </ul>
			  
			
		
		
		</li>
		<!--Kinnari!-->
		
		<li class="profile-img dropdown mnl"><a data-toggle="dropdown"  class="dropdown-toggle" href="#" aria-expanded="true">
		  <img class="img-circle img-resposive" src="<?php echo base_url(); echo isset($cust_detail[0]) ? $cust_detail[0]['photo']:''; ?>" width="30"></a>
		  <ul class="dropdown-menu dpmenu2 text-center">
              <!-- User image -->
              <li class="user-header">
				<img alt="User Image" class="img-circle img-resposive" src="<?php echo base_url();if(isset($cust_detail[0]['photo'])){ echo  $cust_detail[0]['photo'] ;} ?>" height="80" width="80" />
				
				<p class="text-white">
                  <?php echo isset($cust_detail[0]) ? $cust_detail[0]['first_name']:''; echo isset($cust_detail[0]) ? $cust_detail[0]['last_name'] : ''; ?><br>
                  <small><?php $mydate =  isset($cust_detail[0]) ? $cust_detail[0]['date_added'] : '';  $month = date("M",strtotime($mydate)); $year = date("Y",strtotime($mydate)); ?>Member since <?php echo $month.".".$year; ?></small>
                </p>
              </li>
             <li class="user-footer">
                <div class="pull-left bottom-margin">
                  <a class="btn btn-Primary" href="<?php echo base_url(); ?>index.php/profile">Profile</a>
                </div>
                <div class="pull-right bottom-margin">
                  <a class="btn btn-Primary" href="<?php echo base_url(); ?>index.php/sign_out">Sign out</a>
                </div>
              </li>
            </ul>
		</li> 
		<!--Kinnari!-->
      </ul>
	</div>
	<div class="col-xs-12">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-2" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
    
    </div>
	</div>
	<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-2">
      <ul class="nav navbar-nav  navbar-nav-mob">
       <?php foreach($main_menu as $key=>$im)
		{
			if(in_array($key,array("notification","despute")))
			continue;
		?> 
		<?php if($page_name){?>	
	   <li class="<?php echo ($page_key==$key)?"active":''; ?>"><a class="<?php echo $im; ?>" href="<?php echo $page_key!=$key?site_url($key):site_url($key);?>"><?php echo $im; ?></a></li>
		<?php }else{?>
		 <li><a class="<?php echo $im; ?>" href="<?php echo site_url($key);?>"><?php echo $im; ?></a></li>
		<?php } } ?>
      </ul>
    </div>
    <!-- Collect the nav links, forms, and other content for toggling -->
  <!-- /.navbar-collapse -->
 </div><!-- /.container-fluid -->
 </nav>
<!--<nav class="navbar navbar-default mobile-nav visible-xs visible-xs">
	<div class="container">
		<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-2" aria-expanded="false">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
			<a class="navbar-brand mob-brand" href="#"><img src="<?php echo base_url(); ?>layout-1/img/logo.png" class="brand-img"></a>
		</div>
		<div class="top-mobile text-right">
		<ul class="nav navbar-nav navbar-right">
		<li class="dropdown"><a href="#" class="f16 dropdown-toggle border-box" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
			<?php if(!$this->session->userdata('currency_id')){ ?>
			  <img src="<?php echo base_url(); ?>layout-1/img/flag-1.png" width="20px"> 
			  $USD
			  <span class="caret large-caret text-orange" style="font-size:20px;"></span>
			<?php }else{?>
				<?php 	foreach ($this->session->userdata('currencies') as $currency){ 
				if($this->session->userdata('currency_id') == $currency['currency_id']) {?>
			  <div class="flag <?php echo strtolower($currency['code']);?> pull-left" style="height:16px;width:16px;margin: 3px 4px 0px 0px;"></div>
			  <?php echo $currency['currency_symbol'].$currency['code'];?>
			  <span class="caret large-caret text-orange" style="font-size:20px;"></span>
				<?php } } }?>
		  </a>
		  <ul class="dropdown-menu" >
		  <?php	foreach ($this->session->userdata('currencies') as $currency){ 
					if($this->session->userdata('currency_id') == $currency['currency_id']) {	
							if($currency['status'] == '1'){ ?>                              
								 
						<?php }
					} 
					else 
					{ 
						if($currency['status'] == '1'){ ?>          
						<?php	if($this->session->userdata('currency_id') != $currency['currency_id']) {?>
								 <li ><a href="<?php echo base_url();?>index.php/dashboard/setCurrency/<?php echo $currency['currency_id'];?>?redirect=<?php echo urlencode($this->uri->uri_string().$query); ?>">

							<?php //echo $currency['currency_symbol']; ?>  <?php echo $currency['code']; ?></a></li>
						
						<?php }} }?>	
				<?php } ?>
          </ul>
		  
		  </li>
		<li class="profile-img dropdown"><a class="wel-text" href="#" id="dLabel" role="button" data-toggle="dropdown" data-target="#"><i class="fa fa-bell text-orange "></i> <span class="round img-circle text-center" id="total_count">0</span> </a>
		<ul class="dropdown-menu  " role="menu" aria-labelledby="dLabel"><span class="top-caret"></span>
				<div class="notification-heading"><h4 class="menu-title pull-left">Notifications</h4><a href="<?php echo base_url();?>index.php/notification"></a>
				</div>
				<li class="divider col-md-12" ></li>
			   <div class="notifications-wrapper col-md-12"  style="" id="content_2">
			   </div>
			   <li class="divider col-md-12" ></li>
				<div class="notification-footer"><a href="<?php echo base_url();?>notification"><h4 class="menu-title">View all<i class="glyphicon glyphicon-circle-arrow-right"></i></h4></a><a href="#"><h4 class="menu-title pull-right" id="clear-all-notif">Clear All</h4></a></div>
			  </ul>
		</li>
		<li class="dropdown">
		<a data-toggle="dropdown"  class="dropdown-toggle dropdown" href="#" aria-expanded="true">
		  <img class="img-circle img-resposive" src="<?php echo base_url(); echo isset($cust_detail[0]) ? $cust_detail[0]['photo']:''; ?>" width="40"></a>
		  <ul class="dropdown-menu text-center">
              <!-- User image -->
  <!--        <li class="user-header">
				<img alt="User Image" class="img-circle img-resposive" src="<?php echo base_url();if(isset($cust_detail[0]['photo'])){ echo  $cust_detail[0]['photo'] ;} ?>" height="80" width="80" />
				
				<p class="text-white">
                  <?php echo isset($cust_detail[0]) ? $cust_detail[0]['first_name']:''; echo isset($cust_detail[0]) ? $cust_detail[0]['last_name'] : ''; ?><br>
                  <small><?php $mydate =  isset($cust_detail[0]) ? $cust_detail[0]['date_added'] : '';  $month = date("M",strtotime($mydate)); $year = date("Y",strtotime($mydate)); ?>Member since <?php echo $month.".".$year; ?></small>
                </p>
              </li>
             <li class="user-footer">
                <div class="pull-left bottom-margin">
                  <a class="btn btn-Primary" href="<?php echo base_url(); ?>profile">Profile</a>
                </div>
                <div class="pull-right bottom-margin">
                  <a class="btn btn-Primary" href="<?php echo base_url(); ?>sign_out">Sign out</a>
                </div>
              </li>
            </ul>
		
		</li>
		</ul>
		</div>
		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-2">
      <ul class="nav navbar-nav  navbar-nav-mob">
        <li class="active"><a href="#">MyAccount <span class="sr-only">(current)</span></a></li>
        <li><a href="#">SendPayment</a></li>
		 <li><a href="#">RequestPayment</a></li>
		 <li><a href="#">QuickSettler</a></li>
      </ul>
    </div>
	</div>
</nav>
		<!--	<ul class="unstyled-list inline top-ul">
			<li class="inline dropdown">
			<a href="#" class="f16 dropdown-toggle border-box" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
			<?php if(!$this->session->userdata('currency_id')){ ?>
			  <img src="<?php echo base_url(); ?>layout-1/img/flag-1.png" width="20px"> 
			  $USD
			  <span class="caret large-caret text-orange" style="font-size:20px;"></span>
			<?php }else{?>
				<?php 	foreach ($this->session->userdata('currencies') as $currency){ 
				if($this->session->userdata('currency_id') == $currency['currency_id']) {?>
			  <div class="flag <?php echo strtolower($currency['code']);?> pull-left" style="height:16px;width:16px;margin: 3px 4px 0px 0px;"></div>
			  <?php echo $currency['currency_symbol'].$currency['code'];?>
			  <span class="caret large-caret text-orange" style="font-size:20px;"></span>
				<?php } } }?>
		  </a>
			<ul class="dropdown-menu" >
		  <?php	foreach ($this->session->userdata('currencies') as $currency){ 
					if($this->session->userdata('currency_id') == $currency['currency_id']) {	
							if($currency['status'] == '1'){ ?>                              
								 
						<?php }
					} 
					else 
					{ 
						if($currency['status'] == '1'){ ?>          
						<?php	if($this->session->userdata('currency_id') != $currency['currency_id']) {?>
								 <li ><a href="<?php echo base_url();?>index.php/dashboard/setCurrency/<?php echo $currency['currency_id'];?>?redirect=<?php echo urlencode($this->uri->uri_string().$query); ?>">

							<?php echo $currency['currency_symbol']; ?>  <?php echo $currency['code']; ?></a></li>
						
						<?php }} }?>	
				<?php } ?>
          </ul>
			  
			
			</li>
			<li class="dropdown"><a class="wel-text" href="#" id="dLabel" role="button" data-toggle="dropdown" data-target="#"><i class="fa fa-bell text-orange "></i> <span class="round img-circle text-center" id="total_count">0</span> </a> <!--<span class="round img-circle text-center" id="total_count">0</span></li> -->
			
		<!--	  <ul class="dropdown-menu  " role="menu" aria-labelledby="dLabel"><span class="top-caret"></span>
				<div class="notification-heading"><h4 class="menu-title pull-left">Notifications</h4><a href="<?php echo base_url();?>index.php/notification"></a>
				</div>
				<li class="divider col-md-12" ></li>
			   <div class="notifications-wrapper col-md-12"  style="" id="content_2">
			   </div>
			   <li class="divider col-md-12" ></li>
				<div class="notification-footer"><a href="<?php echo base_url();?>notification"><h4 class="menu-title">View all<i class="glyphicon glyphicon-circle-arrow-right"></i></h4></a><a href="#"><h4 class="menu-title pull-right" id="clear-all-notif">Clear All</h4></a></div>
			  </ul>
			  </li>
			
			<li class="profile-img "><a data-toggle="dropdown"  class="dropdown-toggle dropdown" href="#" aria-expanded="true">
		  <img class="img-circle img-resposive" src="<?php echo base_url(); echo isset($cust_detail[0]) ? $cust_detail[0]['photo']:''; ?>"></a>
		  <ul class="dropdown-menu text-center">
              <!-- User image -->
        <!--      <li class="user-header">
				<img alt="User Image" class="img-circle img-resposive" src="<?php echo base_url();if(isset($cust_detail[0]['photo'])){ echo  $cust_detail[0]['photo'] ;} ?>" height="80" width="80" />
				
				<p class="text-white">
                  <?php echo isset($cust_detail[0]) ? $cust_detail[0]['first_name']:''; echo isset($cust_detail[0]) ? $cust_detail[0]['last_name'] : ''; ?><br>
                  <small><?php $mydate =  isset($cust_detail[0]) ? $cust_detail[0]['date_added'] : '';  $month = date("M",strtotime($mydate)); $year = date("Y",strtotime($mydate)); ?>Member since <?php echo $month.".".$year; ?></small>
                </p>
              </li>
             <li class="user-footer">
                <div class="pull-left bottom-margin">
                  <a class="btn btn-Primary" href="<?php echo base_url(); ?>profile">Profile</a>
                </div>
                <div class="pull-right bottom-margin">
                  <a class="btn btn-Primary" href="<?php echo base_url(); ?>sign_out">Sign out</a>
                </div>
              </li>
            </ul>
		</li> 
			
			</ul> -->
			
	<!--	</div>
	</div>
</nav> -->

<?php  if($this->session->userdata('customer_id')){ ?>   
<script>

$(document).ready(function(){
	
$(".alert-box").delay(5000).fadeOut();	
$("#clear-all-notif").click(function(){
	if(confirm("Are you sure you want to clear"))
	{
		$.ajax({
				 url:"<?php echo base_url()."index.php/dashboard/clear_all_notif";?>",
				 success: function(json) {
					 $("#content_2").html('No notification to show');
					 if($("#notify_main").length)
						{
							$("#notify_main").html('No notification to show !');
						}
				 }
		});
	}
});
$.ajax({
			 url:"<?php echo base_url()."index.php/dashboard/count_notif";?>",
			dataType: 'json',
			success: function(json) {
						
						if(json.total==0)
						{
							$('#total_count').hide();
						}
						$("#total_count").text(json.total);
						var herf=$("#dispute_link").attr("href");
						var herf_new =$("#dispute_link").attr("href");
						if(json.total_dispute[0])
						{
							herf = herf+json.total_dispute[0].id
							$("#dispute_link").attr("href",herf);
							if(json.total_dispute[0].date_added)
							{
								$("#dispute_counter").countdown({
										until: new Date(json.total_dispute[0].date_added),
										layout: '{dn} {dl}:{hn}:{mn}:{sn}',
										serverSync: new Date(json.total_dispute[0].now), 
										expiryText: "" 
								}); 
								$("#dispute_link").show();
							}							
							$(".total_dispute").text(json.total_dispute[0].total_dispute);
							
							if(json.total_dispute[0].total_dispute>1){
							var j ;
								for( j=1;j<json.total_dispute[0].total_dispute;j++) {
									 
									$('#counterdiv1').append(
									  $('<a>/>')
										.attr("href", herf_new+json.total_dispute[j].id)
										.addClass("notifications-wrapper col-md-6")
										.append("<span/>")
										  .text("Dispute  Id: "+json.total_dispute[j].id)
									);
									
									$('#counterdiv1').append(
									  $('<div>/>')
										.attr("id", "newDiv"+j)
										.addClass("item-info pull-right")
										
									);
							   
									 $("#newDiv"+j).countdown({
											until: new Date(json.total_dispute[j].date_added),
											layout: '{dn} {dl}:{hn}:{mn}:{sn}',
											serverSync: new Date(json.total_dispute[j].now), 
											expiryText: "" 
									});
									$('#counterdiv1').append(
									  $('<li>/>')
										.addClass("divider col-md-12")
										
									);
								
								}
							}
							else
							{
								$(".dispute_id_plus").css({"display":"none"}); 
							}
						
						}
						
							
						$("#content_2").html('');
						html='';
						html1='';
						if(json.dispatch_received > 0 )
							$('.notification-heading').append('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a data-toggle="tooltip" data-placement="bottom" title="Dispatcher" class="btn btn-primary pull-right navi-btn"  href="<?php echo base_url();?>dispatcher?m=0" id=""><i class="fa fa-paper-plane"></i>&nbsp;<span class="round img-circle text-center" id="quicksettler1">'+json.dispatch_received+'</span></a>');
						
						if(json.quicksettler > 0 )
							$('.notification-heading').append('&nbsp;&nbsp;&nbsp;&nbsp;<a data-toggle="tooltip" title="QuickSettler" data-placement="bottom" class="btn btn-primary pull-right navi-btn " href="<?php echo base_url();?>send_money" id=""><i class="fa fa-cogs"></i> <span class="round img-circle text-center" id="quicksettler1">'+json.quicksettler+'</span></a>');
						
						//Dispatcher And QuickSettler Base
						/* if(json.quicksettler > 0 )
							$('.QuickSettler').append('<span class="round img-circle text-center" id="quicksettler">'+json.quicksettler+'</span>')
						if(json.dispatch_received > 0 )
							$('li a.Dispatcher').parent().append('<span class="round img-circle text-center" id="dispatcher">'+json.dispatch_received+'</span>') */
						$.each(json.notify_details, function(i, item) {
							if(item.read=='0'){
							
							html+=(' <a class="content" href="'+item.url+'"><div class="notification-item"><h4 class="item-title  pull-left">'+item.description+' <b>'+item.amount+'</b></h4><p class="item-info  pull-right">'+item.date_added+'</p></div></a>');
							
							
							html1+=('<tr  style="width:100%"><td class="text-left"><a  href="'+item.url+'">'+item.description+' <b>'+item.amount+'</b></a></td><td class="text-left"><span >'+item.date_added+'</span></td></tr>');
							}
							else{
							
							html+=(' <a class="content" href="'+item.url+'"><div class="notification-item"><h4 class="item-title  pull-left">'+item.description+' <b>'+item.amount+'</b></h4><p class="item-info  pull-right">'+item.date_added+'</p></div></a>');
							
							html1+=('<tr  style="width:100%"><td class="text-left"><a  href="'+item.url+'">'+item.description+' <b>'+item.amount+'</b></a></td><td class="text-left"><span >'+item.date_added+'</span></td></tr>');
							}
						})
						
						$("#content_2").html(html);
						if($("#notify_main").length)
						{
							$("#notify_main").html(html1);
							if(!json.notify_details.length)
							$("#notify_main").html('No notification to show !');
						}
						if(json.count=='0')
						$("#comment_cnt").css('display','none');
						else
						{
							$("#comment_cnt").css('display','block');
						$("#comment_cnt").text(''+json.count);
						}
						if(!json.notify_details.length)
						$("#content_2").html('No notification to show !');
					
					chk1=0;
				}
				})
				
					
var timer1, delay1 = 5000;
var ie=0;
var chk1=0;
timer1 = setInterval(function(){
if(chk1==0){
	chk1=1;
		$.ajax({
				 url:"<?php echo base_url()."index.php/dashboard/count_notif";?>",
				dataType: 'json',
				success: function(json) {
					
							$("#content_2").html('');
							html='';
							html1='';
							$("#total_count").text(json.total);
							var herf='<?php echo base_url().'despute/negotiate/';?>';
							if(json.total_dispute[0])
							{
								
								$("#dispute_link").attr("href",'#');
								if(json.total_dispute[0].date_added)
								{	
								$("#dispute_counter").countdown({
											until: new Date(json.total_dispute[0].date_added),
											layout: '{dn} {dl}, {hn} {hl}, {mn} {ml}, and {sn} {sl}',
											serverSync: new Date(json.total_dispute[0].now), 
											expiryText: "" 
									});   
									$("#dispute_link").show();
								}
								$(".total_dispute").text(json.total_dispute[0].total_dispute);
							}
							if(json.total > 1 && ie==0)
							{
								$.each(json.dispute, function(i, item) {
									$('#da_'+item.id).countdown(item.date_added);
								});
								testes();
							}
							/* if(json.total > 1)
							{
								table="<table style='width:100%'>";
								table=table+"<tr class=''>";
								table=table+"<th class='text-left'>";
								table=table+"Dispute Id";
								table=table+"</th>";
								table=table+"<th class='text-left'>";
								table=table+"Time Left";
								table=table+"</th>";
								table=table+"</tr>";
								
								$.each(json.dispute, function(i, item) {
									var herf='<?php echo base_url().'despute/negotiate/';?>';
									herf = herf+item.id
									table=table+"<tr>";
									table=table+"<td id='dprs'  class='text-left' >";
									table=table+'<a class="btn btn-danger btn-block" href="'+herf+'" >Despute #'+item.id+'</a>';
									table=table+"</td>";
									table=table+"<td id='test_"+i+"'  class='text-left'>";
									table=table+'';
									table=table+"</td>";
									table=table+"</tr>";
									 $('#test_'+i).countdown({
											until: new Date(item.date_added),
											layout: '{dn} {dl}, {hn} {hl}, {mn} {ml}, and {sn} {sl}',
											serverSync: new Date(item.now), 
											expiryText: "" 
									 });  
								});
								table=table+"</table>";
								
								$("#dispute_link").attr({"data-toggle":"popover","data-placement":"bottom","data-content":table});
								 $('[data-toggle="popover"]').popover({ html : true}); 
							 
							}
							  */
							 
							 
							 
							$.each(json.notify_details, function(i, item) {
							if(item.read=='0'){
							
							html+=(' <a class="content" href="'+item.url+'"><div class="notification-item"><h4 class="item-title  pull-left">'+item.description+' <b>'+item.amount+'</b></h4><p class="item-info  pull-right">'+item.date_added+'</p></div></a>');
							
							
							html1+=('<tr   style="width:100%"><td class="text-left"><a  href="'+item.url+'">'+item.description+' <b>'+item.amount+'</b></a></td><td class="text-left"><span >'+item.date_added+'</span></td></tr>');
							}
							else{
							
							html+=(' <a class="content" href="'+item.url+'"><div class="notification-item"><h4 class="item-title  pull-left">'+item.description+' <b>'+item.amount+'</b></h4><p class="item-info  pull-right">'+item.date_added+'</p></div></a>');
							
							html1+=('<tr   style="width:100%"><td class="text-left"><a  href="'+item.url+'">'+item.description+' <b>'+item.amount+'</b></a></td><td class="text-left"><span >'+item.date_added+'</span></td></tr>');
							}
						})
							
							$("#content_2").html(html);
							if($("#notify_main").length)
							{
								$("#notify_main").html(html1);
								if(!json.notify_details.length)
								$("#notify_main").html('No notification to show !');
							}
							if(json.count=='0')
							$("#comment_cnt").css('display','none');
							else
							{
								$("#comment_cnt").css('display','block');
							$("#comment_cnt").text(''+json.count);
							}
							if(!json.notify_details.length)
							$("#content_2").html('No notification to show !');
						chk1=0;
					}
				});
				ie++;
	}
}, delay1);
});

</script>
<?php }?>

<script>
var testes  = $(function() {
  $('div[data-countdown]').each(function(i) {
    var d, h, m, s,
        toDate = $(this).data('until');
    $(this).countdown(toDate, function(event) {
      var timeFormat = "%d day(s) %h:%m:%s";
		  switch(event.type) {
        case "days":
          d = event.value;
          break;
        case "hours":
          h = event.value;
          break;
        case "minutes":
          m = event.value;
          break;
        case "seconds":
          s = event.value;
          break;
      }
      // Assemble time format
      if(d > 0) {
        timeFormat = timeFormat.replace(/\%d/, d);
        timeFormat = timeFormat.replace(/\(s\)/, Number(d) == 1 ? '' : 's');
      } else {
        timeFormat = timeFormat.replace(/%d day\(s\)/, '');
      }
      timeFormat = timeFormat.replace(/\%h/, h);
      timeFormat = timeFormat.replace(/\%m/, m);
      timeFormat = timeFormat.replace(/\%s/, s);
      // Display
      $(this).html(timeFormat);
		});
  });
});
$(document).ready(function(){
   $('[data-toggle="tooltip"]').tooltip(); 
	$('#dispute_link').mouseover(function(){
		$('#Hover_text').toggleClass('hidden');
	});
});
</script>
<style>

.glyphicon-bell 
{
    font-size:1.5rem;
}
.dropdown-menu .divider {
    /* background-color: transparent; */
    height: 1px;
    margin: 9px 0;
overflow: hidden;}


  
 
    

 
.glyphicon-circle-arrow-right {
      margin-left:10px;     
   }
 .curr_bal_amt
 {
	font-family: Agency FB;
	src: url('../layout-1/fonts/Agency_FB.ttf');
	font-size:28px;
 }

</style>

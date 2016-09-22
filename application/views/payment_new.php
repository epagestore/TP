<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Trusted Payer NEW</title>

    <!-- Bootstrap -->
    <link href="<?php echo base_url(); ?>layout-1/css/bootstrap.min.css" rel="stylesheet">
	<link href="<?php echo base_url(); ?>layout-1/css/style.css" rel="stylesheet">
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<meta name="author" content="Iyke" />
		<!-- Bootstrap -->
		<script src="<?php echo base_url(); ?>layout-1/js/modernizr.custom.js"></script>
		
		<link href="<?php echo base_url(); ?>layout-1/css/jquery.fancybox.css" rel="stylesheet">
		<link href="<?php echo base_url(); ?>layout-1/css/flickity.css" rel="stylesheet" >
		<link href="<?php echo base_url(); ?>layout-1/css/animate.css" rel="stylesheet">
		<link href="<?php echo base_url(); ?>layout-1/css/font-awesome.min.css" rel="stylesheet">
		<link href="<?php echo base_url(); ?>layout-1/css/styles.css" rel="stylesheet">
		<link href="<?php echo base_url(); ?>layout-1/css/queries.css" rel="stylesheet">
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
		<style>
			div#preloader { position: fixed; left: 0; top: 0; z-index: 999;opacity:0.8; width: 100%; height: 100%; overflow: visible; background: #333 url('../../images/ajax-loader.gif') no-repeat center center; }

		</style>
  </head>
  <body>
  <div id="preloader" class="hidden"></div>
   <nav class="navbar navbar-default custom-nav hidden-xs">
   <div class="container">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#"><img src="<?php echo base_url(); ?>layout-1/img/logo.png"></a>
    </div>

   
  </div><!-- /.container-fluid -->
</nav>
<div class="seperator">
</div>
<section class="container hide_sec" style="min-height:500px">
<div class="row">

	<div class="col-sm-4 box-border">
	<h3 class="text-orange">Your Order Summary</h3>
	
	<div class="table-responsive">
	  <table class="table payment-table ">
	<thead>
      <tr class="text-center table-hd">
        <th>Discription</th>
        <th class="text-right">Amount</th>
        
      </tr>
    </thead>
	 <tbody>
      <tr>
        <td>Name</td>
        <td class="text-right"><?php echo $supplier_name;?>  </td>
        
      </tr>
      <tr>
        <td>Product /Services Tital</td>
        <td class="text-right"><?php echo $product_desc;?> </td>
       
      </tr>
      <tr>
        <td>Quantity</td>
        <td class="text-right"><?php echo $quantity;?></td>
        
      </tr>
	  
	  <tr>
	  <td>Order Amount</td>
	  <td class="text-right"><?php echo $currency_symbol;?><?php echo sprintf("%.2f", $total_amount*$value); ?></td>
	  </tr>
		<?php if(isset($total_milestone)){?>
	  <tr class="tr-border">
	  <td>Paid Amount</td>
	  <td class="text-right"><?php echo $currency_symbol;?><?php echo sprintf("%.2f", ($total_milestone)*$value); ?></td>
	  </tr>
	  <?php } ?>
	  <tr>
	  <td>Milestone Amount</td>
	  <td class="text-right"><?php echo $currency_symbol;?><?php echo sprintf("%.2f", $milestone*$value); ?></td>
	  </tr>
	 <?php if(isset($total_milestone)){?>
	  <tr class="tr-border">
	  <td>Remaining Amount</td>
	  <td class="text-right"><?php echo $currency_symbol;?><?php echo sprintf("%.2f", ($total_amount-$milestone-$total_milestone)*$value); ?></td>
	  </tr>
	  <?php } ?>
	  <tr class="info">
	  <td>Payment Total </td>
	  <td class="text-right"><?php echo $currency_symbol;?><?php echo sprintf("%.2f", ($milestone)*$value); ?></td>
	  </tr>
	  
	 
	  
	</tbody>
	</table>
	</div>
	
	<div class="container-fluid">
	<form class="form-horizontal" method="post" action="<?php if($this->uri->segment(2)=='milestone_payment'){ echo base_url().'order/milestone_payment';}else {echo base_url().'order/payment';}?>"  name="milestone">
		<input type="hidden" value="<?php echo $_GET['id']?>" name="key">
		  <input type="hidden" name="first_milestone" value="<?php echo $milestone;?>" />
		  <?php if($this->session->userdata('customer_id'))
			{?>
			<div class="form-group">
              <?php if(!$this->session->userdata('bal') && (isset($milestone) || $suffi_balance)){?>
			<div class="col-sm-offset-5 col-sm-7">
			  <button type="submit" name="submit" class="btn btn-success " id="milestone_submit">Submit</button>
			  <a class="btn btn-danger " href="<?php echo urldecode($cancel);?>">Cancel</a>
			</div>
		
		   <?php }else if($this->session->userdata('bal')){?>
					<span class="btn-block label-danger text-white text-center">Sorry! You have insufficient balance</span>
					<br>
					<div class="pull-right">
					<a  class="btn btn-success" href="<?php echo base_url();?>index.php/order/deposit_amount?<?php echo $_SERVER['QUERY_STRING'];?>">Deposit</a>
                    <a  class="btn btn-danger" href="<?php echo urldecode($cancel);?>">Cancel</a>
					</div>
                <?php }?>
				  </div>
        <?php }?>
	</form>
	</div>
	

	</div>
	<div class="col-sm-8 ">
	<div class="row ">
	<?php if(!$this->session->userdata('customer_id'))			{?>
	<div class="col-sm-6 col-sm-offset-1">
	
	<h3 class="text-orange">Pay with my Trusted payer account</h3>
	<span class="bottom-margin">Log in to your account to complete the purchase</span>
	<div class="bottom-margin"></div>
	<form class="form-horizontal" action="<?php echo base_url();?>index.php/sign_in" method="post" autocomplete="off" id="lgform">
			<?php if(isset($_GET['id'])){?>
				<input type="hidden" name="api_key" value="<?php echo $_GET['id'];?>" />
				<input type="hidden" name="api_redirect" value="<?php echo $this->uri->segment(1).'/'.$this->uri->segment(2);?>" />
		    <?php }?>
			<div class="form-group">
			<?php  if(!($this->session->userdata('customer_id') && $cust_login)){if($this->session->flashdata('message')){ ?>   
                    <div style="color:red">
								<?php echo $this->session->flashdata('message'); ?>                
							</div>
			 <?php }}?>
			<label for="inputEmail3" class="col-sm-3 control-label">Email</label>
			<div class="col-sm-9">
			  <input type="text" class="form-control" id="inputEmail3"placeholder="Email Address" name="email" >
			</div>
		  </div>
		  <div class="form-group">
			<label for="inputEmail3" class="col-sm-3 control-label">Password</label>
			<div class="col-sm-9">
			  <input  type="password" class="form-control" placeholder="Password" name="password" autocomplete="off">
			</div>
		  </div>
		  <div class="form-group">
			<div class="col-sm-offset-3 col-sm-9">
			  <button type="submit" class="btn btn-success ">Submit</button>
			  <button type="submit" class="btn btn-danger ">Cancel</button>
			  
			</div>
			<a class="pull-right " id="registered" style="cursor:pointer">I am not registered?</a>
		  </div>
	</form>
	<form class="form-horizontal" id="regform" method="post" action="<?php echo base_url();?>index.php/home" style="display:none"> 
		<?php if(isset($_GET['id'])){?>
				<input type="hidden" name="api_key" value="<?php echo $_GET['id'];?>" />
				<input type="hidden" name="api_redirect" value="<?php echo $this->uri->segment(1).'/'.$this->uri->segment(2);?>" />
		    <?php }?>
		<div class="form-group ">
			<label for="inputEmail3" class="col-sm-3 control-label">Name</label>
			<div class="col-sm-9">
			  <input type="text" class="form-control"  id="fname"  name="fname"  placeholder="Name">
			</div>
		</div>
		<div class="form-group ">
			<label for="inputEmail3" class="col-sm-3 control-label">Email</label>
			<div class="col-sm-9">
			  <input type="email" class="form-control" name="email" id="email_reg" placeholder="Email">
			</div>
		</div>
		<div class="form-group ">
			<label for="inputEmail3" class="col-sm-3 control-label">Password</label>
			<div class="col-sm-9">
			  <input type="password" class="form-control" id="pwd_reg" name="password" placeholder="Password">
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-offset-3 col-sm-9">
			  <button type="submit" class="btn btn-success ">signup</button>
			  <div class="btn btn-danger " id="logined">Login</div>
			</div>
		</div>
	</form>
	</div>
	<?php }?>
	<?php if($this->session->userdata('customer_id') ){?>
	<div class = "col-sm-6 col-md-6 col-lg-6 col-xs-12">
	  <div class = "thumbnail">
		 <img src="<?php echo base_url();?>images/paystack2.png" style="height:32%; !important"/>
	  
	  <div class = "caption">
		
		  <p>
			<form method="POST"  name="cash" id="paystack-form" action="http://test.epagestore.in/payment/payment.php">    
			 <input type="hidden" name="amount" id="paystack_amt" class="form-control bottom-margin" placeholder="Enter amount (₦ NGN)" value="<?php echo ($milestone)*160;?>">		 
			<?php $randomString = substr(str_shuffle("01234567890123456789"), 0, 17);
			$this->session->set_userdata('transaction_id','TP'.$randomString);?>
			<input type="hidden" name="callback_url" value="<?php echo base_url('order/payment').'?id='.$_GET['id'];?>" />
			<input type="hidden" name="unique-paystack" id="unique_id1" class="form-control" value="<?php echo 'TP'.$randomString;?>" />
				 <!--<img src="<?php //echo base_url();?>img/pay_btn11.png" onclick="validate();">-->
			<input type="button" name="submit" value="Deposit" id="submit-paystack" class="btn-block btn-primary btn btn-lg">
			<input type="submit" id="transfer-paystack" value="Transfer" class=" hidden btn-block btn-primary btn btn-md">
			</form>
		 </p>
		</div> 
	  </div>
	</div>
	<?php }?>
	<div class="col-sm-4 col-sm-offset-1 text-right">
	<div class="box-border image-box text-center bottom-margin">
	
	<img src="<?php echo base_url();if($company_logo=='') {echo "images/no-image.gif";}else {echo $company_logo;}?>" class="img-resposive">
	</div>
	<div class="bottom-margin">
	<span class="text-orange">Comapny Name :</span>
	<span><a href=""><?php echo $company_name;?></a></span>
	</div>
	<!--<div class="bottom-margin">
	<span class="text-orange">Comapny Name :</span>
	<span>Trusted Payer</span>
	</div>-->
	</div>
	</div>
	</div>
</div>
</section>

		<!-- Modal -->
	<div class="modal fade animated shake" id="myModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document" style="width:70%;top:13%">
		<div class="modal-content">
		  
		  <div class="modal-body" style="min-height:500px">
		  <div class="row">
				<br><br><br><br><br>
				<div class="col-sm-9 col-sm-offset-1">
					<h1 style="font-size:3em">Sorry,</h1>
					<p><h2 style="font-size:2.3em">Seller / Service Provider does not Registered with TrustedPayer or does not connected with <a href="<?php echo $company_website;?>"><?php echo $company_name;?></a> </h2></p>
					<a class="btn btn-danger btn-lg" href="<?php echo $current_url;?>">Go Back</a>
				</div>
		  </div>
		  </div>
		 
		</div>
	  </div>
	</div>
	<button type="button" class="HIDDEN " data-toggle="modal" data-target="#myModal" id="popup_error">Subscribe Now</button>
	<!-- Modal -->


   
  	<script src="<?php echo base_url();?>layout-1/js/jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>layout-1/js/bootstrap.min.js"></script>
	<script src="<?php echo base_url(); ?>layout-1/js/min/toucheffects-min.js"></script>
		<script src="<?php echo base_url(); ?>layout-1/js/flickity.pkgd.min.js"></script>
		<script src="<?php echo base_url(); ?>layout-1/js/jquery.fancybox.pack.js"></script>
		<script src="<?php echo base_url(); ?>js/ajaxloader.js"></script>
		<!-- Include all compiled plugins (below), or include individual files as needed -->
		<script src="<?php echo base_url(); ?>layout-1/js/retina.js"></script>
		<script src="<?php echo base_url(); ?>layout-1/js/waypoints.min.js"></script>
		
		<script src="<?php echo base_url(); ?>layout-1/js/min/scripts-min.js"></script>
	<?php if(!$this->session->userdata('customer_id')){?>
	<script>
		$('#logined').click(function(){
			$('#lgform').fadeIn();
			$('#regform').hide();
		})
		$('#registered').click(function(){
			
			$('#lgform').hide();
			$('#regform').fadeIn();
		})
		
	</script>
	<?php }?>
	<?php if($this->session->userdata('customer_id')){?>
	<script>
	$('#submit-paystack').click(function(){
		
		var amount=$('#paystack_amt').val();
		var uniqid=$('#unique_id1').val();
		amount = amount.replace(',','');
		if(amount=='')
		{
			return false;
		}
		ajaxindicatorstart('loading data.. please wait..');
		$.post("<?php echo base_url();?>index.php/balance_manager/c_post",{ amount: amount,unique_id:uniqid},
		function(data) {
			var t = $.parseJSON(data);
			
			if(t.status===true) 
			{
				$('#paystack-form').attr('action',t.url);
				//$('#password').css({"border":"2px solid #00F5FF","box-shadow":"0 0 5px #00F5FF"});
				$('section').fadeOut();
				$('.navbar-nav').fadeOut();
				 $('iframe').height('750px');
				 $('iframe').fadeIn();
				$('#transfer-paystack').trigger("click");
			}
			else
			{
				alert(t.status);
			}
		});
		
	});	
	</script>
	
	<?php if( $this->session->userdata('de_trans')){ $this->session->unset_userdata('de_trans'); $this->session->unset_userdata('bal');?>
		<script>
			$(document).ready(function(){
			//	ajaxindicatorstart('loading data.. please wait..');
				$('#milestone_submit').trigger("click");
				
				
			});
		</script>
		
	<?php }?>
	<?php }?>
	
	<?php if(!$this->session->userdata('bal') && isset($pay_id) && $pay_id ==0  ){ ?>
	<script>
		$(window).load(function(){
			$('.hide_sec').html('');
			$('#popup_error').trigger("click");
	
			$('#preloader').fadeIn('slow',function(){$(this).remove().delay(2000);});
		});
	</script>
	<?php }?>
	
  </body>
</html>
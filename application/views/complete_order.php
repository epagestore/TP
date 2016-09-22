
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
	.payment-table > tbody > tr > td, .payment-table > tbody > tr > th, .payment-table > tfoot > tr > td, .payment-table > tfoot > tr > th, .payment-table > thead > tr > td, .payment-table > thead > tr > th
	{
		 font-size: 12px;
		 line-height:1;
		 padding:5px;
		 
	}
	
	
	</style>	
  </head>
  <body>
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

<section class="container">
<div class="row">
	<div class="col-sm-4 box-border">
	<h3 class="text-orange">Your Order Summary</h3>
	
	<div class="table-responsive">
	<table class="table payment-table ">
		<thead>
			  <tr class="table-hd">
				<th class="text-left">ITEM</th>
				<th class="text-right">DESCRIPTION</th>
				
			  </tr>
		</thead>
		<form class="form-horizontal" method="post" action="">
		 <tbody>
			  <tr>
				<td class="text-left"> Order ID</td>
				<td class="text-right"><?php echo $order_id?></td>
				
			  </tr>
			  <tr>
				<td  class="text-left">Product Name</td>
				<td class="text-right"><?php echo $product_name;?> </td>
			   
			  </tr>
			<?php if($this->session->userdata('customer_id') && $cust_login){?>
			  <tr>
				<td  class="text-left">Payee</td>
				<td class="text-right"><?php echo $payee_name;?></td>
			  </tr>
			  <tr>
				<td  class="text-left">Payee Secret Key</td>
				<td class="text-right"><input type="text" class="form-control" name="payee_key" id="payee_key" /></td>
			  </tr>
			  <tr>
				<td  class="text-left">Payer Secret Key</td>
				<td class="text-right"><input type="text" class="form-control"  name="payer_key" id="payer_key" /></td>
				<?php if(isset($key)){?>
					<input type="hidden" name="key" value="<?php echo $key?>" />
				<?php }?>
				 <?php if(isset($cust_login)){?>
					<input type="hidden" name="cust_login" value="<?php echo $cust_login?>" />
				<?php }?>
				<?php if(isset($order_id)){?>
					<input type="hidden" name="order_id" value="<?php echo $order_id?>" />
				<?php }?>
				<?php if(isset($company_logo)){?>
				<input type="hidden" name="company_logo" value="<?php echo $company_logo?>" />
				<?php }?>
				<?php if(isset($cancle)){?>
					<input type="hidden" name="cancle" value="<?php echo $cancle?>" />
				<?php }?>
				<?php if(isset($company_key)){?>
					<input type="hidden" name="company_key" value="<?php echo $company_key?>" />
				<?php }?>
				<?php if(isset($sucess)){?>
					<input type="hidden" name="sucess" value="<?php echo $sucess?>" />
				<?php }?>
				<?php if(isset($txn_id)){?>
					<input type="hidden" name="txn_id" value="<?php echo $txn_id?>" />
				<?php }?>
				<?php if(isset($order_product_id)){?>
					<input type="hidden" name="order_product_id" value="<?php echo $order_product_id?>" />
				<?php }?>
				<?php if(isset($product_key)){?>
					<input type="hidden" name="product_key" value="<?php echo $product_key?>" />
				<?php }?>
			  </tr>
			  <tr>
				<td  class="text-left"><?php if(isset($error_message)){ echo $error_message;}?></td>
				<td class="text-right"><button type="submit" class="btn btn-success btn-lg">Submit</button></td>
			  </tr>
			<?php }?> 
		</tbody>
		</form>
	</table>
	</div>
	
	
	</div>
	<div class="col-sm-8 ">
	<div class="row ">
	<?php if(!$this->session->userdata('customer_id'))			{?>
	<div class="col-sm-6 col-sm-offset-1">
	
	<h3 class="text-orange">Pay with my Trusted payer account</h3>
	<span class="bottom-margin">Log in to your account to complete the purchase</span>
	<div class="bottom-margin"></div>
	
	<form class="form-horizontal" action="<?php echo base_url();?>index.php/sign_in" method="post" autocomplete="off">
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
			  <button type="submit" class="btn btn-success btn-lg">Submit</button>
			  <button type="submit" class="btn btn-danger btn-lg">Cancel</button>
			</div>
		  </div>
	</form>
	</div>
	<?php }?>
	
	<div class="col-sm-4 col-sm-offset-1 text-right">
	<div class="box-border image-box text-center bottom-margin">
	
	<img src="<?php echo base_url();?>layout-1/img/logo.png" class="img-resposive">
	</div>
	
	<!--<div class="bottom-margin">
	<span class="text-orange">Comapny Name :</span>
	<span>Trusted Payer</span>
	</div>-->
	</div>
	<div class="col-sm-4 col-sm-offset-1 text-right">
		<div class="bottom-margin text-left">
		<span class="text-orange">Comapny Name :</span>
		<span><?php echo isset($company_name)?$company_name:'';?></span>
		</div>
		<div class="bottom-margin text-left">
		<span class="text-orange">Website :</span>
		<span><a href="<?php  echo isset($company_website)?$company_website:'';?>"><?php echo isset($company_website)?$company_website:'';?></a></span>
		</div>
	</div>
	</div>
	</div>
</div>
</section>


   
  	<script src="<?php echo base_url();?>layout-1/js/jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>layout-1/js/bootstrap.min.js"></script>
	<script src="<?php echo base_url(); ?>layout-1/js/min/toucheffects-min.js"></script>
		<script src="<?php echo base_url(); ?>layout-1/js/flickity.pkgd.min.js"></script>
		<script src="<?php echo base_url(); ?>layout-1/js/jquery.fancybox.pack.js"></script>
		<!-- Include all compiled plugins (below), or include individual files as needed -->
		<script src="<?php echo base_url(); ?>layout-1/js/retina.js"></script>
		<script src="<?php echo base_url(); ?>layout-1/js/waypoints.min.js"></script>
		
		<script src="<?php echo base_url(); ?>layout-1/js/min/scripts-min.js"></script>
	
	
  </body>
</html>
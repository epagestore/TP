<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
 <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Trusted Payer</title>

    <!-- Bootstrap -->
    <link href="<?php echo base_url(); ?>layout-1/css/bootstrap.min.css" rel="stylesheet">

	<link href="<?php echo base_url(); ?>layout-1/css/style.css" rel="stylesheet">

		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<meta name="author" content="Iyke" />
		<!-- Bootstrap -->

		<link href="<?php echo base_url(); ?>layout-1/css/styles.css" rel="stylesheet">
		<link href="<?php echo base_url(); ?>layout-1/css/queries.css" rel="stylesheet">
		
</head>

<body style="display: block;padding-top:0px;">





<div class="seperator">
</div>
<section class="container" >
<div class="row" style="border:1px solid #ccc;">
<h3 class="text-orange">Invoice</h3>
	<div class="col-sm-12 col-xs-12 col-md-12" >
	<div class="row bottom-margin">
	  <div class="col-sm-10 col-xs-10">
	  <div class="col-sm-10">
	  <span class="pull-left"><strong>Name:</strong> <?php echo $invoice[0]['first_name']." ".$invoice[0]['last_name'] ?> <br>
	  <strong>Invoice Id:</strong> <?php echo $invoice[0]['invoice_id'] ?> <br>
	  <strong>Invoice Date:</strong> <?php echo $invoice[0]['date_added'] ?> <br>
	  <strong>Amount Due:</strong> <?php echo $currency_symbol;?><?php echo sprintf ("%.2f", $invoice[0]['total']*$value); ?>
	  </span>
	  </div>
	  </div>
	  <div class="col-sm-2 col-md-2">
	  <span class="pull-right"><img src="<?php if($invoice[0]['photo']!=''){echo base_url().$invoice[0]['photo'];}else { echo  base_url()."images/no_image.gif";} ?>"width="80" height="70"/></span>
	  </div>
	  </div>
	  
	  <div class="row">
		<div class="col-sm-12 col-xs-12">
		<div class="table-responsive">
	  <table class="table ">
	<thead>
      <tr class="text-center table-hd">
        <th class="text-center">Iteam</th>
        <th class="text-center">Description</th>
        <th class="text-center">Unit Cost</th>
		<th class="text-center">Quantity</th>
		<th class="text-center">Tax</th>
		<th class="text-center">Prize($)</th>
		
      </tr>
    </thead>
	 <tbody>
	    
		 <?php $subtotal=0;foreach($invoice_order as $order):?>
		  <tr class="text-center">
			<th><?php echo $order['item']?></td>
			<td><?php echo $order['description']?></td>
			<td> <?php echo $currency_symbol." ".sprintf ("%.2f", $order['unit_price']);?></td>
			<td><?php echo $order['quantity']?></td>
			<td><?php echo $order['tax']?>%</td>
			<td><?php $amount=$order['quantity']*$order['unit_price']; echo $currency_symbol." ".sprintf ("%.2f", ($amount+($amount*$order['tax']/100))*$value); $subtotal+=$amount+($amount*$order['tax']/100);?></td>
		  </tr>
		 <?php endforeach;?>
	
    </tbody>
	  </table>
	</div>
	</div>	
		
	  </div>
	  
	  <div class="row">
	  <div class="col-sm-12 text-right amount-block">
	 <p> <span>sub Total:</span> <strong><?php echo $currency_symbol;?><?php echo sprintf ("%.2f", $subtotal*$value); ?></strong> </p>
	 <p> <span>GST-<?php echo $invoice[0]['discount'].$invoice[0]['discount_type'] ?>:</span><strong> <?php echo $currency_symbol;?><?php echo sprintf ("%.2f", (($subtotal*$invoice[0]['discount'])/100)*$value); ?></strong></p>
	 <p style="border-bottom:1px solid #ddd;"></p>
	 <p><span>Total:</span> <strong>	<?php echo $currency_symbol;?><?php echo sprintf ("%.2f", ($invoice[0]['total'])*$value); ?></strong></p>
	 <p><span>Amount Paid</span><strong>-<?php if($invoice[0]['status']=='3') echo $invoice[0]['total'];else echo "0.00";?></strong></p>
	 
	 <p class="bg-orange"><span>Balance Due:</span><strong><?php echo $currency_symbol;?><?php if($invoice[0]['status']!='3') echo sprintf ("%.2f", ($invoice[0]['total'])*$value);else echo "0.00";?>	</strong></p>
	  </div>
	  </div>
	</div>
	
</div>

<!-- Modal -->
</section>


<style>

.btn-primary{
	
	color: #000;
text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);
background:url(<?php echo base_url();?>images/SEND_BTN.png) #fff;
background-repeat: no-repeat;
border-color: none !important;
border:none;
padding:16px 10px 4px;
background-color:none;
width:151px;
background-color:none !important;
	}


</style>
<script src="<?php echo base_url();?>js/bootstrap-alert.js"></script> 
	<script>
	$(document).ready(function(){
		$("img").on("error",function(){
			$(this).attr("src",'<?php echo base_url(); ?>img/Team/user_placeholder.png')
		});
	});
	</script>
</body>
</html>
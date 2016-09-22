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
  <div class="seperator">
</div>

<section class="container">
<div class="row">
<link href="<?php echo base_url();?>css/style.css" rel="stylesheet" type="text/css" />


<?php if($invoice[0]['status']=='2'){?>
<div  style="text-align:center;"><a href="<?php echo base_url();?>"><img src="<?php echo base_url();?>images/logo.png" style="width:10%;"/></a></div>
<table width="60%" cellpadding="3" border="0" style="border-collapse:collapse; border:1px solid #e2e2e2; font-size:11px; font-family:Arial, Helvetica, sans-serif; color:#000;" bgcolor="#ffffff" align="center" class="loca_tbl_respo">
   <tr>
  <td>
  <table>
  <tr>
    <td valign="bottom"><b><h2 style="line-height:0;"><?php echo $invoice[0]['company_name'] ?></h2></b>
   <br><p><?php echo $invoice[0]['customer_phone'] ?></p>
    </td>
    <td style="width:100%">
    </td>

    <td align="right" valign="top">
     <img src="<?php if($invoice[0]['photo']!=''){echo base_url().$invoice[0]['photo'];}else { echo  base_url()."images/no_image.gif";} ?>"width="80" height="70"/></td>
  </tr>
 
  </table>
  </td>
  </tr>


<tr>
<td>
  <table width="100%" style="margin-top:10px; margin-bottom:10px;">
   
  <tr>
    <td align="left" valign="bottom"> 
  <a href="#" style="font-size:14px; font-weight:bold; color:#000; text-decoration:none;">
  <?php echo $invoice[0]['first_name']." ".$invoice[0]['last_name'] ?>
   </a>
  
  
 
  
  

   <table width="40%" border="1" align="right" style="border-collapse:collapse; border:1px solid #e2e2e2; font-size:13px;" cellpadding="0" cellspacing="10">
   
   
  <tr height="30" style="border-bottom:1px solid #e2e2e2;">
    <th scope="col" align="left" bgcolor="#f3f3f3" style="border-right:1px solid #e2e2e2;" >In voice # :</th>
    <th scope="col" align="right"><?php echo $invoice[0]['invoice_id'] ?></th>
  </tr>
  <tr height="30" style="border-bottom:1px solid #e2e2e2;">
    <th scope="row" align="left" bgcolor="#f3f3f3" style="border-right:1px solid #e2e2e2;">Date</th>
    <td align="right"><?php echo $invoice[0]['date_added'] ?></td>
  </tr>
  <tr height="30" style="border-bottom:1px solid #e2e2e2;">
    <th scope="row" align="left" bgcolor="#f3f3f3" style="border-right:1px solid #e2e2e2;">Amount Due CAD</th>
    <td align="right"><?php echo $currency_symbol;?><?php echo sprintf("%.2f", ($invoice[0]['total'])*$value); ?></td>
  </tr>
  
</table>
</td>
</tr>
</table>

    </td>
   </tr>
  
  
  
<tr bordercolor="#006666" style="" height="40">
  <td>
  <table width="100%" align="center" border="0" style="border-collapse:collapse; margin-bottom:20px; border:1px solid #e2e2e2; font-size:13px; border-left:none; border-right:none;" cellpadding="0">
  <tr bordercolor="#666666" style="border:1px solid #e2e2e2; height:50px; color:#1996e6; border-left:none; border-right:none;">
    <th width="12%" scope="col" style="border-right:1px solid #e2e2e2; ">item</th>
    <th width="47%" scope="col" style="border-right:1px solid #e2e2e2; ">description</th>
    <th width="16%" scope="col" style="border-right:1px solid #e2e2e2; ">Unit Cost($)</th>
    <th width="15%" scope="col" style="border-right:1px solid #e2e2e2; ">Quantity</th>
    <th width="14%" scope="col">Prize($)</th>
  </tr>
  <?php $subtotal=0;foreach($invoice_order as $order):?>
  <tr style="border:none; margin-bottom:10px; height:40px;">
    <th scope="row"><?php echo $order['item']?></th>
    <td align="center"><?php echo $order['description']?></td>
    <td align="right"><?php echo $currency_symbol;?><?php echo sprintf("%.2f", ($order['unit_price'])*$value); ?></td>
    <td align="center"><?php echo $order['quantity']?></td>
    <td align="right"><?php $subtotal+=$order['quantity']*$order['unit_price']; ?><?php echo $currency_symbol;?><?php echo sprintf("%.2f", ($order['quantity']*$order['unit_price'])*$value); ?></td>
  </tr>
  <?php endforeach;?>
  </table>
  </td>

<tr>
<td>
</td>
</tr>

<tr>
<td>
  <table width="100%" style="border-top:1px solid #e2e2e2; font-size:13px;">
  <tr>
    <td align="left" valign="bottom"> 

      <table width="50%" border="0" align="right" cellpadding="2px" style="border-collapse:collapse; border:1px solid #e2e2e2; margin-top:10px; margin-bottom:10px;font-size:13px;">
        
        <tr style="height:30px;">
          <th scope="col" align="right">Sub Total:</th>
          <th scope="col" align="right"><?php echo $currency_symbol;?><?php echo sprintf("%.2f", ($subtotal)*$value); ?></th>
          </tr>
          <tr style="border-bottom:1px solid #e2e2e2; style="height:30px;"">
          <th scope="col" align="right">GST-<?php echo $invoice[0]['discount'].$invoice[0]['discount_type'] ?>:</th>
          <th scope="col" align="right"><?php echo $currency_symbol;?><?php echo sprintf("%.2f", (($subtotal*$invoice[0]['discount'])/100)*$value); ?></th>
          </tr>
        <tr style="height:30px;">
          <th scope="row" align="right">Total</th>
          <td align="right"><?php echo $currency_symbol;?><?php echo sprintf("%.2f", ($invoice[0]['total'])*$value); ?></td>
          </tr>
          <tr style="border-bottom:1px solid #e2e2e2;height:30px;">
          <th scope="row" align="right">Amount Paid</th>
          <td align="right">-<?php if($invoice[0]['status']=='3') echo $invoice[0]['total'];else echo "0.00";?></td>
          </tr>
        <tr bgcolor="#CCCCCC" style="height:30px;">
          <th scope="row" align="right">Balance Due CAD</th>
          <td align="right"><?php echo $currency_symbol;?><?php if($invoice[0]['status']!='3') echo $invoice[0]['total'];else echo "0.00";?></td>
          </tr>
          <tr bgcolor="#CCCCCC">
          <th scope="row" align="right"></th>
          <td align="right"></td>
          </tr>
        

  </table>

    </td>
  </tr>
  
  <tr>
<td>
  <table width="100%" style="border-top:1px solid #e2e2e2; font-size:13px;">
  <tr>
    <td align="center" valign="bottom"> 

     <h4>Terms and Conditions</h4>
      <p style="font-size:14px; font-weight:normal"><?php echo ($invoice[0]['terms'])?></p>
      <h4>Other Comments From service provider</h4>
      <p style="font-size:14px; font-weight:normal"><?php echo ($invoice[0]['notes'])?></p>
       
      <form method="post">
	  
      	<input type="hidden" name="pay" value="PayPal" />
      	<input type="submit"  value="" class="btn-primary1">
		<a onclick="javascript: return confirm('Are you sure you want to pay invoice payment?')"  href="<?php echo site_url("invoice/trusted_pay")."/$key1"; ?>" class="btn btn-primary btn-md" style="margin-top:-4px;">TrustedPayer</a>
      </form>
	  
	  
     
  </td>
</tr>
  </table>
    </table>
  </td>
</tr>



</tr>
</table>
<table align="center" width="60%">
<tr>
        <td align="right" valign="bottom"> 

      <span style="font-size:12px; margin-top:4px; line-height:30px"  align="top">
      The invoice was sent using</span><span style="float:right;"><img src="<?php echo base_url();?>images/logo.png" width="50" height="30" style="float:right"/></span> 
      </span>
  </td>
  
 
</tr>
</table>

<style>
.btn-primary1{
	
	color: #000;
text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);
background-image:url(<?php echo base_url();?>images/paypal-buttons_03.png);
background-repeat: no-repeat;
border-color: none !important;
border:none;
padding:10px 10px 4px;
background-color:none;
width:151px;
	}
</style>
 <?php } else{
?>
 <div class="btn alert alert-success btn-primary" style="width:320px;">
 <?php if(isset($_GET['success'] )){ echo "Your Invoice Payment <br/>Transaction has been Successful!";}else echo "Invoice Already Paid";
 ?>
  <a href="<?php echo base_url(); ?>dashboard" class="btn btn-block btn-link">Back</a>
  </div>
 <?php
 }?>
 </div>
</section>
  </body>
</html>
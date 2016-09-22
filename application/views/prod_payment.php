<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Trusted Payer</title>
<link href="<?php echo base_url();?>css/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/default.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/component.css" />
		<script src="<?php echo base_url();?>js/modernizr.custom.js"></script>
<style>
	a.trusted-click-btn:hover{
		color:white;
	}
	span.error{
		display: inline-block;
		color: red;
	}
	.payer-name1{float: left;
    padding: 2px 0 2px 5px;
    text-align: left;
    width: 74%;
}
.payer-amount{width:14%;text-align:left; float:right;}
</style>
</head>

<body>

<div class="main-wrapper">
<div class="header-wrapper">
<div class="terusted-pair">
<div class="terusted-pair-logo"><a href="#"><img src="<?php echo base_url();?>images/logo.png" /></a></div>

</div>
</div>
<div class="trasted-transaction">
<div class="trated-payment-wrapper">
<?php echo validation_errors(); ?>
<div class="lft-pay-getway">
<?php if($this->session->userdata('customer_id') && $cust_login)
			{?>
            <?php if($suffi_balance){?>
	<?php echo form_open('')?>
    
    <?php  }}?>
    <input type="hidden" value="<?php echo $_GET['id']?>" name="key">
    
        <div class="trasted-paymennt-details">
        <div class="trated-tble">
        <div class="order-sumary">Your order summary</div>
        <div class="payment-tble-bar">
        <div class="name-person"> Description</div>
        <div class="pay-menu">Amount</div>
        </div>
        <?php foreach($product as $prdt):?>
        <div class="total-descrp-amount">
        <div class="payer-tble-det">
        <div class="payer-name1"> <?php echo $prdt['supplier_name'];?></div>
        <div class="payer-amount">&nbsp;</div>
        <?php /*?><div class="payer-amount"><?php echo $prdt['supplier_name'];?></div><?php */?>
        </div>
        <br /><br />
        <div class="payer-tble-det">
        <div class="payer-name1" style="font-weight:bold;"> <?php echo $prdt['description'];?></div>
        <div class="payer-amount">&nbsp;</div>
       <?php /*?> <div class="payer-amount"><?php echo $prdt['description'];?></div><?php */?>
        </div>
        <div class="payer-tble-det">
        <div class="payer-name1"> Quantity (<?php echo $prdt['quantity'];?>)</div>
        <div class="payer-amount">&nbsp;</div>
       <?php /*?> <div class="payer-amount"><?php echo $prdt['quantity'];?></div><?php */?>
        </div>
        <div class="payer-tble-det">
        <div class="payer-name1"> Amount</div>
        <div class="payer-amount"><?php echo $currency_symbol;?><?php echo sprintf ("%.2f", $prdt['product_amount']*$value); ?></div>
        </div>
        <div class="payer-tble-det">
        <div class="payer-name1"> Shipping cost</div>
        <div class="payer-amount"><?php echo $currency_symbol;?><?php echo sprintf ("%.2f", $prdt['shipping_cost']*$value); ?></div>
        </div>
        <div class="payer-tble-det">
        <div class="payer-name1"> Tax Rate</div>
        <div class="payer-amount"><?php echo $currency_symbol;?><?php echo sprintf ("%.2f", $prdt['taxes']*$value); ?></div>
        </div>
        
        
        <div class="total-amount-apy">
        <div class="totle-name">Item Total</div>
        <div class="totle-amount"><?php echo $currency_symbol;?><?php echo sprintf ("%.2f", $prdt['total_amount']*$value); ?></div>
        </div>
        </div>
         <?php endforeach?>
        <div class="item-ttoal"> Total <?php echo $currency_symbol;?><?php echo sprintf ("%.2f", $total_amount*$value); ?></div>
         <div style="margin-left:10px">
        <?php if($this->session->userdata('customer_id') && $cust_login)
			{?>
              <?php if($suffi_balance){?>
              	<div class="item-ttoal">Secure code : <input type="text" name="secure_code" value="">
                 <?php if($this->session->flashdata('secure_error'))echo "<span class='error'>".$this->session->flashdata('secure_error')."</span>";?>
                 </div>               
                <input class="trusted-click-btn" type="submit" name="submit" value="Submit" />        
                <a class="trusted-click-btn" href="<?php echo urldecode($cancel);?>">Cancel</a>
              <?php }else{?>
                <span style="color:red">Sorry You have insufficient balance!</span>
                    <br /><br /><a  class="trusted-click-btn" href="<?php echo base_url();?>index.php/order/deposit_amount?<?php echo $_SERVER['QUERY_STRING'];?>">Deposit</a>
                    <a  class="trusted-click-btn" href="<?php echo urldecode($cancel);?>">Cancel</a>
                <?php }?>
        <?php }?>
        </div>
        </div>
        </div>
        <?php if($this->session->userdata('customer_id') && $cust_login)
			{?>
    </form>
    <?php }?>
</div>
<div class="trasted-login">
<?php if(!($this->session->userdata('customer_id') && $cust_login))
			{?>
<div class="login-only-trusted">
    <div class="login-page"> 
    <h2>Pay with my Trusted payer account</h2>
    <p>Log in to your account to complete the purchase</p>
    <?php  if(!($this->session->userdata('customer_id') && $cust_login)){if($this->session->flashdata('message')){ ?>   
                    <div style="color:red">
                        <?php echo $this->session->flashdata('message'); ?>                
                    </div>
     <?php }}?>
    </div>

	<?php echo form_open('sign_in','autocomplete="off"')?>
        <?php if(isset($_GET['id'])){?>
        <input type="hidden" name="api_key" value="<?php echo $_GET['id'];?>" />
        <input type="hidden" name="api_redirect" value="<?php echo $this->uri->segment(1).'/'.$this->uri->segment(2);?>" />
   <?php }?>
<div class="login-page"> 
<div class="payer-name-first">Email</div>
<div class="login-first-line"><input type="text" autocomplete="off" placeholder="Email Address" name="email" /></div>
</div>
<div class="login-page"> 
<div class="payer-name-first">Password</div>
<div class="login-first-line"><input type="password" placeholder="Password" name="password" autocomplete="off" /></div>
</div>

<!--<div class="check-box"><input type="checkbox"/>This is a private computer.<a href="#">What's this?</a></div>
-->
<div class="trusted-click"><input type="submit" class="login-btn login-btn-type" value="Login" name="">
<a class="trusted-click-btn" href="<?php echo urldecode($cancel);?>" style="margin-top: -2px;">Cancel</a></div>

</form>
<!--<div class="forget-pass"><a href="#">Forget Email Or password?</a></div>
--></div>
<?php }?>
<div class="pay-with-logo">
<img src="<?php echo base_url();if($company_logo=='') {echo "images/no_image.gif";}else {echo $company_logo;}?>" />
</div>
<table width="60%" style="margin: 0;float: left;width: 30%;">
    <tr>
        <td>Company </td>
        <td>:</td>
        <td><?php echo $company_name;?></td>
    </tr>
    <tr>
        <td>Website </td>
        <td>:</td>
        <td><a style="color:blue;text-decoration:underline" href="<?php echo $company_website;?>"><?php echo $company_website;?></a></td>
    </tr>
</table>
</div>

</div>
</div>

</div>




</body>
</html>

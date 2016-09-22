<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Trusted Payer</title>
<link href="<?php echo base_url();?>css/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/default.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/component.css" />
		<script src="<?php echo base_url();?>js/modernizr.custom.js"></script>
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
<?php if($this->session->userdata('customer_id'))
			{?>
           <?php if(isset($milestone) || $suffi_balance){?>
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
        <div class="total-descrp-amount">
        <div class="payer-tble-detl">
        <div class="payer-name"> <?php echo $supplier_name;?></div>
       <?php /*?> <div class="payer-amount"><?php echo $supplier_name;?></div><?php */?>
        </div>
         <br /><br />
        <div class="payer-tble-detl">
        <div class="payer-name"> <?php echo $product_desc;?></div>
        <?php /*?><div class="payer-amount"><?php echo $product_desc;?></div><?php */?>
        </div>
        <div class="payer-tble-detl">
        <div class="payer-name"> Quantity (<?php echo $quantity;?>)</div>
        <?php /*?><div class="payer-amount"><?php echo $quantity;?></div><?php */?>
        </div>
        <div class="payer-tble-detl">
        <div class="payer-name">Order Amount</div>
        <div class="payer-amount"><?php echo sprintf("%.2f", $total_amount*$value); ?></div>
        </div>
         <div class="payer-tble-detl">
        <div class="payer-name"> Milestone Amount</div>
        <div class="payer-amount"><?php echo $currency_symbol;?><?php echo sprintf("%.2f", $milestone*$value); ?><input type="hidden" name="first_milestone" value="<?php echo $milestone;?>" /></div>
        </div>
        <div class="total-amount-apy">
        <div class="totle-name">Remaining Amount</div>
        <div class="totle-amount"><?php echo $currency_symbol;?><?php echo sprintf("%.2f", ($total_amount-$milestone)*$value); ?></div>
        </div>
        </div>
        <div class="item-ttoal"> Payment Total <?php echo $currency_symbol;?><?php echo sprintf("%.2f", ($milestone)*$value); ?></div>
          <div style="margin-left:10px">
        <?php if($this->session->userdata('customer_id'))
			{?>
              <?php if(isset($milestone) || $suffi_balance){?>
                <input class="trusted-click-btn" type="submit" name="submit" value="submit" />        
                <a class="trusted-click-btn" href="<?php echo urldecode($cancel);?>">Cancel</a>
              <?php }else{?>
                Sorry You have insufficient balance!
                    <br /><br /><a  class="trusted-click-btn" href="<?php echo base_url();?>index.php/order/deposit_amount?<?php echo $_SERVER['QUERY_STRING'];?>">Deposit</a>
                    <a  class="trusted-click-btn" href="<?php echo urldecode($cancel);?>">Cancel</a>
                <?php }?>
        <?php }?>
        </div>
        </div>
        </div>
        <?php if($this->session->userdata('customer_id'))
			{?>
    </form>
    <?php }?>
</div>
<div class="trasted-login">
<?php if(!$this->session->userdata('customer_id'))
			{?>
<div class="login-only-trusted">
    <div class="login-page"> 
    <h2>Pay with my Trusted payer account</h2>
    <p>Log in to your account to complete the purchase</p>
    <?php  if(!$this->session->userdata('customer_id')){if($this->session->flashdata('message')){ ?>   
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
</div>
</form>
<!--<div class="forget-pass"><a href="#">Forget Email Or password?</a></div>
--></div>
<?php }?>
<div class="pay-with-logo">
<img src="<?php echo base_url();if($company_logo=='') {echo "images/no_image.gif";}else {echo $company_logo;}?>" />
</div>
</div>

</div>
</div>

</div>




</body>
</html>

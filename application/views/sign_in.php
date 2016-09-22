<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
 <?php if($this->session->flashdata('message')){ ?>   
                <div class="alert alert-success">
                    <a class="close" data-dismiss="alert" href="#">x</a>
                    <h4 class="alert-heading">Success:</h4>
                    <?php echo $this->session->flashdata('message'); ?>                
                    
                </div>
			<?php }?>
 <?php echo form_open('') ?>

<h3>Sign in</h3>

 Email Address or Member ID:
<input size="25%" type="text" id="xloginemail" acjs="email" name="email" maxlength="100%" value="" tabindex="2" class="login-input">
Password:
<input size="25%" type="password" id="xloginPasswordId" acjs="password" name="password" maxlength="100%" value="" tabindex="2" class="login-input">

<button class="xman_buttonDPL" value="submit"  type="submit">Sign in</button>
<?php if(isset($_GET['id'])){?>
<input type="hidden" name="api_key" value="<?php echo $_GET['id'];?>" />
<?php if(isset($_GET['redirect'])){?>
<input type="hidden" name="api_redirect" value="<?php echo $_GET['redirect'];?>" />
<?php }}else{?>
				<?php if($redirect==''){?>
                
                <select name="redirect" style="width: 95%;margin: 15px 0;" >
                <option value="dashboard">start with My Account</option>
                <option value="balance_manager">start with Deposit</option>
                <option value="history">start with History</option>
                <option value="profile">start with Profile</option>
                <option value="order/order_list">start with Send Payment</option>
                <option value="order/recived_order_list">start with Request Payment</option>
               <!-- <option value="membership">start with Quick Settler</option>
                <option value="membership">start with Create Invoices</option>
                <option value="rfq">start with My Invoices</option>
                <option value="message_center">start withInvoicing Tools</option>-->
                </select>
                <?php }else{?>
                <input type="hidden" name="redirect" value="<?php echo $redirect;?>" />
                
                <?php }?>
<?php }?>

</form>

</body>
</html>
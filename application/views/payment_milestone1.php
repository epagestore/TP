<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style>
.btn{
	border: 1px solid gray;
background: gray;
padding: 3px;
text-decoration: none;
color: white;
border-radius: 6px;
box-shadow: 2px 2px 4px gray;
}
</style>
</head>

<body>
 <?php echo validation_errors(); ?>
Name : <?php echo $name;?><br />
Product : <?php echo $product_desc;?><br />
Quantity : <?php echo $quantity;?><br />
Total amount : <?php echo $total_amount;?><br />
<?php if(isset($milestone) || $suffi_balance){?>
	<?php echo form_open('order/milestone_payment?'.$_SERVER['QUERY_STRING'])?>
    <input type="hidden" value="<?php echo $_GET['id']?>" name="key">
    <?php if(isset($milestone)){?>
    <br />
   <div id="milestone" > First milestone : <input type="text" name="first_milestone" value="<?php echo $milestone?>" /></div><br />
   <?php }?>
    <input type="submit" name="submit" value="submit" />
    <a class="btn" href="<?php echo urldecode($cancel);?>">Cancel</a>
    </form>
<?php }else{?>
Sorry You have insufficient balance!
	<br /><br /><a class="btn" href="<?php echo base_url();?>index.php/order/deposit_amount?<?php echo $_SERVER['QUERY_STRING'];?>">Deposit amount</a>
	<a class="btn" href="<?php echo urldecode($cancel);?>">Cancel</a>
<?php }?>
</body>
</html>
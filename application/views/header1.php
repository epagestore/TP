<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style>
	.top-header ul li a{
		text-decoration:none;
		color:inherit;
	}
	.top-header ul li{
		display:inline;
		background: rgb(74, 77, 148);
		box-shadow: 2px 2px 9px inset;
		padding:10px;
		font-weight:700;
		color:white;
		cursor:pointer;
	}
	.top-header ul li.selected{
		background:rgb(248, 248, 248);
		color:gray;
	}
	.blue-line{
		background:blue;
		width:100%;
	}
	.dashboard-header ul li{
		display:inline;
		padding:10px;
		cursor:pointer;
	}
</style>
<script type="text/javascript" src="<?php echo base_url();?>js/jquery-1.9.1.min.js"></script>
 <script type='text/javascript' src='<?php echo base_url();?>js/picnet.table.filter.min.js'></script>
</head>

<body>
<div class="top-header">
    <?php /*?><ul>
    	<li style="border-radius:10px 0 0 10px"><?php if($this->session->userdata('customer_id')){?><a href="<?php echo base_url();?>index.php/sign_out">LOGOUT</a><?php }else{?><a href="<?php echo base_url();?>index.php/sign_in">Sign In</a><? }?></li>
        <li><a href="<?php echo base_url();?>index.php/dashboard">Dashboard</a></li>
        <li><a href="<?php echo base_url();?>index.php/profile">Profile</a></li>
        <li><a href="<?php echo base_url();?>index.php/balance_manager">Finance</a></li>
    	
     </ul><?php */?>
     <ul>
     	<li style="border-radius:10px 0 0 10px"><?php if($this->session->userdata('customer_id')){?><a href="<?php echo base_url();?>index.php/sign_out">LOGOUT</a><?php }else{?><a href="<?php echo base_url();?>index.php/sign_in">Sign In</a><? }?></li>
     	<li ><a href="<?php echo base_url();?>index.php/dashboard">My Account</a></li>
        <li><a href="<?php echo base_url();?>index.php/order/order_list">Send Payment</a></li>
        <li><a href="<?php echo base_url();?>index.php/order/recived_order_list">Request Payment</a></li>
        
     </ul>
</div>
<div class="bule-line">
</div>

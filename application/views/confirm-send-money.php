<?php include("inner_menu.php");?>
<div class="seperator">
</div>
<section class="container">
<div class="col-md-offset-3 col-md-6">
<?php //print_r($details);?>
<?php if(isset($page)){?>
<h3 style="color:red "  class="text-center panel"><?php echo $page;?></h3>
<?php }else{?>
<div class="main_send_money_form panel " style="margin:0px auto;">
<div class="main_send_dgn panel-body" style="float:none; margin-top:3%;">
<div style="width: 100%; margin-bottom: 2%; border-bottom: 1px solid #e2e2e2;padding-bottom: 2%;">
To Recive amount: <span style="margin-left:3%;"><b><?php echo $currency_symbol;?><?php echo sprintf("%.2f", ($details[0]['amount'])*$value); ?></b></span></div>


<form method="post">
<span style="color:#000;"> Enter Key provided by : </span><span style=" margin-left:10px;"><?php echo $details[0]['sender_name']?></span>
<div style="width:320px;">
 <input type="text" name="key" class="form-control pull-left" style="padding:5px; width:80%;" />
 <input type="submit" value="ok"  class="btn conti_send_btn btn-danger pull-right" style="" />
 </div>
<?php if(isset($error)){ ?>
	<h3 style="color:red"><?php echo $error;?></h3>
<?php }?>
</form>
</div>
</div>
<?php }?>
</div>
</section>
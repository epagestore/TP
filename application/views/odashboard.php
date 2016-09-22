<style>
.data-line{
	width: 14.2%;
float: left;
padding-left: 10px;
text-align: left;
}
</style>
<?php include("inner_menu.php");?>
<div class="table-details">
<div class="table-layout">
<div class="welcom-note">
<?php /*?><h2>Welcome <?php echo $this->session->userdata('first_name')?>,</h2>
<span>Your Current Balance is: <?php echo $balance['amount'];?></span><?php */?>
<!--<span style="color:red;">Total Payment in-process : <?php echo $pending_amount;?><br></span>-->
</div>

<h2 style="text-align: left;float: left;margin-top: 0px;font-size:20px;"> Overview</h2>
<div class="design-tab-bar">
<div class="tbl-hdr">
<!--div class="data-line"> Sr.No</div-->
<div class="data-line"> Transaction Id</div>
<div class="data-line"> Order Id</div>
<div  class="data-line"> Vendor</div>
<div  class="data-line"> Amount</div>
<div class="data-line"> Description</div>
<div class="data-line"> Date</div>
</div>

<!--<div class="search-box">

<div class="sno-line">
<input type="text" placeholder="Search" name="" />
</div>
<div class="transaction-id">
<input type="text" placeholder="Search" name="" />
</div>
<div  class="amount-line">
<input type="text" placeholder="Search" name="" />
</div>
<div class="desrp-id">
<input type="text" placeholder="Search" name="" />
</div>
<div class="date-line">
<input type="text" placeholder="Search" name="" />

</div>
</div>-->

<?php $i=1; foreach($transactions as $transaction):?>
	<div class="inform-histroy-show">
    <!--div class="data-line"> <?php //echo $i;?></div-->
    <div class="data-line"><?php echo $transaction['transaction_id']?></div>
     <div class="data-line"><?php echo $transaction['order_id'];?>&nbsp;</div>
     <div class="data-line"><?php echo  $transaction['company_name'];?>&nbsp;</div>
    <div  class="data-line"> <?php echo $currency_symbol;?><?php echo sprintf ("%.2f", abs($transaction['amount'])*$value); ?></div>
    <div class="data-line"> <?php echo $transaction['description']?></div>
    <div class="data-line"> <?php echo  date('d M Y',strtotime($transaction['date_added']))?></div>
    </div>
<?php $i++; endforeach?>



</div>
</div>
</div>


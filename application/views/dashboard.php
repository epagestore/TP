<?php include("inner_menu.php");?>

<section class="container-fluid" style="background-color:#eef1f5;">
<div class="row">
	<div class="col-md-9 hidden">
	<h3 class="text-orange">Overview <span class="pull-right"><i class="fa fa-angle-right"></i></span></h3>
	<div class="table-responsive">
	  <table class="table ">
	<thead>
      <tr class="text-center table-hd">
        <th>Date</th>
        <th>Transaction ID</th>
       <!-- <th>Order Id</th>
        <th>Vendor</th>-->
		<th>Description</th>
		<th>Credit</th>
		<th>Debit</th>
      </tr>
    </thead>
	 <tbody>
	 <?php $i=1; foreach($transactions as $transaction):?>
      <tr>
        <td><?php echo  date('d M Y h:i A',strtotime($transaction['date_added']))?></td>
        <td><?php echo $transaction['transaction_id']?></td>
      <!--  <td><?php echo $transaction['order_id'];?>&nbsp;</td>
        <td><?php echo  $transaction['company_name'];?>&nbsp;</td>-->
        <td><?php echo $transaction['description']?></td>
        <td><?php if($transaction['amount']>0){ echo $currency_symbol;?><?php echo sprintf("%.2f", (abs($transaction['amount']))*$value); }else{ echo "-"; } ?></td>
        <td><?php if($transaction['amount']<0){echo $currency_symbol;?><?php echo sprintf("%.2f", (abs($transaction['amount']))*$value); }else{ echo "-"; }?></td>		
      </tr>
	  <?php $i++; endforeach?>
    </div></a>
    </tbody>
	  </table>
	</div>
	<span class="pull-right "><a href="<?php echo site_url('history'); ?>" class="text-sky">View All</a></span>
	</div>
	<div class="col-md-3 hidden">
	<div class="">
	<h4 class="text-orange bottom-border"> Your current Balance: <span class="pull-right"><i class="fa fa-angle-right"></i></span></h4>
	<span class="curr_bal_amt"><h1 ><img src="<?php echo base_url();?>images/loader.gif"></h1><small>Available</small></span>
	 <ul class="list-unstyled menu-link">
	 <li><a href="<?php echo site_url('balance_manager'); ?>" class="text-sky"><i class="fa fa-download"></i>Deposite to Your TrustedPayer Account</a></li>
	 <li><a href="<?php echo site_url('history'); ?>" class="text-sky"><i class="fa fa-history"></i>  Your Trancation History</a></li>
	 <li><a href="<?php echo site_url('profile'); ?>" class="text-sky"><i class="fa fa-user"></i>  Your Profile</a></li>
	 <li><a href="<?php echo site_url('despute/receive_list'); ?>" class="text-sky"><i class="fa fa-th-list"></i>  Dispute</a></li>
	 </ul>
	</div>
	
	<div class="">
	<h4 class="text-orange bottom-border"> Your Payment Method  <span class="pull-right"><i class="fa fa-angle-right"></i></span></h4>
	
	 <ul class="list-unstyled menu-link">
	 <li><a href="" class="text-gray"><i class="fa fa-university"></i>  BANK OF AMERICA,NA.x-7786</a></li>
	 <li><a href="" class="text-gray"><i class="fa fa-cc-visa"></i>  Visa x-7786  </a></li>
	 <li><a href="" class="text-gray"><i class="fa fa-cc-visa"></i>  Visa x-7786 </a></li>
	 
	 </ul>
	</div>
	
	</div>
<?php include('graph/graph.php'); ?>
</section>
<!-------------------------dfgdfg end ----!-->
<?php ?>	

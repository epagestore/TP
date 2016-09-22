<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/jquery.countdown.css"> 
<script src="<?php echo base_url();?>js/jquery.countdown.min.js"></script>
<?php include("inner_menu.php");?>
<div class="table-details">
<div class="table-layout" >
<?php //echo "<pre>"; print_r($orders)."<br>"?>
<section class="container">
<h3 class="text-orange"><?php echo $title;?></h3>
<div class="detail-block">
<?php  //echo"<pre>"; print_R($orders);exit;?>
<?php $i=0; foreach($orders as &$order):?>


<?php if(isset($transaction[$i]) && $transaction[$i]!='' && $order['order_product_status_id']==5 && $transaction[$i]['expire_time']!=''){
                    $future_datetime =  date('Y-m-d H:i:s A',strtotime("+".$transaction[$i]['complete_order_time']." ".$transaction[$i]['complete_order_unit']." ", strtotime($transaction[$i]['date_added'])));
                    $future = strtotime($future_datetime); //future datetime in seconds
                    $now_datetime = $transaction[$i]['now'];
                    $now = strtotime($now_datetime); //now datetime in seconds
        
                    //The math for calculating the difference in hours, minutes and seconds
                    $difference = $future - $now;
                    $second = 1;
                    $minute = 60 * $second;
                    $hour = 60 * $minute;
                    $difference_hours = floor($difference/$hour);
                    $remainder = $difference - ($difference_hours * $hour);
                    $difference_minutes = floor($remainder/$minute);
                    $remainder = $remainder - ($difference_minutes * $minute);
                    $difference_seconds = $remainder;
                   // echo $future_datetime;
					
                    //echo "<br>$future_datetime $difference_hours hours, $difference_minutes min and $difference_seconds sec";?>
                    <div id="counter<?php echo $i;?>" style="float:right;width:200px;margin:7px"></div>
                   
                  <script> $("#counter<?php echo $i;?>").countdown({until: new Date('<?php echo $future_datetime;?>'),serverSync: serverTime, expiryText: "<div class='over'>Time over  : <a href=''>Reload</a></div>" }); function serverTime() { return new Date('<?php echo $now_datetime;?>')}</script>
                 <?php $i++;?>
                <?php }?>

<div class="row "  >
	<div class="col-lg-12">
	<div class="table-responsive">
	
	<table class="table " >
	<thead>
      <tr class="text-center table-hd  "  >
        <th class="text-center">Date</th>
        <th class="text-center">Transaction ID</th>
        <th class="text-center"><?php echo $order['company_name'];?> Order Id :</th>
		<th class="text-center">Order Placed By</th>
		<th class="text-center">Payment from</th>
		<th class="text-center">Payment to</th>
		<th class="text-center">Amount Received</th>
      </tr>
    </thead>
	 <tbody>
      <tr class="text-center">
       
		<?php if($order['milestone_amount']!=''){?>
		<td><?php echo  date('Y-m-d H:i:s A',strtotime($order['milestone_date']));?></td>
		<td><?php echo $order['milestone_transaction_id']?></td>
		
		<?php }else {?>
		<td><?php echo  date('Y-m-d H:i:s A',strtotime($order['date_added']));?></td>
		<td><?php echo $order['transaction_id']?></td>
		<?php }?>
        
        <td><?php echo  $order['order_key'];?></td>
		<td><?php if($order['shipping_firstname']!=''){ echo $order['shipping_firstname'];}else{echo $order['payer_name'];}?>@<?php echo $order['company_name'];?>/</td>
		<td> <?php echo $order['payer_name']."@Tp (".$order['payer_email'].")";?></td>
		<td><?php echo $order['payee_name']."@Tp (".$order['payee_email'].")";?></td>
		<?php if($order['milestone_amount']!=''){?>
		<td><?php echo $currency_symbol;?><?php echo sprintf ("%.2f", $order['milestone_amount']*$value); ?></td>
		<?php }else {?>
		<td><?php echo $currency_symbol;?><?php echo sprintf ("%.2f", $order['product_amount']*$value); ?></td>
		<?php }?>
      </tr>
    </tbody>
	</table>
	
	</div>
	</div>
</div>

		<div class="row" >
		<div class="col-sm-6 blockone">
		<p><strong><?php echo $order['company_name'];?> Product Id: </strong> <?php echo isset($order['product_key'])?$order['product_key']:'';?></p>
		<p><strong>Product :</strong> <?php echo $order['product_name'];?></p>
		<p><strong>Quantity :</strong> <?php echo $order['product_quantity'];?></p>
		</div>
		<div class="col-sm-6 blockone">
		<p><strong>Business Contact Information :</strong> Detail of Business</p>
		<p><strong>Vendor URL : </strong> <?php echo $order['company_website'];?> </p>
		<p class="text-orange"><strong>Status : </strong> 
		<?php  if($order['order_product_status_id']==9){?>Despute Resolved<?php } elseif($order['order_product_status_id']==7){?>Complete order time expired<?php }else if($order['order_product_status_id']==5){?>Processing <a href="<?php echo base_url();?>index.php/despute?txn_id=<?php echo $order['product_transaction_id'];?>" >Generate Despute</a><?php } else if($order['order_product_status_id']==6){?>Completed  (Trusted payer will soon release your payment)<?php }else if($order['order_product_status_id']==2){?>Released<?php }else if($order['order_product_status_id']==8){?>Despute<?php }else{?>Paid </td></tr>
		<td></td><td class="color_text"><?php if($order['is_milestone']=='0'){?><a style="color:blue;text-decoration:underline;" href="<?php echo base_url();?>index.php/despute?txn_id=<?php echo $order['product_transaction_id'];?>" >Issue a refund</a><?php } }?>
		</p>
		</div>
		</div>
	
	<?php $i++; endforeach;?>

</div>	



	

<!-- Modal -->


</section>
</div>

<!--table style="color:black; float:left; width:56%;">

<?php $i=0; foreach($orders as $order):?>
<tr>
<td>
<table class="order_details_page">

			<?php if(isset($transaction[$i]) && $transaction[$i]!='' && $order['order_product_status_id']==5 && $transaction[$i]['expire_time']!=''){
                    $future_datetime =  date('Y-m-d H:i:s A',strtotime("+".$transaction[$i]['complete_order_time']." ".$transaction[$i]['complete_order_unit']." ", strtotime($transaction[$i]['date_added'])));
                    $future = strtotime($future_datetime); //future datetime in seconds
                    $now_datetime = $transaction[$i]['now'];
                    $now = strtotime($now_datetime); //now datetime in seconds
        
                    //The math for calculating the difference in hours, minutes and seconds
                    $difference = $future - $now;
                    $second = 1;
                    $minute = 60 * $second;
                    $hour = 60 * $minute;
                    $difference_hours = floor($difference/$hour);
                    $remainder = $difference - ($difference_hours * $hour);
                    $difference_minutes = floor($remainder/$minute);
                    $remainder = $remainder - ($difference_minutes * $minute);
                    $difference_seconds = $remainder;
                   // echo $future_datetime;
					
                    //echo "<br>$future_datetime $difference_hours hours, $difference_minutes min and $difference_seconds sec";?>
                    <div id="counter<?php echo $i;?>" style="float:right;width:200px;margin:7px"></div>
                   
                  <script> $("#counter<?php echo $i;?>").countdown({until: new Date('<?php echo $future_datetime;?>'),serverSync: serverTime, expiryText: "<div class='over'>Time over  : <a href=''>Reload</a></div>" }); function serverTime() { return new Date('<?php echo $now_datetime;?>')}</script>
                 <?php $i++;?>
                <?php }?>
      <?php if(0){?>
      <tr>
        <td>Unique Transaction Id : </td><td class="color_text"> <?php echo $order['transaction_id']?></td>
     </tr>
     <?php }?>
     <tr>
        <td>
        Order placed By : </td><td class="color_text"> <?php if($order['shipping_firstname']!=''){ echo $order['shipping_firstname'];}else{echo $order['payer_name'];}?>@<?php echo $order['company_name'];?>/ </td>
     </tr>
     <tr>
        <td>
        Payment from : </td><td class="color_text"> <?php echo $order['payer_name']."@Tp (".$order['payer_email'].")";?></td>
     </tr>
     <tr>
        <td>
        Payment to : </td><td class="color_text"> <?php echo $order['payee_name']."@Tp (".$order['payee_email'].")";?></td>
     </tr> 
     <tr>
       <td colspan="2"><hr></td>
     </tr>
      <tr>
        <td>
        Business Contact Information : </td>
      </tr>
      <tr>
        <td>
        Vendor URL :</td><td class="color_text"> <?php echo $order['company_website'];?></td>
      </tr>
     <tr>
       <td colspan="2"><hr></td>
     </tr>
     <tr>
        <td>
        Amount Received :</td><td class="color_text"> <?php echo $currency_symbol;?><?php echo sprintf ("%.2f", $order['total_amount']*$value); ?></td>
       </tr>
       <tr>
       <td colspan="2"><hr></td>
     </tr>
      
     <tr>
        <td>
        Date : </td><td class="color_text"> <?php echo  date('Y-m-d H:i:s A',strtotime($order['date_added']));?></td>
      </tr>
      <tr>
       <td>  <?php echo $order['company_name'];?> Order Id : </td><td class="color_text"> <?php echo  $order['order_key'];?></td>
     </tr>
     <?php if($order['shipping_method']!=''){?>
     <tr>
       <td>  Shipping method : </td><td class="color_text"> <?php echo  $order['shipping_method'];?></td>
     </tr>
     <?php }?>
     
	<?php if($i==0){?>
    <tr>
       <td colspan="2"><hr></td>
     </tr>
    <tr>
        <td>
        Unique transaction ID : </td><td class="color_text"> <?php echo $order['product_transaction_id'];?></td>
   	</tr>
    <tr>
       <td> <?php echo $order['company_name'];?> Product ID : </td><td class="color_text"> <?php echo  $order['product_key'];?></td>
     </tr>
    <tr>
        <td>
        Status : </td><td class="color_text"> <?php  if($order['order_product_status_id']==9){?>Despute Resolved<?php } elseif($order['order_product_status_id']==7){?>Complete order time expired<?php }else if($order['order_product_status_id']==5){?>Processing <a href="<?php echo base_url();?>index.php/despute?txn_id=<?php echo $order['product_transaction_id'];?>" >Generate Despute</a><?php } else if($order['order_product_status_id']==6){?>Completed  (Trusted payer will soon release your payment)<?php }else if($order['order_product_status_id']==2){?>Released<?php }else if($order['order_product_status_id']==8){?>Despute<?php }else{?>Paid </td></tr>
    <tr><td></td><td class="color_text"><?php if($order['is_milestone']=='0'){?><a style="color:blue;text-decoration:underline;" href="<?php echo base_url();?>index.php/despute?txn_id=<?php echo $order['product_transaction_id'];?>" >Issue a refund</a><?php } }?></td>
    </tr>
    <tr>
        <td>
        Product : </td><td class="color_text"> <?php echo $order['product_name'];?></td>
    </tr>
  	<tr>
        <td> 
        Amount : </td><td class="color_text"> <?php echo $currency_symbol;?><?php echo sprintf ("%.2f", $order['product_amount']*$value); ?></td>
    </tr>
   <tr>
        <td>
        Quantity : </td><td class="color_text"> <?php echo $order['product_quantity'];?></td>
   </tr>
        
    <?php }else{?>
    
      <tr>
       <td colspan="2"><hr></td>
     </tr>
      <tr>
        <td>
        Unique transaction ID : </td><td class="color_text"> <?php echo $order['product_transaction_id'];?></td>
      </tr>
       <tr>
       <td> Product Key : </td><td class="color_text"> <?php echo  $order['product_key'];?></td>
     </tr>
      <tr>
        <td>
        Status : </td><td class="color_text"> <?php  if($order['order_product_status_id']==9){?>Despute Resolved<?php } elseif($order['order_product_status_id']==7){?>Complete order time expired<?php }else if($order['order_product_status_id']==5){?>Processing <a href="<?php echo base_url();?>index.php/despute?txn_id=<?php echo $order['product_transaction_id'];?>" >Generate Despute</a><?php } else if($order['order_product_status_id']==6){?>Completed  (Trusted payer will soon release your payment)<?php }else if($order['order_product_status_id']==2){?>Released<?php }else if($order['order_product_status_id']==8){?>Despute<?php }else{?>Paid </td></tr>
        <tr><td></td><td class="color_text"><?php if($order['is_milestone']=='0'){?><a style="color:blue;text-decoration:underline;" href="<?php echo base_url();?>index.php/despute?txn_id=<?php echo $order['product_transaction_id'];?>" >Issue a refund</a><?php } }?></td>
     </tr> 
     <tr>
        <td> 
        Product : </td><td class="color_text"> <?php echo $order['product_name'];?></td>
     </tr>
     <tr>
        <td>
        Amount : </td><td class="color_text"> <?php echo $currency_symbol;?><?php echo sprintf ("%.2f", $order['product_amount']*$value); ?></td>
     </tr>
      <tr>
        <td>
        Quantity : </td><td class="color_text"> <?php echo $order['product_quantity'];?></td>	
       </tr>
    <?php }?>
    </table>
      </td>
      </tr>
    
<?php $i++; endforeach;?>
	<tr>
        <td style="text-align:left;margin-top:10px;"><a style="margin-left:9px" class="orange-btn" href="<?php echo base_url();?><?php echo $back;?>"><< BACK</a></td>	
        <td></td>
       </tr>

</table-->
</div>
</div>
<?php include("inner_menu.php");?>

<style>

	


thead tr{
	color:#323232;

}
thead tr th{
	padding:10px;
}
tbody tr{
	padding:5px;

}
tbody tr{
	background:#fff;
	 font-size: 14px;
	
}
#details{
	color:black;
	background: rgb(151, 151, 151);
padding: 1px 5px;
border-radius: 5px;
box-shadow: 2px 4px 4px rgb(199, 199, 199) inset;
}
.btn btn-danger btn-lg:hover{
	color:white;
}
.orange-btn-complain {
box-shadow: 21px 7px 31px orange inset;
background: orange;
color: white;
padding: 7px 22px;
border-radius: 4px;
display: inline-block;
margin-bottom: 10px;
}
.btn btn-danger btn-lg{
	box-shadow:21px 7px 31px #ff0000 inset;
	background: red;
	color: white;
	padding: 7px 24px;
	border-radius: 2px;
	display: inline-block;
	margin-bottom: 10px;
}
.btn btn-danger btn-lg.disabled {
	opacity:0.3;
	cursor:default;
}
#details:hover{
	background: rgb(199, 199, 199);
	box-shadow: 2px 4px 4px rgb(151, 151, 151) inset;
}
.extra_border{
  background:white; box-shadow:0px -1px 0px 0px #1996E6;
   -webkit-box-shadow:0px -1px 0px 0px #1996E6;
  
}
.clickable{cursor: pointer; display:none;}
@media screen and (-webkit-min-device-pixel-ratio:0) {
.extra_border{
  background:white; 
  /* Safari 5.1, Chrome 10+ */
  background: -webkit-linear-gradient(top, #ffffff 90%, #dddddd);

  /* Firefox 3.6+ */
  background: -moz-linear-gradient(top, #ffffff 90%, #dddddd);

  /* IE 10 */
  background: -ms-linear-gradient(top, #ffffff 90%, #dddddd);

  /* Opera 11.10+ */
  background: -o-linear-gradient(top, #ffffff 90%, #dddddd);
}
}

.collapse {
    transition: height 0.6s;
}
td{border-top:1px solid #286090;"}


.table > tbody > tr > td, .table > tbody > tr > th, .table > tfoot > tr > td, .table > tfoot > tr > th, .table > thead > tr > td, .table > thead > tr > th{border-top:1px solid #286090 !important; }


</style>
<section class="container">
<div class="row">
	<div class="col-sm-12" style="min-height:400px;">
	<h3 class="text-orange bottom-margin">Orders</h3>
<div class="table-responsive">



<table class="table dataTable " id="tab" >
<thead >
<!--
<tr class="text-center table-hd " style=" border-bottom: 2px solid #0082c8;">

<th colspan="5" style=" border-bottom: 2px solid #0082c8;" > </th>
<th style=" border-bottom: 2px solid #0082c8;" > </th>
<th colspan="4" class="text-center " style="color: #fff; border-bottom: 2px solid #0082c8; " >Order Summary</th>
<th style=" border-bottom: 2px solid #0082c8;"></th>
</tr>-->
<tr class="text-center table-hd" style="border-top: 1px solid #0082c8;">
	<!--<th>Secret Key</th>-->
	<!--th>Key </th!-->
	<th style="border-top: 1px solid #0082c8;">Date</th>
    <th style="border-top: 1px solid #0082c8;">Payment ID</th>
	<th style="border-top: 1px solid #0082c8;">Vendor</th>    
    <th style="border-top: 1px solid #0082c8;">Payment To</th>
    <th style="border-top: 1px solid #0082c8;">Vendor ID</th>
     <!--<th>name</th>-->
     <th style="border-top: 1px solid #0082c8;">Total Amount</th>
     <th class="" style="border-top: 1px solid #0082c8;"><?php if($milestone==1){?>Milestone Date<?php }else{?><?php }?></th>
	 <th class=""  style="border-top: 1px solid #0082c8; "><?php if($milestone==1){?>No of Milestones<?php }else{?>No of <?php echo $milestone==2?'Items':"Product";}?></th>	
     <th class="" style="border-top: 1px solid #0082c8; "></th>
    
</tr>
	 
</thead>
<tbody style="color:black;">
<?php $cord=0; $mileston = array(); foreach($orders as $order):?>
	
    <?php
		if($order['milestone_amount'])
		{
			if(in_array($order['milestone_transaction_id'],$mileston))
				continue;
			else
			$mileston[] = $order['milestone_transaction_id'];
		}	
	?>
    	<?php if($cord!=$order['order_id']){ $cord=$order['order_id'];?>
   		
    	<tr class="text-center  ld" id="<?php echo $order['order_id'];?>">
             <!--td><?php echo $order['payer_code']?></td!-->
        	 <!--<td><?php if($order['order_status_id']!=6){?>paid<?php /*?><a href="<?php echo base_url();?>index.php/order/complete_order/<?php echo $order['order_id']?>">Complete Order</a><?php */?><?php }else{?>Completed<?php }?></td>-->
            <td style=" padding-top:15px; border-top:1px solid #286090 !important;  "><?php echo  date('M jS Y',strtotime($order['date_added']));?><br /><div style="font-size:11px; text-align:left; margin-left:23px;"><?php echo  date('g:i A',strtotime($order['date_added']));?></div></td>
            <td style="border-top:1px solid #286090 !important; "><?php echo $order['order_id']?></td>
             <td style="border-top:1px solid #286090 !important; "><?php echo $order['company_name']?></td>
			 <td style="border-top:1px solid #286090 !important; "><?php echo str_replace("@","<br>@",$order['payee_email']);?></td>
            <td style="border-top:1px solid #286090 !important; "><?php echo $order['order_key']?></td>
            <!--<td><?php echo $order['transaction_id']?></td>-->
            <!--<td><?php echo $order['shipping_firstname']." ".$order['shipping_lastname']?></td>-->
            <td style="padding-left:10px; border-top:1px solid #286090 !important; "><?php echo $currency_symbol;?><?php echo sprintf("%.2f", ($order['total_amount'])*$value); ?></td>
            <?php if($order['milestone_amount']){?>
			<td class="first" style=" border-top:1px solid #286090 !important; "><span><?php echo  date('M jS Y',strtotime($order['milestone_added']));?></span></td>       <td class="first" style=" border-top:1px solid #286090 !important; "><?php echo $order['counter'];?></td>     
      		<?php /*?> <td class="first" style=" border-top:1px solid #286090 !important; "><span><?php echo $currency_symbol;?><?php echo sprintf("%.2f", ($order['milestone_amount'])*$value); ?></span></td>
			 
      		 <td class="first"><span><?php if($order['milestone_status']=='1'){?>Paid <?php }else if($order['milestone_status']=='2'){?>Released <?php }else  if($order['milestone_status']=='5'){?>Processing<?php } else  if($order['milestone_status']=='8'){?>Dispute<?php }else { echo "Complete";}?></span></td>
           <td>Txn#</td><?php */?>
            
			<!--<td>Secret Key</td>-->
			<?php /*
             <td class="text-left  " style=" border-top:1px solid #286090 !important; "><a class="btn btn-success btn-lg " href="<?php echo  base_url();?>index.php/order/placed_details/<?php echo  $order['order_id'];?>"><i class="fa fa-eye"></i></a><a class="text-orange wel-text pluse-btn clickable" data-toggle="collapse" id="<?php echo $order['order_id'];?>"  data-target=".<?php echo $order['order_id'];?>"><i class="fa fa fa-search-plus" id="icon_<?php echo $order['order_id'];?>"></i></a></td> 
			*/ ?>
			 <td class="text-left  " style=" border-top:1px solid #286090 !important; "><a class="btn btn-success view_mlileston_detail" dt="milestone" data="<?php echo $order['milestone_id'];?>" data-id="<?php echo $order['order_id'];?>" ><i class="fa fa-plus"></i></a><a class="text-orange wel-text pluse-btn clickable" data-toggle="collapse" id="<?php echo $order['order_id'];?>"  data-target=".<?php echo $order['order_id'];?>"><i class="fa fa fa-search-plus" id="icon_<?php echo $order['order_id'];?>"></i></a></td>
			 
            <?php }else{?>
			<td class="first" style=" border-top:1px solid #286090 !important; "></td>
           <?php /*?>  <td  class="first" style=" border-top:1px solid #286090 !important; "><span><?php echo $order['product_name']?></span></td>            
           <td>Txn#</td>
            <td class="first" style=" border-top:1px solid #286090 !important; "><span><?php echo $currency_symbol;?><?php echo sprintf("%.2f", ($order['product_amount'])*$value); ?></span></td><?php */?>
			<td class="first" style=" border-top:1px solid #286090 !important; "><?php echo $order['counter']; ?></td>
			
             <?php /* <td class="first"style=" border-top:1px solid #286090 !important; " ><span><?php  if($order['order_product_status_id']==9){?>Dispute Resolved<?php } else if($order['order_product_status_id']==7){?>Complete order time expired<?php }elseif($order['order_product_status_id']==5){?>Processing <?php } else if($order['order_product_status_id']==6){?>Completed<?php }else if($order['order_product_status_id']==2){?>Released<?php }else if($order['order_product_status_id']==8){?>Dispute<?php }else{?>Paid <?php }?></span></td>
			
            <td class="text-left" style="border-top: 1px solid #286090; "><a class="btn btn-success btn-lg" href="<?php echo  base_url();?>index.php/order/placed_details/<?php echo  $order['order_id'];?>"><i class="fa fa-eye"></i></a><a class="text-orange wel-text pluse-btn clickable" data-toggle="collapse" id="<?php echo $order['order_id'];?>"  data-target=".<?php echo $order['order_id'];?>"><i class="fa fa fa-search-plus" id="icon_<?php echo $order['order_id'];?>"></i></a></td>
			*/ ?>
			<td class="text-left" style="border-top: 1px solid #286090; "><a class="btn btn-success  view_mlileston_detail" data="<?php echo $order['order_product_id'];?>" data-id="<?php echo $order['order_id'];?>" ><i class="fa fa-plus"></i></a><a class="text-orange wel-text pluse-btn clickable" data-toggle="collapse" id="<?php echo $order['order_id'];?>"  data-target=".<?php echo $order['order_id'];?>"><i class="fa fa fa-search-plus" id="icon_<?php echo $order['order_id'];?>"></i></a></td>
            <?php }?>
        </tr>
		<?php if($order['milestone_amount']){?>
        <tr  class="collapse <?php echo $order['order_id'];?> animated fadeInDown" style="background:none!important;" >
        	<td colspan="6"><a  class="btn btn-warning view_mlileston_detail" dt="milestone" data="<?php echo $order['milestone_id'];?>" data-id="<?php echo $order['order_id'];?>">View Milestone Detail<a></td>
         <!--  <td ><span style='display:none'><?php echo $order['payee_code']?></span></td>
            <!--<td ><span style='display:none'><?php if($order['order_status_id']!=6){?>paid<?php }else{?>Completed<?php }?></span></td>-->
           <!-- <td ><span style='display:none'><?php echo $order['order_id']?></span></td>
            <td><span style='display:none'><?php echo $order['shipping_firstname']." ".$order['shipping_lastname']?></span></td>
           <!-- <td ><span style='display:none'><?php echo $order['order_key']?></span></td>-->
          <!--  <td ><span style='display:none'><?php echo $currency_symbol;?><?php echo sprintf("%.2f", ($order['total_amount'])*$value); ?></span></td>  -->          
             <td><?php echo  date('M jS Y',strtotime($order['milestone_added']));?></td>
             <td><?php echo $order['milestone_description'];?></td>
           <?php /*?><td><?php echo $order['milestone_transaction_id'];?></td><?php */?>
            <td><?php echo $currency_symbol;?><?php echo sprintf("%.2f", ($order['milestone_amount'])*$value); ?></td>
            <td> <?php if($order['milestone_status']=='1'){?>Paid <?php }else if($order['milestone_status']=='2'){?>Released <?php }else  if($order['milestone_status']=='5'){?>Processing<?php } else  if($order['milestone_status']=='8'){?>Dispute<?php }else { echo "Complete";}?></td>
			<!--<td><?php echo $order['milestone_payer_code'];?></td>-->
             <td class="text-left"><?php  if($order['milestone_status']==1 || $order['milestone_status']==5){?><a class="<?php if($order['milestone_status']==5) echo "btn btn-warning ";else echo "btn btn-danger ";?>" href="<?php echo base_url();?>index.php/despute?txn_id=<?php echo $order['milestone_transaction_id'];?>" ><i class="fa fa-exclamation-triangle"></i></a><?php }else{?><a class="btn btn-danger  disabled"  ><i class="fa fa-exclamation-triangle"></i></a><?php }?></td>
			 
        </tr>
        <?php }else{?>
        <tr class="collapse <?php echo $order['order_id'];?>  animated fadeInDown" style="background:none!important" >
        	<td colspan="6"> <a  data="<?php echo $order['order_product_id'];?>" data-id="<?php echo $order['order_id'];?>" class="btn btn-warning view_mlileston_detail" >View Product Detail</a></td>
			<td></td>
         <!--  <td ><span style='display:none'><?php echo $order['payer_code']?></span></td>
           <!-- <td ><span style='display:none'><?php if($order['order_status_id']!=6){?>paid<?php }else{?>Completed<?php }?></span></td>-->
         <!--   <td ><span style='display:none'><?php echo $order['order_id']?></span></td>
            <td><span style='display:none'><?php echo $order['shipping_firstname']." ".$order['shipping_lastname']?></span></td>
            <td ><span style='display:none'><?php echo $order['order_key']?></span></td>
            <td ><span style='display:none'><?php echo $currency_symbol;?><?php echo sprintf("%.2f", ($order['total_amount'])*$value); ?></span></td> -->
            	<td ><?php echo $order['product_name']?> </td>
            	<?php /*?><td ><?php echo $order['product_transaction_id']?> </td><?php */?>
                <td><?php echo $currency_symbol;?><?php echo sprintf("%.2f", ($order['product_amount'])*$value); ?></td>
                 <?php /*?><td><?php echo $order['product_payee_code']?></td><?php */?>
                <td><?php  if($order['order_product_status_id']==9){?>Dispute Resolved<?php } else if($order['order_product_status_id']==7){?>Complete order time expired<?php }elseif($order['order_product_status_id']==5){?>Processing <?php } else if($order['order_product_status_id']==6){?>Completed<?php }else if($order['order_product_status_id']==2){?>Released<?php }else if($order['order_product_status_id']==8){?><a href="<?php echo base_url();?>index.php/despute/negotiate/<?php echo $order['despute_id']?>">Dispute</a><?php }else{?>Paid <?php }?></td>
               <td class="text-left"><?php  if($order['order_product_status_id']==1 || $order['order_product_status_id']==5){?><a class="<?php if($order['order_product_status_id']==5) echo "btn btn-warning ";else echo "btn btn-danger ";?>" href="<?php echo base_url();?>index.php/despute?txn_id=<?php echo $order['product_transaction_id'];?>" ><i class="fa fa-exclamation-triangle"></i></a><?php }else{?><a class="btn btn-danger  disabled"  ><i class="fa fa-exclamation-triangle"></i></a><?php }?></td>
                </tr>
            <?php }}else{?>
         <tr class="collapse <?php echo $order['order_id'];?> animated fadeInDown" id="<?php echo $order['order_id'];?> ">
         	<?php if($order['milestone_amount']){?>
        	<td colspan="6"><a  class="btn btn-warning view_mlileston_detail" dt="milestone" data="<?php echo $order['milestone_id'];?>" data-id="<?php echo $order['order_id'];?>">View Milestone Detail<a></td>
			<?php }else{?>
			<td colspan="6"><a  class="btn btn-warning view_mlileston_detail"  data="<?php echo $order['order_product_id'];?>" data-id="<?php echo $order['order_id'];?>">View Product Detail<a></td>
			<?php }?>
         	
         	<?php /*?><td ><span style='display:none'><?php echo $order['payer_code']?></span></td><?php */?>
           <!-- <td ><span style='display:none'><?php if($order['order_status_id']!=6){?>paid<?php }else{?>Completed<?php }?></span></td>-->
          <!--  <td ><span style='display:none'><?php echo $order['order_id']?></span></td>
            <td ><span style='display:none'><?php echo $order['shipping_firstname']." ".$order['shipping_lastname']?></span></td>
            <td ><span style='display:none'><?php echo $order['order_key']?></span></td>
            <td ><span style='display:none'><?php echo $currency_symbol;?><?php echo sprintf("%.2f", ($order['total_amount'])*$value); ?></span></td>-->
            <?php if($order['milestone_amount']){?>
             
           <td><?php echo  date('M jS Y',strtotime($order['milestone_added']));?></td>
             <td><?php echo $order['milestone_description'];?></td>
          <?php /*?>   <td><?php echo $order['milestone_transaction_id'];?></td><?php */?>
            <td><?php echo $currency_symbol;?><?php echo sprintf("%.2f", ($order['milestone_amount'])*$value); ?></td>
            <td> <?php if($order['milestone_status']=='1'){?>paid<?php }else if($order['milestone_status']=='2'){?>Released <?php }else  if($order['milestone_status']=='5'){?>Processing<?php } else { echo "Complete";}?></td>
        	<!--<td><?php echo $order['milestone_payer_code'];?></td>-->
            <td class="text-left"><?php  if($order['milestone_status']==1 || $order['milestone_status']==5){?><a class="<?php if($order['milestone_status']==5) echo "btn btn-warning ";else echo "btn btn-danger ";?>" href="<?php echo base_url();?>index.php/despute?txn_id=<?php echo $order['milestone_transaction_id'];?>" ><i class="fa fa-exclamation-triangle"></i></a><?php }else{?><a class="btn btn-danger  disabled"  ><i class="fa fa-exclamation-triangle"></i></a><?php }?></td>
            <?php }else{?>
			<td></td>
          		<td ><?php echo $order['product_name']?> </td>
            	<?php /*?><td><?php echo $order['product_transaction_id']?> </td><?php */?>
                <td><?php echo $currency_symbol;?><?php echo sprintf("%.2f", ($order['product_amount'])*$value); ?></td>
                <?php /*?><td><?php echo $order['product_payee_code']?></td><?php */?>
               <td><?php  if($order['order_product_status_id']==9){?>Dispute Resolved<?php } elseif($order['order_product_status_id']==7){?>Complete order time expired<?php }else if($order['order_product_status_id']==5){?>Processing <?php } else if($order['order_product_status_id']==6){?>Completed<?php }else if($order['order_product_status_id']==2){?>Released<?php }else if($order['order_product_status_id']==8){?><a href="<?php echo base_url();?>index.php/despute/negotiate/<?php echo $order['despute_id']?>">Dispute</a><?php }else{?>Paid <?php }?></td>
                <td class="text-left"><?php  if($order['order_product_status_id']==1 || $order['order_product_status_id']==5){?><a class="<?php if($order['order_product_status_id']==5) echo "btn btn-warning ";else echo "btn btn-danger ";?>" href="<?php echo base_url();?>index.php/despute?txn_id=<?php echo $order['product_transaction_id'];?>" ><i class="fa fa-exclamation-triangle"></i></a><?php }else{?><a class="btn btn-danger  disabled"  ><i class="fa fa-exclamation-triangle"></i></a><?php }?></td>
            <?php } ?>
            
        </tr>
        <?php }?>
 		
<?php endforeach?>
 </tbody>
 <tfoot>
				<!--<tr><td colspan="11" class="text-center  btn-primary btn-sm" id="loadMore">Loadmore..</td></tr>-->
			</tfoot>
</table>

</div>
	
	</div>
	<div class="col-sm-12">
		
			<div class="btn-primary  text-center btn-lg" id="loadMore">Loadmore...</div>
		
	</div>
	</div>
	</div>
	
	
<button data-toggle="modal" data-target="#myModal" class="hidden" id="popen"></button>	
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-dialog-new " role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title text-orange" id="myModalLabel">Auto Body Repair</h4>
      </div>
      <div class="modal-body">
      <div class="product_view" style="display:none">
		<div class="row ">
			<div class="col-sm-12 ">
			<div class="table-responsive">
			  <table class="table ">
			<thead>
			  <tr class="text-center table-hd">
				<th class="text-center">Date</th>
				<?php if($milestone==1){?>
				<th class="text-center">Milestone ID</th>
				<?php } else{?>
				<th class="text-center">Product ID</th>
				<?php }?>
				<th class="text-center order_m_order_id" ><?php echo isset($orders[0]['company_name'])?$orders[0]['company_name']:''; ?> order ID</th>
				<th class="text-center">Order Placed By</th>
				<th class="text-center">Payment from</th>
				<th class="text-center">Payment to</th>
				<th class="text-center">Amount Paid</th>
			  </tr>
			</thead>
			 <tbody>
			  <tr class="text-center">
				<td id='add_date'>2016-02-24 <br> 15:27:16 PM</td>
				<td id="mileston_id">0</td>
				<td id="orderid"></td>
				<td id="first_name"></td>
				<td id="payee_email">vishal epe@Tp (vishal@epagestore.com)</td>
				<td id="payer_email">manish@Tp (manish@epagestore.com)</td>
				<td id="milestone_amount">Rs.359900.00</td>
			  </tr>
			 
			</tbody>
			</table>
			</div>
			</div>
		</div>
		<div class="row">
		<div class="col-sm-6 blockone">
		
		
		<p id="product_id"><strong>Product ID:  </strong> </p>
		<p id="product_name"><strong>Product : </strong> Auto Body Repair </p>
		<p id="quantity"><strong>Quantity : </strong> 1</p>
		
		
		</div>
		<div class="col-sm-6 blockone">
		<p><strong>Business Contact Information : </strong> Detail of Business</p>
		<p id="company_url"><strong>Vendor URL : </strong> dealmaker.com </p>
		<p class="text-orange" id="status"><strong>Status : </strong> Paid </p>
		</div>
		</div>
</div>

 <div class="milestone_view"  style="display:block">
		<div class="row ">
			<div class="col-sm-12 ">
			<div class="table-responsive">
			  <table class="table ">
			<thead>
			  <tr class="text-center table-hd">
				<th class="text-center">milestone #</th>
				<th class="text-center">Milestone Name</th>
				<th class="text-center">Milestone Amount</th>
				<th class="text-center">Date</th>
				<th class="text-center">Status</th>
				<th class="text-center">Complain</th>
				<th class="text-center">Amount Paid</th>
			  </tr>
			</thead>
			 <tbody>
			  <tr class="text-center">
				<td id="mileston_id">0</td>
				<td id="mileston_name">0</td>
				<td id="milestone_amount">Rs.359900.00</td>
				<td id='add_date'>2016-02-24 <br> 15:27:16 PM</td>
				<td id='status' class="text-orange"></td>
				<td id='complain'></td>
				<td id='received_amount'></td>
			  </tr>
			</tbody>
			</table>
			</div>
			</div>
		</div>
		<div class="row">
		<div class="col-sm-6 blockone">
		
		
		<p id="product_id"><strong>Product ID:  </strong> </p>
		<p id="product_name"><strong>Product : </strong> Auto Body Repair </p>
		<p id="quantity"><strong>Quantity : </strong> 1</p>
		
		
		</div>
		<div class="col-sm-6 blockone">
		<p><strong>Business Contact Information : </strong> Detail of Business</p>
		<p id="company_url"><strong>Vendor URL : </strong> dealmaker.com </p>
		<p id="payee_email"><strong>Payment To : </strong> dealmaker.com </p>
		</div>
		</div>
</div>
	  
	  
      </div>
      <div class="modal-footer">
	<div class="btn btn-default btn-primary pull-left prv_click">Previous</div>
	<div class="btn btn-default btn-primary nxt_click">Next</div>
      </div>
    </div>
  </div>
</div>
	
</section>	
<button type="button" class="btn btn-success hidden " data-toggle="modal" data-target="#Verify"  id="detail_dispute"></button>
<div class="modal fade animated shake" id="Verify" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" style="width:480px!important;">
    <div class="modal-content">
      <div class="modal-header">
        <!--<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>-->
        <h3 class="modal-title">Dispute Detail</h3>
      </div>
      <div class="modal-body text-center">
       
      </div>
      <div class="modal-footer">
		<button type="button" class="btn btn-primary"  data-dismiss="modal" >Close</button>
      </div>
    </div>
  </div>
</div>


<link rel="stylesheet" href="<?php echo base_url();?>css/jquery.dataTables.min.css">
<script type="text/javascript" src="<?php echo base_url();?>js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/datepiker/zebra_datepicker.js"></script>
<script>

$(document).on("click",".dispute_details_set",function(){
	ajaxindicatorstart('please wait..');
	$('.modal-body').html('');
	 $.get($(this).attr('href'), function(data, status){
       // alert("Data: " +   $(data).find("#dispute_html").html()+ "\nStatus: " + status);
		$('.modal-body').append($(data).find("#dispute_html").html());
		$('#detail_dispute').trigger("click");
		ajaxindicatorstop();
    });
	
	return false;
});


var $c_value=<?php echo $value; ?>;
var cnt=0;
// product & milestone view
var click_p_m_view="";
$(document).on("click",".prv_click",function(){	
	if(cnt>0)
	cnt--;	
	if(cnt<=0)
	{		
		$(this).hide();
	}
	if(cnt>=0)
	{
		$(".nxt_click").show();
	}	
	var order=$("."+click_p_m_view+":eq("+cnt+")").find(".view_mlileston_detail").attr('data-id');
	var mileston=$("."+click_p_m_view+":eq("+cnt+")").find(".view_mlileston_detail").attr('data');
	var dt=$("."+click_p_m_view+":eq("+cnt+")").find(".view_mlileston_detail").attr('dt');
	
	if(dt=='milestone'){
		$(".milestone_view").show();
		$(".product_view").hide();
	$.post("<?php echo base_url();?>index.php/order/getmilestone",{ order_id: order,mileston_id: mileston},
		function(data) 
		{
			setTimeout(function(){
				
			
			var parsed = $.parseJSON(data);
			console.log(parsed);
			$(parsed).each(function( index, element ){
				$('.milestone_view #myModalLabel').text(element['product_name']);
				$('.milestone_view #add_date').text(element['add_date']);
				$('.milestone_view #mileston_id').text(element['id']);
				$('.milestone_view #orderid').text(element['orderid']);
				//$('.milestone_view #first_name').text(element['payer_name']+'@'+element['company_url']);
				$('.milestone_view #payee_email').html('<strong>Payment To: </strong>'+element['payee_email']);
				//$('.milestone_view #payer_email').text(element['payee_email']);
				$('.milestone_view #company_url').html('<strong>Vendor URL : </strong>'+element['company_url']);
				$('.milestone_view #mileston_name').html(element['milestone_description']);
				$('.milestone_view #received_amount').html('<?php echo $currency_symbol;?>'+ element['total_amount']);
				$('.milestone_view .order_m_order_id').html(element['company_name']+" Order ID");
				$('.milestone_view #milestone_amount').text('<?php echo $currency_symbol;?>'+element['amount']);
				
				if(element['milestone_status']=="1" || element['milestone_status']=='5' )
				{
					$('.milestone_view #complain').html('<a class="btn btn-danger" href="<?php echo base_url(); ?>index.php/despute?txn_id='+element['milestone_transaction_id']+'" title="complain" data-toggle="tooltip"><i class="fa fa-exclamation-triangle"></i></a>');
				}else{
					$('.milestone_view #complain').html('<a class="btn btn-danger  disabled"title="complain" data-toggle="tooltip"><i class="fa fa-exclamation-triangle"></i></a>');
				}									
				$('.milestone_view #product_id').html('<strong>Product ID: </strong>'+element['order_id']);
				$('.milestone_view #orderid').html(element['order_id']);
				$('.milestone_view #product_name').html('<strong>Product : </strong>'+element['product_name']);
				$('.milestone_view #quantity').html('<strong>Quantity : </strong>'+element['quantity']);
				var st='';
				
				if(element['milestone_status']=='1')
				{
					st='Paid';
				}
				else if(element['milestone_status']=='5')
				{
					st='Processing';
				}
				else if(element['milestone_status']=='2')
				{
					st='Released';
				}
				else if(element['milestone_status']=='8')
				{
					st='Dispute';
				}
				else
				{
					st='Completed';
				}
				$('.milestone_view #status').html(st);
				
				//$("#popen").trigger("click");
			});
			
		},20);
		}
	);
	
	}
	else 
	{
		$(".milestone_view").hide();
		$(".product_view").show();
		$.post("<?php echo base_url();?>index.php/order/getproduct",{ order_id: order,product_id: mileston},
		function(data) 
		{
			
			var parsed = $.parseJSON(data);
			console.log(parsed);
			$(parsed).each(function( index, element ){
				$('.product_view #myModalLabel').text(element['product_name']);
				$('.product_view #add_date').text(element['add_date']);
				$('.product_view #mileston_id').text(element['id']);
				$('.product_view #orderid').text(element['orderid']);
				$('.product_view #first_name').text(element['payer_name']+'@'+element['company_url']);
				$('.product_view #payee_email').text(element['payer_email']);
				$('.product_view #payer_email').text(element['payee_email']);
				$('.product_view #company_url').html('<strong>Vendor URL : </strong>'+element['company_url']);
				$('.product_view #milestone_amount').text('<?php echo $currency_symbol;?>'+element['total']);
				$('.product_view .order_m_order_id').html(element['company_name']+" Order ID");
				$('.product_view #product_id').html('<strong>Product ID: </strong>'+element['order_id']);
				$('.product_view #orderid').html(element['order_id']);
				$('.product_view #product_name').html('<strong>Product : </strong>'+element['product_name']);
				$('.product_view #quantity').html('<strong>Quantity : </strong>'+element['quantity']);
				var st='';
				
				if(element['order_product_status_id']=='9')
				{
					st='Despute Resolved';
				}
				else if(element['order_product_status_id']=='5')
				{
					st='Processing';
				}
				else if(element['order_product_status_id']=='2')
				{
					st='Released';
				}
				else if(element['order_product_status_id']=='8')
				{
					st='Dispute';
				}
				else if(element['order_product_status_id']=='6')
				{
					st='Released';
				}
				else if(element['order_product_status_id']=='0')
				{
					st='Unpaid';
				}	
				else
				{
					st='Paid';
				}
				$('.product_view #status').html('<strong>Status : </strong>'+st);
				if(element['order_product_status_id']=="1" || element['order_product_status_id']=='5' )
									{
										$('.product_view #status').append('<a class="btn btn-danger " href="<?php echo base_url(); ?>index.php/despute?txn_id='+element['product_transaction_id']+'"><i class="fa fa-exclamation-triangle"></i></a>');
									}else{
										$('.product_view #status').append('<a class="btn btn-danger  disabled"  ><i class="fa fa-exclamation-triangle"></i></a>');
									}
				//$("#popen").trigger("click");
			});
			
		}
	);
	}
	
	
});
$(document).on("click",".nxt_click",function(){
	//alert($("#tab ."+click_p_m_view).length+" "+(cnt+1));
	cnt++;
	if((cnt+1)>=$("#tab ."+click_p_m_view).length)
	{
		$(this).hide();
		
	}	
	if(cnt>0)
	{	
		$(".prv_click").show();
	}
	var order=$("."+click_p_m_view+":eq("+cnt+")").find(".view_mlileston_detail").attr('data-id');
	var mileston=$("."+click_p_m_view+":eq("+cnt+")").find(".view_mlileston_detail").attr('data');
	var dt=$("."+click_p_m_view+":eq("+cnt+")").find(".view_mlileston_detail").attr('dt');
	
	if(dt=='milestone'){
		$(".milestone_view").show();
		$(".product_view").hide();
	$.post("<?php echo base_url();?>index.php/order/getmilestone",{ order_id: order,mileston_id: mileston},
		function(data) 
		{
			setTimeout(function(){
				
			
			var parsed = $.parseJSON(data);
			console.log(parsed);
			$(parsed).each(function( index, element ){
				$('.milestone_view #myModalLabel').text(element['product_name']);
				$('.milestone_view #add_date').text(element['add_date']);
				$('.milestone_view #mileston_id').text(element['id']);
				$('.milestone_view #orderid').text(element['orderid']);
				//$('.milestone_view #first_name').text(element['payer_name']+'@'+element['company_url']);
				$('.milestone_view #payee_email').html('<strong>Payment To: </strong>'+element['payee_email']);
				//$('.milestone_view #payer_email').text(element['payee_email']);
				$('.milestone_view #company_url').html('<strong>Vendor URL : </strong>'+element['company_url']);
				$('.milestone_view #mileston_name').html(element['milestone_description']);
				$('.milestone_view #received_amount').html('<?php echo $currency_symbol;?>'+ element['total_amount']);
				$('.milestone_view .order_m_order_id').html(element['company_name']+" Order ID");
				$('.milestone_view #milestone_amount').text('<?php echo $currency_symbol;?>'+element['amount']);
				
				if(element['milestone_status']=="1" || element['milestone_status']=='5' )
				{
					$('.milestone_view #complain').html('<a class="btn btn-danger" href="<?php echo base_url(); ?>index.php/despute?txn_id='+element['milestone_transaction_id']+'" title="complain" data-toggle="tooltip"><i class="fa fa-exclamation-triangle"></i></a>');
				}else{
					$('.milestone_view #complain').html('<a class="btn btn-danger  disabled"  title="complain" data-toggle="tooltip"><i class="fa fa-exclamation-triangle"></i></a>');
				}									
				$('.milestone_view #product_id').html('<strong>Product ID: </strong>'+element['order_id']);
				$('.milestone_view #orderid').html(element['order_id']);
				$('.milestone_view #product_name').html('<strong>Product : </strong>'+element['product_name']);
				$('.milestone_view #quantity').html('<strong>Quantity : </strong>'+element['quantity']);
				var st='';
				
				if(element['milestone_status']=='1')
				{
					st='Paid';
				}
				else if(element['milestone_status']=='5')
				{
					st='Processing';
				}
				else if(element['milestone_status']=='2')
				{
					st='Released';
				}
				else if(element['milestone_status']=='8')
				{
					st='Dispute';
				}
				else
				{
					st='Completed';
				}
				$('.milestone_view #status').html(st);
				//$("#popen").trigger("click");
			});
			
		},20);
		}
	);
	
	}
	else 
	{
		$(".milestone_view").hide();
		$(".product_view").show();
		$.post("<?php echo base_url();?>index.php/order/getproduct",{ order_id: order,product_id: mileston},
		function(data) 
		{
			
			var parsed = $.parseJSON(data);
			console.log(parsed);
			$(parsed).each(function( index, element ){
				$('.product_view #myModalLabel').text(element['product_name']);
				$('.product_view #add_date').text(element['add_date']);
				$('.product_view #mileston_id').text(element['id']);
				$('.product_view #orderid').text(element['orderid']);
				$('.product_view #first_name').text(element['payer_name']+'@'+element['company_url']);
				$('.product_view #payee_email').text(element['payer_email']);
				$('.product_view #payer_email').text(element['payee_email']);
				$('.product_view #company_url').html('<strong>Vendor URL : </strong>'+element['company_url']);
				$('.product_view #milestone_amount').text('<?php echo $currency_symbol;?>'+element['total']);
				$('.product_view .order_m_order_id').html(element['company_name']+" Order ID");
				$('.product_view #product_id').html('<strong>Product ID: </strong>'+element['order_id']);
				$('.product_view #orderid').html(element['order_id']);
				$('.product_view #product_name').html('<strong>Product : </strong>'+element['product_name']);
				$('.product_view #quantity').html('<strong>Quantity : </strong>'+element['quantity']);
				var st='';
				
				if(element['order_product_status_id']=='9')
				{
					st='Despute Resolved';
				}
				else if(element['order_product_status_id']=='5')
				{
					st='Processing';
				}
				else if(element['order_product_status_id']=='2')
				{
					st='Released';
				}
				else if(element['order_product_status_id']=='8')
				{
					st='Dispute';
				}
				else if(element['order_product_status_id']=='0')
				{
					st='Unpaid';
				}	
				else if(element['order_product_status_id']=='6')
				{
					st='Released';
				}
				else
				{
					st='Paid';
				}
				$('.product_view #status').html('<strong>Status : </strong>'+st);
				if(element['order_product_status_id']=="1" || element['order_product_status_id']=='5' )
									{
										$('.product_view #status').append('<a class="btn btn-danger " href="<?php echo base_url(); ?>index.php/despute?txn_id='+element['product_transaction_id']+'" title="complain" data-toggle="tooltip"><i class="fa fa-exclamation-triangle"></i></a>');
									}else{
										$('.product_view #status').append('<a class="btn btn-danger  disabled"  title="complain" data-toggle="tooltip"><i class="fa fa-exclamation-triangle "></i></a>');
									}
				//$("#popen").trigger("click");
			});
			
		}
	);
	}
	
});
var limit_load=0;
var cmp='';
var m_id='';
var p_id='';
$(document).ready(function() {
if($("#tab tbody tr").length>=40)
{
	$('#loadMore').css("display","show");
}
else{
	
	$('#loadMore').css("display","none");
	
}	
					$(".clickable").click(function() {
						var id = $(this).attr('id');
					
						var target = '.'+id;
						var target1 = '#icon_'+id;
								
								if($(target).hasClass("out"))
									{
									$(target).addClass("in");
									$(target).removeClass("out");
									$(target1).removeClass("fa fa-search-minus");
									$(target1).addClass("fa fa-search-plus");
									
								} else {
									
									$(target).addClass("out");
									$(target).removeClass("in");
									$(target1).removeClass("fa fa-search-plus");
									$(target1).addClass("fa fa-search-minus");
									$('.collapse').collapse('hide');
									$(target+" > .first").text("");
								}
								
							
					});
					
				   /*var table = $('#tab').dataTable();
					 $('#tab thead .filter').each(function (i) 
					{
						var title = $('#tab thead .filter').eq($(this).index()).text();
						// or just var title = $('#sample_3 thead th').text();
						var serach = '<input type="text" class="form-control" placeholder="Search ' + title + '" />';
						$(this).html('');
						$(serach).appendTo(this).keyup(function(){table.fnFilter($(this).val(),i)})
					});  */
					//$('#tab').DataTable();
					var closeSlide=0;
					$(document).on("click", ".view_mlileston_detail", function(){
						cnt=0;
						var ths=$(this);
						$(".ld").css({"background-color":"none","color":""});
						ths.parent().parent().css({"background-color":"#0082C8","color":"#fff"});
						var order=$(this).attr('data-id');
						var mileston=$(this).attr('data');
						click_p_m_view=order;
						var dt=ths.attr('dt');
						//$(".collapse.in").removeClass('in out');	
						
						if($("#tab ."+click_p_m_view).length<=1)
						{
							$(".nxt_click").hide();
							$(".prv_click").hide();
						}else{
							$(".nxt_click").show();
							$(".prv_click").show();
						}	
						$(".view_mlileston_detail").find("i").removeClass("fa-minus").addClass("fa-plus");
						if(ths.find('.fa-plus').length>0)
						{
							ths.find("i").removeClass("fa-plus").addClass("fa-minus");
						}else{
							ths.find("i").removeClass("fa-minus").addClass("fa-plus");
						}	
						
						if(dt=='milestone'){
							$(".milestone_view").show();
							$(".product_view").hide();
						$.post("<?php echo base_url();?>index.php/order/getmilestone",{ order_id: order,mileston_id: mileston},
							function(data) 
							{
								setTimeout(function(){
									
								
								var parsed = $.parseJSON(data);
								var  cntPage= parsed.length;
								console.log(parsed);
								var table1='';
								var table='';
								if(cntPage>0)
								{
									table=table+"<table class='inner-table-mileston'>";
									table=table+"<tr class='tb-hd text-orange text-left'>";
									table=table+"<td class='text-left' colspan='9'>";
									table=table+parsed[0]['product_name'];
									table=table+"</td>";									
									table=table+"</tr>";
									
									table=table+"<tr class='tr-hd'>";
									table=table+"<td>";
									table=table+"Sr. No.";
									table=table+"</td>";
									
									table=table+"<td>";
									table=table+"Milestone ID";
									table=table+"</td>";
									
									table=table+"<td>";
									table=table+"Milestone Name";
									table=table+"</td>";
									
									table=table+"<td>";
									table=table+"Milestone Amount";
									table=table+"</td>";
																	
									table=table+"<td>";
									table=table+"Date";
									table=table+"</td>";
									
									/*table=table+"<td>";
									table=table+"Amount Paid";
									table=table+"</td>"; */
									
									table=table+"<td>";
									table=table+"Status";
									table=table+"</td>";							
									
									table=table+"<td>";
									table=table+"Complain";
									table=table+"</td>";
									
									table=table+"</tr>";									
									
									
								}	
								var amount=0;
								$(parsed).each(function( index, element ){
									
									
								
								/* table=table+"<tr class='tb-hd'>";
								table=table+"<td>";
								table=table+"<h3 class='text-orange'>"+element['product_name']+"</h3>";
								table=table+"</td>";
								table=table+"</tr>"; */
								var st='';
									
								if(element['milestone_status']=='1')
								{
									st='Paid';
								}
								else if(element['milestone_status']=='5')
								{
									st='Processing';
								}
								else if(element['milestone_status']=='2')
								{
									st='Released';
								}
								else if(element['milestone_status']=='8')
								{
									st='Dispute';
								}
								else
								{
									st='Completed';
								}
								
								table=table+"<tr>";
								table=table+"<td>";
								table=table+(index+1);
								table=table+"</td>";							
								
								table=table+"<td>";
								table=table+element['id'];
								table=table+"</td>";
								
								table=table+"<td>";
								table=table+element['milestone_description'];
								table=table+"</td>";
								var dis_amount =0;
								var html='';
								if(parseFloat(element['final_amount'])<parseFloat(element['amount']))
								{
									dis_amount =  ((parseFloat(element['final_amount'])*100)/parseFloat(element['amount']));
									html+="<br><small><span class='text-danger' id=''>Amount paid: <?php echo $currency_symbol;?> "+(parseFloat(element['final_amount'])*parseFloat($c_value)).toFixed(2)+"</span><br><span class='text-success' id=''>Amount Refunded (Discount "+dis_amount+"%) : <?php echo $currency_symbol;?>"+(parseFloat(element['amount']-element['final_amount'])*parseFloat($c_value)).toFixed(2)+"</span></small>";
									
								}
								table=table+"<td>";
								table=table+'<?php echo $currency_symbol;?>'+(parseFloat(element['amount'])*parseFloat($c_value)).toFixed(2)+html;
								table=table+"</td>";
								amount=(amount + parseFloat(element['amount']));
								table=table+"<td>";
								table=table+element['add_date'];
								table=table+"</td>";
								
								/* table=table+"<td>";
								table=table+'<?php echo $currency_symbol;?>'+element['total_amount'];
								table=table+"</td>"; */
								
								table=table+"<td>";
								table=table+st;
								table=table+"</td>";							
								
								if(element['milestone_status']=="1" || element['milestone_status']=='5' )
								{
									st='<a class="btn btn-danger " href="<?php echo base_url(); ?>index.php/despute?txn_id='+element['milestone_transaction_id']+'" title="complain" data-toggle="tooltip"><i class="fa fa-exclamation-triangle"></i></a>';
								}else{
									st='<a class="btn btn-danger disabled"  title="complain" data-toggle="tooltip"><i class="fa fa-exclamation-triangle"></i></a>';
								}
									
								table=table+"<td>";
								table=table+st;
								if(element['despute_id']!=null)
								{	
									table=table+'<div class="pull-right"><a class=" btn btn-danger dispute_details_set" href="<?php echo base_url(); ?>despute/negotiate/'+element['despute_id']+'" target="_blank">Dispute details</a></div>';
								}
								table=table+"</td>";
								
								table=table+"</tr>";
								
						
									/* $('.milestone_view #myModalLabel').text(element['product_name']);
									$('.milestone_view #add_date').text(element['add_date']);
									$('.milestone_view #mileston_id').text(element['id']);
									$('.milestone_view #orderid').text(element['orderid']);
									//$('.milestone_view #first_name').text(element['payer_name']+'@'+element['company_url']);
									$('.milestone_view #payee_email').html('<strong>Payment To: </strong>'+element['payee_email']);
									//$('.milestone_view #payer_email').text(element['payee_email']);
									$('.milestone_view #company_url').html('<strong>Vendor URL : </strong>'+element['company_url']);
									$('.milestone_view #mileston_name').html(element['milestone_description']);
									$('.milestone_view #received_amount').html('<?php echo $currency_symbol;?>'+ element['total_amount']);
									$('.milestone_view .order_m_order_id').html(element['company_name']+" Order ID");
									$('.milestone_view #milestone_amount').text('<?php echo $currency_symbol;?>'+element['amount']);
									
									if(element['milestone_status']=="1" || element['milestone_status']=='5' )
									{
										$('.milestone_view #complain').html('<a class="btn btn-danger btn-lg" href="<?php echo base_url(); ?>index.php/despute?txn_id='+element['milestone_transaction_id']+'"><i class="fa fa-exclamation-triangle"></i></a>');
									}else{
										$('.milestone_view #complain').html('<a class="btn btn-danger btn-lg disabled"  ><i class="fa fa-exclamation-triangle"></i></a>');
									}									
									$('.milestone_view #product_id').html('<strong>Product ID: </strong>'+element['order_id']);
									$('.milestone_view #orderid').html(element['order_id']);
									$('.milestone_view #product_name').html('<strong>Product : </strong>'+element['product_name']);
									$('.milestone_view #quantity').html('<strong>Quantity : </strong>'+element['quantity']);
									var st='';
									
									if(element['milestone_status']=='1')
									{
										st='Paid';
									}
									else if(element['milestone_status']=='5')
									{
										st='Processing';
									}
									else if(element['milestone_status']=='2')
									{
										st='Released';
									}
									else if(element['milestone_status']=='8')
									{
										st='Dispute';
									}
									else
									{
										st='Completed';
									}
									$('.milestone_view #status').html(st); */
								//	$("#popen").trigger("click");
								});
								if(cntPage>0)
								{
									setTimeout(function(){
									table=table+"<tr class='text-left'>";
									table=table+"<td class='text-left' colspan='7'>";
									table=table+"<span class='payment-from'><span>Payment From : </span>"+parsed[0]['payer_name']+'@'+parsed[0]['company_url']+"</span> <span>Vendor ID/URL : </span> "+parsed[0]['order_key']+"/"+parsed[0]['company_url']+" <span>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Pending Amount : </span> <?php echo $currency_symbol;?>"+((parseFloat(parsed[0]['total_amount'] - amount)*parseFloat($c_value)).toFixed(2));
									table=table+"</td>";									
									table=table+"</tr>";	
									table=table+"</table>";
									table1=table1+table;
									$("."+order).html("<td colspan='10'>"+table1+"</td>");							
									ths.parent().find(".clickable").click();
								},40);
								}
								
							},20);
							$('[data-toggle="tooltip"]').tooltip(); 
							}
						);
						
						}
						else if($('.dd-selected-text').text()=='Invoice') 
						{
							$(".milestone_view").hide();
							$(".product_view").show();
							$.post("<?php echo base_url();?>index.php/order/getinvoice",{ order_id: order},
							function(data) 
							{
								
								var parsed = $.parseJSON(data);
								var  cntPage= parsed.length;
								console.log(parsed);
								var table1='';
								$(parsed).each(function( index, element ){
									
									var table='';
									if(index>0)
									table=table+"<table class='inner-table' style='display:none;'>";
									else{
										table=table+"<table class='inner-table'>";
									}
						table=table+"<tr class='tb-hd'>";
						table=table+"<td colspan='6'>";
						table=table+"<h3 class='text-orange'>"+element['product_name']+"</h3>";
						table=table+"</td>";
						var st1=' ';
						
						if(element['order_product_status_id']=="1")
						{
							
							st1 = '<a class="btn btn-danger  pull-left" href="<?php echo base_url(); ?>index.php/despute?txn_id='+element['product_transaction_id']+'" title="complain" data-toggle="tooltip"><i class="fa fa-exclamation-triangle"></i></a>';
						}else if(element['order_product_status_id']=='5')
						{
							st1 = '<a class="btn btn-warning  pull-left" href="<?php echo base_url(); ?>index.php/despute?txn_id='+element['product_transaction_id']+'" title="complain" data-toggle="tooltip"><i class="fa fa-exclamation-triangle"></i></a>';
						}
						else{
							st1 = '<a class="btn btn-danger  disabled pull-left" title="complain" data-toggle="tooltip" ><i class="fa fa-exclamation-triangle"></i></a>';
						}
						
						
						table=table+"<td>";
						table=table+"<h3 class='text-orange'>"+st1+"</h3>";
						table=table+"</td>";
						table=table+"</tr>";
												
						table=table+"<tr>";
						table=table+"<td colspan='4'>";
						table=table+"<h3 class='tital-hd3'>Transaction Detail</h3>";
						table=table+"</td>";						
						table=table+"</tr>";
						
						table=table+"<tr>";
						table=table+"<td class='tital-td brdnone'>";
						table=table+($(".dd-selected-value").val()!='2'?'Product Name':'Item');
						table=table+"</td>";
						table=table+"<td colspan='2'>";
						table=table+element['product_name'];
						table=table+"</td>";
						table=table+"<td class='tital-td'>";
						table=table+"Total Amount<br/>";
						table=table+"Amount Paid<br/>";
						table=table+"Tax(<small class='text-success'>"+(parseFloat(element['tax'])).toFixed(2)+'%</small>):';
						element['quantity']
						if(element['product_main_amount']!=null)
						{	
							if(element['remedy']=='Cancellation')
							{
								table=table+'<br/><small>Cancellation charge<br/> Amount Refunded';
							}else if(element['remedy']=='Replacement')
							{
								table=table+'<br/><small>Amount Refunded(Replacement)';
							}
							else{
								table=table+'<br/><small>Amount Refunded (Discount <span class="text-success">'+(((parseFloat(((element['product_main_amount']-element['paid_amount'])/element['product_main_amount'])*100))).toFixed(2))+'%</span>)';
							}
						}
						
						table=table+"</td>";
						table=table+"<td colspan='2'>";
						if(element['product_main_amount']!=null)
						{
							table=table+'<?php echo $currency_symbol;?>'+(parseFloat(element['product_main_amount'])*parseFloat($c_value)).toFixed(2)+"<br/>";
							if(element['remedy']=='Cancellation')
							{
								table=table+'<?php echo $currency_symbol;?>'+(parseFloat(element['product_main_amount'])*parseFloat($c_value)*0.15).toFixed(2);
							}else{
								table=table+'<?php echo $currency_symbol;?>'+(parseFloat(element['paid_amount'])*parseFloat($c_value)).toFixed(2);
							}	
							
						}else{	
							
							var tax =  ((parseFloat(element['total'])*parseFloat(element['tax']))/100); 
							
							table=table+'<?php echo $currency_symbol;?>'+((parseFloat(element['total'])+parseFloat(element['shipping_cost'])+tax)*parseFloat($c_value)).toFixed(2)+"<br/>";
							table=table+'<?php echo $currency_symbol;?>'+(((parseFloat(element['total'])+parseFloat(element['shipping_cost'])))*parseFloat($c_value)).toFixed(2)+"<br/>";
							table=table+'<?php echo $currency_symbol;?>'+(parseFloat(tax)).toFixed(2);
							
						}
						if(element['despute_id']!=null)
						{	
							table=table+'<a class=" pull-right btn btn-danger dispute_details_set" href="<?php echo base_url(); ?>despute/negotiate/'+element['despute_id']+'" target="_blank">Dispute details</a>';
						}
						if(element['product_main_amount']!=null)
						{	
							if(element['remedy']=='Cancellation')
							{
								table=table+'<br/><small><?php echo $currency_symbol;?>'+(parseFloat(element['product_main_amount'])*parseFloat($c_value)*0.15).toFixed(2);	
								table=table+'<br/><?php echo $currency_symbol;?>'+(parseFloat(element['product_main_amount'])*parseFloat($c_value)*0.85).toFixed(2)+"</small>";	
								
							}else{
								table=table+'<br/><small><?php echo $currency_symbol;?>'+(parseFloat(element['product_main_amount']-element['paid_amount'])*parseFloat($c_value)).toFixed(2)+"</small>";	
							}		
							
							
						}	
						table=table+"</td>";
						table=table+"</tr>";
						
						table=table+"<tr>";
						table=table+"<td class='tital-td brdnone'>";
						table=table+"Order Place By";
						table=table+"</td>";
						table=table+"<td colspan='2'>";
						table=table+element['payer_name']+(element['company_url']==null?'':"@"+element['company_url']);
						table=table+"</td>";
						table=table+"<td class='tital-td'>";
						table=table+"Payment from";
						table=table+"</td>";
						table=table+"<td colspan='2'>";
						table=table+element['payer_email'];
						table=table+"</td>";
						table=table+"</tr>";
												
						table=table+"<tr>";
						table=table+"<td class='tital-td brdnone'>";
						table=table+"Vendor ID/URL";
						table=table+"</td>";
						table=table+"<td colspan='2'>";
						table=table+element['order_key']+(element['company_url']==null?'':"/"+element['company_url']);
						table=table+"</td>";
						table=table+"<td class='tital-td'>";
						table=table+"Payment to";
						table=table+"</td>";
						table=table+"<td colspan='2'>";
						table=table+element['payee_email'];
						table=table+"</td>";
						table=table+"</tr>";
						var st='';
									
						if(element['order_product_status_id']=='9')
						{
							st='Despute Resolved';
						}
						else if(element['order_product_status_id']=='5')
						{
							st='Processing';
						}
						else if(element['order_product_status_id']=='2')
						{
							st='Released';
						}
						else if(element['order_product_status_id']=='8')
						{
							st='Dispute';
						}
						else if(element['order_product_status_id']=='6')
						{
							st='Released';
						}
						else if(element['order_product_status_id']=='0')
						{
							st='Unpaid';
						}
						else
						{
							st='Paid';
						}
						
						
						table=table+"<tr>";
						table=table+"<td class='tital-td brdnone'>";
						table=table+"Status";
						table=table+"</td>";
						table=table+"<td colspan='2'>";
						table=table+st;
						table=table+"</td>";
						table=table+"<td class='tital-td'>";
						table=table+"Payment ID";
						table=table+"</td>";
						table=table+"<td colspan='2'>";
						table=table+element['order_id'];
						table=table+"</td>";
						table=table+"</tr>";
						table=table+"<tr>";
						table=table+"<td>";
						table=table+"</td>";
						table=table+"<td colspan='4'>";
						if(cntPage>1)
						{	
						
							if(index==0)
							{
								table=table+"<div class='label label-success pull-right'>"+(index+1)+" of "+cntPage+" <div class='btn btn-success'><<</div> <div class='btn btn-success' onclick='javascript:$(\"."+order+" .inner-table:eq("+index+" )\").hide(); $(\"."+order+" .inner-table:eq("+(index+1)+")\").show();'>>></div></div>";
							}	
							else if(cntPage!=(index+1))
							{
								table=table+"<div class='label label-success pull-right'>"+(index+1)+" of "+cntPage+" <div class='btn btn-success' onclick='javascript:$(\"."+order+" .inner-table:eq("+(index-1)+" )\").show(); $(\"."+order+" .inner-table:eq("+(index)+")\").hide();'><<</div> <div class='btn btn-success' onclick='javascript:$(\"."+order+" .inner-table:eq("+index+" )\").hide(); $(\"."+order+" .inner-table:eq("+(index+1)+")\").show();'>>></div></div>";
								
							}else{
								table=table+"<div class='label label-success pull-right'>"+(index+1)+" of "+cntPage+" <div class='btn btn-success' onclick='javascript:$(\"."+order+" .inner-table:eq("+(index-1)+" )\").show(); $(\"."+order+" .inner-table:eq("+(index)+")\").hide();'><<</div> <div class='btn btn-success'>>></div></div>";
								
							}
							
						}
						
						table=table+"</td>";
						table=table+"</tr>";
						table=table+"</table>";
						table1=table1+table;
									
								});
								
								setTimeout(function(){
									$("."+order).html("<td colspan='10'>"+table1+"</td>");							
									ths.parent().find(".clickable").click();
									$('[data-toggle="tooltip"]').tooltip(); 
								},20);
							}
						);
						}
						else 
						{
							$(".milestone_view").hide();
							$(".product_view").show();
							$.post("<?php echo base_url();?>index.php/order/getproduct",{ order_id: order},
							function(data) 
							{
								
								var parsed = $.parseJSON(data);
								var  cntPage= parsed.length;
								console.log(parsed);
								var table1='';
								$(parsed).each(function( index, element ){
									
									var table='';
									if(index>0)
									table=table+"<table class='inner-table' style='display:none;'>";
									else{
										table=table+"<table class='inner-table'>";
									}
						table=table+"<tr class='tb-hd'>";
						table=table+"<td colspan='6'>";
						table=table+"<h3 class='text-orange'>"+element['product_name']+"</h3>";
						table=table+"</td>";
						var st1=' ';
						if($(".dd-selected-value").val()!='2'){
						if(element['order_product_status_id']=="1")
						{
							
							st1 = '<a class="btn btn-danger  pull-left" href="<?php echo base_url(); ?>index.php/despute?txn_id='+element['product_transaction_id']+'" title="complain" data-toggle="tooltip"><i class="fa fa-exclamation-triangle"></i></a>';
						}else if(element['order_product_status_id']=='5')
						{
							st1 = '<a class="btn btn-warning  pull-left" href="<?php echo base_url(); ?>index.php/despute?txn_id='+element['product_transaction_id']+'" title="complain" data-toggle="tooltip"><i class="fa fa-exclamation-triangle"></i></a>';
						}
						else{
							st1 = '<a class="btn btn-danger  disabled pull-left" title="complain" data-toggle="tooltip" ><i class="fa fa-exclamation-triangle"></i></a>';
						}
						}
						
						table=table+"<td>";
						table=table+"<h3 class='text-orange'>"+st1+"</h3>";
						table=table+"</td>";
						
						/*table=table+"<td class='text-right'>";
						table=table+"<h3 class='text-orange text-right'>"+element['date_added']+"</h3>";
						table=table+"</td>"; */
						
						table=table+"</tr>";
												
						table=table+"<tr>";
						table=table+"<td colspan='4'>";
						table=table+"<h3 class='tital-hd3'>Transaction Detail</h3>";
						table=table+"</td>";						
						table=table+"</tr>";
						
						table=table+"<tr>";
						table=table+"<td class='tital-td brdnone'>";
						table=table+($(".dd-selected-value").val()!='2'?'Product Name':'Item');
						table=table+"</td>";
						table=table+"<td colspan='2'>";
						table=table+element['product_name'];
						table=table+"</td>";
						table=table+"<td class='tital-td'>";
						table=table+"Total Amount<br/>";
						table=table+"Amount Paid";
						if(element['product_main_amount']!=null)
						{	
							if(element['remedy']=='Cancellation')
							{
								table=table+'<br/><small>Cancellation charge<br/> Amount Refunded';
							}else if(element['remedy']=='Replacement')
							{
								table=table+'<br/><small>Amount Refunded(Replacement)';
							}
							else{
								table=table+'<br/><small>Amount Refunded (Discount <span class="text-success">'+(((parseFloat(((element['product_main_amount']-element['paid_amount'])/element['product_main_amount'])*100))).toFixed(2))+'%</span>)';
							}
							
							//table=table+'Discount offered</small>';
						}
						
						table=table+"</td>";
						table=table+"<td colspan='2'>";
						if(element['product_main_amount']!=null)
						{
							table=table+'<?php echo $currency_symbol;?>'+(parseFloat(element['product_main_amount'])*parseFloat($c_value)).toFixed(2)+"<br/>";
							if(element['remedy']=='Cancellation')
							{
								table=table+'<?php echo $currency_symbol;?>'+(parseFloat(element['product_main_amount'])*parseFloat($c_value)*0.15).toFixed(2);
							}else{
								table=table+'<?php echo $currency_symbol;?>'+(parseFloat(element['paid_amount'])*parseFloat($c_value)).toFixed(2);
							}	
							
						}else{	
							table=table+'<?php echo $currency_symbol;?>'+(parseFloat(element['total'])*parseFloat($c_value)).toFixed(2)+"<br/>";
							table=table+'<?php echo $currency_symbol;?>'+(parseFloat(element['total'])*parseFloat($c_value)).toFixed(2);
						}
						if(element['despute_id']!=null)
						{	
							table=table+'<a class=" pull-right btn btn-danger dispute_details_set" href="<?php echo base_url(); ?>despute/negotiate/'+element['despute_id']+'" target="_blank">Dispute details</a>';
						}
						if(element['product_main_amount']!=null)
						{	
							if(element['remedy']=='Cancellation')
							{
								table=table+'<br/><small><?php echo $currency_symbol;?>'+(parseFloat(element['product_main_amount'])*parseFloat($c_value)*0.15).toFixed(2);	
								table=table+'<br/><?php echo $currency_symbol;?>'+(parseFloat(element['product_main_amount'])*parseFloat($c_value)*0.85).toFixed(2)+"</small>";	
								
							}else{
								table=table+'<br/><small><?php echo $currency_symbol;?>'+(parseFloat(element['product_main_amount']-element['paid_amount'])*parseFloat($c_value)).toFixed(2)+"</small>";	
							}		
							
							//table=table+"<?php echo $currency_symbol;?>"+(parseFloat(element['product_main_amount']-element['paid_amount'])*parseFloat($c_value)).toFixed(2)+"</small>";
							//table=table+'<br/><small class="text-primary">  Update Amount from <?php echo $currency_symbol;?>'+(parseFloat(element['product_main_amount'])*parseFloat($c_value)).toFixed(2)+" to <?php echo $currency_symbol;?>"+(parseFloat(element['paid_amount'])*parseFloat($c_value)).toFixed(2)+"</small>";
						}	
						table=table+"</td>";
						table=table+"</tr>";
						
						table=table+"<tr>";
						table=table+"<td class='tital-td brdnone'>";
						table=table+"Order Place By";
						table=table+"</td>";
						table=table+"<td colspan='2'>";
						table=table+element['payer_name']+(element['company_url']==null?'':"@"+element['company_url']);
						table=table+"</td>";
						table=table+"<td class='tital-td'>";
						table=table+"Payment from";
						table=table+"</td>";
						table=table+"<td colspan='2'>";
						table=table+element['payer_email'];
						table=table+"</td>";
						table=table+"</tr>";
												
						table=table+"<tr>";
						table=table+"<td class='tital-td brdnone'>";
						table=table+"Vendor ID/URL";
						table=table+"</td>";
						table=table+"<td colspan='2'>";
						table=table+element['order_key']+(element['company_url']==null?'':"/"+element['company_url']);
						table=table+"</td>";
						table=table+"<td class='tital-td'>";
						table=table+"Payment to";
						table=table+"</td>";
						table=table+"<td colspan='2'>";
						table=table+element['payee_email'];
						table=table+"</td>";
						table=table+"</tr>";
						var st='';
									
						if(element['order_product_status_id']=='9')
						{
							st='Despute Resolved';
						}
						else if(element['order_product_status_id']=='5')
						{
							st='Processing';
						}
						else if(element['order_product_status_id']=='2')
						{
							st='Released';
						}
						else if(element['order_product_status_id']=='8')
						{
							st='Dispute';
						}
						else if(element['order_product_status_id']=='6')
						{
							st='Released';
						}
						else if(element['order_product_status_id']=='0')
						{
							st='Unpaid';
						}
						else
						{
							st='Paid';
						}
						
						
						table=table+"<tr>";
						table=table+"<td class='tital-td brdnone'>";
						table=table+"Status";
						table=table+"</td>";
						table=table+"<td colspan='2'>";
						table=table+st;
						table=table+"</td>";
						table=table+"<td class='tital-td'>";
						table=table+"Payment ID";
						table=table+"</td>";
						table=table+"<td colspan='2'>";
						table=table+element['order_id'];
						table=table+"</td>";
						table=table+"</tr>";
						table=table+"<tr>";
						table=table+"<td>";
						table=table+"</td>";
						table=table+"<td colspan='4'>";
						if(cntPage>1)
						{	
						
							if(index==0)
							{
								table=table+"<div class='label label-success pull-right'>"+(index+1)+" of "+cntPage+" <div class='btn btn-success'><<</div> <div class='btn btn-success' onclick='javascript:$(\"."+order+" .inner-table:eq("+index+" )\").hide(); $(\"."+order+" .inner-table:eq("+(index+1)+")\").show();'>>></div></div>";
							}	
							else if(cntPage!=(index+1))
							{
								table=table+"<div class='label label-success pull-right'>"+(index+1)+" of "+cntPage+" <div class='btn btn-success' onclick='javascript:$(\"."+order+" .inner-table:eq("+(index-1)+" )\").show(); $(\"."+order+" .inner-table:eq("+(index)+")\").hide();'><<</div> <div class='btn btn-success' onclick='javascript:$(\"."+order+" .inner-table:eq("+index+" )\").hide(); $(\"."+order+" .inner-table:eq("+(index+1)+")\").show();'>>></div></div>";
								
							}else{
								table=table+"<div class='label label-success pull-right'>"+(index+1)+" of "+cntPage+" <div class='btn btn-success' onclick='javascript:$(\"."+order+" .inner-table:eq("+(index-1)+" )\").show(); $(\"."+order+" .inner-table:eq("+(index)+")\").hide();'><<</div> <div class='btn btn-success'>>></div></div>";
								
							}
							
						}
						
						table=table+"</td>";
						table=table+"</tr>";
						table=table+"</table>";
						table1=table1+table;
									/* $('.product_view #myModalLabel').text(element['product_name']);
									$('.product_view #add_date').text(element['add_date']);
									$('.product_view #mileston_id').text(element['id']);
									$('.product_view #orderid').text(element['orderid']);
									$('.product_view #first_name').text(element['payer_name']+'@'+element['company_url']);
									$('.product_view #payee_email').text(element['payer_email']);
									$('.product_view #payer_email').text(element['payee_email']);
									$('.product_view #company_url').html('<strong>Vendor URL : </strong>'+element['company_url']);
									$('.product_view #milestone_amount').text('<?php echo $currency_symbol;?>'+element['total']);
									$('.product_view .order_m_order_id').html(element['company_name']+" Order ID");
									$('.product_view #product_id').html('<strong>Product ID: </strong>'+element['order_id']);
									$('.product_view #orderid').html(element['order_id']);
									$('.product_view #product_name').html('<strong>Product : </strong>'+element['product_name']);
									$('.product_view #quantity').html('<strong>Quantity : </strong>'+element['quantity']);
									var st='';
									
									if(element['order_product_status_id']=='9')
									{
										st='Despute Resolved';
									}
									else if(element['order_product_status_id']=='5')
									{
										st='Processing';
									}
									else if(element['order_product_status_id']=='2')
									{
										st='Released';
									}
									else if(element['order_product_status_id']=='8')
									{
										st='Dispute';
									}
									else if(element['order_product_status_id']=='6')
									{
										st='Released';
									}
									else
									{
										st='Paid';
									}
									$('.product_view #status').html('<strong>Status : </strong>'+st);
									
									if(element['order_product_status_id']=="1" || element['order_product_status_id']=='5' )
									{
										$('.product_view #status').append('<a class="btn btn-danger btn-lg" href="<?php echo base_url(); ?>index.php/despute?txn_id='+element['product_transaction_id']+'"><i class="fa fa-exclamation-triangle"></i></a>');
									}else{
										$('.product_view #status').append('<a class="btn btn-danger btn-lg disabled"  ><i class="fa fa-exclamation-triangle"></i></a>');
									}
									//$("#popen").trigger("click"); */
								});
								
								setTimeout(function(){
									$("."+order).html("<td colspan='10'>"+table1+"</td>");							
									ths.parent().find(".clickable").click();
									$('[data-toggle="tooltip"]').tooltip(); 
								},20);
							}
						);
						}
					});
					
				});
$('#seller').on("change",function(){
	
		var value=$(this).val();
		var cmp=$('#seller option:selected').attr('c_id');
		var m_id=$('#seller option:selected').attr('value');
		ajaxindicatorstart('please wait..');
		if(cmp){
			$url = window.location.href+'?m_id='+value+'&c_id='+cmp;
		}
		else
		{
			$url = window.location.href+'?c_id='+value;
		}
			$.ajax({ cache: false,
				url: $url,
				type:"get",
				success: function (data) {
					
					var v = $(data).find("#tab").html();
					$('#tab').html(v);
				},
				complete: function(data) {
					ajaxindicatorstop();
				}
			});
		
})
 
 
 $(document).on("click","#loadMore",function(){	
 var milestone=$('#myDropdown .dd-selected-value').val();

	ajaxindicatorstart('please wait..');
	var last_id=$('tr.ld:last').find('td:eq(1)').text();
	var $url='';
	if(m_id){
		$url = window.location.href+'?m_id='+m_id+"&milestone="+milestone;
	}
	else if(cmp)
	{
		$url = window.location.href+'?c_id='+cmp+"&milestone="+milestone;
	}else if(p_id)
	{
		p_id=encodeURIComponent($("#ajaxselect option:selected").text());
		$url = window.location.href+'?product_name='+p_id+"&milestone="+milestone; 
	}else{
		$url = window.location.href+'?milestone='+milestone;
	}
	limit_load=($('#tab tbody').find("tr").length)/2;
	$url=$url+'&limit='+parseInt(limit_load);
		$.ajax({ cache: false,
			url: $url,
			type:"get",
			success: function (data) {
				var v = $(data).find("tbody").html();
				if(v.trim()=='' || $(data).find("tbody").find("tr").length<20)
				{
					$('#loadMore').css("display","none");
				}		
				$('#tab tbody:eq(0)').append(v);
			},
			complete: function(data) {
				ajaxindicatorstop();
			}
		});
			
});
	
$("#search_by_text").click(function(){
	cmp='';
	m_id='';
	p_id='';
	limit_load=0;
		$value = $(".filtertxt").val();
		var milestone=$('#myDropdown .dd-selected-value').val();
		ajaxindicatorstart('please wait..');
		$url = '<?php echo base_url();?>order/order_list?milestone='+milestone+'&text='+$value;
			$.ajax({ cache: false,
				url: $url,
				type:"get",
				success: function (data) {
					var v = $(data).find("#tab").html();
					if(v.trim()=='')
					{
						$('tfoot').css("display","none");
					}		
					$('#tab').html(v);					
					if($('#tab tr').length>=40)
					{
						$('#loadMore').css("display","show");
					}
					else{
						$('#loadMore').css("display","none");
					}
				},
				complete: function(data) {
					ajaxindicatorstop();
				}
			});
});
		
		
function  selected()
{	
	cmp='';
	m_id='';
	p_id='';
	var milestone;
	limit_load=0;
	milestone=$('#myDropdown .dd-selected-value').val();

	var selected_type =$("#ajaxselect option:selected").val().split("_"); 
	if(selected_type[0]=='company')
	{
		cmp=selected_type[1];
	}
	if(selected_type[0]=='seller')
	{
		m_id=selected_type[1];
	}
	
	if(selected_type[0]=='product')
	{
		p_id=selected_type[1];
	}	
	
	var $url='';
	if(m_id){
		$url = window.location.href+'?m_id='+m_id+"&milestone="+milestone;
	}
	else if(cmp)
	{
		$url = window.location.href+'?c_id='+cmp+"&milestone="+milestone;
	}else if(p_id)
	{
		p_id=encodeURIComponent($("#ajaxselect option:selected").text());
		$url = window.location.href+'?product_name='+p_id+"&milestone="+milestone; 
	}	
	if(!$url)
	{
		$(".filtertxt").val('');
		return false;
	}	
	

ajaxindicatorstart('please wait..');
	$.ajax({ cache: false,
		url: $url,
		type:"get",
		success: function (data) {
			
			var v = $(data).find("#tab").html();
			$('#tab').html(v);
			if($('#tab tbody tr.ld').length < 10)
			{
				$('tfoot').css("display","none");
			} 
			
		},
		complete: function(data) {
			ajaxindicatorstop();
		}
	});
}


</script>

<style>
.tital-td{border-left:1px solid #666!important;}
.tital-td.brdnone{border-left:none!important;}
</style>
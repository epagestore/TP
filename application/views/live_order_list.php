<?php include("inner_menu.php");?>

<style>
a{
	color:green;
}
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
.clickable{cursor: pointer;}
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
</style>
<section class="container">
<div class="row">
	<div class="col-sm-12" style="min-height:400px;">
<div class="table-responsive">
<h3 class="text-white bottom-margin">Place Order </h3>


<table class="table dataTable " id="tab" >
<thead >
<tr class="text-center table-hd " style=" border-bottom: 2px solid #0082c8;">

<th colspan="5" style=" border-bottom: 2px solid #0082c8;" > </th>
<th colspan="5" class="text-center" style=" border-bottom: 2px solid #0082c8;" >OrderSummary</th>
</tr>
<tr class="text-center table-hd" style="border-top: 1px solid #0082c8;">
	<!--<th>Secret Key</th>-->
	<!--th>Key </th!-->
	<th style="border-top: 1px solid #0082c8;">Date</th>
    <th style="border-top: 1px solid #0082c8;">TPOrderID</th>    
    <th style="border-top: 1px solid #0082c8;">PaymentTo</th>
    <th style="border-top: 1px solid #0082c8;">OrderId</th>
     <!--<th>name</th>-->
     <th style="border-top: 1px solid #0082c8;">OrderAmount</th>
     <th style="border-top: 1px solid #0082c8;"><?php if($cmp=='17'){?>Milestone Date<?php }else{?><?php }?></th>
	 <th style="border-top: 1px solid #0082c8;"><?php if($cmp=='17'){?>Milestone Name<?php }else{?>Product name<?php }?></th>
     <th style="border-top: 1px solid #0082c8;"><?php if($cmp=='17'){?>Amount<?php }else{?>Price<?php }?></th>
     <th style="border-top: 1px solid #0082c8;">Status</th>
     <th style="border-top: 1px solid #0082c8;"></th>
    
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
   		
    	<tr class="text-center info  " id="<?php echo $order['order_id'];?>" >
             <!--td><?php echo $order['payer_code']?></td!-->
        	 <!--<td><?php if($order['order_status_id']!=6){?>paid<?php /*?><a href="<?php echo base_url();?>index.php/order/complete_order/<?php echo $order['order_id']?>">Complete Order</a><?php */?><?php }else{?>Completed<?php }?></td>-->
            <td style="padding-top:15px;"><?php echo  date('F jS Y',strtotime($order['date_added']));?><br /><div style="font-size:11px; text-align:left; margin-left:23px;"><?php echo  date('g:i:s A',strtotime($order['date_added']));?></div></td>
            <td style=""><?php echo $order['order_id']?></td>
             <td style=""><?php echo $order['company_name']?></td>
            <td style=""><?php echo $order['order_key']?></td>
            <!--<td><?php echo $order['transaction_id']?></td>-->
            <!--<td><?php echo $order['shipping_firstname']." ".$order['shipping_lastname']?></td>-->
            <td style="padding-left:10px;"><?php echo $currency_symbol;?><?php echo sprintf("%.2f", ($order['total_amount'])*$value); ?></td>
            <?php if($order['milestone_amount']){?>
      		<td><?php echo  date('F jS Y',strtotime($order['milestone_added']));?></td>
             <td><?php echo $order['milestone_description'];?></td>
            <?php /*?><td>Txn#</td><?php */?>
            <td><?php echo $currency_symbol;?><?php echo sprintf("%.2f", ($order['milestone_amount'])*$value); ?></td>
            <td> <?php if($order['milestone_status']=='1'){?>Paid <?php }else if($order['milestone_status']=='2'){?>Released <?php }else  if($order['milestone_status']=='5'){?>Processing<?php }else { echo "Complete";}?></td>
			<!--<td>Secret Key</td>-->
             <td class="text-left"><a class="btn btn-success  " href="<?php echo  base_url();?>index.php/order/placed_details/<?php echo  $order['order_id'];?>"><i class="fa fa-eye"></i></a><a class="text-orange wel-text pluse-btn clickable" data-toggle="collapse" id="<?php echo $order['order_id'];?>"  data-target=".<?php echo $order['order_id'];?>"><i class="fa fa-plus-circle" id="icon_<?php echo $order['order_id'];?>"></i></a></td>
			 
            <?php }else{?>
			<td></td>
            <td >Product name</td>            
           <?php /*?> <td>Txn#</td><?php */?>
            <td>Price</td>
            <td>Status</td>
            <td class="text-left"><a class="btn btn-success" href="<?php echo  base_url();?>index.php/order/placed_details/<?php echo  $order['order_id'];?>"><i class="fa fa-eye"></i></a><a class="text-orange wel-text pluse-btn clickable" data-toggle="collapse" id="<?php echo $order['order_id'];?>"  data-target=".<?php echo $order['order_id'];?>"><i class="fa fa-plus-circle" id="icon_<?php echo $order['order_id'];?>"></i></a></td>
            <?php }?>
        </tr>
		<?php if($order['milestone_amount']){?>
        <tr class="collapse <?php echo $order['order_id'];?> animated fadeInDown" >
        	<td colspan="5"><a id="view_mlileston_detail" class="btn btn-warning view_mlileston_detail"  data="<?php echo $order['milestone_id'];?>" data-id="<?php echo $order['order_id'];?>">View Milestone Detail<a></td>
         <!--  <td ><span style='display:none'><?php echo $order['payee_code']?></span></td>
            <!--<td ><span style='display:none'><?php if($order['order_status_id']!=6){?>paid<?php }else{?>Completed<?php }?></span></td>-->
           <!-- <td ><span style='display:none'><?php echo $order['order_id']?></span></td>
            <td><span style='display:none'><?php echo $order['shipping_firstname']." ".$order['shipping_lastname']?></span></td>
           <!-- <td ><span style='display:none'><?php echo $order['order_key']?></span></td>-->
          <!--  <td ><span style='display:none'><?php echo $currency_symbol;?><?php echo sprintf("%.2f", ($order['total_amount'])*$value); ?></span></td>  -->          
             <td><?php echo  date('F jS Y',strtotime($order['milestone_added']));?></td>
             <td><?php echo $order['milestone_description'];?></td>
           <?php /*?><td><?php echo $order['milestone_transaction_id'];?></td><?php */?>
            <td><?php echo $currency_symbol;?><?php echo sprintf("%.2f", ($order['milestone_amount'])*$value); ?></td>
            <td> <?php if($order['milestone_status']=='1'){?>Paid <?php }else if($order['milestone_status']=='2'){?>Released <?php }else  if($order['milestone_status']=='5'){?>Processing<?php }else { echo "Complete";}?></td>
			<!--<td><?php echo $order['milestone_payer_code'];?></td>-->
             <td class="text-left"><?php  if($order['milestone_status']==1 || $order['milestone_status']==5){?><a class="<?php if($order['milestone_status']==5) echo "btn btn-warning ";else echo "btn btn-danger ";?>" href="<?php echo base_url();?>index.php/despute?txn_id=<?php echo $order['milestone_transaction_id'];?>" ><i class="fa fa-exclamation-triangle"></i></a><?php }else{?><a class="btn btn-danger  disabled"  ><i class="fa fa-exclamation-triangle"></i></a><?php }?></td>
			 
        </tr>
        <?php }else{?>
        <tr class="collapse <?php echo $order['order_id'];?>  animated fadeInDown" >
        	<td colspan="6"> <a id="view_mlileston_detail" data="<?php echo $order['order_product_id'];?>" data-id="<?php echo $order['order_id'];?>" class="btn btn-warning view_mlileston_detail" >View Product Detail</a></td>
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
                <td><?php  if($order['order_product_status_id']==9){?>Despute Resolved<?php } else if($order['order_product_status_id']==7){?>Complete order time expired<?php }elseif($order['order_product_status_id']==5){?>Processing <?php } else if($order['order_product_status_id']==6){?>Completed<?php }else if($order['order_product_status_id']==2){?>Released<?php }else if($order['order_product_status_id']==8){?><a href="<?php echo base_url();?>index.php/despute/negotiate/<?php echo $order['despute_id']?>">Despute</a><?php }else{?>Paid <?php }?></td>
               <td class="text-left"><?php  if($order['order_product_status_id']==1 || $order['order_product_status_id']==5){?><a class="<?php if($order['order_product_status_id']==5) echo "btn btn-warning ";else echo "btn btn-danger ";?>" href="<?php echo base_url();?>index.php/despute?txn_id=<?php echo $order['product_transaction_id'];?>" ><i class="fa fa-exclamation-triangle"></i></a><?php }else{?><a class="btn btn-danger  disabled"  ><i class="fa fa-exclamation-triangle"></i></a><?php }?></td>
                </tr>
            <?php }}else{?>
         <tr class="collapse <?php echo $order['order_id'];?> animated fadeInDown" id="<?php echo $order['order_id'];?> ">
         
         
         	<td colspan="5"> <a id="view_mlileston_detail" data="<?php echo $order['order_product_id'];?>" data-id="<?php echo $order['order_id'];?>" class="btn btn-warning view_mlileston_detail" >View  Product Detail</a></td>
         	
         	<?php /*?><td ><span style='display:none'><?php echo $order['payer_code']?></span></td><?php */?>
           <!-- <td ><span style='display:none'><?php if($order['order_status_id']!=6){?>paid<?php }else{?>Completed<?php }?></span></td>-->
          <!--  <td ><span style='display:none'><?php echo $order['order_id']?></span></td>
            <td ><span style='display:none'><?php echo $order['shipping_firstname']." ".$order['shipping_lastname']?></span></td>
            <td ><span style='display:none'><?php echo $order['order_key']?></span></td>
            <td ><span style='display:none'><?php echo $currency_symbol;?><?php echo sprintf("%.2f", ($order['total_amount'])*$value); ?></span></td>-->
            <?php if($order['milestone_amount']){?>
             
           <td><?php echo  date('F jS Y',strtotime($order['milestone_added']));?></td>
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
               <td><?php  if($order['order_product_status_id']==9){?>Despute Resolved<?php } elseif($order['order_product_status_id']==7){?>Complete order time expired<?php }else if($order['order_product_status_id']==5){?>Processing <?php } else if($order['order_product_status_id']==6){?>Completed<?php }else if($order['order_product_status_id']==2){?>Released<?php }else if($order['order_product_status_id']==8){?><a href="<?php echo base_url();?>index.php/despute/negotiate/<?php echo $order['despute_id']?>">Despute</a><?php }else{?>Paid <?php }?></td>
                <td class="text-left"><?php  if($order['order_product_status_id']==1 || $order['order_product_status_id']==5){?><a class="<?php if($order['order_product_status_id']==5) echo "btn btn-warning ";else echo "btn btn-danger ";?>" href="<?php echo base_url();?>index.php/despute?txn_id=<?php echo $order['product_transaction_id'];?>" ><i class="fa fa-exclamation-triangle"></i></a><?php }else{?><a class="btn btn-danger  disabled"  ><i class="fa fa-exclamation-triangle"></i></a><?php }?></td>
            <?php } ?>
            
        </tr>
        <?php }?>
 		
<?php endforeach?>
 </tbody>
</table>

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
      <div class="">
		<div class="row ">
			<div class="col-sm-12 ">
			<div class="table-responsive">
			  <table class="table ">
			<thead>
			  <tr class="text-center table-hd">
				<th class="text-center">Date</th>
				<?php if($cmp=='17'){?>
				<th class="text-center">Milestone ID</th>
				<?php } else{?>
				<th class="text-center">Product ID</th>
				<?php }?>
				<th class="text-center">Dealmaker order ID</th>
				<th class="text-center">Order Placed By</th>
				<th class="text-center">Payment from</th>
				<th class="text-center">Payment to</th>
				<th class="text-center">Amount Received</th>
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
	  
	  
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-danger" data-dismiss="modal">Close</button>
        
      </div>
    </div>
  </div>
</div>
	
</section>	

<link rel="stylesheet" href="<?php echo base_url();?>css/jquery.dataTables.min.css"></style>
<script type="text/javascript" src="<?php echo base_url();?>js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/datepiker/zebra_datepicker.js"></script>
<script>

$(document).ready(function() {
	
 	$(".clickable").click(function() {
		var id = $(this).attr('id');
	
		var target = '.'+id;
		var target1 = '#icon_'+id;
	
				if($(target).hasClass("out")) {
					$(target).addClass("in");
					$(target).removeClass("out");
					$(target1).removeClass("fa-minus-circle");
					$(target1).addClass("fa-plus-circle");
				} else {
					$(target).addClass("out");
					$(target).removeClass("in");
					$(target1).removeClass("fa-plus-circle");
					$(target1).addClass("fa-minus-circle");
				}
	
	});
	/* 
   var table = $('#tab').dataTable();
	$('#tab thead .filter').each(function (i) 
	{
		var title = $('#tab thead .filter').eq($(this).index()).text();
		// or just var title = $('#sample_3 thead th').text();
		var serach = '<input type="text" class="form-control" placeholder="Search ' + title + '" />';
		$(this).html('');
		$(serach).appendTo(this).keyup(function(){table.fnFilter($(this).val(),i)})
	}); */
	//$('#tab').DataTable();
	
	$('.view_mlileston_detail').on("click",function(){
		var order=$(this).attr('data-id');
		var mileston=$(this).attr('data');
		if('<?php echo $cmp;?>'=='17'){
		$.post("<?php echo base_url();?>index.php/order/getmilestone",{ order_id: order,mileston_id: mileston},
			function(data) 
			{
				var parsed = $.parseJSON(data);
				console.log(parsed);
				$(parsed).each(function( index, element ){
					$('#myModalLabel').text(element['product_name']);
					$('#add_date').text(element['add_date']);
					$('#mileston_id').text(element['id']);
					$('#orderid').text(element['orderid']);
					$('#first_name').text(element['payer_name']+'@dealmaker.com/');
					$('#payee_email').text(element['payee_email']);
					$('#payer_email').text(element['payer_email']);
					$('#milestone_amount').text('<?php echo $currency_symbol;?>'+element['amount']);
					$('#product_id').html('<strong>Product ID: </strong>'+element['order_id']);
					$('#orderid').html(element['order_id']);
					$('#product_name').html('<strong>Product : </strong>'+element['product_name']);
					$('#quantity').text(element['quantity']);
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
					else
					{
						st='Completed';
					}
					$('#status').html('<strong>Status : </strong>'+st);
					$("#popen").trigger("click");
				});
				
			}
		);
		}
		else 
		{
			$.post("<?php echo base_url();?>index.php/order/getproduct",{ order_id: order,product_id: mileston},
			function(data) 
			{
				
				var parsed = $.parseJSON(data);
				console.log(parsed);
				$(parsed).each(function( index, element ){
					$('#myModalLabel').text(element['product_name']);
					$('#add_date').text(element['add_date']);
					$('#mileston_id').text(element['id']);
					$('#orderid').text(element['orderid']);
					$('#first_name').text(element['payer_name']+'@'+element['company_url']);
					$('#payee_email').text(element['payee_email']);
					$('#payer_email').text(element['payer_email']);
					$('#company_url').html('<strong>Vendor URL : </strong>'+element['company_url']);
					
					$('#milestone_amount').text('<?php echo $currency_symbol;?>'+element['total']);
					
					$('#product_id').html('<strong>Product ID: </strong>'+element['order_id']);
					$('#orderid').html(element['order_id']);
					$('#product_name').html('<strong>Product : </strong>'+element['product_name']);
					$('#quantity').html('<strong>Quantity : </strong>'+element['quantity']);
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
					$('#status').html('<strong>Status : </strong>'+st);
					$("#popen").trigger("click");
				});
				
			}
		);
		}
	});
} );


</script>


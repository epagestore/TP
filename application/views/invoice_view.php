<?php include("inner_menu.php");?>
<div class="seperator">
</div>
<section class="container">

<div class="row bottom-margin " onclick="pdf_export()"><span class="pull-right"> <button type="button" class="btn btn-success  "><i class="glyphicon glyphicon-print"></i>  Export PDF </span>
</div> 
<div class="row detail-block">
<h3 class="text-orange">MyInvoice Detail</h3>
	<div class="col-sm-12" >
	<div class="row bottom-margin">
	  <div class="col-sm-10">
	  <span class="pull-left"><strong>Name:</strong> <?php echo $invoice[0]['first_name']." ".$invoice[0]['last_name'] ?> <br>
	  <strong>Invoice Id:</strong> <?php echo $invoice[0]['invoice_id'] ?> <br>
	  <strong>Invoice Date:</strong> <?php echo $invoice[0]['date_added'] ?> <br>
	  <strong>Amount Due:</strong> <?php echo $currency_symbol;?><?php echo sprintf ("%.2f", $invoice[0]['total']*$value); ?>
	  </span>
	  </div>
	  <div class="col-sm-2">
	  <span class="pull-right"><img src="<?php if($invoice[0]['photo']!=''){echo base_url().$invoice[0]['photo'];}else { echo  base_url()."images/no_image.gif";} ?>"width="80" height="70"/></span>
	  </div>
	  </div>
	  
	  <div class="row">
		<div class="col-sm-12">
		<div class="table-responsive">
		
	  <table class="table ">
	<thead>
      <tr class="text-center table-hd">
        <th class="text-center">Item</th>
        <th class="text-center">Description</th>
        <th class="text-center">Unit Cost</th>
		<th class="text-center">Quantity</th>
		<th class="text-center">Tax</th>
		<th class="text-center">Prize($)</th>
		
      </tr>
    </thead>
	 <tbody>
	    
		 <?php $subtotal=0;foreach($invoice_order as $order):?>
		  <tr class="text-center">
			
			<th><?php echo $order['item']?></td>
			<td style="max-width:100px;"><?php echo $order['description']?></td>
			<td> <?php echo $currency_symbol." ".sprintf ("%.2f", $order['unit_price']);?> </td>
			<td><?php echo $order['quantity']?></td>
			<td><?php echo $order['tax']?>%</td>
			<td><?php $amount=$order['quantity']*$order['unit_price']; echo $currency_symbol." ".sprintf ("%.2f", ($amount+($amount*$order['tax']/100))*$value); $subtotal+=$amount+($amount*$order['tax']/100);?></td>
		  </tr>
		 <?php endforeach;?>
	
    </tbody>
	  </table>
	</div>
	</div>	
		
	  </div>
	  
	  <div class="row">
	  <div class="col-sm-12 text-right amount-block">
	 <p> <span>sub Total:</span> <strong><?php echo $currency_symbol;?><?php echo sprintf ("%.2f", $subtotal*$value); ?></strong> </p>
	 <p> <span>GST-<?php echo $invoice[0]['discount'].$invoice[0]['discount_type'] ?>:</span><strong> <?php echo $currency_symbol;?><?php echo sprintf ("%.2f", (($subtotal*$invoice[0]['discount'])/100)*$value); ?></strong></p>
	 <p style="border-bottom:1px solid #ddd;"></p>
	 <p><span>Total:</span> <strong>	<?php echo $currency_symbol;?><?php echo sprintf ("%.2f", ($invoice[0]['total'])*$value); ?></strong></p>
	 <p><span>Amount Paid</span><strong>-<?php if($invoice[0]['status']=='3') echo $invoice[0]['total'];else echo "0.00";?></strong></p>
	 
	 <p class="bg-orange"><span>Balance Due:</span><strong><?php echo $currency_symbol;?><?php if($invoice[0]['status']!='3') echo sprintf ("%.2f", ($invoice[0]['total'])*$value);else echo "0.00";?>	</strong></p>
	  </div>
	  </div>
	  
	  <div class="row">
	 <div class="col-sm-12">
	 <h4 class="text-sky">Terms and Conditions:</h4>
	 <p style="max-width:100px;"><?php echo ($invoice[0]['terms'])?> </p>
	 
	 <h4 class="text-sky">Other Comments From service provider:</h4>
	 <p><?php echo ($invoice[0]['notes'])?></p>
	</div>
	</div> 
	
	</div>
	
</div>


<!-- Modal -->
</section>


<script>
function pdf_export()
{
	url= '<?php echo base_url();?>index.php/invoice/pdf_export/<?php echo ($invoice[0]['invoice_id'])?>';
	window.location=url;
				
}
</script>	
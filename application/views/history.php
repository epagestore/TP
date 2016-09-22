<?php include("inner_menu.php");?>

<div class="seperator">
</div>
<style>
.filter input {
        width: 100%;
       
    }
	
</style>
<section class="container">
<div class="row">
<div class="col-sm-12 col-xs-12">
<link rel="stylesheet" href="<?php echo base_url();?>css/datepiker/default.css" type="text/css">
<link rel="stylesheet" href="<?php echo base_url();?>css/jquery.dataTables.min.css"></style>


<script type="text/javascript" src="<?php echo base_url();?>plugin/datatable/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>plugin/datatable/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>plugin/datatable/buttons.flash.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>plugin/datatable/jszip.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>plugin/datatable/pdfmake.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>plugin/datatable/vfs_fonts.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>plugin/datatable/buttons.html5.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>plugin/datatable/buttons.print.min.js "></script>

<script type="text/javascript" src="<?php echo base_url();?>js/datepiker/zebra_datepicker.js"></script>

<div class="table-details">
<div class="table-layout">
<div class="welcom-note">
<ul class="nav nav-tabs hidden-xs " role="tablist">
	<li role="presentation" class="active"><a href="#transaction" aria-controls="transaction" role="tab" data-toggle="tab"><i class="fa fa-history animated fadeInDown fa-2x"></i> Transaction History</a></li>
	<?php //if(count($transactions[1])>0){?>
	<li role="presentation"><a href="#commission" aria-controls="commission" role="tab" data-toggle="tab"><i class="fa fa-magic fa-2x"></i> Commission History</a></li>
	<?php //} ?>
</ul>
<div class="tab-content" style="min-height:450px">
<div role="tabpanel" class="tab-pane active " id="transaction"> 
<br />
<?php //echo "<pre>"; print_r($transactions[0]);?>
<div class="table-responsive" id="dvData">
<table class="table " id="tab">
	<thead>
		  <tr class="text-center table-hd">
			<th>Date</th>
			<th>Transaction ID</th>
			<th>PAYMENT ID</th>
			<th>Vendor</th>
			<th>Description</th>
			<th>Credit</th>
			<th>Debit</th>
			<th>Total Amount</th>
			
		  </tr>
	</thead>
	<thead>
		<tr>
			<th rowspan="1" class="filter" colspan="1"></th>
			<th rowspan="1" class="filter" colspan="1"></th>
			<th rowspan="1" class="filter" colspan="1"></th>
			<th rowspan="1" class="filter" colspan="1"></th>
			<th rowspan="1" class="filter" colspan="1"></th>
			<th rowspan="1" class="filter" colspan="1"></th>
			<th rowspan="1" class="filter" colspan="1"></th>
			<th rowspan="1" class="filter" colspan="1"></th>
			
		</tr>
	</thead>
	<tbody id="fbody">
	<?php $i=1;$transaction_total=$balance['amount']; foreach($transactions[0] as $transaction):?>
      <tr>
        <td><?php date('d M Y',strtotime($transaction['date_added']))?> <?php echo  date('Y-m-d h:i A',strtotime($transaction['date_added']))?></td>
        <td><?php echo $transaction['transaction_id'];?></td>
		<td><?php echo is_numeric($transaction['order_id']) ? $transaction['order_id'] : '-'; ?>&nbsp;</td>
        <td><small><?php echo $transaction['company_name'];?><?php if(!isset($transaction['payer_id'])){if($customer_id=$transaction['payer_id']){echo $transaction['payee_name'];}else{echo isset($transaction['payer_name'])&& !empty($transaction['payer_name']) ? $transaction['payer_name'] : '';}} else{if($customer_id=$transaction['payer_id']){echo isset($transaction['payee_name1'])&& !empty($transaction['payee_name1']) ? $transaction['payee_name1'] : '';}else{echo isset($transaction['payer_name'])&& !empty($transaction['payer_name']) ? $transaction['payer_name'] : '';}} if($transaction['description'] == "Amount received"){echo "QuickSettler(I)"; } if($transaction['description'] == "Amount sent"){echo "QuickSettler(S)"; } if($transaction['description'] == "Amount request"){echo "QuickSettler(R)"; } echo (isset($transaction['deposite_by']) && $transaction['deposite_by']!='' ) ? 'Transferred from: '.$transaction['deposite_by']:'';?></small></td>
        <td><small><?php if($transaction['description'] == "Amount request"){echo "Requested money";} else if($transaction['description'] == "Amount sent"){echo "Sent money"; } else if($transaction['description'] == "Amount received"){echo "Payment received"; }else{ echo $transaction['description']; }?></small></td>
        <td><?php if($transaction['amount']>0){ echo $currency_symbol;?><?php echo sprintf("%.2f", (abs($transaction['amount']))*$value); }else{ echo "-"; } ?></td>
        <td><?php if($transaction['amount']<0){echo $currency_symbol;?><?php echo sprintf("%.2f", (abs($transaction['amount']))*$value); }else{ echo "-"; }?></td>		
        
		<td>
		<?php if($i!=1){?>
		<?php if($transaction['amount']>0 ){?>
		
			<?php $transaction_total=sprintf("%.2f", (abs($transaction_total))*$value) - sprintf("%.2f", (abs($transaction['amount']))*$value);	?>
			
		<?php }else{?>
			<?php $transaction_total=sprintf("%.2f", (abs($transaction_total+$transaction['amount']))*$value);	?>
		<?php }?>
		<?php }?>
			<?php echo $currency_symbol; echo number_format(sprintf("%.2f", (abs($transaction_total))*$value),2);?>	
		</td>
      </tr>
	  <?php $i++; endforeach?>
    </a>
    </tbody>
	
</table>
</div>
</div>
<?php //if(count($transactions[1])>0){?>
<!----------------------commission start-------------------------->
<div role="tabpanel" class="tab-pane" id="commission"> 
<br />
<?php if(count($transactions[1])>0){?>
<div class="table-responsive">
<table class="table " id="tab1" style="width:100%;">
	<thead>
		  <tr class="text-center table-hd">
			<th>Date</th>
			<th>Transaction ID</th>
			<th>PAYMENT ID</th>
			<th>Vendor</th>
			<th>Description</th>
			<th>Credit</th>
			<th>Debit</th>
		  </tr>
	</thead>
	<thead>
		<tr>
			<th rowspan="1" class="filter" colspan="1"></th>
			<th rowspan="1" class="filter" colspan="1"></th>
			<th rowspan="1" class="filter" colspan="1"></th>
			<th rowspan="1" class="filter" colspan="1"></th>
			<th rowspan="1" class="filter" colspan="1"></th>
			<th rowspan="1" class="filter" colspan="1"></th>
			<th rowspan="1" class="filter" colspan="1"></th>
			
		</tr>
	</thead>
	<tbody id="fbody">
	<?php $i=1; foreach($transactions[1] as $transaction):?>
      <tr>
        <td><?php date('d M Y',strtotime($transaction['date_added']))?> <?php echo  date('Y-m-d h:i A',strtotime($transaction['date_added']))?></td>
        <td><?php echo $transaction['transaction_id'];?></td>
      <td><?php echo $transaction['order_id'];?>&nbsp;</td>
        <td><small><?php echo $transaction['company_name']." / ".$transaction['payee_name'];?><?php if(!isset($transaction['payer_id'])){if($customer_id=$transaction['payer_id']){echo $transaction['payee_name'];}else{echo isset($transaction['payer_name'])&& !empty($transaction['payer_name']) ? $transaction['payer_name'] : '';}} else{if($customer_id=$transaction['payer_id']){echo isset($transaction['payee_name1'])&& !empty($transaction['payee_name1']) ? $transaction['payee_name1'] : '';}else{echo isset($transaction['payer_name'])&& !empty($transaction['payer_name']) ? $transaction['payer_name'] : '';}} if($transaction['description'] == "Amount received"){echo "QuickSettler(I)"; } if($transaction['description'] == "Amount sent"){echo "QuickSettler(S)"; } if($transaction['description'] == "Amount request"){echo "QuickSettler(R)"; }?></small></td>
        <td><small><?php if($transaction['description'] == "Amount request"){echo "Requested money";} else if($transaction['description'] == "Amount sent"){echo "Sent money"; } else if($transaction['description'] == "Amount received"){echo "Payment received"; }else{ echo $transaction['description']; }?></small></td>
        <td><?php if($transaction['amount']>0){ echo $currency_symbol;?><?php echo sprintf("%.2f", (abs($transaction['amount']))*$value); }else{ echo "-"; } ?></td>
        <td><?php if($transaction['amount']<0){echo $currency_symbol;?><?php echo sprintf("%.2f", (abs($transaction['amount']))*$value); }else{ echo "-"; }?></td>		
      </tr>
	  <?php $i++; endforeach?>
    </a>
    </tbody>
	
</table>
</div>
<?php } ?>
<?php if(!isset($transactions[1]) || count($transactions[1])<=0){?>
	<div class="row">
		<div class="col-sm-12 ">
			<div class=" box-warning box-solid " style="background:#C9302C">
				<div class="row bottom-margin center-block " >
					<h2 class="text-white"  style="font-size:3em;padding-left:1%;"><i class="fa fa-exclamation-triangle"></i> Note: It is only for thirdparty accounts !!! </h2>
				</div>
			</div>
		</div>
	</div>
<?php } ?>
<!----------------------commission end-------------------------->

</div>



</div>
</div>
</div>
</div>
</div>
</section>

<script>



$("#searchInput").keyup(function() {
	var rows = $("#fbody").find("tr").hide();
	var data = this.value.split(" ");
	$.each(data, function(i, v) {
		rows.filter(":contains('" + v + "')").show();
	});
});
$(document).ready(function() {
	$('#tab').css("width","100%");
   var table =$('#tab,#tab1').dataTable( { dom: 'Blfrtip',
        buttons: [
		{
			extend: 'excel',
            title: 'Transaction History'
		},
		{
			extend: 'pdf',
            title: 'Transaction History'
		},
		{
			extend: 'print',
            title: 'Transaction History'
		}           
        ],"order": [[1, "desc" ]]});
		//$("#commission").removeClass("active");
	/* $('#tab thead .filter').each(function (i) 
	{
		var title = $('#tab thead .filter').eq($(this).index()).text();
		// or just var title = $('#sample_3 thead th').text();
		var serach = '<input type="text" class="form-control" placeholder="Search ' + title + '" />';
		$(this).html('');
		$(serach).appendTo(this).keyup(function(){table.fnFilter($(this).val(),i)})
	}); */
	//
} );
</script>

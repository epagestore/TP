
<?php include("inner_menu.php");?>

<style>
label.error{width:100%; float:left;}
</style>
<section class="container">
<div class="row">
<h3 class="text-center text-danger"><?php if(isset($error)) echo $error;?></h3>

	<div class="col-md-4 col-xs-12 col-sm-12 panel panel-primary">
	<h3 class="text-orange">Request Money </h3>
	<form action="" method="post" id="form-request-money">
	<div class="row bottom-margin">
		<!--<h5>Enter Email or Mobile </h5> -->
	 <div class="col-xs-12 col-sm-4 col-md-4">
		 
		 <select name="request_to" class="form-control">
					<option value="email">Email</option>
					<?php /* <option value="mobile">Mobile</option> */?>
		</select>
		
	  </div>
	  <div class="col-xs-12 col-sm-8 col-md-8">
		<input type="text" name="contact" class="form-control" placeholder="Enter Email or Mobile">
	   </div>
  
	</div>
	<div class="row bottom-margin">
			<!--<h5>Amount </h5> -->
	  <div class="col-xs-12 col-sm-4 col-md-4">
		  <select name="currency" class="form-control">
									<option value="USD">USD</option>
									<option value="NGN">NGN</option>
									<option value="GBP">GBP</option>
		  </select>
	 </div>
	  <div class="col-xs-12 col-sm-8 col-md-8">
		<input type="text" name="amount" id="amount" class="form-control" placeholder="Amount">
		<label id="valsu" style="display:none">*Insufficient Amount</label>
	  </div>
  
	</div>
	<div class="row bottom-margin">
		<!--<h5>Reason For Sending Money</h5>-->
	  <div class="col-xs-12">
		  
		 <select name="reason"  class="form-control">
									<option value=""> Select Reason For Receiving Money</option>
									<?php foreach($reasons as $reason):?>
								<option value="<?php echo $reason['reason_id'];?>"><?php echo $reason['description'];?></option>
							<?php endforeach;?>
		</select>
	  </div>
	 </div>
	 <div class="row bottom-margin">
		
		 <div class="col-xs-12">
		
		 <input type="submit" name="ok"  class="btn btn-primary  btn-block" value="Continue">
		 
		 </div>
  
	</div>
	
	</form>
	
   </div>
	<div class="col-md-8 col-xs-12 col-sm-12">
		<?php if(isset($_GET['received'])){ ?>
		<h3 class="text-orange">Receieved Money List <a class="btn btn-success pull-right" href="<?php echo base_url();?>request_money">Requested Money</a></h3>
		<?php }else{ ?>
		<h3 class="text-orange">Requested money List <a class="btn btn-primary pull-right" href="<?php echo base_url();?>request_money?received"> Received Money</a></h3>
		<?php } ?>
		<div class="table-responsive">
		<table class="table dataTable" id="tab">
		<?php if(isset($_GET['received'])){ ?>
			<thead>
					<tr class="text-center table-hd">
					<th>#Id  </th>
					<th>Amount Sent(<?php echo $currency_symbol; ?>)</th>
					<th>Receieved From</th>					
					<th>Reason</th>
					<th>Date</th>
					<th>Status</th>
				  </tr>
			</thead>
			<tbody id="fbody">
				<?php if(count($receieved_list)>0){ foreach($receieved_list as $sl){?>
				<tr>
					<td rowspan="1"><?php echo $sl['invoice_id']; ?></td>
					<td rowspan="1"><?php echo (($sl['amount'])/$cf_array[$sl['currency']]*$value); ?></td>
					<td rowspan="1" class="filter" colspan="1"><?php echo $sl['receiever_name']; ?></td>					
					<td rowspan="1" class="filter" colspan="1"><?php echo $sl['description']; ?></td>
					<td rowspan="1" class="filter" colspan="1"><?php echo date("M jS Y H:i A",strtotime($sl['date_added'])); ?></td>
					<td rowspan="1" class="filter" colspan="1"><?php echo $sl['status']==1?'<a class="btn btn-link" href="'.site_url('send_money/confirm')."/".$sl['invoice_id'].'">Enter Key</a>':'Received'; ?></td>
			<?php }} ?>
			</tbody>
		<?php }else{ ?>
			<thead>
					<tr class="text-center table-hd">
					<th>#Id  </th>
					<th>Amount Sent(<?php echo $currency_symbol; ?>)</th>
					<th>Requested From</th>					
					<th>Reason</th>
					<th>Date</th>
					<th>Status</th>
				  </tr>
			</thead>
			<tbody id="fbody">
				<?php if(count($request_list)>0){ foreach($request_list as $sl){?>
				<tr>
					<td rowspan="1"><?php echo $sl['invoice_id']; ?></td>
					<td rowspan="1"><?php echo (($sl['amount'])/$cf_array[$sl['currency']]*$value); ?></td>
					<td rowspan="1" class="filter" colspan="1"><?php echo $sl['contact']; ?></td>					
					<td rowspan="1" class="filter" colspan="1"><?php echo $sl['description']; ?></td>
					<td rowspan="1" class="filter" colspan="1"><?php echo date("M jS Y H:i A",strtotime($sl['date_added'])); ?></td>
				<td rowspan="1" class="filter" colspan="1"><?php if($sl['status']==1){echo 'Requested'; } if($sl['status']==2){echo 'Saved/Received'; } if($sl['status']==-1){echo 'Declined';} ?></td>
			<?php }} ?>
			</tbody>
			
		
		<?php } ?>
		</table>
		</div>
	</div>
</div>
</section>

<link rel="stylesheet" href="<?php echo base_url();?>css/jquery.dataTables.min.css">
<script type="text/javascript" src="<?php echo base_url();?>js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/datepiker/zebra_datepicker.js"></script>
<script>
	$("#form-request-money").validate({
		 
		 rules: {
            request_to: "required",
			contact: "required",
			amount:{required:true,number:true},
			reason: "required"
			
        },
        // Specify the validation error messages
        messages: {
            reason: "* Please enter despute reason",
			contact: {required:"* Please enter contact info"},
			amount: {required:"* Please enter amount"},
			
        },
        
        submitHandler: function(form) {
            form.submit();
        }
		
	});
	$(document).ready(function(){
		$('input[name="amount"]').on('keydown',function(){
			if($(this).autoNumeric('get')<=<?php echo  $balance[0]['amount']?>)
			{
				$('#valsu').css('display','none');
			}
		});
		$('input[name="amount"]').on('keyup',function(){
		
			if($(this).autoNumeric('get')><?php echo  $balance[0]['amount']?>)
			{
				//$(this).attr("disabled","disabled");
				$('#valsu').css('display','block');
			}
			
		});
	
	});
$(document).ready(function() {
	
   var table =$('#tab').dataTable( { dom: 'Blfrtip',
			"bJQueryUI": false,
            'iDisplayLength': 5,
            'bLengthChange': true,
        buttons: [
		          
        ],"order": [[0, "desc" ]]});
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

















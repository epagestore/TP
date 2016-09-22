
<?php include("inner_menu.php");?>

<style>
label.error{width:100%; float:left;color:red;font-weight:normal;}
</style>
<section class="container">

<div class="row">
<h3 class="text-center text-danger"><?php if(isset($error)) echo $error;?></h3>
	<div class="col-md-4 col-xs-12  col-sm-12 panel panel-primary">
	<h3 class="text-orange">SendMoney </h3>
	<form action="" method="post" id="form-send-money">
	<div class="row bottom-margin">
		<!--<h5>Enter Email or Mobile </h5> -->
	  <div class="col-xs-12 col-sm-4 col-md-4">
		 
		 <select name="send_to" class="form-control">
			<option value="email">Email</option>
			<option value="mobile">Mobile</option> 
		</select>
	  </div>
	  <div class="col-xs-12 col-sm-2 col-md-2 hidden" id="phone_code">
		<select class="selectpicker form-control " data-live-search="true"  name="phonecode" id="phonecode" data-size="5">
			<?php foreach($phonecode as $p): ?>
			<option <?php if(isset($profile['phonecode']) && $profile['phonecode']!=0 && $profile['phonecode'] == $p['phonecode']) {echo "selected";} ?> value="<?php echo $p['phonecode'];?>"  data="<?php echo $p['iso']?>"><?php echo '+'.$p['phonecode']?></option>
			<?php endforeach;?>
		</select>
	  </div>
	  <div class="col-xs-12 col-sm-8 col-md-8">
		<input type="text" name="contact" class="form-control" placeholder="Enter Email ">
	  </div>
  
	</div>
	<div class="row bottom-margin">
			<!--<h5>Amount </h5> -->
	  <div class="col-xs-12 col-sm-4 col-md-4">
		  <select name="currency" class="form-control ">
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
									<option value=""> Select Reason For Sending Money</option>
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
		<?php if(isset($_GET['requested'])){ ?>
		<h3 class="text-orange">Request Money List <a class="btn btn-success pull-right" href="<?php echo base_url();?>send_money">Send Money</a></h3>
		<?php }else{ ?>
		<h3 class="text-orange">Send Money List <a class="btn btn-primary pull-right" href="<?php echo base_url();?>send_money?requested">Requested Money</a><?php if(isset($requested_list_count) && $requested_list_count>0) {?><span id="requested_list_count" class="round img-circle text-center"><?php  echo $requested_list_count;?></span><?php }?></h3>
		<?php } ?>
		<div class="table-responsive">
		<table class="table " id="tab">
		<?php if(!isset($_GET['requested'])){ ?>
			<thead>
					<tr class="text-center table-hd">
					<th>#Id&nbsp;&nbsp;  </th>
					<th>Amount Sent(<?php echo $currency_symbol; ?>)</th>
					<th>Sent to</th>					
					<th>Reason</th>
					<th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Date&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th >
					<th>Status</th>
					<th>Key</th>
				  </tr>
			</thead>
			<tbody id="fbody"><??>
				<?php if(count($send_list)>0){ foreach($send_list as $sl){?>
				<tr>
					<td rowspan="1"><?php echo $sl['invoice_id']; ?></td>
					<td rowspan="1"><?php echo (($sl['amount'])/$cf_array[$sl['currency']]*$value); ?></td>
					<td rowspan="1" class="filter" colspan="1"><?php echo $sl['contact']; ?></td>					
					<td rowspan="1" class="filter" colspan="1"><?php echo $sl['description']; ?></td>
					<td rowspan="1" class="filter" colspan="1" width="10%" ><?php echo  date('M jS Y g:i A',strtotime($sl['date_added'])); ?></td>
					<td rowspan="1" class="filter" colspan="1"><?php echo $sl['status']==1?'Sent':'Received'; ?></td>
					<td rowspan="1" class="filter" colspan="1"><?php echo $sl['key']; ?></td>
					
			<?php }} ?>
		<?php }else{ ?>
				<thead>
					<tr class="text-center table-hd">
					<th>#Id&nbsp;&nbsp;  </th>
					<th>Amount Sent(<?php echo $currency_symbol; ?>)</th>
					<th>Requested From</th>					
					<th>Reason</th>
					<th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Date &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
					<th>Status</th>
				  </tr>
			</thead>
			<tbody id="fbody">
				<?php if(count($request_list)>0){ foreach($request_list as $sl){?>
				<tr>
					<td rowspan="1"><?php echo $sl['invoice_id']; ?></td>
					<td rowspan="1"><?php echo (($sl['amount'])/$cf_array[$sl['currency']]*$value); ?></td>
					<td rowspan="1" class="filter" colspan="1"><?php echo $sl['requester_name']; ?></td>					
					<td rowspan="1" class="filter" colspan="1"><?php echo $sl['description']; ?></td>
					<td rowspan="1" class="filter" colspan="1"><?php echo  date('M jS Y g:i A',strtotime($sl['date_added'])); ?></td>
				<td rowspan="1" class="filter" colspan="1"><?php if($sl['status']==1){echo '<a  class="btn btn-link" href="'.base_url().'request_money/approve_request/'.$sl['invoice_id'].'">Accept/Decline'; } if($sl['status']==2){echo 'Saved/Sent'; } if($sl['status']==-1){echo 'Declined';} ?></td>
			<?php }} ?>
			</tbody>
		<?php } ?>
			</tbody>
		</table>
		</div>
	</div>
</div>
</section>

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

<script>
$('#phone_code').css({'paddind-left':'0px','padding':'0px'});
$('select[name="send_to"]').change(function(){
	if($('select[name="send_to"] option:selected').val() == 'mobile')
	{	
		$('input[name="contact"]').parent().removeClass('col-md-8');
		$('input[name="contact"]').parent().addClass('col-md-6');
		$('#phone_code').removeClass('hidden');
		$('input[name="contact"]').attr('placeholder','Enter Mobile');	
	}
	else
	{
		$('input[name="contact"]').attr('placeholder','Please Enter Email');	
		$('input[name="contact"]').parent().removeClass('col-md-6');
		$('input[name="contact"]').parent().addClass('col-md-8');
		$('#phone_code').addClass('hidden');
	}
		
});
//alert('<?php echo $balance[0]['amount']?>');
	$("#form-send-money").validate({
		 
		 rules: {
            send_to: "required",
			contact: "required",
			amount:{required:true,number:true},
			reason: "required"
			
        },
        // Specify the validation error messages
        messages: {
            reason: "* Please Select reason for Send Money",
			contact: {required:"* Please enter contact info"},
			amount: {required:"* Please enter amount",},
			
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

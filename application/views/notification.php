<?php //echo "<pre>";  print_r($notif);?>
<div class="seperator">
</div>
<section class="container">
<div class="row">
<div class="col-xs-12 col-sm-12 col-md-12">

  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#all" aria-controls="all" role="tab" data-toggle="tab">All</a></li>
    <li role="presentation"><a href="#quick" aria-controls="quick" role="tab" data-toggle="tab">Quicksettler</a></li>
    <li role="presentation"><a href="#dispatcher1" aria-controls="dispatcher1" role="tab" data-toggle="tab">Dispatcher</a></li>
  </ul>

  <!-- Tab panes -->
  <div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="all">
		<div class="seperator">
		</div>
		<div class="table-responsive" style="max-height:500px; overflow-y:scroll;">
		  <table class="table text">
			<thead >
			  <tr class="table-hd">
				<th class="text-left">Discription</th>
				<th class="text-left">Date</th>
			  </tr>
			</thead>
			<tbody id="notify_main">
			  <tr></tr>
			</tbody>
		  </table>
		</div>
	</div>
    <div role="tabpanel" class="tab-pane" id="quick">
			<div class="seperator">
			</div>
			<div class="table-responsive" style="max-height:500px; overflow-y:scroll;">
				<table class="table" id="tab" >
					<thead >
					  <tr class="table-hd">
						<th class="text-left">Discription</th>
						<th class="text-left">Date</th>
					  </tr>
					</thead>
					<tbody>
						<?php rsort($notif['transaction']);
						foreach($notif['transaction'] as $n):?>
							<tr style="width:100%">
								<td class="text-left">
									<a href="<?php echo base_url().'index.php/order/placed_details/'.$n['order_id'];?>"><?php echo $n['description'];?>&nbsp;&nbsp;<b><?php echo $currency_symbol.sprintf("%.2f", (abs($n['amount']))*$value);?></b></a>
								</td>
								<td><span><?php echo date('F jS Y g:i:s A',strtotime($n['date_added']));?></span></td>
							</tr>
						<?php endforeach;?>
						<?php if(count($notif['transaction'])<=0){?>
						<tr class="text-hd text-center">
							<td colspan="2">No Record Found.</td>
						</tr>
						<?php }?>
					<tbody>
				</table>
			</div>
		
	</div>
    <div role="tabpanel" class="tab-pane" id="dispatcher1">
			<div class="seperator">
			</div>
			<div class="table-responsive" style="max-height:500px; overflow-y:scroll;">
				<table class="table" id="tab" >
					<thead >
					  <tr class="table-hd">
						<th class="text-left">Discription</th>
						<th class="text-left">Date</th>
					  </tr>
					</thead>
					<tbody>
						<tr class="text-center">
							<td colspan="2">No Record Found.</td>
						</tr>
					<tbody>
				</table>
			</div>
	</div>
   

</div>
</div>



<!--<div class="col-md-12" style="max-height:500px;overflow-y:scroll">
<div class="table-responsive">
<table class="table" id="tab" >
	<thead>
		<tr>
				<th class="text-center">Description</th>
				<th class="text-center">Date</th>
		</tr>
	</thead>
	<tbody id="notify_main">
		<tr>

		</tr>
	<tbody>
</table>




</div>
</div>-->
</section>
<link rel="stylesheet" href="<?php echo base_url();?>css/jquery.dataTables.min.css"></style>
<script type="text/javascript" src="<?php echo base_url();?>js/jquery.dataTables.min.js"></script>
<script>
$(document).ready(function(){
/*  $('#tab').DataTable();*/
	}); 
	//$('#notify_main').DataTable();
</script>
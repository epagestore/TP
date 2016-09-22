<style>
.data-line{
width: 14%;
float: left;
padding-left: 10px;
text-align: left;

}
.data-line a{padding:7px 4px; width:100%; float:left; text-align:center; font-weight:bold;color:#ffffff;font-family: 'latobold';} 
.design-tab-bar{width:80%; position:relative; display:table;}
.table-layout{ position:relative; display:table;}
</style>
<?php include("inner_menu.php");?>
<div class="seperator">
</div>
<section class="container">
<div class="row">
<h3 class="text-orange">My Invoice</h3>
	<div class="col-sm-12">
	<div class="table-responsive">
	  <table class="table dataTable" id="tab">
	<thead>
      <tr class="text-center table-hd">
        <!--<th class="text-center">Invoice ID</th>-->
        <th class="text-center">Invoice No</th>
        <th class="text-center">Amount</th>
		<th class="text-center">Status</th>
		<th class="text-center">Date issued</th>
		<th class="text-center">Date Paid</th>
		<th class="text-center invoice-list-table"></th>
      </tr>
    </thead>
	 <tbody>
	
	<?php $i=1;foreach($invoices as $invoice):?>
	  <tr class="text-center">
		<!--<td><?php echo $i; ?></td>-->
		<td><?php echo $invoice['invoice_id'];?></td>
		<td><?php echo $currency_symbol;?><?php echo sprintf("%.2f", ($invoice['total'])*$value); ?></td>
		<td><?php if($invoice['status']=='1') echo "Not Sent";else if($invoice['status']=='2') echo "Not Paid"; else if($invoice['status']=='3') echo "Paid"; ?></td>
		<td><?php echo date("M jS Y h:s A", strtotime($invoice['date_added']));?></td>
		<td><?php  if($invoice['date_paid']>0 && $invoice['status']!='1') echo $invoice['date_paid']; else echo "-";?></td>
		<td class="text-right invoice-list-table">
		<?php if($invoice['status']=='1'){?>
		
		<a href="<?php echo base_url();?>index.php/invoice/send_now/<?php echo $invoice['invoice_id'];?>" >
		<button type="button" class="btn btn-success  " data-toggle="tooltip" data-placement="top" title="Send" ><i class="fa fa-send"></i> </button>
		</a>
		<?php }?>
		
		<a  href="<?php echo base_url();?>index.php/invoice/view/<?php echo $invoice['invoice_id'];?>">
		<button type="button" class="btn btn-success  " data-toggle="tooltip" data-placement="top" title="View Detail"><i class="glyphicon glyphicon-eye-open"></i></button>
		</a>
		
       
	
		<div onclick="zoomFrame($(this),event);" data-id="<?php echo $invoice['invoice_id'];?>" class="btn btn-success  " data-toggle="modal" data-target="#myModal" data-tooltip="tooltip" data-placement="top" title="" data-original-title="Preview"><i class="glyphicon glyphicon-zoom-in"></i></div>
		
		
		
		 
		
		<div style="width:100%;display: block;position: absolute; left:10%;">
			
		</div>
	 
		</td>
	  </tr>
	  
	   
	  <?php endforeach; ?>
      
    </tbody>
	  </table>
	</div>
	</div>
	
	
</div>

<!-- -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-dialog-new " role="document">
    <div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title text-orange" id="myModalLabel">Invoice Detail</h4>
		  </div>
		  <div class="modal-body">

		  </div>
		  <div class="modal-footer">
			<button type="button" id="md_close" class="btn btn-default" data-dismiss="modal">Close</button>
		  </div>
    </div>
  </div>
</div>
		
	
</div>

<!-- --->




</section>

<link rel="stylesheet" href="<?php echo base_url();?>css/jquery.dataTables.min.css">
<script type="text/javascript" src="<?php echo base_url();?>js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/datepiker/zebra_datepicker.js"></script>

<script>
$('#tab').dataTable({order:['0','desc']});
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();  
		$('[data-tooltip="tooltip"]').tooltip();
});

function zoomFrame($this,e)
{
	 //$("#view_frame").css('display','block');
	// $("#view_frame").parent().css('top',e.pageY-350);
	 //$("#view_frame").attr('src','	'+$this.attr('data-id'));
	// $("#view_frame").attr('src','<?php echo base_url(); ?>index.php/invoice/view_frame/'+$this.attr('data-id'));
	 $.ajax({
				type: "GET",
				url: '<?php echo base_url(); ?>index.php/invoice/view_frame/'+$this.attr('data-id'),
				success: function (data) {
					var $response=$(data);
					var oneval = $response.filter('section').html();
					$('.modal-body').html(oneval);

				}
			});
}
function outFrame()
{
	$("#view_frame").css('display','none');
	 $("#view_frame").attr('src','');
}
</script>
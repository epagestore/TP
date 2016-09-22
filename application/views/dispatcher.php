<?php  include("inner_menu.php");?>
<link rel="stylesheet" href="<?php echo base_url();?>css/jquery.dataTables.min.css">
<section class="container">
<div class="row">
<div class="col-md-12">
<div class="table-responsive">
<h3 class="text-orange">Dispatch <?php echo $this->session->userdata('req')?'Received':'Sent'; ?> <?php if($this->session->userdata('req')){ ?><a href="<?php echo site_url('dispatcher/req'); ?>?m=0" class="btn btn-orange Dispatcher pull-right"> Go to Dispatch sent</a><?php }else{?> <a href="<?php echo site_url('dispatcher/req'); ?>?m=1" class="btn btn-orange Dispatcher pull-right"> Go to Dispatch Received</a><?php }?><span class="pull-right"></span></h3>

<table id="order-place" width="100%" class="table dataTable">
<thead >
<!--
<tr class="text-center table-hd " style=" border-bottom: 2px solid #0082c8;">

<th colspan="5" style=" border-bottom: 2px solid #0082c8;" > </th>
<th  class="text-center" style=" border-bottom: 2px solid #0082c8;" ></th>
<th colspan="5" class="text-center" style=" border-bottom: 2px solid #0082c8;" >Order Summary</th>
</tr>-->
<tr class="text-center table-hd" style="border-top: 1px solid #0082c8;">
	<!--<th>Secret Key</th>-->
	<!--th>Key </th!-->
	<th style="border-top: 1px solid #0082c8;">S/N</th>
	<?php if($dm==1){?>
    <th style="border-top: 1px solid #0082c8;">Milestone Name</th>
	<?php } else{?>
	<th style="border-top: 1px solid #0082c8;">Product Name</th>
	<?php } ?>
	<th style="border-top: 1px solid #0082c8;">Customer</th>    
	<th style="border-top: 1px solid #0082c8;">Amount</th>    
    <th style="border-top: 1px solid #0082c8;">Order Date</th>
	<th style="border-top: 1px solid #0082c8;" class="hidden">Order Status</th>
    <th style="border-top: 1px solid #0082c8;">Dispatch Date</th>
    <th style="border-top: 1px solid #0082c8;"><?php echo $this->session->userdata('req')?'Transferrer':'Dispatcher'; ?> ID</th>
    <th style="border-top: 1px solid #0082c8;">Delivery Status</th>
	<?php if($this->session->userdata('req')){?>
    <th style="border-top: 1px solid #0082c8;">Action</th>
	<?php } ?>
    <th style="border-top: 1px solid #0082c8;">Detail</th>
</tr>
	 
</thead>
<tbody style="color:black;">
<?php  foreach($orders as $key => $order):?>
	<tr>
		<td><?php echo ($key+1); ?></td>
		<?php if($dm==1){?>
		<td class="text-left"><?php echo $order['milestone_description']; ?></td>
		<?php }else{?>
		<td class="text-left"><?php echo $order['product_name']; ?></td>
		<?php } ?>
		<td><?php echo $order['payer_name']."@".$order['company_name']; ?></td>
		<?php if($dm!=1){?>
		<td><?php echo $currency_symbol;?><?php echo sprintf("%.2f", ($order['total'])*$value); ?></td>
		<?php }else{?>
		<td><?php echo $currency_symbol;?><?php echo sprintf("%.2f", ($order['amount'])*$value); ?></td>
		<?php } ?>
		<td><?php echo  date('M jS Y g:i A',strtotime($order['date_added'])); ?></td>
		
		<?php if($dm!=1){?>
		<td class="hidden"><?php  if($order['order_product_status_id']==9){?>Dispute Resolved<?php } else if($order['order_product_status_id']==7){?>Complete order time expired<?php }elseif($order['order_product_status_id']==5){?>Processing <?php } else if($order['order_product_status_id']==6){?>Completed<?php }else if($order['order_product_status_id']==2){?>Released<?php }else if($order['order_product_status_id']==8){?>Dispute<?php }else{?>Paid <?php }?></td>
		<?php }else{?>
		<td class="hidden"><?php if($order['milestone_status']=='1'){?>paid<?php }else if($order['milestone_status']=='2'){?>Released <?php }else  if($order['milestone_status']=='5'){?>Processing<?php } else { echo "Complete";}?></td>
		<?php } ?>
		<td><?php echo  date('M jS Y g:i A',strtotime($order['dispatcher_date'])); ?></td>
		<td><?php echo $this->session->userdata('req')?$order['transferrer_code']:$order['dispatcher_code']; ?></td>
		
		<?php if($this->session->userdata('req')){?>
		<td id="dp_status"><?php if($order['dispatcher_status']==1){echo " Request received";} if($order['dispatcher_status']==2){?>Accepted <?php }  if($order['dispatcher_status']==3){?>Deliver <?php } if($order['dispatcher_status']==4){?>Completed <?php } if($order['dispatcher_status']==6 || $order['dispatcher_status']==0){?>Rejected <?php }  ?>
	<?php if($order['dispatcher_status']==5) echo "Transferred";?>
		</td>
		<td width="150">
		<?php $order['dispatch_to']; if(($order['dispatcher_status']==1  || ($order['dispatcher_status']==5 || $order['dispatcher_status']==0)) && ($order['dispatch_to']==$this->session->userdata('customer_id'))){ ?>
		<div class="btn btn-info  dp_rejected" data-id="<?php echo $dm!=1?$order['order_product_id']:$order['id'];?>" title="Reject"><i class="fa fa-times"></i></div> <div data-id="<?php echo $dm!=1?$order['order_product_id']:$order['id'];?>" class="btn btn-primary  dp_accepted" title="Accept"><i class="fa fa-list"></i></div>
		
		<?php }else if($order['dispatcher_status']==2 && ($order['dispatch_from']==$this->session->userdata('customer_id'))){ ?>
		<div class="btn btn-success  ds_delivery" data-id="<?php echo $dm!=1?$order['order_product_id']:$order['id'];?>"title="Delivery"><i class="fa fa-truck"></i></div><div class="btn btn-danger  ds_transfer" dt="<?php echo $dm; ?>" data-id="<?php echo $dm!=1?$order['order_product_id']:$order['id'];?>" title="Transfer"><i class="fa fa-send"></i>  </div>			
		
		<?php } else if($order['dispatcher_status']==3 && ($order['dispatch_from']==$this->session->userdata('customer_id'))){ ?>
		<div class="btn btn-success  ds_delivery" data-id="<?php echo $dm!=1?$order['order_product_id']:$order['id'];?>"title="Delivery"><i class="fa fa-truck"></i></div><div class="btn btn-danger  ds_transfer" dt="<?php echo $dm; ?>" data-id="<?php echo $dm!=1?$order['order_product_id']:$order['id'];?>" title="Transfer"><i class="fa fa-send"></i>  </div>
		<?php }	else{ ?>
		------
		<?php } ?>
		</td>
		
		
		<?php }else{ ?>
		<td>
		<?php if($order['dispatcher_status']==1){echo "Request Sent";} ?>
		<?php if($order['dispatcher_status']==2){echo "Accepted";} ?>
		<?php if($order['dispatcher_status']==3){echo "Delivered";} ?>
		<?php if($order['dispatcher_status']==4){echo "Completed";} ?>
		<?php if($order['dispatcher_status']==5){echo "Transferred";} ?>
		<?php if($order['dispatcher_status']==6){echo "Rejected";} ?>
		<?php if($order['dispatcher_status']==0){echo "Rejected";}?>
		
		</td>
		
		<?php 
			//$dc = $ci->db->query("select * from customer where customer_id=".$order['dispatcher_id']); 
			//$dc = $dc->row();
		?>		
		<?php } ?>
		
		<td>
		
		<?php  
		
		if($dm!=1)
		{
			$w=" and order_product_id=".$order['order_product_id'];
		}else{
			$w=" and milestone_id=".$order['id'];
		}
		$dcu= $ci->db->query("select DISTINCT(CONCAT(dispatch_from,',',dispatch_to,',',dispatch_status)) AS cc, dispatch_from as cst,dispatch_to,date_time from dispatch  where (dispatch_status=1 or dispatch_status=5) ".$w." and dispatch_to!=0 group by cc order by dispatch_id asc");
		$dcu=$dcu->result_array(); 
		//echo $this->db->last_query();
		$arr_dtab=array();
		foreach($dcu as $d)
		{
			$arr_y=array();
			$dc= $ci->db->query("select * from customer where customer_id=".$d['cst']); 
			$dc=$dc->row();
			$from_phone=array();
			if($dc->customer_phone)
			{
				$from_phone[]="+".$dc->phonecode." ".$dc->customer_phone .($dc->verify>0?'<span class=\'text-success fa fa-check fa-1x\'></span>':'<span class=\'text-danger fa fa-remove fa-1x\'></span>');
			}

			if($dc->customer_phone1)
			{
				$from_phone[]="+".$dc->phonecode1." ".$dc->customer_phone1 .($dc->verify1>0?'<span class=\'text-success fa fa-check fa-1x\'></span>':'<span class=\'text-danger fa fa-remove fa-1x\'></span>');
			}	
			
			if($dc->customer_phone2)
			{
				$from_phone[]="+".$dc->phonecode2." ".$dc->customer_phone2 .($dc->verify2>0?'<span class=\'text-success fa fa-check fa-1x\'></span>':'<span class=\'text-danger fa fa-remove fa-1x\'></span>');
			}	
			
			
			$arr_y['from']=array("c"=>$dc->customer_id,'name'=>$dc->first_name." ".$dc->last_name,'customer_phone'=>implode(",",$from_phone),'location'=>implode(", ",json_decode($dc->dispatcher_location)),"address"=>$dc->address,"DID"=>$dc->dispatcher_id);
			
			$dc= $ci->db->query("select * from customer where customer_id=".$d['dispatch_to']); 
			$dc=$dc->row();
			$from_phone=array();
			if($dc->customer_phone)
			{
				$from_phone[]="+".$dc->phonecode." ".$dc->customer_phone .($dc->verify>0?'<span class=\'text-success fa fa-check fa-1x\'></span>':'<span class=\'text-danger fa fa-remove fa-1x\'></span>');
			}

			if($dc->customer_phone1)
			{
				$from_phone[]="+".$dc->phonecode1." ".$dc->customer_phone1 .($dc->verify1>0?'<span class=\'text-success fa fa-check fa-1x\'></span>':'<span class=\'text-danger fa fa-remove fa-1x\'></span>');
			}	
			
			if($dc->customer_phone2)
			{
				$from_phone[]="+".$dc->phonecode2." ".$dc->customer_phone2 .($dc->verify2>0?'<span class=\'text-success fa fa-check fa-1x\'></span>':'<span class=\'text-danger fa fa-remove fa-1x\'></span>');
			}		
			$arr_y['to']=array("c"=>$dc->customer_id,'name'=>$dc->first_name." ".$dc->last_name,'customer_phone'=>implode(",",$from_phone),'location'=>implode(", ",json_decode($dc->dispatcher_location)),"address"=>$dc->address,"DID"=>$dc->dispatcher_id);
			
			$arr_dtab[]=$arr_y;
		}
		
		?>
			
		<a href="javascript:;" <?php if(count($arr_dtab>0)){?> data-html="true" data-container="body" data-toggle="popover" data-placement="left" title="<strong><?php echo $this->session->userdata('req')?'Transferred':'Dispatched'; ?></strong> " data-content="
<div class='tab-content clearfix'>
<ul  class='nav nav-pills pull-right ' style='margin-top:-10px;'>
	<?php $onRecord=0; $key=0; foreach($arr_dtab as $dfr){ if($this->session->userdata('customer_id')==$dfr['from']['c'] || $this->session->userdata('customer_id')==$dfr['to']['c']){$onRecord=1;} if($onRecord){?>
	<li class='<?php echo $key==0?"active":'';?>'>
<a  href='#1b<?php echo $key;?>' data-toggle='tab'><?php echo ($key+1); ?></a>
	</li>
	<?php $key++;}} ?>
</ul>
<?php $onRecord=0; $key=0;$dtime=0; foreach($arr_dtab as $dfr){if($this->session->userdata('customer_id')==$dfr['from']['c'] || $this->session->userdata('customer_id')==$dfr['to']['c']){$onRecord=1;} if($onRecord){ ?>
  <div class='tab-pane <?php echo $key==0?"active":'';?>' id='1b<?php echo $key;?>'>
  <span class='bg-orange' style='position:absolute; float:right;right:0px; top:-0px;'><?php echo $dcu[$dtime]['date_time']; $dtime++; ?></span>
  <div class='left-table' style='width:50%; float:left; padding:5px;'>
<strong style='width:30px;'>From</strong>

<table class='table'><tr><td class='text-left' style='width:120px;'>Name</td><td class='text-left'><?php echo $dfr['from']['name']; ?></td></tr><tr><td class='text-left' width='90'>Contact NO.</td><td class='text-left'><?php echo $dfr['from']['customer_phone']; ?></td></tr><tr><td class='text-left'>Jurisdiction</td><td class='text-left'><?php echo $dfr['from']['location']; ?></td></tr><tr><td class='text-left'>Address</td><td class='text-left'><?php echo $dfr['from']['address']; ?></td></tr><tr><td class='text-left'><?php echo $this->session->userdata('req')?$key<=0?"Dispatcher":"Transferrer":'Dispatcher'; ?> ID</td><td class='text-left'><?php echo $dfr['from']['DID']; ?></td></tr></table>
</div>
<div class='right-table' style='width:50%; float:left; padding:5px;  margin-top:-20px;'>
<strong style='width:20px;'>To </strong>

<table class='table pull-right'><tr><td class='text-left' style='width:120px;'>Name</td><td class='text-left'><?php echo $dfr['to']['name']; ?></td></tr><tr><td class='text-left' width='90'>Contact NO.</td><td class='text-left'><?php echo $dfr['to']['customer_phone']; ?></td></tr><tr><td class='text-left'>Jurisdiction</td><td class='text-left'><?php echo $dfr['to']['location']; ?></td></tr><tr><td class='text-left'>Address</td><td class='text-left'><?php echo $dfr['to']['address']; ?></td></tr><tr><td class='text-left'><?php echo $this->session->userdata('req')?'Transferrer':'Dispatcher'; ?> ID</td><td class='text-left'><?php echo $dfr['to']['DID']; ?></td></tr></table>
	</div>
	</div>
	<?php $key++;}} ?>
</div> "<?php }?>><i class="fa fa-exclamation-circle text-orange fa-2x"></i></a></td>
		
	</tr>
   
 		
<?php endforeach?>
 </tbody>
 <tfoot>
			<tr>
				<td colspan="11" class="text-center  btn-primary btn-lg" id="loadMore">Loadmore..</td>
			</tr>
		</tfoot>
</table>
</div>
</div>
</div>



</section>

<script>
$(document).ready(function(){
 $('[data-toggle="popover"]').popover();
	$(document).on('click','body', function (e) {
    $('[data-toggle="popover"]').each(function () {
        if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0) {
            $(this).popover('hide');
        }
    });
});
});
var $c_value=<?php echo $value; ?>;
if($("#order-place tbody tr").length>=20)
{
	$('tfoot').css("display","show");
}
else{
	
	$('tfoot').css("display","none");
	
}


$(document).on("click",'#loadMore',function(){
	
	ajaxindicatorstart('loading data.. please wait..');
	var last_id=$('tr.ld:last').find('td:eq(1)').text();
	
	var $url=window.location.href;
	
	limit_load=$("#order-place tbody tr").length;
	$url=$url+'&limit='+limit_load;
	
		$.ajax({ cache: false,
			url: $url,
			type:"get",
			success: function (data) {
				var v = $(data).find("tbody").html();
			
				if(v.trim()=='')
				{
					$('tfoot').css("display","none");
				}		
				$('#order-place tbody:eq(0)').append(v);
				if($("#order-place tbody tr").length>=20)
				{
					$('#order-place tfoot').css("display","show");
				}
				else{
					$('#order-place tfoot').css("display","none");
				}
			},
			complete: function(data) {
				ajaxindicatorstop();
			}
		});
		
});

var limit_load=0;
$(document).ready(function(){

var selectedDsp='';
$(document).on("click",".product_dispatcher_status",function(){
if(!selectedDsp)
{
	alert("This dispatcher is not active or not selected!");
	return false;
}
var chk=$(this);
	var val1=new Array();
	chk.parent().parent().parent().find("input[name='dispatcher_status[]']").each(function(){
	if($(this).prop('checked')==true){
	
	val1.push($(this).val());
	}
	
	});
	
	$.ajax({
	url:"<?php echo site_url(); ?>order/product_dispatcher_status",
	'type':"post",
	data:{dispatcher_status:val1,dispatch:selectedDsp,transfer:1},
	success:function(){
		$(".alert").fadeOut();
		}
	});
});

$(document).on("click",".milestone_dispatcher_status",function(){
if(!selectedDsp)
{
	alert("This dispatcher is not active or not selected!");
	return false;
}
var chk=$(this);
	var val1=new Array();
	chk.parent().parent().parent().find("input[name='dispatcher_status[]']").each(function(){
	if($(this).prop('checked')==true){
	
	val1.push($(this).val());
	}
	
	});
	
	$.ajax({
	url:"<?php echo site_url(); ?>order/milestone_dispatcher_status",
	'type':"post",
	data:{dispatcher_status:val1,dispatch:selectedDsp,transfer:1},
	success:function(){
		$(".alert").fadeOut();
		}
	});
});


 $(document).on('input','#dispatcher_search', function() {
	var userText = $(this);
	$("#dprs").html('');
	selectedDsp='';
	$("#dispatcherdatalist").find("option").each(function() {
	  if ($(this).val() == userText.val()) {
		$("#dprs").html('<div>'+$(this).attr('data')+'</div>');
		selectedDsp=$(this).attr('dsp_id');
		
	  }
	});
  });

$(document).on("keyup","#dispatcher_search",function(){					
	var ths= $(this);						
	$.ajax({
	url:"<?php echo site_url('dispatcher/searchDispatcher'); ?>",
	type:'POST',
	data:{search:ths.val()},
	success:function(data){
		ths.parent().find("#dispatcherdatalist").html(data);
	}
	});
});

$(document).on("click", ".ds_transfer", function(){
var ths=$(this);
var product_id=$(this).attr('data-id');
var dt=ths.attr('dt');
//var l = $(".dispatcherList").Ladda( 'bind' );
//l.start();
if(dt!='1'){
	$.post("<?php echo base_url();?>index.php/order/getproduct",{order_id:'', product_id: product_id},
	function(data) 
	{
	 $('.alert').hide();
		if(ths.parent().parent().find(".alert").length)
		{
			ths.parent().parent().find(".alert").remove();
		}
	ths.parent().parent().append('<div class="alert" style="overflow:auto; max-height:300px;  width:550px; right:0px; float:left; position:absolute; z-index:1000; background-color:#286090;"><a href="#" class="close" data-dismiss="alert" aria-label="close" title="close" style="color:#fff!important;">×</a></div>');
	//	l.stop();
	var table='';
		var parsed = $.parseJSON(data);
		var  cntPage= parsed.length;
		table="<table style='width:100%'>";
		table=table+"<tr class='border-blue'>";
			table=table+"<th class='text-left'>";
			table=table+"<input id='dispatcher_search' list='dispatcherdatalist' class='text-center' style='color:#444' placeholder='Search Dispatch...'><datalist id='dispatcherdatalist'></datalist>";
			table=table+"</th>";
			table=table+"<th class='text-left'>";
			table=table+"Product Name";
			table=table+"</th>";
			table=table+"<th class='text-left'>";
			table=table+"Price";
			table=table+"</th>";
			table=table+"<th class='text-left'>";
			table=table+"Action";
			table=table+"</th>";
		table=table+"</tr>";	
		console.log(parsed);
		var dp_status=1;
		$(parsed).each(function( index, element ){
			table=table+"<tr>";
			if(index==0){
			table=table+"<td id='dprs' rowspan='"+(cntPage)+"' class='text-left' style='border-right:1px solid #286090'>";
			table=table+'';
			table=table+"</td>";
			}
			
			table=table+"<td class='text-left'>";
			table=table+element['product_name'];
			table=table+"</td>";
			table=table+"<td class='text-left'>";
			
			table=table+'<?php echo $currency_symbol;?>'+(parseFloat(element['total'])*parseFloat($c_value)).toFixed(2);
			table=table+"</td>";									
			table=table+"<td class='text-left'>";
			
			if(element['dispatcher_status']==2 || element['dispatcher_status']==0)
			{
				dp_status=0;
			}
			if(element['dispatcher_status']==1)
			table=table+'Transferred';	
			
			else if(element['dispatcher_status']==3)
			table=table+'Delivered';
			else if(element['dispatcher_status']==4)
			table=table+'Completed';
			else
			{
				table=table+'<input type="checkbox" value="'+element['order_product_id']+'" name="dispatcher_status[]">';
				
			}			
			table=table+"</td>";
			table=table+"</tr>";
		});
		setTimeout(function(){
		if(!dp_status){
			table=table+"<tr>";
			table=table+"<td colspan='1'  style='border-top:1px solid #286090'>";
			table=table+"</td>";
			table=table+"<td colspan='3' style='border-top:1px solid #286090'>";
			table=table+"<div class='btn btn-primary product_dispatcher_status pull-right'>Dispatch</div>";
			table=table+"</td>";
			table=table+"</tr>";
			}
		table=table+"</table>";
		ths.parent().parent().find(".alert").append(table);
		},20)
	});
}else{
	$.post("<?php echo base_url();?>index.php/order/getmilestone",{ order_id: '',mileston_id: product_id},
	function(data) 
	{
	 $('.alert').hide();
		if(ths.parent().parent().find(".alert").length)
		{
			ths.parent().parent().find(".alert").remove();
		}
	ths.parent().parent().append('<div class="alert" style="overflow:auto; max-height:300px;  width:550px; right:0px; float:left; position:absolute; z-index:1000;  background-color:#286090;"><a href="#" class="close" data-dismiss="alert" aria-label="close" title="close" style="color:#fff!important;">×</a></div>');
	//	l.stop();
	var table='';
	var dp_status=1;
		var parsed = $.parseJSON(data);
		var  cntPage= parsed.length;
		table="<table style='width:100%'>";
		table=table+"<tr>";
			table=table+"<th class='text-left'>";
			table=table+"<input id='dispatcher_search' list='dispatcherdatalist' class='text-center' style='color:#444' placeholder='Search Dispatch...'><datalist id='dispatcherdatalist'></datalist>";
			table=table+"</th>";
			table=table+"<th class='text-left'>";
			table=table+"Milestone Name";
			table=table+"</th>";
			table=table+"<th class='text-left'>";
			table=table+"Price";
			table=table+"</th>";
			table=table+"<th class='text-left'>";
			table=table+"Action";
			table=table+"</th>";
		table=table+"</tr>";	
		console.log(parsed);
		$(parsed).each(function( index, element ){
			table=table+"<tr>";
			if(index==0){
			table=table+"<td id='dprs' rowspan='"+(cntPage)+"' class='text-left' style='border-right:1px solid #286090'>";
			table=table+'';
			table=table+"</td>";
			}
			table=table+"<td class='text-left'>";
			table=table+element['milestone_description'];
			table=table+"</td>";
			table=table+"<td class='text-left'>";
			
			table=table+'<?php echo $currency_symbol;?>'+(parseFloat(element['amount'])*parseFloat($c_value)).toFixed(2);
			table=table+"</td>";		
			if(element['dispatcher_status']==2)
			{
				dp_status=0;
			}
			table=table+"<td class='text-left'>";
			if(element['dispatcher_status']==1)
			table=table+'Transferred';	
			
			else if(element['dispatcher_status']==3)
			table=table+'Delivered';
			else if(element['dispatcher_status']==4)
			table=table+'Completed';
			else
			{
				table=table+'<input type="checkbox" value="'+element['id']+'" name="dispatcher_status[]">';
				
			}
			table=table+"</td>";
			table=table+"</tr>";
		});
		setTimeout(function(){
		if(!dp_status){
			table=table+"<tr>";
			table=table+"<td colspan='4'>";
			table=table+"<div class='btn btn-primary milestone_dispatcher_status pull-right'>Dispatch</div>";
			table=table+"</td>";
			table=table+"</tr>";
		}
		table=table+"</table>";
		ths.parent().parent().find(".alert").append(table);		
		},20)
	});

}
});
					
	$(document).on("click",'.dp_rejected',function(){
	var ths=$(this);
	var data_id=$(this).attr('data-id');
		$.ajax({
		url:"<?php echo site_url(); ?>dispatcher/rejected",
		'type':"post",
		data:{dispatch:data_id,m:'<?php echo $dm; ?>'},
		success:function(){
			ths.parent().parent().find("#dp_status").text('Rejected');
			ths.fadeOut();
			ths.parent().html('------');
			}
		});
	});
	
	
	
	$(document).on("click",'.dp_accepted',function(){
	var ths=$(this);
	var data_id=$(this).attr('data-id');	
		$.ajax({
		url:"<?php echo site_url(); ?>dispatcher/accepted",
		'type':"post",
		data:{dispatch:data_id,m:'<?php echo $dm; ?>'},
		success:function(){
			ths.parent().parent().find("#dp_status").text('Accepted');
			ths.parent().parent().fadeOut();
			ths.parent().parent().fadeIn();
			ths.parent().html('<div class="btn btn-success  ds_delivery" data-id="'+data_id+'" title="Delivery"><i class="fa fa-truck"></i></div><div class="btn btn-danger  ds_transfer"  dt="<?php echo $dm; ?>" data-id="'+data_id+'" title="Transfer"><i class="fa fa-send"></i> </div>');
			
			}
		});
	});
	var dpId='';
	var dpths='';
	$(document).on("click",'.ds_delivery',function(){
	var ths=$(this);
	dpths=ths;
	var data_id=$(this).attr('data-id');
	dpId=data_id;
	ths.parent().parent().parent().find(".alert").remove();	
		$.ajax({
		url:"<?php echo site_url(); ?>dispatcher/delivery",
		'type':"post",
		data:{dispatch:data_id,m:'<?php echo $dm; ?>'},
		success:function(){
			/* ths.parent().parent().find("#dp_status").text('Deliver');
			ths.parent().parent().find(".ds_transfer").remove(); */
			ths.parent().parent().append('<div class="alert btn-info" style="overflow:auto; max-height:200px;  width:270px; right:0px; float:left; position:absolute; z-index:1000;"><a href="#" class="close" data-dismiss="alert" aria-label="close" title="close" style="color:#fff!important;">×</a>'+" <input id='dspDelSucess' class='text-center input-sm col-dm-4' style='color:#444' placeholder='Enter Key'> <div class='btn btn-primary ds_delivery_success btn-sm'>Ok</div>"+'</div>');
			
			}
		});
	});
	
	$(document).on("click",'.ds_delivery_success',function(){
	if(!dpId)
	return false;
	var ths=$(this);
	var ths=dpths;
		$.ajax({
		url:"<?php echo site_url(); ?>dispatcher/delivery_success",
		'type':"post",
		data:{dispatch:dpId,m:'<?php echo $dm; ?>',code:$("#dspDelSucess").val()},
		success:function(data){
			if(data=="1")
			{
				ths.parent().parent().find("#dp_status").text('Completed');
				ths.parent().html("------");
				$(".alert").fadeOut();
			}
			else{
				alert("Invalid Key!");
			}
			
			}
		});
	});
	
});



</script>


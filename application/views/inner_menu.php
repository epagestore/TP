<?php $customer_id= $this->session->userdata('customer_id');

	$tp_menu=$this->config->item("tp_menu");
	$uSt='';
	if($this->uri->segment(1))
	{
		$uSt.=$this->uri->segment(1);
	}	
	if($this->uri->segment(2))
	{
		$uSt.="/".$this->uri->segment(2);
	}
	
	$main_menu=array("dashboard"=>"MyAccount","order/order_list"=>"PaymentsMade","order/recived_order_list"=>"PaymentsReceived","send_money"=>"QuickSettler","notification"=>"","despute"=>"");
	 if($cust_detail[0]['dispatcher_location']!='null' && $cust_detail[0]['dispatcher_location']){		
	$main_menu['dispatcher']='Dispatcher';
	 }
	 
	$page_name='';
	$page_key='';
	$page_active='';
	foreach($tp_menu as $im)
	{
		if($im[0]==$uSt)
		{
			 $page_name=$im[0];
			 $page_key=$im[1];
			 $page_active=$im[2];
			 break;
		}
	}
if($this->uri->uri_string()=='order/recived_order_list' || $this->uri->uri_string()=='order/order_list' || $this->uri->uri_string()=='dispatcher'){?>

<script src="<?php echo base_url()?>js/jquery-ui.js"></script>
  <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>jQuery/src/jquery.tagger.css" />
  <script src="<?php echo base_url();?>jQuery/src/jquery.tagger.js"></script>
  <script src="<?php echo base_url();?>jQuery/src/jquery.ddslick.js"></script>

<?php }?>

<section class="main-header">
<?php 

	$sub_menu=array();
	//sub-menu---
	$sub_menu['dashboard']['menu']=array("dashboard","balance_manager","history","despute/receive_list");
	$sub_menu['dashboard']['icon']=array("fa fa-file-text","fa fa-money ","fa fa-history","fa fa-th-list");
	$sub_menu['dashboard']['title']=array("Dashboard"," Money","Transaction History","Dispute Resolution");
	//sub-menu---
	$sub_menu['order/order_list']['menu']=array("order/order_list");
	$sub_menu['order/order_list']['icon']=array("fa fa-external-link");
	$sub_menu['order/order_list']['title']=array("PaymentsMade");	
	//sub-menu---
 	$sub_menu['order/recived_order_list']['menu']=array("order/recived_order_list");
	$sub_menu['order/recived_order_list']['icon']=array("fa fa-file-text");
	$sub_menu['order/recived_order_list']['title']=array("PaymentsReceived"); 
	//sub-menu---
	$sub_menu['send_money']['menu']=array("send_money","request_money","invoice","invoice/list_all");
	$sub_menu['send_money']['icon']=array("glyphicon glyphicon-export","glyphicon glyphicon-import ","glyphicon glyphicon-list-alt ","fa fa-user","th-list");
	$sub_menu['send_money']['title']=array("Send Money","Request Money","Create Invoice","My Invoices");
	
	//sub-menu---
	$sub_menu['myprofile']['menu']=array("myprofile");
	$sub_menu['myprofile']['icon']=array("fa fa-user");
	$sub_menu['myprofile']['title']=array("Myprofile");	
	
	//sub-menu---
	$sub_menu['notification']['menu']=array("notification");
	$sub_menu['notification']['icon']=array("fa fa-bell");
	$sub_menu['notification']['title']=array("Notification");	
	//sub-menu---
	$sub_menu['despute']['menu']=array("despute");
	$sub_menu['despute']['icon']=array("fa fa-th-list");
	$sub_menu['despute']['title']=array("Dispute");	
	//sub-menu---
	$sub_menu['dispatcher']['menu']=array("dispatcher");
	$sub_menu['dispatcher']['icon']=array("fa fa-paper-plane");
	$sub_menu['dispatcher']['title']=array("Dispatcher");	
	
?>
<div class="container mobile-container">
	<!--box-menu-active-->
	<div class="row">
	<div class="col-md-12 ">
		<?php if($page_key ){ /*if($this->uri->uri_string()=='despute/receive_list' || $this->uri->uri_string()=='despute/generate_list'){?>
			<div class=" col-sm-12 col-md-2  col-xs-12 text-center box-menu-active">
			<a  class="menu" href=""><span class="icon"><i class="fa fa-th-list animated fadeInDown"></i></span><span class="animated fadeInUp">Dispute Resolution </span></a>
			</div>
		<?php  } else { */?>
		
		<?php $a_page_title=''; foreach($sub_menu[$page_key]['menu'] as $mkey=> $s_m){?>
		<div class=" col-sm-12 col-md-2 col-xs-12 text-center <?php if($page_active==$s_m) {$a_page_title=$sub_menu[$page_key]['title'][$mkey]; echo "box-menu-active"; }else echo "box-menu"; ?>">
		<a  class="menu" href="<?php echo site_url($s_m);?>"><span class="icon"><i class="<?php echo $sub_menu[$page_key]['icon'][$mkey]; ?> animated fadeInDown"></i></span><span class="animated fadeInUp"><?php echo $sub_menu[$page_key]['title'][$mkey]; ?> </span></a>
		</div>
		
		<?php/*   } */ ?>
		<?php }} ?>
		<?php if($this->uri->uri_string()=='dispatcher'){?>
		<div class="col-sm-12 col-md-6 col-xs-12 box-menu box-menu-search">
			<form class="form-inline search-block">
			<select class="btn-search" id="myDropdown" style="display:none;"></select>
			</form>
		</div>
		<script>
		var ddBasic = [
				{ text: "Product", value: 0,imageSrc:'<?php echo base_url(); ?>img/product.png' },
				{ text: "Service", value: 1,imageSrc:'<?php echo base_url(); ?>img/services.png' },
				{ text: "Invoice", value: 2,imageSrc:'<?php echo base_url(); ?>img/invoice.png' }
				
			];
			$('#myDropdown').ddslick({
				width:130,
				data: ddBasic,
				 defaultSelectedIndex:<?php echo $dm; ?>,
				onSelected: function(selectedData){				
					$("#myDropdown").addClass("pull-left");
					
				  var dd = $('#myDropdown .dd-selected-value').val();
				 
				if(dd=='2')
				 {
				 
					if(window.location.href!="<?php echo site_url('dispatcher?m=2');?>")
					window.location.href="<?php echo site_url('dispatcher?m=2');?>";
				 }
				if(dd=='1')
				 {
				 
					if(window.location.href!="<?php echo site_url('dispatcher?m=1');?>")
					window.location.href="<?php echo site_url('dispatcher?m=1');?>";
				 }
				 
				 if(dd=='0'){
					if(window.location.href!="<?php echo site_url('dispatcher?m=0');?>")
					window.location.href="<?php echo site_url('dispatcher?m=0');?>";
				 }
				 
				 
				 
				  $('#myDropdown .dd-selected').addClass('btn-search');
				 
				$(".suggestions li").addClass("sr-tital");
				
				}
			});
		</script>
		<?php } ?>
		<?php if($this->uri->uri_string()=='order/order_list' || $this->uri->uri_string()=='order/recived_order_list'){
			?>
		<div class="col-sm-12 col-md-6 col-xs-12 box-menu box-menu-search">
			<form class="form-inline search-block">
			<select class="btn-search" id="myDropdown" style="display:none;"></select>
				<ul class="dropdown-menu  ul-search">
				<li class=""><a ><i class="fa fa-shopping-cart"></i></span>Product</a></li>
				<li><a ><i class="fa  fa-gears"></i></span>Service</a></li>
				<li><a ><i class="fa  fa-list-alt"></i></span>Invoice</a></li>
				</ul>
			   
			  
        <select name="ajaxselect" id="ajaxselect" size="20" style="display: none;" ></select>
        <script>
		/* function  selected()
		{
			var selected_text =$("#ajaxselect option:selected").text(); 
			var selected_type =$("#ajaxselect option:selected").val().split("_"); 
			selected_type=selected_type[0];
			//alert(selected_type);
		} */
          $(function(){		
		
			var urlauto='<?php echo base_url();?>order/<?php echo $this->uri->uri_string()=='order/recived_order_list'?'autocomplete_payee':'autocomplete';?>';
		
		  
           
			var ddBasic = [
				{ text: "Product", value: 0,imageSrc:'<?php echo base_url(); ?>img/product.png' },
				{ text: "Service", value: 1, imageSrc:'<?php echo base_url(); ?>img/services.png'},
				{ text: "Invoice", value: 2, imageSrc:'<?php echo base_url(); ?>img/invoice.png'},
				
			];
			var clickSer=0;
			<?php if($this->uri->uri_string()=='order/recived_order_list' || $this->uri->uri_string()=='order/order_list'){?>
			$('#myDropdown').ddslick({
				width:130,
				data: ddBasic,
				onSelected: function(selectedData){
					$("#myDropdown").addClass("pull-left");
					$("#search_by_text").show();
					$(".filtertxt").val('');
					
				  var dd = $('#myDropdown .dd-selected-value').val();
				 
				  $('#myDropdown .dd-selected').addClass('btn-search');
				  $(".serch-list").html('<li class="extra sr-tital missing">Record not found</li>');
				  $('#ajaxselect').tagger({
					  ajaxURL: urlauto + '/'+dd+'/'
					, baseURL: '<?php echo base_url();?>img/'
					, characterThreshold: 1
					, fieldWidth: null
				});
				$(".suggestions li").addClass("sr-tital");
				if(clickSer>0)
				setTimeout(function(){
					 $("#search_by_text").trigger("click");
				 },500);
				 clickSer++;
				 //alert($('#myDropdown li:has(input[value="'+dd+'"])').index());
				}   
			});
			 <?php } ?>
          });
        </script>
     
			   <button type="button" class="btn icon-btn-search" id="search_by_text"  style="display:none;"><i class="fa fa-search"></i></button>
		    </form>
		</div>
			
		
		<?php }?>
		<style>
	 .btn-search{padding:15px!important;}
	 .dd-selected{font-weight:normal!important;}
	 .dd-selected-text,.dd-option-text{line-height:14px!important;}
	 .dd-option-image, .dd-selected-image{max-width:22px; margin-top:-5px;}
     </style>
		<div class=" col-sm-12  col-md-4  col-xs-12   text-right pull-right m-welcome ">
		
		<?php if($this->uri->uri_string()=='despute' || strstr($this->uri->uri_string(),'despute/final_offer')|| strstr($this->uri->uri_string(),'despute/negotiate')){?>
		<span class="text-white font28 margin-up"><?php echo 'Dispute'; ?></span>
		<?php }else{?>
		<span class="text-white animated fadeInRight font28 margin-up"><?php echo $a_page_title; ?></span>
		<?php }?><br>
		
		<span class="text-white curr_bal_menu" style="font-size:14;"></span><br>
		
		
		<a id="dispute_link" href="<?php echo base_url();?>despute/negotiate/" style="display:none;">
		
			<span class="text-white " style="font-weight:200;font-size:14px">
				You have 
				<span class="total_dispute"></span> 
				open dispute(s),
				<strong><span id="dispute_counter"></span></strong> 
				<strong><span id="dispute_counter1"></span></strong> 
			</span>
		</a>
		<!-- Mihir -->
		<a class="dropdown" href="#" class="" id="dLabel" role="button" data-toggle="dropdown" data-target="#"><i class="fa fa-plus text-white dispute_id_plus "></i> </a>
			  <ul class="dropdown-menu dpmenu1 " role="menu" aria-labelledby="dLabel"><span class="top-caret"></span>
				 <div class="notifications-wrapper col-md-12"  style="" id="counterdiv1">
				   </div>
			  </ul>
		<!-- Mihir -->
		</div>
		
	</div>
	<!--<div class="col-md-2 text-center ">
	
	<span class="text-white"><h3>Welcome Nik!</h3></span>
	<span class=""><h2>My Account</h2></span>
	
	</div> -->
	<div class="col-xs-12 visible-xs">
		
	</div>

	</div >
	
</div>	
</section>

<script>



$("#exampleInputEmail3").keyup(function(){
	var ths= $(this).val();
})
$(document).on("load",function(){
	$(function(){
		if($("#filter").val()=='vendor')
		{
			$(".seller").addClass('hidden');
		}
		else if($("#filter").val()=='seller')
		{
			
			$(".vendor").addClass('hidden');
		}
	});
});
$(document).ready(function(){
	//$('.selectpicker').selectpicker();
	
	$("#filter").on("change",function(){
		if($(this).val()=='vendor')
		{
			$("#filter").removeAttr("disabled");
			$(".vendor").removeClass('hidden');
			$(".seller").addClass('hidden');
			$(".seller").removeAttr('selected');
			$('#seller option[class="seller"]').removeAttr('selected');
			$("#seller").parent().find('.bs-placeholder .filter-option').text("Please Select Store");
			//$('#seller option[class="vendor"]:first').attr('selected',"selected");
			//alert($("#seller option[class='vendor']:selected" ).text());
		}
		else if($("#filter").val()=='seller')
		{
			$("#filter").removeAttr("disabled");
			$(".seller").removeClass('hidden');
			$("#seller").parent().find('.bs-placeholder .filter-option').text("Please Select "+$("#filter option:selected").text());
			$(".vendor").addClass('hidden');
			$(".vendor").removeAttr('selected');
			$('#seller option[class="vendor"]').removeAttr('selected');
			//$('#seller option[class="seller"]:first').attr('selected',"selected");
			//alert($("#seller option:selected" ).text());
				
		}
	});
});

</script>

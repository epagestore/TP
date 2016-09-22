<div class="welcom-note-name" style="margin-left:120px">
<h2>Welcome <?php echo $this->session->userdata('first_name')?>,</h2>
<span class="curr_bal_amt">Your Current Balance is: <img src="<?php echo base_url();?>images/loader.gif" style="    width: 6%;    margin-bottom: -4px;"></span>
</div>
<div class="main-paypal-blog">
<div class="main-paypal-contain">
<div class="container">
			<div class="main">
<?php /*?><script src="<?php echo base_url();?>js/modernizr.custom1.js"></script><?php */?>
                <nav id="cbp-hrmenu" class="cbp-hrmenu">
					<ul>
						<li>
							<a href="<?php echo base_url();?>index.php/dashboard" onclick="javascript:window.location.href=$(this).attr('href');">My Account</a>
							<!--<div class="cbp-hrsub">
								<div class="cbp-hrsub-inner"> 
										<ul>
											<li><a class="block-none" href="<?php echo base_url();?>index.php/dashboard">Overview</a></li>
											<li class="block-none"><a class="block-none" href="<?php echo base_url();?>index.php/balance_manager">Deposite</a></li>
											<li class="block-none"><a class="block-none" href="<?php echo base_url();?>index.php/history">History</a></li>
											<li class="block-none"><a class="block-none" href="<?php echo base_url();?>index.php/profile">Profile</a></li>
                                            <li class="block-none"><a class="block-none" href="<?php echo base_url();?>index.php/despute/receive_list">Dispute</a></li>
										</ul>
								</div>
							</div>-->
						</li>
						<li>
							<a href="<?php echo base_url();?>index.php/order/order_list" onclick="javascript:window.location.href=$(this).attr('href');">Send Payment</a>
							<!--<div class="cbp-hrsub">
								<div class="cbp-hrsub-inner"> 
										<ul>
											<li><a class="block-none" href="<?php echo base_url();?>index.php/order/order_list">Placed Order</a></li>
										</ul>
								</div>
							</div>-->
						</li>
						<!--<li>
							<a href="#">Applications</a>
						
						</li>-->
						<li>
							<a href="<?php echo base_url();?>index.php/order/recived_order_list" onclick="javascript:window.location.href=$(this).attr('href');">Request Payment</a>
                            <!--<div class="cbp-hrsub">
								<div class="cbp-hrsub-inner"> 
										<ul>
											<li><a class="block-none" href="<?php echo base_url();?>index.php/order/recived_order_list">Received Order</a></li>
										</ul>
								</div>
							</div>-->
						</li>
                        <li><a href="<?php echo base_url();?>index.php/send_money" onclick="javascript:window.location.href=$(this).attr('href');">Quick Settler</a>
                        <!-- <div class="cbp-hrsub">
								<div class="cbp-hrsub-inner">  
                        <ul>
                            <li><a href="<?php echo base_url();?>index.php/send_money" class="block-none">Send Money</a></li>
                            <li><a href="<?php echo base_url();?>index.php/request_money" class="block-none">Request Money</a></li>
                            <li><a href="<?php echo base_url();?>index.php/invoice" class="block-none">Create Invoices</a></li>
                            <li><a href="<?php echo base_url();?>index.php/invoice/list_all" class="block-none">My Invoices</a></li>
                        </ul>
                 		</div>
                        </div>-->
                    </li>
                        
					</ul>
				</nav>
			</div>
		</div>
		<script src="<?php echo base_url();?>js/cbpHorizontalMenu.min.js"></script>
		<script>
		  $.ajax({
					url: '<?php echo base_url();?>index.php/balance_manager/getCurrentBalance',
					success: function(e) {
						var val=parseInt(e);
						val=parseFloat(val*<?php echo $value; ?>).toFixed(2);
						var curr='<?php echo $currency_symbol;?>';
						$(".curr_bal_amt").text('Your Current Balance is: '+curr+' '+ val);
						chk2=0;
					}
		   });
			$(function() { 
				
				cbpHorizontalMenu.init();
			
				var timer2, delay2 = 5000;
				var chk2=0;
				timer2 = setInterval(function(){
						
				if(chk2==0)
				{
					chk2=1;
					
				   $.ajax({
							url: '<?php echo base_url();?>index.php/balance_manager/getCurrentBalance',
							success: function(e) 
							{
								
								var val=parseInt(e);
								val=parseFloat(val*<?php echo $value; ?>).toFixed(2);
								var curr='<?php echo $currency_symbol;?>';
								
								if(e!='')
									$(".curr_bal_amt").text('Your Current Balance is: '+curr+' '+ val);
								chk2=0;
							}
				   });
				}
			}, delay2);
		});
		</script>   
</div>
</div>
<div class="vetical-menu-detl">
<div class="left_sidebar">
<?php

	$uri_string = uri_string();
	$menuArr = array("dashboard","balance_manager","history","profile","despute/receive_list","despute/generate_list","profile/edit");
	$menuArr1 = array("order/order_list","order/placed_details/".$this->uri->segment(3));
	$menuArr2 = array("order/recived_order_list","order/receive_details/".$this->uri->segment(3));
	$menuArr3 = array("send_money","request_money","invoice","invoice/list_all","invoice/view/".$this->uri->segment(3));
?>
<ul>
	<?php if(in_array($uri_string,$menuArr)){ ?>
	<li><a href="<?php echo base_url();?>index.php/dashboard" class="<?php echo $menuArr[0]==$uri_string?"active_tab":''; ?>">Overview</a></li>
	<li ><a href="<?php echo base_url();?>index.php/balance_manager" class="<?php echo $menuArr[1]==$uri_string?"active_tab":''; ?>">Deposite</a></li>
	<li ><a href="<?php echo base_url();?>index.php/history" class="<?php echo $menuArr[2]==$uri_string?"active_tab":''; ?>">History</a></li>
	<li ><a href="<?php echo base_url();?>index.php/profile" class="<?php echo $menuArr[3]==$uri_string||$menuArr[6]==$uri_string?"active_tab":''; ?>">Profile</a></li>
	<li ><a href="<?php echo base_url();?>index.php/despute/receive_list" class="<?php echo $menuArr[4]==$uri_string?"active_tab":$menuArr[5]==$uri_string?"active_tab":''; ?>">Dispute</a></li>
	<?php } 
	if(in_array($uri_string,$menuArr1)){
	?>
	<li><a href="<?php echo base_url();?>index.php/order/order_list" class="<?php echo $menuArr1[0]==$uri_string||$menuArr1[1]==$uri_string?"active_tab":''; ?>">Placed Order</a></li>
	<?php } 
	if(in_array($uri_string,$menuArr2)){
	?>
	<li><a href="<?php echo base_url();?>index.php/order/recived_order_list" class="<?php echo $menuArr2[0]==$uri_string||$menuArr2[1]==$uri_string?"active_tab":''; ?>">Received Order</a></li>
	<?php } 
	if(in_array($uri_string,$menuArr3)){ 
	?>
	<li><a href="<?php echo base_url();?>index.php/send_money" class="<?php echo $menuArr3[0]==$uri_string?"active_tab":''; ?>" >Send Money</a></li>
	<li><a href="<?php echo base_url();?>index.php/request_money" class="<?php echo $menuArr3[1]==$uri_string?"active_tab":''; ?>">Request Money</a></li>
	<li><a href="<?php echo base_url();?>index.php/invoice" class="<?php echo $menuArr3[2]==$uri_string?"active_tab":''; ?>" >Create Invoices</a></li>
	<li><a href="<?php echo base_url();?>index.php/invoice/list_all" class="<?php echo $menuArr3[3]==$uri_string||$menuArr3[4]==$uri_string?"active_tab":''; ?>">My Invoices</a></li>
	<?php }  ?>
	</ul>

</div>
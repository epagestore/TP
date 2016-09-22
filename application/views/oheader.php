<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Trusted Payer</title>
<link href="<?php echo base_url();?>css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo base_url();?>js/jquery-1.9.1.min.js"></script>
<script src="<?php echo base_url();?>css/skdslider.min.js"></script>
<script src="<?php echo base_url();?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/jquery.popup.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/jquery.reveal.js"></script>
<link href="<?php echo base_url();?>css/skdslider.css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/default.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/component.css" />
<link rel="stylesheet" href="<?php echo base_url();?>css/jquery.popup.css" type="text/css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>fonts/font.css" />
<link href='http://fonts.googleapis.com/css?family=Oswald:400,700,300' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="<?php echo base_url();?>new-css/bootstrap.css">
	<link rel="stylesheet" href="<?php echo base_url();?>new-css/font-awesome.css">
	<link rel="stylesheet" href="<?php echo base_url();?>new-css/main.css">
	<link rel="stylesheet" href="<?php echo base_url();?>new-css/jquery.bxslider.css">
	<script src="<?php echo base_url();?>new-js/modernizr.custom.js"></script>



<style>
.fix_clear_all {
display: inline;
text-align: right;
padding-top: 4px;
margin-top:-20px;
float: right;
}
.fix_clear_all a {
font-size: 13px;
font-family: Arial, Helvetica, sans-serif;
font-weight: bold;
color: #1964A7;
}
.fix_clear_all a:hover{background:none !important;}
</style>
<script type="text/javascript">
		jQuery(document).ready(function(){
			jQuery('#demo').skdslider({'delay':5000, 'fadeSpeed': 2000,'showNextPrev':true,'showPlayButton':true,'autoStart':true});
			jQuery('#demo1').skdslider({'delay':5000, 'fadeSpeed': 2000,'autoStart':true,'pauseOnHover':true});
		    $(".js__p_start, .js__p_another_start").simplePopup();
		});
</script>

</head>

<body>

<div class="main-wrapper">
<div class="navbar navbar-smak navbar-fixed-top" style="background:<?php if(uri_string()=='' || uri_string()=='home'){echo "";}else{echo "#1996e6";} ?>">

<div class="terusted-pair">
<div class="terusted-pair-logo header-top-line " style="text-align:<?php if(uri_string()=='' || uri_string()==''){echo "";}else{echo "center";} ?>"><a href="<?php echo base_url().'index.php/dashboard';?>"><img src="<?php echo base_url();?>images/logo.png" /></a></div>
<div class="header-top-menu" style="display:none">
<ul>
	<li class="personal"><a href="<?php echo base_url();?>" style="border-right:none;">Personal</a></li>
	<li class="business"> <a href="<?php echo base_url();?>index.php/business">Business</a></li>
</ul>
</div>

<div class="right-menu">
<!--<ul><li> <a href="#">Buy</a>
<ul>
<li class="bg-none"><a href="#">Overview</a></li>
<li class="bg-none"><a href="#">Make a Payment</a></li>
<li class="bg-none"><a href="#">How to Buy</a></li>
<li class="bg-none"><a href="#">Where to Shop</a></li>
</ul>
</li>
<li> <a href="#">Sell</a>
<ul>
<li class="bg-none"><a href="#">Overview</a></li>
<li class="bg-none"><a href="#">Request a Payment</a></li>
<li class="bg-none"><a href="#">How to Sell</a></li>
</ul>
</li>
<li class="bg-none"> <a href="#">Manage</a>
<ul>
<li class="bg-none"><a href="#">Overview</a></li>
<li class="bg-none"><a href="#">Payment Methods</a></li>
<li class="bg-none"><a href="#">Getting Started</a></li>
</ul>
</li>
</ul>-->
<?php  if(!$this->session->userdata('customer_id')){ ?>   
<ul class="menu">
 
    <li><a href="#">Buy</a>
    <ul>
            <li><a href="#" class="documents">Documents</a></li>
            <li><a href="#" class="messages">Messages</a></li>
            <li><a href="#" class="signout">Sign Out</a></li>
        </ul>
    </li>
    <li><a href="#">Sell</a>
    <ul>
            <li><a href="#" class="documents">Documents</a></li>
            <li><a href="#" class="messages">Messages</a></li>
            <li><a href="#" class="signout">Sign Out</a></li>
        </ul>
    </li>
    <li><a href="#">Manage</a>
 
        <ul>
            <li><a href="#" class="documents">Documents</a></li>
            <li><a href="#" class="messages">Messages</a></li>
            <li><a href="#" class="signout">Sign Out</a></li>
        </ul>
 
    </li>
     
  
 
</ul>
<?php }?>
</div>

<div class="hdr-menu-login">
<?php if(!$this->session->userdata('customer_id')){?>
<div class="login-right">
	<?php echo form_open('sign_in','autocomplete="off"')?>
		<div class="email-textbox">
			<input type="text" placeholder="Email Address" name="email" />
		</div>
		<div class="email-textbox">
			<input type="password" placeholder="Password" name="password" autocomplete="off" />
    	</div>
        
        <?php if(isset($_GET['id'])){?>
        <input type="hidden" name="api_key" value="<?php echo $_GET['id'];?>" />
        <?php if(isset($_GET['redirect'])){?>
        <input type="hidden" name="api_redirect" value="<?php echo $_GET['redirect'];?>" />
        <?php }}else{?>
				<?php if($redirect==''){?>
            <div class="email-textbox">    
                <select name="redirect" style="background: #e0d9d9;border-radius: 5px;border: none;padding: 8px !important;color: #666666;font-size: 14px;width: 170px;box-shadow: 1px -1px 1px 1px #bcb7b7 inset;" >
                <option value="dashboard">start with My Account</option>
                <option value="balance_manager">start with Deposit</option>
                <option value="history">start with History</option>
                <option value="profile">start with Profile</option>
                <option value="order/order_list">start with Send Payment</option>
                <option value="order/recived_order_list">start with Request Payment</option>
               <!-- <option value="membership">start with Quick Settler</option>
                <option value="membership">start with Create Invoices</option>
                <option value="rfq">start with My Invoices</option>
                <option value="message_center">start withInvoicing Tools</option>-->
                </select>
                </div>
                <?php }else{?>
                <input type="hidden" name="redirect" value="<?php echo $redirect;?>" />
                
                <?php }?>
        <?php }?>
        <div><input type="submit" class="register-btn" value="Login" name="" style="float:right; margin-top:2px; width:14%;line-height:35px"></div>
    	<div class="js__p_start" style="float:right;font-size:12px;"><a href="#">Forget Password?</a></div>
        <?php  if(!$this->session->userdata('customer_id')){if($this->session->flashdata('message')){ ?>   
                <div style="color:red; float:left;">
                    <?php echo $this->session->flashdata('message'); ?>                
                </div>
 <?php }}?>
    </form>
</div>

<div class="p_body js__p_body js__fadeout"></div>
<div class="popup js__popup js__slide_top"> 
<a href="#" class="p_close js__p_close" title="Close"></a>
<div class="p_content">
<div class="pop-box">
<?php if($this->session->flashdata('forget_pass:success')){?>
<span style="color:green;font-size:15px;"><?php echo $this->session->flashdata('forget_pass:success');?></span>
<?php }?>
<?php if($this->session->flashdata('forget_pass:error')){?>
<span style="color:red;font-size:15px;"><?php echo $this->session->flashdata('forget_pass:error');?></span>
<?php }?>
<div class="pop-box-name">
<form action="" method="post">
<p>Forget Passowrd ?</p>
<div class="subcribr_txt_bar">
<div class="pop-text">
<input type="text" name="forget_email" placeholder="Email" />
</div>
<input type="submit"  name="forget_pass" value="Ok"/>

</div>

<div class="subcribe-offer"></div>
</form>
</div>


</div>
<br>
</div></div>

<?php }else{	
?>
<?php $query = $_SERVER['QUERY_STRING'] ? '?'.$_SERVER['QUERY_STRING'] : ''; ?> 
	<div class="logout-right">
   
    <a class="register-btn" style="float:right; margin-top:0px; width:108px;" href="<?php echo base_url();?>index.php/sign_out">Sign Out</a>
       
    <a href="#" title="Notification" class="big-link" data-reveal-id="myModal2"data-animation="none">
                <div class="noti_csl">
                <div class="comnt_bar"></div>
                <div id="comment_cnt" class="notfcn_bar" style="display:none">0</div>
                </div>
                </a>
			
				 <select name="currency" onchange="location = this.options[this.selectedIndex].value;">
				<?php	foreach ($this->session->userdata('currencies') as $currency){ 
					
					if($this->session->userdata('currency_id') == $currency['currency_id']) {	 
						 
							if($currency['status'] == '1'){ ?>                              
				<!--                    <a class="btn" href="<?php echo base_url();?>index.php/home/setCurrency/<?php echo $currency['currency_id'];?>" rel="nofollow">
				-->													
								<option value="<?php echo base_url();?>index.php/home/setCurrency/<?php echo $currency['currency_id'];?>?redirect=<?php echo urlencode($this->uri->uri_string().$query); ?>" selected="selected">

									<?php echo $currency['currency_symbol']; ?>  <?php echo $currency['code']; ?></option>
						<?php } } else { 
							if($currency['status'] == '1'){ ?>                              
				<!--                    <a class="btn" href="<?php echo base_url();?>index.php/home/setCurrency/<?php echo $currency['currency_id'];?>" rel="nofollow">
				-->													
								<option value="<?php echo base_url();?>index.php/dashboard/setCurrency/<?php echo $currency['currency_id'];?>?redirect=<?php echo urlencode($this->uri->uri_string().$query); ?>">

							<?php echo $currency['currency_symbol']; ?>  <?php echo $currency['code']; ?></option>
						
					<?php } }?>	
				<?php } ?>
				</select> 
                <div id="myModal2" class="reveal-modal1">
                  <div id="modal2_content_box">
                      <div id="content_2" class="content notifn_ul">
                                  <ul>
                                  <img  src="<?php echo base_url();?>images/loader.gif" style="width: 6%;">
                                 
                                  </ul>  
                            </div>
               		</div>
				<span class="fix_see_all"> <a href="<?php echo base_url();?>index.php/notification">See All</a></span>
                <span class="fix_clear_all"><a href="javascript:void(0);" id="clear-all-notif">Clear All</a></span></div> 

    </div>
<?php }?>


</div>


</div>
</div>
<?php  if($this->session->userdata('customer_id')){ ?>   
<script>
$(document).ready(function(){
$("#clear-all-notif").click(function(){
	if(confirm("Are you sure you want to clear"))
	{
		$.ajax({
				 url:"<?php echo base_url()."index.php/dashboard/clear_all_notif";?>",
				 success: function(json) {
					 $("#content_2").html('No notification to show');
					 if($("#notify_main").length)
						{
							$("#notify_main").html('No notification to show !');
						}
				 }
		});
	}
});
$.ajax({
			 url:"<?php echo base_url()."index.php/dashboard/count_notif";?>",
			dataType: 'json',
			success: function(json) {
						$("#content_2").html('');
						html='';
						$.each(json.notify_details, function(i, item) {
							if(item.read=='0')
							html+=('<li style="background: #EEEEEE;"><a style="width: 75%;" href="'+item.url+'">'+item.description+' <b>'+item.amount+'</b></a><span style="float:right;text-align:center;font-size:10px; color:#666;width:22%;">'+item.date_added+'</span></li>');
							else
							html+=('<li style="background:white"><a style="width: 75%;" href="'+item.url+'">'+item.description+' <b>'+item.amount+'</b></a><span style="float:right;text-align:center;font-size:10px; color:#666;width:21%;">'+item.date_added+'</span></li>');
							
						})
						
						$("#content_2").html('<ul>'+html+'</ul>');
						if($("#notify_main").length)
						{
							$("#notify_main").html('<ul>'+html+'</ul>');
							if(!json.notify_details.length)
							$("#notify_main").html('No notification to show !');
						}
						if(json.count=='0')
						$("#comment_cnt").css('display','none');
						else
						{
							$("#comment_cnt").css('display','block');
						$("#comment_cnt").text(''+json.count);
						}
						if(!json.notify_details.length)
						$("#content_2").html('No notification to show !');
					chk1=0;
				}
				});
var timer1, delay1 = 5000;
var chk1=0;
timer1 = setInterval(function(){
if(chk1==0){
	chk1=1;
		$.ajax({
				 url:"<?php echo base_url()."index.php/dashboard/count_notif";?>",
				dataType: 'json',
				success: function(json) {
							$("#content_2").html('');
							html='';
							$.each(json.notify_details, function(i, item) {
								if(item.read=='0')
								html+=('<li style="background: #EEEEEE;"><a style="width: 75%;" href="'+item.url+'">'+item.description+' <b>'+item.amount+'</b></a><span style="float:right;text-align:center;font-size:10px; color:#666;width:21%;">'+item.date_added+'</span></li>');
								else
								html+=('<li style="background:white"><a style="width: 75%;" href="'+item.url+'">'+item.description+' <b>'+item.amount+'</b></a><span style="float:right;text-align:center;font-size:10px; color:#666;width:21%;">'+item.date_added+'</span></li>');
							})
							
							$("#content_2").html('<ul>'+html+'</ul>');
							if($("#notify_main").length)
							{
								$("#notify_main").html('<ul>'+html+'</ul>');
								if(!json.notify_details.length)
								$("#notify_main").html('No notification to show !');
							}
							if(json.count=='0')
							$("#comment_cnt").css('display','none');
							else
							{
								$("#comment_cnt").css('display','block');
							$("#comment_cnt").text(''+json.count);
							}
							if(!json.notify_details.length)
							$("#content_2").html('No notification to show !');
						chk1=0;
					}
				});
	}
}, delay1);
});
</script>
<?php }?>
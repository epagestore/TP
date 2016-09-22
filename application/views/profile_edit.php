<?php include("inner_menu.php");?>

<script src="<?php echo base_url();?>js/library/bootstrap-fileupload.js"></script>
<script src="<?php echo base_url();?>js/library/bootstrap-select.js"></script>
<section class="container">

<div class="row">
<div class="col-xs-12 col-sm-12 col-xs-12">
<h3 class="text-orange bottom-margin">MyProfile</h3>
  <!-- Nav tabs -->
  <div class="col-md-3 col-sm-12 col-xs-12" >
	<!--div class="logo-img bottom-margin">
	<img src="img/profile.png">
	</div>
	<div class="">
	<span class="btn btn-success ">Change Image</span>
	</div!-->
	<div class="separator"> 
	</div>
	<form name="frm1" id="frm1" method="post" enctype="multipart/form-data">
		<div class="fileupload <?php if($profile['photo']){echo 'fileupload-exists';}else{ echo "fileupload-new"; } ?>"  data-provides="fileupload">
				<div class="fileupload-preview  logo-img bottom-margin text-center" style="max-height:235px;min-height:235px">
					<img src="<?php echo base_url().$profile['photo'];?>" style="max-height:223px;min-height:223px">
				</div>
					<div class="thumbnail">
						<span class="btn btn-file  btn-primary">
							<span class="<?php if($profile['photo']){echo 'fileupload-exists';}else{ echo "fileupload-new"; } ?>">
								<?php if($profile['photo']){echo 'Change';}else{ echo "Select image"; } ?>
							</span>
							<span class="file_exists"></span>
							 <?php if($profile['photo']!=''){?>
								<input type="hidden" name="profile_photo" value="<?php echo $profile['photo'];?>" />
							 <?php }?>
							<input type="file" name="profile_photo" id="imgInp" value="<?php echo base_url().$profile['photo'];?>"  />
						</span>
						&nbsp;&nbsp;
						<a href="#"  id="remove" class="btn  btn-danger fileupload-exists" data-dismiss="fileupload"><i class="fa fa-bank"></i></a>
					</div>
					<span class="help-block bg-danger text-center"></span>
					
			</div>
	</form>	
  </div>
					
  <div class="col-sm-12 col-md-9">
  <ul class="nav nav-tabs hidden-xs" role="tablist" id="myTab">
    <li role="presentation" class="active"><a href="#Personal" aria-controls="Personal" role="tab" data-toggle="tab">
Personal Information</a></li>
    <li role="presentation"><a href="#Bank" aria-controls="Bank" role="tab" data-toggle="tab">Bank Information</a></li>
	<li role="presentation"><a href="#Key" aria-controls="Key" role="tab" data-toggle="tab">Trusted Payer Key</a></li>
	<li role="presentation"><a href="#Dispatcher" aria-controls="Dispatcher" role="tab" data-toggle="tab">Dispatcher</a></li>
   
  </ul>
  <ul class="nav nav-tabs visible-xs" role="tablist" id="myTab">
    <li role="presentation" class="active"><a href="#Personal" aria-controls="Personal" role="tab" data-toggle="tab">
<i class="fa fa-user"></i></a></li>
    <li role="presentation"><a href="#Bank" aria-controls="Bank" role="tab" data-toggle="tab"><i class="fa  fa-university"></i> </a></li>
	<li role="presentation"><a href="#Key" aria-controls="Key" role="tab" data-toggle="tab"><i class="fa  fa-key"></i></a></li>
	<li role="presentation"><a href="#Dispatcher" aria-controls="Dispatcher" role="tab" data-toggle="tab"><i class="fa fa-paper-plane "></i></a></li>
   
  </ul>
<form class="form-horizontal" name="personal" method="post" action="<?php echo base_url();?>index.php/profile/edit" >
  <!-- Tab panes -->
  <div class="tab-content">
    <div role="tabpanel" class="tab-pane active " id="Personal" style="padding-left: 20px;">
			<div class="row">
			<h4 class="text-sky"></h4>
			
			
			<div class="form-group">
			<label for="inputEmail3" class="col-sm-4 col-xs-12 control-label">First Name</label>
			<div class="col-sm-8 col-xs-12">
			  <input type="text" name="first_name" class="form-control" id="inputEmail3" placeholder="Name"  value="<?php echo isset($profile['first_name'])?$profile['first_name']:'';?>"/>
			</div>
		  </div>
		  <div class="form-group">
			<label for="inputEmail3" class="col-sm-4  col-xs-12 control-label">Last Name</label>
			<div class="col-sm-8 col-xs-12">
			  <input type="text"  name="last_name" class="form-control" id="inputEmail3" placeholder="Name"  value="<?php echo isset($profile['last_name'])?$profile['last_name']:'';?>"/>
			</div>
		  </div>
		  <div class="form-group">
			<label for="inputEmail3" class="col-sm-4 col-xs-12 control-label">Email</label>
			<div class="col-sm-8 col-xs-12">
			  <input type="email"  name="email"  class="form-control" id="inputEmail3" placeholder="Email" value="<?php echo isset($profile['email'])?$profile['email']:'';?>"/>
			</div>
		  </div>
		  <div class="form-group">
			<label for="inputEmail3" class="col-sm-4 col-xs-6 control-label">Register As:</label>
			<div class="col-sm-8 col-xs-6">
			 <span><?php if($profile['is_company']) echo "Business"; else echo "Personal";?></span>
			</div>
		  </div>
		  
		  <div class="form-group">
			<label for="inputEmail3" class="col-sm-4 col-xs-12 control-label">Address:</label>
			<div class="col-sm-8 col-xs-12">
			  <textarea class="form-control"  name="customer_add"  rows="3" placeholder="Address" ><?php echo isset($profile['customer_add'])?$profile['customer_add']:'';?></textarea>
			</div>
		  </div>
		  <?php 
		  $pm_total=0;
			if($profile['verify1'])
		  $pm_total=1;
			if($profile['verify2'])
		  $pm_total=2;
	  
		$fg_flag=2;
		  for($k=0; $k<=$fg_flag; $k++){
		  if(!$k)
		  {$kp='';}
			else
		{$kp=$k;}	
		?>
			<div class="form-group cmdm_phone <?php if($k>($pm_total)) echo "hidden"; ?>">
				
				<label for="inputEmail3" class="col-sm-4 col-xs-12 control-label"><?php if(!$k){ ?>Phone : <?php } ?> </label>
				
				<div class="col-sm-2 col-xs-3 ">
					<select class="selectpicker form-control" data-live-search="true"  name="phonecode[]" id="phonecode" data-size="5">
						<?php foreach($phonecode as $p): ?>
						<option <?php if(isset($profile['phonecode']) && $profile['phonecode']!=0 && $profile['phonecode'] == $p['phonecode']) {echo "selected";} ?> value="<?php echo $p['phonecode'];?>"  data="<?php echo $p['iso']?>"><?php echo '+'.$p['phonecode']?></option>
						<?php endforeach;?>
					</select>
		
				</div>
				<div class="col-sm-3 col-xs-9">
					  <input maxlength="10" onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" type="text" class="form-control text-center"  name="customer_phone[]"  id="inputEmail3" placeholder="Enter Mobile number" value="<?php echo (isset($profile['customer_phone'.$kp])&& $profile['customer_phone'.$kp])?$profile['customer_phone'.$kp]:'';?>" />
				</div>
				<div class="col-sm-3 col-xs-12">
					  <a class="<?php echo $profile['verify'.$kp]==1?'img-circle':'btn btn-primary opt_retrieve2'; ?>" <?php if($profile['verify'.$kp]){ ?> style="color:#449D44;" <?php } ?> data="<?php echo $k; ?>"><?php if($profile['verify'.$kp]==1){?><i class="fa fa-check-square-o fa-2x"></i><?php }else{ echo "Verify"; }?></a><?php if($profile['verify'.$kp]){?> &nbsp; <a class="opt_retrieve2" data="<?php echo $k; ?>" style="cursor:pointer; "><i class="fa fa-pencil-square-o fa-2x" aria-hidden="true"></i>
					  </a> <?php if($kp>0){?><a style="cursor:pointer; " class="text-danger removePhone" data="<?php echo $kp; ?>"><i class="fa fa-times-circle-o fa-2x"></i></a> <?php }} ?> <?php if(!$k && $pm_total<2){ ?><a class="btn btn-danger addmorecmob pull-right" data-toggle="tooltip" title="Add More mobile number" ><i class="fa fa-plus"></i></a><?php } ?>
				</div>
			</div>
		  <?php } ?>
<div class="modal fade animated shake" id="Verify" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" style="width:320px!important;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <p class="modal-title">Mobile verification!</p>
      </div>
      <div class="modal-body text-center">
        <input onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" class="form-control text-center" maxlength="6" type="text"  name="opt_verify_number"  placeholder=" Enter OPT Code" />
		<span class="opt_error text-danger"></span>
      </div>
      <div class="modal-footer">
        <a class="btn-danger btn" style="cursor:pointer;" id="opt_retrieve">Regenerate OPT Code</a>
		<button type="button" class="btn btn-primary otp_verify" id="opt_verify" disabled >Verify</button>
      </div>
    </div>
  </div>
</div>
<script>
var indexotpmobile=0;
var phoneCode=0;
var indexoptm=0;
$(document).ready(function(){
	$( '.modal' ).modal( 'hide' ).data( 'bs.modal', null );
});
$(document).on("click",".addmorecmob",function(e){
	
	$('.cmdm_phone.hidden:eq(0)').removeClass('hidden');
	
	if(!$('.cmdm_phone').hasClass('hidden'))
	{
		$(".cmdm_phone").find(".tooltip").remove();
		$(this).remove();
	}
});
$(document).on("click",".removePhone",function(e){
	e.preventDefault();
	var ths=$(this);
	if(ths.hasClass("btn-danger"))
		return false;
	$.ajax({
		url:"<?php echo site_url('profile/removePhone'); ?>/"+ths.attr("data"),
		type:"post",
		success:function(){
			location.reload();
		},
		error:function(){
			location.reload();
		}
	});
	ths.addClass("btn-danger btn");
	var l = Ladda.create(this);
		l.start();
});
$(document).on("click",".opt_retrieve2",function(){
	indexotpmobile = $(this).parent().parent().find('input[name="customer_phone[]"]').val();
	
	indexoptm = $(this).attr("data");
	
	phoneCode =$('select[name="phonecode[]"]:eq('+(indexoptm)+')').val();

	$(".opt_error").addClass("text-danger");
	$("input[name='opt_verify_number']").val('');
	$(".opt_error").text('');
	if(indexotpmobile.length<10)
	{
		$(this).parent().parent().find('.col-xs-9').addClass("has-error");
		$(this).parent().parent().find('.col-xs-9').removeClass("has-success");
		return false;
	}else{
		$(this).parent().parent().find('.col-xs-9').removeClass("has-error");
		$(this).parent().parent().find('.col-xs-9').addClass("has-success");
	}	
	
	
	$("#Verify").modal('show');
	var num= phoneCode+indexotpmobile;
	var l = Ladda.create( document.querySelector( '#opt_retrieve' ) );
	l.start();
	$.ajax({
		url:"<?php echo base_url()?>/profile/opt?number="+encodeURIComponent("+"+num),
		type:"get",
		success:function(data){
			$(".otp_verify").removeAttr('disabled');
			console.log(data);
			$(".opt_error").text(data);
			l.stop();
		},error:function(error){
			console.log(error);
			l.stop();
		}
	})
	
});
$("#opt_retrieve").on("click",function(){
	$(".opt_error").addClass("text-danger");
	$("input[name='opt_verify_number']").val('');
	$(".opt_error").text('');
	var num= phoneCode+indexotpmobile;
	var l = Ladda.create( document.querySelector( '#opt_retrieve' ) );
	l.start();
	$.ajax({
		url:"<?php echo base_url()?>/profile/opt?number="+encodeURIComponent("+"+num),
		type:"get",
		success:function(data){
			$(".otp_verify").removeAttr('disabled');
			console.log(data);
			$(".opt_error").text(data);
			l.stop();
		},error:function(error){
			console.log(error);
			l.stop();
		}
	})
	
});


$("#opt_verify").on("click",function(){
	$(".opt_error").text('');
	var num= $("input[name='opt_verify_number']").val();
	var l = Ladda.create( document.querySelector( '#opt_verify' ) );
	l.start();
	$.ajax({
		url:"<?php echo base_url()?>/profile/opt_verify?otp="+encodeURIComponent(num)+'&mobile='+indexotpmobile+"&phonecode="+phoneCode+"&index="+indexoptm,
		type:"get",
		success:function(data){
			$(".otp_verify").removeAttr('disabled');
			console.log(data);
			if(data=='0')
			{
				$(".opt_error").text(" Invalid OPT code!");
				$(".opt_error").addClass("text-danger");
			}	
			if(data=='1')
			{
				$(".opt_error").text("Mobile number verification is successful!");
				$(".opt_error").addClass("text-success");
				$(".opt_error").removeClass("text-danger");
				$(".opt_retrieve2:eq("+(indexoptm)+")").removeClass("btn btn-primary");
				$(".opt_retrieve2:eq("+(indexoptm)+")").addClass('img-circle');
				$(".opt_retrieve2:eq("+(indexoptm)+")").html('<i class="fa fa-check-square-o fa-2x"></i>');
				$(".opt_retrieve2:eq("+(indexoptm)+")").css('color',"#449D44");
				
				setTimeout(function(){
					$("#Verify").modal('hide');
				},1500);
				window.location.href=window.location.href;
			}
			l.stop();
		},error:function(error){
			console.log(error);
			l.stop();
		}
	})
});

</script>
			<div class="form-group">
				<label for="inputEmail3" class="col-sm-4 col-xs-12 control-label">Business Name : </label>
				<div class="col-sm-8 col-xs-12">
				  <input type="text" class="form-control"  name="business_info"  id="inputEmail3" placeholder="Business Name" value="<?php echo isset($profile['business_info'])?$profile['business_info']:'';?>">
				</div>
			  </div>
			  <div class="form-group">
				<label for="inputEmail3" class="col-sm-4 col-xs-12 control-label">Business Type : </label>
				<div class="col-sm-8 col-xs-12">
				  <input type="text" class="form-control"  name="business_type"  id="inputEmail3" placeholder="Business Type" value="<?php echo isset($profile['business_type'])?$profile['business_type']:'';?>" />
				</div>
			  </div>
				<div class="form-group">
					<div class="col-sm-offset-4 col-sm-8">
					  <button type="button" class="btn btn-success " data-toggle="modal" data-target="#myModal" id="personal_btn">Save</button>
					  <button type="button" class="btn btn-success ">Cancel</button>
					</div>
				</div>
		</div>
	</div>
    <div role="tabpanel" class="tab-pane " id="Bank" style="padding-left: 20px;">
		<div class="row">
			<div class="col-sm-6">
				<h4 class="text-sky"> Account Detail </h4>
				<div class="form-group">
					<label for="inputEmail3" class="col-sm-4 col-xs-12 control-label">Account No: </label>
					<div class="col-sm-8 col-xs-12">
					  <input type="text" class="form-control" name="bank_ac" id="inputEmail3" placeholder="Account Number" value="<?php echo isset($profile['bank_ac'])?$profile['bank_ac']:'';?>" />
					</div>
				</div>
				<div class="form-group">
					<label for="inputEmail3" class="col-sm-4 col-xs-12 control-label">Account Name: </label>
					<div class="col-sm-8 col-xs-12">
					  <input type="text" class="form-control" name="bank_ac_name" id="inputEmail3" placeholder="Bank Account Name" value="<?php echo isset($profile['bank_ac_name'])?$profile['bank_ac_name']:'';?>" />
					</div>
				</div>
				<div class="form-group">
					<label for="inputEmail3" class="col-sm-4 col-xs-12 control-label">Debit / Credit Card :</label>
					<div class="col-sm-8 col-xs-12">
					<select class="form-control"   name="dr_cr_card" >
						  <option value="Visa" <?php if($profile['dr_cr_card']=='Visa'){ echo "selected";}?>>Visa</option>
						  <option value="MC" <?php if($profile['dr_cr_card']=='MC'){ echo "selected";}?>>MC</option>
						  <option value="aMEX" <?php if($profile['dr_cr_card']=='aMEX'){ echo "selected";}?>>aMEX</option>
						  
					</select>
					
					  <!--<input type="email" class="form-control" id="inputEmail3" placeholder="Email"> -->
					</div>
				</div>
				<div class="form-group">
					<label for="inputPassword3" class="col-sm-4 control-label">PayPal email : </label>
					<div class="col-sm-8">
					  <input type="email" class="form-control"   name="paypal_email"  id="inputPassword3" placeholder="PayPal email"  value="<?php echo isset($paypal_email)?$paypal_email:'';?>" /> 
					</div>
				</div>
				<div class="form-group">
					<label for="inputEmail3" class="col-sm-4 control-label">Purpose Code </label>
					<div class="col-sm-8">
					  <input type="text" class="form-control"  name="purpose_code"  id="inputEmail3" placeholder="Purpose Code" value="<?php echo isset($profile['purpose_code'])?$profile['purpose_code']:'';?>" />
					</div>
				</div>
				<div class="form-group">
					<label for="inputEmail3" class="col-sm-4 control-label">Address Line1</label>
					<div class="col-sm-8">
					  <textarea class="form-control" name="bank_ac_address1" ><?php  echo isset($profile['bank_ac_address2'])?$profile['bank_ac_address2']:'' ;?></textarea>
					</div>
				</div>
			</div>
			<div class="col-sm-6">
				<h4 class="text-sky">Bank Detail</h4>
				<div class="form-group">
					<label for="inputEmail3" class="col-sm-4 col-xs-12 control-label">Bank Name : </label>
					<div class="col-sm-8 col-xs-12">
					  <input type="text" class="form-control" name="bank_name" id="inputEmail3" placeholder="Bank Name" value="<?php echo isset($profile['bank_name'])?$profile['bank_name']:'';?>" />
					 
					</div>
				</div>
				<div class="form-group">
					<label for="inputEmail3" class="col-sm-4 col-xs-12 control-label">Routing No</label>
					<div class="col-sm-8 col-xs-12">
					 <input type="text" class="form-control" name="routing_no" id="routing_no" placeholder="Routing Number" value="<?php echo isset($profile['routing_no'])?$profile['routing_no']:'';?>" />
					  <!--<input type="email" class="form-control" id="inputEmail3" placeholder="Email"> -->
					</div>
				</div>
				<div class="form-group">
					<label for="inputPassword3" class="col-sm-4 control-label">Bank Address : </label>
					<div class="col-sm-8">
					  <input type="text" class="form-control"   name="bank_address"  id="bank_address" placeholder="Bank Address"  value="<?php echo isset($profile['bank_address'])?$profile['bank_address']:'';?>" /> 
					</div>
				</div>
				<div class="form-group">
					<label for="inputEmail3" class="col-sm-4 control-label">Bank Country </label>
					<div class="col-sm-8">
					  <select class="form-control selectpicker"  data-size="5"  data-live-search="true"  name="bank_country" >
						<?php foreach($country_code as $cn):?>
						  <option <?php if($profile['bank_country'] ==  $cn['country_id']){echo "seleted";}?> value="<?php echo $cn['country_id'];?>"><?php echo $cn['printable_name'];?></option>
						<?php endforeach;?> 
					</select>
					</div>
				</div>
				<div class="form-group">
					<label for="inputEmail3" class="col-sm-4 control-label">Bank Account Type </label>
					<div class="col-sm-8">
					  <select class="form-control" name="bank_ac_type" >
						  <option value="">Please Select</option>
						  <option value="checking" <?php if($profile['bank_ac_type']=='checking'){ echo "selected";}?>>CHECKING</option>
						  <option value="saving" <?php if($profile['bank_ac_type']=='saving'){ echo "selected";}?>>SAVING</option>
						  <option value="current" <?php if($profile['bank_ac_type']=='current'){ echo "selected";}?>>CURRENT</option>
					</select>
					</div>
				</div>
				<div class="form-group">
					<label for="inputEmail3" class="col-sm-4 control-label">Address Line2</label>
					<div class="col-sm-8">
					  <textarea class="form-control" name="bank_ac_address2" ><?php  echo isset($profile['bank_ac_address2'])?$profile['bank_ac_address2']:'' ;?></textarea>
					</div>
				</div>
				
			</div>
			<div class="col-sm-12 text-center">
				<div class="form-group">
						<button type="button" class="btn btn-success " data-toggle="modal" data-target="#myModal" id="bank_btn">Save</button>
						<input type="hidden" id="form_name" name="form_name" value="" />
						<button type="button" class="btn btn-success ">Cancel</button>
				</div>
			</div>
		</div>
	
	
	</div>
    
	<div role="tabpanel" class="tab-pane " id="Key" style="padding-left: 20px;">
		<div class="row">
		<h4 class="text-sky"></h4>
			<div class="form-group">
				<label for="inputEmail3" class="col-sm-4 control-label">Trusted Payer Key : </label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="inputEmail3" placeholder="Trusted Payer Key" value="<?php echo str_repeat("X", (strlen($customer_key)-3)).substr($customer_key,-3) ; ?>" <?php if($customer_key!=''){echo "disabled";}?> >
				</div>
			</div>
	</div>
    </div>
	
	  <div role="tabpanel" class="tab-pane " id="Dispatcher" style="padding-left: 20px;">
		<div class="row">
		<h4 class="text-sky"></h4>
		
	
		<?php if($profile['dispatcher_id']){ ?>
		<div class="form-group">
			<label for="inputPassword3" class="col-sm-4 control-label">Dispatcher Code :</label>
			<div class="col-sm-8">
			 <span><?php echo $profile['dispatcher_id']; ?></span>
			</div>
		  </div>
		<?php } ?> 
		  <div class="form-group">
			<label for="inputPassword3" class="col-sm-4 control-label">Jurisdiction :</label>
			<div class="col-sm-8">
		  <div class="col-sm-offset-1 col-sm-9 dispatcher_location1">
		  <span><?php $dp = json_decode($profile['dispatcher_location']); if(!count($dp)){$dp[]='1';} ?></span>
			
			<label>
			  <input type="checkbox" name="dispatcher_location[]" value="Local" <?php echo in_array("Local",$dp)?"checked":''; ?>>Local
			</label>
			
			<label>
			  <input type="checkbox" name="dispatcher_location[]" value="Domestic" <?php echo in_array("Domestic",$dp)?"checked":''; ?>>Domestic
			</label>
			
			<label>
			  <input type="checkbox" name="dispatcher_location[]" value="International" <?php echo in_array("International",$dp)?"checked":''; ?>>International
			</label>
		  </div>
		  
			 
			</div>
		  </div>
		  <?php if($profile['dispatcher_location']!='null' && $profile['dispatcher_location']){?>	
		  
		   <div class="form-group">
			<div class="col-sm-offset-4 col-sm-8">
			<button type="button" class="btn btn-success " data-toggle="modal" data-target="#myModal" id="dispatcher_btn">Save</button>
			  
			</div>
		  </div>
		  <?php } else{?>
		  <div class="form-group">
			<div class="col-sm-offset-4 col-sm-8">
			<button type="button" class="btn btn-success " data-toggle="modal" data-target="#myModal" id="dispatcher_btn">Subscribe Now</button>
			</div>
		  </div>
		  <?php }?>
		 
	</div>
  </div>
  
  
	<!-- Modal -->
	<div class="modal fade animated shake" id="myModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document" style="width:290px;">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title text-orange" id="myModalLabel">Enter Password for Edit Profile</h4>
		  </div>
		  <div class="modal-body">
		  <div class="row">
		   <div class="form-group">
				<div class="col-sm-offset-1 col-sm-10">
				  <input type="password" class="form-control text-center userpassenter" id="inputPassword3" name="password" placeholder="Enter Your Password here" >
				  <p class="userpasswrong text-danger text-center">Enter your password</p>
				</div>
			  </div>
			</div>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
			<div class="btn btn-primary saveUserProfile">Save changes</div>
			<button type="submit" class="btn btn-primary hidden saveUserProfile">Save changes</button>
		  </div>
		</div>
	  </div>
	</div>
	<!-- Modal -->
</div>
</form>
</div>
</div>
</div>
</section>
<?php if(isset($profile) && isset($profile['phonecode']) && !$profile['phonecode']){?>
<script>


function country()
{
	var requestUrl = "http://ip-api.com/json";
	$.ajax({
	  url: requestUrl,
	  type: 'GET',
	  success: function(json)
	  {
		//$('#phonecode option:selected').removeAttr("selected");
		var text1 = $('#phonecode option[data="'+json.countryCode+'"]').text();
		$('.dropdown-toggle .filter-option').text(text1);
		$('#phonecode').find('option').each(function(){
			if($(this).attr('data')==json.countryCode){
				$(this).attr('selected','selected');
			}
		});
	  },
	  error: function(err)
	  {
		console.log("Request failed, error= " + err);
	  }
	});
	
}
$('#phonecode').ready(function(){
	country();
})
</script>
<?php }?>
<style>


/*file select */
    .btn-file {
        position: relative;
        overflow: hidden;
    }
    .btn-file input[type=file] {
        position: absolute;
        top: 0;
        right: 0;
        min-width: 100%;
        min-height: 100%;
        font-size: 100px;
        text-align: right;
        filter: alpha(opacity=0);
        opacity: 0;
        outline: none;
        background: white;
        cursor: inherit;
        display: block;
    }
/*file select */
</style>
<script src="<?php echo base_url(); ?>js/md5.js"></script>
<script>
$(document).ready(function(e){
$(".saveUserProfile:eq(0)").click(function(e){
	var md5 = $.md5($(".userpassenter").val());
	if(md5!='<?php echo $profile['password']; ?>')
	{
		$(".userpasswrong").text('*Your password is invalid!');
		return false;
	}	
	e.preventDefault();
	$(".saveUserProfile:eq(1)").trigger("click");
});

			/* Clear Broser Console */
		console.log(window.console);
		if(window.console || window.console.firebug) {
		  console.clear();
		}
		
		/* Clear Broser Console */
	
	$('#personal_btn').click(function(){
		
		$('#inputPassword3').val('');
		$('#form_name').val('personal');
	});
	$('#bank_btn').click(function(){
		$('#form_name').val('bank');
	});
	
	$('#dispatcher_btn').click(function(){
		$('#form_name').val('dispatcher');
		var dp=0;
		$("input[name='dispatcher_location[]']").each(function(){
			if($(this).prop('checked')==true)
			dp++;
		});
		if(!dp)
		{
			setTimeout(function(){$("#myModal").modal('hide');},10);
		}
	});
	var hash = window.location.hash;
	
	if(hash!='')
	{
		$('.nav-tabs a[href="' + hash + '"]').tab('show');
	}
	$("#imgInp").click(function(){
		$('#remove').before().find('button').remove();
	});
	$("#imgInp").change(function(){
		var ext = $('#imgInp').val().split('.').pop().toLowerCase();
		$('#img_button').remove();
		$('.help-block').text('');
		if($('#remove').before().find('button').attr('type')!='button')
			$('#remove').before('<button type="submit" class="btn btn-success " id="img_button" ><i class="fa fa-save"></i></button>&nbsp;&nbsp;&nbsp;');
		if($.inArray(ext, ['gif','jpg','jpeg']) == -1) {
			$('.help-block').text('Invalid File Selected!');
			$('#img_button').attr("disabled","disabled");
		}
		
	});
	
});
$('#frm1').submit(function(){
	var formData = new FormData($(this)[0]);
	
	$.ajax({
	  type: "POST",
	  url: '<?php echo base_url().'index.php/profile/edit';?>',
	  data: data,
	  success: success,
	  dataType: dataType
	});
});
</script>
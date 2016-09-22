<?php include("inner_menu.php");?>


<section class="container">

<div class="row">
<div class="col-sm-12">
<h3 class="text-orange bottom-margin">MyProfile</h3>
  <!-- Nav tabs -->
  <div class="col-sm-12 col-md-3 col-xs-12">
	<div class="logo-img bottom-margin text-center">
	<?php ?>
	<img src="<?php echo base_url().$profile['photo'];?>">
	</div>
	
  </div>
  <div class="col-sm-12 col-xs-12 col-md-9">
  <ul class="nav nav-tabs hidden-xs " role="tablist">
    <li role="presentation" class="active"><a href="#Personal" aria-controls="Personal" role="tab" data-toggle="tab">
Personal Information</a></li>
    <li role="presentation"><a href="#Bank" aria-controls="Bank" role="tab" data-toggle="tab">Bank Information</a></li>
	<li role="presentation"><a href="#Key" aria-controls="Key" role="tab" data-toggle="tab">Trusted Payer Key</a></li>
	<li role="presentation"><a href="#Dispatcher" aria-controls="Dispatcher" role="tab" data-toggle="tab">Dispatcher</a></li>
   
  </ul>
  
  <ul class="nav nav-tabs visible-xs " role="tablist">
    <li role="presentation" class="active"><a href="#Personal" aria-controls="Personal" role="tab" data-toggle="tab"><i class="fa fa-user"></i></a></li>
    <li role="presentation"><a href="#Bank" aria-controls="Bank" role="tab" data-toggle="tab"><i class="fa  fa-university"></i> </a></li>
	<li role="presentation"><a href="#Key" aria-controls="Key" role="tab" data-toggle="tab"><i class="fa  fa-key"></i> </a></li>
	<li role="presentation"><a href="#Dispatcher" aria-controls="Dispatcher" role="tab" data-toggle="tab"><i class="fa fa-paper-plane "></i> </a></li>
   
  </ul>
  
  
 <!-- <div class="dropdown visible-xs">
  <button class="btn  btn-primary btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
    Dropdown
    <span class="caret"></span>
  </button>
  <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
    <li role="presentation" class="active"><a href="#Personal" aria-controls="Personal" role="tab" data-toggle="tab">
Personal Information</a></li>
    <li role="presentation"><a href="#Bank" aria-controls="Bank" role="tab" data-toggle="tab">Bank Information</a></li>
	<li role="presentation"><a href="#Key" aria-controls="Key" role="tab" data-toggle="tab">Trusted Payer Key</a></li>
	<li role="presentation"><a href="#Dispatcher" aria-controls="Dispatcher" role="tab" data-toggle="tab">Dispatcher</a></li>
  </ul>
</div> -->
  <!-- Tab panes -->
  <div class="tab-content" style="min-height:450px">
  

  
    <div role="tabpanel" class="tab-pane active " id="Personal">
			<div class="row">
			<h4 class="text-sky">Personal Information</h4>
			<form class="form-horizontal">
			<div class="form-group">
			<label for="inputEmail3" class="col-sm-4 col-xs-5 control-label">Name :</label>
			<div class="col-sm-8 col-xs-7 control-label" style="text-align:left">
			  <div><?php echo isset($profile['first_name']) ? $profile['first_name']  : ''; echo  isset($profile['last_name']) ? '&nbsp;'.$profile['last_name']  : ''; ?></div>
			</div>
		  </div>
		  <div class="form-group">
			<label for="inputEmail3" class="col-sm-4 col-xs-5 control-label">Email :</label>
			<div class="col-sm-8 col-xs-7 control-label" style="text-align:left">
			  <span> <?php echo isset($profile['email'])?$profile['email']:'';?> </span>
			</div>
		  </div>
		 
		  <div class="form-group">
			<label for="inputEmail3" class="col-sm-4 col-xs-5 control-label">Register As :</label>
			<div class="col-sm-8 col-xs-7 control-label" style="text-align:left">
			 <span><?php if($profile['is_company']) echo "Business"; else echo "Personal";?></span>
			</div>
		  </div>
		  
		  <div class="form-group">
			<label for="inputEmail3" class="col-sm-4 col-xs-5 control-label">Address :</label>
			<div class="col-sm-8 col-xs-7 control-label" style="text-align:left">
			 <span><?php echo isset($profile['customer_add'])? $profile['customer_add'] : '';?></span>
			</div>
		  </div>
		  <div class="form-group">
			<label for="inputEmail3" class="col-sm-4 col-xs-5 control-label">Phone : </label>
			<div class="col-sm-8 col-xs-7 control-label" style="text-align:left">
			  <span><?php echo isset($profile['phonecode']) && $profile['phonecode']!=0? '+'.$profile['phonecode'] : '';?><?php echo isset($profile['customer_phone'])? ' '.$profile['customer_phone'] : '';?> &nbsp;&nbsp;&nbsp;<?php if($profile['verify']){?><i class="text-success fa fa fa-check-square-o fa-2x"></i> <?php }else{ ?><i class="text-danger fa fa-shield fa-2x"></i> <?php } ?></span>
			</div>
		  </div>
		  <div class="form-group">
			<label for="inputEmail3" class="col-sm-4 col-xs-5 control-label">Business Name : </label>
			<div class="col-sm-8 col-xs-7 control-label" style="text-align:left">
			  <span><?php echo isset($profile['business_info'])? $profile['business_info'] : ''; ?></span>
			</div>
		  </div>
		  <div class="form-group">
			<label for="inputEmail3" class="col-sm-4 col-xs-5 control-label">Business Type : </label>
			<div class="col-sm-8 col-xs-7 control-label" style="text-align:left">
			  <span><?php echo isset($profile['business_type'])? $profile['business_type'] : ''; ?></span>
			</div>
		  </div>
		  <div class="form-group">
			<div class="col-sm-offset-4 col-sm-8 col-xs-12">
			<a href="<?php echo base_url();?>index.php/profile/edit#Personal" class="btn btn-success ">Edit</a>
			 
			</div>
		  </div>
		</form>
		</div>
	</div>
	<?php //print_r($profile);?>
    <div role="tabpanel" class="tab-pane " id="Bank">
		<div class="row">
			<div class="col-sm-6">
			<h4 class="text-sky">Account Information</h4>
				<form class="form-horizontal">
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-5 col-xs-5 ">Account No:  </label>
						<div class="col-sm-7 col-xs-7">
						  <span class="control-label"><?php echo isset($profile['bank_ac'])? $profile['bank_ac'] : ''; ?></span>
						</div>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-5 col-xs-5 ">Account Name:  :</label>
						<div class="col-sm-7 col-xs-7">
						<span class="control-label"><?php echo isset($profile['bank_ac_name'])? $profile['bank_ac_name'] : ''; ?></span>
						</div>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-5 col-xs-5 ">Debit / Credit Card :</label>
						<div class="col-sm-7 col-xs-7">
						<span class="control-label"><?php echo isset($profile['dr_cr_card'])? $profile['dr_cr_card'] : ''; ?></span>
						</div>
					</div>
					<div class="form-group">
					<label for="inputPassword3" class="col-sm-5 col-xs-5 ">PayPal email : </label>
						<div class="col-sm-7 col-xs-7">
						 <span class="control-label"><?php echo isset($paypal_email)? $paypal_email : ''; ?></span>
						</div>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-5 col-xs-5 ">Purpose Code </label>
						<div class="col-sm-7 col-xs-7">
						  <span class="control-label"><?php echo isset($profile['purpose_code'])? $profile['purpose_code'] : ''; ?></span>
						</div>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-5 col-xs-5 ">Purpose Code </label>
						<div class="col-sm-7 col-xs-7">
						  <span class="control-label"><?php echo isset($profile['bank_ac_address1'])? $profile['bank_ac_address1'] : ''; ?></span>
						</div>
					</div>
					
				</form>
			</div>
			<div class="col-sm-6">
			<h4 class="text-sky">Bank Information</h4>
				<form class="form-horizontal">
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-5 col-xs-5 ">Bank Name : </label>
						<div class="col-sm-7 col-xs-7">
						  <span class="control-label"><?php echo isset($profile['bank_ac'])? $profile['bank_name'] : ''; ?></span>
						</div>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-5 col-xs-5 ">Routing No :</label>
						<div class="col-sm-7 col-xs-7">
						<span class="control-label"><?php echo isset($profile['routing_no'])? $profile['routing_no'] : ''; ?></span>
						</div>
					</div>
					<div class="form-group">
					<label for="inputPassword3" class="col-sm-5 col-xs-5 ">Bank Address : </label>
						<div class="col-sm-7 col-xs-7">
						 <span class="control-label"><?php echo isset($profile['bank_address'])? $profile['bank_address'] : ''; ?></span>
						</div>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-5 col-xs-5 ">Bank Country :</label>
						<div class="col-sm-7 col-xs-7">
						  <span class="control-label"><?php echo isset($profile['bankname'])? $profile['bankname'] : ''; ?></span>
						</div>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-5 col-xs-5 ">Bank Account Type : </label>
						<div class="col-sm-7 col-xs-7">
						  <span class="control-label"><?php echo isset($profile['bank_ac_type'])? $profile['bank_ac_type'] : ''; ?></span>
						</div>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-5 col-xs-5 ">Address Line2 :  </label>
						<div class="col-sm-7 col-xs-7">
						  <span class="control-label"><?php echo isset($profile['bank_ac_address2'])? $profile['bank_ac_address2'] : ''; ?></span>
						</div>
					</div>
					
				</form>
			</div>
			<div class="col-sm-12">
				<div class="form-group">
					<div class="col-sm-offset-4 col-sm-8">
					<a href="<?php echo base_url();?>index.php/profile/edit#Bank" class="btn btn-success ">Edit</a>
					</div>
				</div>
			</div>
			
		</div>
	</div>
    
	<div role="tabpanel" class="tab-pane " id="Key">
		<div class="row">
		<h4 class="text-sky">Trusted Payer</h4>
		<form class="form-horizontal">
			<div class="form-group">
			<label for="inputEmail3" class="col-sm-4 col-xs-6 control-label">Trusted Payer Key : </label>
			<div class="col-sm-8 col-xs-6">
			 <span><?php echo str_repeat("X", (strlen($customer_key)-3)).substr($customer_key,-3) ; ?> </span>
			 <a class="btn btn-success" data-toggle="modal" data-target="#myModal" id="bank_btn">Show</a>
			</div>
		  </div>
		  </form >
	</div>
  </div>
  
    <div role="tabpanel" class="tab-pane " id="Dispatcher">
		<div class="row">
		<h4 class="text-sky">Dispatcher</h4>
		<form class="form-horizontal">	
<?php if($profile['dispatcher_location']!='null' && $profile['dispatcher_location'] && $profile['dispatcher_id']){?>		
		<div class="form-group">
			<label for="inputPassword3" class="col-sm-4 col-xs-5 control-label">Dispatcher Code :</label>
			<div class="col-sm-8 col-xs-7">
			 <span><?php echo $profile['dispatcher_id']; ?></span>
			</div>
		  </div>
		  
		  <div class="form-group">
			<label for="inputPassword3" class="col-sm-4 col-xs-5 control-label">Jurisdiction :</label>
			<div class="col-sm-8 col-xs-7">
			 <span><?php echo implode(", ",json_decode($profile['dispatcher_location'])); ?></span>
			</div>
		  </div>
		  
		  
		   <div class="form-group">
			<div class="col-sm-offset-4 col-sm-8">
			<a href="<?php echo base_url();?>index.php/profile/edit#Dispatcher" class="btn btn-danger ">Edit</a>
			</div>
		  </div>
		  <?php } else{?>
		  <div class="form-group">
			<div class="col-sm-offset-4 col-sm-8">
			  <a href="<?php echo base_url();?>index.php/profile/edit#Dispatcher" class="btn btn-danger ">Subscribe Now</a>
			</div>
		  </div>
		  <?php }?>
		  </form>
	</div>
  </div>
  
  <!-- Modal -->
	
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title text-orange" id="myModalLabel">Enter Password for Edit Profile</h4>
		  </div>
		  <div class="modal-body">
		  <div class="row">
		   <div class="form-group" id="group">
				<label for="inputPassword3" class="col-sm-2 control-label">Password</label>
				<div class="col-sm-10">
				  <input type="password" class="form-control" id="pwd_reg" name="password" placeholder="Enter Your Password" >
				</div>
			  </div>
			<h1 class="text-center" id="tp_k" style="display:none"> <strong><?php echo  $customer_key;?></strong> </h1> 
			  
			  <div>
			  </div>
			</div>
		  </div>
		  <div class="modal-footer">
			<button type="button" id="md_close" class="btn btn-default" data-dismiss="modal">Close</button>
			<button type="button" id="tp_key" class="btn btn-primary">Confirm</button>
		  </div>
		</div>
	  </div>
	</div>
	<!-- Modal -->

</div>
</div>
</div>
</div>
</section>
<script>
$(document).ready(function(){
var hash = window.location.hash;
if(hash!='')
{
	$('.nav-tabs a[href="' + hash + '"]').tab('show');
}
	$('#pwd_reg').keyup(function(){
		var password = $("#pwd_reg").val();
		if( password !='' )
		{
			$('#pwd_reg').css("border","1px solid #ccc");
			$('#pwd_reg').css("box-shadow","none");
		}
		if( password ==''  )
		{
			$('#pwd_reg').css("border","2px solid red");
			$('#pwd_reg').css("box-shadow","0 0 3px red");
			//alert("Please fill all fields...!!!!!!");
		}
	});
	$("#tp_key").click(function(){
				
				
				var password = $("#pwd_reg").val();
				var $a = 0;
				if( password =='' || password.length <=3 )
				{
					$('#pwd_reg').css("border","2px solid red");
					$('#pwd_reg').css("box-shadow","0 0 3px red");
					//alert("Please fill all fields...!!!!!!");
					 $a++;
				}
				if($a==0)
				{
					
					$.post("<?php echo base_url();?>index.php/profile/validate_password",{ password: password},
						function(data) {
						if(data=='1') 
						{
							
							$("#tp_k").css("display","block");
							$("#myModalLabel").text("Trusted Payer Key");
							$("#group").hide();
							$("#tp_key").hide();
							
						}
						});
					
				}
				
			});	
			$('#md_close').on('click', function () {
				$("#tp_k").css("display","none");
				$("#myModalLabel").text("Enter Password for Edit Profile");
				$("#group").show();
				$("#tp_key").show();
			});

});
					
</script>
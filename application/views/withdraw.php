<?php include("inner_menu.php"); //echo "<pre>"; print_R($userinfo); ?>
<div class="seperator">
</div>
<section class="container">
<div class="row">
<div class="col-sm-offset-1 col-sm-10 ">
	<div class="box box-warning box-solid">
	<form name="" method="post" action="" >
       <div class="box-header">
        <h3 class="box-title">Withdrawal</h3>              
              <!-- /.box-tools -->
       </div>
            <!-- /.box-header -->
        <div class="box-body" style="display: block;">
		<div class="row block">
              
			  <div class="col-md-6">
			  <h4 class="text-orange">Amount to withdraw</h4>
			  <!--<div class="form-group bottom-margin row ">
				<label class="col-sm-12 control-label" for="formGroupInputLarge">Currency of bank account:</label>
				<div class="col-sm-6">
				<select class="form-control" name="currency_id">
					<?php foreach($currencies as $c):?>
						<option <?php if($this->session->userdata('currency_id') == $c['currency_id']) echo "selected";?> value="<?php echo $c['currency_id']?>"><?php echo $c['currency_symbol'].' '.$c['code'];?></option>
					<?php endforeach;?>
				</select>
				</div>
			  </div>-->
			  <div class="form-group bottom-margin row ">
				<label class="col-sm-12 control-label" for="formGroupInputLarge">Withdraw Amount</label>
				<div class="col-sm-12">
					<form class="form-inline">
						  <div class="form-group">
							<label class="sr-only" for="exampleInputAmount">Amount (in dollars)</label>
							<div class="input-group">
							  <div class="input-group-addon"><?php echo $currency_symbol;?></div>
							  <input type="text" name="amount" class="form-control" id="exampleInputAmount" value="<?php echo ($current_balance['amount'])*$value;?>" placeholder="0.00">
							  <input type="hidden" name="currency_id" value="<?php echo $this->session->userdata('currency_id');?>" >
							 
							</div>
						  </div>
						 
						</form>
						<span><small>Note: minmum amount <?php echo $currency_symbol;?> <?php echo ($value*30)." ".$currency_title;?> </small></span>
				</div>
			  </div>
			 
			  
			  </div>
			  <div class="col-md-6 text-right">
			 <h3 class="text-hd-3">You will receive</h3>
			 <h1 class="text-hd-1"><?php echo $currency_symbol.' ';?><?php echo number_format(($current_balance['amount'])*$value,2);?><br> <?php echo $currency_title;?></h1>
			  <h5 class="text-hd-5">There is no withdrawal fee</h5>
			 
			  </div>
			</div>  
			  
		<div class="row bottom-margin block">
		<h4 class="text-orange ">Provide Your Bank information</h4>
		
		<h5> This is the account where the transer will be sent.</h5>
		<div class="col-sm-12">
			<div class="row bottom-margin">
			<form class="form-horizontal parent-selector">
				<div class="form-group">
					<label for="inputEmail3" class="col-sm-3 control-label">Bank Name</label>
					<div class="col-sm-8">
					  <input type="text" class="form-control" id="inputEmail3" placeholder="Name of bank" value="<?php echo isset($userinfo['bank_name'])?$userinfo['bank_name']:'';?>" />
					</div>
				</div>
				<div class="form-group">
					<label for="inputPassword3" class="col-sm-3 control-label">Routing Number</label>
					<div class="col-sm-8">
					  <input type="text" class="form-control" id="inputPassword3" placeholder="012345666666" value="<?php echo isset($userinfo['routing_no'])?$userinfo['routing_no']:'';?>" />
					</div>
				</div>
				<div class="form-group">
					<label for="inputPassword3" class="col-sm-3 control-label">BankCity/State</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" id="inputPassword3" placeholder="BankCity, State" value="<?php echo isset($userinfo['bank_country_name'])?$userinfo['bank_country_name']:'';?>" />
					</div>
				</div>
				<div class="form-group">
					<label for="inputPassword3" class="col-sm-3 control-label">Account Number</label>
					<div class="col-sm-8">
					  <input type="text" class="form-control" id="inputPassword3" placeholder="012345666666" value="<?php echo isset($userinfo['bank_ac'])?$userinfo['bank_ac']:'';?>" />
					</div>
				</div>
				<div class="form-group">
					<label for="inputPassword3" class="col-sm-3 control-label">Country</label>
					<div class="col-sm-8">
						<select class="form-control">
						  <option selected><?php echo isset($userinfo['bank_country_name'])?$userinfo['bank_country_name']:'';?></option>
						  <option>2</option>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label for="inputPassword3" class="col-sm-3 control-label">Account Type</label>
					<div class="col-sm-8">
					 <select class="form-control">
						   <option selected><?php echo isset($userinfo['bank_ac_type'])?strtoupper($userinfo['bank_ac_type']):'';?></option>
						  <option>2</option>
						  
						</select>
					</div>
				</div>
			</form>
			</div>
		</div>
		</div><!--- block  ends-->
			 
		<div class="row bottom-margin block">
		<h4 class="text-orange">Provide Your Account Detail</h4>
		
		<h5 class="text-hd-5">Enter the account name exaclty as it appears on your bank account</h5>
		<div class="col-sm-12">
			<div class="row bottom-margin">
				<form class="form-horizontal parent-selector">
				  <div class="form-group">
					<label for="inputEmail3" class="col-sm-3 control-label">Account Name</label>
					<div class="col-sm-8">
					  <input type="text" class="form-control" id="inputEmail3" placeholder="Name of account" value="<?php echo isset($userinfo['bank_ac_name'])?$userinfo['bank_ac_name']:'';?>" />
					</div>
				  </div>
				  <div class="form-group">
					<label for="inputPassword3" class="col-sm-3 control-label">Address line 1 </label>
					<div class="col-sm-8">
						<textarea  class="form-control" cols="20" rows="3" ><?php echo isset($userinfo['bank_ac_address2'])?$userinfo['bank_ac_address2']:'';?></textarea>
					</div>
				  </div>
				  <div class="form-group">
					<label for="inputPassword3" class="col-sm-3 control-label">Address line 2 </label>
					<div class="col-sm-8">
					 
					  <textarea  class="form-control" cols="20" rows="3" ><?php echo isset($userinfo['bank_ac_address2'])?$userinfo['bank_ac_address2']:'';?></textarea>
					</div>
				  </div>
				  
				  <div class="form-group">
					<label for="inputPassword3" class="col-sm-3 control-label">Country</label>
					<div class="col-sm-8">
					  <select class="form-control">
						   <option selected><?php echo isset($userinfo['bank_country_name'])?$userinfo['bank_country_name']:'';?></option>
						  <option>2</option>
						  
						</select>
					</div>
				  </div>
				  
				</form>
			</div>
		</div>
		<!--<div class="col-sm-1">
			<span class="addicon"><a href="#" class="text-sky"><i class="fa fa-plus-circle"></i></a> <a href="#" class="text-sky"> <i class="fa fa-minus-circle"></i></a></span>
		</div> -->
		</div>
		<div class="row button-grp bottom-margin ">
			<div class="col-sm-12 btn_withdraw">
				<?php if($userinfo['bank_country_name']!='' && $userinfo['bank_ac_type'] !='' && $userinfo['bank_ac'] !='' &&  $userinfo['routing_no'] !='' && $userinfo['bank_name']!='' && $userinfo['bank_country_name']!='' ){ ?>
				<button type="submit" class="btn btn-primary ">Withdraw Funds</button> 
				<?php }else{?>
				<button type="button" class="btn btn-primary withdraw_fund">Withdraw Funds</button> 
				<?php }?>
				
				<a class="btn btn-danger pull-right " href="<?php echo base_url();?>profile/edit#Bank">Edit Bank information</a>  
			</div>
		</div>
        </div>
            <!-- /.box-body -->
       </div>
	</form>   
</div>
</div>
</section>	

<script>	

$('.withdraw_fund').click(function(){
	
	var	html='<div class="alert alert-danger alert-dismissible alert-box" role="alert" style="position:absolute;top:0px;z-index:111;width:100%;"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong>Please Fillup your Bank Information</strong></div>';
	$('nav.custom-nav').prepend(html);
	$('html').animate({ scrollTop: 0 }, 'slow');
	
})

</script>	

<script>	
$(".parent-selector :input").attr("disabled", true);
</script>	
	
	
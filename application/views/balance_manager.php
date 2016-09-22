

<?php include('inner_menu.php');?>
<div class="seperator">
</div>
<section class="container">
<div class="row">
<div class="col-sm-12 col-xs-12 col-md-12">
    <ul class="nav nav-tabs hidden-xs " role="tablist">
		<li role="presentation" class="active"><a href="#deposite" aria-controls="deposite" role="tab" data-toggle="tab"><i class="fa fa-download fa-2x"></i> Deposit Fund</a></li>
		<li role="presentation"><a href="#withdraw" aria-controls="withdraw" role="tab" data-toggle="tab"><i class="fa fa-share-square-o fa-2x"></i> Withdraw Amount</a></li>
    </ul>
	<div class="tab-content" style="min-height:450px">
		<div role="tabpanel" class="tab-pane active " id="deposite"> 
			<h3 class="text-orange">Deposit Fund</h3>
			<?php if($this->session->flashdata('message')){ echo $this->session->flashdata('message'); } ?>
			<div class = "col-sm-6 col-md-3 col-lg-4">
			  <div class = "thumbnail">
				 <img src="<?php echo base_url();?>images/paypal-icon.png" alt = "payment" style="height:80px; !important">
				  <div class = "caption">
					 <h3>Paypal deposit</h3>
					  <p>
						 <?php echo form_open('','name="balance_manager" id="form-balance_manager"')?>
						 <input type="text" name="amount" id="amount" class="form-control bottom-margin" placeholder="Enter amount">
						<input type="submit" name="submit" value="Transfer" class="btn-block btn-primary btn btn-md">
						</form>
					 </p>
					 
				  </div>
			  </div>
			</div>

			<div class = "col-sm-6 col-md-3 col-lg-4">
			  <div class = "thumbnail">
				 <img src="<?php echo base_url();?>layout-1/img/logo.png" style="height:80px; !important" />
			  
			  
			  <div class = "caption">
				 <h3> Testing Deposit</h3>
				  <p>
					   <?php echo form_open('','name="balance_manager" id="form-balance_manager"')?>
				 <input type="text" name="amount" id="amount" class="form-control bottom-margin" placeholder="Enter amount">
				<input type="submit" name="testing" value="Transfer" class="btn-block btn-primary btn btn-md">
				</form>
				 </p>
				</div> 
			  </div>
			</div>

			<div class = "col-sm-6 col-md-3 col-lg-4">
			  <div class = "thumbnail">
				 <img src="<?php echo base_url();?>images/cashenvoylogo.png" style="height:80px; !important"/>
			  
			  
			  <div class = "caption">
				 <h3> Cashenvoy Deposit</h3>
				  <p>
					<form method="POST" target="iframe" name="cash" id="cashenvoy" action="http://test.epagestore.in/payment/payment.php">    
					 <input type="text" name="amount" id="cashenvoy_amt" class="form-control bottom-margin" placeholder="Enter amount (₦ NGN)">		 
					<?php $randomString = substr(str_shuffle("01234567890123456789"), 0, 17);
					$this->session->set_userdata('transaction_id','TP'.$randomString);?>
					<input type="hidden" name="unique_id" id="amount" class="form-control" value="<?php echo 'TP'.$randomString;?>" />
						 <!--<img src="<?php //echo base_url();?>img/pay_btn11.png" onclick="validate();">-->
				   <input type="button" name="submit" value="Transfer" id="submit_t" class="btn-block btn-primary btn btn-md">
				   <input type="submit" id="transfer" value="Transfer" class=" hidden btn-block btn-primary btn btn-md">
					</form>
				 </p>
				</div> 
			  </div>
			</div>
			<div class="col-sm-4 col-md-4 col-lg-4">
				<form class="form-horizontal thumbnail"  id="myCCForm" method="post" action="<?php echo base_url();?>contact.php">
					<fieldset >
					  <legend class="text-orange">2checkout</legend>
					  
					  <div class="form-group">
						
						<div class="col-sm-12">
						  <input class="form-control"  id="ccNo" type="text" value="" autocomplete="off" required placeholder="Debit/Credit Card Number">
						</div>
					  </div>
					  <div class="form-group">
						
						<div class="col-sm-12">
						  <div class="row">
							<div class="col-xs-6">
							  <select class="form-control col-sm-2" id="expMonth" name="expiry-month" >
								<option>Month</option>
								<option value="01">Jan (01)</option>
								<option value="02">Feb (02)</option>
								<option value="03">Mar (03)</option>
								<option value="04">Apr (04)</option>
								<option value="05">May (05)</option>
								<option value="06">June (06)</option>
								<option value="07">July (07)</option>
								<option value="08">Aug (08)</option>
								<option value="09">Sep (09)</option>
								<option value="10">Oct (10)</option>
								<option value="11">Nov (11)</option>
								<option value="12">Dec (12)</option>
							  </select>
							</div>
							<div class="col-xs-6">
							  <select class="form-control" name="expiry-year" id="expYear">
								<option value="13">2013</option>
								<option value="14">2014</option>
								<option value="15">2015</option>
								<option value="16">2016</option>
								<option value="17">2017</option>
								<option value="18">2018</option>
								<option value="19">2019</option>
								<option value="20">2020</option>
								<option value="21">2021</option>
								<option value="22">2022</option>
								<option value="23">2023</option>
							  </select>
							</div>
						  </div>
						</div>
					  </div>
					  <div class="form-group">
						<div class="col-sm-6">
						  <input type="text" class="form-control" name="cvv" id="cvv" placeholder="Security Code">
						</div>
					  
						<div class="col-sm-6">
						  <input type="hidden" class="form-control" name="token" id="_token" placeholder="Deposit Amount">
						  <input type="text" class="form-control" name="amount" id="amount-2check" placeholder="Deposit Amount">
						</div>
					  </div>
					  <div class="form-group">
						<div class="col-sm-12">
						  <button type="submit" class="btn-block btn btn-md btn-primary" style="width:100%">Transfer</button>
						
						</div>
					  </div>
					</fieldset>
				  </form>
			</div>
			<div class = "col-sm-6 col-md-3 col-lg-4">
			  <div class = "thumbnail">
				 <img src="<?php echo base_url();?>images/paystack.jpg" style="height:75px; !important"/>
			  
			  
			  <div class = "caption">
				 <h3>Paystack Deposit</h3>
				  <p>
					<form method="POST"  name="cash" id="paystack-form" action="http://test.epagestore.in/payment/payment.php">    
					 <input type="text" name="amount" id="paystack_amt" class="form-control bottom-margin" placeholder="Enter amount (₦ NGN)">		 
					<?php $randomString = substr(str_shuffle("01234567890123456789"), 0, 17);
					$this->session->set_userdata('transaction_id','TP'.$randomString);?>
					<input type="hidden" name="unique-paystack" id="unique_id1" class="form-control" value="<?php echo 'TP'.$randomString;?>" />
						 <!--<img src="<?php //echo base_url();?>img/pay_btn11.png" onclick="validate();">-->
					<input type="button" name="submit" value="Transfer" id="submit-paystack" class="btn-block btn-primary btn btn-md">
					<input type="submit" id="transfer-paystack" value="Transfer" class=" hidden btn-block btn-primary btn btn-md">
					</form>
				 </p>
				</div> 
			  </div>
			</div>
			<?php /*?>Current Balance : <?php echo $balance['amount'];?><br />
			<span style="color:red;">Total Payment in-process : <?php echo $pending_amount;?><br></span><?php */?>
			</div>

			<div role="tabpanel" class="tab-pane " id="withdraw">
				<div class="seperator"></div>
				<div class="col-sm-offset-1 col-sm-10 ">
					<div class="box box-warning box-solid">
					<form name="" method="post" action="<?php base_url();?>order/withdraw" >
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
	</div>
</div>
<?php /*?><a href="<?php echo base_url()."index.php/order"?>">Make order</a><br /><?php */?>
<?php /*?><a href="<?php echo base_url()."index.php/order/order_list"?>">Placed order</a><br />
<a href="<?php echo base_url()."index.php/order/recived_order_list"?>">Recived Order</a><?php */?>

</div>
</section>
<a class="hidden" data-toggle="modal" data-target="#myModal" id="bank_btn">Show</a>

<iframe src="" name="iframe" width="100%" height="100%" style="display:none" frameBorder="0" id="ifr" >	</iframe>

<script>

//document.getElementById('some_frame_id').contentWindow.location.reload();
	$('#submit-paystack').click(function(){
		
		var amount=$('#paystack_amt').val();
		var uniqid=$('#unique_id1').val();
		amount = amount.replace(',','');
		if(amount=='')
		{
			return false;
		}
		ajaxindicatorstart('loading data.. please wait..');
		$.post("<?php echo base_url();?>index.php/balance_manager/c_post",{ amount: amount,unique_id:uniqid},
		function(data) {
			var t = $.parseJSON(data);
			
			if(t.status===true) 
			{
				$('#paystack-form').attr('action',t.url);
				//$('#password').css({"border":"2px solid #00F5FF","box-shadow":"0 0 5px #00F5FF"});
				$('section').fadeOut();
				$('.navbar-nav').fadeOut();
				 $('iframe').height('750px');
				 $('iframe').fadeIn();
				$('#transfer-paystack').trigger("click");
			}
			else
			{
				alert(t.status);
			}
		});
		setTimeout(function(){ ajaxindicatorstop(); }, 3000);
	});	

</script>




<script type="text/javascript">
  // Called when token created successfully.
  var successCallback = function(data) {
    var myForm = document.getElementById('myCCForm');

    // Set the token as the value for the token input
    myForm.token.value = data.response.token.token;
	$('#_token').val(data.response.token.token)
		console.log(data);
    // IMPORTANT: Here we call `submit()` on the form element directly instead of using jQuery to prevent and infinite token request loop.
    myForm.submit();
  };

  // Called when token creation fails.
  var errorCallback = function(data) {
    if (data.errorCode === 200) {
      // This error code indicates that the ajax call failed. We recommend that you retry the token request.
    } else {
      alert(data.errorMsg);
    }
  };
//'16C2AF17-121D-44DE-AE8E-FA63583942BD'
  var tokenRequest = function() {
    // Setup token request arguments
    var args = {
      sellerId: "102941659",
      publishableKey: "1C657D2C-5243-4283-91D8-701A7A7282ED",
      ccNo: $("#ccNo").val(),
      cvv: $("#cvv").val(),
      expMonth: $("#expMonth").val(),
      expYear: $("#expYear").val()
    };
    // Make the token request
    TCO.requestToken(successCallback, errorCallback, args);
  };

  $(function() {
    // Pull in the public encryption key for our environment
    TCO.loadPubKey('production');

    $("#myCCForm").submit(function(e) {
      // Call our token request function
      tokenRequest();

      // Prevent form from submitting
      return false;
    });
  });


$(document).ready(function(){
	var hash = window.location.hash;
	if(hash!='')
	{
		$('.nav-tabs a[href="' + hash + '"]').tab('show');
	}
	
	$('#cashenvoy').on("submit",function(){
		$('section').fadeOut();
		$('.navbar-nav').fadeOut();
		 $('iframe').fadeIn();
		 
		 
	});
	$('#cashenvoy_amt').keyup(function(){
		var amount = $('#cashenvoy_amt').val();
		if( amount !='' )
		{
			$('#cashenvoy_amt').css("border","1px solid #66afe9");
			$('#cashenvoy_amt').css("box-shadow","0 0 3px  #66afe9 ");
			//alert("Please fill all fields...!!!!!!");
			
		}
	});
	$('#submit_t').click(function()
	{
			$a=0;
			var amount = $('#cashenvoy_amt').val();
			if( amount =='' )
			{
				$('#cashenvoy_amt').css("border","1px solid red");
				$('#cashenvoy_amt').css("box-shadow","0 0 3px red");
				//alert("Please fill all fields...!!!!!!");
				 $a++;
			}
			if($a==0)
			{
				$('#transfer').trigger("click");
			}
			
		});
		
	});
	$('.withdraw_fund').click(function(){
		
		var	html='<div class="alert alert-danger alert-dismissible alert-box" role="alert" style="position:absolute;top:0px;z-index:111;width:100%;"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong>Please Fillup your Bank Information</strong></div>';
		$('nav.custom-nav').prepend(html);
		$('html').animate({ scrollTop: 0 }, 'slow');
		
	})
	$(".parent-selector :input").attr("disabled", true);
</script>
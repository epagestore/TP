<?php include("inner_menu.php");?>

<div class="seperator">
</div>

<div class="seperator">
</div>
<section class="container">
<?php echo form_open('','enctype="multipart/form-data" name="despute_order" id="form-despute_order"  class="form-horizontal"')?>

<div class="row">
	<div class="col-md-12">
	<h3 class="text-orange">Dispute </h3>
	<div class="step-process">
		<div class="row steps bottom-margin">
	<div class=" col-md-3 col-sm-6 col-xs-12 main-stage-active ">
		<div class="stage">
		<span class="stageno pull-left">1</span>
		<span class="sname pull-left">IDENTIFY THE ISSUE</span>
		</diV>
		
	</div>
	<div class="col-md-3 col-md-3 col-sm-6 col-xs-12 main-stage ">
		<div class="stage">
		<span class="stageno pull-left">2</span>
		<span class="sname pull-left">NEGOTIATIONS</span>
		</diV>
		
	</div>
	<div class=" col-md-3 col-sm-6 col-xs-12 main-stage ">
		<div class="stage">
		<span class="stageno pull-left">3</span>
		<span class="sname pull-left">FINAL OFFERS/ EVIDANCE</span>
		</diV>
		
	</div>
	<div class="col-md-3  col-sm-6 col-xs-12 main-stage ">
		<div class="stage">
		<span class="stageno pull-left">4</span>
		<span class="sname pull-left">RESOLUTION</span>
		</diV>
		
	</div>
	</div>
  <!-- Tab panes -->


 
    <div  class="tab-pane ">

	
			<div class="form-group">
			<label for="inputEmail3" class="col-sm-4 control-label">Disputed order : </label>
			<div class="col-sm-8">
			  <span><?php echo $product_name?></span>
			</div>
		  </div>
		  <div class="form-group">
			<label for="inputEmail3" class="col-sm-4 control-label"><?php if(isset($payer)){?>Payee<?php }else if(isset($payee)){?>Payer<?php }?> :</label>
			<div class="col-sm-8">
			<span><?php if(isset($payee_name)){echo $payee_name;}else if(isset( $payer_name)){echo $payer_name;}?></span>
			
			  <!--<input type="email" class="form-control" id="inputEmail3" placeholder="Email"> -->
			</div>
		  </div>
		 <hr>
		  <div class="form-group">
			<label for="inputPassword3" class="col-sm-4 control-label">Total Price : </label>
			<div class="col-sm-8 totle-value">
			 <span><?php echo $currency_symbol;?><?php echo sprintf("%.2f", ($amount)*$value); ?></span>
			 <?php if($despute_exist){ ?><input type="checkbox" name="cont_prev_desp" />Continue with previous despute.<?php }?>
			</div>
		  </div>
		  <div class="form-group totol-prize-on" id="discount" style="display:none">
			<label for="inputPassword3" class="col-sm-4 control-label totle-prize-name">Discount Claim: </label>
			<div class="col-sm-8 totle-value">
			 <span class="totle-value"></span>
			</div>
		  </div>
		  
		   <div class="form-group totol-prize-on">
                <?php if(isset($payer)){?>
               
               <label class="totle-prize-name col-sm-4 control-label" style=" <?php if($pre_delivery==1) echo "display:none";?>">Pay Amount(<?php echo $currency_symbol;?>)</label>
               <div class="totle-value col-sm-8" style=" <?php if($pre_delivery==1) echo "display:none";?>"><input type="text" name="claim_amount" id="claim_amount_org" placeholder="pay amount" style="width:190px;text-align:center; padding:3px" <?php if($pre_delivery==1){ echo "value='0' disabled";}?>> <?php if($pre_delivery==1){ ?> <input type="hidden" name="claim_amount" value="0" /><?php }?></div>
               
                <?php } if(isset($payee)){?>
				<label for="inputPassword3" class="col-sm-4 control-label totle-prize-name">Claim Amount(<?php echo $currency_symbol;?>): </label>
                
               <div class="totle-value col-sm-8"><span></span>
			   <input type="text" name="claim_amount" class="form-control text-center" id="claim_amount_org" placeholder="Claim amount(<?php echo $currency_symbol;?>)" style="width:190px;padding:3px;"></div>
                <?php } ?>
             </div>
		  
		  <div class="form-group">
			<label for="inputEmail3" class="col-sm-4 control-label">Reason for dispute :  </label>
			<div class="col-sm-8">
			  <select class="form-control" name="despute_reason">
			   <option  value=""> Select a Reason</option>
			  <?php foreach($despute_reasons as $despute_reason):?>
                <option value="<?php echo $despute_reason['reason_id']?>"><?php echo $despute_reason['description'];?></option>
              <?php endforeach; ?>
			  </select>
			</div>
		  </div>
		  <div class="form-group">
			<label for="inputEmail3" class="col-sm-4 control-label">Describe the reason for your dispute in detail :  </label>
			<div class="col-sm-8">
				<textarea class="form-control" rows="3" placeholder="Describe The Reason" name="despute_desc"></textarea>
			</div>
		  </div>
		  <!---- start --->
		    <?php if(isset($payer) && $pre_delivery==0){ ?>
            <div class="form-group add-despute-desrp" >
            <label for="inputEmail3" class="col-sm-4 control-label">Describe Remedy:</label>
               <div class="col-sm-8">
                <select class="form-control" name="remedy" id="remedy">
                    <option disc='' value="">- select -</option>
                    <option value='Discount' >Discount</option>
                    <option value='Replacement' >Replacement</option>
                    <option value='Cancellation' >Cancellation</option>
                 </select>
                </div>
            </div>
            
            <div class="add-despute-desrp" id="remedy_reason">
            
            	<div id="remedy_discount"  class="form-group" style="display:none;">
                    <label for="inputEmail3" class="col-sm-4 control-label">Discount:</label>
                    <div class="col-sm-8"> 
                    <select class="form-control" name="remedyDiscount" id="remedyDiscount">
                        <option disc='100' value="1">-select -</option>
                        <?php foreach($remedy_discounts as $remedy_discount):?>
                        <option disc="<?php echo $remedy_discount['discount']?>" value="<?php echo $remedy_discount['reason_id']?>"><?php echo $remedy_discount['description'];?></option>
                        <?php endforeach;?> 
                    </select>
                    </div>
                </div>
                
                <div class="form-group" id="remedy_replacement" style="display:none;">
                    <label for="inputEmail3" class="col-sm-4 control-label">Replacement:</label>
                    <div class="add-textarea col-sm-8"> 
                    <select class="form-control" name="remedyReplacement" id="remedyReplacement">
                        <option disc='' value="1">- select a reason -</option>
                         <?php foreach($remedy_replacements as $remedy_replacement):?>
                        <option value="<?php echo $remedy_replacement['reason_id']?>"><?php echo $remedy_replacement['description'];?></option>
                        <?php endforeach;?>
                    </select>
                    </div>
                 </div>
				 
                <div class="form-group" id="remedy_cancelation" style="display:none;">
                 	<label for="inputEmail3" class="col-sm-4 control-label">Cancelation:</label>
                    <div class="add-textarea col-sm-8"> 
                    <select class="form-control" name="remedyCancelation" id="remedyCancelation">
                        <option disc='' value="1">-select a reason -</option>
                         <?php foreach($remedy_replacements as $remedy_replacement):?>
						 <option value="<?php echo $remedy_replacement['reason_id']?>"><?php echo $remedy_replacement['description'];?></option>
                        <?php endforeach;?>
                     </select>
                    </div>
                </div>
                
            </div>
            <?php } ?>
		  <!---- stop --->
		  
		  <div class="form-group">
			<label for="inputEmail3" class="col-sm-4 control-label">you may attach document to support your case :  </label>
			<div class="col-sm-8">
			<label class="btn btn-default btn-file">
				<input type="file" name="attachment" id="attachment">
			</label>
			</div> 
			
		  </div>
		  
		  
		 <div class="form-group">
			<div class="col-sm-offset-4 col-sm-8">
			  <button type="submit" class="btn btn-success " value="1">Submit</button>
			  
			</div>
		  </div>
	
	
	</div>
	
    <input type="hidden" name="order_product_id" value="<?php echo $order_product_id;?>" />
    <input type="hidden" name="order_id" value="<?php echo $order_id;?>" />
    <input type="hidden" name="key" value="<?php echo $key;?>" />
	
	</div>
  </div>

</div>

</form>
</section>

<script>
	$(document).ready(function(){
	$("#remedyDiscount").on('change',function(){
		if(parseInt($("#remedyDiscount").children('option:selected').attr('disc'))!=0)
		{
			$("#discount").css('display','block');
			
			$("#claim_amount_org").val((<?php echo $amount?>-(( <?php echo $amount?>*parseInt($("#remedyDiscount").children('option:selected').attr('disc')))/100).toFixed(2)).toFixed(2));
			$("#claim_amount_clone").val((<?php echo $amount?>-(( <?php echo $amount?>*parseInt($("#remedyDiscount").children('option:selected').attr('disc')))/100)).toFixed(2));
			$("#discount .totle-value").text("$"+parseInt((<?php echo $amount?>*parseInt($("#remedyDiscount").children('option:selected').attr('disc')))/100).toFixed(2));
		}
	});
	$("#remedy").on('change',function(){
		$("#claim_amount_clone").remove();
		$("#claim_amount_org").attr('disabled','disabled');
		
		if($(this).val()=='Discount')
		{
			$("#remedy_discount").css('display','inline');
			$("#remedy_replacement").css('display','none');
			$("#remedy_cancelation").css('display','none');
			$("#claim_amount_org").before('<input type="hidden" name="claim_amount" id="claim_amount_clone" value="'+$("#claim_amount_org").val()+'"/>');
		}
		else if($(this).val()=='Replacement')
		{
			$("#discount").css('display','none');
			$("#discount .totle-value").text('');
			$("#claim_amount_org").val(parseFloat(<?php echo $amount?>).toFixed(2));
			$("#remedy_discount").css('display','none');
			$("#remedy_replacement").css('display','inline');
			$("#remedy_cancelation").css('display','none');
			$("#claim_amount_org").before('<input type="hidden" name="claim_amount" id="claim_amount_clone" value="'+$("#claim_amount_org").val()+'"/>');
		}
		else if($(this).val()=='Cancellation')
		{
			$("#discount").css('display','none');
			$("#discount .totle-value").text('');
			$("#claim_amount_org").val('0');
			$("#remedy_discount").css('display','none');
			$("#remedy_replacement").css('display','none');
			$("#remedy_cancelation").css('display','inline');
			$("#claim_amount_org").before('<input type="hidden" name="claim_amount" id="claim_amount_clone" value="'+$("#claim_amount_org").val()+'"/>');
		}
		else
		{
			$("#claim_amount_clone").remove();
			$("#claim_amount_org").removeAttr('disabled');
			$("#discount").css('display','none');
			$("#discount .totle-value").text('');
			$("#claim_amount_org").val('0');
			$("#remedy_discount").css('display','none');
			$("#remedy_replacement").css('display','none');
			$("#remedy_cancelation").css('display','none');
		}
		
	});
	$("#form-despute_order").validate({
		 
		 rules: {
            despute_reason: "required",
			claim_amount:{required:true,number:true,max:<?php echo $amount?>},
			despute_desc: "required"
			
        },
        // Specify the validation error messages
        messages: {
            despute_reason: "* Please enter despute reason",
			claim_amount: {required:"* Please enter amount",email:"* Please enter valid amount",max:"* Amount should be less than or equal to total price"},
			despute_desc: "* Please enter despute description"
			
        },
        
        submitHandler: function(form) {
            form.submit();
        }
		
	});
});
</script>
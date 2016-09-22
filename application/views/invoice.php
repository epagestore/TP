<?php include("inner_menu.php");?>
<link rel="stylesheet" href="<?php echo base_url();?>css/datepiker/default.css" type="text/css">
<style>
.data-line {
	width: 14.2%;
	float: left;
	padding-left: 10px;
	text-align: left;
}
.Zebra_DatePicker {
	top:56% !important;
	left:63% !important;
}
</style>
<script type="text/javascript" src="<?php echo base_url();?>js/datepiker/zebra_datepicker.js"></script>

<div class="seperator">
</div>
<section class="container">
<div class="row">
<div class="col-sm-12 col-md-12">
	<div class="box box-warning box-solid">
       <div class="box-header">
        <h3 class="box-title">Create a new Invoice</h3>              
              <!-- /.box-tools -->
       </div>
            <!-- /.box-header -->
			
		<form method="post" id="form-invoice">
        <div class="box-body" style="display: block;">
		
		<div class="row block">             
			<?php if(validation_errors()){?>
			 <div class="col-md-12">
				<ul><?php echo validation_errors(); ?></ul>
			 </div>
			<?php } ?>
              <div class="col-md-6 ">			  
			  <h4 class="text-orange">Your Contact Information</h4>
			  <?php if($personal_details['customer_phone']){ ?>
			  <p><strong>Phone:</strong><?php echo $personal_details['customer_phone']; ?></p>
			  <?php } ?>
			  <p><strong>Email:</strong><?php echo $personal_details['email']; ?> </p>
			  
			  <h4 class="text-orange">Send to</h4>	
			  <div class="form-group bottom-margin ">
				<label class="col-sm-5 control-label" for="formGroupInputLarge">Recipient's email address</label>
				<div class="col-sm-7">
				 <input class="form-control" type="text" id="formGroupInputLarge" placeholder="email" name="send_to">
				</div>
			  </div>
			  </div>
			  <div class="col-md-6">
			  <h4 class="text-orange">Your Invoice Information</h4>
			  <div class="form-group bottom-margin row ">
				<label class="col-sm-4 control-label" for="formGroupInputLarge">Invoice Date</label>
				<div class="col-sm-8">
				  <input class="form-control" type="text" id="formGroupInputLarge" placeholder="29-feb-2016" value="<?php echo date('d-m-Y');?>">
				   
				</div>
			  </div>
			  <div class="form-group bottom-margin row ">
				<label class="col-sm-4 control-label" for="formGroupInputLarge">Payment Teams</label>
				<div class="col-sm-8">
				  <select name="pay_terms" class="form-control">
							<option value="1"> Due on receipt </option>
				 </select>
				
				</div>
			  </div>
			  <div class="form-group bottom-margin row ">
				<label class="col-sm-4 control-label" for="formGroupInputLarge">Due Date</label>
				<div class="col-sm-8">
				    <input name="due_date" id="datepicker-example2" class="button.Zebra_DatePicker_Icon form-control" placeholder="Select Date"/>
				</div>
			  </div>
			 
			  
			  </div>
			  
			</div>  
			  
		<div class="row bottom-margin block" id="invoice_items_box">
		<h4 class="text-orange">Product/Services Detail</h4>
		<div class="col-sm-12 drop_list_slect">
			<div class="row bottom-margin">
			<div class="form-group ">
				
				<div class="col-sm-3">
					<label class="control-label" for="formGroupInputLarge">Iteam Name/Id</label>
				  <input name="item_name[]" class="form-control" type="text" id="formGroupInputLarge" placeholder="Iteam Name/Id">
				</div>
				<div class="col-sm-2">
					<label class="control-label" for="formGroupInputLarge">Quantity</label>
				  <input onchange="qty_change($(this));" name="qty[]" class="qty form-control" type="text" placeholder="Quantity"/>
				</div>
				<div class="col-sm-3">
					<label class="control-label" for="formGroupInputLarge">Unit Price (<?php echo $currency_symbol;?>)</label>
					<input  onchange="unit_price_change($(this));" name="unit_price[]" class="unit_price form-control" type="text"  placeholder="Unit Price"/>
					
				</div>
				<div class="col-sm-2">
					<label class="control-label" for="formGroupInputLarge">Tax (%)</label>
				   <input onchange="add_tax($(this));" name="tax[]" class="tax form-control" type="text" placeholder="Tax %" />
				</div>
				<div class="col-sm-2 amt">
				<label class="control-label" for="formGroupInputLarge"></label>
				  <div class="amonut_boxz" style="margin-top:10px;"> <span class="amonut_boxz_name"> Amount (<?php echo $currency_symbol;?>): </span>
                    <strong><label class="amount">00.00 </label></strong>
					<input type="hidden" name="total_product_amount[]"  />
                   </div>
				</div>
				
				
			  </div>
			
			</div>
			<div class="row bottom-margin">

				<div class="col-sm-11">
				<textarea name="disc[]" placeholder="Description (optional)" class="form-control" rows="3"></textarea>
				</div>
				<div class="col-sm-1">
				<span class="addicon">
					<a onclick="add_invoice_item($(this));" href="javascript:void(0);" class="add_item"> 
						<i class="fa fa-plus-circle"></i> 
					</a> 
				</span>
			</div>
             </div>			 
			
		</div>
		
			
		</div><!--- block  ends-->
		<div class="row block bottom-margin">
			<h4 class="text-orange">Summary</h4>
			  
			  <div class="form-group ">
				
				<div class="col-sm-2">
					<label class="control-label" for="formGroupInputLarge">Subtotal(<?php echo $currency_symbol;?>)</label>
				<!--  <input class="form-control" type="text" id="formGroupInputLarge" placeholder="$0"> -->
				  <label class="form-control bg-sky text-center" for="formGroupInputLarge"><span><?php echo $currency_symbol;?></span><span id="pre-discount"> 00.00</span></label>
				   
				</div>
				<div class="col-sm-4">
					 <div class="col-sm-5">
				  <label class="control-label" for="formGroupInputLarge">Discount(%)</label>
					<input class="form-control text-center" type="text" name="discount" id="discount" placeholder="%">
				  </div>
				  <div class="col-sm-7" style="padding-left:0px;">
				  <label class="control-label text-white" for="formGroupInputLarge">Discount(<?php echo $currency_symbol;?>)</label>
					<label class="form-control bg-sky text-center" for="formGroupInputLarge"><span><?php echo $currency_symbol;?></span><span id="disc_txt">0.00</span></label>
				  </div>
				</div>
				
				<div class="col-sm-3">
				<div class="col-sm-5">
				  <label class="control-label" for="formGroupInputLarge">Shipping(<?php echo $currency_symbol;?>)</label>
					<input type="text" id="shipping" name="shipping"  class="form-control text-center" placeholder="<?php echo $currency_symbol;?>"/>
				  </div>
				  <div class="col-sm-7" style="padding-left:0px;">
				  <label class="control-label text-white" for="formGroupInputLarge">Shipping(<?php echo $currency_symbol;?>)</label>
					<label class="form-control bg-sky text-center" for="formGroupInputLarge"><span><?php echo $currency_symbol;?></span><span id="ship_txt">0.00</span></label>
				  </div>
				   
				</div>
				
				
				<div class="col-sm-3">
				<label class="control-label" for="formGroupInputLarge">Total(<?php echo $currency_symbol;?>)</label>
				<input class="form-control" type="hidden" name="total" id="hid_total" placeholder="Total amount">
				  <label class="form-control bg-sky text-center" for="formGroupInputLarge"><span><?php echo $currency_symbol;?></span><span id="total">0.00</span></label>
				   
				</div>
				
			  </div>
		</div>	 
		<div class="row block bottom-margin">
		<h4 class="text-orange">Terms and condition</h4>
		<div class="form-group ">
		<div class="col-sm-6">
			<textarea class="form-control" rows="3" placeholder="Terms and condition" name="term_condi"></textarea>
			<span><small>characters :4000</small></span>   
		</div>
		<div class="col-sm-6">
			<textarea class="form-control" rows="3" placeholder="Note to recipient" name="note"></textarea>
				<span><small>characters :4000</small></span>   
		</div>
		</div>
		</div>
			
		<div class="row block bottom-margin">
		<h4 class="text-orange"> Memo<small>(your recipient don't see this)</small> </h4>
		<div class="col-sm-12">
		<textarea class="form-control" rows="3" placeholder="Memo to recipient " name="memo"></textarea>
			<span><small>characters :4000</small></span>   
		</div>
		</div>
		
		<div class="row button-grp bottom-margin ">
		
		<div class="col-sm-12">
		
		<button type="submit" name="send" class="btn btn-primary  " value="1"><i class="fa fa-send"></i> Send</button>  
		<button type="submit" name="save" class="btn btn-success  " value="1"><i class=" glyphicon glyphicon-list-alt"></i> Save Invoice
		</button>
		<button type="submit" name="close" class="btn btn-danger  "><i class="fa fa-close"></i> Close</button>
		
		
		
		
		</div>
		</div>

		
        </div>
		</form>
            <!-- /.box-body -->
       </div>
	   
	   </div>
	   
	<div id="drop_list_clone" style="display:none">
		<div class="col-sm-12 drop_list_slect">
			<div class="row bottom-margin">
			<div class="form-group ">
				
				<div class="col-sm-3">
					<label class="control-label" for="formGroupInputLarge">Iteam Name/Id</label>
				  <input name="item_name[]" class="form-control" type="text" id="formGroupInputLarge" placeholder="Iteam Name/Id">
				</div>
				<div class="col-sm-2">
					<label class="control-label" for="formGroupInputLarge">Quantity</label>
				  <input onchange="qty_change($(this));" name="qty[]" class="qty form-control" type="text" placeholder="Quantity"/>
				</div>
				<div class="col-sm-3">
					<label class="control-label" for="formGroupInputLarge">Unit Price (<?php echo $currency_symbol;?>)</label>
					<input  onchange="unit_price_change($(this));" name="unit_price[]" class="unit_price form-control" type="text"  placeholder="Unit Price"/>
					
				</div>
				<div class="col-sm-2">
					<label class="control-label" for="formGroupInputLarge">Tax (%)</label>
				   <input onchange="add_tax($(this));" name="tax[]" class="tax form-control" type="text" placeholder="Tax %" />
				</div>
				<div class="col-sm-2 amt">
				<label class="control-label" for="formGroupInputLarge"></label>
				  <div class="amonut_boxz" style="margin-top:10px;"> <span class="amonut_boxz_name"> Amount (<?php echo $currency_symbol;?>): </span>
                    <strong><label class="amount">00.00 </label></strong>
					<input type="hidden" name="total_product_amount[]"  />
                   </div>
				</div>
				
				
			  </div>
			
			</div>
			<div class="row bottom-margin">

				<div class="col-sm-11">
				<textarea name="disc[]" placeholder="Description (optional)" class="form-control" rows="3"></textarea>
				</div>
				<div class="col-sm-1">
			<span class="addicon">
				<a onclick="add_invoice_item($(this));" href="javascript:void(0);" class="add_item"> 
					<i class="fa fa-plus-circle"></i> 
				</a> 
				<a onclick="remove_invoice_item($(this));" class="remove_item" href="javascript:void(0);">
					<i class="fa fa-minus-circle"></i>
				</a>
			</span>
			</div>
             </div>			 
			
		</div>
		
	</div>
	   
</div>
</div>
</section>	


<script>
function add_tax($this)
{
	$this.val($this.val().replace(/[^0-9\.]/g,''));
	tax=parseFloat($this.val());
	if(!tax)
	tax=0;
	amount=parseFloat($this.parents('.drop_list_slect').find(".qty").val())*parseFloat($this.parents('.drop_list_slect').find(".unit_price").val());
	//
	net=parseFloat(amount+((amount*tax)/100));
	
	$this.parents('.drop_list_slect').find(".amonut_boxz .amount").text(net);
	$this.parents('.drop_list_slect').find("input[name='total_product_amount[]']").val(net);
	
	calc_all();
}
function add_invoice_item($this)
{
	$("#invoice_items_box").append($("#drop_list_clone").html());
	$(".unit_price").autoNumeric({
			
		});
	$this.remove();
}
function remove_invoice_item($this)
{

	if($this.siblings('.add_item').length)
	{
		$this.parents('.drop_list_slect').siblings('.drop_list_slect').last().find('.col-sm-1 .addicon').append($this.siblings('.add_item'));
	}
	$this.parents('.drop_list_slect').remove();	
	calc_all();
	
}
function qty_change($this){
	 
	if($this.parents('.drop_list_slect').find(".unit_price").val()!='')
	{
		if($this.val().trim()=='' || $this.val()==0)
		$this.val('0');
		$this.parents('.drop_list_slect').find(".amount").text((parseFloat($this.val())*parseFloat($this.parents('.drop_list_slect').find(".unit_price").val())).toFixed(2));
		$this.val($this.val().replace(/[^0-9\.]/g,''));
	}
	calc_all();
}
function calc_all()
{
		$("#discount").val($("#discount").val().replace(/[^0-9\.]/g,''));	
		$(".tax").each(function(){
			if($(this).val()!='')
			{tax=parseFloat($(this).val());		
		
			amount=parseFloat($(this).parents('.drop_list_slect').find(".qty").val())*parseFloat($(this).parents('.drop_list_slect').find(".unit_price").val());
			
			net=amount+((amount*tax)/100);
			$(this).parents('.drop_list_slect').find(".amonut_boxz .amount").text(net.toFixed(2));
			}else{
				$(this).val(0);
			}
		});
		var amt=0;
		$(".amount").each(function(){
			if($(this).text()=='NaN')
			{
				$(this).text('00.00');
			}	
			amt+=parseFloat($(this).text());
		});
		//alert(amt);
		$("#pre-discount").text(amt);
		if($("#discount").val()=='')
		$("#discount").val('0');
		if($("#shipping").val()=='')
		$("#shipping").val('0');
		
		var disc=0;
		
		if($("#discount").val()!='0')
		disc=((amt/100)*parseFloat($("#discount").val())).toFixed(2);
	

		$("#total").text(amt - disc + parseFloat($("#shipping").val()) );
		$("#hid_total").val($("#total").text());
		$("#ship_txt").text($("#shipping").val());
		$("#disc_txt").text(disc);
}
function unit_price_change($this){
	
		
		if($this.parents('.drop_list_slect').find(".qty").val()=='')
		$this.parents('.drop_list_slect').find(".qty").val('1');
		if($this.val().trim()=='' || $this.val()==0)
		$this.val('1');
		$this.parents('.drop_list_slect').find(".amount").text( (parseFloat($this.parents('.drop_list_slect').find(".qty").val())*parseFloat($this.val().replace(",",""))).toFixed(2));
		$this.parents('.drop_list_slect').find("input[name='total_product_amount[]']").val( (parseFloat($this.parents('.drop_list_slect').find(".qty").val())*parseFloat($this.val().replace(",",""))).toFixed(2));
		
		calc_all();
		
	}
$(document).ready(function() {
	$('#datepicker-example2').Zebra_DatePicker({
        direction: 1    // boolean true would've made the date picker future only
                        // but starting from today, rather than tomorrow
    });
	$("#discount").change(function(){
		calc_all();
		
	});
	$("#shipping").change(function(){
		calc_all();
		
	});
	
});
</script>




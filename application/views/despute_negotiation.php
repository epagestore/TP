<!-- working negotiation despute -->
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/jquery.countdown.css"> 
<style>
.dtlspn{
	color:#000;
	float: right;
width: 55%;
}
.pop-box-name input {
	margin-left: auto !important;
width: auto;
}
</style>
<script src="<?php echo base_url();?>js/jquery.plugin.min.js"></script>
<script src="<?php echo base_url();?>js/jquery.countdown.min.js"></script>
<?php //echo form_open('','enctype="multipart/form-data" name="despute_order" id="form-despute_order"')?>
<?php include("inner_menu.php");?>
<div class="seperator">
</div>
<section class="container">
<div class="row">
	<div class="col-md-12">
	<h3 ></h3>
	<div class="step-process">
	<div class="row steps">
	<div class="col-md-3 col-sm-6 col-xs-12 main-stage ">
		<div class="stage">
		<span class="stageno pull-left">1</span>
		<span class="sname pull-left">IDENTIFY THE ISSUE</span>
		</diV>
		
	</div>
	<div class="col-md-3 col-sm-6 col-xs-12 main-stage-active ">
		<div class="stage">
		<span class="stageno pull-left">2</span>
		<span class="sname pull-left">NEGOTIATIONS</span>
		</diV>
		
	</div>
	<div class="col-md-3 col-sm-6 col-xs-12 main-stage ">
		<div class="stage">
		<span class="stageno pull-left">3</span>
		<span class="sname pull-left">FINAL OFFERS/ EVIDANCE</span>
		</diV>
		
	</div>
	<div class="col-md-3 col-sm-6 col-xs-12 main-stage ">
		<div class="stage">
		<span class="stageno pull-left">4</span>
		<span class="sname pull-left">RESOLUTION</span>
		</diV>
		
	</div>
	</div>
  <!-- Tab panes -->
 
   
    <div class="tab-pane">
	<h4 class="text-sky">Step 2 - NEGOTIATIONS</h4>
	<div class="row">
	<div class="col-sm-4 bg-box" id="dispute_html">
		<div class="form-group row">
			<span class="col-sm-6 control-label">Time Left : </span>
			<div class="col-sm-12">
			  <span>
			  <div id="counter" style="float:left;width:98%;margin:7px; background:#fff; color:#0082c8; padding:10px; border:1px solid #0082c8;"></div>
			  <div id="year" style="float:left;width:98%;margin:7px; background:#fff; color:#0082c8;  "></div>
			  <script type="text/javascript">
				$("#counter").countdown({
				  until: new Date('<?php echo date("Y/m/d H:i:s",strtotime($future_datetime));?>'),
					serverSync: new Date('<?php echo date("Y/m/d H:i:s",strtotime($now_datetime));?>'), 
					expiryText: "<div class='over'>Time over  : <a href='<?php echo base_url();?>index.php/despute/closeDespute/<?php echo $despute['despute_id']?>'>Reload</a></div>" 
					});   
				</script>

			  </span>
			</div>
		  </div>
		  <?php //print_r($despute);?>
		  <div class="form-group row">
			<label for="inputEmail3" class="col-sm-6 control-label">Dispute date :</label>
			<div class="col-sm-6">
			  <span><?php echo date('M jS Y',strtotime($despute['despute_date_added']));?></span>
			</div>
		  </div>
		 <div class="form-group row">
			<label for="inputEmail3" class="col-sm-6 control-label">Dispute order :</label>
			<div class="col-sm-6">
			  <span><?php echo $despute['name']?></span>
			</div>
		  </div>
		  
		 <div class="form-group row">
			<label for="inputEmail3" class="col-sm-6 control-label">Reason for dispute :</label>
			<div class="col-sm-6">
			  <span><?php echo $despute['despute_reason'];?></span>
			</div>
		  </div>
		  <div class="form-group row">
		  <?php if(isset($payer)) echo "<label for='inputEmail3' class='col-sm-6 control-label'>Payee :</label> ".'<div class="col-sm-6"><span>'.$despute['payee_name'].'</div></span>'; else echo "<label for='inputEmail3' class='col-sm-6 control-label'>Payer :</label>".'<div class="col-sm-6"><span>'.$despute['payer_name'].'</div></span>';?>
			
		  </div>
		   <div class="form-group row">
			<label for="inputEmail3" class="col-sm-6 control-label">Total Amount Dispute: </label>
			<div class="col-sm-6">
			<?php if($despute['milestone_id'] != 0){?>	
			  <span><?php echo $currency_symbol." ".sprintf ("%.2f", ($despute['milestone_amount'])*$value); ?></span>
			<?php }else{?>
			  <span><?php echo $currency_symbol." ".sprintf ("%.2f", ($despute['total_despute_amount']!=''?$despute['total_despute_amount']:$despute['total'])*$value); ?></span>
			<?php }?>
			</div>
		  </div>
		  <hr>
		 	   
		<div class="row">
		<?php if((isset($own_despute) && isset($payer)) || (isset($payer) && $despute['despute_status']=='1')){ ?>
				
				<div class="col-sm-6 text-center">
				<span> Buyer(you) </span><br>
				<?php if($despute['remedy']=='Discount'){ echo $despute['discount']."% ".$despute['remedy']." to now pay";}?>  <?php if($despute['remedy']=='Replacement'){ echo " to Replace the Product and pay";}?><?php if($despute['remedy']=='Cancellation'){ echo " to Cancel the Order/Product and receive";}?> (<?php echo $currency_symbol;?><?php echo sprintf ("%.2f", $despute['payer_amount']*$value); ?>)
			  
				<?php echo form_open('','id="form-negotiation"')?>
				<?php if($despute['pre_delivery']=='0'){?>
					 <br />Change(<?php echo $currency_symbol;?>) : <input type="text" value="<?php echo sprintf ("%.2f", $despute['payer_amount']*$value); ?>" name="pay_amount" style="width:94px" />
					<input type="submit" value="ok" name="submit" class="sub-btn1" />
				<?php }else if(isset($payee_response) && $payee_response && ($despute['payee_amount']!=$despute['total'])){?>
				<div class="js__p_start">
					 <br /><input type="hidden" id="pre_pay_amount" value="<?php echo $currency_symbol;?><?php echo sprintf ("%.2f", $despute['payee_amount']*$value); ?>" name="pay_amount" style="width:94px" />
					<input type="button" value="Accept Payee Offer" name="button" onclick="acceptOffer();" class="sub-btn1" />
					</div>
				<?php }?>
				</form>
				</div>
			   
				<div class="col-sm-6 text-center">
				<span>
				Seller(Want to Receive) <br> <span class="pye_amount_txt"><?php echo $currency_symbol;?><?php echo sprintf ("%.2f", $despute['payee_amount']*$value); ?></span>
				<input type="hidden" name="pye_amt" id="pye_amt" value="<?php echo $currency_symbol;?><?php echo sprintf ("%.2f", $despute['payee_amount']*$value); ?>" />
				</span>
				</div>
   
		<?php } else if((isset($payer) && $despute['despute_status']=='1')){?>
	<?php echo form_open('','id="form-negotiation"')?>
			<div class="col-sm-6 text-center">
			<span> Buyer(you) <br>(<?php echo $despute['remedy'];?>)
			</span>
			<input type="text" value="<?php echo $currency_symbol;?><?php echo sprintf ("%.2f", $despute['payer_amount']*$value); ?>" name="pay_amount" style="width:95px" />
              <input type="submit" value="ok" name="submit" />
			  </span>
            </div>
            <div class="col-sm-6 text-center">
				<span>
					Payee(Want to Receive)<br> 
						<span class="pye_amount_txt"><?php echo sprintf ("%.2f", $despute['payee_amount']*$value); ?></span>
						<input type="hidden" name="pye_amt" id="pye_amt" value="<?php echo $despute['payee_amount'];?>" />
				</span>
			</div>
         </form>
	<?php } else if((isset($own_despute) && isset($payee)) || (isset($payee)&& $despute['despute_status']=='1')){?>
   
        <div class="col-sm-6 text-center">
		<span> Buyer(you) <br><span class="pyr_amount_txt"><?php echo $currency_symbol;?><?php echo sprintf ("%.2f", $despute['payer_amount']*$value); ?></span>
         <input type="hidden" name="pyr_amt" id="pyr_amt" value="<?php echo $currency_symbol;?><?php echo sprintf ("%.2f", $despute['payer_amount']*$value); ?>" />
		 </span>
        </div>
        <div class="col-sm-6 text-center">
			<span>
			Seller(you) <?php if($despute['pre_delivery']=='0'){?>want to receive (<?php echo sprintf ("%.2f", $despute['payee_amount']*$value); ?>)<?php }?>
			</span>
			<?php echo form_open('','id="form-negotiation"')?>
			<?php if($despute['pre_delivery']=='0'){?>
			<br />Change(<?php echo $currency_symbol;?>):<input type="text" value="<?php echo sprintf ("%.2f", $despute['payee_amount']*$value); ?>" name="receive_amount" style="width:94px" />
			<?php }else{?>
			 <br />Create Offer : <br/><?php echo $currency_symbol;?><input type="text" value="<?php echo sprintf ("%.2f", $despute['payee_amount']*$value); ?>" name="receive_amount" style="width:94px" />
			<?php }?>
			<input type="submit" value="ok" name="submit" />
			</form>
        </div>
       
	<?php }else if(isset($payee)&& $despute['despute_status']=='1'){?>
	<?php echo form_open('','id="form-negotiation"')?>
	    <div class="col-sm-6 text-center">
		<span>
        Seller
        Want to Pay <br><span class="pye_amount_txt"><?php echo sprintf ("%.2f", $despute['payer_amount']*$value); ?></span>
         <input type="hidden" name="pye_amt" id="pye_amt" value="<?php echo $currency_symbol;?><?php echo sprintf ("%.2f", $despute['payer_amount']*$value); ?>" />
        </span>
		</div>
        <div class="col-sm-6 text-center">
		<span>
        Seller(you) want to receive 
		</span><br>
		<input type="text" value="<?php echo sprintf ("%.2f", $despute['payee_amount']*$value); ?>" name="receive_amount" style="width:95px" />
       
        <input type="submit" value="ok" name="submit" class="btn btn-primary btn-lg" />
        </div>
		</form>   
  
		<?php }?>
		</div>
			
	
	</div>
	<div class="col-sm-8" >
	<div class="box box-warning direct-chat direct-chat-warning">
    <div class="box-header with-border">
	 <h3 class="box-title">Direct Chat</h3>
	 </div>
		<div id="messag-body" style="max-height:350px;">
		<?php $payee_response=0; foreach($messages as $message):?>
			
			<?php if($message['payer_id']==$message['sender_id']){?>
		  
				
				<div class="blog-first-client box-body">
					<div class="blog-chat">
					<div class="client-details direct-chat-info clearfix ">
					<div class="blog-imge"><img src="<?php echo base_url().$message['photo']?>" class="direct-chat-img pull-right" /></div>
					<div class="client-name direct-chat-name pull-right"><?php echo $message['sender_name']?></div>
					<div class="client-date direct-chat-timestamp pull-left"><?php echo date('d M Y h:i:s A',strtotime($message['added_on']))?></div>
					</div>
					<div class="client-desptn direct-chat-text pull-right"><label><?php echo $message['message_body']?> </label></div>
					</div>
				</div>
				
				
				
			<?php }else{ $payee_response=1; ?>
				
				<div class="blog-first-client box-body">
					<div class="blog-chat">
					<div class="client-details direct-chat-info clearfix ">
					<div class="blog-imge "><img src="<?php echo base_url().$message['photo']?>" class="direct-chat-img" /></div>
					<div class="client-name direct-chat-name pull-left"><?php echo $message['sender_name']?></div>
					<div class="client-date direct-chat-timestamp pull-right"><?php echo date('d M Y h:i:s A',strtotime($message['added_on']))?></div>
					</div>
					<div class="client-desptn direct-chat-text"><label><?php echo $message['message_body']?> </label></div>
					</div>
				</div>
		<?php }?>
		<?php endforeach;?>
		</div>
		
<div class="blog-wrap">
<div class="blog-imge"></div>
  
 
   
<div class="replay-btn input-group">
				  <input type="text" class="form-control" placeholder="Type Message ..." name="reply_message" id="reply_message">
				  <span class="input-group-btn">
					<button class="btn btn-warning btn-flat" type="button" id="reply_button">Send</button>
				  </span>
</div>

</div>



</div>
<?php if(((isset($own_despute) && isset($payer)) || (isset($payer) && $despute['despute_status']=='1')) && $despute['pre_delivery']=='1'){?>
   		 <?php if($payee_response==0){?>
        
		<input type="button" value="No response from seller -go to stage 4 Resolution" name="arbitration" id="arbitration1" class="sub-btn1 pull-right btn btn-primary bottom-margin" data-toggle="modal" data-target="#myModal"/>
        <?php }else{?>
       <input type="button" value="Response ok" name="arbitration" id="arbitration1" class="sub-btn1 pull-right btn btn-primary bottom-margin" data-toggle="modal" data-target="#myModal" />
		
    <?php }}?>
<div class="row">
	<div class="col-sm-12">
		<div class="p_body js__p_body js__fadeout"></div>
		
		<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog" role="document" style="width:500px;">
			<div class="modal-content">
					<div class="modal-header" id="popup_first" style="display:block;">
              
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				   <?php if(!$payee_response){?>
                       <h3 class="modal-header">No response from seller ?
					  <br/>
							Go to stage 4- Resolution
					  </h3>
                    <?php }else if($despute['payee_amount']==$despute['total']){?>
                   
                    <?php }else if($despute['payee_amount']!=$despute['total']){?>
                   <div class="">
				  <h3 class="modal-header">Offer from seller</h3> 
				   
				  <span> Old Price : <strong> <?php echo $currency_symbol;?><?php echo sprintf ("%.2f", $despute['total']*$value); ?></strong></span><br /> <span>New Price : <strong> <?php echo $currency_symbol;?><?php echo sprintf ("%.2f", $despute['payee_amount']*$value); ?></strong></span>
				   </div>
                    <?php }?>
                  <div class="subcribr_txt_bar pull-right">
                    <div class="pop-text">
                     
                    </div>
                     <?php if(!$payee_response){?>
					
                    <input class="btn btn-primary btn" type="button"  name="yes" onclick="arbit();" value="Yes"/>
                    <input class="btn-danger btn" type="button" data-dismiss="modal"  name="no" value="No"/>
					
                     <?php }else if($despute['payee_amount']==$despute['total']){?>
					  <h3 class="modal-header">Offer from seller</h3> 
					 Click <input class="btn btn-primary " type="button"  name="yes" onclick="acceptOffer_ok();" value="Yes"/>to accept and resolve issue or <div class="btn btn-danger"  name="no" onclick="acceptOffer();" >No</div> to go to Resolution  
					
                	<?php }else if($despute['payee_amount']!=$despute['total']){?>
     				<!--<input class="btn btn-primary" type="button"  name="yes" onclick="acceptOffer();" value="Click here to accept new offer and resolve issue"/> -->
     				Click <input class="btn btn-primary" type="button"  name="yes" onclick="acceptOffer_ok();" value="Yes"/>to accept and resolve issue or <div class="btn btn-danger"  name="no" onclick="acceptOffer();" >No</div> to go to Resolution  
 					<?php }?>
                  </div>
                  
                  <div class="subcribe-offer"></div>
               
              </div>
               <div class="modal-header" id="popup_second" style="display:none">
			   <button type="button" class="close" data-dismiss="modal">&times;</button>
				<div class="modal-header">
                <h4>You have chosen NO …Do you want to go ahead ?</h4>
				</div>
					<div class="pull-right">
                	<?php if($despute['payee_amount']==$despute['total']){?>
                    <div id="popup_arbitration_ok">
                      <input class="btn btn-primary" type="button"  name="yes" onclick="arbitration_ok();" value="Yes"/>
                   <button type="button" class="btn btn-danger" onclick="popup_cancel()" data-dismiss="modal">No</button>
                   <!--<input class="btn btn-danger" type="button" onclick="popup_cancel()"  name="no" value="No"/>-->
                    </div>
                    <div id="popup_acceptOffer_ok">
                       <input class="btn btn-primary" type="button"  name="yes" onclick="acceptOffer_ok();" value="Yes"/>
					   <button type="button" class="btn btn-danger" onclick="popup_cancel()" data-dismiss="modal">No</button>
					   
                    </div>
                	<?php }else if($despute['payee_amount']!=$despute['total']){ ?>
     				 <input class="btn btn-primary" type="button"  name="yes" onclick="arbitration_ok();" value="Yes"/>
                   <button type="button" class="btn btn-danger" onclick="popup_cancel()" data-dismiss="modal">No</button>
 					<?php } ?>
					</div>
               </div>
			  
			</div>
		  </div>
		</div>

        
	</div>
</div>	
	</div>
	
	</div>
	
	
	
	
	
	</div>
 
</section>


<script>



function acceptOffer(){
	$("#popup_first").css('display','none');
	$("#popup_second").css('display','block');
	$("#popup_acceptOffer_ok").css('display','block');
	$("#popup_arbitration_ok").css('display','none');
}
function arbit(){
	
	$("#popup_first").css('display','none');
	$("#popup_second").css('display','block');
	$("#popup_acceptOffer_ok").css('display','none');
	$("#popup_arbitration_ok").css('display','block');
}
function arbitration_ok(){
	
		window.location.href="<?php echo base_url();?>index.php/despute/closeDespute/<?php echo $despute['despute_id']?>";
}
function acceptOffer_ok(){
	window.location.href="<?php echo base_url();?>index.php/despute/acceptOffer/<?php echo $despute['despute_id']?>";
	
}
function popup_cancel(){
	
		$("#popup_first").css('display','block');
		$("#popup_second").css('display','none');
}

$(document).ready(function() {
	$("input[name='receive_amount']").change(function(){
		$(this).val($(this).val().replace(',',''));
	})
	
	$("#form-negotiation").validate({
		 
		 rules: {
            pay_amount: {required:true,number:true,range:[0.00,<?php echo sprintf ("%.2f", $despute['total']*$value);?>]},
			receive_amount:{required:true,number:true,range:[0.00,<?php echo sprintf ("%.2f", $despute['total']*$value);?>]}
        },
        // Specify the validation error messages
        messages: {
			pay_amount: {required:"* Please enter amount",email:"* Please enter valid amount",range:"* Amount should be greater than or equal to total price"},
			receive_amount: {required:"* Please enter amount",email:"* Please enter valid amount",range:"* Amount should be less than or equal to total price"},			
        },
        
        submitHandler: function(form) {
			if(confirm('Are you sure you want ot make this change!'))
            form.submit();
        }
		
	});
	
	
	var timer2, delay2 = 2000;
	var chk2=0;
	timer2 = setInterval(function(){
		
		if(chk2==0){
			chk2=1;
			
	   $.ajax({
				url: '<?php echo base_url();?>index.php/despute/loadMessage/'+<?php echo $despute['despute_id']?>,
				dataType: 'json',
				success: function(json) {
					
						if(json.result.length>$("#messag-body").children().length)
						{
							
								$("#messag-body").html('');
								for(i=0;i<json.result.length;++i)
								{
									
									var message =json.result[i];
									if(message.payer_id==message.sender_id){
										html='<div class="blog-first-client box-body">';
										html+='<div class="blog-chat"><div class="client-details direct-chat-info clearfix"><div class="blog-imge "><img src="<?php echo base_url();?>'+message.photo+'" class="direct-chat-img pull-right"/></div>';
										html+='<div class="client-name direct-chat-name pull-right">'+message.sender_name+'</div>';
										html+='<div class="client-date direct-chat-timestamp pull-left">'+message.added_on+'</div>';
										html+='</div>';
										html+='<div class="client-desptn direct-chat-text pull-right"><label>'+message.message_body+'</label></div>';
										html+='</div></div>';	
									 }else{
										html='<div class="blog-first-client box-body">';
										html+='<div class="blog-chat"><div class="client-details direct-chat-info clearfix"><div class="blog-imge "><img src="<?php echo base_url();?>'+message.photo+'" class="direct-chat-img"/></div>';
										html+='<div class="client-name direct-chat-name pull-left">'+message.sender_name+'</div>';
										html+='<div class="client-date direct-chat-timestamp pull-right">'+message.added_on+'</div>';
										html+='</div>';
										html+='<div class="client-desptn direct-chat-text"><label>'+message.message_body+'</label></div>';
										html+='</div></div>';											   
										  
									 }
									 
								$("#messag-body").append(html);
								if(parseFloat("<?php echo $despute['payee_amount']?>")!=parseFloat(json.payee_amount))
								location.reload();
								}
								
								
								$("#reply_message").val('');
								$("#reply_message").removeAttr('disabled');
								$("#reply_button").removeAttr('disabled');
			
						}
						if(json.dispute_status!="1")
								{
									location.reload();
								}
						<?php if(isset($payee)){?>
						
						if($("#pyr_amt").val()!=json.payer_amount)
						{
							$("#pyr_amt").val(json.payer_amount);
							$(".pyr_amount_txt").text('<?php echo $currency_symbol;?> '+json.payer_amount);
							//alert(json.payer_amount);
						}
						<?php }if(isset($payer)){?>
						//alert(json.payee_amount);
						if($("#pye_amt").val()!=json.payee_amount)
						{
							$("#pye_amt").val(json.payee_amount);
							$("#pre_pay_amount").val(json.payee_amount);
							
							var val=parseInt(json.payee_amount);
							val=parseFloat(val*<?php echo $value; ?>).toFixed(2);
							$(".pye_amount_txt").text('<?php echo $currency_symbol;?> '+ val);
							//alert(json.payee_amount);
						}
						<?php }?>
					chk2=0;
				}
			}).done(function() {
					$("img").on("error",function(){
						$(this).attr("src",'<?php echo base_url(); ?>img/Team/user_placeholder.png')
					});
				});
		}
				
	}, delay2);
	
	
	
	
	
$("#arbitration").click(function() {
	<?php if(!$payee_response){?>
	
		if(confirm('Are you sure you want to take this option  '))
		window.location.href="'<?php echo base_url();?>index.php/despute/closeDespute/<?php echo $despute['despute_id']?>";
	
	<?php }else if($despute['payee_amount']==$despute['total']){?>
	if(confirm('Click here to accept response and resolve  issue  Not happy with response go to stage for Resolution'))
	{
		if(confirm('Are you sure you want to take this option  '))
		window.location.href="'<?php echo base_url();?>index.php/despute/closeDespute/<?php echo $despute['despute_id']?>";
	}
	<?php }else if($despute['payee_amount']!=$despute['total']){?>	
	if(confirm('Offer from seller old price -> <?php echo sprintf ("%.2f", $despute['payee_amount']*$value); ?> New Price -><?php echo sprintf ("%.2f", $despute['payee_amount']*$value); ?>'))
	{
		if(confirm('Are you sure you want to take this option  '))
		window.location.href="'<?php echo base_url();?>index.php/despute/closeDespute/<?php echo $despute['despute_id']?>";
	}
	<?php }?>
	
});
	

	
$(document).ready(function(){

$("#messag-body").scrollTop($('#messag-body')[0].scrollHeight);
$("#reply_message").focus().keypress( function(e) {
						if( e.keyCode == 13 || e.keyCode == 27 ) $("#reply_button").trigger('click');
					});
});
 $("#reply_button").click(function() {
	var message=$("#reply_message").val();
	if(message.length<=0)
		return false;
	 $("#reply_message").attr('disabled','disabled');
	 $("#reply_button").attr('disabled','disabled');
	
	 $.ajax({
		url: '<?php echo base_url();?>index.php/despute/sendReply/<?php echo $despute['despute_id']?>/'+encodeURIComponent(message).replace(/[!'()]/g, escape).replace(/\*/g, "%2A").replace(/\%2F/g, "%5C"),
			dataType: 'json',
			success: function(json) 
			{
				$("#messag-body").html('');
				for(i=0;i<json.result.length;++i)
				{
					var message =json.result[i];
					if(message.payer_id==message.sender_id){
										html='<div class="blog-first-client box-body">';
										html+='<div class="blog-chat"><div class="client-details direct-chat-info clearfix"><div class="blog-imge "><img src="<?php echo base_url();?>'+message.photo+'" class="direct-chat-img pull-right"/></div>';
										html+='<div class="client-name direct-chat-name pull-right">'+message.sender_name+'</div>';
										html+='<div class="client-date direct-chat-timestamp pull-left">'+message.added_on+'</div>';
										html+='</div>';
										html+='<div class="client-desptn direct-chat-text pull-right"><label>'+message.message_body+'</label></div>';
										html+='</div></div>';	
									 }else{
										html='<div class="blog-first-client box-body">';
										html+='<div class="blog-chat"><div class="client-details direct-chat-info clearfix"><div class="blog-imge "><img src="<?php echo base_url();?>'+message.photo+'" class="direct-chat-img"/></div>';
										html+='<div class="client-name direct-chat-name pull-left">'+message.sender_name+'</div>';
										html+='<div class="client-date direct-chat-timestamp pull-right">'+message.added_on+'</div>';
										html+='</div>';
										html+='<div class="client-desptn direct-chat-text"><label>'+message.message_body+'</label></div>';
										html+='</div></div>';											   
										  
									 }
					 
				$("#messag-body").append(html);
				$("#messag-body").scrollTop($('#messag-body')[0].scrollHeight);
				}
				$("#reply_message").val('');
			 	$("#reply_message").removeAttr('disabled');
				$("#reply_button").removeAttr('disabled');
			}
		}).done(function() {
					$("img").on("error",function(){
						$(this).attr("src",'<?php echo base_url(); ?>img/Team/user_placeholder.png')
					});
				});
		return false;
 
 });
});
</script>
	
<?php include("inner_menu.php");?>
<div class="seperator">
</div>
<section class="container">
<div class="row">
	<div class="col-md-12">
	<h3 class="text-orange"> </h3>
	<div class="step-process">
		<div class="row steps bottom-margin">
	<div class="col-md-3 col-sm-6 col-xs-12 main-stage ">
		<div class="stage">
		<span class="stageno pull-left">1</span>
		<span class="sname pull-left">IDENTIFY THE ISSUE</span>
		</diV>
		
	</div>
	<div class="col-md-3 col-sm-6 col-xs-12 main-stage ">
		<div class="stage">
		<span class="stageno pull-left">2</span>
		<span class="sname pull-left">NEGOTIATIONS</span>
		</diV>
		
	</div>
	<div  <?php if((isset($despute_resolved) && $despute_resolved=='1')){?>class="col-md-3 col-sm-6 col-xs-12 main-stage-active "<?php }else{?>class="col-md-3 col-sm-6 col-xs-12 main-stage " <?php } ?>>
		<div class="stage">
		<span class="stageno pull-left">3</span>
		<span class="sname pull-left">FINAL OFFERS/EVIDENCE</span>
		</diV>
		
	</div>
	<div  <?php if(((isset($despute_resolved) && $despute_resolved=='2')) || (!isset($despute_resolved))){?>class="col-sm-3 main-stage-active "<?php }else{?>class="col-md-3 col-sm-6 col-xs-12 main-stage " <?php } ?>>
		<div class="stage">
		<span class="stageno pull-left">4</span>
		<span class="sname pull-left"><!--ARBITRATION-->RESOLUTION</span>
		</diV>
		
	</div>
	</div>
  <!-- Tab panes -->
 
   
    
    <div class="tab-pane">
	
	<div class="row">
	<div class="col-sm-4 col-xs-12 bg-box" id="dispute_html">
		
		  <?php //print_r($despute); ?>
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
			<label for="inputEmail3" class="col-sm-6 control-label">Reason for dispute:</label>
			<div class="col-sm-6">
			  <span><?php echo $despute['despute_reason'];?></span>
			</div>
		  </div>
		  <div class="form-group row">
			<?php if(isset($payer)) echo "<label for='inputEmail3' class='col-sm-6 control-label'>Payee :</label> ".'<div class="col-sm-6"><span>'.$despute['payee_name'].'</span></div>'; else echo "<label for='inputEmail3' class='col-sm-6 control-label'>Payer :</label> ".'<div class="col-sm-6"><span>'.$despute['payer_name'].'</span></div>';?>
		  </div>
		   <div class="form-group row ">
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
		  
		  <?php if((isset($own_despute) && isset($payer)) || (isset($payer) && $despute['despute_status']=='2') || (isset($payer) && isset($despute_resolved))){?>

		  <div class="row">
			  <div class="col-sm-6 text-center" >
					<span>Buyer(you)
					Want to pay <br> <?php //echo $currency_symbol;?><?php //echo sprintf("%.2f", (abs($despute['total']))*$value); ?> <?php echo $currency_symbol;?><?php echo sprintf("%.2f", (abs($despute['payer_amount']))*$value); ?></span> 
			  </div>
			   <div class="col-sm-6 text-center "style="border-left:1px solid #ddd;" >
					<span >Seller(Want to Receive) <br> <?php echo $currency_symbol;?><?php echo sprintf("%.2f", (abs($despute['payee_amount']))*$value); ?></span>
			   </div>
		  </div>
		  
		  <?php } else if((isset($own_despute) && isset($payee)) || (isset($payee)&& $despute['despute_status']=='2') || (isset($payee) && isset($despute_resolved))){?>
		  
		  <div class="row">
			  <div class="col-sm-6 text-center" >
					<span>Buyer(you)
					Want to pay <br><?php echo $currency_symbol;?><?php echo sprintf("%.2f", (abs($despute['payer_amount']))*$value); ?></span> 
			  </div>
			   <div class="col-sm-6 text-center "style="border-left:1px solid #ddd;" >
					<span >Seller(Want to Receive) <br> <?php echo $currency_symbol;?><?php echo sprintf("%.2f", (abs($despute['payee_amount']))*$value); ?></span>
			   </div>
		  </div>
		  
		  <?php } ?>

		  
			<div class="row">
			  <div class="col-sm-12">
				  <div class="result-bomt">
			<!--<strong>Result:</strong>$0.00 Received-->
			<?php if(isset($despute_resolved)){?>
				<?php if($despute_resolved=='1'){?>
					 <h4 class="text-center"><strong>Result: </strong>  <?php if(isset($payer)){?>Pay<?php }else{?>Receive<?php }?> <?php echo $currency_symbol;?><?php $despute['payer_amount']>$despute['payee_amount']?$despute['payer_amount']:$despute['payee_amount'];?>
					<?php echo sprintf("%.2f", (abs($despute['payer_amount']))*$value); ?>
					</h4>
					 <!--<h4 class="text-orange text-center">DISPUTE RESOLVED</h4>-->
					 <h4 class="text-orange text-center">DISPUTE CLOSED</h4>
					 <hr>
					<?php if(!isset($key_exist[0])){?>
					
							<?php echo form_open('')?>
							<?php if(isset($payer)){?>
						   <div class="payer-tble-detll">
						   
							<h4 class="text-sky text-center">Complete order:</h4>
							
							 <div class="form-group row">
								<label for="inputEmail3" class="col-sm-6 control-label">Payer Secrt Key : </label>
								<div class="col-sm-6">
								  <input type="text" name="payee_key" id="payee_key"  class="form-control" placeholder="Payer Secrt Key">
								</div>
							  </div>
							  <div class="form-group row">
								<label for="inputEmail3" class="col-sm-6 control-label">Your Secret Key : </label>
								<div class="col-sm-6">
								  <input type="text" name="payer_key" id="payer_key"  class="form-control"  placeholder="Your Secrt Key">
								</div>
							  </div>
							</div>
							<?php }else  if(isset($payee)){?>
							 <div class="payer-tble-detl">
							 <h4 class="text-sky text-center label-danger">Complete order:</h4>
							<div class="form-group row">
								<label for="inputEmail3" class="col-sm-6 control-label">Payer Secrt Key : </label>
								<div class="col-sm-6">
								  <input type="text" name="payer_key" id="payer_key"  class="form-control" placeholder="Payer Secrt Key">
								</div>
							  </div>
							  <div class="form-group row">
								<label for="inputEmail3" class="col-sm-6 control-label">Your Secret Key : </label>
								<div class="col-sm-6">
								  <input type="text" name="payee_key" id="payee_key"  class="form-control"  placeholder="Your Secrt Key">
								</div>
							  </div>
							  
							</div>
							
							<?php }?>
							<div>
							</div>
							 <?php  if($this->session->flashdata('message')){ ?>   
											<div style="color:red">
												<?php echo $this->session->flashdata('message'); ?>                
											</div>
							 <?php }?>
							<input type="hidden" name="order_product_id" value="<?php echo $despute['order_product_id'];?>" />
							 <input type="hidden" name="order_id" value="<?php echo $despute['order_id'];?>" />
							  <div class="form-group  row">
								<div class="col-sm-offset-4 col-sm-8">
								  <input class="trusted-click-btn btn btn-success btn-sm" type="submit" name="submit" value="CONFIRM">
								</div>
							  </div>
							  <div class="form-group  row">
								<div class="col-sm-12 text-center">
								  <a style="color:blue" id="regenrate" href="<?php echo site_url()?>/despute/regenrate_despute/<?php echo $despute['despute_id'];?>">Regenerate Despute</a>
								</div>
							  </div>
					</form>
					 <?php }else{?>
					  <?php if(!isset($key_complete[0])){?>
							<br>Waiting from <?php if(isset($payer)){?>Payee<?php }else{?>Payee<?php }?>  side
					 <?php }}?>
				<?php }elseif($despute_resolved=='2'){?>
					<h4 class="text-center "><strong>Result: </strong>  <?php if(isset($payer)){?>Paid<?php }else{?>Received<?php }?> <?php echo $currency_symbol;?><?php $despute['payer_amount']>$despute['payee_amount']?$despute['payer_amount']:$despute['payee_amount'];?>
					<?php echo sprintf("%.2f", (abs($despute['final_amount']))*$value); ?></h4>			
					<!--<div class="result-note"><h3 class="text-center text-orange">DISPUTE FINISHED</h3></div>-->
					<div class="result-note"><h3 class="text-center text-orange">Resolution</h3></div>
					<div><h4 class="text-center" style="font-size:16px">TrustedPayer has resolved your dispute in favour of the Payer and Payee as follows: 
						Payer: <?php echo (($despute['payee_amount'] - $despute['final_amount'])*100)/$despute['payee_amount'];?>% 
						(<?php echo $currency_symbol.sprintf("%.2f", (abs($despute['payee_amount'] - $despute['final_amount']))*$value);?>) and 
						Payee <?php echo ( $despute['final_amount']*100)/$despute['payee_amount'];?>% 
						(<?php echo $currency_symbol.sprintf("%.2f", (abs($despute['final_amount']))*$value);?>)<br> Thank you for allowing us to settle your dispute and secure your transactions.</h4></div>
					<?php }?>
			<?php }else{?>
			<div class="result-note"><h3 class="text-center text-orange"><?php echo isset($despute_resolved)?"DISPUTE CLOSED":'RESOLUTION'; ?></h3>
			<?php if(!isset($despute_resolved)){ ?>
			<h5 class="text-center">TrustedPayer has received this dispute for resolution. TrustedPayer will resolve in 3 days.</h5>
			<?php } ?>
			</div>
			<?php }?>
			</div>
			</div>
		</div>
	</div>
	<div class="col-sm-8 col-xs-12" >
		<div class="box box-warning direct-chat direct-chat-warning">
                <div class="box-header with-border">
                  <h3 class="box-title">Chat</h3>
				</div>
                <div id="messag-body" class="box-body" style="max-height:600px;">
			<?php foreach($messages as $message): ?>
			
			<?php if($message['message_type']=='Admin') {?>
		  
				 <div class="left-block row text-orange">
					  <div class="left-img-block col-sm-2  blog-imge">
							<img src="<?php echo base_url().$message['photo']?>" class="direct-chat-img">
					  </div>
					  <div class="left-img-text pull-left col-sm-10 ">
						<div class="col-sm-12 bottom-margin ">
							<div class="pull-left client-name"><?php echo $message['sender_name']?></div>
							<div class="pull-right client-date"><?php echo date('d M Y h:i:s A',strtotime($message['added_on']))?></div>
						</div>
							<div class="col-sm-12"><?php echo $message['message_body']?></div>
					  </div>
				  </div>
				  <hr>
				
			<?php  } else if($message['payer_id']==$message['sender_id']){?>
				
			<div class="right-block row">
				  <div class="left-img-block col-sm-2 pull-right blog-imge">
				   	    <img src="<?php echo base_url().$message['photo']?>" class="direct-chat-img">
				  </div>
					  <div class="left-img-text pull-left col-sm-10 ">
						<div class="col-sm-12 bottom-margin ">
						<div class="pull-right client-name"><?php echo $message['sender_name']?></div>
							<div class="pull-left client-date"><?php echo date('d M Y h:i:s A',strtotime($message['added_on']))?></div>
						</div>
							<div class="col-sm-12 text-right"><?php echo $message['message_body']?></div>
					  </div>
				  </div>
			
				<hr>
				
			<?php }else if($message['payee_id']==$message['sender_id']){?>
				
				 <div class="left-block row">
					  <div class="left-img-block col-sm-2  blog-imge">
							<img src="<?php echo base_url().$message['photo']?>" class="direct-chat-img">
					  </div>
					  <div class="left-img-text pull-left col-sm-10 ">
						<div class="col-sm-12 bottom-margin ">
							<div class="pull-left client-name"><?php echo $message['sender_name']?></div>
							<div class="pull-right client-date"><?php echo date('d M Y h:i:s A',strtotime($message['added_on']))?></div>
						</div>
							<div class="col-sm-12"><?php echo $message['message_body']?></div>
					  </div>
				  </div>
				  <hr>
				
			<?php } ?>
			
		<?php endforeach;?>
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
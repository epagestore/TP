<div class="main-area dashboard">
	
	<div class="container">
		<?php if( validation_errors()){ ?>
            <div class="alert alert-error">
                <a class="close" data-dismiss="alert" href="#">x</a>
                <h4 class="alert-heading">Error</h4>
                <?php echo validation_errors(); ?>
            </div>
		<?php }?>
			            		
			<div class="row">
            <?php echo form_open() ?>
            <div class="span12">
            <div class="slate">
             
                <div class="page-header">
                    <div class="pull-right listing-buttons">
                    	<button class="btn btn-success">Save</button>
                   	 <a href="<?php echo base_url();?>index.php/order_transaction" class="btn btn-primary">Cancel</a>
                   </div>
                    <h2>Product - Order Transaction </h2>
                </div>
			
            <div class="content">
             <?php  if($this->session->flashdata('message')){ ?>   
			 <div class="alert alert-success">
                <a class="close" data-dismiss="alert" href="#">x</a>
                <p> <?php echo $this->session->flashdata('message'); ?> </p>
            </div>
     <?php }?>
        <table class="list orders-table table">
          <tbody>
         
         
             <tr>
              <td>Order ID</td>
              <td>Transaction ID</td>
              <td>Name</td>
              <td>Quantity</td>                                          
              <td>Price</td>  
              <td>Total Amount</td>
              <!--<td>Payer Code</td>                                          
              <td>Payee Code</td>  -->
              <td>Order Product Status</td> 
              <td>Action</td>  
 	<?php if($order_product_status_id == 2){ ?>          
            <td>Released By:</td>
	<?php } ?>
                                                                                                        
            </tr>

             <tr>
              <td><?php echo $order_id?></td>
              <td><?php echo $transaction_id?></td>
              <td><?php echo $name?></td>                                                        
              <td><input type="text" value="<?php echo $quantity;?>" name="quantity" /></td>
              <td><?php echo $price?></td>  
              <td><?php echo $total?></td>
              <?php /*?><td><?php echo $payer_code?></td>  
              <td><?php echo $payee_code?></td>   <?php */?>                                                                                             
            <td><!--<span><?php echo $status?></span>-->
                  <select id="order_status" name="order_status">
                   <?php foreach($order_statuses as $order_status):?>
                   <?php if($order_status['order_status_id'] == $order_product_status_id) { ?>
				   <option value="<?php echo $order_status['order_status_id'];?>" selected="selected"><?php echo $order_status['name'];?>  </option>
					<?php } else { ?>                   
				   <option value="<?php echo $order_status['order_status_id'];?>"><?php echo $order_status['name'];?>  </option>
                   <?php } ?>
				   <?php endforeach?>
                  </select>
            </td>
            <td width="120px"><a href="<?php echo base_url();?>index.php/order_transaction/regnerate_code/<?php echo $order_product_id;?>">Generate New Code</a></td>  
 	<?php 
	
	if(isset($releasedByName)){
		if($order_product_status_id == 2){ ?>          
            <td><?php echo $releasedByName?></td>
	<?php } }?>
            
            </tr>
            <input type="hidden" value="<?php echo $order_product_id;?>" name="order_product_id"/></td>
 
<!--         
          <tr>          
            <td>Order ID:</td>
            <td><span><?php echo $order_id?></span></td>
          </tr>
          <tr>
          
          <tr>          
            <td>Transaction ID:</td>
            <td><span><?php echo $transaction_id?></span></td>
          </tr>
          <tr>
          
          <tr>          
            <td>Name:</td>
            <td><span><?php echo $name?></span></td>
          </tr>
          <tr>
          
          <tr>          
            <td>Quantity:</td>
            <td><span><input type="text" value="<?php echo $quantity?>" name="quantity" /></span>
            <input type="hidden" value="<?php echo $order_product_id;?>" name="order_product_id"/></td>
          </tr>
          <tr>
          
          <tr>          
            <td>Price:</td>
            <td><span><?php echo $price?></span></td>
          </tr>
          <tr>
          
          <tr>          
            <td>Total Amount:</td>
            <td><span><?php echo $total?></span></td>
          </tr>
          <tr>

          <tr>          
            <td>Payer Code:</td>
            <td><span><?php echo $payer_code?></span></td>
          </tr>
          <tr>
 
          <tr>          
            <td>Payee Code:</td>
            <td><span><?php echo $payee_code?></span></td>
          </tr>

          <tr>          
            <td>Order Product Status:</td>
            <td>
                  <select id="order_status" name="order_status">
                   <?php foreach($order_statuses as $order_status):?>
                   <?php if($order_status['order_status_id'] == $order_product_status_id) { ?>
				   <option value="<?php echo $order_status['order_status_id'];?>" selected="selected"><?php echo $order_status['name'];?>  </option>
					<?php } else { ?>                   
				   <option value="<?php echo $order_status['order_status_id'];?>"><?php echo $order_status['name'];?>  </option>
                   <?php } ?>
				   <?php endforeach?>
                  </select>
            </td>
          </tr>
--> 
        </tbody></table>
        
          <br /><br /><br />
          
          </div>  
   </div>
           
			  </div>
				
				</form>
				</div>
			
			</div>
			
		</div>
<script language="javascript1.5">
// add new option value and correct its parent div id
function deleteValue($this){
	/*if(confirm('These items will be permanently deleted and cannot be recovered. Are you sure?'))*/{
		$id=$this.parents('tbody').attr('id');
			$this.parents('tbody').siblings('tbody').each(function(){
				if( parseInt($(this).attr('id')) > parseInt($id))
				{
					$(this).attr('id',parseInt($(this).attr('id'))-1)
				}
			});
			$this.parents('tbody').remove();
	}
}
$("#add_value").click(function(){
	//if option value exist then get last child id and make new id by incrementing one
	if($("#option-value").children('tbody').length>0){
		$new_id=(parseInt($("#option-value").children('tbody').last().attr('id'))+1);
	}
	else{
		$new_id='1';
	}
	// append option values box
	html  = '<tbody id=' + $new_id + '">';
	html += '<tr>';	
    html += '<td >';
		html += '<input type="text" name="option_value_name[]" value=""/>';
    	html += '</td>';
  
	html += '<td class="value"><input type="text" name="option_value_order[]" value=""/></td>';
	html += '<td class="actions" ><a name="delete" id="delete_value" onclick="deleteValue($(this))" class="button btn btn-success">Remove</a></td>';
	html += '</tr>';	
    html += '</tbody>';
	$('#option-value tfoot').before(html);
	
	
});

$(document).ready(function(){
	// if already exist option value then display exist option values
	$exist_id=1;
	<?php if(isset($option_values)){?>
		$("#1").remove();
	
	<?php foreach($option_values as $values){?>
		
	html  = '<tbody id=' + $exist_id + '>';
	html += '<tr>';	
    html += '<td><?php if(isset($values['option_value_id'])){?><input type="hidden" value="<?php echo $values['option_value_id']?>" name="option_value_id[]"><?php }?>';
		html += '<input type="text" name="option_value_name[]" value="<?php echo $values['name']?>"/>';
    	html += '</td>';
  
	html += '<td><input type="text" name="option_value_order[]" value="<?php echo $values['sort_order']?>"/></td>';
	html += '<td class="actions" ><a name="delete" id="delete_value" onclick="deleteValue($(this))" class="button btn btn-success">Remove</a></td>';
	html += '</tr>';	
    html += '</tbody>';
		$('#option-value tfoot').before(html);
		
		
		
		$exist_id++
	<?php }}?>
});
</script>
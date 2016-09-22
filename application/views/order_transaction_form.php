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
                    <h2>Order Transaction   </h2>
                </div>
			
            <div class="content">
        <table class="list orders-table table">
          <tbody>
          
            <tr>
              <td>Order ID</td>
              <td>Transaction ID</td>
              <td>Total Amount</td>
              <td>Company Name</td>                                          
              <td>Payer Name</td>  
              <td>Payee Name</td>
              <!--<td>Payer Code</td>                                          
              <td>Payee Code</td>  -->                                      
            </tr>

             <tr>
              <td><?php echo $order_id?></td>
              <td><?php echo $transaction_id?></td>
              <td><input type="text" value="<?php echo $total_amount?>" name="total" /></td>
              <td><?php echo $Company_name?></td>                                          
              <td><?php echo $Payer_name?></td>  
              <td><?php echo $Payee_name?></td>
              <!--<td><?php echo $payer_code?></td>                                          
              <td><?php echo $payee_code?></td>   -->                                     
            </tr>
              <input type="hidden" value="<?php echo $order_id;?>" name="order_id"/>
       
<!--          <tr>          
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
            <td>Total Amount:</td>
            <td><span><input type="text" value="<?php echo $total_amount?>" name="total" /></span>
            <input type="hidden" value="<?php echo $order_id;?>" name="order_id"/>
             
            </td>
          </tr>
          <tr>
          
          <tr>          
            <td>Company Name:</td>
            <td><span><?php echo $Company_name?></span></td>
          </tr>
          <tr>
          
          <tr>          
            <td>Payer Name:</td>
            <td><span><?php echo $Payer_name?></span></td>
          </tr>
          <tr>
          
          <tr>          
            <td>Payee Name:</td>
            <td><span><?php echo $Payee_name?></span></td>
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
--> 
        </tbody></table>
        
          <br /><br /><br />
          
     <?php if($is_milestone == 0) { ?>     
        <table class="list orders-table table">
          <thead>
            <tr>
              <td>Order Product ID</td>
              <td>Product Name</td>
              <td>Transaction ID</td>
              <td>Amount</td>                                          
              <td class="actions">Action</td>              
            </tr>
            
          </thead>               
               <tbody>
               
               <?php foreach($product_results as $product_result): ?>
                    <tr>
                      <td><?php echo $product_result['order_product_id'];?></td>
                      <td><?php echo $product_result['name'];?></td> 
                      <td><?php echo $product_result['transaction_id'];?></td>  
                      <td><?php echo $product_result['total'];?></td>                      
                      <td class="actions"><a class="btn btn-small btn-primary" href="<?php echo base_url();?>index.php/order_transaction/postingProduct/<?php echo $product_result['order_product_id']?>">Edit</a></td>

                    </tr>
               <?php endforeach ?>     
               </tbody>
           
               <tfoot>
               
              </tfoot>
            </table>
       <?php } ?>


     <?php if($is_milestone == 1) { ?>     
        <table class="list orders-table table">
          <thead>
            <tr>
              <td>Milestone ID</td>
              <td>Transaction ID</td>
              <td class="actions">Action</td>              
            </tr>
            
          </thead>               
               <tbody>
               
               <?php foreach($milestone_results as $milestone_result): ?>
                    <tr>                      
                      <td><?php echo $milestone_result['milestone_id'];?></td>
                      <td><?php echo $milestone_result['transaction_id'];?></td>                      
                      <td class="actions"><a class="btn btn-small btn-primary" href="<?php echo base_url();?>index.php/order_transaction/postingMilestone/<?php echo $milestone_result['milestone_id']?>">Edit</a></td>

                    </tr>
               <?php endforeach ?>     
               </tbody>
           
               <tfoot>
               
              </tfoot>
            </table>
       <?php } ?>        
    		
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
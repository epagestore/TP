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
                   	 <a href="<?php echo base_url();?>index.php/despute/remedy_discount" class="btn btn-primary">Cancel</a>
                   </div>
                    <h2>despute reason </h2>
                </div>
			
            <div class="content">
        <table>
          <tbody>
          <tr>
            <td>despute reason :</td>
            <td><input type="text" name="description" value="<?php echo $DesputeRemedy['description']?>"/></td>
          </tr>
          <tr>
            <td>discount :</td>
            <td><input type="text" name="discount" value="<?php echo $DesputeRemedy['discount']?>"/>%</td>
          </tr>
          <tr>
          
          </tr>
          
          
        </tbody></table>
        
        
    		
          </div>  
   </div>
           
			  </div>
				
				</form>
				</div>
			
			</div>
			
		</div>
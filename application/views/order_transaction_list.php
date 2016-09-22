<div class="main-area dashboard">
	
		<div class="container">
			<?php if($this->session->flashdata('message')){ ?>   
                <div class="alert alert-success">
                    <a class="close" data-dismiss="alert" href="#">x</a>
                    <h4 class="alert-heading">Success:</h4>
                    <?php echo $this->session->flashdata('message'); ?>                
                    
                </div>
			<?php }?>
			<div class="row">
			
				<div class="span12">
				
					<div class="slate">
						<div class="content">
						 <?php echo form_open('','class=form-inline') ?>
                                <input type="text" class="input-large" placeholder="Keyword..." name="keyword" value="<?php echo $keyword?>" id="keyword">
<!--							<select>
								<option value=""> - From Date - </option>
							</select>
							<select>
								<option value=""> - To Date - </option>
							</select>
-->							<select>
								<option value=""> - Filter - </option>
							</select>
							<button type="submit" class="btn btn-primary">Filter Listings</button>
						</form>
						</div>
					</div>
				
				</div>
			
			</div>
			
			<div class="row">
				
				
				
				<div class="span12">
				
					<div class="slate">
					
						<div class="page-header">
							<div class="pull-right listing-buttons">
				
<!--                                <a href="<?php echo base_url();?>index.php/product/posting" class="btn btn-success">INSERT</a>
-->                            
                                <button class="btn btn-primary" onclick="deletemulti();">DELETE</button>
                            
                            </div>
							<h2>Order Transaction </h2>
						</div>
					<div class="content">
						<table class="orders-table table">
						<thead>
							<tr style=" width:10px;">
                             <th><input type="checkbox" value="order_all" id="all" onclick="checkall($(this),'ord_id[]');" ></th>
                           
								<th>Order ID</th>
								<th class="value">Company Name</th>
								<th class="value">Order Type</th> 
								<th class="value">Payer Name</th> 
								<th class="value">Payee Name</th>                                                                                               
                                <th class="value">Amount</th>
                                 
								<th class="actions">Actions</th>
                            
							</tr>
						</thead>
						<tbody>
                        	<?php foreach ($orders as $order): ?>
                           <tr>
                             <td style=" width:10px;"><input type="checkbox" value="<?php echo $order['order_id']?>" name="ord_id[]" onclick="checkitem($(this),'all')"></td>
                             <td style=" width:10px;"><?php echo $order['order_id']?></td>
                             <td class="value"><?php echo $order['Company_name']?></td>
                <?php if($order['is_milestone'] == 1){ ?>
                             <td class="value">Milestone</td>
                 <?php } else { ?>	
                             <td class="value">Product</td>
				<?php } ?>                 				             
                             <td class="value"><?php echo $order['Payer_name']?></td>
                             <td class="value"><?php echo $order['Payee_name']?></td>                             
                             <td class="value"><?php echo $order['total_amount']?></td>
                             
<!--							  <td><a href="form.html"><?php echo $order['product_name']?></a> <br /><span class="meta"><?php echo $order['date_modified']?></span></td>
                                <td class="value">
									<?php echo $order['status']?>
								</td>
                                <td class="value">
									<?php echo $order['customer_name']?>
								</td>
-->								<td class="actions">
									<a class="btn btn-small btn-danger remove-item" data-toggle="modal"  href="<?php echo base_url();?>index.php/order_transaction/delete/<?php echo $order['order_id']?>">Remove</a>
									<a class="btn btn-small btn-primary" href="<?php echo base_url();?>index.php/order_transaction/posting/<?php echo $order['order_id']?>">Edit</a>
								</td>
							</tr>
							
							<?php endforeach ?><?php if(!$orders){ ?>
                            <tr>
                            	<td colspan="4" style="text-align:center">Sorry No Record Found</td>
                            </tr>
                            <?php }?>
						</tbody>
						</table>
                        </div>
						<div id="pagination" class="pagination pull-left">
						</div>
					</div>
				
				</div>
				
				<div class="modal hide fade" id="removeItem">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">×</button>
						<h3>Remove Item</h3>
					</div>
					<div class="modal-body">
						<p>Are you sure you would like to remove this item?</p>
					</div>
					<div class="modal-footer">
						<a href="#" class="btn" data-dismiss="modal">Close</a>
						<a href="#" class="btn btn-danger">Remove</a>
					</div>
				</div>
                
                <div class="modal hide fade" id="selectItem">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">×</button>
						<h3>Information</h3>
					</div>
					<div class="modal-body">
						<p>Select atleast one Item</p>
					</div>
					<div class="modal-footer">
						<a href="#" class="btn" data-dismiss="modal">Ok</a>
					</div>
				</div>
			
			</div>
			
		</div>
	
	</div>
<script>
function checkall($this,$name){
	
		if($this.attr('checked'))
		$("input[name='"+$name+"']").attr('checked','checked');
		else
		$("input[name='"+$name+"']").removeAttr('checked');

}
function checkitem($this,$id){

		if($this.attr('checked'))
			$this.attr('checked','checked');
		else
			$this.removeAttr('checked');
			
		if($("input[name='"+$this.attr('name')+"'][checked='checked']").length == $("input[name='"+$this.attr('name')+"']").length)
			$("#"+$id).attr('checked','checked');
		else
			$("#"+$id).removeAttr('checked');

}
function deletemulti(){

	var order_id='';
	
	$i=0;
	$("input[name='ord_id[]'][checked='checked']").each(function(){
		if($i==0)
		order_id+=$(this).val();
		else
		order_id+='--'+$(this).val();
		$i++;
	});
	if(order_id!='')
	{
		$('#removeItem .btn-danger').click(function () {
      		window.location.href ="<?php echo base_url();?>index.php/order_transaction/delete/"+order_id;
		 });
		 $('#removeItem').modal('toggle');
	}
	else
	 $('#selectItem').modal('toggle');
	
	
}

$(document).ready(function(){
	
	
$('a.remove-item').click(function () {
    var url = this.href;
    $('#removeItem .btn-danger').click(function () {
      window.location.href = url;
    });
	$('#removeItem').modal('toggle');
 });
  
<?php $array = $this->uri->uri_to_assoc(2);
if(isset($array['page']))
$page=$array['page'];
else
$page=1;
?>



/*var totalPages = <?php echo $page_total;?>;
alert(totalPages);
exit;	
*/		

keyword = $("#keyword").val();

 var options = {
	 		keyword: $("#keyword").val(),
            currentPage: <?php echo $page;?>,
            totalPages: <?php echo $page_total?>,			
 //         page: <?php echo $page;?>,

			pageUrl: function(type, page, current){

            if(keyword == '')
			    return "<?php echo base_url();?>index.php/order_transaction/page/"+page;
			else
				return "<?php echo base_url();?>index.php/order_transaction/page/"+page+"?keyword="+encodeURI(keyword);
            },
			itemTexts: function (type, page, current) {
                    switch (type) {
                    case "first":
                        return "First";
                    case "prev":
                        return "Previous";
                    case "next":
                        return "Next";
                    case "last":
                        return "Last";
                    case "page":
                        return page;
                    }
                },
			shouldShowPage:function(type, page, current){
                switch(type)
                {
                    case "first":
                    case "last":
                        return false;
                    default:
                        return true;
                }
            }
        }

        $('#pagination').bootstrapPaginator(options);
});
</script>
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
                                <input type="text" class="input-large" placeholder="Keyword..." name="option_name" value="<?php //echo $option_name?>">
                                <select>
                                    <option value=""> - From Date - </option>
                                </select>
                                <select>
                                    <option value=""> - To Date - </option>
                                </select>
                                <select>
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
								<a href="<?php echo base_url();?>index.php/despute/reasons_insert" class="btn btn-success">INSERT</a>
                            
                                <button class="btn btn-primary" onclick="deletemulti('opt_id[]');">DELETE</button>
                            </div>
							<h2>despute reason </h2>
						</div>
						<div class="content">
						<table class="desputes-table table">
						<thead>
							<tr style=" width:10px;">
                             <th><input type="checkbox" value="option_all" id="all" onclick="checkall($(this),'opt_id[]');" ></th>
                           
								<th>despute reason</th>
								<th class="actions">Actions</th>
                            
							</tr>
						</thead>
						<tbody>
                        	<?php foreach ($DesputeReasons as $option): ?>
                            <tr>
                             <td style=" width:10px;"><input type="checkbox" value="<?php echo $option['reason_id']?>" name="opt_id[]" onclick="checkitem($(this),'all')"></td>
							  <td><a href="form.html"><?php echo $option['description']?></a> <!--<span class="label label-info">Item Status</span>--><br /><span class="meta">Added date</span></td>
                            
								<td class="actions">
									<a class="btn btn-small btn-danger remove-item" data-toggle="removeItem"  href="<?php echo base_url();?>index.php/despute/reasons_delete/<?php echo $option['reason_id']?>">Remove</a>
									<a class="btn btn-small btn-primary" href="<?php echo base_url();?>index.php/despute/reasons_form/<?php echo $option['reason_id']?>">Edit</a>
								</td>
							</tr>
							
							<?php endforeach ?>
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
function deletemulti($name){

	var option_id='';
	$i=0;
	$("input[name='"+$name+"'][checked='checked']").each(function(){
		if($i==0)
		option_id+=$(this).val();
		else
		option_id+='--'+$(this).val();
		$i++;
	});
	if(option_id!='')
	{
		$('#removeItem .btn-danger').click(function () {
			window.location.href ="<?php echo base_url();?>index.php/despute/reasons_delete/"+option_id;
		});
		$('#removeItem').modal('toggle');
		
	}
	else
	$('#selectItem').modal('toggle');

}

<?php /*?>$(document).ready(function(){
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
		
			
	 var options = {
				currentPage: <?php echo $page;?>,
				totalPages: <?php echo $page_total?>,
				pageUrl: function(type, page, current){
	
					return "<?php echo base_url();?>index.php/option/page/"+page+"/<?php echo $option_name?>";
	
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
});<?php */?>
</script>

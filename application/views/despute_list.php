<?php include("inner_menu.php");?>
<div class="seperator">
</div>
<section class="container">
<div class="row">




<div class="col-sm-12">
<nav id="cbp-hrmenu" class="cbp-hrmenu">
  <ul class="nav nav-tabs">
    <li <?php if($heading=='DISPUTE RECEIVED,'){?>class="active" <?php }?> ><a href="<?php echo base_url();?>index.php/despute/receive_list">Dispute Received</a></li>
    <li <?php if($heading=='DISPUTE GENERATED,'){?>class="active" <?php }?>><a  href="<?php echo base_url();?>index.php/despute/generate_list">Dispute Generated</a></li>
	<a href="" class="refresh_list btn btn-success   pull-right " style="margin-bottom:5px;"><i class="fa fa-refresh"></i> Refresh</a>
  </ul>
</nav>
</div>
<div class="col-sm-12">
	<div class="tab-content">
        <div class="welcom-note bottom-margin">
        
		
	   
        </div>
		<div class="table-responsive">
        <table class="table " id="tab">
		<thead>
		  <tr class="text-center table-hd">
			<th>Dispute ID</th>
			 <?php if($heading=='DISPUTE GENERATED,'){?>        
		<th>Generated For</th>
        <?php }else{?>
		<th>Generated By</th>       
        <?php }?>			
			<th>Description</th>
			<th>Date</th>
			<th>Status</th>
		  </tr>
			</thead>
		<thead>
			<tr>
				<th rowspan="1" class="filter" colspan="1"></th>
				<th rowspan="1" class="filter" colspan="1"></th>
				<th rowspan="1" class="filter" colspan="1"></th>
				<th rowspan="1" class="filter" colspan="1"></th>
				<th rowspan="1" class="filter" colspan="1"></th>
				
			</tr>
		</thead>
			<tbody id="fbody">
				
        <?php $i=1; foreach($desputes as $desputes):?>
            <tr class="inform-histroy-show" style="cursor:pointer;" onClick="window.location.href='<?php echo base_url()?>index.php/despute/negotiate/<?php echo $desputes['despute_id']?>'">
            <td class="sno-line"> <?php echo $desputes['despute_id'];?></td>
              <?php if($heading=='DISPUTE GENERATED,'){?>
            <td  class="amount-line"> <?php echo $desputes['generate_for_name']?>&nbsp;</td>
             <?php }else{?>
             <td  class="amount-line"> <?php echo $desputes['generate_by_name']?>&nbsp;</td>
              <?php }?>
            <td class="desrp-id"> &nbsp;<?php echo $desputes['despute_reason']?></td>
            <td class="date-line"> <?php echo  date('d M Y h:i:s A',strtotime($desputes['date_added']))?></td>
             <td class="date-line"> <?php /*if($desputes['status']<=1){echo "unresolved";}else if($desputes['status']>=2){echo "resolved";}else*/ if($desputes['status']=='1'){ echo "Pending";}else if($desputes['status']=='2'){ echo "closed";}else if($desputes['status']=='3'){ echo "resolved ";}else if($desputes['status']=='4'){ echo "fineshed";}?></td>
            </tr>
        <?php $i++; endforeach?>
        
        </tbody> 
        </table> 
		</div>
	</div>
	</div>
</div>
</section>
<link rel="stylesheet" href="<?php echo base_url();?>css/jquery.dataTables.min.css"></style>
<script type="text/javascript" src="<?php echo base_url();?>js/jquery.dataTables.min.js"></script>

<script>
$(document).ready(function(){
  var table =$('#tab').dataTable( {"order": [[0, "desc" ]] });
  /* $('#tab thead .filter').each(function (i) 
	{
		var title = $('#tab thead .filter').eq($(this).index()).text();
		// or just var title = $('#sample_3 thead th').text();
		var serach = '<input type="text" class="form-control" placeholder="Search ' + title + '" />';
		$(this).html('');
		$(serach).appendTo(this).keyup(function(){table.fnFilter($(this).val(),i)})
	});*/
  }); 
</script>

<?php //include("inner_menu.php"); //echo "<pre>"; print_R($userinfo); ?>
<div class="seperator">
</div>
<section class="container">
	<div class="row">
		<div class="col-sm-offset-1 col-sm-10 ">
			<div class="box box-warning box-solid bg-orange">
				<div class="row bottom-margin center-block text-center " style="padding:10%;">
					<h1 class="text-center"  style="font-size:3em;font-weight:normal">Your  Withdrawal Request has been received successfully !!! </h1>
					<br>
					<h3 class=""><a class="countdown text-white" href="<?php echo base_url();?>dashboard"></a></h3>
				</div>
			</div>
		</div>
	</div>
</section>	
<script>
var count = 10;
  countdown = setInterval(function(){
    $("a.countdown").html('You Will Redirect Home page in '+count + " seconds ");
    if (count == 0) {
		window.location = '<?php echo base_url().'index.php/dashboard';?>';
		//return false;
    }
	count--;
}, 1000);


</script>
<div class="seperator">
</div>
	
	
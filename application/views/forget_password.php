
<section class="container" style="min-height:;">
<br>
<div class="row">
	<div class="col-xs-12 col-sm-4 col-sm-offset-4">
		<div class="panel panel-primary">
			<div class="panel-heading">Change Password</div>
			<div class="panel-body">
				<form method="post" class="form-vertical">
					<div class="form-group"><span>New Password :</span> <input class="form-control" name="pass" type="password" autocomplete="off" /></div>
					<span class="help-block label-danger text-white"><?php echo form_error('pass'); ?></span>
					<div class="form-group"><span>Confirm Password :</span> <input name="confirm_pass"  class="form-control" type="password"  autocomplete="off"/></div>
					<span class="help-block label-danger text-white"><?php echo form_error('confirm_pass'); ?></span>
					<input name="redirect" value="<?php echo $_SERVER['REQUEST_URI'];?>" type="hidden" />
					<button type="submit" class="Forget_btn btn btn-success">Change Password</button>
					<a type="submit" class="Forget_btn btn btn-danger">Cancel</a>
				</form>
			</div>
		</div>
	</div>
</div>
	<hr>
</section>
<script>
$('.nav').remove();
</script>
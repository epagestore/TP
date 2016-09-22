<?php if(isset($error)) echo $error;?>
<?php //print_r($request);?>
<div class="seperator">
</div>
<section class="container">
<form method="post" name="form-approve-request">
Request made by <?php echo $request[0]['request_name']?> of total amount <?php echo $currency_symbol;?><?php echo sprintf("%.2f", ($request[0]['amount'])*$value); ?> 
<input type="submit"  class="btn btn-success" name="ok" value="Approve">
<input type="submit" class="btn btn-danger" name="cancel" value="Decline">
</form>
</section>
<div class="banner-wrapper">
<div id="demo" class="skdslider">
<ul>
<li>
<img src="<?php echo base_url();?>slideimages/banner.png" /></li>
<li><img src="<?php echo base_url();?>slideimages/banner-1.png" /></li>
<li><img src="<?php echo base_url();?>slideimages/banner-3.png" /></li>
<li><img src="<?php echo base_url();?>slideimages/banner-4.png" /></li>
<li><img src="<?php echo base_url();?>slideimages/banner-5.png" /></li>
<?php /*?><li><img src="<?php echo base_url();?>slideimages/6.jpg" />
  <div class="slide-desc">
		<h1>Every Purchage Here</h1>
		<p>Buy with confidence knowing,/</p>
  </div>
  <div class="shop-btn">
  <a href="#"> Shop Now !</a>
  </div>
 
</li><?php */?>
</ul>
</div>

<div class="banner-contain">
    <div class="reg-templete">
		<?php if( validation_errors()){ ?>
                    <div class="alert alert-error">
                        <a class="close" data-dismiss="alert" href="#">x</a>
                        <?php echo validation_errors(); ?>
                    </div>
                <?php }?>
        <?php echo form_open('','id="personal_registration-form"')?>
            <div class="reg-bar">
                <div class="reg-txt">Company Name</div>
                <div class="reg-input-text"><input type="text" value="" name="company_name" id="company_name" /></div>
            </div>
            <div class="reg-bar">
                <div class="reg-txt">Email id</div>
                <div class="reg-input-text"><input type="text" value="" name="email" id="email" /></div>
            </div>
            <div class="reg-bar">
                <div class="reg-txt">Passowrd</div>
                <div class="reg-input-text"><input type="password" value="" name="password" id="password" /></div>
            </div>
            <div class="reg-bar">
                <div class="reg-txt">Confirm Passowrd</div>
                <div class="reg-input-text"><input type="password" value="" name="repass" id="repass" /></div>
            </div>
            <div class="reg-bar">
                <input type="submit" class="register-btn" value="Register Now!">
               <!-- <div class="cancel-btn"><a href="#">Cancel</a></div>-->
            </div>   
        </form>
    </div>
</div>
</div>
<div class="gly-wrapper">
<div class="gly-contain">
<div class="gly-one">
<div class="gly-top-img">
<img src="<?php echo base_url();?>images/gly-img-one.png" />
</div>
<div class="gly-hdr-name">
Buy into being safer
</div>
<div class="gly-desrpn">
Shop safely across the globe
while your financial information 
is kept private and protected.
</div>
<div class="gly-readmore"><a href="#">Read more >></a></div>
</div>
<div class="gly-two">
<div class="gly-top-img">
<img src="<?php echo base_url();?>images/gly-img-two.png" />
</div>
<div class="gly-hdr-name">
Buy into being safer
</div>
<div class="gly-desrpn">
Shop safely across the globe
while your financial information 
is kept private and protected.
</div>
<div class="gly-readmore"><a href="#">Read more >></a></div>
</div>
<div class="gly-three">
<div class="gly-top-img">
<img src="<?php echo base_url();?>images/gly-img-one.png" />
</div>
<div class="gly-hdr-name">
Buy into being safer
</div>
<div class="gly-desrpn">
Shop safely across the globe
while your financial information 
is kept private and protected.
</div>
<div class="gly-readmore"><a href="#">Read more >></a></div>
</div>
</div>
</div>
<script>
	$(".header-top-menu ul li.business a").addClass('active');
	$(document).ready(function(){
	$("#personal_registration-form").validate({
		 
		 rules: {
            company_name: "required",
			email:{required:true,email:true},
			password: "required",
			repass:{equalTo : "#password"}
			
        },
        // Specify the validation error messages
        messages: {
            company_name: "* Please enter Company name",
			email: {required:"* Please enter Email address",email:"* Please enter valid Email address"},
			password: "* Please enter Password",
			repass:"* Please enter valid Password",
			
        },
        
        submitHandler: function(form) {
            form.submit();
        }
		
	});
});
</script>
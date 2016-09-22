
<style>
.form-control
{
	color:#fff;
}
.text-white{
	color:#fff;
}
@media (max-width:767px) {
	#trigger-overlay11{overflow-x:hidden; }
}
@media (min-width:768px) and (max-width:991px) {
	#trigger-overlay11{ overflow-x:hidden; }
}
</style>
<link href="<?php echo base_url(); ?>css/ladda.min.css" rel="stylesheet" >
<link rel="stylesheet" href="<?php echo base_url();?>layout-1/css/bootstrap-select.css">
<link rel="stylesheet" href="<?php echo base_url();?>layout-1/css/bootstrap-select.min.css">

	<header>
			<section class="hero">
				<div class="texture-overlay"></div>
				<div class="container">
					<div class="row nav-wrapper">
						<div class="col-md-6 col-sm-6 col-xs-6 text-left">
							<a href="#"><img src="<?php echo base_url();?>layout-1/img/logo.png" alt="TRUSTED PAYER Logo" class="brand-img"></a>
						</div>
						<div class="col-md-6 col-sm-6 col-xs-6 text-right navicon">
							<!--<p>LOGIN/SIGNUP NOW</p>-->
							<?php if(!$this->session->userdata('customer_id')){?>
								<a id="trigger-overlay"  class="learn-btn nav_slide_button " href="#"> LOGIN </a>
							<?php } else {?>
								<a class="learn-btn nav_slide_button " href="<?php echo base_url();?>index.php/dashboard"> Dashboard </a>
							<?php }?>
							<!-- <a id="trigger-overlay" class="nav_slide_button " href="#"><span></span></a> -->
						</div>
					</div>
					<div class="row hero-content">
						<div class="col-md-12 mob-center">
							<h1 class="animated fadeInDown">TrustedPayer, <small class="text-white">Make your transactions secure, safe & sure...!!!</small></h1>
							<?php if(!$this->session->userdata('customer_id')){?>
							<a id="sign_up" href="#" class="use-btn animated fadeInUp">SIGNUP NOW</a>
							<?php }?>
							<a href="#about" class="learn-btn animated fadeInUp">Learn more <i class="fa fa-arrow-down"></i></a>
							
						</div>
					</div>
				</div>
			</section>
		</header>
		<section class="video" id="about">
			<div class="container">
				<div class="row">
					<div class="col-md-12 text-center">
						<h1><a href="#" class="youtube-media"><i class="fa fa-play-circle-o"></i> Watch the Video</a></h1>
					</div>
				</div>
			</div>
		</section>
		<section class="features-intro">
			<div class="container-fluid">
				<div class="row">
					<div class="col-md-6 nopadding features-intro-img">
						<div class="features-bg">
							<div class="texture-overlay"></div>
							<div class="features-img wp1">
								<img src="<?php echo base_url();?>layout-1/img/secure.png" alt="Secure">
							</div>
						</div>
					</div>
					<div class="col-md-6 nopadding">
						<div class="features-slider">
								<ul class="slides" id="featuresSlider">
									<li>
										<h1>Sign up for your free TrustedPayer account using your email and password on your mobile or website.</h1>
										<p>TrustedPayer is extremely simple to use, You can pay directly from your bank or card or your can fund your Trustedpayer account to complete your order .TrustedPayer is also packed  with powerful features that enables merchants and sellers to fulfill their  sales directly and  securely without  fear of loss of payment or exorbitant costs . </p>
									</li>
									<li>
										<h1>Easy intergration to your eCommerce website</h1>
										<p>With our simple to integrate APIs and Plug-ins you can integrate with trusted payer and immediately begin to receive payments from your buyers who need the security and assurance provided by TrustedPayer. </p>
									</li>
									<li>
										<h1>Buy and Sell from anywhere in the world </h1>
										<p>With TrustedPayer you can buy and sell from anywhere in the world, TrustedPayer enables you to deliver your goods or services to the right buyer without fear of loss or fraud. When you buy from any trustedpayer seller anywhere in the world you can be sure that your money is guaranteed until the purchase is delivered to your satisfaction.</p>
									</li>
								</ul>
						</div>
					</div>
				</div>
			</div>
		</section>
		<section class="features-list" id="features">
			<div class="container">
				<div class="row">
					<div class="col-md-12">

						<div class="col-md-4 feature-1 wp2">
							<div class="feature-icon">
								<i class="fa fa-lightbulb-o"></i>
							</div>
							<div class="feature-content">
								<h1>Peace of mind</h1>
								<p>With TrustedPayer you are covered from beginning to the end of your transaction. For all your we legitimated purchases we guarantee you full peace of mind and 110% protection. If your order doesn't arrive or is not as promised by the seller described, you will not be debited and your money will be safe and secure with us</p>
								<!--<a href="#" class="read-more-btn">Read More <i class="fa fa-chevron-circle-right"></i></a>-->
							</div>
						</div>
						<div class="col-md-4 feature-2 wp2 delay-05s">
							<div class="feature-icon">
								<i class="fa fa-life-ring"></i>
							</div>
							<div class="feature-content">
								<h1>The safer way to pay</h1>
								<p>TrustedPayer is the safest way to pay or receive money for good and services sold or purchased. We protect your agreement all the way and ensure that the seller sticks to his promise from day 1</p>
								<!--<a href="#" class="read-more-btn">Read More <i class="fa fa-chevron-circle-right"></i></a>-->
							</div>
						</div>
						<div class="col-md-4 feature-3 wp2 delay-1s">
							<div class="feature-icon">
								<i class="fa fa-money"></i>
							</div>
							<div class="feature-content">
								<h1>Send payments overseas</h1>
								<p>With TrustedPayer, whether you are a buyer or a seller you are always in charge of the entire transaction process. With TrustedDispatcher our revolutionary dispatch module you can deliver your products anywhere in the world without loosing your product to courier or loosing your money to fraudulent buyers   </p>
								<!--<a href="#" class="read-more-btn">Read More <i class="fa fa-chevron-circle-right"></i></a> -->
							</div>
						</div>

					</div>
				</div>
			</div>
		</section>
		<section class="showcase">
			<div class="showcase-wrap">
				<div class="texture-overlay"></div>
				<div class="container">
					<div class="row">
						<!--<div class="col-md-6">
							<div class="device wp3">
								<div class="device-content">
									<div class="showcase-slider">
										<ul class="slides" id="showcaseSlider">
											<li>
												<img src="img/screen1.jpg" alt="Device Content Image">
											</li>
											<li>
												<img src="img/screen2.jpg" alt="Device Content Image">
											</li>
											<li>
												<img src="img/screen3.jpg" alt="Device Content Image">
											</li>
										</ul>
									</div>
								</div>
							</div>
						</div>-->
						<div class="col-md-12 text-center">
							<h1>Showcase your Product or Service</h1>
							<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed a lorem quis neque interdum consequat ut sed sem. Duis quis tempor nunc. Interdum et malesuada fames ac ante ipsum primis in faucibus.</p>
							<blockquote class="team-quote">
								<div class="avatar"><img src="<?php echo base_url();?>layout-1/img/avatar.png" alt="User Avatar"></div>
								<p>"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed a lorem quis neque interdum consequat ut sed sem. Duis quis tempor nunc." - Peter Finlan</p>
								<!--<div class="logo-quote">
									<a href="#"><img src="img/logo.png" alt="Logo"></a>
								</div> -->
							</blockquote>
							
							<blockquote class="team-quote">
								<div class="avatar"><img src="<?php echo base_url();?>layout-1/img/avatar.png" alt="User Avatar"></div>
								<p>"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed a lorem quis neque interdum consequat ut sed sem. Duis quis tempor nunc." - Peter Finlan</p>
								<!--<div class="logo-quote">
									<a href="#"><img src="img/logo.png" alt="Logo"></a>
								</div> -->
							</blockquote>
							<!--<a href="#" class="download-btn">Download! <i class="fa fa-download"></i></a> -->
						</div>
					</div>
				</div>
			</div>
		</section>

		<section class="screenshots-intro">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<h1>Packed Full of Powerful Features</h1>
						<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed a lorem quis neque interdum consequat ut sed sem. Duis quis tempor nunc. Interdum et malesuada fames ac ante ipsum primis in faucibus.</p>
						<p><a href="#screenshots" class="arrow-btn">See the screenshots! <i class="fa fa-long-arrow-right"></i></a></p>
					</div>
				</div>
			</div>
		</section>
		<section class="screenshots" id="screenshots">
			<div class="container-fluid">
				<div class="row">
					<ul class="grid">
						<li>
							<figure>
								<img src="<?php echo base_url();?>layout-1/img/01-screenshot.jpg" alt="Screenshot 01">
								<figcaption>
								<div class="caption-content">
									<a href="<?php echo base_url();?>layout-1/img/large/01.jpg" class="single_image">
										<i class="fa fa-search"></i><br>
										<p>Optimised For Design</p>
									</a>
								</div>
								</figcaption>
							</figure>
						</li>
						<li>
							<figure>
								<img src="<?php echo base_url();?>layout-1/img/02-screenshot.jpg" alt="Screenshot 01">
								<figcaption>
								<div class="caption-content">
									<a href="<?php echo base_url();?>layout-1/img/large/02.jpg" class="single_image">
										<i class="fa fa-search"></i><br>
										<p>User Centric Design</p>
									</a>
								</div>
								</figcaption>
							</figure>
						</li>
						<li>
							<figure>
								<img src="<?php echo base_url();?>layout-1/img/03-screenshot.jpg" alt="Screenshot 01">
								<figcaption>
								<div class="caption-content">
									<a href="<?php echo base_url();?>layout-1/img/large/03.jpg" class="single_image">
										<i class="fa fa-search"></i><br>
										<p>Responsive and Adaptive</p>
									</a>
								</div>
								</figcaption>
							</figure>
						</li>
						<li>
							<figure>
								<img src="<?php echo base_url();?>layout-1/img/04-screenshot.jpg" alt="Screenshot 01">
								<figcaption>
								<div class="caption-content">
									<a href="<?php echo base_url();?>layout-1/img/large/04.jpg" class="single_image">
										<i class="fa fa-search"></i><br>
										<p>Absolutely Free</p>
									</a>
								</div>
								</figcaption>
							</figure>
						</li>
					</ul>
				</div>
			<!--	<div class="row">
					<ul class="grid">
						<li>
							<figure>
								<img src="img/05-screenshot.jpg" alt="Screenshot 01">
								<figcaption>
								<div class="caption-content">
									<a href="img/large/05.jpg" class="single_image">
										<i class="fa fa-search"></i><br>
										<p>Multi-Purpose Design</p>
									</a>
								</div>
								</figcaption>
							</figure>
						</li>
						<li>
							<figure>
								<img src="img/06-screenshot.jpg" alt="Screenshot 01">
								<figcaption>
								<div class="caption-content">
									<a href="img/large/06.jpg" class="single_image">
										<i class="fa fa-search"></i><br>
										<p>Exclusive to Codrops</p>
									</a>
								</div>
								</figcaption>
							</figure>
						</li>
						<li>
							<figure>
								<img src="img/07-screenshot.jpg" alt="Screenshot 01">
								<figcaption>
								<div class="caption-content">
									<a href="img/large/07.jpg" class="single_image">
										<i class="fa fa-search"></i><br>
										<p>Made with Love</p>
									</a>
								</div>
								</figcaption>
							</figure>
						</li>
						<li>
							<figure>
								<img src="img/08-screenshot.jpg" alt="Screenshot 01">
								<figcaption>
								<div class="caption-content">
									<a href="img/large/08.jpg" class="single_image">
										<i class="fa fa-search"></i><br>
										<p>In Sydney, Australia</p>
									</a>
								</div>
								</figcaption>
							</figure>
						</li>
					</ul>
				</div>-->
			</div>
		</section>
		<section class="features-intro">
			<div class="container-fluid">
				<div class="row">
					<div class="col-md-6 nopadding features-intro-img">
						<div class="features-bg">
							<div class="texture-overlay"></div>
							<div class="features-img wp1">
								<img src="<?php echo base_url();?>layout-1/img/secure.png" alt="Secure">
							</div>
						</div>
					</div>
					<div class="col-md-6 nopadding">
						<div class="features-slider text-center">
						<h1 class="text-white">TrustedPayer Dispature</h1>
								<ul class="slides" id="featuresSlider">
									<li>
										<a href="#" class="download-btn">Start Now</a>
									</li>
								</ul>
						</div>
					</div>
				</div>
			</div>
		</section>
		<section class="download" id="download">
			<div class="container">
				<div class="row">
					<div class="col-md-12 text-center text-orange wp4">
						<h1>Easy And SecurePayment</h1>
						<a href="#" class="download-btn">Start Now</a>
					</div>
				</div>
			</div>
		</section>
		
		<div class="overlay " id="trigger-overlay11" style="display:none;">
			
				<div class="row">
					<div class="col-md-12">
						<span class="pull-right" id="close_overlay" style="color:#fff;margin-top:3%; margin-right:10%; cursor:pointer; display:block; z-index:2345" ><i class="fa fa-times fa-2x"></i></span>
					</div>
				</div>
			
			<nav class="container nav-home">
				
				<div class="row">
				<div class="col-xs-12 col-sm-5  text-left login login-box">
				<h3>Login</h3>
				<form class="form-horizontal" method="post" id="login_form" action="<?php echo base_url();?>index.php/sign_in">
					  <div class="form-group trans-bg">
						
						<div class="col-sm-12">
						  <input type="email" name="email" id="email" class="form-control" placeholder="Email">
						</div>
					  </div>
					  <div class="form-group trans-bg">
						
						<div class="col-sm-12">
						  <input type="password" name="password" id="password" class="form-control"  placeholder="Password">
						  <input type="hidden" name="redirect" class="form-control"  id="redirect" placeholder="redirect" value="<?php echo isset($_GET['redirect'])?$_GET['redirect']:''; ?>">
						</div>
					  </div>
					  <div class="form-group">
						<div class="col-sm-12">
						  <div class="checkbox">
							<label>
							  <input type="checkbox" name="remember_me" value="1"> Remember me
							</label>
							<label  class="pull-right" id="forgot">
							   Forgot Password ?
							</label>
							
						  </div>
						</div>
					  </div>
					  <div class="form-group ">
						<div class="col-sm-12">
						  <div id="login" class="btn btn-success btn-lg">Sign In</div>
						</div>
					  </div>
					
					  <div class="form-group ">
						<div class="col-sm-12">
						<h4><!--  <a href ="#" class="fb-btn"><i class="fa fa-facebook fbicon"></i>Login With Facebook</a>--></h4>
						</div>
					  </div>
					  <div class="form-group ">
						<div class="col-sm-12">
						<h4> <!-- <a href ="#" class="g-btn"><i class="fa fa-google-plus fbicon"></i>Login With Google+</a>--></h4>
						</div>
					  </div>
				</form>
				
				</div>
				<div class="col-xs-12 col-sm-5  text-left forgot login" style="display:none">
				<h3>Forgot Password</h3>
				<form class="form-horizontal" method="post" id="forgot_form" action="<?php echo base_url();?>index.php/sign_in">
					  <div class="form-group trans-bg">
						<div class="col-sm-12">
						  <input type="email" name="forget_email" id="forget_email" class="form-control" placeholder="Email">
						  <span class="help-block label-danger text-white" ></span>
						</div>
					  </div>
					  <div class="form-group ">
						<div class="col-sm-12">
						  <button type="button" id="forgot-btn" class="btn btn-danger btn-lg" >Forgot Password</button>
						  <div id="sign-forgot-btn" class="btn btn-success btn-lg pull-right">Sign In</div>
						</div>
					  </div>
					
					  <div class="form-group ">
						<div class="col-sm-12">
						<h4><!--  <a href ="#" class="fb-btn"><i class="fa fa-facebook fbicon"></i>Login With Facebook</a>--></h4>
						</div>
					  </div>
					  <div class="form-group ">
						<div class="col-sm-12">
						<h4> <!-- <a href ="#" class="g-btn"><i class="fa fa-google-plus fbicon"></i>Login With Google+</a>--></h4>
						</div>
					  </div>
				</form>
				
				</div>
				
				<div class="col-sm-2 hidden-xs text-center">
				<img src="<?php echo base_url();?>layout-1/img/or.png">
				
				</diV>
				
				<div class=" col-xs-12 col-sm-5 text-left login">
				<h3>Signup</h3>
				<form class="form-horizontal" id="reg_form" method="post" action="<?php echo base_url();?>index.php/home"> 
						<div class="form-group trans-bg">
						
						<div class="col-sm-12">
						  <input type="text" class="form-control"  id="fname"  name="fname"  placeholder="Name">
						</div>
					  </div>
					  <div class="form-group trans-bg">
						
						<div class="col-sm-12">
						  <input type="email" class="form-control" name="email" id="email_reg" placeholder="Email">
						</div>
					  </div>
					  <div class="form-group trans-bg">
						<div class="col-sm-12">
						  <input type="password" class="form-control" id="pwd_reg" name="password" placeholder="Password">
						</div>
					  </div>
					  <div class="form-group trans-bg">
						<div class="col-sm-12">
						<div class="col-sm-3 ">
								<select class="form-control" data-size="5"  name="phonecode" id="phonecode" >
									<?php foreach($phonecode as $p): ?>
									<option <?php if(isset($profile['phonecode']) && $profile['phonecode']!=0 && $profile['phonecode'] == $p['phonecode']) {echo "selected";} ?> value="<?php echo $p['phonecode'];?>"  data="<?php echo $p['iso']?>"><?php echo '+'.$p['phonecode']?></option>
									<?php endforeach;?>
								</select>
								</div>
							<div class="col-sm-9 ">
								<input type="text" class="form-control" id="customer_phone" name="customer_phone" placeholder="Enter Your Phone number">
							</div>
						</div>
					  </div>
					   <div class="form-group">
						<div class="col-sm-12">
						  <div class="checkbox">
							<div class="col-sm-12">
								<label>
							  <input type="checkbox" name="dispatcher" value="1">I Want to subscribe for TPDispatcher
							</label>
							</div>
							
							<div class="col-sm-offset-1 col-sm-9 dispatcher_location1 hidden">
							<label>
							  <input type="checkbox" name="dispatcher_location[]" value="Local">Local
							</label>							
							<label>
							  <input type="checkbox" name="dispatcher_location[]" value="Domestic">Domestic
							</label>							
							<label>
							  <input type="checkbox" name="dispatcher_location[]" value="International">International
							</label>
							
						  </div>
						  </div>
						</div>
					  </div>
					  <div class="form-group">
						<div class="col-sm-12">
						  <div class="btn btn-success btn-lg" id="register">Sign UP</div>
						</div>
					  </div>
				</form>
				
				</div>
				</div>
			</nav>
		</div>
		<!--div class="overlay " id="trigger-overlay11" style="display:none">
			
				<div class="row">
					<div class="col-md-12">
						<span class="pull-right" id="close_overlay" style="color:#fff;margin-top:3%; margin-right:10%; cursor:pointer;" ><i class="fa fa-times fa-2x"></i></span>
					</div>
				</div>
			<div class="row">
					<div class="col-md-12 text-center text-white">
						<h1>TrustedPayer Dispature</h1>
					</div>
				</div>
			
		</div!-->
		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
		<script src="<?php echo base_url();?>layout-1/js/min/toucheffects-min.js"></script>
		<script src="<?php echo base_url();?>layout-1/js/flickity.pkgd.min.js"></script>
		<script src="<?php echo base_url();?>layout-1/js/jquery.fancybox.pack.js"></script>
		<!-- Include all compiled plugins (below), or include individual files as needed -->
		<script src="<?php echo base_url();?>layout-1/js/retina.js"></script>
		<script src="<?php echo base_url();?>layout-1/js/waypoints.min.js"></script>
		<script src="<?php echo base_url();?>layout-1/js/bootstrap.min.js"></script>
		<script src="<?php echo base_url();?>layout-1/js/min/scripts-min.js"></script>
		<script src="<?php echo base_url();?>js/library/bootstrap-select.js"></script>
		<!-- Google Analytics: change UA-XXXXX-X to be your site's ID. -->
		<script>
		(function(b,o,i,l,e,r){b.GoogleAnalyticsObject=l;b[l]||(b[l]=
		function(){(b[l].q=b[l].q||[]).push(arguments)});b[l].l=+new Date;
		e=o.createElement(i);r=o.getElementsByTagName(i)[0];
		e.src='//www.google-analytics.com/analytics.js';
		r.parentNode.insertBefore(e,r)}(window,document,'script','ga'));
		ga('create','UA-XXXXX-X');ga('send','pageview');
		</script>
		<script>
		$(document).ready(function(){
			$('body').css('overflow','hidden!important');
			$('.selectpicker').selectpicker();
		});
		
		$(document).ready(function(){
			$("input[name='dispatcher']").on("change",function(){
			
				if($(this).prop('checked')==true)
				{
					$(".dispatcher_location1").removeClass('hidden');
				}else{
					$(".dispatcher_location1").addClass('hidden');
					$("input[name='dispatcher_location[]']").prop("checked",false);
				}
			});
			
			$("#trigger-overlay").click(function(event) {
				
				$('html').css('overflow','hidden');
				$('.overlay').fadeIn();
				
			});
			$("#sign_up").click(function() {
				$('.overlay').fadeIn();
			});
			$("#close_overlay").click(function() {
				$('.overlay').fadeOut();
				$('html').css('overflow','');
			});
			
			
			$("#login").click(function(){
				var email = $("#email").val();
				var password = $("#password").val();
				var redirect=$("#redirect").val();
				// Checking for blank fields.
					if( email =='' || password =='')
					{
						$('#email,#password').css("border","2px solid red");
						$('#email,#password').css("box-shadow","0 0 3px red");
						//alert("Please fill all fields...!!!!!!");
					}
					else 
					{
						$.post("<?php echo base_url();?>index.php/sign_in/validCustomer",{ email: email, password:password,redirect:redirect},
						function(data) {
							
						if(data=='Invalid Email.......') 
						{
							$('#email').css({"border":"2px solid red","box-shadow":"0 0 3px red"});
							$('#password').css({"border":"2px solid #00F5FF","box-shadow":"0 0 5px #00F5FF"});
							alert(data);
						}
						else if(data=='Email or Password is wrong...!!!!'){
							$('#email,#password').css({"border":"2px solid red","box-shadow":"0 0 3px red"});
							//alert(data);
						} 
						else if(data=='Successfully Logged in...')
						{
							$( "#login_form" ).submit();
							//alert(data);
						} 
						else
						{
							alert(data);
						}
						});
					}
			});
			$('#fname').keyup(function(){
				var fname = $("#fname").val();
				if( fname !='')
				{
					$('#fname').css("border","1px solid #ccc");
					$('#fname').css("box-shadow","none");
				}
			});
			$('#email_reg').keyup(function(){
				var email = $("#email_reg").val();
				var pattern = /^[+a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/i;
				if( email !='' && pattern.test(email))
				{
					$('#email_reg').css("border","1px solid #ccc");
					$('#email_reg').css("box-shadow","none");
				}
			});
			$('#pwd_reg').keyup(function(){
				var password = $("#pwd_reg").val();
				if( password !='' && password.length >=3)
				{
					$('#pwd_reg').css("border","1px solid #ccc");
					$('#pwd_reg').css("box-shadow","none");
				}
				if( password =='' || password.length <=3 )
				{
					$('#pwd_reg').css("border","2px solid red");
					$('#pwd_reg').css("box-shadow","0 0 3px red");
					//alert("Please fill all fields...!!!!!!");
				}
			});
			$("#register").click(function(){
				
				var email = $("#email_reg").val();
				var fname = $("#fname").val();
				var password = $("#pwd_reg").val();
				var pattern = /^[+a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/i;
				// Checking for blank fields.
				var $a = 0;
				if( fname =='')
				{
					$('#fname').css("border","2px solid red");
					$('#fname').css("box-shadow","0 0 3px red");
					//alert("Please fill all fields...!!!!!!");
					 $a++;
				}
				if( email =='')
				{
					$('#email_reg').css("border","2px solid red");
					$('#email_reg').css("box-shadow","0 0 3px red");
					 $a++;
				
				}
				if( password =='' || password.length <=3 )
				{
					$('#pwd_reg').css("border","2px solid red");
					$('#pwd_reg').css("box-shadow","0 0 3px red");
					//alert("Please fill all fields...!!!!!!");
					 $a++;
				}
				if($a==0)
				{
					
					$.post("<?php echo base_url();?>index.php/sign_in/validate_email",{ email: email},
						function(data) {
						if(data=='1') 
						{
							$( "#reg_form" ).submit();	
						}
						else
						{
							$('#email_reg').css("border","2px solid red");
							$('#email_reg').css("box-shadow","0 0 3px red");
							$('#email_reg').val('');
							$('#email_reg').attr("placeholder","Email Id Already Register");
						}
						});
					
				}
				
			});	
			$("#password").focus().keypress( function(e) {
					if( e.keyCode == 13 || e.keyCode == 27 ) $("#login").trigger('click');
			});
	
			
		});
		$('#forgot').click(function(){
				$('.login-box').hide();
				$('.forgot').fadeIn('slow').animate('slow');
		});
		$('#sign-forgot-btn').click(function(){
				$('.forgot').hide();
				$('.login-box').fadeIn('slow').animate('slow');
		});
		
		$("#forgot-btn").click(function(){
			var l = Ladda.create( document.querySelector( '#forgot-btn' ) );
			$('#forget_email').parent().find('.help-block').text('');
			var email = $("#forget_email").val();
			var forget_pass = "forget_pass";
			$a=0;
			
			 
			
			var filter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
			if( email =='' || filter.test(email) === false)
			{
				$('#forget_email').css("border","2px solid red");
				$('#forget_email').css("box-shadow","0 0 3px red");
				 $a++;
				$('#forget_email').parent().find('.help-block').text('Please Enter valid Email Address');
				$('#forget_email').parent().find('.help-block').fadeIn();
			}
			else
			{
				$('#forget_email').parent().find('.help-block').text('');
			}
			l.start();
			if($a==0)
			{
			
				$.post("<?php echo base_url();?>index.php/sign_in/validate_email",{ email: email},
						function(data) {
						if(data=='1') 
						{
							$.post("<?php echo base_url();?>index.php/sign_in/fg",{ forget_pass:forget_pass,forget_email: email},
							function(data) {
								data = $.parseJSON(data);
							if(data.status=='1') 
							{
								$('#forget_email').parent().find('.help-block').removeClass('label-danger');
								$('#forget_email').parent().find('.help-block').addClass('label-info');
								$('#forget_email').parent().find('.help-block').text(data.message);
							}
							else
							{
								$('#forget_email').css("border","2px solid red");
								$('#forget_email').parent().find('.help-block').text(data.message);
								$('#forget_email').val('');
								
							}
							});
							l.stop();
						}
						else
						{
							$('#forget_email').css("border","2px solid red");
							$('#forget_email').css("box-shadow","0 0 3px red");
							$('#forget_email').val('');
							$('#forget_email').parent().find('.help-block').text(data.message);
						}
						});
						
				
			}
			
		});
		
		</script>
		
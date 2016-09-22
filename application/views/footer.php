<style>
.modal.fade .modal-dialog {
    -webkit-transform: scale(0.1);
    -moz-transform: scale(0.1);
    -ms-transform: scale(0.1);
    transform: scale(0.1);
    top: 300px;
    opacity: 0;
    -webkit-transition: all 0.3s;
    -moz-transition: all 0.3s;
    transition: all 0.3s;
}

.modal.fade.in .modal-dialog {
    -webkit-transform: scale(1);
  -moz-transform: scale(1);
    -ms-transform: scale(1);
  transform: scale(1);
  -webkit-transform: translate3d(0, -300px, 0);
    transform: translate3d(0, -300px, 0);
  opacity: 1;
}
</style>
<div class="ci_session hidden"><?php print_r($this->session->userdata); ?></div>
<section class="footer">
  <div class="text-center">
	<ul class="list-unstyled footer-link">
		<li><a class="text-white" href="<?php echo base_url();?>dashboard" >Home | </a></li>
		<li><a class="text-white" href="<?php echo base_url();?>" >About Us | </a></li>
		<li><a class="text-white" href="<?php echo base_url();?>" >Contact Us </a></li>
		<li><a class="text-white" href="<?php echo base_url();?>" >Contact Us </a></li>
		
	</ul>
	<h1 class="text-white"><span id="siteseal"><script type="text/javascript" src="//seal.godaddy.com/getSeal?sealID=ppqPk7Z6pIOVYQFCeEN0ljatdAB4Yfipee8eXy7cc6y2UdU5AaRS7KMWpQ3n"></script></span></h1>
	<h3 class="text-white">Follow Us </h3>
	<ul class="list-unstyled footer-link">
		<li><a class="text-white" href="#" ><i class="fa fa-facebook"></i></a></li>
		<li><a class="text-white" href="#" ><i class="fa fa-google-plus"></i></a></li>
		<li><a class="text-white" href="#" ><i class="fa fa-twitter"></i></a></li>
		<li><a class="text-white" href="#" ><i class="fa fa-linkedin"></i></a></li>
	</ul>
	
	<span class="copy-text text-white"><small>Copyright © 1999 - <?php echo date("Y"); ?> Trusted Payer. All rights reserved.Privacy Policy Legal Agreements</small></span> 
  </div>
</section>
<?php if($this->session->userdata('customer_id')){?>
<script src="<?php echo base_url();?>layout-1/js/userLog.js"></script>
<script>
$(document).ready(function() {
	//$(".collapse").collapse('show');
	$(document).on("click","#hide",function(){
		$("table.hide_details").slideToggle( "slow", "linear" );
	});
	$("#show").click(function(){
		$("div").toggle();
	});
	$(window).scroll(function(){
		var scrollTop = $(window).scrollTop();
		if(scrollTop != 0 && scrollTop > 150)
			$('.yehki_addresbar_bar ').stop().animate({'opacity':'1'},400);
		else	
			$('.yehki_addresbar_bar ').stop().animate({'opacity':'0'},400);
	});
});
</script>
<?php }?>
<script>
	/* Default Image */
	$(document).ready(function() {
		$(".container:eq(2)").css({"min-height":(570)+"px"});
	  $('img').each(function() {
			/* if (!this.complete || typeof this.naturalWidth == "undefined" || this.naturalWidth == 0) {
			  // image was broken, replace with your new image
			  this.src = '<?php echo base_url(); ?>img/Team/user_placeholder.png';
			} */
		  });
	});
/* Default Image */
	$(document).ready(function(){
		/* $("span.round.img-circle.text-center").each(function(){
			//console.log($(this).text());
			//if($(this).text().trim()=='0'){$(this).addClass('hidden')};
		});
		
		var tdf = setInterval(function(){
			$("span.round.img-circle.text-center").each(function(){
				//console.log($(this).text());
				//if($(this).text().trim()!='0'){$(this).removeClass('hidden');};
			});
		},1000);
		setTimeout(function(){clearTimeout(function(){tdf});},20000); */
		
		/* tooltip */
		$('.fa-eye,.fa-exclamation-triangle').parent().attr("data-placement","top");
		$('.fa-eye,.fa-exclamation-triangle').parent().attr("data-toggle","tooltip");
		$('.fa-eye').parent().attr("data-original-title","View Detail" );
		$('.fa-exclamation-triangle').parent().attr("data-original-title","Complain" );
		$('[data-toggle="tooltip"]').tooltip();  
		$('[data-tooltip="tooltip"]').tooltip();
		/* tooltip */
		/* Bootstrap Select Dropdown */
		//$('.selectpicker').selectpicker();
		/* Bootstrap Select Dropdown */
		//Currency change
		$("input[name='claim_amount'],input[name='unit_price[]'],.unit_price").priceFormat({
			prefix: '',
			thousandsSeparator: ','
		});
		$('span').each(function(){
			var va=$(this).text();
			//$(this).autoNumeric('set',va);
		});
		
		 $("input[name='amount']").autoNumeric('init');   
		 $("input[name='amount'],input[name='receive_amount']").keyup(function(){
			// $(this).val($(this).autoNumeric('get')); 
		 })  ; 
	});
	
	</script>
	<script src="<?php echo base_url();?>js/bootstrap-alert.js"></script> 
	<script src="<?php echo base_url();?>js/spin.min.js"></script>
	<script src="<?php echo base_url();?>js/ladda.min.js"></script>
	<script src="<?php echo base_url();?>js/ajaxloader.js"></script>
	<script>

			// Bind normal buttons
			Ladda.bind( 'button[type="submit"],input[type="submit"],#login,#register,.buttons-pdf,.nxt_click,.view_mlileston_detail,.prv_click,.product_dispatcher_status,.dispatcherList',{ timeout: 1500 } );

			// Bind progress buttons and simulate loading progress
			/* Ladda.bind( 'button[type="submit"],input[type="submit"]', {
				callback: function( instance ) {
					var progress = 0;
					var interval = setInterval( function() {
						progress = Math.min( progress + Math.random() * 0.1, 1 );
						instance.setProgress( progress );

						if( progress === 1 ) {
							instance.stop();
							clearInterval( interval );
						}
					}, 200 );
				}
			} ); */

			// You can control loading explicitly using the JavaScript API
			// as outlined below:

			// var l = Ladda.create( document.querySelector( 'button' ) );
			// l.start();
			// l.stop();
			// l.toggle();
			// l.isLoading();
			// l.setProgress( 0-1 );

		</script>
	<script>
		  $.ajax({
					url: '<?php echo base_url();?>index.php/balance_manager/getCurrentBalance',
					success: function(e) {
						
						var val=parseInt(e);
						val=parseFloat(val*<?php echo $value; ?>).toFixed(2);
						var curr='<?php echo $currency_symbol;?>';
						
						if(e!='')
							$(".curr_bal_amt").html(curr+' '+ addCommas(val));
							$(".curr_bal_menu").html('Your Current Balance: <strong class=" auto">'+curr+ addCommas(val)+'</strong>');
						chk2=0;
					}
		   });
			$(function() {		
			
				var timer2, delay2 = 5000;
					var chk2=0;
					timer2 = setInterval(function(){
						
						if(chk2==0){
							chk2=1;
							
					   $.ajax({
								url: '<?php echo base_url();?>index.php/balance_manager/getCurrentBalance',
								success: function(e) {
									var val=parseInt(e);
									val=parseFloat(val*<?php echo $value; ?>).toFixed(2);
									var curr='<?php echo $currency_symbol;?>';
									//val=format1(val,curr)
									
									
									if(e!='')
										$(".curr_bal_amt").html( curr +" " + addCommas(val));
									chk2=0;
								
								}
					   });
						}
					}, delay2);
		});
		
		function addCommas(nStr) {
			nStr += '';
			x = nStr.split('.');
			x1 = x[0];
			x2 = x.length > 1 ? '.' + x[1] : '';
			var rgx = /(\d+)(\d{3})/;
			while (rgx.test(x1)) {
				x1 = x1.replace(rgx, '$1' + ',' + '$2');
			}
			return x1 + x2;
		}
		</script>  
<?php if(uri_string()=='dashboard'){?>
<a class="text-white opt_retrieve2 hidden"  ></a>
<div class="modal fade animated shake" id="Verify" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" style="width:320px!important;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <p class="modal-title">Mobile verification!</p>
      </div>
      <div class="modal-body text-center">
        <input onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" class="form-control text-center" maxlength="6" type="text"  name="opt_verify_number"  placeholder=" Enter OPT Code" />
		<span class="opt_error text-danger"></span>
      </div>
      <div class="modal-footer">
        <a class="btn-danger btn" style="cursor:pointer;" id="opt_retrieve">Regenerate OPT Code</a>
		<button type="button" class="btn btn-primary otp_verify" id="opt_verify" disabled >Verify</button>
      </div>
    </div>
  </div>
</div>
<script>
var customer_phone = "<?php echo $cust_detail[0]['customer_phone'];?>";
var phonecode = "<?php echo $cust_detail[0]['phonecode'];?>";
var x = "<?php echo $cust_detail[0]['verify'];?>";
$(document).on("click",".opt_retrieve2",function(){
	indexotpmobile ='<?php echo $cust_detail[0]['customer_phone'];?>' //$(this).parent().parent().find('input[name="customer_phone[]"]').val();
	
	indexoptm = $(this).attr("data");
	
	phoneCode = "<?php echo $cust_detail[0]['phonecode'];?>";//$('select[name="phonecode[]"]:eq('+(indexoptm)+')').val();

	$(".opt_error").addClass("text-danger");
	$("input[name='opt_verify_number']").val('');
	$(".opt_error").text('');
	if(indexotpmobile.length<10)
	{
		$(this).parent().parent().find('.col-xs-9').addClass("has-error");
		$(this).parent().parent().find('.col-xs-9').removeClass("has-success");
		return false;
	}else{
		$(this).parent().parent().find('.col-xs-9').removeClass("has-error");
		$(this).parent().parent().find('.col-xs-9').addClass("has-success");
	}	
	
	
	$("#Verify").modal('show');
	var num= phoneCode+indexotpmobile;
	var l = Ladda.create( document.querySelector( '#opt_retrieve' ) );
	l.start();
	$.ajax({
		url:"<?php echo base_url()?>profile/opt?number="+encodeURIComponent("+"+num),
		type:"get",
		success:function(data){
			$(".otp_verify").removeAttr('disabled');
			console.log(data);
			$(".opt_error").text(data);
			l.stop();
		},error:function(error){
			console.log(error);
			l.stop();
		}
	})
	
});
$("#opt_retrieve").on("click",function(){
	$(".opt_error").addClass("text-danger");
	$("input[name='opt_verify_number']").val('');
	$(".opt_error").text('');
	var num= phoneCode+indexotpmobile;
	var l = Ladda.create( document.querySelector( '#opt_retrieve' ) );
	l.start();
	$.ajax({
		url:"<?php echo base_url()?>profile/opt?number="+encodeURIComponent("+"+num),
		type:"get",
		success:function(data){
			$(".otp_verify").removeAttr('disabled');
			console.log(data);
			$(".opt_error").text(data);
			l.stop();
		},error:function(error){
			console.log(error);
			l.stop();
		}
	})
	
});


$("#opt_verify").on("click",function(){
	$(".opt_error").text('');
	var num= $("input[name='opt_verify_number']").val();
	var l = Ladda.create( document.querySelector( '#opt_verify' ) );
	l.start();
	$.ajax({
		url:"<?php echo base_url()?>profile/opt_verify?otp="+encodeURIComponent(num)+'&mobile='+indexotpmobile+"&phonecode="+phoneCode,
		type:"get",
		success:function(data){
			$(".otp_verify").removeAttr('disabled');
			console.log(data);
			if(data=='0')
			{
				$(".opt_error").text(" Invalid OPT code!");
				$(".opt_error").addClass("text-danger");
			}	
			if(data=='1')
			{
				$(".opt_error").text("Mobile number verification is successful!");
				$(".opt_error").addClass("text-success");
				$(".opt_error").removeClass("text-danger");
				$(".opt_retrieve2:eq("+(indexoptm)+")").removeClass("btn btn-primary");
				$(".opt_retrieve2:eq("+(indexoptm)+")").addClass('img-circle');
				$(".opt_retrieve2:eq("+(indexoptm)+")").html('<i class="fa fa-check-square-o fa-2x"></i>');
				$(".opt_retrieve2:eq("+(indexoptm)+")").css('color',"#449D44");
				
				setTimeout(function(){
					$("#Verify").modal('hide');
				},1500);
				window.location.href=window.location.href;
			}
			l.stop();
		},error:function(error){
			console.log(error);
			l.stop();
		}
	})
});
	
	
	if(x==0 && customer_phone.length != 0 && phonecode.length != 0)
	{
		$('.opt_retrieve2').trigger('click');
	}
</script>
<?php }?>
  </body>
</html>

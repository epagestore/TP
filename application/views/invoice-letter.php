<?php 
///////////////////////////////////////////
$ci = &get_instance();
	 $ci->load->model('currencies_model');
		
		if($this->session->userdata('currency_id')){
			$currency_id = $this->session->userdata('currency_id');		
		} else { 
			$currency_id = '4';				
		}
		
		$currencies= $ci->currencies_model->get_currency();
		foreach($currencies as $currency)
		{
					
				$this->currency['currencies'][] = array(
				'currency_id' => $currency['currency_id'],
				'currency_symbol'          => $currency['symbol'],
				'code'          => $currency['code'],	
				'status'          => $currency['status']										
				);
		}		
		$this->session->set_userdata($this->currency);
		
		$currency_detail = $ci->currencies_model->getCurrencyInfo($currency_id);		
		if(sizeof($currency_detail)<=0)
		{
			$currency_detail = $ci->currencies_model->getCurrencyInfo(4);		
		}
		$currency_symbol = $currency_detail->code;				
		$currency_title = $currency_detail->title;		
		$value = $currency_detail->value; 	
		
		//////////////////////////////////////////////////


?>

<table width="600" border="1" style="border-collapse:collapse; border:1px solid #e2e2e2; font-size:13px; font-family:Arial, Helvetica, sans-serif;" bgcolor="#fff">
 <div style="text-align:right; width:70%; margin:10px auto; display:table;"><input type="button" value="Export PDF" onclick="pdf_export()" style="padding:4px; margin-top:10px" /></div>
   <tr bordercolor="#006666" style="border-bottom:5px solid #f79646">
  <td>
  <table>
  <tr>
    <td valign="bottom"><b><h2 style="line-height:0;"><?php echo $company_name;?></h2></b></td>
    <td style="width:240px">
    </td>
<?php if($photo){?>
    <td align="right">
     <img src="<?php echo base_url().urlencode($photo);?>" width="100" height="70"/></td>
<?php } ?>	 
  </tr>
 
  </table>
  </td>
  </tr>
  
   <tr>
   <td>
  <table width="510" align="center">
  <tr><td> 
<p>
   
    To Pay your invoice From <?php echo $company_name;?> for <?php echo $currency_symbol;?> : <?php echo sprintf("%.2f", ($total)*$value); ?> or to download a PDF copy  for your  records, Clickthe link below...
   </p>
   
   <p>
   <a href="<?php echo base_url().'index.php/invoice/pay/'.$key;?>">
   <?php echo base_url().'index.php/invoice/pay/'.$key;?>
   </a>
   </p>
   
   <p>
   <span>Best Regards</span>
   <p><?php echo $company_name; if($company_website){ ?> (<a href="#"><?php echo $company_website;?></a>)<?php } ?></p>
   </p>
  
   </td>
   </tr>
   </table>
  </tr>
 <tr bordercolor="#006666" style="">
  <td>
  <table>
  <tr>
    <td valign="bottom">
    
   <p>
   <p style="margin-bottom:0px;">
   Sent using Trustedpayer QuickSetter</p>
 
 <span>  #1 Online settler and account manager Designed for Small and  Medium Enterprises.</span>

<p style="line-height:0">
   <a href="<?php echo base_url();?>">Sign up for your free account</a></p>
   </p>
    
    
    </td>
   

    <td align="right">
     <img src="<?php echo base_url();?>images/logo.png" width="120" height="80"/></td>
  </tr>
 
  </table>
  </td>
  </tr>
</table>
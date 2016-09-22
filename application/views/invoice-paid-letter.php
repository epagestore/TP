<table width="800" cellpadding="5" border="0" style="border-collapse:collapse; border:1px solid #e2e2e2; font-size:13px; font-family:Arial, Helvetica, sans-serif; color:#000;" bgcolor="#fff">
  <tr>
    <td><table>
        <tr>
          <td valign="bottom"><div style="color:white;float: left;margin-left: -3px;margin-top: -2px;"></div>
            <img src="<?php echo base_url();?>images/paid.png" /> <b>
            <h2 style="line-height:0;"><?php echo $invoice[0]['company_name'] ?></h2>
            </b> <br>
            <p><?php echo $invoice[0]['customer_phone'] ?></p></td>
          <td style="width:100%"></td>
          <td align="right"><img src="<?php if($invoice[0]['photo']!=''){echo base_url().$invoice[0]['photo'];}else { echo  base_url()."images/no_image.gif";} ?>"width="80" height="70"/></td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td><table width="800" style="margin-top:10px; margin-bottom:10px;">
        <tr>
          <td align="left" valign="bottom"><a href="#" style="font-size:18px; font-weight:bold; color:#000;"> <?php echo $invoice[0]['first_name']." ".$invoice[0]['last_name'] ?> </a>
            <table width="60%" border="1" align="right" style="border-collapse:collapse; border:1px solid #e2e2e2;" cellpadding="0" cellspacing="10">
              <tr height="30" style="border-bottom:1px solid #e2e2e2;">
                <th scope="col" align="left" bgcolor="#f3f3f3" style="border-right:1px solid #e2e2e2;" >In voice # :</th>
                <th scope="col" align="right"><?php echo $invoice[0]['invoice_id'] ?></th>
              </tr>
              <tr height="30" style="border-bottom:1px solid #e2e2e2;">
                <th scope="row" align="left" bgcolor="#f3f3f3" style="border-right:1px solid #e2e2e2;">Date</th>
                <td align="right"><?php echo $invoice[0]['date_added'] ?></td>
              </tr>
              <tr height="30" style="border-bottom:1px solid #e2e2e2;">
                <th scope="row" align="left" bgcolor="#f3f3f3" style="border-right:1px solid #e2e2e2;">Amount Due CAD</th>
                <td align="right"><?php echo $currency_symbol;?><?php echo sprintf("%.2f", ($invoice[0]['total'])*$value); ?></td>
              </tr>
            </table></td>
        </tr>
      </table></td>
  </tr>
  <tr bordercolor="#006666" style="" height="40">
    <td><table width="100%" align="center" border="0" style="border-collapse:collapse; margin-bottom:20px; border:1px solid #e2e2e2; border-left:none; border-right:none;" cellpadding="10">
        <tr bordercolor="#666666" style="border:1px solid #e2e2e2; height:50px; color:#1996e6; border-left:none; border-right:none;">
          <th width="12%" scope="col" style="border-right:1px solid #e2e2e2; ">item</th>
          <th width="47%" scope="col" style="border-right:1px solid #e2e2e2; ">description</th>
          <th width="16%" scope="col" style="border-right:1px solid #e2e2e2; ">Unit Cost</th>
          <th width="15%" scope="col" style="border-right:1px solid #e2e2e2; ">Quantity</th>
          <th width="14%" scope="col">Prize</th>
        </tr>
        <?php $subtotal=0;foreach($invoice_order as $order):?>
        <tr style="border:none; margin-bottom:10px; height:40px;">
          <th scope="row"><?php echo $order['item']?></th>
          <td align="center"><?php echo $order['description']?></td>
          <td align="right"><?php echo $currency_symbol;?><?php echo sprintf("%.2f", ($order['unit_price'])*$value); ?></td>
          <td align="center"><?php echo $order['quantity']?></td>
          <td align="right"><?php $subtotal+=$order['quantity']*$order['unit_price'];?><?php echo $currency_symbol;?><?php echo sprintf("%.2f", ($order['quantity']*$order['unit_price'])*$value); ?></td>
        </tr>
        <?php endforeach;?>
      </table></td>
  <tr>
    <td></td>
  </tr>
  <tr>
    <td><table width="800" style="border-top:1px solid #e2e2e2;">
        <tr>
          <td align="left" valign="bottom"><table width="60%" border="0" align="right" cellpadding="4px" style="border-collapse:collapse; border:1px solid #e2e2e2; margin-top:10px; margin-bottom:10px;">
              <tr style="height:30px;">
                <th scope="col" align="right">Sub Total:</th>
                <th scope="col" align="right"><?php echo $currency_symbol;?><?php echo sprintf("%.2f", ($subtotal)*$value); ?></th>
              </tr>
              <tr style="border-bottom:1px solid #e2e2e2; style="height:30px;"">
                <th scope="col" align="right">GST-<?php echo $invoice[0]['discount'].$invoice[0]['discount_type'] ?>:</th>
                <th scope="col" align="right"><?php echo $currency_symbol;?><?php echo sprintf("%.2f", (($subtotal*$invoice[0]['discount'])/100)*$value); ?></th>
              </tr>
              <tr style="height:30px;">
                <th scope="row" align="right">Total</th>
                <td align="right"><?php echo $currency_symbol;?><?php echo sprintf("%.2f", ($invoice[0]['total'])*$value); ?></td>
              </tr>
              <tr style="border-bottom:1px solid #e2e2e2;height:30px;">
                <th scope="row" align="right">Amount Paid</th>
                <td align="right">-
                  <?php if($invoice[0]['status']=='3') echo $invoice[0]['total'];else echo "0.00";?></td>
              </tr>
              <tr bgcolor="#CCCCCC" style="height:30px;">
                <th scope="row" align="right">Balance Due CAD</th>
                <td align="right"><?php echo $currency_symbol;?>
                  <?php if($invoice[0]['status']!='3') echo sprintf("%.2f", ($invoice[0]['total'])*$value);else echo "0.00";?></td>
              </tr>
              <tr bgcolor="#CCCCCC">
                <th scope="row" align="right"></th>
                <td align="right"></td>
              </tr>
            </table></td>
        </tr>
        <tr>
          <td><table width="800" style="border-top:1px solid #e2e2e2;">
              <tr>
                <td align="center" valign="bottom"><p style="font-size:18px;"><?php echo ($invoice[0]['terms'])?></p>
                  <p style="font-size:18px;"><?php echo ($invoice[0]['notes'])?></p></td>
              </tr>
            </table>
      </table></td>
  </tr>
  </tr>
  
</table>
<table align="left" width="800">
  <tr>
    <td align="right" valign="bottom"><span style="font-size:12px; margin-top:4px; line-height:30px"  align="top"> The invoice was sent using</span><span style="float:right;"><img src="<?php echo base_url();?>images/logo.png" width="50" height="30" style="float:right"/></span> </span></td>
  </tr>
</table>

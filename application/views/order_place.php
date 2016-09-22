<?php echo form_open('','name="order_place" id="form-order_place"')?>
order ID: <input type="text" name="order_key" id="order_key"  />
Amount: <input type="text" name="amount" id="amount"  /><br>
<br>
Delivery address:<br>
	Name: <input type="text" name="fname" id="fname" placeholder="Firts name" /> <input type="text" name="lname" id="lname" placeholder="Last name" /><br />
    Email:  <input type="text" name="email" id="email" placeholder="Email" /><br />
    country:  <input type="text" name="country" id="country" placeholder="Country" /><br />
    state:  <input type="text" name="state" id="state" placeholder="state" /><br />
    Address: <textarea name="address" id="address"></textarea><br />
    Postcode: <input type="text" name="post_code" id="post_code" /><br />
    Mobile: <input type="text" name="mobile" id="mobile" /><br />
Payee_id : <input type="text" name="payee_key" id="payee_key"  /><br />
<input type="submit" value="Place Order" name="place_order" id="place_order">
</form>
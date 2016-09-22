 <?php echo form_open('','name="personal_registration" id="form-personal_registration"')?>
	Name: <input type="text" name="fname" id="fname" placeholder="Firts name" /> <input type="text" name="lname" id="lname" placeholder="Last name" /><br />
    Email:  <input type="text" name="email" id="email" placeholder="Email" /><br />
    Password:  <input type="password" name="pass" id="pass"  /><br />
    country:  <input type="text" name="country" id="country" placeholder="Country" /><br />
    state:  <input type="text" name="state" id="state" placeholder="state" /><br />
    Address: <textarea name="address" id="address"></textarea><br />
    Postcode: <input type="text" name="post_code" id="post_code" /><br />
    Mobile: <input type="text" name="mobile" id="mobile" /><br />   
    <input type="submit" name="submit" value="ok" />
</form>

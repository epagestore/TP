<?php echo form_open('','name="business_registration" id="form-business_registration"')?>
	Name: <input type="text" name="fname" id="fname" placeholder="Firts name" /> <input type="text" name="lname" id="lname" placeholder="Last name" /><br />
    Email:  <input type="text" name="email" id="email" placeholder="Email" /><br />
    Password:  <input type="password" name="pass" id="pass"  /><br />
    country:  <input type="text" name="country" id="country" placeholder="Country" /><br />
    state:  <input type="text" name="state" id="state" placeholder="state" /><br />
    Address: <textarea name="address" id="address"></textarea><br />
    Postcode: <input type="text" name="post_code" id="post_code" /><br />
    Mobile: <input type="text" name="mobile" id="mobile" /><br />
    <div id="company_information">
        Company name: <input type="text" name="company_name" id="company_name" /><br />
        Company website: <input type="text" name="company_website" id="company_website" /><br />
        Company adress: <input type="text" name="cmp_address" id="cmp_address" /><br />
        Company state:  <input type="text" name="cmp_state" id="cmp_state" placeholder="company state" /><br />
        Company Postcode: <input type="text" name="cmp_post_code" id="cmp_post_code" /><br />
    </div>
    <input type="submit" name="submit" value="ok" />
</form>
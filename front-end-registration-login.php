<?php
/*
Plugin Name: Front End Registration and Login
Plugin URI: 
Description: Provides simple front end registration and login forms
Version: 1.0
Author: Ismail Hossain
*/

require_once('disable-user.php');

// user registration login form
function pippin_registration_form() {
 
	// only show the registration form to non-logged-in members
	//if(!is_user_logged_in()) {
	{
 
		global $pippin_load_css;
 
		// set this to true so the CSS is loaded
		$pippin_load_css = true;
 
		// check to make sure user registration is enabled
		$registration_enabled = get_option('users_can_register');
 
		// only show the registration form if allowed
		if($registration_enabled) {
			$output = pippin_registration_form_fields();
		} else {
			$output = __('User registration is not enabled');
		}
		return $output;
	}
}
add_shortcode('register_form', 'pippin_registration_form');


// registration form fields
function pippin_registration_form_fields() {
 
	ob_start(); ?>

<h3 class="pippin_header">
  <?php //_e('Register New Account'); ?>
</h3>
<?php 
		// show any error messages after form submission
		pippin_show_error_messages(); ?>
<form id="marathon_registration_form" class="registration_form" action="" method="POST">
  
  <!--form fields here-->
  <div class="row">
    <div class="col-sm-12 text-center mb-30">
      <h3 data-text-color="#219b48"><strong>ALEH Ascend Marathon Registarion</strong></h3>
    </div>
    <div class="col-sm-6">
      <div class="form-group">
        <label for="f_name">First Name <span class="red-star">*</span></label>
        <input type="text" class="form-control" required="" name="runner_first_name" id="runner_first_name" placeholder="John">
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-sm-6">
      <div class="form-group">
        <label for="l_name">Last Name <span class="red-star">*</span></label>
        <input type="text" class="form-control" required="" name="runner_last_name" id="runner_last_name" placeholder="Smith">
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-sm-6">
      <div class="form-group">
        <label for="address">Address <span class="red-star">*</span></label>
        <input type="text" class="form-control" required="" name="runner_address1" id="runner_address1" placeholder="9009 Woodwerd Way">
      </div>
    </div>
    <div class="col-sm-6">
      <div class="form-group">
        <label for="address">.</label>
        <input type="text" class="form-control" name="runner_address2" id="runner_address2" placeholder="Address Line #2">
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-sm-6">
      <div class="form-group">
        <label for="city">City <span class="red-star">*</span></label>
        <input type="tel" class="form-control" required="" name="runner_city" id="runner_city" placeholder="">
        <!--<select name="runner_city" class="form-control" id="runner_city">
          <option value="Please Select">Please Select Your City</option>
          <option value="">city 1</option>
          <option value="">city 2</option>
        </select>-->
      </div>
    </div>
    <div class="col-sm-3 col-md-offset-3">
      <div class="form-group">
        <label for="zipcode">Zipcode <span class="red-star">*</span></label>
        <input type="text" class="form-control" required="" name="runner_zipcode" id="runner_zipcode" placeholder="33483">
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-sm-6">
      <div class="form-group">
        <label for="p_number">Phone Number <span class="red-star">*</span></label>
        <input type="tel" class="form-control" required="" name="runner_phonenumber" id="runner_phonenumber" placeholder="(770 493-3934)">
      </div>
    </div>
    <div class="col-sm-6">
      <div class="form-group">
        <label for="city">Country <span class="red-star">*</span></label>
        <select name="runner_country" class="form-control" id="runner_country">
          <option value="Please Select">Select Your Country</option>
          <?php
						$runner_country_select = runner_add_country_select();
						foreach($runner_country_select as $each_country){
							echo '<option value="'.$each_country.'">'.$each_country.'</option>';
						}
					?>
        </select>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-sm-6">
      <div class="form-group">
        <label for="p_number">Email Address <span class="red-star">*</span></label>
        <input type="email" class="form-control" required="" name="user_email" id="user_email" placeholder="danny@dsquaredmedia.net">
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-sm-4">
      <div class="form-group">
        <label for="p_number">Gender <span class="red-star">*</span></label>
        <div>
          <label class="radio-inline">
            <input type="radio" value="Male" name="runner_gender">
            Male </label>
          <label class="radio-inline">
            <input type="radio" value="Female" name="runner_gender">
            Female </label>
        </div>
      </div>
    </div>
    <div class="col-sm-8">
      <div class="form-group">
        <label for="birthday">Birthday <span class="red-star">*</span></label>
        <div class="row">
          <div class="col-xs-4">
            <div class="form-group">
              <select name="birth_month" class="form-control">
                <option value="Please Select">Select Month</option>
                <?php
									// lowest year wanted
									$cutoff = 1910;						
									// current year
									$now = date('Y');
									for ($m=1; $m<=12; $m++) {
											echo '  <option value="' . $m . '">' . date('M', mktime(0,0,0,$m)) . '</option>' . PHP_EOL;
									}
								?>
              </select>
            </div>
          </div>
          <div class="col-xs-4">
            <div class="form-group">
              <select name="birth_day" class="form-control">
                <option value="Please Select">Select Date</option>
                <?php
									for ($d=1; $d<=31; $d++) {
											echo '  <option value="' . $d . '">' . $d . '</option>' . PHP_EOL;
									}
								?>
              </select>
            </div>
          </div>
          <div class="col-xs-4">
            <div class="form-group">
              <select name="birth_year" class="form-control">
                <option value="Please Select">Select year</option>
                <?php
									for ($y=$now; $y>=$cutoff; $y--) {
											echo '  <option value="' . $y . '">' . $y . '</option>' . PHP_EOL;
									}
								?>
              </select>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-sm-6">
      <div class="form-group">
        <label for="f_name"> Passport or Israeli ID (Teudat Zehut) number: <span class="red-star">*</span></label>
        <input type="text" class="form-control" required="" name="passport_or_israeli_id" id="passport_or_israeli_id" placeholder="">
      </div>
    </div>
  </div>
  
  
  <div class="row">
    <div class="col-sm-10 col-sm-offset-1 mt-30 mb-30">
      <hr>
    </div>
  </div>
    
  
  <div class="row">
    <div class="col-sm-12 text-center mt-30 mb-30">
      <h3 data-text-color="#219b48"><strong>Emergency Contact Information</strong></h3>
    </div>
  </div>
  <div class="row">
    <div class="col-sm-6">
      <div class="form-group">
        <label for="f_name">Full Name <span class="red-star">*</span></label>
        <input type="text" class="form-control" required="" name="emergency_contact_name" id="emergency_contact_name" placeholder="John">
      </div>
    </div>
    <div class="col-sm-6">
      <div class="form-group">
        <label for="p_">Phone Number <span class="red-star">*</span></label>
        <input type="tel" class="form-control" required="" name="emergency_contact_phone_number" id="emergency_contact_phone_number" placeholder="(770) 493-3934">
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-sm-6">
      <div class="form-group">
        <label for="f_name">Relationship <span class="red-star">*</span></label>
        <input type="text" class="form-control" required="" name="emergency_contact_relationship" id="emergency_contact_relationship" placeholder="Type">
      </div>
    </div>
  </div>
  
  <div class="row">
    <div class="col-sm-10 col-sm-offset-1 mt-30 mb-30">
      <hr>
    </div>
  </div>
  
  <div class="row">
    <div class="col-sm-12 text-center mt-30 mb-30">
      <h3 data-text-color="#219b48"><strong>General Marathon Information</strong></h3>
    </div>
  </div>
  <div class="row">
    <div class="col-sm-6">
      <h4><strong>What Marathon would you like to participate in:</strong> </h4>
      <div class="radio">
        <label>
          <input type="radio" name="what_marathon_like_to_participate" value="Jerusalem Marathon">
          Jerusalem Marathon</label>
      </div>
      <div class="radio">
        <label>
          <input type="radio" name="what_marathon_like_to_participate" value="Berlin Marathon">
          Berlin Marathon</label>
      </div>
      <div class="radio">
        <label>
          <input type="radio" name="what_marathon_like_to_participate" value="Chicago Marathon">
          Chicago Marathon</label>
      </div>
      <div class="radio">
        <label>
          <input type="radio" name="what_marathon_like_to_participate" value="NYC Marathon">
          NYC Marathon</label>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-sm-6">
      <h4><strong>Are you participating in (choose one):</strong></h4>
      <div class="radio">
        <label>
          <input type="radio" name="are_you_participating_in_range" value="10k" >
          10k</label>
      </div>
      <div class="radio">
        <label>
          <input type="radio" name="are_you_participating_in_range" value="1/2 marathon">
          1/2 marathon</label>
      </div>
      <div class="radio">
        <label>
          <input type="radio" name="are_you_participating_in_range" value="Full Marathon">
          Full Marathon</label>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-sm-6">
      <h4><strong>What is your average race time?</strong></h4>
      <div class="radio">
        <label>
          <input type="radio" name="what_is_your_average_race_time" value="1-1.5 hours" >
          1-1.5 hours</label>
      </div>
      <div class="radio">
        <label>
          <input type="radio" name="what_is_your_average_race_time" value="1.5-2 hours">
          1.5-2 hours</label>
      </div>
      <div class="radio">
        <label>
          <input type="radio" name="what_is_your_average_race_time" value="2.5-3 hours">
          2.5-3 hours</label>
      </div>
      <div class="radio">
        <label>
          <input type="radio" name="what_is_your_average_race_time" value="3.5-4 hours">
          3.5-4 hours</label>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-sm-12">
      <h4><strong>ALEH Ascend T-shirt order:</strong></h4>
    </div>
    <div class="col-sm-4">
      <p>Your size <span class="red-star">*</span></p>
      <div class="radio">
        <label>
          <input type="radio" name="tshirt_order_your_size" value="XS">
          XS</label>
      </div>
      <div class="radio">
        <label>
          <input type="radio" name="tshirt_order_your_size" value="Small">
          Small</label>
      </div>
      <div class="radio">
        <label>
          <input type="radio" name="tshirt_order_your_size" value="Medium">
          Medium</label>
      </div>
      <div class="radio">
        <label>
          <input type="radio" name="tshirt_order_your_size" value="Large">
          Large</label>
      </div>
      <div class="radio">
        <label>
          <input type="radio" name="tshirt_order_your_size" value="Xlarge">
          Xlarge</label>
      </div>
    </div>
    <div class="col-sm-4">
      <p>Gender <span class="red-star">*</span></p>
      <div class="radio">
        <label>
          <input type="radio" name="tshirt_order_gender" value="Male">
          Male</label>
      </div>
      <div class="radio">
        <label>
          <input type="radio" name="tshirt_order_gender" value="Female">
          Female</label>
      </div>
    </div>
    <div class="col-sm-4">
      <p>Sleeves <span class="red-star">*</span></p>
      <div class="radio">
        <label>
          <input type="radio" name="tshirt_order_sleeves" value="Short sleeve">
          Short sleeve </label>
      </div>
      <div class="radio">
        <label>
          <input type="radio" name="tshirt_order_sleeves" value="Long sleeve">
          Long sleeve </label>
      </div>
    </div>
  </div>
  
  
  <div class="row">
    <div class="col-sm-10 col-sm-offset-1 mt-30 mb-30">
      <hr>
    </div>
  </div>
  
  
  <div class="row">
    <div class="col-sm-12 text-center mt-30 mb-30">
      <h3 data-text-color="#219b48"><strong>Create your own personal login page</strong></h3>
    </div>
  </div>
  
  <div class="row">
    <div class="col-sm-10 col-sm-offset-1">
      <div class="row">
        <div class="col-sm-4">
          <div class="form-group">
            <label for="p_number">Username <span class="red-star">*</span></label>
            <input type="text" class="form-control" required="" name="runner_username" id="runner_username" placeholder="ddonov9342">
          </div>
        </div>
        <div class="col-sm-4">
          <div class="form-group">
            <label for="city">Password <span class="red-star">*</span></label>
            <input type="password" class="form-control" required="" name="runner_password" id="runner_password" placeholder="******">
          </div>
        </div>
        <div class="col-sm-4">
          <div class="form-group">
            <label for="city">Retype Password <span class="red-star">*</span></label>
            <input type="password" class="form-control" required="" name="runner_retype_password" id="runner_retype_password" placeholder="******">
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-12">
          <div class="form-group">
            <div class="checkbox">
              <label>
                <input type="checkbox" name="agree_terms" id="agree_terms" value="agree">
                By Registering your  agreeing to <a target="_blank" href="<?php echo home_url('/terms-of-service/')?>">Your Website Here Terms of Service </a> </label>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  
   
  
  <div class="row">
    <div class="col-sm-12 text-center mt-30 mb-30">
      <input type="hidden" name="pippin_register_nonce" value="<?php echo wp_create_nonce('pippin-register-nonce'); ?>"/>
      <input type="submit" value="<?php _e('REGISTER'); ?>"/>
    </div>
  </div>
</form>

<script>
jQuery("#marathon_registration_form").submit(function(e) {
    if(!jQuery('#agree_terms:checked').length) {
        alert("Please select Terms of Service.");
        //stop the form from submitting
        return false;
    }

    return true;
});
</script>

<?php
	return ob_get_clean();
}



// register a new user
function pippin_add_new_member() {
  	if (isset( $_POST["runner_username"] ) && wp_verify_nonce($_POST['pippin_register_nonce'], 'pippin-register-nonce')) {
		//print_r($_POST); die;
					
		$runner_first_name		= $_POST["runner_first_name"];
		$runner_last_name		= $_POST["runner_last_name"];
		$runner_address1		= $_POST["runner_address1"];			
		$runner_address2		= $_POST["runner_address2"];
		
		$runner_city		= $_POST["runner_city"];
		$runner_zipcode		= $_POST["runner_zipcode"];
		$runner_phonenumber		= $_POST["runner_phonenumber"];			
		$runner_country		= $_POST["runner_country"];
		
		$user_email		= $_POST["user_email"];
		$runner_gender		= $_POST["runner_gender"];	
		$passport_or_israeli_id		= $_POST["passport_or_israeli_id"];
				
		$birth_month		= $_POST["birth_month"];
		$birth_day		= $_POST["birth_day"];
		$birth_year		= $_POST["birth_year"];
			
		
		$emergency_contact_name		= $_POST["emergency_contact_name"];
		$emergency_contact_phone_number		= $_POST["emergency_contact_phone_number"];			
		$emergency_contact_relationship		= $_POST["emergency_contact_relationship"];
		
		$what_marathon_like_to_participate		= $_POST["what_marathon_like_to_participate"];
		$are_you_participating_in_range		= $_POST["are_you_participating_in_range"];
		$what_is_your_average_race_time		= $_POST["what_is_your_average_race_time"];
		
		$tshirt_order_your_size		= $_POST["tshirt_order_your_size"];
		$tshirt_order_gender		= $_POST["tshirt_order_gender"];
		$tshirt_order_sleeves		= $_POST["tshirt_order_sleeves"];
		
		$runner_username		= $_POST["runner_username"];
		$runner_password		= $_POST["runner_password"];
		$runner_retype_password		= $_POST["runner_retype_password"];
		
		$agree_terms		= $_POST["agree_terms"];
		
		
		// this is required for username checks
		require_once(ABSPATH . WPINC . '/registration.php');
 
		if(username_exists($runner_username)) {
			// Username already registered
			pippin_errors()->add('username_unavailable', __('Username already taken'));
		}
		if(!validate_username($runner_username)) {
			// invalid username
			pippin_errors()->add('username_invalid', __('Invalid username'));
		}
		if($runner_username == '') {
			// empty username
			pippin_errors()->add('username_empty', __('Please enter a username'));
		}
		if(!is_email($user_email)) {
			//invalid email
			pippin_errors()->add('email_invalid', __('Invalid email'));
		}
		if(email_exists($user_email)) {
			//Email address already registered
			pippin_errors()->add('email_used', __('Email already registered'));
		}
		if($runner_password == '') {
			// passwords do not match
			pippin_errors()->add('password_empty', __('Please enter a password'));
		}
		if($runner_password != $runner_retype_password) {
			// passwords do not match
			pippin_errors()->add('password_mismatch', __('Passwords do not match'));
		}
		if($agree_terms == '') {
			// confirm terms of service
			pippin_errors()->add('confirm_terms', __('Please confirm Terms of Service'));
		}
 
		$errors = pippin_errors()->get_error_messages();
 
		// only create the user in if there are no errors
		if(empty($errors)) {
			$new_user_id = wp_insert_user(array(
					'user_login'		=> $runner_username,
					'user_pass'	 		=> $runner_password,
					'user_email'		=> $user_email,
					'first_name'		=> $runner_first_name,
					'last_name'			=> $runner_last_name,
					'user_registered'	=> date('Y-m-d H:i:s'),
					'role'				=> 'subscriber'
				)
			);
			//disable user
			update_user_meta( $new_user_id, 'ja_disable_user', 1 );
			
			//user meta
			update_user_meta($new_user_id, 'allowed_to_get_fund', 1);
			update_user_meta($new_user_id, 'runner_address1', esc_attr($runner_address1));
			update_user_meta($new_user_id, 'runner_address2', esc_attr($runner_address2));
			update_user_meta($new_user_id, 'runner_city', esc_attr($runner_city));
			update_user_meta($new_user_id, 'runner_zipcode', esc_attr($runner_zipcode));
			update_user_meta($new_user_id, 'runner_phonenumber', esc_attr($runner_phonenumber));
			update_user_meta($new_user_id, 'runner_country', esc_attr($runner_country));
			
			update_user_meta($new_user_id, 'runner_gender', esc_attr($runner_gender));
			update_user_meta($new_user_id, 'passport_or_israeli_id', esc_attr($passport_or_israeli_id));
			update_user_meta($new_user_id, 'date_of_birth', $birth_year.''.$birth_month.''.$birth_day);
			
			update_user_meta($new_user_id, 'emergency_contact_name', esc_attr($emergency_contact_name));
			update_user_meta($new_user_id, 'emergency_contact_phone_number', esc_attr($emergency_contact_phone_number));
			update_user_meta($new_user_id, 'emergency_contact_relationship', esc_attr($emergency_contact_relationship));
			
			
			update_user_meta($new_user_id, 'what_marathon_like_to_participate', esc_attr($what_marathon_like_to_participate));
			update_user_meta($new_user_id, 'are_you_participating_in_range', esc_attr($are_you_participating_in_range));
			update_user_meta($new_user_id, 'what_is_your_average_race_time', esc_attr($what_is_your_average_race_time));
			update_user_meta($new_user_id, 'tshirt_order_your_size', esc_attr($tshirt_order_your_size));
			update_user_meta($new_user_id, 'tshirt_order_gender', esc_attr($tshirt_order_gender));
			update_user_meta($new_user_id, 'tshirt_order_sleeves', esc_attr($tshirt_order_sleeves));
			
      update_user_meta($new_user_id, 'runner_funding_goal', 0);
      update_user_meta($new_user_id, 'runner_pledged', 0);
			update_user_meta($new_user_id, 'runner_fundraising_end_date', date("Ymd"));
			
			//fake post linked to runner
			linkFakePostToRunner($new_user_id);
			
			//user activation_link
			if ( $new_user_id && !is_wp_error( $new_user_id ) ) {
          //Add repeater field for donation_history (initialize after new reg)
          $event_field_key = 'field_56a8a88487810';
          $events[] = array(
              'donation_history' => array(
                  array(
                      "donation_history_donated_by" => '',
                      "donation_history_donated_amount_usd" => '',
                      "donation_history_donated_currency" => '',
                      "donation_history_donated_amount_in_currency" => ''
                  )
              )
          );
          update_field( $event_field_key, $events, "user_".$new_user_id );


          //sendmail
					$code = sha1( $new_user_id . time() );
					$arr_params = array( 'activatekey' => $code, 'user' => $new_user_id );
					$activation_link = add_query_arg( $arr_params, home_url('/activation/'));
					add_user_meta( $new_user_id, 'has_to_be_activated', $code, true );
					
					//send email to the registered user with the attached files:
					// Additional headers
					$headers = 'Content-Type: text/html; charset=UTF-8';	
					$headers  = 'MIME-Version: 1.0' . "\r\n";
					$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
					$headers .= 'From: Aleh Ascend <info@runforaleh.org>';
					
					$body = 'You have registered as '.$runner_username.'. To activate your account, please click the following link: <a href="' . $activation_link.'">' . $activation_link.'</a><br>';
					$body .= 'Verify your account by pressing this link or copying into your browser';
					//mail( $user_email, 'Activate your account | ALEH Ascend', $body, $headers );	
				
					$attachments = array( 
						WP_CONTENT_DIR . '/uploads/2015/11/Fundraising-letter-for-ALEH-Ascend-UPDATED.docx',
						WP_CONTENT_DIR . '/uploads/2015/11/Welcome-Letter-to-ALEH-Ascend-UPDATED.docx'
					);
					$subject = 'Activate your account | ALEH Ascend';
					wp_mail( $user_email, $subject, $body, $headers, $attachments  );		
			}
			
			if($new_user_id) {
				// send an email to the admin alerting them of the registration
				//wp_new_user_notification($new_user_id);
 
				// log the new user in
				//wp_setcookie($user_login, $user_pass, true);
				//wp_set_current_user($new_user_id, $user_login);	
				//do_action('wp_login', $user_login);
				
				//send email
				$headers = 'Content-Type: text/html; charset=UTF-8';

				// To send HTML mail, the Content-type header must be set
				$headers  = 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
				// Additional headers
				$headers .= 'From: Aleh Ascend <info@runforaleh.org>';


				$admin_email = get_option( 'admin_email' );
				$subject = 'New User Registration | Aleh Ascend';
				$body = '<h2>ALEH Ascend Marathon Registarion</h2>'.'<br>';
				$body .= '<h4>Basic Info:'.'<br>';
				$body .= '--------------------</h4>';
				$body .= 'Username: '.$runner_username.'<br>' ;
				$body .= 'First Name: '.$runner_first_name.'<br>' ;
				$body .= 'Last Name: '.$runner_last_name.'<br>' ;
				$body .= 'Address: '.$runner_address1.' '.$runner_address2.'<br>' ;
				$body .= 'City: '.$runner_city.'<br>' ;
				$body .= 'Zipcode: '.$runner_zipcode.'<br>' ;
				
				$body .= 'Phone Number: '.$runner_phonenumber.'<br>' ;
				$body .= 'Country: '.$runner_country.'<br>' ;
				$body .= 'Email Address: '.$user_email.'<br>' ;
				$body .= 'Gender: '.$runner_gender.'<br>' ;
				$body .= 'Birthday: '.$birth_month.'/'.$birth_day.'/'.$birth_year.'<br>' ;
				$body .= 'Passport or Israeli ID (Teudat Zehut) number: '.$passport_or_israeli_id.'<br>' ;
				
				$body .= '<h4>Emergency Contact Information:'.'<br>';
				$body .= '--------------------</h4>';
				$body .= 'Full Name: '.$emergency_contact_name.'<br>' ;
				$body .= 'Phone Number: '.$emergency_contact_phone_number.'<br>' ;
				$body .= 'Relationship: '.$emergency_contact_relationship.'<br>' ;
				
				$body .= '<h4>General Marathon Information:'.'<br>';
				$body .= '--------------------</h4>';
				$body .= 'What Marathon would you like to participate in: '.$what_marathon_like_to_participate.'<br>' ;
				$body .= 'Are you participating in (choose one): '.$are_you_participating_in_range.'<br>' ;
				$body .= 'What is your average race time? '.$what_is_your_average_race_time.'<br>' ;
				$body .= '<h4>ALEH Ascend T-shirt order:'.'<br>';
				$body .= '--------------------</h4>';
				$body .= 'Your size: '.$tshirt_order_your_size.'<br>' ;
				$body .= 'Gender: '.$tshirt_order_gender.'<br>' ;
				$body .= 'Sleeves: '.$tshirt_order_sleeves.'<br>' ;
				$body .= '---' ;
				
				wp_mail( $admin_email, $subject, $body, $headers );
				
				// send the newly created user to the home page after logging them in
				wp_redirect(home_url('/regsuccess/')); exit;
			}
 
		}
 
	}
}
add_action('init', 'pippin_add_new_member');


// used for tracking error messages
function pippin_errors(){
    static $wp_error; // Will hold global variable safely
    return isset($wp_error) ? $wp_error : ($wp_error = new WP_Error(null, null, null));
}

// displays error messages from form submissions
function pippin_show_error_messages() {
	if($codes = pippin_errors()->get_error_codes()) {
		echo '<div class="pippin_errors">';
		    // Loop error codes and display errors
		   foreach($codes as $code){
		        $message = pippin_errors()->get_error_message($code);
		        echo '<span class="error"><strong>' . __('Error') . '</strong>: ' . $message . '</span><br/>';
		    }
		echo '</div>';
	}	
}


// register our form css
function pippin_register_css() {
	wp_register_style('pippin-form-css', plugin_dir_url( __FILE__ ) . '/css/forms.css');
}
add_action('init', 'pippin_register_css');


// load our form css
function pippin_print_css() {
	global $pippin_load_css;
 
	// this variable is set to TRUE if the short code is used on a page/post
	if ( ! $pippin_load_css )
		return; // this means that neither short code is present, so we get out of here
 
	wp_print_styles('pippin-form-css');
}
add_action('wp_footer', 'pippin_print_css');




// user login form
function pippin_login_form() {
 
	if(!is_user_logged_in()) {
 
		global $pippin_load_css;
 
		// set this to true so the CSS is loaded
		$pippin_load_css = true;
 
		$output = pippin_login_form_fields();
	} else {
		// could show some logged in user info here
		// $output = 'user info here';
	}
	return $output;
}
add_shortcode('login_form', 'pippin_login_form');

// login form fields
function pippin_login_form_fields() {
 
	ob_start(); ?>
<h3 class="pippin_header">
  <?php _e('Login'); ?>
</h3>
<?php
		// show any error messages after form submission
		pippin_show_error_messages(); ?>
<form id="pippin_login_form"  class="pippin_form"action="" method="post">
  <fieldset>
    <p>
      <label for="pippin_user_Login">Username</label>
      <input name="pippin_user_login" id="pippin_user_login" class="required" type="text"/>
    </p>
    <p>
      <label for="pippin_user_pass">Password</label>
      <input name="pippin_user_pass" id="pippin_user_pass" class="required" type="password"/>
    </p>
    <p>
      <input type="hidden" name="pippin_login_nonce" value="<?php echo wp_create_nonce('pippin-login-nonce'); ?>"/>
      <input id="pippin_login_submit" type="submit" value="Login"/>
    </p>
  </fieldset>
</form>
<?php
	return ob_get_clean();
}


// logs a member in after submitting a form
function pippin_login_member() {
 
	if(isset($_POST['pippin_user_login']) && wp_verify_nonce($_POST['pippin_login_nonce'], 'pippin-login-nonce')) {
 
		// this returns the user ID and other info from the user name
		$user = get_userdatabylogin($_POST['pippin_user_login']);
 
		if(!$user) {
			// if the user name doesn't exist
			pippin_errors()->add('empty_username', __('Invalid username'));
		}
 
		if(!isset($_POST['pippin_user_pass']) || $_POST['pippin_user_pass'] == '') {
			// if no password was entered
			pippin_errors()->add('empty_password', __('Please enter a password'));
		}
 
		// check the user's login with their password
		if(!wp_check_password($_POST['pippin_user_pass'], $user->user_pass, $user->ID)) {
			// if the password is incorrect for the specified user
			pippin_errors()->add('empty_password', __('Incorrect password'));
		}
 
		// retrieve all error messages
		$errors = pippin_errors()->get_error_messages();
 
		// only log the user in if there are no errors
		if(empty($errors)) {
 
			wp_setcookie($_POST['pippin_user_login'], $_POST['pippin_user_pass'], true);
			wp_set_current_user($user->ID, $_POST['pippin_user_login']);	
			do_action('wp_login', $_POST['pippin_user_login']);
 
			wp_redirect(home_url()); exit;
		}
	}
}
add_action('init', 'pippin_login_member');




function runner_add_country_select(){

    $_countries = array(
      "GB" => "United Kingdom",
      "US" => "United States",
      "AF" => "Afghanistan",
      "AL" => "Albania",
      "DZ" => "Algeria",
      "AS" => "American Samoa",
      "AD" => "Andorra",
      "AO" => "Angola",
      "AI" => "Anguilla",
      "AQ" => "Antarctica",
      "AG" => "Antigua And Barbuda",
      "AR" => "Argentina",
      "AM" => "Armenia",
      "AW" => "Aruba",
      "AU" => "Australia",
      "AT" => "Austria",
      "AZ" => "Azerbaijan",
      "BS" => "Bahamas",
      "BH" => "Bahrain",
      "BD" => "Bangladesh",
      "BB" => "Barbados",
      "BY" => "Belarus",
      "BE" => "Belgium",
      "BZ" => "Belize",
      "BJ" => "Benin",
      "BM" => "Bermuda",
      "BT" => "Bhutan",
      "BO" => "Bolivia",
      "BA" => "Bosnia And Herzegowina",
      "BW" => "Botswana",
      "BV" => "Bouvet Island",
      "BR" => "Brazil",
      "IO" => "British Indian Ocean Territory",
      "BN" => "Brunei Darussalam",
      "BG" => "Bulgaria",
      "BF" => "Burkina Faso",
      "BI" => "Burundi",
      "KH" => "Cambodia",
      "CM" => "Cameroon",
      "CA" => "Canada",
      "CV" => "Cape Verde",
      "KY" => "Cayman Islands",
      "CF" => "Central African Republic",
      "TD" => "Chad",
      "CL" => "Chile",
      "CN" => "China",
      "CX" => "Christmas Island",
      "CC" => "Cocos (Keeling) Islands",
      "CO" => "Colombia",
      "KM" => "Comoros",
      "CG" => "Congo",
      "CD" => "Congo, The Democratic Republic Of The",
      "CK" => "Cook Islands",
      "CR" => "Costa Rica",
      "CI" => "Cote D'Ivoire",
      "HR" => "Croatia (Local Name: Hrvatska)",
      "CU" => "Cuba",
      "CY" => "Cyprus",
      "CZ" => "Czech Republic",
      "DK" => "Denmark",
      "DJ" => "Djibouti",
      "DM" => "Dominica",
      "DO" => "Dominican Republic",
      "TP" => "East Timor",
      "EC" => "Ecuador",
      "EG" => "Egypt",
      "SV" => "El Salvador",
      "GQ" => "Equatorial Guinea",
      "ER" => "Eritrea",
      "EE" => "Estonia",
      "ET" => "Ethiopia",
      "FK" => "Falkland Islands (Malvinas)",
      "FO" => "Faroe Islands",
      "FJ" => "Fiji",
      "FI" => "Finland",
      "FR" => "France",
      "FX" => "France, Metropolitan",
      "GF" => "French Guiana",
      "PF" => "French Polynesia",
      "TF" => "French Southern Territories",
      "GA" => "Gabon",
      "GM" => "Gambia",
      "GE" => "Georgia",
      "DE" => "Germany",
      "GH" => "Ghana",
      "GI" => "Gibraltar",
      "GR" => "Greece",
      "GL" => "Greenland",
      "GD" => "Grenada",
      "GP" => "Guadeloupe",
      "GU" => "Guam",
      "GT" => "Guatemala",
      "GN" => "Guinea",
      "GW" => "Guinea-Bissau",
      "GY" => "Guyana",
      "HT" => "Haiti",
      "HM" => "Heard And Mc Donald Islands",
      "VA" => "Holy See (Vatican City State)",
      "HN" => "Honduras",
      "HK" => "Hong Kong",
      "HU" => "Hungary",
      "IS" => "Iceland",
      "IN" => "India",
      "ID" => "Indonesia",
      "IR" => "Iran (Islamic Republic Of)",
      "IQ" => "Iraq",
      "IE" => "Ireland",
      "IL" => "Israel",
      "IT" => "Italy",
      "JM" => "Jamaica",
      "JP" => "Japan",
      "JO" => "Jordan",
      "KZ" => "Kazakhstan",
      "KE" => "Kenya",
      "KI" => "Kiribati",
      "KP" => "Korea, Democratic People's Republic Of",
      "KR" => "Korea, Republic Of",
      "KW" => "Kuwait",
      "KG" => "Kyrgyzstan",
      "LA" => "Lao People's Democratic Republic",
      "LV" => "Latvia",
      "LB" => "Lebanon",
      "LS" => "Lesotho",
      "LR" => "Liberia",
      "LY" => "Libyan Arab Jamahiriya",
      "LI" => "Liechtenstein",
      "LT" => "Lithuania",
      "LU" => "Luxembourg",
      "MO" => "Macau",
      "MK" => "Macedonia, Former Yugoslav Republic Of",
      "MG" => "Madagascar",
      "MW" => "Malawi",
      "MY" => "Malaysia",
      "MV" => "Maldives",
      "ML" => "Mali",
      "MT" => "Malta",
      "MH" => "Marshall Islands",
      "MQ" => "Martinique",
      "MR" => "Mauritania",
      "MU" => "Mauritius",
      "YT" => "Mayotte",
      "MX" => "Mexico",
      "FM" => "Micronesia, Federated States Of",
      "MD" => "Moldova, Republic Of",
      "MC" => "Monaco",
      "MN" => "Mongolia",
      "MS" => "Montserrat",
      "MA" => "Morocco",
      "MZ" => "Mozambique",
      "MM" => "Myanmar",
      "NA" => "Namibia",
      "NR" => "Nauru",
      "NP" => "Nepal",
      "NL" => "Netherlands",
      "AN" => "Netherlands Antilles",
      "NC" => "New Caledonia",
      "NZ" => "New Zealand",
      "NI" => "Nicaragua",
      "NE" => "Niger",
      "NG" => "Nigeria",
      "NU" => "Niue",
      "NF" => "Norfolk Island",
      "MP" => "Northern Mariana Islands",
      "NO" => "Norway",
      "OM" => "Oman",
      "PK" => "Pakistan",
      "PW" => "Palau",
      "PA" => "Panama",
      "PG" => "Papua New Guinea",
      "PY" => "Paraguay",
      "PE" => "Peru",
      "PH" => "Philippines",
      "PN" => "Pitcairn",
      "PL" => "Poland",
      "PT" => "Portugal",
      "PR" => "Puerto Rico",
      "QA" => "Qatar",
      "RE" => "Reunion",
      "RO" => "Romania",
      "RU" => "Russian Federation",
      "RW" => "Rwanda",
      "KN" => "Saint Kitts And Nevis",
      "LC" => "Saint Lucia",
      "VC" => "Saint Vincent And The Grenadines",
      "WS" => "Samoa",
      "SM" => "San Marino",
      "ST" => "Sao Tome And Principe",
      "SA" => "Saudi Arabia",
      "SN" => "Senegal",
      "SC" => "Seychelles",
      "SL" => "Sierra Leone",
      "SG" => "Singapore",
      "SK" => "Slovakia (Slovak Republic)",
      "SI" => "Slovenia",
      "SB" => "Solomon Islands",
      "SO" => "Somalia",
      "ZA" => "South Africa",
      "GS" => "South Georgia, South Sandwich Islands",
      "ES" => "Spain",
      "LK" => "Sri Lanka",
      "SH" => "St. Helena",
      "PM" => "St. Pierre And Miquelon",
      "SD" => "Sudan",
      "SR" => "Suriname",
      "SJ" => "Svalbard And Jan Mayen Islands",
      "SZ" => "Swaziland",
      "SE" => "Sweden",
      "CH" => "Switzerland",
      "SY" => "Syrian Arab Republic",
      "TW" => "Taiwan",
      "TJ" => "Tajikistan",
      "TZ" => "Tanzania, United Republic Of",
      "TH" => "Thailand",
      "TG" => "Togo",
      "TK" => "Tokelau",
      "TO" => "Tonga",
      "TT" => "Trinidad And Tobago",
      "TN" => "Tunisia",
      "TR" => "Turkey",
      "TM" => "Turkmenistan",
      "TC" => "Turks And Caicos Islands",
      "TV" => "Tuvalu",
      "UG" => "Uganda",
      "UA" => "Ukraine",
      "AE" => "United Arab Emirates",
      "UM" => "United States Minor Outlying Islands",
      "UY" => "Uruguay",
      "UZ" => "Uzbekistan",
      "VU" => "Vanuatu",
      "VE" => "Venezuela",
      "VN" => "Viet Nam",
      "VG" => "Virgin Islands (British)",
      "VI" => "Virgin Islands (U.S.)",
      "WF" => "Wallis And Futuna Islands",
      "EH" => "Western Sahara",
      "YE" => "Yemen",
      "YU" => "Yugoslavia",
      "ZM" => "Zambia",
      "ZW" => "Zimbabwe"
    );
   /* Default country is ZW (Zimbabwe) set as an example */
   $country_select = array(
    'name'    => __('Country', 'my_lang'),
    'validate'=> 'esu-required',
    'id'      => 'country_select',
    'class'   => 'esu-country-select',
    'type'    => 'select',
    'options' => $_countries,
    'default' => 'US'
    );
    //return array(  'country_select' => $country_select );
    return $_countries;
}
add_filter( 'gform_field_validation_3_3', 'custom_validation', 10, 4 );
function custom_validation( $result, $value, $form, $field ) {
      global $wpdb;
	    $submitted_value = $value; // Assuming the field ID is 3

    $entry_meta_table = $wpdb->prefix . 'gf_entry_meta';
    $exists_query = $wpdb->prepare("SELECT COUNT(*) FROM $entry_meta_table WHERE form_id = %d AND meta_value = %s", 2, $submitted_value);
    $entry_count = $wpdb->get_var($exists_query);
    error_log("Submitted value: $submitted_value, Count in DB: $entry_count");

    if ( $result['is_valid'] && $entry_count== 0 ) {
        $result['is_valid'] = false;
//         $result['message'] = 'شماره سریال معتبر نمی باشد . ';
		        $result['message'] = '<span style="color: #DC0225;">شماره سریال معتبر نمی‌باشد.</span>';

    }
    return $result;
}

add_filter( 'gform_field_validation_2_21', 'custom_validation_21', 10, 4 );
function custom_validation_21( $result, $value, $form, $field ) {
      global $wpdb;
	    $submitted_value = $value; // Assuming the field ID is 3

    $entry_meta_table = $wpdb->prefix . 'gf_entry_meta';
    $exists_query = $wpdb->prepare("SELECT COUNT(*) FROM $entry_meta_table WHERE form_id = %d AND meta_value = %s", 2, $submitted_value);
    $entry_count = $wpdb->get_var($exists_query);
    error_log("Submitted value: $submitted_value, Count in DB: $entry_count");
    if ( $result['is_valid'] && $entry_count> 1 ) {
        $result['is_valid'] = false;
//         $result['message'] = 'شماره سریال قبلا ثبت شده است  . ';
		        $result['message'] = '<span style="color: #DC0225;">شماره سریال قبلا ثبت شده است.    ‌ .</span>';

    }
    else if ( $result['is_valid'] && $entry_count== 0 ) {
        $result['is_valid'] = false;
//         $result['message'] = 'شماره سریال معتبر نمی باشد . ';
		        $result['message'] = '<span style="color: #DC0225;">شماره سریال معتبر نمی‌باشد.</span>';

    }
    return $result;
}

 


// Hook into the Gravity Forms submission process for Form ID 3
add_action('gform_after_submission_899', 'farzadkbbb', 10, 2);

function farzadkbbb($entry, $form) {
    global $wpdb;
    
    // Retrieve the submitted value from Form ID 3
    $submitted_value = rgar($entry, '3'); // Assuming the field ID is 3
    
    // Check if the submitted value exists in the database for Form ID 2
    $entry_meta_table = $wpdb->prefix . 'gf_entry_meta';
    $exists_query = $wpdb->prepare("SELECT COUNT(*) FROM $entry_meta_table WHERE form_id = %d AND meta_value = %s", 2, $submitted_value);
    $entry_count = $wpdb->get_var($exists_query);
    
    // Log whether the value exists
    error_log("Submitted value: $submitted_value, Count in DB: $entry_count");
    
    // If the value does not exist, prevent form submission
    if ($entry_count == 0) {
        // Value doesn't exist, prevent form submission
        $validation_message = 'The value you entered does not exist. Please enter a valid value.';
        // Display the validation message to the user
        add_filter('gform_validation_message_3', function($message, $form) use ($validation_message) {
            return "<div class='validation_error'>$validation_message</div>";
        }, 10, 2);
        // Prevent the form from being submitted
        add_filter('gform_pre_submission_filter_3', function($form) {
            // Log that form submission is prevented
            error_log("Form submission prevented.");
            return false; // Returning false prevents form submission
        });
    } else {
        // Log that form submission is allowed
        error_log("Form submission allowed.");
    }
}
// Step 1: Form Submission Handling
add_action('gform_after_submission_2', 'custom_process_form_submission', 10, 2);
function custom_process_form_submission($entry, $form) {
    $user_id = get_current_user_id();
    if ($user_id) {
        // Get the current count
         $current_count = get_user_meta($user_id, 'form_2_submission_count', true);

        // If the meta doesn't exist, set the count to 1
        // 
       
		
		  if (empty($current_count)) {
            $current_count = 1;
        } else {
            // Increment the count
            $current_count++;
        }

        // Update the user meta with the new count
        update_user_meta($user_id, 'form_2_submission_count', $current_count);
		
		  if ($current_count === 15) {
			  				         

            // Get the user's phone number and first name
            $user = get_userdata($user_id);
           $country_code = '0';
            $phone_number = get_user_meta($user_id, 'digits_phone_no', true);

            // Combine the country code and phone number
            $full_phone_number = $country_code . $phone_number;
			              error_log("Phone: " . $full_phone_number);
$phone=$full_phone_number;
            $name = $user->first_name;
     // Log the phone and name variables
            error_log("Phone: " . $phone);
            error_log("Name: " . $name);
			  error_log("User ID: " . $user_id);
 
       $current_count = 1;
        update_user_meta($user_id, 'form_2_submission_count', $current_count);

//             // Construct the API URL
//             $apiUrl = 'http://ippanel.com:8080/?apikey=hXuoMPVA9JbZLjx1dy6J0a9ycD3gLH1Uiv1kJdRWNcw=&pid=cthwdu2waus83j5&fnum=3000505&tnum=+98' . $phone . '&p1=name&v1=' . $name;
	$client = new SoapClient("http://ippanel.com/class/sms/wsdlservice/server.php?wsdl");
	$user = ""; 
	$pass = ""; 
	$fromNum = "3000505"; 
	$toNum = $phone; 
	$pattern_code = "cthwdu2waus83j5"; 
	$input_data = array("name" =>  $name); 

	echo $client->sendPatternSms($fromNum,$toNum,$user,$pass,$pattern_code,$input_data);
		  }
    }
}
 // Step 1: Add the shortcode
function display_form_2_submission_count_shortcode() {
    $user_id = get_current_user_id();
    if ($user_id) {
        $current_count = get_user_meta($user_id, 'form_2_submission_count', true);
        if (empty($current_count)) {
            $current_count = 0;
        }

        // Calculate progress percentage
        $progress_percentage = ($current_count / 15) * 100;
        // Limit progress percentage to 100%
        $progress_percentage = min(100, $progress_percentage);

        // Output HTML with progress bar and text
        $output = '<div style="text-align: center; font-family: Arial, sans-serif;">';
        $output .= '<div style="width: 300px; height: 30px; background-color: #f3f3f3; border-radius: 15px; position: relative; margin: 0 auto 20px; box-shadow: inset 0 0 5px rgba(0, 0, 0, 0.2);">';
        $output .= '<div style="height: 100%; width: ' . $progress_percentage . '%; background-color: #ff6600; border-radius: 15px; transition: width 0.5s ease; position: absolute; top: 0; left: 0;"></div>';
        $output .= '<div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; color: #333; font-weight: bold;">' . $current_count . '/15</div>';
        $output .= '</div>';
        $output .= '<div style="color: #666; font-size: 14px; font-family:YekanBakhFaNum;">با فعالسازی 15 عدد گارانتی، از ما جایزه دریافت کنید.</div>';
        $output .= '</div>';
        return $output;
    } else {
        return 'You must be logged in to view your submission count.';
    }
}
add_shortcode('form_2_submission_count', 'display_form_2_submission_count_shortcode');

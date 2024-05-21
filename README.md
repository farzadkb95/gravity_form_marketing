Gravity Forms Custom Validation
This code provides custom validation for Gravity Forms fields by checking if the submitted value exists in the WordPress database for a specific form ID. It also prevents form submission if the submitted value does not exist in the database.
Functions
custom_validation
This function is hooked to the gform_field_validation_3_3 filter and validates the submitted value for Form ID 3. It checks if the submitted value exists in the database for Form ID 2. If the value doesn't exist, it sets the field validation to false and displays an error message.
custom_validation_21
This function is hooked to the gform_field_validation_2_21 filter and validates the submitted value for Form ID 2. It checks if the submitted value exists in the database for Form ID 2. If the value exists more than once or doesn't exist at all, it sets the field validation to false and displays an error message.
farzadkbbb
This function is hooked to the gform_after_submission_899 action and runs after the submission of Form ID 3. It retrieves the submitted value from Form ID 3 and checks if it exists in the database for Form ID 2. If the value doesn't exist, it displays a validation message and prevents the form submission using the gform_validation_message_3 and gform_pre_submission_filter_3 filters.
Usage

Copy the code into your WordPress theme's functions.php file or a site-specific plugin.
Ensure that you have Gravity Forms installed and activated on your WordPress site.
The code will automatically validate the submitted values for the specified form IDs and prevent form submission if necessary.

Notes

The code uses the wpdb global variable to interact with the WordPress database.
The form IDs and field IDs used in the code are hardcoded. You may need to modify them according to your specific requirements.
The error messages displayed are in Persian (Farsi) language. You can modify the messages as per your needs.
The code assumes that the field ID for the submitted value is 3 for Form ID 3.

Dependencies

Gravity Forms plugin

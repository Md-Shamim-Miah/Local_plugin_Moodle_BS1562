
<?php
// Instantiate the myform form from within the plugin.
require_once('../config.php');
global $CFG,$DB,$USER,$OUTPUT; 
require_once( $CFG->dirroot.'/test/form.php' );
echo $OUTPUT->header();
$mform = new simplehtml_form();
$mform ->add_action_buttons();

$redirect= $CFG->wwwroot.'/test/index.php';

// Form processing and displaying is done here.
if ($mform->is_cancelled()) {
    echo "Form is cancel";
} 
else if ($fromform = $mform->get_data()) {
    print_r($fromform);
    $data=new stdclass();

    $data->email=$fromform->email;
    $data->added_time=time();
    $data->added_by=$USER->id;
    $user_id = $DB->insert_record('email_list', $data);
    if ($user_id) {
        echo "New user record inserted with ID: " . $user_id;
    } else {
        echo "Error inserting user record";
    }

    redirect($redirect, 'record successfully Recorded', 5, \core\output\notification::NOTIFY_SUCCESS);
    
} 
else {
    // This branch is executed if the form is submitted but the data doesn't
    // validate and the form should be redisplayed or on the first display of the form.

    // Set anydefault data (if any).
    // print_r($mform);
    $mform->set_data($toform);

    // Display the form.
    $mform->display();
}

<?php

require_once(__DIR__ . '/../../config.php');
require_once(__DIR__ . '/classes/form/request_form.php');

use local_training_letter\form\request_form;

// Require login.
require_login();

// Check permission.
$context = context_system::instance();

require_capability('local/training_letter:submitrequest', $context);

// Page settings.
$PAGE->set_context($context);
$PAGE->set_url(new moodle_url('/local/training_letter/apply.php'));
$PAGE->set_title('Training Request Form');
$PAGE->set_heading('Training Request Letter Generator');
$PAGE->add_body_class('training-request-page');

// Load custom CSS.
$PAGE->requires->css(
    new moodle_url('/local/training_letter/styles.css')
);

// Create form.
$form = new request_form();

// Handle cancellation.
if ($form->is_cancelled()) {

    redirect(new moodle_url('/my/'));

// Handle form submission.
} else if ($data = $form->get_data()) {

    $record = new stdClass();

    $record->userid = $USER->id;
    $record->studentname = $data->studentname;
    $record->rollnumber = $data->rollnumber;
    $record->branch = $data->branch;
    $record->semester = $data->semester;
    $record->companyname = $data->companyname;
    $record->companyaddress = $data->companyaddress;
    $record->trainingtype = $data->trainingtype;
    $record->duration = $data->duration;
    $record->startdate = $data->startdate;
    $record->joindate = $data->joindate;
    $record->status = 'Pending';
    $record->timecreated = time();
    $record->timemodified = time();

    // Save request in database.
    $DB->insert_record('local_training_letter', $record);

    // Show success message.
    redirect(
        new moodle_url('/local/training_letter/apply.php'),
        'Training request submitted successfully!',
        null,
        \core\output\notification::NOTIFY_SUCCESS
    );
}

// Display page.
echo $OUTPUT->header();

// Subtitle.
echo html_writer::tag(
    'p',
    'Fill in your details to submit a training request.',
    ['class' => 'training-subtitle']
);

// Display form.
$form->display();

echo $OUTPUT->footer();

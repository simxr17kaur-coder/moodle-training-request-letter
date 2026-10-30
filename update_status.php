
<?php
require_once(__DIR__ . '/../../config.php');

require_login();

$context = context_system::instance();

require_capability('local/training_letter:managerequests', $context);

require_sesskey();

$id = required_param('id', PARAM_INT);
$status = required_param('status', PARAM_ALPHA);
$remarks = optional_param('remarks', '', PARAM_TEXT);

if (!in_array($status, ['Approved', 'Rejected'], true)) {
    throw new moodle_exception('Invalid training request status.');
}

$request = $DB->get_record(
    'local_training_letter',
    ['id' => $id],
    '*',
    MUST_EXIST
);

$request->status = $status;
$request->remarks = $remarks;
$request->coordinatorid = $USER->id;
$request->timemodified = time();

$DB->update_record('local_training_letter', $request);

redirect(
    new moodle_url('/local/training_letter/coordinator.php'),
    'Training request status and remarks updated successfully!',
    null,
    \core\output\notification::NOTIFY_SUCCESS
);

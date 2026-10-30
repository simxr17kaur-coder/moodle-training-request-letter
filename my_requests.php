<?php
require_once(__DIR__ . '/../../config.php');

require_login();

$context = context_system::instance();

$PAGE->set_context($context);
$PAGE->set_url(new moodle_url('/local/training_letter/my_requests.php'));
$PAGE->set_title('My Training Requests');
$PAGE->set_heading('My Training Request Status');

// Add custom CSS class for this page.
$PAGE->add_body_class('training-requests-list-page');

// Load the existing custom CSS file.
$PAGE->requires->css(
    new moodle_url('/local/training_letter/styles.css')
);

echo $OUTPUT->header();

echo $OUTPUT->heading(
    'My Submitted Training Requests',
    2,
    'requests-section-heading'
);

// Fetch only the logged-in student's requests.
$requests = $DB->get_records(
    'local_training_letter',
    ['userid' => $USER->id],
    'timecreated DESC'
);

if (empty($requests)) {

    echo html_writer::start_div('requests-empty-card');

    echo $OUTPUT->notification(
        'You have not submitted any training requests yet.',
        \core\output\notification::NOTIFY_INFO
    );

    echo html_writer::link(
        new moodle_url('/local/training_letter/apply.php'),
        'Submit a New Training Request',
        ['class' => 'new-request-button']
    );

    echo html_writer::end_div();

} else {

    $table = new html_table();

    $table->head = [
        'Company Name',
        'Training Type',
        'Duration',
        'Start Date',
        'Status',
        'Coordinator Remarks',
        'Approval Letter'
    ];

    // Add custom table styling class.
    $table->attributes['class'] = 'training-requests-table generaltable';

    foreach ($requests as $request) {

        // Display status with a coloured label.
        $status = html_writer::tag(
            'span',
            s($request->status),
            [
                'class' => 'request-status status-' .
                    strtolower(clean_param($request->status, PARAM_ALPHA))
            ]
        );

        // Display coordinator remarks.
        $remarks = !empty($request->remarks)
            ? s($request->remarks)
            : 'No remarks yet';

        // Show PDF download link only for approved requests.
        if ($request->status === 'Approved') {

            $letterlink = html_writer::link(
                new moodle_url(
                    '/local/training_letter/generate_letter.php',
                    ['id' => $request->id]
                ),
                'Download PDF',
                ['class' => 'download-letter-link']
            );

        } else {

            $letterlink = html_writer::tag(
                'span',
                'Available after approval',
                ['class' => 'letter-unavailable']
            );
        }

        // Add request details to the table.
        $table->data[] = [
            s($request->companyname),
            s($request->trainingtype),
            s($request->duration),
            userdate($request->startdate, '%d %B %Y'),
            $status,
            $remarks,
            $letterlink
        ];
    }

    // Display the table inside a styled card.
    echo html_writer::start_div('training-requests-card');

    echo html_writer::table($table);

    echo html_writer::end_div();
}

echo $OUTPUT->footer();
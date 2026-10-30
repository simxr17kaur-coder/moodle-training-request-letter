<?php
require_once(__DIR__ . '/../../config.php');

require_login();

$context = context_system::instance();

require_capability('local/training_letter:managerequests', $context);

$PAGE->set_context($context);
$PAGE->set_url(new moodle_url('/local/training_letter/coordinator.php'));
$PAGE->set_title('Coordinator Dashboard');
$PAGE->set_heading('Training Request Coordinator Dashboard');

// Add custom CSS class.
$PAGE->add_body_class('training-coordinator-page');

// Load custom CSS.
$PAGE->requires->css(
    new moodle_url('/local/training_letter/styles.css')
);

echo $OUTPUT->header();

echo $OUTPUT->heading(
    'Submitted Training Requests',
    2,
    'coordinator-section-heading'
);

// Fetch all training requests.
$requests = $DB->get_records(
    'local_training_letter',
    null,
    'timecreated DESC'
);

if (empty($requests)) {

    echo html_writer::start_div('coordinator-empty-card');

    echo $OUTPUT->notification(
        'No training requests have been submitted yet.',
        \core\output\notification::NOTIFY_INFO
    );

    echo html_writer::end_div();

} else {

    $table = new html_table();

    $table->head = [
        'Student Name',
        'Roll Number',
        'Department',
        'Company',
        'Training Type',
        'Duration',
        'Status',
        'Coordinator Remarks',
        'Action'
    ];

    // Apply custom table styling.
    $table->attributes['class'] =
        'coordinator-requests-table generaltable';

    foreach ($requests as $request) {

        $actions = '';

        if ($request->status === 'Pending') {

            $actionurl = new moodle_url(
                '/local/training_letter/update_status.php'
            );

            $actions = html_writer::start_tag('form', [
                'method' => 'post',
                'action' => $actionurl,
                'class' => 'coordinator-action-form'
            ]);

            $actions .= html_writer::empty_tag('input', [
                'type' => 'hidden',
                'name' => 'id',
                'value' => $request->id
            ]);

            $actions .= html_writer::empty_tag('input', [
                'type' => 'hidden',
                'name' => 'sesskey',
                'value' => sesskey()
            ]);

            $actions .= html_writer::tag(
                'textarea',
                '',
                [
                    'name' => 'remarks',
                    'rows' => 3,
                    'cols' => 25,
                    'placeholder' => 'Enter coordinator remarks...',
                    'aria-label' => 'Coordinator remarks',
                    'class' => 'form-control coordinator-remarks'
                ]
            );

            $actions .= html_writer::empty_tag('br');

            $actions .= html_writer::empty_tag('input', [
                'type' => 'submit',
                'name' => 'status',
                'value' => 'Approved',
                'class' => 'btn btn-success coordinator-approve'
            ]);

            $actions .= ' ';

            $actions .= html_writer::empty_tag('input', [
                'type' => 'submit',
                'name' => 'status',
                'value' => 'Rejected',
                'class' => 'btn btn-danger coordinator-reject'
            ]);

            $actions .= html_writer::end_tag('form');

        } else {

            $actions = html_writer::tag(
                'span',
                s($request->status),
                ['class' => 'coordinator-action-complete']
            );
        }

        // Status label.
        $statusclass = 'status-' .
            strtolower(clean_param($request->status, PARAM_ALPHA));

        $status = html_writer::tag(
            'span',
            s($request->status),
            ['class' => 'request-status ' . $statusclass]
        );

        // Coordinator remarks.
        $remarks = !empty($request->remarks)
            ? s($request->remarks)
            : 'No remarks yet';

        // Add request details to the table.
        $table->data[] = [
            s($request->studentname),
            s($request->rollnumber),
            s($request->branch),
            s($request->companyname),
            s($request->trainingtype),
            s($request->duration),
            $status,
            $remarks,
            $actions
        ];
    }

    // Display table inside a styled card.
    echo html_writer::start_div('coordinator-requests-card');

    echo html_writer::table($table);

    echo html_writer::end_div();
}

echo $OUTPUT->footer();
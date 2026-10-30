<?php
require_once(__DIR__ . '/../../config.php');

require_login();

$context = context_system::instance();

$PAGE->set_url(new moodle_url('/local/training_letter/index.php'));
$PAGE->set_context($context);
$PAGE->set_title('Training Letter Portal');
$PAGE->set_heading('Training Letter Portal');

$PAGE->add_body_class('training-portal-page');

$PAGE->requires->css(
    new moodle_url('/local/training_letter/styles.css')
);

echo $OUTPUT->header();

echo html_writer::start_div('training-portal-container');

// =====================================
// HERO / WELCOME SECTION
// =====================================

echo html_writer::start_div('portal-hero');

$logo = new moodle_url('/local/training_letter/pix/gndec-logo.png');

echo html_writer::empty_tag('img', [
    'src' => $logo->out(false),
    'class' => 'portal-logo',
    'alt' => 'GNDEC College Logo'
]);

echo html_writer::tag(
    'h1',
    'Training Letter Portal',
    ['class' => 'portal-main-title']
);

echo html_writer::tag(
    'p',
    'Guru Nanak Dev Engineering College',
    ['class' => 'portal-college-name']
);

echo html_writer::tag(
    'p',
    'Training & Placement Cell',
    ['class' => 'portal-subtitle']
);

echo html_writer::tag(
    'p',
    'Your journey towards professional growth starts here. Apply for industrial training, track your requests, and manage your training documentation in one place.',
    ['class' => 'portal-description']
);

echo html_writer::end_div();

// =====================================
// QUICK ACTIONS SECTION
// =====================================

echo html_writer::tag(
    'h2',
    'Explore Your Portal',
    ['class' => 'portal-section-title']
);

echo html_writer::start_div('training-portal-cards');

// CARD 1: APPLY FOR TRAINING

echo html_writer::start_div('training-portal-card');

echo html_writer::tag(
    'div',
    '📝',
    ['class' => 'portal-icon']
);

echo html_writer::tag(
    'h3',
    'Apply for Training'
);

echo html_writer::tag(
    'p',
    'Submit a new industrial training request with your company and training details.'
);

echo html_writer::link(
    new moodle_url('/local/training_letter/apply.php'),
    'Apply Now',
    ['class' => 'training-portal-button']
);

echo html_writer::end_div();

// CARD 2: MY REQUESTS

echo html_writer::start_div('training-portal-card');

echo html_writer::tag(
    'div',
    '📋',
    ['class' => 'portal-icon']
);

echo html_writer::tag(
    'h3',
    'My Requests'
);

echo html_writer::tag(
    'p',
    'Track the status of your training applications and download approved letters.'
);

echo html_writer::link(
    new moodle_url('/local/training_letter/my_requests.php'),
    'View Requests',
    ['class' => 'training-portal-button']
);

echo html_writer::end_div();

// CARD 3: COORDINATOR DASHBOARD

if (has_capability(
    'local/training_letter:managerequests',
    $context
)) {

    echo html_writer::start_div('training-portal-card');

    echo html_writer::tag(
        'div',
        '👨‍💼',
        ['class' => 'portal-icon']
    );

    echo html_writer::tag(
        'h3',
        'Coordinator Dashboard'
    );

    echo html_writer::tag(
        'p',
        'Review student requests, approve or reject applications, and provide remarks.'
    );

    echo html_writer::link(
        new moodle_url('/local/training_letter/coordinator.php'),
        'Open Dashboard',
        ['class' => 'training-portal-button']
    );

    echo html_writer::end_div();
}

echo html_writer::end_div();

// =====================================
// HOW IT WORKS SECTION
// =====================================

echo html_writer::start_div('portal-how-it-works');

echo html_writer::tag(
    'h2',
    'How It Works',
    ['class' => 'portal-section-title']
);

echo html_writer::start_div('portal-steps');

$steps = [
    [
        'number' => '01',
        'title' => 'Submit Request',
        'description' => 'Fill in your student, company, and training details.'
    ],
    [
        'number' => '02',
        'title' => 'Wait for Review',
        'description' => 'The coordinator reviews your training application.'
    ],
    [
        'number' => '03',
        'title' => 'Download Letter',
        'description' => 'Once approved, download your training request letter.'
    ]
];

foreach ($steps as $step) {

    echo html_writer::start_div('portal-step');

    echo html_writer::tag(
        'span',
        $step['number'],
        ['class' => 'portal-step-number']
    );

    echo html_writer::tag(
        'h3',
        $step['title']
    );

    echo html_writer::tag(
        'p',
        $step['description']
    );

    echo html_writer::end_div();
}

echo html_writer::end_div();
echo html_writer::end_div();

// =====================================
// FOOTER
// =====================================

echo html_writer::start_div('portal-footer');

echo html_writer::tag(
    'p',
    'Guru Nanak Dev Engineering College, Gill Park, Ludhiana, Punjab'
);

echo html_writer::tag(
    'p',
    'Training & Placement Cell | Training Letter Portal'
);

echo html_writer::end_div();

echo html_writer::end_div();

echo $OUTPUT->footer();

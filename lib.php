<?php

function local_training_letter_extend_navigation(global_navigation $navigation) {
    global $CFG, $USER;

    if (!isloggedin() || isguestuser()) {
        return;
    }

    $url = new moodle_url('/local/training_letter/index.php');

    $navigation->add(
        'Training Letter Portal',
        $url,
        navigation_node::TYPE_CUSTOM,
        null,
        'training_letter_portal',
        new pix_icon('i/home', '')
    );
}

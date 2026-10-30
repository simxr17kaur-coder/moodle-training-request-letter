<?php
namespace local_training_letter\form;

defined('MOODLE_INTERNAL') || die();

require_once($CFG->libdir . '/formslib.php');

class request_form extends \moodleform {

    public function definition() {
        $mform = $this->_form;

        // =====================================
        // SECTION 1: STUDENT DETAILS
        // =====================================

        $mform->addElement(
            'header',
            'studentsection',
            '01. Student Details'
        );

        $mform->setExpanded('studentsection', true);

        $mform->addElement('text', 'studentname', 'Student Name');
        $mform->setType('studentname', PARAM_TEXT);
        $mform->addRule('studentname', 'Please enter your name.', 'required');

        $mform->addElement('text', 'rollnumber', 'Roll Number');
        $mform->setType('rollnumber', PARAM_TEXT);
        $mform->addRule('rollnumber', 'Please enter your roll number.', 'required');

        $mform->addElement('text', 'branch', 'Department / Branch');
        $mform->setType('branch', PARAM_TEXT);
        $mform->addRule('branch', 'Please enter your department.', 'required');

        $mform->addElement(
            'select',
            'semester',
            'Semester',
            [
                1 => '1',
                2 => '2',
                3 => '3',
                4 => '4',
                5 => '5',
                6 => '6',
                7 => '7',
                8 => '8',
            ]
        );

        // =====================================
        // SECTION 2: COMPANY DETAILS
        // =====================================

        $mform->addElement(
            'header',
            'companysection',
            '02. Company Details'
        );

        $mform->setExpanded('companysection', true);

        $mform->addElement('text', 'companyname', 'Company Name');
        $mform->setType('companyname', PARAM_TEXT);
        $mform->addRule('companyname', 'Please enter the company name.', 'required');

        $mform->addElement('textarea', 'companyaddress', 'Company Address');
        $mform->setType('companyaddress', PARAM_TEXT);
        $mform->addRule('companyaddress', 'Please enter the company address.', 'required');

        // =====================================
        // SECTION 3: TRAINING DETAILS
        // =====================================

        $mform->addElement(
            'header',
            'trainingsection',
            '03. Training Details'
        );

        $mform->setExpanded('trainingsection', true);

        $mform->addElement(
            'select',
            'trainingtype',
            'Training Type',
            [
                'Software' => 'Software',
                'Industrial' => 'Industrial',
            ]
        );

        $mform->addElement(
            'select',
            'duration',
            'Training Duration',
            [
                '6 Weeks' => '6 Weeks',
                '6 Months' => '6 Months',
            ]
        );

        $mform->addElement(
            'date_selector',
            'startdate',
            'Training Start Date'
        );

        $mform->addElement(
            'date_selector',
            'joindate',
            'Joining Date'
        );

        // SUBMIT BUTTON
        $this->add_action_buttons(true, 'Submit Request');
    }

    // =====================================
    // DATE VALIDATION
    // =====================================

    public function validation($data, $files) {
        $errors = parent::validation($data, $files);

        if (!empty($data['startdate']) &&
            !empty($data['joindate']) &&
            $data['joindate'] < $data['startdate']) {

            $errors['joindate'] =
                'Joining date cannot be before the training start date.';
        }

        return $errors;
    }
}

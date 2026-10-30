
<?php
require_once(__DIR__ . '/../../config.php');

require_login();

$id = required_param('id', PARAM_INT);

// Fetch the training request.
$request = $DB->get_record(
    'local_training_letter',
    ['id' => $id],
    '*',
    MUST_EXIST
);

// Only the student who submitted the request can download it.
if ((int)$request->userid !== (int)$USER->id) {
    throw new moodle_exception(
        'nopermissions',
        'error',
        '',
        'download this letter'
    );
}

// Only approved requests can generate a letter.
if ($request->status !== 'Approved') {
    throw new moodle_exception(
        'nopermissions',
        'error',
        '',
        'download this letter because the request is not approved'
    );
}

// Get coordinator name, if available.
$coordinatorname = '';

if (!empty($request->coordinatorid)) {
    $coordinator = $DB->get_record(
        'user',
        ['id' => $request->coordinatorid],
        'firstname, lastname'
    );

    if ($coordinator) {
        $coordinatorname = trim(
            $coordinator->firstname . ' ' . $coordinator->lastname
        );
    }
}

if (empty($coordinatorname)) {
    $coordinatorname = 'Training and Placement Coordinator';
}

// Escape database values before inserting them into HTML.
$studentname = s($request->studentname);
$rollnumber = s($request->rollnumber);
$branch = s($request->branch);
$semester = s($request->semester);
$companyname = s($request->companyname);
$companyaddress = nl2br(s($request->companyaddress));
$trainingtype = s($request->trainingtype);
$duration = s($request->duration);

$startdate = userdate(
    (int)$request->startdate,
    '%d-%m-%Y'
);

$joindate = userdate(
    (int)$request->joindate,
    '%d-%m-%Y'
);

$remarks = !empty($request->remarks)
    ? nl2br(s($request->remarks))
    : 'Recommended for the proposed training programme.';

$coordinatornamehtml = s($coordinatorname);

// Generate reference number and date.
$referenceno = 'GNDEC/TPC/' . date('Y') . '/' . $request->id;
$letterdate = userdate(time(), '%d-%m-%Y');

// College logo.
$logoPath = realpath(__DIR__ . '/pix/gndec-logo.png');

$logoHtml = '';

if ($logoPath && is_readable($logoPath) && @getimagesize($logoPath)) {
    // Use forward slashes for Windows compatibility.
    $logoPath = str_replace('\\', '/', $logoPath);

    $logoHtml = '<img src="' . $logoPath . '" width="75" height="75">';
} else {
    $logoHtml = '<div style="font-size:10px; color:#777;">GNDEC LOGO</div>';
}

// Prepare PDF.
require_once($CFG->libdir . '/pdflib.php');

$pdf = new pdf();

$pdf->SetCreator('GNDEC Training and Placement Cell');
$pdf->SetAuthor('Training and Placement Cell');
$pdf->SetTitle('Training Request Letter');
$pdf->SetSubject('Request for Student Training');

$pdf->SetMargins(18, 15, 18);
$pdf->SetAutoPageBreak(true, 18);
$pdf->AddPage();

$html = '
<style>
    body {
        font-family: helvetica;
        color: #333333;
        font-size: 10pt;
    }

    .college-name {
        font-size: 19pt;
        font-weight: bold;
        color: #173f35;
        text-align: center;
    }

    .cell-name {
        font-size: 11pt;
        font-weight: bold;
        color: #7a263a;
        text-align: center;
    }

    .college-address {
        font-size: 8pt;
        color: #555555;
        text-align: center;
    }

    .divider {
        border-bottom: 3px solid #7a263a;
    }

    .reference {
        font-size: 9pt;
        color: #444444;
    }

    .subject {
        font-weight: bold;
        color: #173f35;
        font-size: 11pt;
    }

    .details-heading {
        background-color: #173f35;
        color: #ffffff;
        font-weight: bold;
        font-size: 10pt;
    }

    .details-table {
        border-collapse: collapse;
        font-size: 9pt;
    }

    .label {
        background-color: #f1f4f0;
        font-weight: bold;
        width: 32%;
    }

    .remarks {
        background-color: #f7f5ef;
        border-left: 3px solid #7a263a;
        padding: 8px;
    }

    .signature {
        color: #173f35;
        font-weight: bold;
    }

    .footer {
        color: #777777;
        font-size: 8pt;
        text-align: center;
    }
</style>

<table width="100%" cellpadding="3">
    <tr>
        <td width="18%" align="center">' . $logoHtml . '</td>
        <td width="82%" align="center">
            <div class="college-name">
                GURU NANAK DEV ENGINEERING COLLEGE
            </div>
            <div class="cell-name">
                TRAINING AND PLACEMENT CELL
            </div>
            <div class="college-address">
                Gill Park, Ludhiana, Punjab
            </div>
        </td>
    </tr>
</table>

<br>

<table width="100%">
    <tr>
        <td class="divider">&nbsp;</td>
    </tr>
</table>

<br>

<table width="100%" cellpadding="3">
    <tr>
        <td width="60%" class="reference">
            <b>Reference No.:</b> ' . $referenceno . '
        </td>
        <td width="40%" align="right" class="reference">
            <b>Date:</b> ' . $letterdate . '
        </td>
    </tr>
</table>

<br>

<b>To,</b><br>
The HR Manager / Training Coordinator,<br>
<b>' . $companyname . '</b><br>
' . $companyaddress . '

<br><br>

<div class="subject">
    Subject: Request for providing ' . $trainingtype . ' Training
</div>

<br>

Respected Sir/Madam,

<br><br>

This is to request you to kindly provide an opportunity for
<b>' . $studentname . '</b>, Roll Number
<b>' . $rollnumber . '</b>, a student of
<b>' . $branch . '</b>, Semester
<b>' . $semester . '</b>, at Guru Nanak Dev Engineering College,
Ludhiana, to undergo <b>' . $trainingtype . ' Training</b>
at your esteemed organization.

<br><br>

The proposed training details are given below:

<br><br>

<table border="1" cellpadding="7" width="100%" class="details-table">
    <tr>
        <td colspan="2" class="details-heading">
            STUDENT AND TRAINING DETAILS
        </td>
    </tr>
    <tr>
        <td class="label">Student Name</td>
        <td>' . $studentname . '</td>
    </tr>
    <tr>
        <td class="label">Roll Number</td>
        <td>' . $rollnumber . '</td>
    </tr>
    <tr>
        <td class="label">Department / Branch</td>
        <td>' . $branch . '</td>
    </tr>
    <tr>
        <td class="label">Semester</td>
        <td>' . $semester . '</td>
    </tr>
    <tr>
        <td class="label">Company / Organization</td>
        <td>' . $companyname . '</td>
    </tr>
    <tr>
        <td class="label">Training Type</td>
        <td>' . $trainingtype . '</td>
    </tr>
    <tr>
        <td class="label">Training Duration</td>
        <td>' . $duration . '</td>
    </tr>
    <tr>
        <td class="label">Proposed Start Date</td>
        <td>' . $startdate . '</td>
    </tr>
    <tr>
        <td class="label">Joining Date</td>
        <td>' . $joindate . '</td>
    </tr>
</table>

<br>

We kindly request you to consider this application and provide
the student with an opportunity to undergo training at your
organization. This training will help the student gain practical
knowledge and valuable industry experience.

<br><br>

Thank you for your consideration and support.

<br><br>

Yours faithfully,

<br><br><br>

<table width="100%" cellpadding="3">
    <tr>
        <td width="60%">
            <div class="signature">' . $coordinatornamehtml . '</div>
            Training and Placement Coordinator<br>
            Guru Nanak Dev Engineering College
        </td>
        <td width="40%" align="center">
            <br><br>
            __________________________<br>
            Authorized Signature
        </td>
    </tr>
</table>

<br><br>

<div class="remarks">
    <b>Coordinator Remarks:</b><br>
    ' . $remarks . '
</div>

<br><br>

<table width="100%">
    <tr>
        <td class="divider">&nbsp;</td>
    </tr>
</table>

<br>

<div class="footer">
    Training and Placement Cell | Guru Nanak Dev Engineering College, Ludhiana
    <br>
    Computer-generated letter. Institutional authorization/signature is required
    before official use.
</div>
';

$pdf->writeHTML($html, true, false, true, false, '');

// Clear output buffers before sending the PDF.
while (ob_get_level()) {
    ob_end_clean();
}

// Download PDF.
$pdf->Output(
    'Training_Request_Letter_' . $request->id . '.pdf',
    'D'
);

exit;

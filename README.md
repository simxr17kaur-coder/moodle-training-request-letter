Training Request Letter Generator
A Moodle local plugin developed for Guru Nanak Dev Engineering College
(GNDEC), Gill Park, Ludhiana, Punjab.

The Training Request Letter Generator provides an online portal through
which students can submit industrial training requests, track their
application status, and download a formal PDF training request letter
after approval. Authorized coordinators can review requests, approve or
reject them, and provide remarks.
Table of Contents
1. Project Overview
2. Objectives
3. Technology Stack
4. Moodle Plugin Information
5. Project Structure
6. System Architecture
7. Database Design
8. Student Request Form
9. Application Submission Process
10. Coordinator Dashboard
11. Approval and Rejection
    Processing
12. Student Request Tracking
13. PDF Letter Generation
14. Moodle Permissions and
    Capabilities
15. Plugin Version and
    Compatibility
16. Language File
17. Main Portal Dashboard
18. Moodle Navigation Integration
19. Installation Guide
20. How to Use the Plugin
21. Security and Data Handling
22. Testing Checklist
23. Limitations and Future
    Enhancements
24. Conclusion
1. Project Overview
The Training Request Letter Generator is a local Moodle plugin
designed to digitize and simplify the process of requesting
institutional support for industrial training.

Traditionally, students may need to prepare training request details
manually and coordinate with the Training and Placement Cell for
approval. This plugin provides a centralized Moodle-based workflow.

Students log in to Moodle and submit their personal, academic, company,
and training information. The request is saved in the Moodle database
with an initial status of Pending.

An authorized coordinator accesses the Coordinator Dashboard, reviews
the submitted information, enters remarks, and approves or rejects the
request.

When a request is approved, the student can download a generated PDF
letter containing the college letterhead, logo, student details, company
information, training schedule, coordinator information, remarks, and
signature area.
Main users
- Students: Submit training requests, view their own requests,
  track decisions, and download approved letters.
- Coordinators / authorized managers: View submitted requests,
  approve or reject them, and provide remarks.
- Moodle administrators: Install the plugin and manage Moodle
  roles and capabilities.
2. Project Objectives
The main objectives are:
- Digitize the student industrial training request process.
- Provide a centralized portal inside Moodle.
- Collect student, company, and training details through an online
  form.
- Store requests in Moodle's database.
- Allow authorized coordinators to review and process requests.
- Allow students to track the status of their applications.
- Generate a formal PDF training request letter after approval.
- Restrict access using Moodle authentication and capabilities.
- Reduce manual paperwork and make request tracking easier.
3. Technology Stack
  Technology                          Use in the project
  Moodle LMS                          Host application and user
management

  PHP                                 Server-side plugin development

  MySQL / MariaDB (depending on       Database used by the Moodle
Moodle installation)                installation

  HTML                                Structure of portal pages and PDF
letter content

  CSS                                 Styling of portal pages, forms,
cards, and tables

  Moodle Forms API                    Creation and validation of the
training request form

  Moodle Database API (DML)           Database record retrieval,
insertion, and updates

  Moodle Navigation API               Integration with Moodle navigation

  Moodle Access API                   Role and capability-based
permission checking
Moodle PDF library                  Generation of downloadable PDF
letters
The plugin uses Moodle's APIs rather than creating a separate database
connection. Moodle manages the database connection and table prefix.
4. Moodle Plugin Information
  Property                 Value
  Plugin name              Training Request Letter Generator
Plugin type              Local plugin
Component name           local_training_letter
Release                  0.1
Internal version         2026102900
Minimum Moodle version   2024100700
Maturity                 Alpha
Institution              Guru Nanak Dev Engineering College
Department               Training and Placement Cell

A local plugin is stored inside Moodle's local directory and can add
custom functionality to the Moodle site.
5. Project Structure
training_letter/
│
├── classes/
│   └── form/
│       └── request_form.php
│
├── db/
│   ├── access.php
│   └── install.xml
│
├── lang/
│   └── en/
│       └── local_training_letter.php
│
├── pix/
│   └── gndec-logo.png
│
├── apply.php
├── coordinator.php
├── generate_letter.php
├── index.php
├── lib.php
├── my_requests.php
├── update_status.php
├── version.php
├── styles.css
└── README.md
Purpose of important files
  File / Folder                         Responsibility
  version.php                         Defines plugin identity, version,
release, maturity, and Moodle
requirement.

  index.php                           Main portal dashboard and
navigation cards.

  apply.php                           Processes and saves student
training requests.

  my_requests.php                     Displays requests belonging to the
logged-in student.

  coordinator.php                     Displays requests for coordinator
review and decision-making.

  update_status.php                   Processes coordinator approval or
rejection and saves remarks.

  generate_letter.php                 Generates the PDF training request
letter.

  lib.php                             Defines the global navigation
extension callback.

  styles.css                          Contains custom visual styling for
plugin pages.

  classes/form/request_form.php       Defines and validates the Moodle
training request form.

  db/install.xml                      Defines the plugin database table
and its fields.

  db/access.php                       Defines plugin capabilities and
default role permissions.

  lang/en/local_training_letter.php   Stores English language strings.
pix/gndec-logo.png                  College logo used in the portal and
PDF letter.
6. System Architecture
The plugin follows a Moodle-based client/server architecture.
Main components
1. Presentation layer: Moodle pages, HTML elements, forms, tables,
   and custom CSS.
2. Application layer: PHP scripts process submissions, retrieve
   requests, check permissions, update statuses, and generate letters.
3. Moodle platform layer: Moodle handles authentication, user
   identity, page rendering, capabilities, navigation, and PDF library
   integration.
4. Database layer: The local_training_letter table stores student
   training request records.
Overall workflow
Student logs in to Moodle
          |
          v
Training Letter Portal
          |
          v
Student fills training request form
          |
          v
Moodle validates submitted data
          |
          v
Request saved in database
Status = Pending
          |
          v
Coordinator opens dashboard
          |
          v
Coordinator reviews request
          |
          +----------------------+
          |                      |
          v                      v
       Approve                Reject
          |                      |
          +----------+-----------+
                     |
                     v
          Status and remarks updated
                     |
                     v
            Student views status
                     |
          +----------+-----------+
          |                      |
          v                      v
       Approved              Rejected
          |
          v
     Download PDF letter
7. Database Design
The plugin defines its database table in:

db/install.xml
Table name
local_training_letter

Moodle automatically applies the database prefix configured by the site.
For example, if the prefix is mdl_, the physical table may be named
mdl_local_training_letter.
Database fields
  Field                   Type                    Description
  id                    Integer, primary key    Unique ID of each
training request.

  userid                Integer                 Moodle user ID of the
student who submitted
the request.

  studentname           Character (100)         Student's name.

  rollnumber            Character (30)          Student roll number.

  branch                Character (100)         Department or branch.

  semester              Integer (2)             Student semester.

  companyname           Character (150)         Company or organization
name.

  companyaddress        Text                    Company address.

  trainingtype          Character (30)          Training category, such
as Software or
Industrial.

  duration              Character (30)          Training duration.

  startdate             Integer                 Proposed training start
date stored as a
timestamp.

  joindate              Integer                 Joining date stored as
a timestamp.

  status                Character (20)          Current request status.

  coordinatorid         Integer, nullable       Moodle user ID of the
coordinator who
processed the request.

  remarks               Text, nullable          Coordinator's remarks.

  timecreated           Integer                 Time when the request
was created.
timemodified          Integer                 Time when the request
was last modified.
Keys and relationships
- id is the primary key.
- userid has a foreign key relationship with the id field of
  Moodle's core user table.
- coordinatorid stores the ID of the coordinator who processes the
  request.
Default values
- Initial status: Pending
- Default training type: Software
- Default duration: 6 Weeks
- Default semester: 1
Database operations
The plugin uses Moodle's Database API:

  Moodle API               Purpose
  $DB->insert_record()   Inserts a new training request.
$DB->get_record()      Retrieves one matching record.
$DB->get_records()     Retrieves multiple matching records.
$DB->update_record()   Updates an existing request.

The plugin does not directly create a MySQL or MariaDB connection.
Moodle handles database access through its database abstraction layer.
Installation and future schema changes
Moodle reads db/install.xml when installing the plugin and creates the
defined table.

If the database structure needs to change in a future release, the
plugin should use Moodle's upgrade mechanism through db/upgrade.php
and an appropriate version increase in version.php. The current
project schema is defined in db/install.xml.
8. Student Request Form
The form is implemented in:

classes/form/request_form.php

It uses Moodle's Forms API by extending the moodleform class.
Form sections
Section 1: Student Details
- Student Name
- Roll Number
- Department / Branch
- Semester
Section 2: Company Details
- Company Name
- Company Address
Section 3: Training Details
- Training Type
- Training Duration
- Training Start Date
- Joining Date
Form validation
The form uses Moodle form methods:
- addElement() creates text fields, dropdowns, text areas, date
  selectors, and section headings.
- setType() specifies how text input should be cleaned.
- addRule() marks required fields and displays validation messages.
- setExpanded() controls whether form sections are initially
  expanded.
- add_action_buttons() adds submit and cancel buttons.
The custom validation() method checks that the joining date is not
earlier than the training start date.

The form uses Moodle's PARAM_TEXT cleaning type for text fields.
9. Application Submission Process
The application processing is implemented in:

apply.php
Processing steps
1. Loads Moodle configuration through config.php.
2. Includes the custom request form class.
3. Calls require_login() to require authentication.
4. Gets the system context.
5. Checks the local/training_letter:submitrequest capability.
6. Configures the Moodle page and loads the custom CSS.
7. Creates an instance of the request_form class.
8. Handles cancellation by redirecting the user to the Moodle
   dashboard.
9. Retrieves validated form data using $form->get_data().
10. Creates a database record containing the student, company, and
    training details.
11. Stores the current Moodle user ID in userid.
12. Sets the initial status to Pending.
13. Sets timecreated and timemodified using time().
14. Saves the record using $DB->insert_record().
15. Redirects the student with a success notification.
Important Moodle functions
  Function                            Purpose
  require_once()                    Loads Moodle configuration and the
form class.

  require_login()                   Requires an authenticated user.

  context_system::instance()        Gets the system context.

  require_capability()              Checks whether the user can submit
requests.

  moodle_url()                      Creates Moodle URLs.

  $form->is_cancelled()             Checks whether the form was
cancelled.

  $form->get_data()                 Retrieves validated submitted form
data.

  $DB->insert_record()              Saves the request.
redirect()                        Redirects the user and displays a
notification.
10. Coordinator Dashboard
The coordinator dashboard is implemented in:

coordinator.php

It allows authorized coordinators to view student training requests and
process pending applications.
Main operations
1. Requires the user to log in.
2. Gets the system context.
3. Checks the local/training_letter:managerequests capability.
4. Configures the Moodle page and loads custom CSS.
5. Retrieves training requests from the local_training_letter table.
6. Sorts requests by creation time, newest first.
7. Displays an information message if no requests are available.
8. Displays a table containing student and training details.
9. For pending requests, displays a remarks field and
   approval/rejection actions.
10. For processed requests, displays their current status without the
    pending decision controls.
Dashboard information
The dashboard table includes:
- Student Name
- Roll Number
- Department
- Company
- Training Type
- Duration
- Status
- Coordinator Remarks
- Action
The coordinator can enter remarks and select either Approved or
Rejected.

The dashboard uses Moodle's HTML writer and table APIs to create the
interface. Dynamic text is escaped using Moodle's s() function.
11. Approval and Rejection Processing
The processing logic is implemented in:

update_status.php

This script receives the coordinator's decision from the dashboard and
updates the matching database record.
Processing steps
1. Loads Moodle configuration.
2. Requires the user to be logged in.
3. Gets the system context.
4. Checks the local/training_letter:managerequests capability.
5. Calls require_sesskey() to validate Moodle's session key and help
   protect against CSRF.
6. Reads the request ID using required_param('id', PARAM_INT).
7. Reads the decision using required_param('status', PARAM_ALPHA).
8. Reads optional remarks using
   optional_param('remarks', '', PARAM_TEXT).
9. Accepts only Approved and Rejected as valid decisions.
10. Retrieves the matching request using $DB->get_record().
11. Updates the status, remarks, coordinator ID, and modification time.
12. Saves the updated record using $DB->update_record().
13. Redirects to the coordinator dashboard with a success notification.
Fields updated
  Field             Value
  status          Approved or Rejected
remarks         Coordinator's submitted remarks
coordinatorid   Current coordinator's Moodle user ID
timemodified    Current timestamp
Important Moodle functions
- require_sesskey() -- checks the Moodle session key.
- required_param() -- reads mandatory parameters.
- optional_param() -- reads an optional parameter.
- PARAM_INT, PARAM_ALPHA, PARAM_TEXT -- parameter cleaning
  types.
- $DB->get_record() -- retrieves the request.
- $DB->update_record() -- saves the decision.
- redirect() -- returns to the coordinator dashboard.
12. Student Request Tracking
The student tracking page is implemented in:

my_requests.php

It displays only the training requests submitted by the currently
logged-in student.
Processing steps
1. Requires the user to log in.
2. Configures the Moodle page and loads custom CSS.
3. Retrieves requests using the current user's ID:
   $requests = $DB->get_records(
       'local_training_letter',
       ['userid' => $USER->id],
       'timecreated DESC'
   );
4. Displays an information message and a new-request link if no records
   are found.
5. Otherwise, creates a table containing company, training, date,
   status, remarks, and letter availability.
6. Displays the request status using CSS classes.
7. Displays coordinator remarks, or No remarks yet when none are
   available.
8. Displays a PDF download link only when the request status is
   Approved.
9. Displays Available after approval for requests that are not
   approved.
Important Moodle functions
  Function                 Purpose
  $USER->id              Identifies the current Moodle user.
$DB->get_records()     Retrieves that user's requests.
html_table()           Creates a table structure.
html_writer::tag()     Creates HTML elements.
html_writer::link()    Creates links.
html_writer::table()   Renders the table.
s()                    Escapes dynamic text.
clean_param()          Cleans a parameter.
userdate()             Formats a timestamp as a readable date.
13. PDF Letter Generation
PDF generation is implemented in:

generate_letter.php

The script creates a formal training request letter using Moodle's PDF
library.
Access checks
Before generating a letter, the script:
1. Requires the user to be logged in.
2. Reads the request ID from the URL.
3. Retrieves the matching request from the database.
4. Checks that the request's userid matches the current user's ID.
5. Checks that the request status is exactly Approved.
These checks prevent a student from using the script to download another
student's letter or generate a letter for a request that has not been
approved.
Coordinator information
If a coordinator ID is stored, the script retrieves the coordinator's
first and last name from Moodle's user table. If no coordinator name
is available, it uses the default designation:

Training and Placement Coordinator
PDF content
The generated letter includes:
- GNDEC logo.
- Guru Nanak Dev Engineering College letterhead.
- Training and Placement Cell heading.
- College address.
- Reference number and date.
- Company name and address.
- Subject line and formal request text.
- Student name, roll number, branch, and semester.
- Training type and duration.
- Proposed start date and joining date.
- Coordinator name and designation.
- Coordinator remarks.
- Authorized signature area.
- Institutional footer.
Reference number
The reference number is generated in this format:

GNDEC/TPC/YEAR/REQUEST_ID
Logo handling
The script checks whether pix/gndec-logo.png exists, is readable, and
is a valid image. If the logo is unavailable, a text placeholder is
used.
PDF generation process
1. Loads Moodle's PDF library using
   require_once($CFG->libdir . '/pdflib.php').
2. Creates a PDF object using new pdf().
3. Sets the creator, author, title, and subject.
4. Configures page margins and automatic page breaks.
5. Builds the letter using HTML and CSS.
6. Renders the HTML using $pdf->writeHTML().
7. Clears output buffers.
8. Sends the PDF to the browser using $pdf->Output() with the
   download option.
The generated filename follows this pattern:

Training_Request_Letter_REQUEST_ID.pdf

The letter includes an institutional authorization/signature notice. The
computer-generated PDF should not be treated as an officially signed
document until the required institutional authorization is provided.
14. Moodle Permissions and Capabilities
Permissions are defined in:

db/access.php

The plugin defines two capabilities.
  Capability                               Default archetype       Purpose
  local/training_letter:submitrequest    user                  Allows users with this
capability to submit
training requests.
local/training_letter:managerequests   manager               Allows users with this
capability to manage
requests.
Both capabilities use:
- captype = write
- contextlevel = CONTEXT_SYSTEM
- CAP_ALLOW for the specified default role archetype.
Where permissions are checked
- apply.php uses require_capability() to check request-submission
  permission.
- coordinator.php uses require_capability() to check
  request-management permission.
- update_status.php checks request-management permission before
  processing a decision.
- index.php uses has_capability() to decide whether to display the
  Coordinator Dashboard card.
Moodle capabilities are permission checks, not hard-coded role-name
checks. Administrators can assign these capabilities to other roles if
required.
15. Plugin Version and Compatibility
Plugin metadata is defined in:

version.php
  Setting                 Current value             Meaning
  Component               local_training_letter   Unique plugin component
name.

  Version                 2026102900              Internal version used
by Moodle to detect
updates.

  Requires                2024100700              Minimum Moodle core
version required.

  Maturity                MATURITY_ALPHA          Alpha development
stage.
Release                 0.1                     Human-readable release
number.
The component name follows Moodle's local plugin naming convention.
16. Language File
English language strings are defined in:

lang/en/local_training_letter.php

The file contains strings for:
- Plugin name.
- Training request form.
- Student and company field labels.
- Training type, duration, and dates.
- Submit request action.
- Pending, approved, and rejected statuses.
- Submission and management capability descriptions.
Moodle language strings are stored in the $string array and can be
retrieved using:
get_string('pluginname', 'local_training_letter');
The language strings are available to the plugin, although some labels
in the current pages are written directly in English rather than
retrieved using get_string().
17. Main Portal Dashboard
The main dashboard is implemented in:

index.php

It provides a central entry point for the plugin.
Dashboard sections
Welcome / Hero section

Displays:
- GNDEC logo.
- Training Letter Portal heading.
- College name.
- Training and Placement Cell name.
- Welcome description.
Quick action cards
- Apply for Training: Opens apply.php.
- My Requests: Opens my_requests.php.
- Coordinator Dashboard: Opens coordinator.php, but only if the
  user has the local/training_letter:managerequests capability.
How It Works

Explains the three main stages:
1. Submit Request.
2. Wait for Review.
3. Download Letter.
Footer

Displays the college name, location, and Training and Placement Cell
identification.

The page uses Moodle's html_writer, moodle_url, $PAGE, and
$OUTPUT APIs.
18. Moodle Navigation Integration
The plugin contains a navigation extension callback in:

lib.php

The function is:
local_training_letter_extend_navigation(global_navigation $navigation)
It:
1. Checks whether the user is logged in.
2. Excludes guest users.
3. Creates the portal URL using moodle_url().
4. Adds a custom Training Letter Portal item to Moodle's global
   navigation.
5. Uses Moodle's standard home icon through pix_icon().
Theme custom menu configuration
A separate portal link was also configured through Moodle's theme
settings:

Site administration → Appearance → Themes → Theme settings → Custom
menu items

The menu entry used was:
Training Letter Portal|/local/training_letter/index.php
This theme custom menu entry is separate from the callback in lib.php.
19. Installation Guide
These instructions assume that Moodle is already installed and running.
Step 1: Locate the Moodle installation
Find the Moodle site's main directory. The plugin must be placed inside
its local directory.

Example Windows development path:
C:\Users\Asus\Downloads\MoodleWindowsInstaller-latest-405\server\moodle\
Step 2: Copy the plugin folder
Copy the complete training_letter folder into:
moodle/local/
The final path should be:
moodle/local/training_letter/
Check that version.php is directly inside the training_letter
folder.
Step 3: Open Moodle as an administrator
Log in using a Moodle administrator account.
Step 4: Install the plugin
Open:

Site administration → Notifications

Moodle detects the new plugin and displays the installation or upgrade
screen.

Follow the on-screen instructions to complete installation.
Step 5: Verify installation
Confirm that Moodle recognizes the local plugin and that the database
table has been created.

The table is defined by:

local/training_letter/db/install.xml
Step 6: Configure permissions
The plugin defines these default capabilities:
- local/training_letter:submitrequest
- local/training_letter:managerequests
Review role permissions in Moodle and ensure that the intended students
and coordinators have the appropriate capabilities.
Step 7: Add the portal to the theme menu (optional)
To make the portal easy to find, configure the custom menu item:
Training Letter Portal|/local/training_letter/index.php
Use the theme settings path described in Section 18.
Step 8: Open the portal
Visit:
https://your-moodle-site/local/training_letter/index.php
For a local development installation, use the corresponding localhost
Moodle address.
20. How to Use the Plugin
Student workflow
1. Log in to Moodle using a student account.
2. Open the Training Letter Portal.
3. Select Apply for Training.
4. Fill in student details.
5. Enter company details.
6. Enter training information and dates.
7. Submit the form.
8. Open My Requests to view the submitted request.
9. Wait for the coordinator to review it.
10. If approved, select Download PDF to download the training
    request letter.
Coordinator workflow
1. Log in using an account with the
   local/training_letter:managerequests capability.
2. Open the Training Letter Portal.
3. Select Coordinator Dashboard.
4. Review student and training details.
5. Enter remarks.
6. Select Approved or Rejected.
7. Submit the decision.
8. The request status and remarks are saved in the database.
9. The student can view the updated status through My Requests.
21. Security and Data Handling
The plugin uses Moodle's built-in security and platform features.
Authentication
Pages and processing scripts use require_login() where required, so
users must be authenticated.
Capability checks
The submission and coordinator-management features use Moodle's Access
API to check capabilities.
Request ownership
The student tracking page retrieves records using the current user's ID.

The PDF generation script independently checks that the request belongs
to the current user.
Approval restriction
The PDF generation script checks that the request status is Approved
before generating a letter. Hiding the download link in the student
interface is not the only protection; the server-side script performs
its own check.
Session key validation
update_status.php uses require_sesskey() to validate the Moodle
session key before processing the coordinator's decision.
Input cleaning and output escaping
The form uses Moodle's parameter types, such as PARAM_TEXT. Processing
scripts use required_param() and optional_param(). Dynamic values
inserted into HTML are escaped using s().
Database access
The plugin uses Moodle's $DB API rather than building raw SQL queries
or opening a separate database connection.
22. Testing Checklist
The following checklist can be used for demonstration and project
evaluation.
  Test                                Expected result
  Open portal while logged out        Moodle requires login.

  Open portal as a logged-in student  Portal dashboard is displayed.

  Open application form               Student request form is displayed.

  Submit valid request                Request is saved with Pending
status.

  Submit invalid or incomplete        Moodle form validation displays
required fields                     errors.

  Enter joining date before start     Custom date validation displays an
date                                error.

  Open My Requests                    Only the current student's requests
are displayed.

  Open coordinator dashboard without  Access is denied.
permission                          

  Open coordinator dashboard with     Requests are displayed for review.
permission                          

  Approve a pending request           Status and remarks are saved.

  Reject a pending request            Status and remarks are saved.

  View request after coordinator      Updated status and remarks are
decision                            displayed.

  Download an approved request letter PDF is generated and downloaded.

  Try to download a pending or        PDF generation is denied.
rejected request                    

  Try to download another student's   PDF generation is denied.
letter                              
Inspect generated PDF               Letterhead, logo, student details,
company details, remarks, and
signature area are present.
23. Limitations and Future Enhancements
Possible future improvements include:
- Sending email notifications when a request is submitted or
  processed.
- Adding more detailed coordinator search and filtering options.
- Adding pagination for large numbers of requests.
- Providing request history and audit information.
- Supporting additional training categories and duration options.
- Improving accessibility and responsive design.
- Supporting additional language translations.
- Adding configurable institutional letterhead and signature
  information.
- Adding automated tests for form validation, permissions, and request
  processing.
- Introducing a formal upgrade script when the database schema
  changes.
These are possible enhancements and are not claims about features
currently implemented.
24. Conclusion
The Training Request Letter Generator demonstrates how Moodle can be
extended using a local plugin to support an institutional workflow.

It brings together Moodle authentication, capabilities, Forms API,
Database API, navigation, HTML output, and PDF generation.

Students can submit training requests and track their progress, while
authorized coordinators can review applications, record decisions, and
provide remarks. Once a request is approved, the student can download a
formal PDF training request letter.

The project provides a centralized and structured approach to managing
student industrial training requests within the Moodle environment.
Project: Training Request Letter Generator
Institution: Guru Nanak Dev Engineering College, Gill Park,
Ludhiana, Punjab
Department: Training and Placement Cell
Plugin component: local_training_letter
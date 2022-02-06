<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Spreadsheet user enrolment UI.
 *
 * @package    enrol_spreadsheet
 * @author     infinitail
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require('../../config.php');
require_once($CFG->dirroot.'/enrol/spreadsheet/manage_form.php');
require_once(__DIR__.'/libs/parser_proxy.php');

$enrolid      = required_param('enrolid', PARAM_INT);

$instance = $DB->get_record('enrol', ['id'=>$enrolid, 'enrol'=>'spreadsheet'], '*', MUST_EXIST);
$course   = $DB->get_record('course', ['id'=>$instance->courseid], '*', MUST_EXIST);
$context  = context_course::instance($course->id, MUST_EXIST);

require_login($course);
$canenrol = has_capability('enrol/spreadsheet:enrol', $context);
$canunenrol = has_capability('enrol/spreadsheet:unenrol', $context);

$PAGE->set_url('/enrol/spreadsheet/edit.php', ['enrolid'=>$enrolid]);
$PAGE->set_pagelayout('admin');

// Note: manage capability not used here because it is used for editing
// of existing enrolments which is not possible here.

if (!$canenrol and !$canunenrol) {
    // No need to invent new error strings here...
    require_capability('enrol/spreadsheet:enrol', $context);
    require_capability('enrol/spreadsheet:unenrol', $context);
}

$roleid = $instance->roleid;
$roles = get_assignable_roles($context);
$roles = ['0'=>get_string('none')] + $roles;

if (!isset($roles[$roleid])) {
    // Weird - security always first!
    $roleid = 0;
}

if (!$enrol_spreadsheet = enrol_get_plugin('spreadsheet')) {
    throw new coding_exception('Can not instantiate enrol_spreadsheet');
}

$instancename = $enrol_spreadsheet->get_instance_name($instance);

$plugin = enrol_get_plugin('spreadsheet');
$mform = new enrol_spreadsheet_manage_form(null, [$instance, $plugin, $context]);

if ($formdata = $mform->get_data()) {
    $filecontents = $mform->get_file_content('spreadsheetfile');

    $dryrun = true;
    if ($formdata->submitbutton === get_string('update')) {
        $dryrun = false;
    }

    // Get file extension
    $filename = $mform->get_new_filename('spreadsheetfile');
    preg_match('/\.([A-Za-z0-9]{1,4})$/', $filename, $matches);
    $ext = $matches[1] ?? null;

    // Prepare to process data
    $parser_proxy = new \enrol\spreadsheet\parser_proxy($ext);
    $parser_proxy->load_contents($filecontents);
    $parser_proxy->skip_headers($formdata->headerrows);
    $parser_proxy->set_idnumber_column_position($formdata->idnumbercolumnposition);

    // Step1: generate user list
    $users = [];
    while ($idnumber = $parser_proxy->fetch_idnumber()) {
        // Find user by idnumber
        if ($user = $DB->get_record('user', ['idnumber'=>$idnumber, 'deleted'=>0])) {
            $users[] = $user;
        } else {
            // TODO: Treat missing users
        }
    }
    //echo '<pre>'; var_dump($users); echo '</pre>'; die();

    // Step2: check user is already enroled
    $newusers = $users;
    foreach ($newusers as $key=>$user) {
        $ue = $DB->get_records('user_enrolments', ['enrolid'=>$instance->id, 'userid'=>$user->id]);
        if (!empty($ue)) {
            unset($newusers[$key]);  // remove enroled user from list
        }
    }
    //echo '<pre>'; var_dump($newusers); echo '</pre>'; die();

    // Step3: unenrol user not in the list (optional)
    $ues = [];
    if ($formdata->retainremovedusers === '0') {
        $ues = $DB->get_records('user_enrolments', ['enrolid'=>$instance->id]);  // get users in the course using the enrole plugin

        // compare two user list
        foreach ($ues as $key=>$ue) {
            foreach ($users as $user) {
                if ($user->id == $ue->userid) {
                    unset($ues[$key]);
                }
            }
        }
    }
    //echo '<pre>'; var_dump($ues); echo '</pre>'; die();

    // Step4
    if ($dryrun) {
        // Step4 (A): dryrun
        $enrolledusers = [];

        foreach ($newusers as $user) {
            $user->action = get_string('ADD', 'enrol_spreadsheet');
            $user->displayname = get_string('fullnamedisplay', 'moodle', $user);
            $user->enroltime   = '-';

            $enrolledusers[] = $user;
        }

        foreach ($ues as $ue) {
            $user = $DB->get_record('user', ['id'=>$ue->userid]);

            $user->action = get_string('DEL', 'enrol_spreadsheet');
            $user->displayname = get_string('fullnamedisplay', 'moodle', $user);
            $user->enroltime   = userdate($user->timecreated);

            $enrolledusers[] = $user;
        }

    } else {
        // Step4 (B): enrol / unenrol users
        foreach ($newusers as $user) {
            // get enrol plugins using in the course except guest
            $sql = "SELECT * FROM {enrol} WHERE courseid = :courseid AND enrol != 'guest'";
            $params = ['courseid' => $course->id];
            $rs = $DB->get_records_sql($sql, $params);

            $enrolplugins = new stdClass();
            foreach($rs as $record){
                $enrolplugins->{$record->enrol} = enrol_get_plugin($record->enrol);
            }

            $plugin->enrol_user($instance, $user->id, $roleid, time(), 0);
        }

        // remove enroled user not in file
        foreach ($ues as $ue) {
            $plugin->unenrol_user($instance, $ue->userid);  // remove users enroled by this instance
        }
    }
}

// Get enrolled users exclude dryrun mode
if (empty($dryrun)) {
    $sql = "SELECT * FROM {user} u
            JOIN {user_enrolments} ue ON (ue.userid = u.id AND ue.enrolid = :enrolid)";
    $params['enrolid'] = $instance->id;
    $enrolledusers = $DB->get_records_sql($sql, $params);

    $enrolledusers = array_values($enrolledusers);
    foreach ($enrolledusers as $key=>$user) {
        $enrolledusers[$key]->action = '-';
        $enrolledusers[$key]->displayname = get_string('fullnamedisplay', 'moodle', $user);
        $enrolledusers[$key]->enroltime   = userdate($user->timecreated);
    }
}

$PAGE->set_title($enrol_spreadsheet->get_instance_name($instance));
$PAGE->set_heading($course->fullname);
navigation_node::override_active_url(new moodle_url('/enrol/users.php', ['id'=>$course->id]));

echo $OUTPUT->header();
echo $OUTPUT->heading($instancename);

// Display file upload form
$mform->display();

// YUI auto generated table
if (empty($dryrun)) {
    echo html_writer::tag('h2', 'Enroled users: '.count($enrolledusers));

    if (!empty($formdata)) {
        echo html_writer::div(get_string('updatemessage', 'enrol_spreadsheet'), 'alert alert-success');
    }
} else {
    echo html_writer::tag('h2', get_string('dryrunresult', 'enrol_spreadsheet', count($enrolledusers)));
    echo html_writer::div(get_string('dryrunwarning', 'enrol_spreadsheet'), 'alert alert-warning');
}
echo html_writer::tag('table', '', ['class' => 'admintable generaltable datatable']);

$script = '
// Create a new YUI instance and populate it with the required modules.
YUI().use("datatable", function (Y) {
    var table = new Y.DataTable({
        columns: [
            { key: "action", label: "' . get_string('action') . '" },
            { key: "username", label: "' . get_string('username') . '" },
            { key: "displayname", label: "' . get_string('fullname') . '"},
            { key: "idnumber", label: "' . get_string('idnumber') . '", allowHTML: true, emptyCellValue: "<em>-</em>"},
            { key: "institution", label: "' . get_string('institution') . '"},
            { key: "department", label: "' . get_string('department') . '"},
            { key: "enroltime", label: "' . get_string('enroltime', 'enrol_spreadsheet') . '"},
        ],
        data: ' . json_encode($enrolledusers) . ',
        sortable: true
    }).render(".datatable").sort({ idnumber: "asc" });
});';
echo html_writer::script($script);

echo $OUTPUT->footer();

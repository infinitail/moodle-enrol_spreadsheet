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
 * Adds new instance of enrol_spreadsheet to specified course
 * or edits current instance.
 *
 * @package    enrol_spreadsheet
 * @author     Mitsuru Udagawa
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once($CFG->libdir.'/formslib.php');

class enrol_spreadsheet_manage_form extends moodleform {

    function definition() {
        global $COURSE;

        $mform = $this->_form;

        list($instance, $plugin, $context) = $this->_customdata;

        $mform->addElement('header', 'updateenrolement', get_string('updateenrolment', 'enrol_spreadsheet'));
        $mform->setExpanded('updateenrolement');

        // upload Spreadsheet file
        $mform->addElement('filepicker', 'spreadsheetfile', get_string('spreadsheetfile', 'enrol_spreadsheet'), null,
            ['maxbytes' => $COURSE->maxbytes, 'maxfiles' => 1, 'accepted_types' => ['xlsx', 'csv']]);
        $mform->addHelpButton('spreadsheetfile', 'spreadsheetfile', 'enrol_spreadsheet');
        $mform->addRule('spreadsheetfile', get_string('error'), 'required', '', 'server', false, false);

        // Select header rows
        $mform->addElement('select', 'headerrows', get_string('headerrows', 'enrol_spreadsheet'), range(0, 20));
        $mform->addHelpButton('headerrows', 'headerrows', 'enrol_spreadsheet');
        $mform->setDefault('headerrows', $plugin->get_config('headerrows'));

        // Select idnumber column position
        $mform->addElement('select', 'idnumbercolumnposition', get_string('idnumbercolumnposition', 'enrol_spreadsheet'),
            array_combine(range(1,10), range(1,10)));
        $mform->addHelpButton('idnumbercolumnposition', 'idnumbercolumnposition', 'enrol_spreadsheet');
        $mform->setDefault('idnumbercolumnposition', $plugin->get_config('idnumbercolumnposition'));

        // Retain existing users
        $mform->addElement('selectyesno', 'retainremovedusers', get_string('retainremovedusers', 'enrol_spreadsheet'));
        $mform->addHelpButton('retainremovedusers', 'retainremovedusers', 'enrol_spreadsheet');
        $mform->setDefault('retainremovedusers', $plugin->get_config('retain_removed_users'));

        // Override other enrolement
        //$mform->addElement('selectyesno', 'overrideotherenrolment', get_string('overrideotherenrolment', 'enrol_spreadsheet'));
        //$mform->addHelpButton('overrideotherenrolment', 'overrideotherenrolment', 'enrol_spreadsheet');
        //$mform->setDefault('overrideotherenrolment', $plugin->get_config('override_other_enrolment'));

        $buttonarray = [];
        $buttonarray[] = $mform->createElement('submit', 'submitbutton', get_string('dryrun', 'enrol_spreadsheet'));
        $buttonarray[] = $mform->createElement('submit', 'submitbutton', get_string('update'));
        //$buttonarray[] = $mform->createElement('cancel');
        $mform->addGroup($buttonarray, 'buttonar', '', ' ', false);

        $mform->addElement('hidden', 'enrolid', $instance->id);
        $mform->setType('enrolid', PARAM_INT);

        $this->set_data($instance);
    }

    function validation($data, $files) {
        global $DB;

        $errors = parent::validation($data, $files);

        return $errors;
    }
}

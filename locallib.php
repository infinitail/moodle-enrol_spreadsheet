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
 * Spreadsheet enrolment plugin.
 *
 * @package    enrol_spreadsheet
 * @author     infinitail
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * A bulk operation for the manual enrolment plugin to delete selected users enrolments.
 */
class enrol_spreadsheet_deleteselectedusers_operation extends enrol_bulk_enrolment_operation
{
    /**
     * Returns the title to display for this bulk operation.
     *
     * @return string
     */
    public function get_identifier() {
        return 'deleteselectedusers';
    }

    /**
     * Returns the identifier for this bulk operation. This is the key used when the plugin
     * returns an array containing all of the bulk operations it supports.
     *
     * @return string
     */
    public function get_title() {
        return get_string('deleteselectedusers', 'enrol_manual');
    }

    /**
     * Returns a enrol_bulk_enrolment_operation extension form to be used
     * in collecting required information for this operation to be processed.
     *
     * @param string|moodle_url|null $defaultaction
     * @param mixed $defaultcustomdata
     * @return enrol_manual_editselectedusers_form
     */
    public function get_form($defaultaction = null, $defaultcustomdata = null) {
        global $CFG;
        require_once($CFG->dirroot.'/enrol/spreadsheet/bulkchangeforms.php');
        if (!array($defaultcustomdata)) {
            $defaultcustomdata = [];
        }
        $defaultcustomdata['title']   = $this->get_title();
        $defaultcustomdata['message'] = get_string('confirmbulkdeleteenrolment', 'enrol_manual');
        $defaultcustomdata['button']  = get_string('unenrolusers', 'enrol_manual');
        return new enrol_spreadsheet_deleteselectedusers_form($defaultaction, $defaultcustomdata);
    }

    /**
     * Processes the bulk operation request for the given userids with the provided properties.
     *
     * @global moodle_database $DB
     * @param course_enrolment_manager $manager
     * @param array $userids
     * @param stdClass $properties The data returned by the form.
     */
    public function process(course_enrolment_manager $manager, array $users, stdClass $properties) {
        if (!has_capability('enrol/spreadsheet:unenrol', $manager->get_context())) {
            return false;
        }
        $counter = 0;
        foreach ($users as $user) {
            foreach ($user->enrolments as $enrolment) {
                $plugin = $enrolment->enrolmentplugin;
                $instance = $enrolment->enrolmentinstance;
                if ($plugin->allow_unenrol_user($instance, $enrolment)) {
                    $plugin->unenrol_user($instance, $user->id);
                    $counter++;
                }
            }
        }
        // Display a notification message after the bulk user unenrollment.
        if ($counter > 0) {
            \core\notification::info(get_string('totalunenrolledusers', 'enrol', $counter));
        }
        return true;
    }
}

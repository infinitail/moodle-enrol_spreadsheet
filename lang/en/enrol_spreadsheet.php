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
 * Strings for component 'enrol_spreadsheet', language 'en'.
 *
 * @package    enrol_spreadsheet
 * @author     infinitail
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$string['pluginname'] = 'Spreadsheet Enrol';
$string['pluginname_desc'] = 'Enrol users from CSV file exported from UNIPA EX';

$string['applychanges'] = 'Apply changes';
$string['spreadsheetfile'] = 'Spreadsheet file';
$string['spreadsheetfile_help'] = 'Select spreadsheet File';
$string['encoding'] = 'File encoding';
$string['enroltime'] = 'Enrol time';
$string['expiredaction'] = 'Enrolment expiration action';
$string['expiredaction_help'] = 'Select action to carry out when user enrolment expires. Please note that some user data and settings are purged from course during course unenrolment.';
$string['spreadsheet:manage'] = 'Manage user enrolments manually';
$string['spreadsheet:unenrol'] = 'Unenrol users from the course manually';
$string['mapping'] = 'Flat file role mapping';
$string['overrideotherenrolment'] = 'Override other enrolement';
$string['overrideotherenrolment_help'] = 'Allow override other enrolement';
$string['retainremovedusers'] = 'Retain users removed from CSV file';
$string['retainremovedusers_help'] = 'Yes - Retain users even if removed from CSV file
NO - Remove users if not in CSV file';
$string['enableplugin'] = 'Enable plugin';
$string['updateenrolment'] = 'Update enrolment';

$string['headerrows'] = 'Header Rows';
$string['headerrows_help'] = 'Ignore rows as header in Spreadsheet file';
$string['idnumbercolumnposition'] = get_string('idnumber').' column position';
$string['idnumbercolumnposition_help'] = 'The column position of '.get_string('idnumber');
$string['dryrun'] = 'Dry run';
$string['dryrunresult'] = 'Dry run result - Affected users: {$a}';
$string['dryrunwarning'] = 'This is dry run result. If you want to reflect changes, please click "UPDATE" button.';
$string['updatemessage'] = 'User enrolment as provided spreadsheet file.';
$string['ADD'] = 'ADD';
$string['DEL'] = 'DEL';

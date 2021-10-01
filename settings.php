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
 * Spreadsheet enrolments plugin settings and presets.
 *
 * @package    enrol_spreadsheet
 * @copyright  2021 infinitail
 * @author     infinitail
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once(__DIR__.'/adminlib.php');

if ($ADMIN->fulltree) {
    $settings->add(new admin_setting_heading('enrol_spreadsheet_settings', '', get_string('pluginname_desc', 'enrol_spreadsheet')));

    //$options = core_text::get_encodings();
    //array_unshift($options, 'auto');
    //$settings->add(new admin_setting_configselect('enrol_spreadsheet/encoding', get_string('encoding', 'enrol_spreadsheet'), '', 'auto', $options));

    //$options = array(ENROL_EXT_REMOVED_UNENROL        => get_string('extremovedunenrol', 'enrol'),
    //                 ENROL_EXT_REMOVED_KEEP           => get_string('extremovedkeep', 'enrol'),
    //                 ENROL_EXT_REMOVED_SUSPENDNOROLES => get_string('extremovedsuspendnoroles', 'enrol'));
    //$settings->add(new admin_setting_configselect('enrol_spreadsheet/unenrolaction', get_string('extremovedaction', 'enrol'), get_string('extremovedaction_help', 'enrol'), ENROL_EXT_REMOVED_SUSPENDNOROLES, $options));

    $settings->add(new admin_setting_configselect('enrol_spreadsheet/retain_removed_users',
        get_string('retainremovedusers', 'enrol_spreadsheet'), '', 0, [0=>'no', 1=>'yes']));
}

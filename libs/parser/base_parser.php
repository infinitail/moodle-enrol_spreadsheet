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
 * @package    enrol_spreadsheet
 * @author     infinitail
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace enrol\spreadsheet;

interface base_parser
{
    /**
     * Load spreadsheet file contents and prepare to process
     *
     * @param string $contents
     * @return bool
     */
    public function load_contents(string $contents);

    /**
     * Dispose header rows
     *
     * @param int $header_rows
     * @return void
     */
    public function skip_headers(int $header_rows);

    /**
     * Set idnumber column position
     *
     * @param int $col_position
     * @return void
     */
    public function set_idnumber_column_position(int $col_position);

    /**
     * Get single idnumber
     *
     * @param void
     * @return string|bool
     */
    public function fetch_idnumber();
}


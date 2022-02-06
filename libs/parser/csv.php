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

defined('MOODLE_INTERNAL') || die();

global $CFG;

require_once __DIR__.'/base_parser.php';

class csv implements base_parser {
    private $_csvdata;
    private $_col_position;

    public function load_contents($contents)
    {
        // Convert file encoding
        $contents = mb_convert_encoding($contents, 'utf-8', 'sjis-win, eucjp-win, auto');
        $this->_csvdata = explode("\n", $contents);

        return true;
    }

    public function skip_headers($header_rows)
    {
        for ($i=0; $i<$header_rows; $i++) {
            array_shift($this->_csvdata);
        }
    }

    public function set_idnumber_column_position($col_position)
    {
        $this->_col_position = $col_position;
    }

    public function fetch_idnumber()
    {
        foreach ($this->_csvdata as $row) {
            $line = str_getcsv($line);

            if (empty($line) || empty($line[$this->_col_position])) return false;

            return $line[$this->_col_position];
        }
    }
}

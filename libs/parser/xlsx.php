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
require_once "$CFG->libdir/phpspreadsheet/vendor/autoload.php";

class xlsx implements base_parser {
    private $_sheet;
    private $_row_counter = 1;
    private $_col_position = 1;

    public function load_contents($contents)
    {
        global $CFG;

        try {
            $tmpfile = tempnam($CFG->tempdir, 'enrol_spreadsheet_');
            file_put_contents($tmpfile, $contents);

            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            $book = $reader->load($tmpfile);
            $this->_sheet = $book->getActiveSheet();

            unlink($tmpfile);

            return true;
        } catch(Exception $e) {
            return false;
        }
    }

    public function skip_headers($header_rows)
    {
        $this->_row_counter += $header_rows;
    }

    public function set_idnumber_column_position($col_position)
    {
        $this->_col_position = $col_position;
    }

    public function fetch_idnumber()
    {
        $value = $this->_sheet->getCellByColumnAndRow($this->_col_position, $this->_row_counter)->getValue();
        $this->_row_counter++;

        return $value;
    }
}

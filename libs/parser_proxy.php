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

require_once __DIR__.'/parser/base_parser.php';

class parser_proxy implements base_parser
{
    private $_parser;

    public function __construct(string $ext)
    {
        if (!is_file(__DIR__."/parser/{$ext}.php")) {
            return false;
        }

        require_once __DIR__."/parser/{$ext}.php";
        $classname = "\\enrol\\spreadsheet\\{$ext}";
        $this->_parser = new $classname;

        return $this;
    }

    final public function load_contents($contents)
    {
        return $this->_parser->load_contents($contents);
    }

    final public function skip_headers($header_rows)
    {
        return $this->_parser->skip_headers($header_rows);
    }

    final public function set_idnumber_column_position($col_position)
    {
        return $this->_parser->set_idnumber_column_position($col_position);
    }

    final public function fetch_idnumber()
    {
        return $this->_parser->fetch_idnumber();
    }
}

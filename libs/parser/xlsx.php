<?php
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

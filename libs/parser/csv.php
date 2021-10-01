<?php

namespace enrol\spreadsheet;

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

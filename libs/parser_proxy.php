<?php

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

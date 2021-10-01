<?php

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


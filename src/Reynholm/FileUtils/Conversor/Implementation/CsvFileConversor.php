<?php

namespace Reynholm\FileUtils\Conversor\Implementation;

use Reynholm\FileUtils\Conversor\FileConversor;

class CsvFileConversor implements FileConversor {

    protected $delimiter = ';';
    protected $firstRowAsKeys = false;

    /**
     * @param string $delimiter
     */
    public function setDelimiter($delimiter)
    {
        $this->delimiter = $delimiter;
    }

    /**
     * @return string
     */
    public function getDelimiter()
    {
        return $this->delimiter;
    }

    /**
     * @param boolean $boolean
     */
    public function setFirstRowAsKeys($boolean)
    {
        $this->firstRowAsKeys = $boolean;
    }

    /**
     * Converts a file to an array
     * @param   $filePath
     * @param   integer $skipRows A number of rows to remove from the start
     * @return  array
     */
    public function toArray($filePath, $skipRows = 0)
    {
        /**
         * Returns associative array or simple array depending on the
         * firstRowAsKeys property
         */
        $getRows = function($keys, array $row) {
            if ($this->firstRowAsKeys === true) {
                return array_combine($keys, $row);
            }
            return $row;
        };

        $data = array();
        $keys = null;

        $handle = fopen($filePath, 'r');

        if ($this->firstRowAsKeys === true) {
            $keys = fgetcsv($handle, 0, $this->delimiter);
        }

        while ($row = fgetcsv($handle, 0, $this->delimiter)) {
            $data[] = $getRows($keys, $row);
        }

        fclose($handle);

        return array_slice($data, $skipRows);
    }
}
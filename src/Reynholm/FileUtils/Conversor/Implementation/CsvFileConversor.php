<?php

namespace Reynholm\FileUtils\Conversor\Implementation;

use Reynholm\FileUtils\Conversor\FileConversor;

class CsvFileConversor implements FileConversor {

    protected $delimiter = ';';

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
     * Converts a file to an array
     * @param   $filePath
     * @param   integer $skipRows A number of rows to remove from the start
     * @return  array
     */
    public function toArray($filePath, $skipRows = 0)
    {
        $data = array();

        $handle = fopen($filePath, 'r');

        while ($row = fgetcsv($handle, 0, $this->delimiter)) {
            $data[] = $row;
        }

        fclose($handle);

        return array_slice($data, $skipRows);
    }
}
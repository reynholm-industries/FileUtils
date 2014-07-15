<?php

namespace Reynholm\FileUtils\Conversor\Implementation;

use Reynholm\FileUtils\Conversor\FileConversor;

class ArrayConversor implements FileConversor {

    protected $delimiter = ';';

    /**
     * @param string $filePath
     * @param string $destinationPath
     * @return string
     */
    public function toXls($filePath, $destinationPath)
    {
        // TODO: Implement toXls() method.
        throw new \Exception('Not implemented yet');
    }

    /**
     * Converts a file into an array
     * @param   string $filePath
     * @param   integer $skipRows Number of rows to skip
     * @return  array
     */
    public function toArray($filePath, $skipRows = 0)
    {
        // TODO: Implement toArray() method.
        throw new \Exception('Not implemented yet');
    }

    /**
     * Set if the conversion should use the first row as the keys
     * @param $boolean
     * @return void
     */
    public function setFirstRowAsKeys($boolean)
    {
        // TODO: Implement setFirstRowAsKeys() method.
        throw new \Exception('Not implemented yet');
    }

    /**
     * @param string|array $filePath or data
     * @param string $destinationPath
     * @return string
     */
    public function toCsv($filePath, $destinationPath)
    {
        $handle = fopen($destinationPath, 'w');

        foreach ($filePath as $row) {
            fputcsv($handle, $row, $this->getDelimiter(), '"');
        }

        fclose($handle);

        return $destinationPath;
    }

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
}
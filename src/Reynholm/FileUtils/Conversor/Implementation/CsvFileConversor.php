<?php

namespace Reynholm\FileUtils\Conversor\Implementation;

use PHPExcel_IOFactory;
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

    /**
     * @param string $filePath
     * @param string $destinationPath
     * @return string
     */
    public function toXls($filePath, $destinationPath)
    {
        $objReader = $this->getReader('CSV');
        $objReader->setDelimiter($this->getDelimiter());

        $objPHPExcel = $objReader->load($filePath);
        $objWriter = $this->getWriter($objPHPExcel, 'Excel5');
        $objWriter->save($destinationPath);

        return $destinationPath;
    }

    /**
     * @param string $type
     * @return \PHPExcel_Reader_IReader
     */
    protected function getReader($type) {
        return PHPExcel_IOFactory::createReader($type);
    }

    /**
     * @param $objPHPExcel
     * @param $format
     * @return \PHPExcel_Writer_IWriter
     */
    protected function getWriter($objPHPExcel, $format) {
        return PHPExcel_IOFactory::createWriter($objPHPExcel, $format);
    }
}
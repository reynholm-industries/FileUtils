<?php

namespace Reynholm\FileUtils\Conversor\Implementation;

use PHPExcel_IOFactory;
use Reynholm\FileUtils\Conversor\Arrayable;
use Reynholm\FileUtils\Conversor\Xlsable;

class CsvFileConversor implements Arrayable, Xlsable {

    /**
     * @param string $origin
     * @param int $skipRows Number of rows to skip
     * @param bool $firstRowAsKeys
     * @param string $delimiter
     * @return array
     */
    public function toArray($origin, $skipRows = 0, $firstRowAsKeys = false, $delimiter = ';')
    {
        /**
         * Returns associative array or simple array depending on the
         * firstRowAsKeys property
         */
        $getRows = function($keys, array $row) use ($firstRowAsKeys) {
            if ($firstRowAsKeys === true) {
                return array_combine($keys, $row);
            }
            return $row;
        };

        $data = array();
        $keys = null;

        $handle = fopen($origin, 'r');

        if ($firstRowAsKeys === true) {
            $keys = fgetcsv($handle, 0, $delimiter);
        }

        while ($row = fgetcsv($handle, 0, $delimiter)) {
            $data[] = $getRows($keys, $row);
        }

        fclose($handle);

        return array_slice($data, $skipRows);
    }

    /**
     * @param string|array $origin Can be the origin file or an array depending on the implementation
     * @param string $destinationPath
     * @return string Returns the destinationPath
     */
    public function toXls($origin, $destinationPath)
    {
        $objReader = $this->getReader('CSV');

        $objPHPExcel = $objReader->load($origin);
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
<?php

namespace Reynholm\FileUtils\Conversor\Implementation;

use PHPExcel_IOFactory;
use Reynholm\FileUtils\Conversor\Csvable;
use Reynholm\FileUtils\Conversor\Jsonable;
use Reynholm\FileUtils\Conversor\Xlsable;

class ArrayConversor implements Csvable, Xlsable, Jsonable {

    /**
     * @param string|array $origin The origin file or data to convert depending on the implementation
     * @param string $destinationPath
     * @param bool $keysAsFirstRow
     * @param string $delimiter Character to delimite rows
     * @param string $enclosure Character to enclose strings
     * @return string The string with the destination path
     */
    public function toCsv($origin, $destinationPath, $keysAsFirstRow = false, $delimiter = ';', $enclosure = '"')
    {
        if ($keysAsFirstRow === true) {
            $keys = array_keys(current($origin));
            array_unshift($origin, $keys);
        }

        $handle = fopen($destinationPath, 'w');

        foreach ($origin as $row) {
            fputcsv($handle, $row, $delimiter, $enclosure);
        }

        fclose($handle);

        return $destinationPath;
    }

    /**
     * @param string|array $origin Can be the origin file or an array depending on the implementation
     * @param string $destinationPath
     * @param bool $keysAsFirstRow
     * @return string Returns the destinationPath
     */
    public function toXls($origin, $destinationPath, $keysAsFirstRow = false)
    {
        if ($keysAsFirstRow === true) {
            $keys = array_keys(current($origin));
            array_unshift($origin, $keys);
        }

        #@todo Remove the new. Not testeable
        $xls = new \PHPExcel();
        $xls->getActiveSheet()->fromArray($origin, null, 'A1');

        $objWriter = $this->getWriter($xls, 'Excel5');
        $objWriter->save($destinationPath);

        return $destinationPath;
    }

    /**
     * @param $objPHPExcel
     * @param $format
     * @return \PHPExcel_Writer_IWriter
     */
    protected function getWriter($objPHPExcel, $format) {
        return PHPExcel_IOFactory::createWriter($objPHPExcel, $format);
    }

    /**
     * @param string|array $origin Depending on the implementation it could be an array or an origin folder
     * @return string
     */
    public function toJson($origin)
    {
        return json_encode($origin);
    }
}
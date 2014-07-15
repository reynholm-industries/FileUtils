<?php

namespace Reynholm\FileUtils\Conversor\Implementation;

use PHPExcel_IOFactory;
use Reynholm\FileUtils\Conversor\Csvable;
use Reynholm\FileUtils\Conversor\Xlsable;

class ArrayConversor implements Csvable, Xlsable {

    /**
     * @param string|array $origin The origin file or data to convert depending on the implementation
     * @param string $destinationPath
     * @param string $delimiter Character to delimite rows
     * @param string $enclosure Character to enclose strings
     * @return string The string with the destination path
     */
    public function toCsv($origin, $destinationPath, $delimiter = ';', $enclosure = '"')
    {
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
     * @return string Returns the destinationPath
     */
    public function toXls($origin, $destinationPath)
    {
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

}
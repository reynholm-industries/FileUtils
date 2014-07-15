<?php

namespace Reynholm\FileUtils\Conversor\Implementation;

use PHPExcel_CachedObjectStorageFactory;
use PHPExcel_IOFactory;
use PHPExcel_Settings;
use Reynholm\FileUtils\Conversor\Arrayable;
use Reynholm\FileUtils\Conversor\Csvable;

class XlsFileConversor implements Csvable, Arrayable {

    function __construct()
    {
        $this->setPhpExcelCache();
    }

    /**
     * @param string|array $origin The origin file or data to convert depending on the implementation
     * @param string $destinationPath
     * @param string $delimiter Character to delimite rows
     * @param string $enclosure Character to enclose strings
     * @return string The string with the destination path
     */
    public function toCsv($origin, $destinationPath, $delimiter = ';', $enclosure = '"')
    {
        $reader = $this->getReader('Excel5');
        $excel = $reader->load($origin);

        /** @var \PHPExcel_Writer_CSV $writer */
        $writer = $this->getWriter($excel, 'CSV');
        $writer->setDelimiter($delimiter);
        $writer->setEnclosure($enclosure);
        $writer->save($destinationPath);

        return $destinationPath;
    }

    protected function getReader($reader) {
        return PHPExcel_IOFactory::createReader($reader);
    }

    protected function getWriter($excel, $writer) {
        return PHPExcel_IOFactory::createWriter($excel, $writer);
    }

    protected function setPhpExcelCache() {
        $cacheMethod = PHPExcel_CachedObjectStorageFactory::cache_to_phpTemp;
        $cacheSettings = array( 'memoryCacheSize' => '2GB');
        PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);
    }

    /**
     * @param string $origin
     * @param int $skipRows Number of rows to skip
     * @param bool $firstRowAsKeys
     * @param string $delimiter
     * @return array
     */
    public function toArray($origin, $skipRows = 0, $firstRowAsKeys = false, $delimiter = ';')
    {
        $reader = $this->getReader('Excel5');
        
        /** @var \PHPExcel $phpExcel */
        $phpExcel = $reader->load($origin);

        $data = $phpExcel->getActiveSheet()->toArray();

        while ($skipRows > 0) {
            array_shift($data);
            $skipRows--;
        }

        return $data;
    }
}
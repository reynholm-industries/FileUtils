<?php

namespace Reynholm\FileUtils\Factory;

use Reynholm\FileUtils\Conversor\Implementation\CsvFileConversor;
use Reynholm\FileUtils\Conversor\Implementation\XlsFileConversor;
use Reynholm\FileUtils\Conversor\Implementation\XlsxFileConversor;
use Reynholm\FileUtils\Factory\Exception\ConversorNotFoundException;
use Reynholm\FileUtils\Factory\Exception\ExtensionNotFoundException;

class ConversorFactory {

    /**
     * @param $file
     * @throws ExtensionNotFoundException
     * @return mixed
     */
    protected function getFileExtension($file) {
        $chunks = explode('.', $file);

        if (count($chunks) < 2) {
            throw new ExtensionNotFoundException('No extension found for file ' . $file);
        }

        return strtolower(end($chunks));
    }

    /**
     * @param $file
     * @throws ConversorNotFoundException
     * @return CsvFileConversor|XlsFileConversor|XlsxFileConversor
     */
    public function getConversorForFile($file) {

        $ext = $this->getFileExtension($file);

        switch($ext) {
            case 'xlsx': return new XlsxFileConversor();
            case 'xls': return new XlsFileConversor();
            case 'csv': return new CsvFileConversor();
        }

        throw new ConversorNotFoundException('No conversor found for ' . $ext . ' extension');
    }

} 
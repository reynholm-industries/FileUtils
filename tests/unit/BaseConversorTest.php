<?php

namespace unit;

use Codeception\TestCase\Test;
use PHPExcel_IOFactory;

class BaseConversorTest extends Test {

    protected function canRead($file, $readerType) {
        return PHPExcel_IOFactory::createReader($readerType)->canRead($file);
    }

    protected function canreadXls($file) {
        return $this->canRead($file, 'Excel5');
    }

    protected function canReadXlsx($file) {
        return $this->canRead($file, 'Excel2007');
    }

} 
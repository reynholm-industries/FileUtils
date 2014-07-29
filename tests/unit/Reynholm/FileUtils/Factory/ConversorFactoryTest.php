<?php

namespace unit\Reynholm\FileUtils\Factory;

use Codeception\Specify;

use Reynholm\FileUtils\Conversor\Implementation\CsvFileConversor;
use Reynholm\FileUtils\Conversor\Implementation\XlsFileConversor;
use Reynholm\FileUtils\Conversor\Implementation\XlsxFileConversor;
use Reynholm\FileUtils\Factory\ConversorFactory;
use unit\BaseConversorTest;

/**
 * Class ConversorFactoryTest
 * @package unit\Reynholm\FileUtils\Factory
 * @property ConversorFactory conversorFactory
 */
class ConversorFactoryTest extends BaseConversorTest
{
    use Specify;

    protected $conversorFactory;

    protected function _before()
    {
        $this->conversorFactory = new ConversorFactory();
    }

    protected function _after()
    {

    }

    public function testGetFileConversor()
    {
        $this->specify('Returns CsvFileConversor when csv file is given', function() {
            $conversor = $this->conversorFactory->getConversorForFile('test.csv');

            expect_that($conversor instanceof CsvFileConversor);
        });

        $this->specify('Returns XlsFileConversor when xls file is given', function() {
            $conversor = $this->conversorFactory->getConversorForFile('test.xls');

            expect_that($conversor instanceof XlsFileConversor);
        });

        $this->specify('Returns XlsxFileConversor when xlsx file is given', function() {
            $conversor = $this->conversorFactory->getConversorForFile('test.xlsx');

            expect_that($conversor instanceof XlsxFileConversor);
        });

        $this->specify('Throws exception when no extension is found', function() {
            $this->conversorFactory->getConversorForFile('test');
        }, ['throws' => 'Reynholm\FileUtils\Factory\Exception\ExtensionNotFoundException']);

        $this->specify('Throws exception when no file conversor is found', function() {
            $this->conversorFactory->getConversorForFile('test.pdf');
        }, ['throws' => 'Reynholm\FileUtils\Factory\Exception\ConversorNotFoundException']);
    }
}
<?php

namespace unit\Reynholm\FileUtils\Conversor\Implementation;

use Codeception\Specify;
use Codeception\TestCase\Test;

use Reynholm\FileUtils\Conversor\Implementation\ArrayConversor;
use Reynholm\FileUtils\Conversor\Implementation\CsvFileConversor;
use Reynholm\FileUtils\Conversor\Implementation\XlsFileConversor;

class XlsFileConversorTest extends Test
{
    use Specify;

    protected $simpleXlsFile;

    /** @var  XlsFileConversor */
    protected $xlsConversor;

    /** @var  CsvFileConversor */
    protected $csvConversor;

    protected function _before()
    {
        $this->simpleXlsFile       = getResourcePath('simpleXlsFile.xls');
        $this->xlsConversor = new XlsFileConversor();
        $this->csvConversor = new CsvFileConversor( new ArrayConversor() );
    }

    protected function _after()
    {

    }

    public function testConvertToCsv()
    {
        $this->specify("Can Convert To Csv", function() {
            $temporaryFile = getTemporaryFile();
            $result = $this->xlsConversor->toCsv($this->simpleXlsFile, $temporaryFile);
            $resultArray = $this->csvConversor->toArray($result);

            $expectedArray = array(
              array('title1', 'title2'),
              array('data1', 'data2'),
            );

            expect($resultArray)->equals($expectedArray);
        });
    }

}
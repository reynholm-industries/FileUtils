<?php

namespace unit\Reynholm\FileUtils\Conversor\Implementation;

use Codeception\Specify;

use Reynholm\FileUtils\Conversor\Implementation\ArrayConversor;
use Reynholm\FileUtils\Conversor\Implementation\CsvFileConversor;
use Reynholm\FileUtils\Conversor\Implementation\XlsxFileConversor;
use unit\BaseConversorTest;

class XlsxFileConversorTestTest extends BaseConversorTest
{
    use Specify;

    protected $simpleXlsxFile;
    protected $expectedArray = array(
        array('title1', 'title2'),
        array('data1', 'data2'),
    );
    protected $expectedArrayWithoutTitles = array(
        array('data1', 'data2'),
    );
    protected $expectedArrayWithKeys = array(
        array('title1' => 'data1', 'title2' => 'data2'),
    );

    protected $expectedJson = '[["title1","title2"],["data1","data2"]]';

    /** @var  XlsxFileConversor */
    protected $xlsxConversor;

    /** @var  CsvFileConversor */
    protected $csvConversor;

    protected function _before()
    {
        $this->simpleXlsxFile       = getResourcePath('simpleXlsxFile.xlsx');
        $this->xlsxConversor = new XlsxFileConversor();
        $this->csvConversor = new CsvFileConversor( new ArrayConversor() );
    }

    protected function _after()
    {

    }

    public function testXlsxToCsv()
    {
        $this->specify("Can Convert To Csv", function() {
            $temporaryFile = getTemporaryFile();
            $result = $this->xlsxConversor->toCsv($this->simpleXlsxFile, $temporaryFile);
            $resultArray = $this->csvConversor->toArray($result);

            expect($resultArray)->equals($this->expectedArray);
        });

        $this->specify('Throws exception when the origin file is not found', function() {
            $this->xlsxConversor->toCsv('unexistentFile.csv', getTemporaryFile());
        }, ['throws' => 'Reynholm\FileUtils\Conversor\Exception\FileNotFoundException']);


        $this->specify("Using first key as row is not appropriate for XLS", function() {
            $temporaryFile = tempnam('/temp', 'TMP');
            $this->xlsxConversor->toCsv($this->simpleXlsxFile, $temporaryFile, true);
        }, ['throws' => 'Reynholm\FileUtils\Conversor\Exception\OptionNotSupportedException']);
    }

    public function testXlsxToArray()
    {
        $this->specify("Can convert XLSX to Array", function() {
            $result = $this->xlsxConversor->toArray($this->simpleXlsxFile);
            expect($result)->equals($this->expectedArray);
        });

        $this->specify("Can convert XLSX to Array and skip rows", function() {
            $result = $this->xlsxConversor->toArray($this->simpleXlsxFile, 1);
            expect($result)->equals($this->expectedArrayWithoutTitles);
        });

        $this->specify("Can convert XLSX to Array using first row as keys", function() {
            $result = $this->xlsxConversor->toArray($this->simpleXlsxFile, 0, true);
            expect($result)->equals($this->expectedArrayWithKeys);
        });

        $this->specify('Throws exception when the origin file is not found', function() {
            $this->xlsxConversor->toArray('unexistentFile.csv');
        }, ['throws' => 'Reynholm\FileUtils\Conversor\Exception\FileNotFoundException']);
    }

    public function testXlsxToJson()
    {
        $this->specify("Can convert XLSX to Json", function() {
            $result = $this->xlsxConversor->toJson($this->simpleXlsxFile);
            expect($result)->equals($this->expectedJson);
        });

        $this->specify('Throws exception when the origin file is not found', function() {
            $this->xlsxConversor->toJson('unexistentFile.csv', getTemporaryFile());
        }, ['throws' => 'Reynholm\FileUtils\Conversor\Exception\FileNotFoundException']);

        $this->specify("Can convert XLSX to Json using first row as keys", function() {
            $result = $this->xlsxConversor->toJson($this->simpleXlsxFile, true);
            expect($result)->equals('[{"title1":"data1","title2":"data2"}]');
        });
    }

}
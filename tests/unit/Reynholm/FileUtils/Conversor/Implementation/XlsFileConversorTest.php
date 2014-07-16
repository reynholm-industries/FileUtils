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

    public function testXlsToCsv()
    {
        $this->specify("Can Convert To Csv", function() {
            $temporaryFile = getTemporaryFile();
            $result = $this->xlsConversor->toCsv($this->simpleXlsFile, $temporaryFile);
            $resultArray = $this->csvConversor->toArray($result);

            expect($resultArray)->equals($this->expectedArray);
        });

        $this->specify('Throws exception when the origin file is not found', function() {
            $this->xlsConversor->toCsv('unexistentFile.csv', getTemporaryFile());
        }, ['throws' => 'Reynholm\FileUtils\Conversor\Exception\FileNotFoundException']);


        $this->specify("Can convert an XLS to a CSV using keys as first rows", function() {
            $temporaryFile = tempnam('/temp', 'TMP');
            $result = $this->xlsConversor->toCsv($this->simpleXlsFile, $temporaryFile, true);

            $resultArray = $this->csvConversor->toArray($result, 0, false);
            expect($resultArray)->equals(
                array(
                    array('title1', 'title2'),
                    array('data1',  'data2'),
                )
            );
        });
    }

    public function testXlsToArray()
    {
        $this->specify("Can convert XLS to Array", function() {
            $result = $this->xlsConversor->toArray($this->simpleXlsFile);
            expect($result)->equals($this->expectedArray);
        });

        $this->specify("Can convert XLS to Array and skip rows", function() {
            $result = $this->xlsConversor->toArray($this->simpleXlsFile, 1);
            expect($result)->equals($this->expectedArrayWithoutTitles);
        });

        $this->specify("Can convert XLS to Array using first row as keys", function() {
            $result = $this->xlsConversor->toArray($this->simpleXlsFile, 0, true);
            expect($result)->equals($this->expectedArrayWithKeys);
        });

        $this->specify('Throws exception when the origin file is not found', function() {
            $this->xlsConversor->toArray('unexistentFile.csv');
        }, ['throws' => 'Reynholm\FileUtils\Conversor\Exception\FileNotFoundException']);
    }

    public function testXlsToJson()
    {
        $this->specify("Can convert XLS to Json", function() {
            $result = $this->xlsConversor->toJson($this->simpleXlsFile);
            expect($result)->equals($this->expectedJson);
        });

        $this->specify('Throws exception when the origin file is not found', function() {
            $this->xlsConversor->toJson('unexistentFile.csv', getTemporaryFile());
        }, ['throws' => 'Reynholm\FileUtils\Conversor\Exception\FileNotFoundException']);

        $this->specify("Can convert XLS to Json using first row as keys", function() {
            $result = $this->xlsConversor->toJson($this->simpleXlsFile, true);
            expect($result)->equals('[{"title1":"data1","title2":"data2"}]');
        });
    }

}
<?php

namespace unit\Reynholm\FileUtils\Conversor\Implementation;

use Codeception\Specify;

use Reynholm\FileUtils\Conversor\Implementation\ArrayConversor;
use Reynholm\FileUtils\Conversor\Implementation\CsvFileConversor;
use Reynholm\FileUtils\Conversor\Implementation\XlsFileConversor;
use Reynholm\FileUtils\Conversor\Implementation\XlsxFileConversor;
use unit\BaseConversorTest;

/**
 * Class ArrayConversorTestTest
 * @property ArrayConversor $arrayConversor
 * @property CsvFileConversor $csvConversor
 * @property XlsFileConversor $xlsConversor
 * @property XlsFileConversor $xlsxConversor
 */
class ArrayConversorTestTest extends BaseConversorTest
{
    use Specify;

    protected $arrayConversor;
    protected $csvConversor;
    protected $xlsConversor;
    protected $xlsxConversor;

    protected $exampleArray = array(
        array('CODIGO', 'NOMBRE',    'MARCA',   'MEDIDA',  'STOCK'),
        array('100',    'PRODUCT 1', 'BRAND 1', '1207017', 'BAJO'),
        array('200',    'PRODUCT 2', 'BRAND 2', '1208017', 'ALTO'),
        array('030',    'PRODUCT 3', 'BRAND 3', '1301518', 'AGOTADO')
    );

    protected $exampleArrayWithKeys = array(
        array('key1' => 'value1', 'key2' => 'value2'),
        array('key1' => 'value3', 'key2' => 'value4'),
    );

    protected $expectedExampleArrayWithKeys = array(
        array('key1',   'key2'),
        array('value1', 'value2'),
        array('value3', 'value4'),
    );

    protected function _before()
    {
        $this->arrayConversor = new ArrayConversor();
        $this->csvConversor   = new CsvFileConversor(new ArrayConversor());
        $this->xlsConversor   = new XlsFileConversor();
        $this->xlsxConversor  = new XlsxFileConversor();
    }

    protected function _after()
    {

    }

    public function testArrayToCsv()
    {
        $this->specify("Can convert an array to a CSV", function() {
            $temporaryFile = tempnam('/temp', 'TMP');
            $result = $this->arrayConversor->toCsv($this->exampleArray, $temporaryFile);

            $resultArray = $this->getCsvAsArray($result);
            expect($resultArray)->equals($this->exampleArray);
        });

        $this->specify("Can convert an array to a CSV using keys as first rows", function() {
            $temporaryFile = tempnam('/temp', 'TMP');
            $result = $this->arrayConversor->toCsv($this->exampleArrayWithKeys, $temporaryFile, true);

            $resultArray = $this->csvConversor->toArray($result, 0, false);
            expect($resultArray)->equals($this->expectedExampleArrayWithKeys);
        });
    }

    public function testArrayToXls()
    {
        $this->specify("Can convert an array to XLS", function() {
            $temporaryFile = tempnam('/temp', 'TMP');
            $result = $this->arrayConversor->toXls(array('1', '2', '3'), $temporaryFile);
            expect_that($this->canreadXls($result));
        });

        $this->specify("Can convert an array to XLS using keys as first rows", function() {
            $temporaryFile = tempnam('/temp', 'TMP');
            $data = array(
                array('key1' => 'value1', 'key2' => 'value2'),
                array('key1' => 'value3', 'key2' => 'value4'),
            );
            $expectedArray = array(
                array('key1', 'key2'),
                array('value1', 'value2'),
                array('value3', 'value4'),
            );

            $result = $this->arrayConversor->toXls($data, $temporaryFile, true);
            expect_that($this->canreadXls($result));

            $resultArray = $this->xlsConversor->toArray($result);
            expect($resultArray)->equals($expectedArray);
        });
    }

    public function testArrayToXlsx()
    {
        $this->specify("Can convert an array to XLSX", function() {
            $temporaryFile = tempnam('/temp', 'TMP');
            $result = $this->arrayConversor->toXlsx(array('1', '2', '3'), $temporaryFile);
            expect_that($this->canReadXlsx($result));
        });

        $this->specify("Can convert an array to XLSX using keys as first rows", function() {
            $temporaryFile = tempnam('/temp', 'TMP');
            $data = array(
                array('key1' => 'value1', 'key2' => 'value2'),
                array('key1' => 'value3', 'key2' => 'value4'),
            );
            $expectedArray = array(
                array('key1', 'key2'),
                array('value1', 'value2'),
                array('value3', 'value4'),
            );

            $result = $this->arrayConversor->toXlsx($data, $temporaryFile, true);
            expect_that($this->canReadXlsx($result));

            $resultArray = $this->xlsxConversor->toArray($result);
            expect($resultArray)->equals($expectedArray);
        });
    }

    public function testArrayToJson()
    {
        $this->specify("Can be converted to JSON", function() {
            $input = array(1, 2, 3);
            $result = $this->arrayConversor->toJson($input);

            expect($result)->equals("[1,2,3]");

            $input2 = array('key1' => 'value1', 'key2' => 2);
            $result2 = $this->arrayConversor->toJson($input2);

            expect($result2)->equals('{"key1":"value1","key2":2}');
        });

        $this->specify("Can be converted to JSON using first row as keys", function() {
            $data = array(
                array('key1',   'key2'),
                array('value1', 'value2'),
            );
            $expectedJson = '[{"key1":"value1","key2":"value2"}]';

            $result2 = $this->arrayConversor->toJson($data, true);

            expect($result2)->equals($expectedJson);
        });
    }

    protected function getCsvAsArray($filePath) {
        return $this->csvConversor->toArray($filePath);
    }

}
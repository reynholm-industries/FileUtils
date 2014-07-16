<?php

namespace unit\Reynholm\FileUtils\Conversor\Implementation;

use Codeception\Specify;
use Codeception\TestCase\Test;
use PHPExcel_IOFactory;
use Reynholm\FileUtils\Conversor\Implementation\ArrayConversor;
use Reynholm\FileUtils\Conversor\Implementation\CsvFileConversor;

/**
 * Class ArrayConversorTest
 * @property ArrayConversor $arrayConversor
 * @property CsvFileConversor $csvConversor
 * @property \PHPExcel_Reader_Excel5 $excelReader
 */
class ArrayConversorTest extends Test
{
    use Specify;

    protected $arrayConversor;
    protected $csvConversor;
    protected $excelReader;

    protected $exampleArray = array(
        array('CODIGO', 'NOMBRE',    'MARCA',   'MEDIDA',  'STOCK'),
        array('100',    'PRODUCT 1', 'BRAND 1', '1207017', 'BAJO'),
        array('200',    'PRODUCT 2', 'BRAND 2', '1208017', 'ALTO'),
        array('030',    'PRODUCT 3', 'BRAND 3', '1301518', 'AGOTADO')
    );

    protected function _before()
    {
        $this->arrayConversor = new ArrayConversor();
        $this->csvConversor   = new CsvFileConversor(new ArrayConversor());
        $this->excelReader = PHPExcel_IOFactory::createReader('Excel5');
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
    }

    public function testArrayToXls()
    {
        $this->specify("Can convert an array to XLS", function() {
            $temporaryFile = tempnam('/temp', 'TMP');
            $result = $this->arrayConversor->toXls(array('1', '2', '3'), $temporaryFile);
            expect_that($this->excelReader->canRead($result));
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
    }

    protected function getCsvAsArray($filePath) {
        return $this->csvConversor->toArray($filePath);
    }

}
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
        $this->arrayConversor = new ArrayConversor(new \PHPExcel());
        $this->csvConversor   = new CsvFileConversor();
        $this->excelReader = PHPExcel_IOFactory::createReader('Excel5');
    }

    protected function _after()
    {

    }

    public function testArrayIsConvertedToCsv()
    {
        $this->specify("Can convert an array to a CSV", function() {
            $temporaryFile = tempnam('/temp', 'TMP');
            $result = $this->arrayConversor->toCsv($this->exampleArray, $temporaryFile);

            $resultArray = $this->getCsvAsArray($result);
            expect($resultArray)->equals($this->exampleArray);
        });

    }

    public function testCanBeConvertedToXls()
    {
        $this->specify("Can convert an array to XLS", function() {
            $temporaryFile = tempnam('/temp', 'TMP');
            $result = $this->arrayConversor->toXls(array('1', '2', '3'), $temporaryFile);
            expect_that($this->excelReader->canRead($result));
        });
    }

    protected function getCsvAsArray($filePath) {
        return $this->csvConversor->toArray($filePath);
    }

}
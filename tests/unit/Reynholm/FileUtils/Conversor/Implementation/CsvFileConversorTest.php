<?php

namespace unit\Reynholm\FileUtils\Conversor\Implementation;

use Codeception\Specify;
use Codeception\TestCase\Test;
use PHPExcel_IOFactory;
use Reynholm\FileUtils\Conversor\Implementation\CsvFileConversor;

/**
 * Class CsvFileConversorTest
 * @property CsvFileConversor $csvConversor
 * @property string $filePath
 * @property \PHPExcel_Reader_Excel5 $excelReader
 */
class CsvFileConversorTest extends Test
{
    use Specify;

    protected $csvConversor;
    protected $filePath;
    protected $fileDelimitedWithCommaPath;
    protected $excelReader;

    protected $expectedArrayWithTitles = array(
        array('CODIGO', 'NOMBRE',    'MARCA',   'MEDIDA',  'STOCK'),
        array('100',    'PRODUCT 1', 'BRAND 1', '1207017', 'BAJO'),
        array('200',    'PRODUCT 2', 'BRAND 2', '1208017', 'ALTO'),
        array('030',    'PRODUCT 3', 'BRAND 3', '1301518', 'AGOTADO')
    );

    protected $expectedArrayWithTitlesAsKeys = array(
        array('CODIGO' => '100', 'NOMBRE' => 'PRODUCT 1', 'MARCA' => 'BRAND 1', 'MEDIDA' => '1207017', 'STOCK' => 'BAJO'),
        array('CODIGO' => '200', 'NOMBRE' => 'PRODUCT 2', 'MARCA' => 'BRAND 2', 'MEDIDA' => '1208017', 'STOCK' => 'ALTO'),
        array('CODIGO' => '030', 'NOMBRE' => 'PRODUCT 3', 'MARCA' => 'BRAND 3', 'MEDIDA' => '1301518', 'STOCK' => 'AGOTADO'),
    );

    protected $expectedArrayWithoutTitles = array(
        array('100',    'PRODUCT 1', 'BRAND 1', '1207017', 'BAJO'),
        array('200',    'PRODUCT 2', 'BRAND 2', '1208017', 'ALTO'),
        array('030',    'PRODUCT 3', 'BRAND 3', '1301518', 'AGOTADO')
    );

    protected $expectedArrayWithoutTwoFirstRows = array(
        array('200',    'PRODUCT 2', 'BRAND 2', '1208017', 'ALTO'),
        array('030',    'PRODUCT 3', 'BRAND 3', '1301518', 'AGOTADO')
    );

    protected function _before()
    {
        $this->csvConversor = new CsvFileConversor();

        $this->filePath = getResourcePath('productStock.csv');
        $this->fileDelimitedWithCommaPath = getResourcePath('productStockDelimitedByComma.csv');
        $this->excelReader = PHPExcel_IOFactory::createReader('Excel5');
    }

    protected function _after()
    {

    }

    public function testCsvIsParsedToArray()
    {

        $this->specify("Con convert to convert to array", function() {
            $result = $this->csvConversor->toArray($this->filePath);
            expect($result)->equals($this->expectedArrayWithTitles);
        });

        $this->specify("Can convert to array and jump a number of lines", function() {
            $result = $this->csvConversor->toArray($this->filePath, 1);
            expect($result)->equals($this->expectedArrayWithoutTitles);

            $result = $this->csvConversor->toArray($this->filePath, 2);
            expect($result)->equals($this->expectedArrayWithoutTwoFirstRows);
        });

    }

    public function testCsvIsParsedToArrayWithCommaDelimeter() {

        $this->specify("Can convert to array chaging the delimiter character", function() {
            $this->csvConversor->setDelimiter(",");

            $result = $this->csvConversor->toArray($this->fileDelimitedWithCommaPath);
            expect($result)->equals($this->expectedArrayWithTitles);
        });

    }

    public function testCsvIsParsedWithFirstRowAsKeys() {

        $this->specify("Sets the first row as the array keys", function() {
            $this->csvConversor->setFirstRowAsKeys(true);

            $result = $this->csvConversor->toArray($this->filePath);
            expect($result)->equals($this->expectedArrayWithTitlesAsKeys);
        });

    }

    public function testCsvIsParsedToXls()
    {
        $this->specify("Can convert to XLS", function() {
            $temporaryFile = tempnam('/temp', 'TMP');
            $result = $this->csvConversor->toXls($this->filePath, $temporaryFile);
            expect_that($this->excelReader->canRead($result));
        });
    }

}
<?php

use Reynholm\FileUtils\Conversor\Implementation\CsvFileConversor;

/**
 * Class CsvFileConversorTest
 * @property CsvFileConversor $csvConversor
 * @property string $filePath
 */
class CsvFileConversorTest extends \Codeception\TestCase\Test
{
    use Codeception\Specify;

    protected $csvConversor;

    protected $expectedArrayWithTitles = array(
        array('CODIGO', 'NOMBRE',    'MARCA',   'MEDIDA',  'STOCK'),
        array('100',    'PRODUCT 1', 'BRAND 1', '1207017', 'BAJO'),
        array('200',    'PRODUCT 2', 'BRAND 2', '1208017', 'ALTO'),
        array('030',    'PRODUCT 3', 'BRAND 3', '1301518', 'AGOTADO')
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

    protected $filePath;

    protected function _before()
    {
        $this->csvConversor = new CsvFileConversor();

        $this->filePath = getResourcePath('productStock.csv');
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

}
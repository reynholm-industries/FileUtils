<?php

namespace unit\Reynholm\FileUtils\Helper;

use Codeception\Specify;

use AspectMock\Test as test;
use Reynholm\FileUtils\Conversor\Implementation\CsvFileConversor;
use Reynholm\FileUtils\Factory\ConversorFactory;
use Reynholm\FileUtils\WebHelper\Exception\DataException;
use Reynholm\FileUtils\WebHelper\Table;
use unit\BaseConversorTest;

class TableTest extends BaseConversorTest
{
    use Specify;

    /** @var  Table */
    protected $tableHelper;

    protected function _before()
    {
        $this->tableHelper = new Table(new ConversorFactory());
    }

    protected function _after()
    {
        test::clean();
    }

    public function testGetHtml()
    {
        $this->specify('Exception is throwed when no data is given', function() {
            $this->tableHelper->getHtml();
        }, ['throws' => new DataException()]);

        $this->specify('Array is converted to html', function() {
            $this->tableHelper->setData( [ [1,2,3] ] );

            $result = $this->tableHelper->getHtml();
            expect($result)->equals('<table><tbody><tr><td>1</td><td>2</td><td>3</td></tr></tbody></table>');
        });

        $this->specify('Array is converted with keys as first row', function() {
            $this->tableHelper->setData( [ ['title1' => 1, 'title2' => 2, 'title3' => 3] ] );

            $result = $this->tableHelper->getHtml(true);
            expect($result)->equals('<table><thead><tr><th>title1</th><th>title2</th><th>title3</th></tr></thead><tbody><tr><td>1</td><td>2</td><td>3</td></tr></tbody></table>');
        });

        $this->specify('Array is converted with caption', function() {
            $this->tableHelper->setData( [ [1, 2, 3] ] );
            $result = $this->tableHelper->getHtml(false, 'Example Caption');
            expect($result)->equals('<table><caption>Example Caption</caption><tbody><tr><td>1</td><td>2</td><td>3</td></tr></tbody></table>');
        });

        $this->specify('File is converted to html', function() {
            $conversorFactoryDouble = test::double('Reynholm\FileUtils\Factory\ConversorFactory',
                    ['getConversorForFile' => new CsvFileConversor()]);

            $csvFile = getResourcePath('simpleCsvFile.csv');
            $this->tableHelper->setData($csvFile);

            $result = $this->tableHelper->getHtml();
            expect($result)->equals('<table><tbody><tr><td>title1</td><td>title2</td></tr><tr><td>data1</td><td>data2</td></tr></tbody></table>');

            $conversorFactoryDouble->verifyInvokedOnce('getConversorForFile', [$csvFile]);
        });
    }

}
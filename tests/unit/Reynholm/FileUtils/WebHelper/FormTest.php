<?php

namespace unit\Reynholm\FileUtils\Helper;

use Codeception\Specify;

use AspectMock\Test as test;
use Reynholm\FileUtils\Conversor\Implementation\CsvFileConversor;
use Reynholm\FileUtils\Factory\ConversorFactory;
use Reynholm\FileUtils\WebHelper\Form;
use unit\BaseConversorTest;

class FormTest extends BaseConversorTest
{
    use Specify;

    /** @var  Form */
    protected $formHelper;

    protected function _before()
    {
        $this->formHelper = new Form(new ConversorFactory());
    }

    protected function _after()
    {
        test::clean();
    }

    public function testArrayConversion()
    {
        $this->specify('Convert a file to an array', function() {

            $conversorFactoryDouble = test::double('Reynholm\FileUtils\Factory\ConversorFactory',
                ['getConversorForFile' => new CsvFileConversor()]
            );

            $csvFileConversorDouble = test::double('Reynholm\FileUtils\Conversor\Implementation\CsvFileConversor',
                ['toArray' => array(1, 2, 3)]
            );

            $result = $this->formHelper->fileToArray('test.tmp', 'realFile.csv');

            expect($result)->equals(array(1, 2, 3));

            $conversorFactoryDouble->verifyInvoked('getConversorForFile', ['realFile.csv']);
            $csvFileConversorDouble->verifyInvoked('toArray', ['test.tmp']);
        });

        $this->specify('Convert a file to an array with all parameters', function() {

            $conversorFactoryDouble = test::double('Reynholm\FileUtils\Factory\ConversorFactory',
                ['getConversorForFile' => new CsvFileConversor()]
            );

            $csvFileConversorDouble = test::double('Reynholm\FileUtils\Conversor\Implementation\CsvFileConversor',
                ['toArray' => array(1, 2, 3)]
            );

            $result = $this->formHelper->fileToArray('test.tmp', 'realFile.csv', 2, true, '\\t');

            expect($result)->equals(array(1, 2, 3));

            $conversorFactoryDouble->verifyInvoked('getConversorForFile', ['realFile.csv']);
            $csvFileConversorDouble->verifyInvoked('toArray', ['test.tmp', 2, true, '\\t']);
        });
    }

}
<?php

namespace unit\Reynholm\FileUtils\Conversor\Implementation;

use Codeception\Specify;
use Codeception\TestCase\Test;
use Reynholm\FileUtils\Conversor\Implementation\JsonConversor;

class JsonConversorTest extends Test {

    use Specify;

    /** @var  JsonConversor */
    protected $jsonConversor;

    protected function _before()
    {
        $this->jsonConversor = new JsonConversor();
    }

    protected function _after()
    {
    }

    public function testJsonToArray() {
        $this->specify('Can convert a simple json', function() {
            $input    = '[1,2,3]';
            $expected = array(1,2,3);
            $result   = $this->jsonConversor->toArray($input);

            expect($result)->equals($expected);
        });

        $this->specify('Can convert an associative json', function() {
            $input    = '{"key1": "value1","key2":2,"key3":"value3"}';
            $expected = array('key1' => 'value1', 'key2' => 2, 'key3' => 'value3');
            $result   = $this->jsonConversor->toArray($input);

            expect($result)->equals($expected);
        });

        $this->specify('Can convert to a multidimensional array', function() {
            $input    = '[1, 2, [3,4]]';
            $expected = array(
                    1, 2, array(3, 4)
                );
            $result   = $this->jsonConversor->toArray($input);

            expect($result)->equals($expected);
        });
    }

} 
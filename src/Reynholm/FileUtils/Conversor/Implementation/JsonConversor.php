<?php

namespace Reynholm\FileUtils\Conversor\Implementation;

use Reynholm\FileUtils\Conversor\Arrayable;

class JsonConversor implements Arrayable {

    /**
     * @param string $origin
     * @param int $skipRows Number of rows to skip
     * @param bool $firstRowAsKeys
     * @param string $delimiter
     * @throws \Reynholm\FileUtils\Conversor\Exception\FileNotFoundException
     * @return array
     */
    public function toArray($origin, $skipRows = 0, $firstRowAsKeys = false, $delimiter = ';')
    {
        return json_decode($origin, true);
    }

}
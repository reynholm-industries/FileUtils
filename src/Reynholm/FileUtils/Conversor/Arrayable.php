<?php

namespace Reynholm\FileUtils\Conversor;

interface Arrayable {

    /**
     * @param string $origin
     * @param int $skipRows Number of rows to skip
     * @param bool $firstRowAsKeys
     * @param string $delimiter
     * @return array
     */
    public function toArray($origin, $skipRows = 0, $firstRowAsKeys = false, $delimiter = ';');
}
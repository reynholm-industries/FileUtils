<?php

namespace Reynholm\FileUtils\Conversor;

interface Jsonable {

    /**
     * @param string|array $origin Depending on the implementation it could be an array or an origin folder
     * @throws \Reynholm\FileUtils\Conversor\Exception\FileNotFoundException
     * @return string
     */
    public function toJson($origin);
} 
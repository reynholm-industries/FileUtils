<?php

namespace Reynholm\FileUtils\Conversor;

interface Xlsable {

    /**
     * @param string|array $origin Can be the origin file or an array depending on the implementation
     * @param string $destinationPath
     * @throws \Reynholm\FileUtils\Conversor\Exception\FileNotFoundException
     * @return string Returns the destinationPath
     */
    public function toXls($origin, $destinationPath);
} 
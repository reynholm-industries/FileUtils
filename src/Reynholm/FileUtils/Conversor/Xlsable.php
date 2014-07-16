<?php

namespace Reynholm\FileUtils\Conversor;

interface Xlsable {

    /**
     * @param string|array $origin Can be the origin file or an array depending on the implementation
     * @param string $destinationPath
     * @param bool $keysAsFirstRow
     * @throws \Reynholm\FileUtils\Conversor\Exception\FileNotFoundException
     * @throws \Reynholm\FileUtils\Conversor\Exception\OptionNotSupportedException
     * @return string Returns the destinationPath
     */
    public function toXls($origin, $destinationPath, $keysAsFirstRow = false);
} 
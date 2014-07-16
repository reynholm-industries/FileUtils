<?php

namespace Reynholm\FileUtils\Conversor;

interface Csvable {

    /**
     * @param string|array $origin The origin file or data to convert depending on the implementation
     * @param string $destinationPath
     * @param bool $keysAsFirstRow
     * @param string $delimiter Character to delimite rows
     * @param string $enclosure Character to enclose string
     * @return string The string with the destination path
     */
    public function toCsv($origin, $destinationPath, $keysAsFirstRow = false, $delimiter = ';', $enclosure = '"');
} 
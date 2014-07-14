<?php

namespace Reynholm\FileUtils\Conversor;

interface FileConversor {

    /**
     * @param string $filePath
     * @param string $destinationPath
     * @return string
     */
    public function toXls($filePath, $destinationPath);

    /**
     * Converts a file into an array
     * @param   string $filePath
     * @param   integer $skipRows Number of rows to skip
     * @return  array
     */
    public function toArray($filePath, $skipRows = 0);

    /**
     * Set if the conversion should use the first row as the keys
     * @param $boolean
     * @return void
     */
    public function setFirstRowAsKeys($boolean);
} 
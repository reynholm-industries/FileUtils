<?php

namespace Reynholm\FileUtils\Conversor\Implementation;

use Reynholm\FileUtils\Conversor\Csvable;

class ArrayConversor implements Csvable {

    /**
     * @param string|array $origin The origin file or data to convert depending on the implementation
     * @param string $destinationPath
     * @param string $delimiter Character to delimite rows
     * @param string $enclosure Character to enclose strings
     * @return string The string with the destination path
     */
    public function toCsv($origin, $destinationPath, $delimiter = ';', $enclosure = '"')
    {
        $handle = fopen($destinationPath, 'w');

        foreach ($origin as $row) {
            fputcsv($handle, $row, $delimiter, $enclosure);
        }

        fclose($handle);

        return $destinationPath;
    }

}
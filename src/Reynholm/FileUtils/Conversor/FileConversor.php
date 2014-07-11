<?php

namespace Reynholm\FileUtils\Conversor;

interface FileConversor {

    /**
     * Convierte un archivo en un array.
     * Opcionalmente permite saltarse alguna de las primeras filas
     * como podrían ser los títulos o líneas en blanco
     * @param   $filePath
     * @param   integer $skipRows
     * @return  array
     */
    public function toArray($filePath, $skipRows = 0);
} 
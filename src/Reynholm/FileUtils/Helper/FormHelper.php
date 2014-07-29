<?php

namespace Reynholm\FileUtils\Helper;

use Reynholm\FileUtils\Factory\ConversorFactory;

class FormHelper
{

    /** @var ConversorFactory */
    protected $conversorFactory;

    public function __construct(ConversorFactory $conversorFactory)
    {
        $this->conversorFactory = $conversorFactory;
    }

    /**
     * @param string $tmpFile
     * @param string $realFileName
     * @param int $skipRows
     * @param bool $firstRowAsKeys
     * @param string $delimiter
     * @todo Not tested yet
     * @return array
     */
    public function fileToArray($tmpFile, $realFileName, $skipRows = 0, $firstRowAsKeys = false, $delimiter = ';') {
        $this->conversorFactory
            ->getConversorForFile($realFileName)
            ->toArray($tmpFile, $skipRows, $firstRowAsKeys, $delimiter);
    }

}
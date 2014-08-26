<?php

namespace Reynholm\FileUtils\WebHelper;

use Reynholm\FileUtils\Conversor\Exception\FileNotFoundException;
use Reynholm\FileUtils\Factory\ConversorFactory;
use Reynholm\FileUtils\Factory\Exception\ConversorNotFoundException;
use Reynholm\FileUtils\Factory\Exception\ExtensionNotFoundException;

/**
 * Class Form
 * @package Reynholm\FileUtils\WebHelper
 *
 * This class helps you when uploading csv, xls or xlsx files
 * so you can work with them without have to check what kind of file it is.
 */
class Form
{

    /** @var ConversorFactory */
    protected $conversorFactory;

    public function __construct(ConversorFactory $conversorFactory)
    {
        $this->conversorFactory = $conversorFactory;
    }

    /**
     * @param $originFile
     * @param string $realFileName
     * @param int $skipRows
     * @param bool $firstRowAsKeys
     * @param string $delimiter
     * @return array
     * @throws FileNotFoundException
     * @throws ConversorNotFoundException
     * @throws ExtensionNotFoundException
     */
    public function fileToArray($originFile, $realFileName, $skipRows = 0, $firstRowAsKeys = false, $delimiter = ';') {
        return $this->conversorFactory
            ->getConversorForFile($realFileName)
            ->toArray($originFile, $skipRows, $firstRowAsKeys, $delimiter);
    }

}

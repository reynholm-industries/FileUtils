<?php

namespace Reynholm\FileUtils\WebHelper;
use Reynholm\FileUtils\Factory\ConversorFactory;
use Reynholm\FileUtils\Factory\Exception\ConversorNotFoundException;
use Reynholm\FileUtils\Factory\Exception\ExtensionNotFoundException;
use Reynholm\FileUtils\WebHelper\Exception\DataException;

/**
 * Class Table
 * @package Reynholm\FileUtils\WebHelper
 *
 * Allows you the conversion from an array or a file to a HTML Table
 */
class Table {

    /** @var ConversorFactory  */
    protected $conversorFactory;

    /**
     * The data that is going to be showed as html table
     * @var array
     */
    protected $data;

    public function __construct(ConversorFactory $conversorFactory)
    {
        $this->conversorFactory = $conversorFactory;
    }

    /**
     * @param $data
     * @throws ConversorNotFoundException
     * @throws ExtensionNotFoundException
     */
    public function setData($data)
    {
        if (is_array($data)) {
            $this->data = $data;
        }
        else { //It is a file
            $this->data = $this->conversorFactory
                ->getConversorForFile($data)
                ->toArray($data);
        }
    }

    /**
     * @param bool $keysAsFirstRow
     * @param string $caption
     * @throws Exception\DataException
     * @return string
     */
    public function getHtml($keysAsFirstRow = false, $caption = null)
    {
        if ( empty($this->data) || ! is_array($this->data) ) {
            throw new DataException('No data was given or it is not an array');
        }

        $tableBody = '';

        if ( $caption !== null ) {
            $tableBody .= $this->createTag('caption', $caption);
        }

        //I need to clone the data so i can remove elements from it without modify the original data
        $data = $this->data;

        if ($keysAsFirstRow) {
            $keys = array_keys(reset($data));

            $tableTitles = '';

            foreach ($keys as $key) {
                $tableTitles .= $this->createTag('th', $key);
            }

            $trHead = $this->createTag('tr', $tableTitles);
            $tableBody .= $this->createTag('thead', $trHead);
        }

        $tableRows = '';

        foreach ($data as $row) {

            $tableCells = '';

            foreach ($row as $field) {
                $tableCells .= $this->createTag('td', $field);
            }

            $tableRows .= $this->createTag('tr', $tableCells);
        }

        $tableBody .= $this->createTag('tbody', $tableRows);

        return $this->createTag('table', $tableBody);
    }

    protected function createTag($tagName, $data) {
        return "<$tagName>$data</$tagName>";
    }

}
?>
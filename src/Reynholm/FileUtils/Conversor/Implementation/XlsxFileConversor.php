<?php

namespace Reynholm\FileUtils\Conversor\Implementation;

class XlsxFileConversor extends XlsFileConversor {

    function __construct()
    {
        parent::__construct();

        $this->setFileType('Excel2007');
    }

}
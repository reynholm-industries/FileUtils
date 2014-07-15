<?php
// This is global bootstrap for autoloading

if ( ! function_exists('getResourcePath') ) {
    function getResourcePath($resource) {
        return __DIR__
        . DIRECTORY_SEPARATOR . 'resources' . DIRECTORY_SEPARATOR . $resource;
    }
}

if ( ! function_exists('getTemporaryFile') ) {
    function getTemporaryFile() {
        return tempnam('/temp', 'TMP');
    }
}
<?php

spl_autoload_register(function ($class) {
    $filename = str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';
    if (file_exists($filename)) {
        require_once $filename;
    }
});
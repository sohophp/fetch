<?php

spl_autoload_register(function ($className) {
    $className = ltrim( $className,'\\');

    if (class_exists($className, false) || strpos($className, 'Sohophp\\Fetcher\\') !== 0) {
        var_dump(strpos($className, 'Sohophp\\Fetcher\\'));
        return false;
    }

    $filePath = __DIR__ . DIRECTORY_SEPARATOR . 'src' .
        DIRECTORY_SEPARATOR .
        str_replace('Sohophp\\Fetcher\\', '',$className)
        . '.php';


    if (file_exists($filePath) && is_readable($filePath)) {
        require($filePath);
        return true;
    } else {
        return false;
    }
});

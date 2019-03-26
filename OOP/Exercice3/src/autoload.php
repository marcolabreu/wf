<?php
declare(strict_types=1);

spl_autoload_register(function($className) {

	$file = __DIR__ . DIRECTORY_SEPARATOR . $className . '.php';
	if (is_file($file)) {
	    require_once $file;
    }
});
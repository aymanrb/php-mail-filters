<?php

include_once __DIR__ . '/../vendor/autoload.php';

$exampleFiles = glob(__DIR__ . DIRECTORY_SEPARATOR . 'example_*.php');

foreach ($exampleFiles as $exampleFile) {
    echo 'Running example file: ' . $exampleFile . PHP_EOL;

    include_once $exampleFile;
}

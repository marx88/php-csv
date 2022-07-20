<?php

namespace Marx\Csv\Test;

require_once __DIR__.'/../vendor/autoload.php';

$test = $_GET['test'];
$testMap = [
    'flush' => FlushExportTest::class,
];
if (!isset($testMap[$test])) {
    exit('error');
}

$class = new $testMap[$test]();
$class->test();

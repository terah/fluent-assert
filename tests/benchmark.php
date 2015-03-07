<?php


require_once 'src/Assert.php';

use Terah\Assert\Assert;
use Assert as Beberlei;

$assert = new Assert('');
Assert::that('');

echo "Benchmarking static Terah\\Assert";
$start = microtime(true);

for ( $i = 0 ; $i < 100000 ; $i++ )
{
    Assert::that(true)->true();
}
$time = microtime(true) - $start;
echo "Taken: $time" . PHP_EOL;

echo "Benchmarking new Terah\\Assert";
$start = microtime(true);

for ( $i = 0 ; $i < 100000 ; $i++ )
{
    (new Assert(true))->true();
}
$time = microtime(true) - $start;
echo "Taken: $time" . PHP_EOL;




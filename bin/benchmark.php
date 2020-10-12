<?php declare(strict_types=1);


require_once __DIR__ . '/../../../../vendor/autoload.php';

use Terah\Assert\Assert;

use Assert as Beberlei;

$assert = new Assert('');
Assert::that('');
Beberlei\that('');

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
    Assert::that(true)->true();
}
$time = microtime(true) - $start;
echo "Taken: $time" . PHP_EOL;

echo "Benchmarking fluent Beberlei";
$start = microtime(true);

for ( $i = 0 ; $i < 100000 ; $i++ )
{
    Beberlei\that(true)->true();
}
$time = microtime(true) - $start;
echo "Taken: $time" . PHP_EOL;


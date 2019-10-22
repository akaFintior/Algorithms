<?php
$n = 100;
            //при n = 100 скорость выполнения идентичных операций с foreach и ArrayIterator приблизительно равная,
            //при большем кол-ве элементов, foreach опережает ArrayIterator в разы

$array = range(0, $n);
$testArray = [];

$start = microtime(true);
foreach ($array as $value) {
    $testArray[$value] = $value * 2 . ' ';
}
echo microtime(true) - $start . PHP_EOL;

$array2 = new ArrayIterator($array);
$testArray2 = [];

$start2 = microtime(true);
while ($array2->valid()) {
    $testArray2[$array2->current()] = $array2->current() * 2;
    $array2->next();
}
echo microtime(true) - $start2;
<?php
function getPrime($n) {
    if ($n === 1) return 2;
    $num = 1;
    for ($i = 3; $num < $n; $i += 2) {
        $prime = true;
        for ($j = 3; $j < $i; $j += 2) {
            if ($i % $j === 0) {
                $prime = false;
            }
        }
        if ($prime) {
            $num++;
            $primeNumber = $i;
        }
    }
    return $primeNumber;
}


print getPrime(10001);
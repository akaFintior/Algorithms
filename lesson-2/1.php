<?php
function getMaxPrime($n) {
    $primes = [];
    while ($n !== 1) {
        for ($i = 2; $i <= $n; $i++) {
            if ($n % $i === 0) {
                $primes[] = $i;
                $n /= $i;
            }
        }
    }
    return max($primes);
}

echo getMaxPrime(600851475143);
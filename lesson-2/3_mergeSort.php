<?php
function mergeSort($mas) {    
    if(count($mas) <= 1) {
        return $mas;
    } else {
        $q = (int) (count($mas)/2);
        return merge(mergeSort(array_slice($mas, 0, $q)), mergeSort(array_slice($mas, $q)));
    }
}

function merge($leftMas, $rightMas) {    
    $twoMasCount = count($leftMas)+count($rightMas);
    
    $leftMas[] = INF;
    $rightMas[] = INF;
    
    $l = 0;
    $r = 0;
    
    for($i=0; $i<$twoMasCount; $i++) {
        if($leftMas[$l] <= $rightMas[$r]) {
            $mas[] = $leftMas[$l];
            $l++;
        } else {
            $mas[] = $rightMas[$r];
            $r++;
        }
    }
    
    return $mas;
}

$a = [1,5,8,6,3,4,9,0,4,7,3,14,23,24,1,4,5,43,5,9,56,34,2,3];

echo implode(', ', mergeSort($a));
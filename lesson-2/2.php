<?php
function getMaxStr($string) {
    $newStr = '';
    $maxStr = '';
    for ($i = 0; $i < strlen($string); $i++) {
        if (strpos($newStr, $string[$i]) === 0) {
            $newStr = substr($newStr, 1) . $string[$i];
        } else if (!strpos($newStr, $string[$i])) {
            $newStr .= $string[$i];
        } else {
            $newStr = $string[$i];
        }
        if (strlen($newStr) > strlen($maxStr)) {
            $maxStr = $newStr;
        }
    }
    return strlen($maxStr);
}

echo getMaxStr('abcdabcddrewlowl');
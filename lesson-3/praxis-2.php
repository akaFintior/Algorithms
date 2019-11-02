<?php

function checkWord($word) {
    if (strlen($word) === 1) return print "Yes";
    if ($word[0] !== $word[strlen($word) - 1]) return print "No";
    if (strlen($word) === 2) return print "Yes";
    return checkWord(substr($word,1,-1));
}

checkWord('alalamnnmalala');
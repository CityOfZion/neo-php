<?php

function swapEndian($input)
{
    $output = "";
    $length = strlen($input);
    for ($i=0;$i< $length;$i+=2) {
        $output .= substr($input, -($i+2), 2);
    }
    return $output;
}


// Function used for pushpoold solution checks
function word_reverse($str)
{
    $ret = '';
    while (strlen($str) > 0) {
        $ret .= substr($str, -8, 8);
        $str = substr($str, 0, -8);
    }
    return $ret;
}
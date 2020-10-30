<?php
function verificationPassword($var){
    $upper = preg_match('@[A-Z]@', $var);
    $lower = preg_match('@[a-z]@', $var);
    $number = preg_match('@[0-9]@', $var);
    if (strlen($var) >= 8 && $upper && $lower && $number){
        return true;
    } else {
        return false;
    }
}
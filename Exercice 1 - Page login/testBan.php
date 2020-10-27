<?php
session_start();
$bdd = new PDO('mysql:host=127.0.0.1;dbname=connexions', 'root', 'root');
//Retourne la vraie adresse IP
function get_ip() {
    if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else
        $ip = $_SERVER['REMOTE_ADDR'];
    return $ip;
}
<?php

require "Medoo.php";
use Medoo\Medoo;
$bdd = new Medoo([
    'database_type' => 'mysql',
    'database_name' => 'nbdd',
    'server' => 'localhost',
    'username' => 'root',
    'password' => 'root'
]);

<?php

return [
    'dsn'     => "mysql:host=blu-ray.student.bth.se;dbname=emsf14;", //blu-ray.student.bth.se
    'username'        => "emsf14",
    'password'        => "p,$75}jH", //p,$75}jH
    'driver_options'  => [PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'"],
    'table_prefix'    => "phpmvc_",
    //'verbose' => true,
    //'debug_connect' => 'true',
];

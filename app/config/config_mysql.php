<?php

return [
    'dsn'     => "mysql:host=localhost;dbname=emsf14;", //blu-ray.student.bth.se
    'username'        => "root",
    'password'        => "", //p,$75}jH
    'driver_options'  => [PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'"],
    'table_prefix'    => "puglife_",
    'verbose' => true,
    //'debug_connect' => 'true',
];

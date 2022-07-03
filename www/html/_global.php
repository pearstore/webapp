<?php 

session_start();
require_once('_function.php');

/* Legt die Parameter für die MySQL verbundung fest */
$_MYSQL = [
    "HOST" => "pearshop_db",
    "PORT" => 3306,
    "USER" =>"root",
    "PASSWD" => "",
    "DATABASE" => "pearstore_database"
];

$_USER = getUserbySession();

?>
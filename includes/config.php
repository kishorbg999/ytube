<?php

ob_start();
session_start();

date_default_timezone_set("America/New_York");

try {
    $con = new PDO("mysql:dbname=OF5seLKKxG;host=remotemysql.com;port=3306", "OF5seLKKxG", "fhG7JEtc9Z");
    // $con = new PDO("mysql:dbname=youtube;host=localhost", "root", "");
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
}
catch(PDOException $e){
    echo "Connection Failed" . $e->getMessage();
}

?>
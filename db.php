<?php

/* DATABASE CONFIGURATION */

$DB_HOST = "localhost";
$DB_USER = "root";
$DB_PASS = "";
$DB_NAME = "school_system";

/* CREATE CONNECTION */

$mysqli = new mysqli(
    $DB_HOST,
    $DB_USER,
    $DB_PASS,
    $DB_NAME
);

/* CHECK CONNECTION */

if($mysqli->connect_error){

    die(
        "Database Connection Failed: "
        . $mysqli->connect_error
    );
}

/* SET CHARACTER */

$mysqli->set_charset("utf8mb4");

?>
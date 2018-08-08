<?php
ob_start(); //turns on output_buffering
session_start();

$timezone = date_default_timezone_set('Europe/Zagreb');

//todo set PDO database connection
$con = mysqli_connect("localhost", "spajalica", "spajalica", "spajalica"); //Connection Variable

if (mysqli_connect_errno()) {
    echo "Failed to connect: " . mysqli_connect_errno();
}
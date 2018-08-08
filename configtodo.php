<?php


$putanjaAPP = "/Spajalica/";
$naslovAPP = "Spajalica";
$appID = "SPAJALICAAPP";

$host = "localhost";
$dbname = "spajalica";
$dbuser = "spajalica";
$dbpass = "spajalica";
$dev = true;

try {
    $veza = new PDO("mysql:host=" . $host . ";dbname=" . $dbname, $dbuser, $dbpass);
    $veza->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $veza->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, "SET NAMES 'utf8';");
    $veza->exec("SET NAMES 'utf8';");
} catch (PDOException $e) {

    switch ($e->getCode()) {
        case 1049;
            header("location: " . $putanjaAPP . "greske/kriviNazivBaze.html");
            exit;
            break;
        default:
            header("location: " . $putanjaAPP . "greske/greska.php?code=" . $e->getCode());
            exit;
            break;
    }

}

<?php
// config.php
$host = 'localhost';
$db   = 'salvaHof';
$user = 'root';
$pass = 'miguel';

$mysqli = new mysqli($host, $user, $pass, $db);

if ($mysqli->connect_error) {
    die('Erro ao conectar: ' . $mysqli->connect_error);
}

$mysqli->set_charset('utf8mb4');
?>

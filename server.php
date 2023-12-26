<?php
$hostname = '';
$database = '';
$username = '';
$password = '';

$mysqli = new mysqli($hostname, $username, $password, $database);

if ($mysqli->connect_error) {
    die('&#128308; Conexão falhou: ' . $mysqli->connect_error);
} else {
    echo '&#128994; Sucess connect DB -';
}
?>
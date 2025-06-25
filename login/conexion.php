<?php
$servername = "localhost";
$username = "yeraypadial";
$password = "srA4#7x14";
$dbname = "yeraypadial";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>

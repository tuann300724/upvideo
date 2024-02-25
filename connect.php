<?php
$servername = "localhost";
$username = "root";
$dbname = "test";
$password = "";
$port = 3306;
$conn = new mysqli($servername, $username, $password, $dbname , $port);
if($conn->connect_error) {
    die("Error connect : " . $conn->connect_error);
}
// echo "Connect"
?>
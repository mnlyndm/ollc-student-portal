<?php

$servername = "localhost";
$username = "root";
$password = "";
$database = "ollcinformationsystemadmin";

$conn = new mysqli ($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>
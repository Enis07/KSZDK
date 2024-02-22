<?php

session_start();

$servername = "localhost";
$db_username = "root";
$db_password = "";
$database_name = "test";

$conn = mysqli_connect( $servername, $db_username, $db_password,$database_name );
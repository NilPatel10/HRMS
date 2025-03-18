<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hrms_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if (!$conn) {
    die("connection failed" . mysqli_error($conn));
};


header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Credentials: true");
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Max-Age: 1000');
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Headers: Content-Type, Content-Range, Content-Disposition, Content-Description, X-Requested-With, Auth');
?>
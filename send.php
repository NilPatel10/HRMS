<?php

use function GuzzleHttp\json_decode;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'connection.php';

if (!isset($_GET['u_email']) || empty($_GET['u_email']) || !isset($_GET['u_phone']) || empty($_GET['u_phone']) || !isset($_GET['otp']) || empty($_GET['otp'])) {
    die("Required parameters (email, phone, OTP) are missing.");
}

$u_email = mysqli_real_escape_string($conn, trim($_GET['u_email']));
$u_phone = mysqli_real_escape_string($conn, trim($_GET['u_phone']));
$otp = mysqli_real_escape_string($conn, trim($_GET['otp']));


$query = "SELECT u_id, u_name FROM user_master WHERE u_email = '$u_email' AND u_phone = '$u_phone'";
$result = mysqli_query($conn, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $user_id = $row['u_id'];
    $user_name = $row['u_name'];

    include "mail.php"; 
    include "./mailer/send_mail.php"; 

} else {
    echo json_encode("Email and phone number not found in our system.");
}
?>

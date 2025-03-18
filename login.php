<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

include("connection.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if (isset($_POST["email"]) && isset($_POST["password"])) {
        $email = $_POST["email"];
        $password = $_POST["password"];

        // Query to check in login_data table
        $query_login = "SELECT * FROM user_master WHERE u_email = '$email' AND u_pass = '$password'";
        $result_login = mysqli_query($conn, $query_login);

        // Query to check in registration table
        $query_registration = "SELECT * FROM user_master WHERE u_email = '$email' AND u_pass = '$password'";
        $result_registration = mysqli_query($conn, $query_registration);

        if (mysqli_num_rows($result_login) > 0 || mysqli_num_rows($result_registration) > 0) {
            $response["message"] = "Login Successfully";
            $response["status"] = 200;
        } else {
            $response["message"] = "Invalid Credentials";
            $response["status"] = 201;
        }
    } else {
        $response["message"] = "Email and Password are required";
        $response["status"] = 201;
    }
} else {
    $response["message"] = "Only POST Request is allowed";
    $response["status"] = 201;
}

echo json_encode($response);
?>
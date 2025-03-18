<?php
include("connection.php");

$response = array();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["u_email"]) && isset($_POST["new_password"])) {
        $u_email = trim($_POST["u_email"]);
        $new_password = password_hash(trim($_POST["new_password"]), PASSWORD_BCRYPT);

        // Fetch user ID using email
        $userQuery = "SELECT u_id FROM user_master WHERE u_email = ?";
        $stmt = mysqli_prepare($conn, $userQuery);
        mysqli_stmt_bind_param($stmt, "s", $u_email);
        mysqli_stmt_execute($stmt);
        $userResult = mysqli_stmt_get_result($stmt);

        if ($row = mysqli_fetch_assoc($userResult)) {
            $u_id = $row["u_id"];

            // Update the password in user_master
            $updatePasswordQuery = "UPDATE user_master SET u_pass = ? WHERE u_id = ?";
            $stmt = mysqli_prepare($conn, $updatePasswordQuery);
            mysqli_stmt_bind_param($stmt, "si", $new_password, $u_id);
            mysqli_stmt_execute($stmt);

            $response["message"] = "Password Updated Successfully!";
            $response["status"] = 200;
        } else {
            $response["message"] = "User does not exist!";
            $response["status"] = 201;
        }
    } else {
        $response["message"] = "User Email and New Password are required!";
        $response["status"] = 201;
    }
} else {
    $response["message"] = "Only POST method is allowed!";
    $response["status"] = 201;
}

echo json_encode($response);
?>

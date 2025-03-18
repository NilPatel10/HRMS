<?php
include 'connection.php';

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['u_email']) && isset($_POST['u_pass'])) {
        
        $email = trim($_POST['u_email']);
        $password = trim($_POST['u_pass']);
        
        // Validate email format
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $response["message"] = "Invalid email format";
            $response["status"] = 201;
            echo json_encode($response);
            exit;
        }
        
        
        $sql = "SELECT u_id, u_name, u_email, u_pass, company_id FROM user_master WHERE u_email = ? AND u_is_delete = 0";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        if ($row = mysqli_fetch_assoc($result)) {
            // Verify password
            if (password_verify($password, $row['u_pass'])) {
                $response["message"] = "Login successful";
                $response["status"] = 200;
                $response["user"] = array(
                    "u_id" => $row['u_id'],
                    "u_name" => $row['u_name'],
                    "u_email" => $row['u_email'],
                    "company_id" => $row['company_id'] 
                );
            } else {
                $response["message"] = "Invalid password";
                $response["status"] = 201;
            }
        } else {
            $response["message"] = "Email not found";
            $response["status"] = 201;
        }
        
        mysqli_stmt_close($stmt);
    } else {
        $response["message"] = "Missing email or password";
        $response["status"] = 201;
    }
} else {
    $response["message"] = "Only POST method is allowed";
    $response["status"] = 201;
}

echo json_encode($response);
mysqli_close($conn);
?>

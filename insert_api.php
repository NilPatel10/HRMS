<?php
include 'connection.php';

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['insert'])) {
        
        $user_name = isset($_POST['u_name']) ? trim($_POST['u_name']) : null;
        $email = isset($_POST['u_email']) ? trim($_POST['u_email']) : null;
        $password = isset($_POST['u_pass']) ? trim($_POST['u_pass']) : null;
        $phone = isset($_POST['u_phone']) ? trim($_POST['u_phone']) : null;
        $gender = isset($_POST['u_gender']) ? trim($_POST['u_gender']) : null;
        $dept_id = isset($_POST['dept_id']) ? trim($_POST['dept_id']) : null;
        $position_id = isset($_POST['position_id']) ? trim($_POST['position_id']) : null;
        $salary = isset($_POST['u_salary']) ? trim($_POST['u_salary']) : null;
        $joining_date = isset($_POST['u_joining_date']) ? trim($_POST['u_joining_date']) : null;
        $dob = isset($_POST['u_dob']) ? trim($_POST['u_dob']) : null;
        $company_id = isset($_POST['company_id']) ? trim($_POST['company_id']) : null;
        $u_img = "default.png";

        // Validate required fields
        if (!$user_name || !$email || !$password || !$phone || !$dept_id || !$position_id || !$company_id) {
            $response["message"] = "Missing required fields";
            $response["status"] = 201;
            echo json_encode($response);
            exit;
        }

        // Validate email format
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $response["message"] = "Invalid email format";
            $response["status"] = 201;
            echo json_encode($response);
            exit;
        }
        
        // Validate phone number (10 digits only)
        if (!preg_match("/^[0-9]{10}$/", $phone)) {
            $response["message"] = "Invalid phone number. It should be 10 digits.";
            $response["status"] = 201;
            echo json_encode($response);
            exit;
        }
        
        // Check if email already exists
        $check_email_sql = "SELECT u_email FROM user_master WHERE u_email = ?";
        $stmt = mysqli_prepare($conn, $check_email_sql);
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) > 0) {
            $response["message"] = "Email already exists. Please use a different email.";
            $response["status"] = 201;
            echo json_encode($response);
            exit;
        }
        mysqli_stmt_close($stmt);

        // Encrypt password before saving
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        // Insert data using prepared statement
        $sql = "INSERT INTO user_master (u_name,u_img, u_email, u_pass, u_phone, u_gender, dept_id, position_id, u_salary, u_joining_date, u_dob, company_id) 
                VALUES (?,?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ssssssiidssi", 
            $user_name,
            $u_img, 
            $email, 
            $hashed_password, 
            $phone, 
            $gender, 
            $dept_id, 
            $position_id, 
            $salary, 
            $joining_date, 
            $dob, 
            $company_id
        );

        if (mysqli_stmt_execute($stmt)) {
            $response["message"] = "Data inserted Successfully";
            $response["status"] = 200;
        } else {
            $response["message"] = "Error executing query: " . mysqli_error($conn);
            $response["status"] = 201;
        }

        mysqli_stmt_close($stmt);
    } else {
        $response["message"] = "Invalid tag";
        $response["status"] = 201;
    }
} else {
    $response["message"] = "Only POST method is allowed";
    $response["status"] = 201;
}

echo json_encode($response);
mysqli_close($conn);
?>

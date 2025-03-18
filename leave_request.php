<?php
include 'connection.php';

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['insert'])) {
        
        $leave_type_id = isset($_POST['leave_type_id']) ? trim($_POST['leave_type_id']) : null;
        $reason = isset($_POST['l_reason']) ? trim($_POST['l_reason']) : null;
        $start_date = isset($_POST['l_start_date']) ? trim($_POST['l_start_date']) : null;
        $user_id = isset($_POST['u_id']) ? trim($_POST['u_id']) : null;
        $company_id = isset($_POST['company_id']) ? trim($_POST['company_id']) : null;

        // Validate required fields
        if (!$leave_type_id || !$reason || !$start_date || !$user_id || !$company_id) {
            $response["message"] = "Missing required fields";
            $response["status"] = 201;
            echo json_encode($response);
            exit;
        }

        // Convert start_date to DateTime and check if it's a weekend
        $dateObj = DateTime::createFromFormat('Y-m-d', $start_date);
        if (!$dateObj) {
            $response["message"] = "Invalid date format";
            $response["status"] = 201;
            echo json_encode($response);
            exit;
        }

        $dayOfWeek = $dateObj->format('N'); // 6 = Saturday, 7 = Sunday
        if ($dayOfWeek == 6 || $dayOfWeek == 7) {
            $response["message"] = "Leave cannot be applied on weekends";
            $response["status"] = 201;
            echo json_encode($response);
            exit;
        }

        // Check if the entered company_id matches the user's actual company_id
        $company_check_sql = "SELECT company_id FROM user_master WHERE u_id = ?";
        $company_check_stmt = mysqli_prepare($conn, $company_check_sql);
        mysqli_stmt_bind_param($company_check_stmt, "i", $user_id);
        mysqli_stmt_execute($company_check_stmt);
        mysqli_stmt_bind_result($company_check_stmt, $actual_company_id);
        mysqli_stmt_fetch($company_check_stmt);
        mysqli_stmt_close($company_check_stmt);

        if ($actual_company_id != $company_id) {
            $response["message"] = "Invalid company ID for the user";
            $response["status"] = 201;
            echo json_encode($response);
            exit;
        }

        // Check if the user has already applied for leave on the same day
        $check_sql = "SELECT l_id FROM leave_master WHERE u_id = ? AND l_start_date = ? AND is_delete = 0";
        $check_stmt = mysqli_prepare($conn, $check_sql);
        mysqli_stmt_bind_param($check_stmt, "is", $user_id, $start_date);
        mysqli_stmt_execute($check_stmt);
        mysqli_stmt_store_result($check_stmt);

        if (mysqli_stmt_num_rows($check_stmt) > 0) {
            $response["message"] = "You have already applied for leave on this date";
            $response["status"] = 201;
            echo json_encode($response);
            mysqli_stmt_close($check_stmt);
            exit;
        }
        mysqli_stmt_close($check_stmt);

        // Insert leave request
        $sql = "INSERT INTO leave_master (company_id, u_id, leave_type_id, l_reason, l_start_date) 
                VALUES (?, ?, ?, ?, ?)";

        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "iiiss", 
            $company_id, 
            $user_id, 
            $leave_type_id, 
            $reason, 
            $start_date
        );

        if (mysqli_stmt_execute($stmt)) {
            $response["message"] = "Leave request submitted successfully";
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

<?php
include 'connection.php';

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['delete'])) {
        
        $leave_id = isset($_POST['l_id']) ? trim($_POST['l_id']) : null;
        $user_id = isset($_POST['u_id']) ? trim($_POST['u_id']) : null;
        $company_id = isset($_POST['company_id']) ? trim($_POST['company_id']) : null;

        // Validate required fields
        if (!$leave_id || !$user_id || !$company_id) {
            $response["message"] = "Missing required fields";
            $response["status"] = 201;
            echo json_encode($response);
            exit;
        }

        // Check if the leave request exists and belongs to the user
        $check_sql = "SELECT company_id, is_delete FROM leave_master WHERE l_id = ? AND u_id = ? AND is_delete = 0";
        $check_stmt = mysqli_prepare($conn, $check_sql);
        mysqli_stmt_bind_param($check_stmt, "ii", $leave_id, $user_id);
        mysqli_stmt_execute($check_stmt);
        mysqli_stmt_bind_result($check_stmt, $actual_company_id, $is_deleted);
        mysqli_stmt_fetch($check_stmt);
        mysqli_stmt_close($check_stmt);

        if (!$actual_company_id) {
            $response["message"] = "Leave request not found or does not belong to the user";
            $response["status"] = 201;
            echo json_encode($response);
            exit;
        }

        // Ensure the company ID matches
        if ($actual_company_id != $company_id) {
            $response["message"] = "Invalid company ID for the user";
            $response["status"] = 201;
            echo json_encode($response);
            exit;
        }

        // Check if the leave is already deleted
        if ($is_deleted == 1) {
            $response["message"] = "Leave request is already deleted";
            $response["status"] = 201;
            echo json_encode($response);
            exit;
        }

        // Soft delete the leave request (mark as deleted instead of removing it)
        $soft_delete_sql = "UPDATE leave_master SET is_delete = 1 WHERE l_id = ? AND u_id = ?";
        $soft_delete_stmt = mysqli_prepare($conn, $soft_delete_sql);
        mysqli_stmt_bind_param($soft_delete_stmt, "ii", $leave_id, $user_id);

        if (mysqli_stmt_execute($soft_delete_stmt)) {
            $response["message"] = "Leave request deleted successfully";
            $response["status"] = 200;
        } else {
            $response["message"] = "Error executing query: " . mysqli_error($conn);
            $response["status"] = 201;
        }

        mysqli_stmt_close($soft_delete_stmt);
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

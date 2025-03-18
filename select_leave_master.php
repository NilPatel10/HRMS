<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

include("connection.php");

$response = array();

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if (isset($_POST["method"]) && $_POST["method"] == "select_leave") {

        $user_id = isset($_POST["u_id"]) ? intval($_POST["u_id"]) : 0;

        if ($user_id > 0) {
            $sql = "SELECT lm.l_id, lm.company_id, lm.u_id, 
                           lm.leave_type_id, lt.type_name AS leave_type, 
                           lm.l_reason, lm.l_start_date, 
                           lm.l_status_id, ls.status_name AS leave_status, 
                           lm.l_approved_by
                    FROM leave_master lm
                    JOIN leave_types lt ON lm.leave_type_id = lt.id
                    JOIN leave_statuses ls ON lm.l_status_id = ls.id
                    WHERE lm.u_id = ? AND is_delete = 0";
            
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "i", $user_id);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if (mysqli_num_rows($result) > 0) {
                $response["leave_data"] = array();
                while ($row = mysqli_fetch_assoc($result)) {
                    $leave = array(
                        "l_id" => $row["l_id"],
                        "company_id" => $row["company_id"],
                        "u_id" => $row["u_id"],
                        "leave_type_id" => $row["leave_type_id"],
                        "leave_type" => $row["leave_type"],
                        "l_reason" => $row["l_reason"],
                        "l_start_date" => $row["l_start_date"],
                        "l_status_id" => $row["l_status_id"],
                        "leave_status" => $row["leave_status"],
                        "l_approved_by" => $row["l_approved_by"]
                    );
                    array_push($response["leave_data"], $leave);
                }

                $response["message"] = "Leave records fetched successfully";
                $response["status"] = 200;
            } else {
                $response["message"] = "No leave records found";
                $response["status"] = 201;
            }

            mysqli_stmt_close($stmt);
        } else {
            $response["message"] = "Invalid user ID";
            $response["status"] = 400;
        }
    } else {
        $response["message"] = "Enter a valid method";
        $response["status"] = 201;
    }
} else {
    $response["message"] = "Only POST request is allowed";
    $response["status"] = 405;
}

echo json_encode($response);

?>

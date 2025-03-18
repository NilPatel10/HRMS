<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

header("Content-Type: application/json");
include 'connection.php';

$response = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!isset($_POST['user_id'], $_POST['month'], $_POST['year'])) {
        $response["message"] = "User ID, Month, and Year are required";
        $response["status"] = 201;
        echo json_encode($response);
        exit;
    }

    $user_id = intval($_POST['user_id']);
    $month = intval($_POST['month']);
    $year = intval($_POST['year']);
    $selected_month = sprintf("%04d-%02d", $year, $month);
    $today = date('Y-m-d');
    $current_year = date('Y');
    $current_month = date('m');

    // Validate that the month and year are not in the future
    if ($year > $current_year || ($year == $current_year && $month > $current_month)) {
        $response["message"] = "Invalid month or year. You cannot check for future dates.";
        $response["status"] = 201;
        echo json_encode($response);
        exit;
    }

    // Check if user exists and is active
    $user_sql = "SELECT company_id FROM user_master WHERE u_id = ? AND u_is_delete = 0";
    $stmt_user = mysqli_prepare($conn, $user_sql);
    mysqli_stmt_bind_param($stmt_user, "i", $user_id);
    mysqli_stmt_execute($stmt_user);
    $user_result = mysqli_stmt_get_result($stmt_user);
    $user = mysqli_fetch_assoc($user_result);
    mysqli_stmt_close($stmt_user);

    if (!$user) {
        $response["message"] = "User not found or is deleted.";
        $response["status"] = 201;
        echo json_encode($response);
        exit;
    }

    $company_id = $user['company_id'];

    // Loop through the selected month to find missing entries
    $start_date = "$year-$month-01";
    while (date('Y-m', strtotime($start_date)) == $selected_month && strtotime($start_date) < strtotime($today)) {
        $day_of_week = date('N', strtotime($start_date));

        // Check if date is a public holiday
        $holiday_check_sql = "SELECT COUNT(*) AS holiday_count FROM public_holidays WHERE holiday_date = ?";
        $stmt_holiday = mysqli_prepare($conn, $holiday_check_sql);
        mysqli_stmt_bind_param($stmt_holiday, "s", $start_date);
        mysqli_stmt_execute($stmt_holiday);
        $result_holiday = mysqli_stmt_get_result($stmt_holiday);
        $holiday = mysqli_fetch_assoc($result_holiday);
        mysqli_stmt_close($stmt_holiday);

        // Check if the user already has attendance for that day
        $check_attendance_sql = "SELECT COUNT(*) AS count FROM attendance_master WHERE u_id = ? AND a_date = ?";
        $stmt_check = mysqli_prepare($conn, $check_attendance_sql);
        mysqli_stmt_bind_param($stmt_check, "is", $user_id, $start_date);
        mysqli_stmt_execute($stmt_check);
        $result_check = mysqli_stmt_get_result($stmt_check);
        $attendance = mysqli_fetch_assoc($result_check);
        mysqli_stmt_close($stmt_check);

        if ($day_of_week < 6 && $holiday['holiday_count'] == 0 && $attendance['count'] == 0) { 
            // Insert absent entry
            $insert_sql = "INSERT INTO attendance_master (u_id, company_id, a_date, a_punch_in_time, a_status) VALUES (?, ?, ?, '00:00:00', 1)";
            $stmt_insert = mysqli_prepare($conn, $insert_sql);
            mysqli_stmt_bind_param($stmt_insert, "iis", $user_id, $company_id, $start_date);
            if (!mysqli_stmt_execute($stmt_insert)) {
                $response["error"] = "Insert Error: " . mysqli_error($conn);
            }
            mysqli_stmt_close($stmt_insert);
        }

        $start_date = date('Y-m-d', strtotime($start_date . ' +1 day'));
    }

    $response["message"] = "Absent records inserted successfully for missing days in the selected month.";
    $response["status"] = 200;
} else {
    $response["message"] = "Only POST method is allowed";
    $response["status"] = 201;
}

echo json_encode($response);
mysqli_close($conn);
?>

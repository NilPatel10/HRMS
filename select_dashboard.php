<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

include("connection.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["method"]) && $_POST["method"] == "select") {
        
        if (isset($_POST["u_id"])) {
            $u_id = mysqli_real_escape_string($conn, $_POST["u_id"]);
            $today_date = date("Y-m-d"); // Get today's date

            $sql = "SELECT um.u_id, am.a_punch_in_time, am.a_punch_out_time, am.a_date 
                    FROM user_master um 
                    JOIN attendance_master am ON um.u_id = am.u_id 
                    WHERE um.u_id = '$u_id' AND am.a_date = '$today_date'";

            $result = mysqli_query($conn, $sql);

            if ($result && mysqli_num_rows($result) > 0) {
                $response["attendance"] = array();
                while ($row = mysqli_fetch_assoc($result)) {
                    array_push($response["attendance"], [
                        "u_id" => $row["u_id"],
                        "a_punch_in_time" => $row["a_punch_in_time"],
                        "a_punch_out_time" => $row["a_punch_out_time"],
                        "a_date" => $row["a_date"]
                    ]);
                }
                $response["message"] = "Today's attendance found";
                $response["status"] = 200;
            } else {
                $response["message"] = "No attendance record found for today";
                $response["status"] = 201;
            }
        } else {
            $response["message"] = "User ID is required";
            $response["status"] = 201;
        }
    } else {
        $response["message"] = "Enter a valid method";
        $response["status"] = 201;
    }
} else {
    $response["message"] = "Only POST request is allowed";
    $response["status"] = 201;
}

header('Content-Type: application/json');
echo json_encode($response);
?>

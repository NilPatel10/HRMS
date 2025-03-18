<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

include("connection.php");

$response = array();

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if (isset($_POST["method"]) && $_POST["method"] == "select_leave") {

        $sql = "SELECT `id`, `type_name` FROM `leave_types`";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            $response["leave_types"] = array();
            while ($row = mysqli_fetch_assoc($result)) {
                $leave_type = array(
                    "id" => $row["id"],
                    "type_name" => $row["type_name"]
                );
                array_push($response["leave_types"], $leave_type);
            }

            $response["message"] = "Leave types fetched successfully";
            $response["status"] = 200;
        } else {
            $response["message"] = "No leave types found";
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

echo json_encode($response);

?>

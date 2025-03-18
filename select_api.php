<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

include("connection.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if (isset($_POST["method"]) && $_POST["method"] == "select") {

        if (isset($_POST["u_id"])) {
            $user_id = $_POST["u_id"];
            $sql = "SELECT * FROM `user_master` WHERE `u_id`='$user_id'";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                $response["selected_user"] = array();
                while ($row = mysqli_fetch_assoc($result)) {
                    $selected_user = array(
                        "user_id" => $row["u_id"],
                        "user_name" => $row["u_name"],
                        "password" => $row["u_pass"]
                    );
                    array_push($response["selected_user"], $selected_user);
                }

                $response["message"] = "Data found";
                $response["status"] = 200;
            } else {
                $response["message"] = "Data not found";
                $response["status"] = 201;
            }
        } else {
            $sql = "SELECT * FROM `user_master`";
            $result = mysqli_query($conn, $sql);
            $response["user"] = array();

            while ($row = mysqli_fetch_assoc($result)) {
                $user = array(
                    "user_id" => $row["u_id"],
                    "user_name" => $row["u_name"],
                    "password" => $row["u_pass"]
                );
                array_push($response["user"], $user);
            }

            $response["message"] = "All users fetched";
            $response["status"] = 200;
        }
    } else {
        $response["message"] = "Enter valid method";
        $response["status"] = 201;
    }
} else {
    $response["message"] = "Only POST Request is allowed";
    $response["status"] = 201;
}

echo json_encode($response);
?>
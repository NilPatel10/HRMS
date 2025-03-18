<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

include("connection.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if (isset($_POST["method"]) && $_POST["method"] == "select") {
        
        if (isset($_POST["dept_id"]) && isset($_POST["company_id"])) {
            $dept_id = mysqli_real_escape_string($conn, $_POST["dept_id"]);
            $company_id = mysqli_real_escape_string($conn, $_POST["company_id"]);
            
            $sql = "SELECT 
                        u.u_id AS user_id,
                        u.u_name AS user_name, 
                        p.position_name AS user_position
                    FROM user_master u
                    JOIN position_master p ON u.position_id = p.position_id
                    WHERE u.dept_id = '$dept_id' 
                    AND u.company_id = '$company_id'";

            $result = mysqli_query($conn, $sql);
            
            if ($result && mysqli_num_rows($result) > 0) {
                $response["employees"] = array();
                while ($row = mysqli_fetch_assoc($result)) {
                    $response["employees"][] = [
                        "user_id" => $row["user_id"],
                        "user_name" => $row["user_name"],
                        "user_position" => $row["user_position"]
                    ];
                }
                $response["message"] = "Data found";
                $response["status"] = 200;
            } else {
                $response["message"] = "Data not found";
                $response["status"] = 201;
            }
        } else {
            $response["message"] = "Department ID and Company ID are required";
            $response["status"] = 201;
        }
    } else {
        $response["message"] = "Enter valid method";
        $response["status"] = 201;
    }
} else {
    $response["message"] = "Only POST request is allowed";
    $response["status"] = 201;
}

header('Content-Type: application/json');
echo json_encode($response);
?>

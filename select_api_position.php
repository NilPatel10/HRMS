<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

include("connection.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if (isset($_POST["method"]) && $_POST["method"] == "select") {
        
        if (isset($_POST["dept_id"])) {
            $dept_id = mysqli_real_escape_string($conn, $_POST["dept_id"]);
            
            $sql = "SELECT pm.position_id, pm.position_name FROM dept_master dm 
                    JOIN position_master pm ON dm.dept_id = pm.dept_id 
                    WHERE dm.dept_id = '$dept_id'";
            
            $result = mysqli_query($conn, $sql);
            
            if ($result && mysqli_num_rows($result) > 0) {
                $response["positions"] = array();
                while ($row = mysqli_fetch_assoc($result)) {
                    array_push($response["positions"], [
                        "position_id" => $row["position_id"],
                        "position_name" => $row["position_name"]
                    ]);
                }
                $response["message"] = "Data found";
                $response["status"] = 200;
            } else {
                $response["message"] = "Data not found";
                $response["status"] = 201;
            }
        } else {
            $response["message"] = "Department ID is required";
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

<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

include("connection.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if (isset($_POST["method"]) && $_POST["method"] == "select_dept") {
        $company = $_POST['company_id'];

        $sql = "SELECT dm.dept_id, dm.dept_name,dm.company_id,cm.company_name FROM `dept_master` dm JOIN `company_master` cm ON cm.company_id = dm.company_id WHERE dm.company_id = $company;";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            $response["departments"] = array();
            while ($row = mysqli_fetch_assoc($result)) {
                $department = array(
                    "dept_id" => $row["dept_id"],
                    "dept_name" => $row["dept_name"]
                );
                array_push($response["departments"], $department);
            }

            $response["message"] = "Departments fetched successfully";
            $response["status"] = 200;
        } else {
            $response["message"] = "No departments found";
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

echo json_encode($response);

?>

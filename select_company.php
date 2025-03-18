<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

include("connection.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if (isset($_POST["method"]) && $_POST["method"] == "select_company") {

        $sql = "SELECT company_id, company_name FROM company_master";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            $response["company"] = array();
            while ($row = mysqli_fetch_assoc($result)) {
                $company = array(
                    "company_id" => $row["company_id"],
                    "company_name" => $row["company_name"]
                );
                array_push($response["company"], $company);
            }

            $response["message"] = "companies fetched successfully";
            $response["status"] = 200;
        } else {
            $response["message"] = "No companies found";
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

<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

include("connection.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if (isset($_POST["method"]) && $_POST["method"] == "fetch_holidays") {

        if (isset($_POST["company_id"]) && !empty($_POST["company_id"])) {
            $company_id = mysqli_real_escape_string($conn, $_POST["company_id"]);

            $sql = "SELECT holiday_name, holiday_date FROM public_holidays WHERE company_id = '$company_id' ORDER BY holiday_date";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                $response["holidays"] = array();
                while ($row = mysqli_fetch_assoc($result)) {
                    $holiday = array(
                        "holiday_name" => $row["holiday_name"],
                        "holiday_date" => $row["holiday_date"]
                    );
                    array_push($response["holidays"], $holiday);
                }

                $response["message"] = "Holidays fetched successfully";
                $response["status"] = 200;
            } else {
                $response["message"] = "No holidays found for this company";
                $response["status"] = 201;
            }
        } else {
            $response["message"] = "Company ID is required";
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

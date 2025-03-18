<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

include("connection.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if (isset($_POST["method"]) && $_POST["method"] == "get_user_by_email") {
        
        if (isset($_POST["u_email"]) && !empty($_POST["u_email"])) {
            $u_email = mysqli_real_escape_string($conn, $_POST["u_email"]);
            
            $sql = "SELECT 
                        u.u_id, u.u_name, u.u_email, u.u_pass, u.u_phone, u.u_gender, 
                        d.dept_id, d.dept_name, 
                        p.position_id, p.position_name, 
                        u.u_salary, u.u_joining_Date, u.u_created_date, u.u_modified_by, 
                        u.u_is_delete, u.u_dob, u.company_id, u.u_img
                    FROM user_master u
                    JOIN dept_master d ON u.dept_id = d.dept_id
                    JOIN position_master p ON u.position_id = p.position_id
                    WHERE u.u_email = '$u_email' AND u.u_is_delete = 0";
            
            $result = mysqli_query($conn, $sql);
            
            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);

                // Define base URL for images
                $image_base_url = "http://192.168.4.140/HMRS/uploads/profile/";

                // Check if image exists, otherwise use default
                $user_image = !empty($row["u_img"]) ? $image_base_url . $row["u_img"] : $image_base_url . "default.png";

                $response["user"] = array(
                    "u_id" => $row["u_id"],
                    "u_name" => $row["u_name"],
                    "u_email" => $row["u_email"],
                    "u_pass" => $row["u_pass"],
                    "u_phone" => $row["u_phone"],
                    "u_gender" => $row["u_gender"],
                    "dept_id" => $row["dept_id"],
                    "dept_name" => $row["dept_name"],
                    "position_id" => $row["position_id"],
                    "position_name" => $row["position_name"],
                    "u_salary" => $row["u_salary"],
                    "u_joining_Date" => $row["u_joining_Date"],
                    "u_created_date" => $row["u_created_date"],
                    "u_modified_by" => $row["u_modified_by"],
                    "u_is_delete" => $row["u_is_delete"],
                    "u_dob" => $row["u_dob"],
                    "company_id" => $row["company_id"],
                    "u_img" => $user_image
                );
                
                $response["message"] = "User fetched successfully";
                $response["status"] = 200;
            } else {
                $response["message"] = "User not found";
                $response["status"] = 201;
            }
        } else {
            $response["message"] = "Email is required";
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

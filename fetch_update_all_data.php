<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

include("connection.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    if (isset($_POST["method"]) && $_POST["method"] == "fetch_and_update_user") {
        $user_id = $_POST["u_id"];

        // Fetch user details
        $sql = "SELECT 
                    u.u_id, u.u_name, u.u_email, u.u_pass, u.u_phone, u.u_gender, 
                    d.dept_id, d.dept_name, 
                    p.position_id, p.position_name, 
                    u.u_salary, u.u_joining_Date, u.u_created_date, u.u_modified_by, 
                    u.u_dob, u.company_id, c.company_name, 
                    COALESCE(u.u_img, 'default.png') AS u_img
                FROM user_master u
                JOIN dept_master d ON u.dept_id = d.dept_id
                JOIN position_master p ON u.position_id = p.position_id
                JOIN company_master c ON u.company_id = c.company_id
                WHERE u.u_is_delete = 0 AND u.u_id = '$user_id'";

        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            $user = mysqli_fetch_assoc($result);

            // Check if the user has sent any updates
            $update_fields = [];
            if (!empty($_POST["u_name"])) {
                $update_fields[] = "u_name = '" . mysqli_real_escape_string($conn, $_POST["u_name"]) . "'";
                $user["u_name"] = $_POST["u_name"];
            }
            if (!empty($_POST["u_phone"])) {
                $update_fields[] = "u_phone = '" . mysqli_real_escape_string($conn, $_POST["u_phone"]) . "'";
                $user["u_phone"] = $_POST["u_phone"];
            }
            if (!empty($_POST["u_dob"])) {
                $update_fields[] = "u_dob = '" . mysqli_real_escape_string($conn, $_POST["u_dob"]) . "'";
                $user["u_dob"] = $_POST["u_dob"];
            }

            // Handle Image Upload
            if (isset($_FILES['user_img']) && $_FILES['user_img']['error'] === 0) {
                $target_dir = "../uploads/profile/";
                if (!is_dir($target_dir)) {
                    mkdir($target_dir, 0777, true);
                }

                $original_name = pathinfo($_FILES["user_img"]["name"], PATHINFO_FILENAME);
                $imageFileType = strtolower(pathinfo($_FILES["user_img"]["name"], PATHINFO_EXTENSION));
                $allowed_types = ["jpg", "jpeg", "png", "gif"];
                
                if (!in_array($imageFileType, $allowed_types)) {
                    $response['message'] = "Invalid image format. Only JPG, JPEG, PNG, and GIF allowed.";
                    $response['status'] = 201;
                    echo json_encode($response);
                    exit();
                }

                // Generate filename: user_id_filename.extension
                $clean_name = preg_replace("/[^a-zA-Z0-9]/", "", $original_name);
                $new_file_name = "user_" . $user_id . "_" . $clean_name . "." . $imageFileType;
                $target_file = $target_dir . $new_file_name;

                // Check file size (limit: 5MB)
                if ($_FILES["user_img"]["size"] > 5 * 1024 * 1024) {
                    $response['message'] = "File size exceeds 5MB limit.";
                    $response['status'] = 201;
                    echo json_encode($response);
                    exit();
                }

                if (move_uploaded_file($_FILES["user_img"]["tmp_name"], $target_file)) {
                    // Remove old image if exists
                    if (!empty($user["u_img"]) && $user["u_img"] !== 'default.png') {
                        $old_image_path = $target_dir . $user["u_img"];
                        if (file_exists($old_image_path)) {
                            unlink($old_image_path);
                        }
                    }
                    
                    $update_fields[] = "u_img = '$new_file_name'";
                    $user["u_img"] = $new_file_name;
                } else {
                    $response['message'] = "Failed to upload image.";
                    $response['status'] = 201;
                    echo json_encode($response);
                    exit();
                }
            }

            // If there are fields to update, execute the update query
            if (!empty($update_fields)) {
                $update_sql = "UPDATE user_master SET " . implode(", ", $update_fields) . " WHERE u_id = '$user_id'";
                
                if (mysqli_query($conn, $update_sql)) {
                    $response["message"] = "User data fetched & updated successfully";
                } else {
                    $response["message"] = "Failed to update user";
                }
            } else {
                $response["message"] = "User data fetched successfully (no updates made)";
            }

            $response["status"] = 200;
            $response["user"] = $user;
        } else {
            $response["message"] = "User not found";
            $response["status"] = 404;
        }
    } else {
        $response["message"] = "Invalid method";
        $response["status"] = 400;
    }
} else {
    $response["message"] = "Only POST requests allowed";
    $response["status"] = 405;
}

echo json_encode($response);

?>

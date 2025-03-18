<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

include("connection.php");

header("Content-Type: application/json");

$response = array();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["method"]) && $_POST["method"] == "update_user") {
        if (!empty($_POST["u_id"])) {
            $u_id = mysqli_real_escape_string($conn, $_POST["u_id"]);
            $updateFields = [];

            foreach (["u_name", "u_phone", "u_dob"] as $field) {
                if (!empty($_POST[$field])) {
                    $updateFields[] = "$field = '" . mysqli_real_escape_string($conn, $_POST[$field]) . "'";
                }
            }

            // Handle Image Upload
            if (isset($_FILES['user_img']) && $_FILES['user_img']['error'] === 0) {
                $target_dir = __DIR__ . "/uploads/profile/";

                // Ensure directory exists and is writable
                if (!is_dir($target_dir) && !mkdir($target_dir, 0777, true) && !is_dir($target_dir)) {
                    error_log("Failed to create upload directory: " . $target_dir);
                    echo json_encode(["status" => 201, "message" => "Failed to create upload directory."]);
                    exit();
                }

                $imageFileType = strtolower(pathinfo($_FILES["user_img"]["name"], PATHINFO_EXTENSION));
                $allowedTypes = ["jpg", "jpeg", "png", "gif"];

                if (!in_array($imageFileType, $allowedTypes)) {
                    echo json_encode(["status" => 201, "message" => "Invalid image format. Only JPG, JPEG, PNG, and GIF allowed."]);
                    exit();
                }

                if ($_FILES["user_img"]["size"] > 5 * 1024 * 1024) {
                    echo json_encode(["status" => 201, "message" => "File size exceeds 5MB limit."]);
                    exit();
                }

                // Generate a random file name
                $new_file_name = uniqid("user_") . "." . $imageFileType;
                $target_file = $target_dir . $new_file_name;

                // Move file and check for errors
                if (!move_uploaded_file($_FILES["user_img"]["tmp_name"], $target_file)) {
                    error_log("Failed to move uploaded file: " . $_FILES["user_img"]["tmp_name"] . " -> " . $target_file);
                    echo json_encode(["status" => 201, "message" => "File upload failed."]);
                    exit();
                }

                chmod($target_file, 0644);

                // Get old image
                $old_img_query = "SELECT COALESCE(u_img, 'default.png') AS u_img FROM user_master WHERE u_id = '$u_id'";
                $old_img_result = mysqli_query($conn, $old_img_query);

                if ($old_img_result) {
                    $old_img = mysqli_fetch_assoc($old_img_result)['u_img'];

                    // Delete old image if it exists and is not the default
                    if ($old_img !== 'default.png' && file_exists($target_dir . $old_img)) {
                        unlink($target_dir . $old_img);
                    }
                }

                $updateFields[] = "u_img = '$new_file_name'";
            }

            if (!empty($updateFields)) {
                $sql = "UPDATE user_master SET " . implode(", ", $updateFields) . " WHERE u_id = '$u_id' AND u_is_delete = 0";
                if (mysqli_query($conn, $sql)) {
                    $response["status"] = 200;
                    $response["message"] = "User updated successfully";
                } else {
                    $response["status"] = 201;
                    $response["message"] = "Database error: " . mysqli_error($conn);
                }
            } else {
                $response = ["status" => 201, "message" => "No changes made."];
            }
        } else {
            $response = ["status" => 201, "message" => "User ID (u_id) is required"];
        }
    } else {
        $response = ["status" => 201, "message" => "Invalid method"];
    }
} else {
    $response = ["status" => 201, "message" => "Only POST requests are allowed"];
}

echo json_encode($response);

?>
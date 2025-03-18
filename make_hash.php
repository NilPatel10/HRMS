<?php
include 'connection.php';

$sql = "SELECT u_id, u_pass FROM user_master";
$result = mysqli_query($conn, $sql);

while ($row = mysqli_fetch_assoc($result)) {
    // Check if the password is already hashed (length of bcrypt hash is 60)
    if (strlen($row['u_pass']) < 60) {
        $hashed_password = password_hash($row['u_pass'], PASSWORD_BCRYPT);
        $update_sql = "UPDATE user_master SET u_pass = ? WHERE u_id = ?";
        $update_stmt = mysqli_prepare($conn, $update_sql);
        mysqli_stmt_bind_param($update_stmt, "si", $hashed_password, $row['u_id']);
        mysqli_stmt_execute($update_stmt);
        mysqli_stmt_close($update_stmt);
    }
}

echo "Passwords updated successfully!";
mysqli_close($conn);
?>

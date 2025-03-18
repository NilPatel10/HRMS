<?php
include 'connection.php';

date_default_timezone_set("Asia/Kolkata");

$u_id = 0;
$otp = "No Active OTP";
$user_name = "User";

// ✅ Fetch latest OTP and user details
$query_uid = "SELECT u_id, otp_code FROM otp_master WHERE otp_status = 0 ORDER BY otp_created_at DESC LIMIT 1";
$result_uid = mysqli_query($conn, $query_uid);

if ($result_uid && mysqli_num_rows($result_uid) > 0) {
    $row = mysqli_fetch_assoc($result_uid);
    $u_id = intval($row['u_id']);
    $otp = $row['otp_code'];
}

if ($u_id > 0) {
    $query_user = "SELECT u_name, u_email FROM user_master WHERE u_id = ?";
    
    if ($stmt = mysqli_prepare($conn, $query_user)) {
        mysqli_stmt_bind_param($stmt, "i", $u_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) > 0) {
            mysqli_stmt_bind_result($stmt, $user_name, $user_email);
            mysqli_stmt_fetch($stmt);
        }
        mysqli_stmt_close($stmt);
    }
}


$subject = "Your OTP Code | SyncHR";
$to = $user_email;

$message = '<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>OTP Verification</title>

    <style>
        body { margin: 0; font-family: "Poppins", sans-serif; font-size: 14px; }
        .email-container { max-width: 680px; margin: 0 auto; padding: 45px 30px 60px; background: linear-gradient(#94bbe9, #eeaeca); text-align: center; }
        .content-box { background: #ffffff; padding: 92px 30px 115px; border-radius: 30px; margin-top: 70px; }
        h1 { font-size: 24px; font-weight: 500; color: #1f1f1f; }
        .otp { margin-top: 60px; font-size: 40px; font-weight: 600; letter-spacing: 25px; color: #ba3d4f; }
        .highlight { font-weight: 600; color: #1f1f1f; }
        footer { text-align: center; margin-top: 40px; border-top: 1px solid #e6ebf1; }
        footer p { font-size: 14px; color: #434343; }
    </style>
</head>

<body>
    <div class="email-container">
        <header>
            <table width="100%">
                <tr>
                    <td>
                        <img src="https://portal.matchr.com/storage/product/photos/16477107591380.jpg" height="60px" width="130px" alt="Company Logo">
                    </td>
                    <td style="text-align: right; font-size: 16px; color: #ffffff;">' . date("l, jS F Y h:i A") . '</td>
                </tr>
            </table>
        </header>

        <main>
            <div class="content-box">
                <h1>Your OTP</h1>
                <p>Dear <b>' . htmlspecialchars($user_name) . '</b>,</p>
                <p>Thank you for choosing SyncHR. Use the following OTP to complete your verification process:</p>
                <p class="otp">' . htmlspecialchars($otp) . '</p>
                <p>OTP is valid for <span class="highlight">5 minutes</span>. Do not share this code with anyone.</p>
            </div>
        </main>

        <footer>
            <p>SyncHR Company</p>
            <p>Sarkhej, Ahmedabad, Gujarat.</p>
            <p>&copy; 2025 SyncHR. All rights reserved.</p>
        </footer>
    </div>
</body>

</html>';

?>

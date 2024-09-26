<?php
if (isset($_GET['token'])) {
    $token = $_GET['token'];
    $result = mysqli_query($db_conn, "SELECT * FROM users WHERE reset_token='$token' AND reset_expiry > NOW()");
    $user = mysqli_fetch_assoc($result);

    if ($user) {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $new_password = password_hash($_POST['password'], PASSWORD_BCRYPT);
            mysqli_query($db_conn, "UPDATE users SET password='$new_password', reset_token=NULL, reset_expiry=NULL WHERE id=" . $user['id']);
            
            echo "Password updated successfully!";
            header("Location: login.php");
        }
    } else {
        echo "Invalid or expired token.";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<form method="post" action="">
    <input type="password" name="password" placeholder="New Password" required>
    <button type="submit">Reset Password</button>
</form>
</body>
</html>
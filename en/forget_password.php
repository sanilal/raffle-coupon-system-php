<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($db_conn, $_POST['email']);
    $token = bin2hex(random_bytes(16)); // Secure token
    $expiry = date("Y-m-d H:i:s", strtotime('+1 hour'));

    mysqli_query($db_conn, "UPDATE users SET reset_token='$token', reset_expiry='$expiry' WHERE email='$email'");
    
    $reset_link = "https://alyoumpromo.com/reset_password.php?token=$token";
    
    // Send email with the reset link
    mail($email, "Password Reset", "Click this link to reset your password: $reset_link");

    echo "Check your email for the password reset link.";
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
    <input type="email" name="email" placeholder="Enter your email" required>
    <button type="submit">Send Password Reset Link</button>
</form>
</body>
</html>
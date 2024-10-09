<?php
include("../alyoumAdmin987/includes/conn.php"); 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($url, $_POST['email']);
    $token = bin2hex(random_bytes(16)); // Secure token
    $expiry = date("Y-m-d H:i:s", strtotime('+1 hour'));

    mysqli_query($url, "UPDATE users SET reset_token='$token', reset_expiry='$expiry' WHERE email='$email'");
    
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
<body class="signin">
<div class="outer-wraper">
    <div class="logoheader">
        <img src="../assets/images/alyoum-logo.png" alt="Alyoum Logo" class="img-fluid">
    </div>
    <div class="welcome text-black fontsize15 d-flex flex-column">
        <div class="renovate">
                <img src="../assets/images/renovate-your-kitchen-inner-en.png" alt="Renovate your kitchen with Alyoum Chicken">
               </div>
                <div class="signin-wraper">
                <div class="signinform">
                    <h2>Reset Your Password</h2>
                    <form method="post" action="" name="forgot_password" id="forgot_password">
                        <label for="email">Enter your email
                            <input type="email" name="email" required>
                        </label>
                        <button class="btn btn-primary" type="submit">Send Password Reset Link</button>
                    </form>
            </div>
                </div>
        </div>
        <div class="signinfooter">
                <img src="../assets/images/sign-in-bg.webp" alt="" class="img-fluid">
                <div class="termsspl">
                    <p class="termsClick text-white">Terms & Conditions Apply </p>
                </div>
            </div>
</div>
</body>
</html>
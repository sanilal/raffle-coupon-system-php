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
                    <form method="post" action="" name="reset_password" id="reset_password">
                        <label for="password">New Password
                        <input type="password" name="password" required>
                        </label>
                        <button class="btn btn-primary" type="submit">Reset Password</button>
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
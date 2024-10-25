<?php
ob_start();
date_default_timezone_set('Asia/Riyadh'); 


include("../alyoumAdmin987/includes/conn.php"); 
if (isset($_GET['token'])) {
    $token = $_GET['token'];
    $result = mysqli_query($url, "SELECT * FROM `" . TB_pre . "users` WHERE reset_token='$token' AND CONVERT_TZ(reset_expiry, '+03:00', @@session.time_zone) > NOW()");
    // var_dump("SELECT * FROM `" . TB_pre . "users` WHERE reset_token='$token' AND CONVERT_TZ(reset_expiry, '+03:00', @@session.time_zone) > NOW()"); die;
    $user = mysqli_fetch_assoc($result);
    

  
    
    if ($user) {
        $invaliDToken = false;
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $new_password = password_hash($_POST['password'], PASSWORD_BCRYPT);
            mysqli_query($url, "UPDATE `" . TB_pre . "users` SET password='$new_password', reset_token=NULL, reset_expiry=NULL WHERE id=" . $user['id']);
            
         //   echo "Password updated successfully!";
            header("Location: signin.php?reset=1");
        }
    } else {
        $invaliDToken = true;
     //   echo "Invalid or expired token.";
    }
} else {
    header("Location: signin.php");
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alyoum - Reset Password</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/responsive.css">
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
                <?php if($invaliDToken === false) { ?>
                    <div class="signinform">
                    <h2>Reset Your Password</h2>
                    <form method="post" action="" name="reset_password" id="reset_password">
                    <label for="password">Password</label>
                        <input type="password" id="password" name="password" required>
                        <div id="pswrderrr"></div>

                        <div id="password-requirements" style="display: none;">
                            <p id="length-condition"><span>✖</span> Password must be at least 6 characters long.</p>
                            <p id="uppercase-condition"><span>✖</span> Password must contain at least one uppercase letter.</p>
                            <p id="lowercase-condition"><span>✖</span> Password must contain at least one lowercase letter.</p>
                            <p id="number-condition"><span>✖</span> Password must contain at least one number.</p>
                            <p id="special-condition"><span>✖</span> Password must contain at least one special character (@, #, %, &, *, !, $).</p>
                        </div>

                        <button class="btn btn-primary" type="submit" id="submit-button">Reset Password</button>
                    </form>
            </div>

<?php } else { ?>
    <p class="lead">Invalid Token</p>
    <a href="signin.php" class="btn btn-primary sigin-btn">
                    SIGN IN
                </a>
    <?php } ?>
                </div>
        </div>
        <div class="signinfooter">
                <img src="../assets/images/sign-in-bg.webp" alt="" class="img-fluid">
                <div class="termsspl">
                    <p class="termsClick text-white">Terms & Conditions Apply </p>
                </div>
            </div>

</div>
<script src="../assets/scripts/validatepassword.js"></script>
</body>
</html>
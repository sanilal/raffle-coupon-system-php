<?php
session_start(); // Start the session at the top
ob_start();
date_default_timezone_set('Asia/Riyadh'); 
// $currentDate =  date("Y-m-d"); 
// // $currentDate =  date("Y-m-d H:i"); 
 $timestamp = time(); 
  $date_time = date("Y-m-d H:i:s", $timestamp); 

include("../alyoumAdmin987/includes/conn.php"); 
// var_dump($_COOKIE['remember_me']); die;
if (isset($_COOKIE['remember_me'])) {

    $cookie_token = $_COOKIE['remember_me'];
    $token_hash = hash('sha256', $cookie_token);

    
    // Query the database to verify the token
    $query = "SELECT * FROM `".TB_pre."users` WHERE remember_token='$token_hash' AND token_expiry > NOW()";
    $result = mysqli_query($url, $query);
    
    if (!$result) {
        die("Query failed: " . mysqli_error($url));
    }
    
    // If a matching token is found and it's not expired, log the user in
    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);
        
        // Set session variables for the logged-in user
        $_SESSION['user_id'] = $user['id'];
        $_SESSION["logged"] = "true";
        $_SESSION['last_login'] = $user['last_login'];

        
        // var_dump($_SESSION['last_login']); die;
        // Redirect to the dashboard or intended page
        header("Location: dashboard.php");
        exit();
    } else {
        // Invalid token or token expired, clear the cookie
        setcookie("remember_me", "", time() - 3600, "/"); // Delete the cookie
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alyoum</title>
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
                    <h2>Welcome</h2>

                    <p>Existing users</p>
                <a href="signin.php" class="btn btn-primary sigin-btn">
                    SIGN IN
                </a>
                <p>Don't have an account?</p>
                <a href="signup.php" class="btn btn-blue">
                    SIGN UP
                </a>
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
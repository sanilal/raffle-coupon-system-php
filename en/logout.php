<?php
session_start(); // Start the session at the top
ob_start();
date_default_timezone_set('Asia/Riyadh'); 
// $currentDate =  date("Y-m-d"); 
// // $currentDate =  date("Y-m-d H:i"); 
 $timestamp = time(); 
  $date_time = date("Y-m-d H:i:s", $timestamp); 
// echo "Current date is: $currentDate". "<br>";
// echo "Current Date & Time Of The Server Is: $date_time". "<br>"; 
// echo "The time is " . date("h:i:sa"); 

// Check if the remember_me cookie is set

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



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($url, $_POST['email']);
	$pass = mysqli_real_escape_string($url, $_POST['password']);

    $password=md5($pass);
    $remember = isset($_POST['remember_me']);

    // var_dump($remember); die;

    $query = "SELECT * FROM `".TB_pre."users` WHERE `email`='$email'";
    $result = mysqli_query($url, $query) or die(mysqli_error($url));
    $user = mysqli_fetch_assoc($result);

    // var_dump( $user); die;

    if (password_verify($pass, $user['password'])) {
        // Set session variables
        $_SESSION['user_id'] = $user['id'];
        $_SESSION["logged"] = "true";
        $_SESSION['last_login'] = $user['last_login'];
    
        // If "Remember Me" is checked
        if ($remember) {
            // Generate a secure random token
            $token = bin2hex(random_bytes(16));
            // Set expiry for 60 days (60 * 86400 seconds per day)
            $expiry = date('Y-m-d H:i:s', time() + (86400 * 60)); 
    
            // Set a cookie with the token that expires in 60 days
            setcookie("remember_me", $token, time() + (86400 * 60), "/"); // Set cookie for 60 days

    
            // Hash the token for storing in the database (to prevent token theft)
            $token_hash = hash('sha256', $token);
    
            // Store the hashed token in the database with the user's ID
            $update_query = "UPDATE `".TB_pre."users` SET remember_token='$token_hash', token_expiry='$expiry' WHERE id=" . $user['id'];
            mysqli_query($url, $update_query);
        }
    
        // Update the last login time and redirect to the dashboard
        $date_time = date("Y-m-d H:i:s"); // current timestamp
        mysqli_query($url, "UPDATE `".TB_pre."users` SET last_login='$date_time' WHERE id=" . $_SESSION['user_id']);
    
        header("Location: dashboard.php");
        exit();
    } else {
        echo "Invalid login credentials";
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
                <div class="signinform">
                    <h2>You are Logged Out</h2>
                    <a class="btn btn-primary" href="signin.php">Login</a>
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
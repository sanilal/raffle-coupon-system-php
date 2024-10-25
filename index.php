<?php
session_start(); // Start the session at the top
ob_start();
date_default_timezone_set('Asia/Riyadh'); 
// $currentDate =  date("Y-m-d"); 
// // $currentDate =  date("Y-m-d H:i"); 
 $timestamp = time(); 
  $date_time = date("Y-m-d H:i:s", $timestamp); 

include("alyoumAdmin987/includes/conn.php"); 
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
        $userLang = $user['is_arabic'];
        if($userLang != 0) {
            header("Location: ar/dashboard.php");
            exit();
        } else {
            header("Location: en/dashboard.php");
            exit();
        }
        
        // var_dump($_SESSION['last_login']); die;
        // Redirect to the dashboard or intended page
      //  header("Location: dashboard.php");
        
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

    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/responsive.css">
</head>
<body>
    <div class="outer-wraper">
        <div class="bg-wraper home">
            <div class="header">
                <img src="assets/images/home-bg.webp" alt="Renovate your kitchen with ALYOUM Chicken" class="img-fluid">
                <div class="notice">
                <img src="assets/images/every20.svg" alt="Every 20 SAR spent earns you one extra entry in the draw" class="img-fluid">
                </div>
            </div>
        <div class="select-lang text-black fontsize15 d-flex flex-column">
        <h2 class="arabic text-medium text-center text-white">
                اختر لغتك المفضلة
                </h2>        
        <h2 class="text-medium text-center text-white almarai-bold">
                SELECT YOUR LANGUAGE
                </h2>
                
                <a href="./en/" class="">
                    <span>
                    ENGLISH
                    </span>
                    <span class="arabic">الانجليزية</span>
                </a>
                <a href="./ar/" class="">
                    <span>
                    ARABIC
                    </span>
                    <span class="arabic">العربية</span>
                </a>
                <div class="termsspl">
                    <p class="termsClick text-white">Terms & Conditions Apply </p>
                </div>
            </div>
        </div>

    </div>
</body>
</html>
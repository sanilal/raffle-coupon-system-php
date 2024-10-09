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
       
                <div class="thanks-wraper">
                    <h2 class="text-bold">THANK YOU <span>FOR YOUR
                    PARTICIPATION!</span></h2>
                    <p class="text-center text-white">Your entry is under verification. Your chances in Alyoum Raffle draw will be updated on your dashboard within 3 - 4 working days
 </p>
 <a href="dashboard.php" class="btn btn-standard backto text-bold">Go Back to Dashboard</a>
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
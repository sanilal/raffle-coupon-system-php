<?php
ob_start();
date_default_timezone_set('Asia/Riyadh'); 

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

include("../alyoumAdmin987/includes/conn.php"); 


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = mysqli_real_escape_string($url, $_POST['email']);

    // Check if the email exists in the database
    $check_email_query = "SELECT * FROM `" . TB_pre . "users` WHERE email='$email'";
    
    $result = mysqli_query($url, $check_email_query);
    $result_row = mysqli_fetch_object($result);
    $fullName = $result_row->first_name .' '. $result_row->last_name;  
  // var_dump($fullName); 
    
    if (mysqli_num_rows($result) > 0) {
        
        // Email exists, proceed with generating the token
        $token = bin2hex(random_bytes(16)); // Secure token
        $expiry = date("Y-m-d H:i:s", strtotime('+1 hour'));
        

        // Update the database with reset token and expiry
        $update_query = "UPDATE `" . TB_pre . "users` SET reset_token='$token', reset_expiry='$expiry' WHERE email='$email'";
        mysqli_query($url, $update_query) or die(mysqli_error($url));

        // Prepare reset link
        $reset_link = "https://alyoumpromo.com/demo/en/reset_password.php?token=$token";

        // Send email with the reset link
        // $headers = "From: your-email@example.com\r\n";
        // $headers .= "Reply-To: your-email@example.com\r\n";
        // $headers .= "Content-Type: text/html; charset=UTF-8\r\n"; // If you want to send HTML email
        
        // // Check if the mail was successfully sent
        // if (mail($email, "Password Reset", "Click this link to reset your password: $reset_link", $headers)) {
            //     $mailSent = true; // Mail sent successfully
            // }
            
            // Newwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwww
            
            // Include the PHPMailer library
            
        include_once('reset-password-email.php');
        $emailSubject = "Password reset link from Alyoumpromo.com";
        $emailTemplate = $resetEmail;
        
         require '../PHPMailer/src/Exception.php';
         require '../PHPMailer/src/PHPMailer.php';
         require '../PHPMailer/src/SMTP.php';
          
         try { 
             $mail = new PHPMailer(true);
             // SMTP Configuration
             $mail->CharSet = 'UTF-8';
             $mail->isSMTP();
             $mail->Host = 'mail.alyoumpromo.com';
             $mail->SMTPAuth = true;
             $mail->Username = 'registration@alyoumpromo.com';
             $mail->Password = 'Email@987';
             $mail->SMTPSecure = 'ssl'; // You can also use 'tls' if SSL is not available
             $mail->Port = 465; // Change to 587 if you're using 'tls'
         
             // Sender and Recipient
             $mail->setFrom('registration@alyoumpromo.com', 'Alyoum Chicken');
             $mail->addAddress($email);

              // Add CC recipients
              $ccEmail1 = 'submissions@alyoumpromo.com';
              $mail->addCC($ccEmail1);
         
             // Email content
             $mail->isHTML(true);
             $mail->Subject = $emailSubject;
             $mail->Body = $emailTemplate;
         
             // Send the email
             $mail->send();
             
            $_SESSION['form_submitted'] = true;
             
             // Success message
             $mailSent = true;
         } catch (Exception $e) {
             // Error message
        //     echo 'Email could not be sent. Error: ' . $mail->ErrorInfo;
         }

         // Create a new PHPMailer instance
         $mail = new PHPMailer(true);

        // Newwwwwwwwwwwwwwwwwwwwwwwwwwwwwww

    } else {
        // Email does not exist
        $noUser = true;
        // echo "The email address does not exist in our records. Please try again.";
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alyoum Forget Password</title>
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
                    <h2>Reset Your Password</h2>
                    <?php if(isset($mailSent)) { ?>
                        <p class="lead">Please check your email. We've sent a password reset link to the registered email address.</p>
                        <a href="signin.php" class="btn btn-primary sigin-btn">
                    SIGN IN
                </a>
                   <?php } elseif(isset($noUser)) { ?>
                        <p class="lead">Please verify your email address. It seems you may have used a different one to register. The email provided doesn't exist in our records. </p>
                        <a href="signin.php" class="btn btn-primary sigin-btn">
                    SIGN IN
                </a>

                    <?php } else { ?>
                    <form method="post" action="" name="forgot_password" id="forgot_password">
                        <label for="email">Enter your email
                            <input type="email" name="email" required>
                        </label>
                        <button class="btn btn-primary" type="submit">Send Password Reset Link</button>
                    </form>
                    <?php } ?>
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
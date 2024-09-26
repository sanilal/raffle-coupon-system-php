<?php
ob_start();
date_default_timezone_set('Asia/Riyadh'); 
// $currentDate =  date("Y-m-d"); 
// // $currentDate =  date("Y-m-d H:i"); 
 $timestamp = time(); 
  $date_time = date("Y-m-d H:i:s", $timestamp); 
// echo "Current date is: $currentDate". "<br>";
// echo "Current Date & Time Of The Server Is: $date_time". "<br>"; 
// echo "The time is " . date("h:i:sa"); 

session_start();
$formSubmitted = isset($_SESSION['form_submitted']) && $_SESSION['form_submitted'] === true;
// var_dump($_SESSION['form_submitted']); die;


$_SESSION['form_submitted'] = false; // Reset the session variable

include("../alyoumAdmin987/includes/conn.php"); 

$arabic=0;
$currentDate = date('Y-m-d');

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $alreadyRegisteredSql = "SELECT * FROM `" . TB_pre . "users` WHERE `email` = '" . $_POST['email'] . "' OR `mobile` = '" . $_POST['mobile'] . "' ";

   // var_dump($alreadyRegisteredSql); die;

    $alreadyRegisteredR1=mysqli_query($url,$alreadyRegisteredSql) or die("Failed".mysqli_error($url));
                 $alreadyRegisteredRowcount=mysqli_num_rows($alreadyRegisteredR1);

                 if ($alreadyRegisteredRowcount >= 1) {
               		$userExists = true;
                } else {
                    $userExists = false;
                }

if($userExists === false) {
    $ctime = time();
    function generateUniqueID($time)
    {
        // Use alphanumeric characters
        $spinId = 'aly_' . $time . bin2hex(random_bytes(4));

        return $spinId;
    }
    $userId = generateUniqueID($ctime);

}
                
// var_dump( $userId ); die;
$firstName=ucwords($_POST['fname']);	
$lastName=ucwords($_POST['lname']);	
$email=$_POST['email'];
$address = $_POST['address'];
$region = $_POST['region'];
$mobile = $_POST['mobile'];
$country  = 'ksa';
$password = $_POST['password'];
$confirmPassword = $_POST['cpassword'];

// Check if passwords match before hashing
if ($password === $confirmPassword) {
    // Hash the password once after confirmation

    $pass=md5($password);

    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

  //  var_dump($hashedPassword); die;

    

   // var_dump($pass); die;
    $passwordMismatch = false;
    // Now, you can store $hashedPassword in the database
  //  echo "Password matches and has been hashed!";
    
    // Redirect user to their dashboard or perform other actions
} else {
    $passwordMismatch = true; 
}




  //  var_dump($date_time); die;
    
    $query = "INSERT INTO `".TB_pre."users` (`userid`,`username`,`first_name`,`last_name`,`mobile`,`email`,`country`,`region`,`address`,`password`,`is_arabic`,`profile_created`,`last_login`) VALUES('$userId','$email','$firstName','$lastName','$mobile','$email','$country','$region','$address','$hashedPassword','$arabic','$date_time','$date_time')";
    $r = mysqli_query($url, $query) or die(mysqli_error($url));

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
<div class="outer-wraper">
   <div class="signupform">
    <h2>Register</h2>
        <form method="post" action="" name="signup_form" id="signup_form">
            <input type="text" name="fname" placeholder="First Name" required>
            <input type="text" name="lname" placeholder="Last Name" required>
            <textarea name="address" id="address" required></textarea>
            <input type="text" name="region" placeholder="Region" required>
            <input type="tel" name="mobile" placeholder="Number" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="password" name="cpassword" placeholder="Confirm Password" required>
            <button type="submit">Create Account</button>
            <button type="reset">Cancel</button>
        </form>
   </div>
</div>

</body>
</html>
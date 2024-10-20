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
// var_dump($formSubmitted);
if($formSubmitted === true) {
    $registereduser = true;
} else {
    $_SESSION['form_submitted'] = false;
}
 // Reset the session variable

include("../alyoumAdmin987/includes/conn.php"); 

$arabic=0;
$currentDate = date('Y-m-d');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    function generateRandomID($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        
        return $randomString;
    }
    $randomid = generateRandomID(10); 

    $alreadyRegisteredSql = "SELECT * FROM `" . TB_pre . "users` WHERE `email` = '" . $_POST['email'] . "' OR `mobile` = '" . $_POST['mobile'] . "' ";

   // var_dump($alreadyRegisteredSql); die;

    $alreadyRegisteredR1=mysqli_query($url,$alreadyRegisteredSql) or die("Failed".mysqli_error($url));
                 $alreadyRegisteredRowcount=mysqli_num_rows($alreadyRegisteredR1);

                 if ($alreadyRegisteredRowcount >= 1) {
               		$userExists = true;
                       $alreadyRegisteredRow = mysqli_fetch_assoc($alreadyRegisteredR1); 
                       $userId = $alreadyRegisteredRow['id']; 
                       if(isset($userId)) {
                        // Function to generate a random alphanumeric ID
                        // Generates a random ID with a length of 10
                           header("Location: signin.php?user_id=$randomid");
                           exit(); 
                       }
                       exit();
                } else {
                    $userExists = false;
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

$passwordMismatch = false;

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


if(!$passwordMismatch) {
    $query = "INSERT INTO `".TB_pre."users` (`userid`,`username`,`first_name`,`last_name`,`mobile`,`email`,`country`,`region`,`address`,`password`,`is_arabic`,`profile_created`,`last_login`) VALUES('$userId','$email','$firstName','$lastName','$mobile','$email','$country','$region','$address','$hashedPassword','$arabic','$date_time','$date_time')";
    $r = mysqli_query($url, $query) or die(mysqli_error($url));
    if ($r) {
        // Successful insertion, redirect to sign-in page
        $insertedUserId = mysqli_insert_id($url);
       // var_dump( $insertedUserId); die;
        $_SESSION['form_submitted'] = true;
        header("Location: signin.php?nu=$randomid");
        exit(); // Ensure the script stops after redirection
    } else {
        // Error occurred during query execution
        die("Error: " . mysqli_error($url));
    }

} else {
    echo "<script>alert('Password Mismatch!');</script>";
}

  //  var_dump($date_time); die;
    
   

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
<body class="signup">
<div class="outer-wraper">
    <div class="logoheader">
        <img src="../assets/images/alyoum-logo.png" alt="Alyoum Logo" class="img-fluid">
    </div>
        <div class="welcome text-black fontsize15 d-flex flex-column">
            <div class="renovate">
                <img src="../assets/images/renovate-your-kitchen-inner-en.png" alt="Renovate your kitchen with Alyoum Chicken">
            </div>
        </div>
        <div class="signin-wraper">
        <div class="signupform">
            <h2>Register new account</h2>
                <form method="post" action="" name="signup_form" id="signup_form">
                    <div class="row-50">
                        <label class="col" for="fname">First Name<span class="star">*</span><input type="text" name="fname" required id="first-name"></label>
                       
                        <label class="col" for="lname">Last Name<span class="star text-white">*</span><input type="text" name="lname" id="last-name"></label>
                        
                    </div>
                    <div id="fname-err"></div>
                    <div id="lname-err"></div>
                    <div class="row">
                        <label for="address">Address<span class="star">*</span><textarea name="address" id="address" required></textarea id='address'></label>
                        <div id="address-err"></div>
                    </div>
                    <div class="row">
                        <label for="region">Region<span class="star">*</span><input type="text" name="region" required id="city"></label>
                        <div id="city-err"></div>
                    </div>
                    <div class="row">
                        <label for="mobile">Mobile Number<span class="star">*</span><input type="tel" name="mobile" required id="inputNumber"></label>
                        <div id="mobile-err"></div>
                    </div>
                    <div class="row">
                        <label for="email">Email<span class="star">*</span><input type="email" name="email" required id="inputEmail4"></label>
                        <div id="email-err"></div>
                    </div>
                    <div class="row">
                        <label for="password">Password<span class="star">*</span><input type="password" name="password" required id="password"></label>
                        <div id="password-err">
                            <div id="pswrderrr"></div>
                            <ul id="password-requirements" style="display: none;">
                                <li id="length-condition"><span>✖</span> Password must be at least 6 characters long.</li>
                                <li id="uppercase-condition"><span>✖</span> Password must contain at least one uppercase letter.</li>
                                <li id="lowercase-condition"><span>✖</span> Password must contain at least one lowercase letter.</li>
                                <li id="number-condition"><span>✖</span> Password must contain at least one number.</li>
                                <li id="special-condition"><span>✖</span> Password must contain at least one special character (@, #, %, &, *, !, $).</li>
                            </ul>
                        </div>

                    </div>
                    <div class="row">
                        <label for="cpassword">Confirm Password<span class="star">*</span><input type="password" name="cpassword" required id="cpassword"></label>
                        <div id="confirm-password-msg"></div>
                    </div>
                    <div class="row"><div class="req-fields"><span class="star">*</span>required fields</div></div>
                    <div class="registerbtns">
                        <button type="submit" class="btn btn-primary" id="submit-button">Create Account</button>
                        <button type="reset" class="btn btn-gray">Cancel</button>
                    </div>
                </form>
        </div>
        </div>
        <div class="signupfooter">
                <div class="termsspl">
                    <p class="termsClick text-white">Terms & Conditions Apply </p>
                </div>
            </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js" integrity="sha256-lSjKY0/srUM9BE3dPm+c4fBo1dky2v27Gdjm2uoZaL0=" crossorigin="anonymous"></script>
<script src="../assets/scripts/register.js"></script>
</body>
</html>
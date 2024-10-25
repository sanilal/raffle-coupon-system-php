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

$userid =$_POST['uid'];
$gwid =$_POST['gwid'];
// var_dump($userid); die;



if(!isset($userid)) {
    header('Location: dashboard.php');
}

if(isset($_REQUEST['btnadd'])){
    $invNumber=$_POST['inv-number'];

    $invoiceSql="select * from `".TB_pre."transactions` WHERE `invoice_no` = '$invNumber' ";
    $invoicer1=mysqli_query($url,$invoiceSql) or die("Failed".mysqli_error($url));
    $invoicerowcount=mysqli_num_rows($invoicer1);

    // var_dump($invoicerowcount); die;
    if ($invoicerowcount != 0) { 
        echo '<script> 
            alert("This invoice number has been previously submitted");
            setTimeout(function() {
                window.location.href = "/";
            }, 1000); // Delay for 10 seconds (10000 milliseconds)
        </script>';
        exit(); // Stop script execution
    }
    // var_dump($_FILES['inputInvoice']); die;
    include_once("../alyoumAdmin987/classes/class.upload.php");
    $p_image=image_upload($_FILES['inputInvoice'],$invNumber."main_img".time());

  //  var_dump($p_image); die;

    $g_image="";
		for($i=1;$i<=12;$i++){
			$u_image=image_upload($_FILES['inputInvoice'.$i],$product."g_img".$i);
			//var_dump($_FILES['productimg'.$i]);
			if($u_image!=""){
				$g_image.=",".$u_image;
			}
		}
		$g_image=ltrim($g_image,",");
		
	    //	var_dump($_FILES['inputInvoice']); die;
		// var_dump($p_image); exit;
		//
		$msg=""; $error="";
		  //var_dump($num); exit;

        $currentDate = date('Y-m-d H:i:s');
        $raffleCoupons = 2*$multiplier;
        $goldenWeek = $gwid;


        $query = "INSERT INTO `".TB_pre."transactions` (`user_id`,`invoice_no`,invoice_img,`date`,`raffle_coupons`,`golden_week_id`) VALUES('$userid','$invNumber','$p_image','$currentDate','$raffleCoupons','$goldenWeek')";
        $r = mysqli_query($url, $query) or die(mysqli_error($url));

        

} else {
    header('Location: dashboard.php');
}

?>


<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alyoum - Thank You</title>
    <link rel="stylesheet" href="../assets/css/style-rtl.css">
    <link rel="stylesheet" href="../assets/css/responsive-rtl.css">
</head>
<body class="signin">
<div class="outer-wraper">
<div class="logoheader">
            <img src="../assets/images/alyoum-logo.png" alt="Alyoum Logo" class="img-fluid">
        </div>
        <div class="welcome text-black fontsize15 d-flex flex-column">
       
                <div class="thanks-wraper">
                    <h2 class="text-bold">شكراً لمشاركتك</h2>
                    <p class="text-center text-white">مشاركتك قيد التحقق
ستتم تحديث فرصك في سحب "اليوم
 على لوحة التحكم الخاصة بك خلال
 أيام عمل <span class="english">3-4</span></p>
 <a href="dashboard.php" class="btn btn-standard backto text-bold">ارجع إلى لوحة التحكم</a>
                </div>
        </div>
        <div class="signinfooter">
                <img src="../assets/images/sign-in-bg.webp" alt="" class="img-fluid">
                <div class="termsspl">
                    <p class="termsClick text-white">تطبق الشروط والأحكام </p>
                </div>
            </div>
    
</div>
</body>
</html>
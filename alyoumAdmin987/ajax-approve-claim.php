<?php  
error_reporting(0); 
ob_start();
session_start();
include("includes/conn.php");
if(!isset($_SESSION['user_id'])){
	header("Location: logout.php");
	echo "<script type='text/javascript'>window.top.location='logout.php';</script>";
	exit;
}
else if($_SESSION['user_id']=="" || $_SESSION['user_id']==NULL){
	header("Location: logout.php");
	echo "<script type='text/javascript'>window.top.location='logout.php';</script>";
	exit;
}
date_default_timezone_set('Asia/Dubai'); 
$timestamp = time(); 
$dateString = date("Y-m-d H:i:s", $timestamp);
// echo $dateString;


$entry_id = $_GET["entryId"];

$query = "UPDATE `" . TB_pre . "prize` 
SET `confirm`='1', `rejected`='0', `mailtime`='$dateString'
WHERE `winner` = '$entry_id'";


 //var_dump($query); die;


$result = mysqli_query($url, $query);
if(mysqli_affected_rows($result) > 0) {
    // Reload the current page using JavaScript
    echo '<script>window.location.reload();</script>';
} else {
    echo 'Data Not Found';
}

?>
 
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
$output = '';
$country_id = $_POST["cid"];


if(isset($_POST["cid"]))

{
 //$search = mysqli_real_escape_string($url, $emirate);
 $query = "
  SELECT * FROM `".TB_pre."zone` 
  WHERE zone_id = '$country_id'
 ";
}
$result = mysqli_query($url, $query);
if (mysqli_num_rows($result) > 0) {
    $res = mysqli_fetch_array($result);
    $s_date = $res['c_start'];
    $e_date = $res['c_ends'];
    echo '<input type="date" min="' . $s_date . '" max="' . $e_date . '" class="form-control" placeholder="Date" name="prize_date" id="prize_date" />';
}


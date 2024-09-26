<?php
error_reporting(0);
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
$userId = $_SESSION['user_id'];

if (!isset($_SESSION['user_id']) && isset($_COOKIE['remember_me'])) {
    
    echo 136;
    $token_hash = hash('sha256', $token);

    $result = mysqli_query($db_conn, "SELECT * FROM users WHERE remember_token='$token_hash'");
    $user = mysqli_fetch_assoc($result);

    if ($user) {
        $_SESSION['user_id'] = $user['id']; // Log the user in
    }
}

//var_dump($_SESSION['user_id']);
?>
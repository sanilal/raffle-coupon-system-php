<?php
session_start(); // Start the session at the top
ob_start();
date_default_timezone_set('Asia/Riyadh'); 


include("../alyoumAdmin987/includes/conn.php"); 



include_once('../inc/header.php');


// if (!isset($_SESSION['user_id']) && isset($_COOKIE['remember_me'])) {
//     $token = $_COOKIE['remember_me'];
//     $token_hash = hash('sha256', $token);

//     $result = mysqli_query($db_conn, "SELECT * FROM users WHERE remember_token='$token_hash'");
//     $user = mysqli_fetch_assoc($result);

//     if ($user) {
//         $_SESSION['user_id'] = $user['id']; // Log the user in
//     }
// }

$userid = $_SESSION['user_id'];
$userquery = "select * from `".TB_pre."users` WHERE `id` = '$userid' ";
$userr1=mysqli_query($url,$userquery) or die("Failed".mysqli_error($url));
$userRes = mysqli_fetch_array($userr1);

$fname= $userRes['first_name'] ;
$name= $userRes['first_name'] . ' ' . $userRes['last_name'];

$today = date('Y-m-d');
$gwquery = "select * from `".TB_pre."golden_week` WHERE `start_date` <= '$today' AND `end_date` >= '$today' LIMIT 1";
//var_dump($gwquery);
$gwr1=mysqli_query($url,$gwquery) or die("Failed".mysqli_error($url));
$gwRes = mysqli_fetch_array($gwr1);
$gwid = $gwRes['id'];
$multiplier = $gwRes['prize_multiplication'];
// var_dump($multiplier);

// Check for custom notifications
    // 01. Transaction notification (golden week success)
    $transactionSql="select * from `".TB_pre."transactions` WHERE `user_id` = '$userid' ORDER BY `id` DESC LIMIT 1 ";
    $transactionR1=mysqli_query($url,$transactionSql) or die("Failed".mysqli_error($url));
    $transactionRow = mysqli_fetch_array($transactionR1);

    $transactionTime=$transactionRow['date'];
    $currentTime = date('Y-m-d H:i:s');
    $transactiongwId=$transactionRow['golden_week_id'];

   // Create DateTime objects
$transactionDateTime = new DateTime($transactionTime);
$currentDateTime = new DateTime($currentTime);

// Calculate the difference
$timeDifference = $currentDateTime->diff($transactionDateTime);

// Convert the difference to total minutes
$minutesDifference = ($timeDifference->days * 24 * 60) + ($timeDifference->h * 60) + $timeDifference->i;
// print_r($minutesDifference); die;
if($transactiongwId === $gwRes['id']) {
    $gwNotification = $gwRes['notification'];
    if ($minutesDifference < 60) {
        $gwSuccessNotification = "Congratulations!
Your chances in the raffle just doubled!";
    }
} 


// Check if the time difference is less than 1 hour
// if ($timeDifference->h < 1 && $timeDifference->days == 0) {
//     echo "The time difference is less than 1 hour.";
// } else {
//     echo "The time difference is more than 1 hour.";
// }

$rfcquery = "select SUM(raffle_coupons) from `".TB_pre."transactions` WHERE `user_id` = '$userid' ";
$rfcr1=mysqli_query($url,$rfcquery) or die("Failed".mysqli_error($url));
$rfcRow = mysqli_fetch_array($rfcr1);

// Access the sum value
$rfcSum = $rfcRow['SUM(raffle_coupons)'];

// var_dump($rfcSum);



?>


<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../assets/css/style-rtl.css">
    <link rel="stylesheet" href="../assets/css/responsive-rtl.css">
</head>
<body class="userdashboard">
   
    <div class="outer-wraper">
        <div class="logoheader">
            <img src="../assets/images/alyoum-logo.png" alt="Alyoum Logo" class="img-fluid">
        </div>
        <div class="dashboard ">
            <div class="dashboard-welcome mt-4">
                <?php if(!isset($gwSuccessNotification)) { ?>
                <h1 class="d_name">مرحباً <?php echo $fname; ?></h1>
                <?php if(isset($gwNotification)) { echo $gwNotification; } ?>
                <?php } else {?>
                <div class="dashoboard-notifications">
                    <?php if(isset($gwNotification)) { ?>
                    <div class="lead-notification text-bold">
                        <?php echo $gwSuccessNotification; ?>
                    </div>
                    <?php } 
                    if(isset($gwNotification)) { echo $gwNotification; } ?>
                    
                </div>
                <?php } ?>
            </div>
            <div class="dashboard-main mt-1">
                <div class="dashboard-main-raffle-tickets">
                    <div class="ticket-number">
                        <h1 id="ticketNumber" class="text-bold">0</h1>
                    </div>
                    <div class="ticket-text ">
                        <h2 class="text-ex-bold">تذكرة السحب</h2>
                    </div>
                    <div class="ticket-message">
                        <p>لقد حصلت على فرصة لدخول<br>
                        السحب الخاص ب "اليوم"</p>
                    </div>
                </div>
                <div class="dashboard-main-tabs">
                    <ul>
                        <li class="text-bold active" id="increase-chance">زد من فرصك في الفوز  </li>
                        <li class="text-bold" id="transaction-history">سجل المعاملات</li>
                    </ul>
                    <div class="invoice-form">
                        <div class="dashboard-main-tab-item active" id="invoice-form">
                            <form role="form" method="post"  class="form-horizontal" action="submission.php" enctype="multipart/form-data" id="submitForm" >
                                <div class="box-body row">
                                    <div class="col-md-12">
                                        <input type="hidden" name="gwid" id="gwid" value="<?php echo $gwid; ?>">
                                        <input type="hidden" name="uid" id="uid" value="<?php echo $userid; ?>">
                                        <div class="inv-num">
                                            <label for="inv-number">رقم الفاتورة
                                            <input type="text" class="form-control" name="inv-number" id="inv-number" required /></label>
                                            <div id="inv-number-err"></div>
                                            <div id="invoice_exists"></div>
                                        </div>
                                        <div class="invoice-upload">
                                            <label for="inputInvoice">حمل الإيصال
                                            <input type="file" name="inputInvoice" class="form-control inputInvoice " accept="image/*" id="inputInvoice" required capture="camera"></label>
                                            <div id="invoice-err"></div>
                                        </div>
                                        
                                        <div class="announcement text-bold">
                                            <p>كل 20 ريال سعودي تمنحك فرصة
                                            إضافية لدخول السحب</p>
                                        </div>
                                        <div class="form-buttons">
                                            <button type="submit" class="btn btn-primary" name="btnadd" id="submit-button">إرسال</button>
                                        
                                        </div>
                                    </div>					 
                                </div><!-- /.box-body -->
                            </form>
                        </div>
                        <?php

$sql="select * from `".TB_pre."transactions` WHERE `user_id` = '$userid' ORDER BY id DESC ";
// $sql="select * from `".TB_pre."shop_win` ORDER BY entry_id DESC ";
$r1=mysqli_query($url,$sql) or die("Failed".mysqli_error($url));

                        ?>

<div class="box-header with-border">
              <?php if(isset($msg)){ ?>
              	<div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4><i class="icon fa fa-check"></i> <?php echo $msg; ?></h4>
               	</div>
               <?php } ?> 
            </div>
                        <div class="dashboard-main-tab-item">
                        
                            <table id="transactions">
                            <?php 
					    $i = 1;
					    while($res = mysqli_fetch_array($r1)){ ?>
                                <tr class="tranaction">
                                    <td width="50"><?php echo $i++; ?></td>
                                    <td class="invnocol"><?php echo $res['invoice_no']; ?></td>
                                    <td width="100">
                                        <?php 
                                        $date = new DateTime($res['date']);
                                        echo $date->format('Y/m/d'); 
                                        ?>
                                    </td>
                                </tr>
                                <?php } ?>
                                
                            </table>
                        </div>
                        
                    </div>
                    <div id="leader-board">
                        <div class="leader-board-title">
                            <h2 id="leaderBoadButton">قائمة المتصدرين +</h2>
                        </div>
                        <div class="winners" id="winners">
                            <!-- <div class="winner-row">
                                <div class="winner-col">Position</div>
                                <div class="winner-col">Name</div>
                            </div> -->
                            <?php $lb_row=mysqli_query($url,"select * from `".TB_pre."leaderboards` WHERE `active`=1"); 
                            $i = 1;
                                while($lb_res = mysqli_fetch_object($lb_row)) {
                            ?>
                                <div class="winner-row">
                                    <div class="winner-col"><?php echo $i++; ?></div>
                                    <div class="winner-col"><?php
                                    $user_id = $lb_res->user;
                                        $user_query = "SELECT first_name, last_name FROM `".TB_pre."users` WHERE id='$user_id'";
                                        $user_result = mysqli_query($url, $user_query) or die(mysqli_error($url));

                                        if ($user_row = mysqli_fetch_assoc($user_result)) {
                                            // Extract first_name and last_name from the result
                                            $first_name = $user_row['first_name'];
                                            $last_name = $user_row['last_name'];
                                            
                                            // Echo the first name and last name in the table
                                            echo $first_name . " " . $last_name;
                                        } else {
                                            // Handle case where no user is found
                                            echo "<td>User not found</td>";
                                        }
 ?>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                
            </div>
            <div class="signupfooter">
                <div class="termsspl">
                    <p class="termsClick text-white">تطبق الشروط والأحكام </p>
                </div>
            </div>


        </div>
    </div>
    <script src="../assets/scripts/dashboard.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
    const ticketElement = document.getElementById('ticketNumber');
    let currentNumber = 0;
    const targetNumber = <?php echo $rfcSum; ?>;
    const speed = 100; // The delay between increments (in milliseconds)

    const increaseNumber = setInterval(function() {
        currentNumber++;
        const formattedNumber = currentNumber.toString().padStart(2, '0');
        ticketElement.textContent = formattedNumber;

        // ticketElement.innerText = currentNumber;

        if (currentNumber >= targetNumber) {
            clearInterval(increaseNumber); // Stop the interval when target is reached
        }
    }, speed);
});

    </script>
</body>
</html>
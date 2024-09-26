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

$name= $userRes['first_name'] . ' ' . $userRes['last_name'];



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

        $currentDate = date('Y-m-d');
        $raffleCoupons = 2;
        $goldenWeek = 0;


        $query = "INSERT INTO `".TB_pre."transactions` (`user_id`,`invoice_no`,invoice_img,`date`,`raffle_coupons`,`golden_week_id`) VALUES('$userid','$invNumber','$p_image','$currentDate','$raffleCoupons','$goldenWeek')";
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
        <div class="dashboard">
            <div class="dashboard-welcome">
                <h1>Welcome <?php echo $name; ?></h1>
            </div>
            <div class="dashoboard-notifications">
                <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Blanditiis sint, ea nobis sed, dicta nulla facere iste itaque ullam iure neque quisquam a</p>
            </div>
            <div class="dashboard-main">
                <div class="dashboard-main-raffle-tickets">
                    <div class="ticket-number">
                        <h1>11</h1>
                    </div>
                    <div class="ticket-text">
                        <h2>RAFFLE TICKET</h2>
                    </div>
                    <div class="ticket-message">
                        <p>You have got a chance to enter Alyoum Raffle Promotion</p>
                    </div>
                </div>
                <div class="dashboard-main-tabs">
                    <ul>
                        <li>Increase your chances of winning</li>
                        <li>Transacion History</li>
                    </ul>
                    <div class="invoice-form">
                        <div class="dashboard-main-tab-item" id="invoice-form">

                        <form role="form" method="post"  class="form-horizontal" action="dashboard.php#submitForm" enctype="multipart/form-data" id="submitForm" >
                  <div class="box-body row">
                  	<div class="col-md-12">
                    <input type="hidden" name="zone" id="zone" value="uae">
                   
            
                        <div class="invoice-upload">
                <!-- <div class="invoice-wraper" >
                    <span class="invoice-copy">Upload purchase receipt*</span>
                    <span class="file-select">+</span>
                </div> -->
                <!-- <p style="padding-left:15px;">Kindly upload a clear invoice copy</p> -->
                <input type="file" name="inputInvoice" class="form-control inputInvoice " accept="image/*" id="inputInvoice" placeholder="Upload picture" required capture="camera">
                
                <div id="invoice-err"></div>
            </div>
            <input type="text" class="form-control" placeholder="invoice Number*" name="inv-number" id="inv-number" required />
						<div id="inv-number-err"></div>
                        <div id="invoice_exists"></div>


           <div class="announcement">
                                    <p>*Every 20 SAR earns you one extra entry in the draw</p>
                                </div>
            <div class="form-buttons"><button type="submit" class="btn submitnreset" name="btnadd" id="submit-button">Submit</button>
                <button type="reset" class="btn submitnreset" name="btnareset" id="reset-button">Reset</button>
            </div>


					</div>
			
					 
                  </div><!-- /.box-body -->

                  <div class="box-footer">
                   
                  </div>
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
                            <div id="transactions">
                            <?php 
					    $i = 1;
					    while($res = mysqli_fetch_array($r1)){ ?>
                                <div class="tranaction">
                                    <div class="transaction-col"><?php echo $i++; ?></div>
                                    <div class="tranaction-col"><?php echo $res['invoice_no']; ?></div>
                                    <div class="tranaction-col"><?php echo $res['date']; ?></div>
                                </div>
                                <?php } ?>
                                
                            </div>
                        </div>
                        
                    </div>
                    <div id="leader-board">
                        <div class="leader-board-title">
                            <h2>+ Leader Board</h2>
                            <div class="winners">
                                <div class="winner-row">
                                    <div class="winner-col">Name</div>
                                    <div class="winner-col">Reason</div>
                                    <div class="winner-col">Position</div>
                                </div>
                                <div class="winner-row">
                                    <div class="winner-col">Name</div>
                                    <div class="winner-col">Reason</div>
                                    <div class="winner-col">Position</div>
                                </div>
                                <div class="winner-row">
                                    <div class="winner-col">Name</div>
                                    <div class="winner-col">Reason</div>
                                    <div class="winner-col">Position</div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
    
</body>
</html>
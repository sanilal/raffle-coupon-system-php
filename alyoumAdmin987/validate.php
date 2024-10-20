<?php $active="campaign"; ?>
<?php
	ob_start();
	include("includes/conn.php"); 
?>
<?php include_once('includes/header.php'); ?>

      <!-- Left side column. contains the sidebar -->
<?php include_once('includes/side_bar.php'); ?>

<?php  
$eid = $_GET['e_id'];

////
$sql="select * from `".TB_pre."transactions` WHERE `id` = '$eid' ";

$r1=mysqli_query($url,$sql) or die("Failed".mysqli_error($url));

if(isset($_REQUEST['btnapprove'])){

  $coupon = $_POST['couponid'];

  if (isset($coupon)) {
    $to = $sessionEmail;
    $subject = 'Congratulations on Winning!';
    $message = '<html><body>';
    $message .= '<table width="500px" align="center" cellpadding="15" style="font-family: \'Lucida Grande\', \'Lucida Sans Unicode\', \'Lucida Sans\', \'DejaVu Sans\', Verdana, \'sans-serif\'">';
    $message .= '<tr>';
    $message .= '<td align="center">';
    $message .= '<img src="https://winwithalyoum.ae/demo/assets/images/email-logo.png" alt="alyoum" >' ;
    $message .= '</td>';
    $message .= '</tr>';
    $message .= '<tr bgcolor="#0D8340" style="color: #fff">';
    $message .= '<td>';
    $message .= '<h2>Dear ' . $name . ' Thank you for your participation</h2>';
    $message .= '<p>Here is your Coupon No ' . $coupon . '.</p>';
    $message .= '<p>You will receive the code via email on your registered email id within 1-2 days.</p>';
    $message .= '</td>';
    $message .= '</tr>';
    $message .= '</table>';
    $message .= '</body></html>';

    // Set content type header for HTML email
    $headers = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
    $headers .= 'From: noreply@winwithalyoum.ae' . "\r\n";
    $headers .= 'Reply-To: noreply@winwithalyoum.ae' . "\r\n";
    $headers .= 'X-Mailer: PHP/' . phpversion();

    // mail($to, $subject, $message, $headers);
    $emailSent = mail($to, $subject, $message, $headers);

    if ($emailSent) {
    //    echo "Email sent successfully.";
        $emailStatus = 1;
$msg=""; $error="";
		//  var_dump($num); exit;
   
      $query = "UPDATE `".TB_pre."prize` SET `confirm`='1',`coupon`='$coupon',`mailstatus`='$emailStatus' WHERE pid=".$_GET['pid'];
     print_r($query);
      $r = mysqli_query($url, $query) or die(mysqli_error($url));
		  if($r){
			  $msg.= "Coupon Successfully Sent";
		  }
		  else {
			  $error.= "Failed: Error occured";
		  }

    } else {
     //   echo "Email sending failed.";
        $emailStatus = 0;
        $error.= "Failed: Error occured";
    }
}

		
	  

}
?>
  
  <style type="text/css">
  	.grey-img{ opacity:0.4;}
  </style>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Validate Transaction
          </h1>
          
         <!-- <ol class="breadcrumb">
            <li><a href="products.php" class="btn btn-block"><i class="fa fa-eye"></i>View Products</a></li>
          </ol>-->
        
        </section>

        <!-- Main content -->
        <section class="content">

          <!-- Default box -->
          <div class="box">

            <div class="box-header with-border">
              <?php if(isset($msg)){ if($msg!=""){ ?>
              	<div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4><i class="icon fa fa-check"></i> <?php echo $msg; ?></h4>
                    
               	</div>
               <?php }} ?> 
               <?php if(isset($error)){ if($error!=""){ ?>
              	<div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4><i class="icon fa fa-ban"></i> <?php echo $error; ?></h4>
                    
               	</div>
               <?php } } ?> 
            </div>
            
            <div class="box-body">
            <table id="example2" class="table table-bordered table-hover">
                    <tbody>
                    <?php 
                    
					$i = 1;
					while($res = mysqli_fetch_array($r1)){ ?>
                      <tr>
                        <!--<td><?php //if($res["product_img"]!=""){ ?>
                      <img src="uploads/<?php //echo $res["product_img"]; ?>" width="200" />
                      <?php //} else{ echo "No-image";} ?></td>-->
						 <th>Full Name</th>
						<td><?php echo $res['full_name']; ?></td>
						</tr>
           
            <tr>
						<th>Prize Won</th>
						<td><?php echo $res['prize']; ?></td>
						</tr>
						<tr>
            <tr>
						<th>Mobile</th>
						<td><?php echo $res['mobile']; ?></td>
						</tr>
						<tr>
						<th>Email</th>
                        <td><?php echo $res['email']; ?></td>
						</tr>
             
						<tr>
						<th>Country</th>
						<td><?php echo $res['country']; ?></td>
						</tr>
            <tr>
						<th>City</th>
						<td><?php echo $res['emirate']; ?></td>
						</tr>
						<tr>
						<th>Invoice number</th>
                        <td><?php  echo $res['invoice_no']; ?></td>
						</tr>
            <tr>
						<th>Invoice Image</th>
                        <td><?php if($res["invoice_img"]!=""){ ?>
                      <img src="../alyoumAdmin987/uploads/<?php //if($res['is_arabic']==1) {echo ('../ar/uploads/');} else {echo ('../uploads/');} ?><?php echo $res["invoice_img"]; ?>" />
                      <?php } else{ echo "No-image";} ?></td>
						</tr>
            <tr>
						<th>Product Image</th>
                        <td><?php if($res["product_img"]!=""){ ?>
                      <img src="../alyoumAdmin987/uploads/<?php //if($res['is_arabic']==1) {echo ('../ar/uploads/');} else {echo ('../uploads/');} ?><?php echo $res["product_img"]; ?>" />
                      <?php } else{ echo "No-image";} ?></td>
						</tr>
            
						<tr>
						<!-- <th>National ID / Iqama ID</th>
                        <td><?php // echo $res['eid']; ?></td>
						</tr> -->
						<tr>
						<th>Submitted Date</th>
                        <td><?php echo $res['submission_date']; ?></td>
						</tr>
						<tr>
				
					
						<tr>
              	
						<th>Approve</th>
            <td>
              <?php if($pr_res->confirm == 0) { ?>
            <form role="form" method="post"  action="" enctype="multipart/form-data" id="approve_form">
              <input style="max-width: 500px; margin-bottom: 15px;" class="form-control" type="text" name="couponid" id="couponid" placeholder="Coupon Number" required />
              <div id="coupon-err"></div>
            <button type="submit" class="btn btn-primary" name="btnapprove" id="approve_button">Confirm</button>
            </form>  
            <?php } else { ?>
            <div style="width:100px; cursor:auto" class="btn btn-success" title="">Confirmed</div>
         <?php } ?>
          </td>
                        <!-- <td><a href="javascript:removeItem(<?php // echo $res['entry_id']; ?>);" class="btn btn-danger">Remove</a></td> -->
                      </tr> 
                      <tr>
                      <?php if($pr_res->confirm == 0) { ?>
						<th>Deny & Reassign</th>
            <td><a href="edit-prize.php?pid=<?php echo $_GET['pid'] ?>" class="btn btn-warning">Deny</a></td>
                   <?php } ?>
                      </tr>
                      <?php }?>
                    </tbody>
                    <tfoot>
                    </tfoot>
                  </table>
            </div><!-- /.box-body -->
            
            <div class="box-footer">
            
            </div><!-- /.box-footer-->
          </div><!-- /.box -->

        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->

<?php include_once('includes/footer.php'); ?>
    <!-- jQuery 2.1.4 -->
<?php include_once('includes/footer-scripts.php'); ?>     
<script>

	$(document).ready(function(){

    $('#approve_button').on('click', function(){
    var coupon = $('#couponid').val();
    console.log(coupon);
    if(coupon.length < 3) {
        $('#coupon-err').html('<p class="errormsg" style="color:red;">Please enter a valid Coupon code</p>');
        document.getElementById('couponid').focus();
        return false;
    }

});
	});


</script>
    
  </body>
</html>
<?php ob_end_flush(); ?>
<?php 
// error_reporting(E_ALL);
$active="submissions"; 

ob_start();
include("includes/conn.php"); 
?>

<?php include_once('includes/header.php'); ?>


 <!-- Left side column. contains the sidebar -->
 <?php include_once('includes/side_bar.php'); ?>

<?php  
date_default_timezone_set('Asia/Dubai'); 
$timestamp = time(); 
$dateString = date("Y-m-d H:i:s", $timestamp);

$date = date('Y-m-d');
 
$entry_id = $_GET['e_id'];

$checkRejections = "SELECT * FROM `" . TB_pre . "rejections` WHERE `entry_id` = '$entry_id'";
          $checkRejectionsResult = mysqli_query($url, $checkRejections);
          $rejectionRowCount = mysqli_num_rows($checkRejectionsResult);

$sql="select * from `".TB_pre."shop_win` WHERE `entry_id` = '$entry_id'  ORDER BY entry_id DESC ";
$r1=mysqli_query($url,$sql) or die("Failed".mysqli_error($url));

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['reject'])) {

  if (empty($_POST["reason"])) { 
    echo "<script>alert('Please enter reason for rejection!')</script>";
  } else {
  $entry_id = $_POST["id"];
  $reason = htmlspecialchars($_POST["reason"], ENT_QUOTES, 'UTF-8');
  
  // Update query to set `rejected` column to 1 for the specified `entry_id`
  $update_prize_query = "UPDATE `" . TB_pre . "prize` 
                          SET `confirm`='0', `rejected`='1', `mailtime`='$dateString'
                          WHERE `winner` = '$entry_id'";

  $result = mysqli_query($url, $update_prize_query);
  if ($result) {

    
      // Successful update
      echo "<span style='color: green;'>Entry rejected successfully!</span>";

      // Insert into rejection table
      $prize_sql = "SELECT * FROM `" . TB_pre . "prize` WHERE `winner` = '$entry_id'";
      $prize_r1 = mysqli_query($url, $prize_sql) or die("Failed" . mysqli_error($url));

      if (mysqli_num_rows($prize_r1) > 0) {
          // Fetch the row as an associative array
          $prize_res = mysqli_fetch_assoc($prize_r1);
          $pid = $prize_res['pid'];

          $rejection_time = date("Y-m-d H:i:s");
          $checkRejections = "SELECT * FROM `" . TB_pre . "rejections` WHERE `prize_id` = '$pid' OR `entry_id` = '$entry_id'";
          $checkRejectionsResult = mysqli_query($url, $checkRejections);
          $rejectionRowCount = mysqli_num_rows($checkRejectionsResult);
          
        if($rejectionRowCount > 0) {

          $rejected = 1;
          // Existing rejection records found, no need to insert a new record
    // You can add any additional logic here if needed
        } else {
           $re_query = "INSERT INTO `".TB_pre."rejections` (`prize_id`, `entry_id`, `reason`, `rejection_time`) 
                       VALUES ('$pid', '$entry_id', '$reason', '$rejection_time')";
          $re_result = mysqli_query($url, $re_query);

          $zone=1;	
	      $prize=$prize_res['prize'];

          $newPrize_query = "INSERT INTO `".TB_pre."prize` (`date`,`prize`,`zone`) VALUES('$date','$prize','$zone')";
          $newPrize_result = mysqli_query($url, $newPrize_query);

          $update_entry_query = "UPDATE `" . TB_pre . "shop_win` 
          SET `rejected`='1' WHERE `entry_id` = '$entry_id'";
          $result = mysqli_query($url, $update_entry_query);
        }
          

          if (!$re_result) {
              // Error occurred while inserting into rejection table
              echo "<span style='color: red;'>Error: Unable to log rejection.</span>";
          }
      } else {
          // Prize not found
          echo "<span style='color: red;'>Error: Prize not found.</span>";
      }
  } else {
      // Error occurred


      echo "<span style='color: red;'>Error: Unable to reject entry.</span>";
  }

  // Redirect or reload the page after processing
  header("Location: {$_SERVER['REQUEST_URI']}"); // Using REQUEST_URI

  exit;

}
}


?>  

      <!-- =============================================== -->

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Reject Submission
            <small></small>
          </h1>
          
 
          
        </section>

        <!-- Main content -->
        <section class="content">

          <!-- Default box -->
          <div class="box">
            <div class="box-header with-border">
            
              <?php if(isset($msg)){ ?>
              	<div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4><i class="icon fa fa-check"></i> <?php echo $msg; ?></h4>
               	</div>
               <?php } ?> 
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
						<td><?php echo $res['first_name'] ." ". $res['last_name'] ; ?></td>
						</tr>
						<tr>
						<th>Mobile</th>
						<td><?php echo $res['mobile']; ?></td>
						</tr>
						<tr>
						<th>Email</th>
                        <td><?php echo $res['email']; ?></td>
						</tr>
						<tr>
						<th>Prize</th>
                        <td><?php if($res['prize'] == 'airfryer') {echo 'Air Fryer'; } else { echo 'Recipe Book';} ?></td>
						</tr>
						<th>City</th>
                        <td><?php echo $res['emirate']; ?></td>
						</tr>
						<tr>
						<tr>
						<th>Invoice No.</th>
						<td><?php  echo $res['invoice_no']; ?></td>
						</tr>
						
						<tr>
							<th>Invoice Image</th>
							<td><?php if($res["invoice_img"]!=""){ ?>
                      <img src="../alyoumAdmin987/uploads/<?php echo $res["invoice_img"]; ?>" style="width:150px; height:auto;"/>
                      <?php } else{ echo "No-image";} ?></td>
						</tr>
						<!-- <tr>
							<th>Image</th>
							<td><?php if($res["invoice_img"]!=""){ ?>
                      <img src="../alyoumAdmin987/uploads/<?php if($res['is_arabic']==1) {echo ('../ar/uploads/');} else {echo ('../uploads/');} ?><?php echo $res["invoice_img"]; ?>" />
                      <?php } else{ echo "No-image";} ?></td>
						</tr> -->
						<tr>
						<tr>
						<th>Submitted On</th>
                        <td><?php echo $res['submission_date']; ?></td>
						</tr>

            <tr>

            <th>Status  </th>
            <td>
              <?php if (($res['rejected'] == '1') || ($rejectionRowCount > 0)) {
                echo "<span style='background-color:#f39c12; color:#fff; padding: 7px 10px; margin-top:10px'>Rejected</span>";
                 } else { ?>
            <form action="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']); ?>" method="post" name="reject" id="rejectSubmission">

    <input type="hidden" name="id" value="<?php echo $entry_id; ?>">
    <input type="hidden" name="e_id" value="<?php echo isset($_GET['e_id']) ? htmlspecialchars($_GET['e_id']) : ''; ?>">

    <textarea style="width:100%; padding-left:15px;" name="reason" id="reason" cols="30" rows="5" placeholder="Reason for Rejection"></textarea>
    <input type="submit" name="reject" value="Reject" class="btn btn-warning" style="width: max-content; margin: auto;">
</form>
<?php } ?>
            </td>
            </tr>
						
						<!-- <tr>
						<th>Delete</th>
                        <td><a href="javascript:removeItem(<?php // echo $res['entry_id']; ?>);" class="btn btn-danger">Remove</a></td>
                      </tr> -->
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

     
      <!-- Control Sidebar -->


	<?php include_once('includes/footer.php'); ?>
    <!-- jQuery 2.1.4 -->
   <?php include_once('includes/footer-scripts.php'); ?>
    
    
    <!-- AdminLTE for demo purposes -->
     <script>
      $(function () {
        $('#example2').DataTable({
          "paging": true,
          "lengthChange": true,
          "searching": true,
          "ordering": true,
          "info": true,
          "autoWidth": false
		  });
      });
    </script>
    <script type="text/javascript">
    function removeItem(id){
		var c= confirm("Do you want to remove this?");
		if(c){
			location = "submissions.php?remove_pr="+id;
		}
	}
	
    </script>
  </body>
</html>
<?php ob_end_flush(); ?>
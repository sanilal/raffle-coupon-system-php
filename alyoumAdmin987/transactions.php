<?php $active="submissions"; 
ob_start();
include("includes/conn.php"); 
?>

<?php include_once('includes/header.php'); ?>


 <!-- Left side column. contains the sidebar -->
 <?php include_once('includes/side_bar.php'); ?>

<?php  

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Check if the specific form's submit button was clicked
  if (isset($_POST['submit_invoice'])) {
      $transaction_id = intval($_POST['submit_invoice']); // Use the value of the submit button to get the transaction ID
      $invoice_value = floatval($_POST['invoice_value']);
      $target_value = 20.0;
      $epsilon = 0.00001; // Small tolerance for floating-point comparison
      $raffleCoupons = '';

      $gw = $_POST['gwid'];
      $gwQuery = "SELECT `prize_multiplication` FROM `" . TB_pre . "golden_week` WHERE `id` = '" . $gw . "'";
      $prizeMultiply = mysqli_fetch_object(mysqli_query($url, $gwQuery))->prize_multiplication;
     
      if ($invoice_value > $target_value || abs($invoice_value - $target_value) < $epsilon) {
        $raffleCoupons = floor($invoice_value / $target_value); 
      } else {
        $raffleCoupons = 0;
      }
      if($prizeMultiply>0){ $finalRaffleCoupons=$prizeMultiply*$raffleCoupons; } else { $finalRaffleCoupons=$raffleCoupons;}
   //   var_dump($finalRaffleCoupons); die;
      // Update the invoice value in the transaction table
      $update_query = "UPDATE `".TB_pre."transactions` SET `invoice_value` = '$invoice_value', `raffle_coupons` = '$finalRaffleCoupons' WHERE `id` = '$transaction_id'";
      
      if (mysqli_query($url, $update_query)) {
          // Redirect back to the same page after successful update
          header('Location: transactions.php');
          exit();
      } else {
          echo "Error: " . mysqli_error($url);
      }
  }
}

if(isset($_GET['p_id']) && isset($_GET['status']) ){
	$id = $_GET['p_id'];
	$status = $_GET['status'];
	$query = "UPDATE `".TB_pre."products` set status='$status' WHERE `product_id`='$id'";
	$r = mysqli_query($url, $query) or die(mysqli_error($url));
	if($r){
		$msg = "Status updated Successfully.";
	}
}

if(isset($_GET['remove_pr'])){
	$id = $_GET['remove_pr'];
	$pr_img_res=mysqli_fetch_object(mysqli_query($url,"select product_img,gallery_imgs from `".TB_pre."products` WHERE `product_id`='$id'"));
	$query = "DELETE FROM `".TB_pre."shop_win` WHERE `entry_id`='$id'";
	$r = mysqli_query($url, $query) or die(mysqli_error($url));
	unlink( "uploads/".$pr_img_res->product_img);
	$g_imgs=explode(",",$pr_img_res->gallery_imgs);
	foreach($g_imgs as $g_img){
		unlink( "uploads/".$g_img->product_img);
	}
	if($r){
		$msg = "The selected entry deleted successfully.";
	}
}
 // $sql="select * from `".TB_pre."shop_win` GROUP BY `email` ORDER BY entry_id DESC ";
 $sql="select * from `".TB_pre."transactions` ORDER BY id DESC ";
$r1=mysqli_query($url,$sql) or die("Failed".mysqli_error($url));


?>  

      <!-- =============================================== -->
<style>
    .invval-container {
    display: flex;
    gap: 5px;
    flex-direction: column;
    max-width: 160px;
}

.invval-container button[name="submit_invoice"] {
    width: 85px;
    margin: auto;
}
/* The Modal (background) */
.modal {
    display: none;
    position: fixed;
    z-index: 9999;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.85);
    margin: auto;
}
.imginv {
    display: flex;
    flex-direction: column;
    gap: 8px;
    cursor: pointer;
    justify-content: center;
    align-items: center;
}
.imginv a:hover {
    text-decoration: underline;
}
.modal-content {
    width: 80%;
    max-width: max-content;
    max-height: 80vh;
    /* overflow-y: scroll; */
    margin: 10vh auto;
    background: transparent;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
}

#caption {
    text-align: center;
    color: #ccc;
    padding: 10px;
}

.close {
    position: absolute;
    top: 0;
    right: -35px;
    color: #f90000 !important;
    font-size: 40px;
    font-weight: 500;
    cursor: pointer;
    opacity: 1 !important;
    background: #ffffff;
    width: 35px;
    height: 35px;
    display: flex;
    justify-content: center;
    align-items: center;
}

.download-btn {
    display: block;
    text-align: center;
    margin: 15px auto;
    padding: 10px 20px;
    background-color: #f1c40f;
    color: #000;
    text-decoration: none;
    font-weight: bold;
    border-radius: 5px;
    max-width: 156px;
}


</style>
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            View Transactions
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
                    <thead>
                      <tr>
                      <th>Sl. No</th>
                      <th>User</th>
                      <th>Email</th>
                      <th>Mobile</th>
                      <th>City</th>
                        <th>Invoice No</th>
                        <th>Invoice Image</th>
                        <th>Invoice Value</th>
                        <th>Raffle Coupons</th>
                        <th>Golden Week</th>
                        <!-- <th>View</th> -->
                        <!-- <th>Action</th> -->
                      </tr>
                    </thead>
                    <tbody>
                    <?php 
					$i = 1;
					while($res = mysqli_fetch_array($r1)){ ?>
                      <tr>
                        <td><?php echo $i++; ?></td>
                        <!--<td><?php //if($res["product_img"]!=""){ ?>
                      <img src="uploads/<?php //echo $res["product_img"]; ?>" width="200" />
                      <?php //} else{ echo "No-image";} ?></td>-->
                      <td>
    <?php 
    // Query to fetch user details
    $users_query = "SELECT `first_name`, `last_name`, `email`, `mobile`, `region` FROM `" . TB_pre . "users` WHERE `id` = '" . $res['user_id'] . "'";

    // Execute the query
    $users_result = mysqli_query($url, $users_query);

    // Check if query execution is successful and the user exists
    if ($users_result && mysqli_num_rows($users_result) > 0) {
        // Fetch user object
        $users_r = mysqli_fetch_object($users_result);

        // Display first and last name
        echo htmlspecialchars($users_r->first_name . " " . $users_r->last_name);
        $email = $users_r->email;
        $mobile = $users_r->mobile;
        $city = $users_r->region;
    } else {
        // Handle case where no user is found
        echo "Unknown User";
    }
    ?>
</td>

                        <td><?php echo $email; ?></td>
                        <td><?php echo $mobile; ?></td>
                        <td><?php echo $city; ?></td>
                        <td><?php echo strval($res['invoice_no']); ?>.</td>
						            <!-- <td><?php // echo $res['invoice_no']; ?></td> -->
            
						<!-- Display the thumbnail with download and popup functionality -->
                        <td>
        <!-- Download link for the specific image -->
        
            <!-- Thumbnail image that triggers the popup -->
            <div class="imginv">
            <a download="<?php echo $res['invoice_img']; ?>" href="/uploads/<?php echo $res['invoice_img']; ?>" id="downloadimg">
            <img src="uploads/<?php echo $res['invoice_img']; ?>" width="75px" height="75px" class="image-thumb" data-full-image="uploads/<?php echo $res['invoice_img']; ?>" alt="Invoice Image"/>
        </a>
            </div>
    </td>

            <td>
    <?php
    $invValue = floatval($res['invoice_value']); // Convert to a float
    if ($invValue > 0) {
        echo htmlspecialchars($invValue);
    } else { 
    ?>
        <a href="#" class="btn btn-warning show-invoice-input" data-id="<?php echo $res['id']; ?>">Add Invoice Value</a>

        <form class="invoice-form" action="transactions.php" method="post" style="display:none;" id="invoice-form-<?php echo $res['id']; ?>">
            <input type="hidden" name="transaction_id" value="<?php echo $res['id']; ?>">
           <div class="invval-container">
            <input type="number" name="invoice_value" class="form-control" placeholder="Enter Invoice Value" step="0.01" required>
            <input type="hidden" name="gwid" value="<?php echo $res['golden_week_id']; ?>">
            <button type="submit" name="submit_invoice" value="<?php echo $res['id']; ?>" class="btn btn-success">Update</button>
           </div>
        </form>
    <?php } ?>
</td>


             <td><?php
            $raffleCoupons = strval($res['raffle_coupons']);
           

            // echo($prizeMultiply); die;
            if($raffleCoupons > 0) { echo $raffleCoupons; } else { if($res['invoice_value']<1) { ?>
            Add Invoice value to show Raffle Coupons
            <?php } else {echo '0'; } }?>
             </td>
             <td><?php
             $resgw = $res['golden_week_id'];
            if($resgw > 0) { echo "Yes"; } else {  ?>
            No
            <?php }?>
             </td>
                        <!-- <td><a href="transaction.php?e_id=<?php echo $res['entry_id']; ?>" class="btn btn-primary" title="">View</a>&nbsp;
                        <a href="javascript:removeItem(<?php echo $res['entry_id']; ?>);" class="btn btn-danger">Remove</a></td> -->
                        <!-- <td>
                    <?php if( $res['confirm'] == '1' AND $res['rejected'] == '0') { echo "<span style='background-color:#0dc736; color:#fff; padding: 7px 10px; margin-top:10px'>Confirmed</span>"; } elseif ($res['confirm'] == '0' AND $res['rejected'] == '1'){
echo "<span style='background-color:#e90606; color:#fff; padding: 7px 10px; margin-top:10px'>Rejected</span>";
                    }else { ?>
                        <a href="approve-transaction.php?e_id=<?php  echo $user['entry_id']; ?>" style="width:70px; margin-bottom:10px" class="btn btn-success" title="">Approve</a>
                        <a href="reject-transaction.php?e_id=<?php  echo $user['entry_id']; ?>" style="width:70px; margin-bottom:10px" class="btn btn-warning" title="">Reject</a>
                        <?php } ?>
                        
                    </td> -->
                      

                      </tr>
                      <?php }?>
                    </tbody>
                    <tfoot>
                    </tfoot>
                  </table>
                  <!-- Shared Modal for viewing images -->
<div id="image-modal" class="modal">
    
    <!-- Full-size image displayed in modal -->
     <div class="modal-content">
     <span class="close">&times;</span>
        <img class="img-fluid" id="full-image" src="">
    <!-- <div id="caption">Invoice Image</div> -->
    <!-- Download button inside modal -->
    <a download="" href="" id="download-btn" class="download-btn">Download Image</a>
     </div>
    
</div>

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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/PapaParse/5.3.0/papaparse.min.js"></script>

<script>

document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.show-invoice-input').forEach(function (btn) {
        btn.addEventListener('click', function (e) {
            e.preventDefault();
            var id = btn.getAttribute('data-id');
            // Hide the button and show the form
            btn.style.display = 'none';
            document.getElementById('invoice-form-' + id).style.display = 'block';
        });
    });
});

// Modal starts
// Get modal element and components
var modal = document.getElementById("image-modal");
var fullImage = document.getElementById("full-image");
var closeBtn = document.getElementsByClassName("close")[0];
var downloadBtn = document.getElementById("download-btn");
var imageThumbs = document.getElementsByClassName("image-thumb");
//var downloadimg = document.getElementById("downloadimg");

// Function to open modal and set the correct image and download link
Array.from(imageThumbs).forEach(function(image) {
    image.onclick = function() {
        var fullImageUrl = image.getAttribute('data-full-image'); // Get the full image URL
        var downloadUrl = image.parentNode.getAttribute('href');  // Get the download URL

        // Set the modal image and download button's href
        fullImage.src = fullImageUrl;
        downloadBtn.href = downloadUrl;
       // downloadimg.href = fullImageUrl;

        // Show the modal
        modal.style.display = "block";
    }
});

// Close modal when clicking the close button
closeBtn.onclick = function() {
    modal.style.display = "none";
}

// Close modal when clicking outside of the modal content
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}

// modal ends


    $(function () {
        $('#example2').DataTable({
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'copyHtml5',
                    exportOptions: {
                        columns: [0, ':visible']
                    }
                },
                {
                    extend: 'excelHtml5',
                    title: 'alyoum Winners',
                    exportOptions: {
                        columns: ':visible'
                    },
                    customize: function (xlsx) {
                        var sheet = xlsx.xl.worksheets['sheet1.xml'];
                        $('row c', sheet).attr('s', '2');
                    }
                },
                {
                    extend: 'csvHtml5',
                    extension: '.txt',
                    exportOptions: {
                        columns: ':visible'
                    },
                    action: function (e, dt, button, config) {
                        var data = dt.buttons.exportData(config);
                        var csv = Papa.unparse({
                            fields: data.header,
                            data: data.body
                        });

                        // Add BOM (Byte Order Mark)
                        var blob = new Blob(["\ufeff", csv]);
                        saveAs(blob, config.title + '.csv');
                    }
                },
                {
                    extend: 'pdfHtml5',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4]
                    }
                },
                {
                    extend: 'print',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4]
                    }
                },
                'colvis'
            ]
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
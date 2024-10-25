<?php $active="notification"; ?>
<?php
	ob_start();
	include("includes/conn.php"); 
?>
<?php include_once('includes/header.php'); ?>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
  .select2-container--default .select2-selection--multiple .select2-selection__choice {
    background-color: #313131 !important;
  }
  .switch {
    position: relative;
    display: inline-block;
    width: 60px;
    height: 34px;
  }

  .switch input {
    opacity: 0;
    width: 0;
    height: 0;
  }

  .slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ccc;
    transition: 0.4s;
    border-radius: 34px;
  }

  .slider:before {
    position: absolute;
    content: "";
    height: 26px;
    width: 26px;
    left: 4px;
    bottom: 4px;
    background-color: white;
    transition: 0.4s;
    border-radius: 50%;
  }

  input:checked + .slider {
    background-color: #4CAF50;
  }

  input:checked + .slider:before {
    transform: translateX(26px);
  }

</style>
      <!-- Left side column. contains the sidebar -->
<?php include_once('includes/side_bar.php'); ?>

<?php  
 $startdate_query = "SELECT `c_start`, `c_ends` FROM `".TB_pre."zone`";
 $startdate_r = mysqli_query($url, $startdate_query) or die(mysqli_error($url));
 $startdate_assoc = mysqli_fetch_assoc( $startdate_r );
$startdate=$startdate_assoc['c_start'];
$enddate=$startdate_assoc['c_ends'];

// Users query
$users_query = "SELECT `id`, `first_name`, `last_name`, `email` FROM `".TB_pre."users`";
$users_r = mysqli_query($url, $users_query) or die(mysqli_error($url));



 if(isset($_REQUEST['btnadd'])){
	 
	$name=$_POST['nname'];	
	$users=$_POST['users'];	
  $notification=$_POST['notification'];
	$start_date	= $_POST['n_start_date'];
	$end_date	= $_POST['n_end_date'];
  $active= $_POST['status'];
  $start_timestamp = strtotime($start_date);
  $end_timestamp = strtotime($end_date);
	$datediff= $end_timestamp - $start_timestamp;
  $duration=round($datediff / (60 * 60 * 24));

    // Check if "All" was selected (value = 0), otherwise, process the array
    if (in_array("0", $users)) {
      $userString = 0;  // If 'All' is selected, we save '0' in the DB
  } else {
      // Convert the users array to a comma-separated string
      $userString = implode(",", $users); // Example: "1,2,3"
  }

  $notification = mysqli_real_escape_string($url, $notification);
// var_dump($notification); die;

  if($active!=1) {
    $active =0;
  }
 // var_dump($active); die;

	if($name!="" && $users!="" && $start_date!="" && $end_date!=""  ){

		 // var_dump($multiplier); exit;
		  $query = "INSERT INTO `".TB_pre."notifications` (`notification_name`,`notification_message`,`applicable_users`,`duration`,`start_date`,`end_date`,`active`) VALUES('$name','$notification','$userString','$duration','$start_date','$end_date','$active')";
		  //echo $query; exit;
		  $r = mysqli_query($url, $query) or die(mysqli_error($url));
		  if($r){
			  $msg.= "Notification Successfully Added";
              $name = "";
              $start_date = "";
              $end_date = "";
              $multiplier = "";
		  }
		  else {
			  $error.= "Failed: Error occured";
		  }
	  
	}
	else {
			  $error.= "Failed: Fill all the required fields";
		  }
}
?>
  

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Add Notification
          </h1>
          
          <!--<ol class="breadcrumb">
            <li><a href="products.php" class="btn btn-block"><i class="fa fa-eye"></i>View Products</a></li>
          </ol>-->
        
        </section>

        <!-- Main content -->
        <section class="content">

          <!-- Default box -->
          <div class="box">

         

			<?php
			$sql="select * from `".TB_pre."notifications` WHERE `active` = 1 ORDER BY `id` DESC ";
			$r1=mysqli_query($url,$sql) or die("Failed".mysqli_error($url));
			?>
		<div class="box-body">
                  <table id="example2" class="table table-bordered table-hover center-table" style="max-width: 100%; float: left;">
                    <thead>
                      <tr>
                      <th>No.</th>
                      <th>Name</th>
                      <th>Notification</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Users</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php 
					$i = 1;
					while($res = mysqli_fetch_array($r1)){ ?>
                      <tr>
                        <td><?php echo $i++; ?></td>
                        <td><?php echo $res['notification_name']; ?></td>
                        <td>
                          <?php echo $res['notification_message']; ?>
                          <?php if(isset($res['message_arabic'])) { echo $res['message_arabic']; } ?>
                        </td>
                        <td><?php echo $res['start_date']; ?></td>
                        <td><?php echo $res['end_date']; ?></td>
                        <td>
                          <?php 
                            $user_ids = explode(',', $res['applicable_users']); 
                            $user_ids_string = implode(',', array_map('intval', $user_ids));

                            $userquery = "SELECT email FROM `".TB_pre."users` WHERE id IN ($user_ids_string)";
                            $userresult = mysqli_query($url, $userquery);
                           // var_dump($userresult); die;
                              if ($userresult) {
                                  // Fetch and display emails
                                  $useremails = [];
                                  while ($userrow = mysqli_fetch_assoc($userresult)) {
                                      $useremails[] = $userrow['email'];
                                  }

                                  // Display the emails as a comma-separated string
                                  echo implode(', ', $useremails); // Example: user1@example.com, user2@example.com
                              } else {
                                  echo "No users found for the given IDs.";
                              }
                       //     echo $user_ids_string; 
                          ?>
                        </td>
<td>
<a href="notification.php?nid=<?php echo $res['id']; ?>" class="btn btn-primary" title="Edit">View</a>
</td>
                      
                      </tr>
                      <?php }?>
                    </tbody>
                    <tfoot>
                    </tfoot>
                  </table>
                </div><!-- /.box-body -->
            
            <!--<div class="box-footer">
            
            </div>--><!-- /.box-footer-->
          </div><!-- /.box -->

        </section><!-- /.content -->

		
      </div><!-- /.content-wrapper -->

<?php include_once('includes/footer.php'); ?>
    <!-- jQuery 2.1.4 -->
<?php include_once('includes/footer-scripts.php'); ?>  
<script src="https://cdn.ckeditor.com/4.5.7/standard/ckeditor.js"></script>   
<script>
  
$(function () {
    // Replace the <textarea id="editor1"> with a CKEditor
    // instance, using default configuration.
    CKEDITOR.replace('notification');
  });
  
  document.getElementById('status-toggle').addEventListener('change', function() {
    var statusLabel = document.getElementById('status-label');
    if (this.checked) {
      statusLabel.textContent = 'Active';
    } else {
      statusLabel.textContent = 'Inactive';
    }
  });



$(function () {
        /*$('#example2').DataTable({
          "paging": true,
          "lengthChange": true,
          "searching": true,
          "ordering": true,
          "info": true,
          "autoWidth": false
		  });*/
		  $('#example2').DataTable( {
        dom: 'Bfrtip',
        /*buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]*/
		buttons: [
            {
                extend: 'copyHtml5',
                exportOptions: {
                    columns: [ 0, ':visible' ]
                }
            },
            {
                extend: 'excelHtml5',
                exportOptions: {
                    columns: ':visible'
                }
            },
            {
                extend: 'pdfHtml5',
                exportOptions: {
                    columns: [ 0, 1, 2, 3, 4 ]
                }
            },
			{
                extend: 'print',
                exportOptions: {
                    columns: [ 0, 1, 2, 3, 4 ]
                }
            },
            'colvis'
        ]
    } );
      });




</script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<!-- Initialize Select2 -->
<script>
  $(document).ready(function() {
    $('#applicable-users').select2({
      placeholder: "Select users", // Placeholder text
      allowClear: true // Allows clearing selection
    });
  });
</script>
    
  </body>
</html>
<?php ob_end_flush(); ?>
<?php $active="leaderboard"; ?>
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
	 
	$user=$_POST['user'];	

    $start_date	= $_POST['n_start_date'];
	$end_date	= $_POST['n_end_date'];
  $active= $_POST['status'];

    $usql="select * from `".TB_pre."leaderboards` WHERE `user` = $user AND `active` = 1 ORDER BY `id` DESC ";
    $ur1 = mysqli_num_rows(mysqli_query($url, $usql));
    if($active!=1) {
        $active =0;
      }

    if ($ur1 > 0) {
        // User is already in an active leaderboard
        echo "<script>
            alert('User is already in an active leaderboard!');
            document.getElementById('myForm').reset(); // Clear the form fields
            window.location.reload(); // Reload the page
        </script>";
    } else {
        
	

  // var_dump($active); die;

	if($user!="" && $start_date!="" && $end_date!=""  ){

		 // var_dump($multiplier); exit;
		  $query = "INSERT INTO `".TB_pre."leaderboards` (`user`, `start_date`,`end_date`,`active`) VALUES('$user','$start_date','$end_date','$active')";
		  //echo $query; exit;
		  $r = mysqli_query($url, $query) or die(mysqli_error($url));
		  if($r){
			  $msg.= "Leaderboard Successfully Added";
              $user = "";
              $start_date = "";
              $end_date = "";
		  }
		  else {
			  $error.= "Failed: Error occured";
		  }
	  
	}
	else {
			  $error.= "Failed: Fill all the required fields";
		  }


    }


}
?>
  

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Add Leaderboad User
          </h1>
          
          <!--<ol class="breadcrumb">
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
              <form role="form" method="post"action="" enctype="multipart/form-data">
                  <div class="box-body">
                  
                 
					  <!--<div id="searchresult"></div>-->
                      <div class="row">
                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12 m-r-0">
                    <label>Select Users</label>
                    <select id="applicable-users" name="user" class="form-control">
                      <option value="">Select user</option>
                      <?php
                      // Fetch each user and display in the dropdown
                      while($users_assoc = mysqli_fetch_object($users_r)) { 
                        ?>
                        <option value="<?php echo $users_assoc->id; ?>">
                          <?php echo $users_assoc->first_name . ' ' . $users_assoc->last_name . ' &lt;' . trim($users_assoc->email) . '&gt;'; ?>
                        </option>
                      <?php } ?>
                    </select>
                  </div>

                  <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12 m-r-0">
                      
                    </div>
				
                   
					  </div>
                      <div class="row">
					  <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12 m-r-0" style="margin-left: 0;">
            
                      <label>Select Start Date</label>
					  <?php
					  ?>
                      <input type="date" class="form-control" placeholder="Start Date" name="n_start_date" id="n_start_date" min="<?php echo $startdate; ?>" max="<?php echo $enddate; ?>" />
					  </div>

                    

                      <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12 m-r-0">
                      <label>Select End Date</label>
					  <?php
					  ?>
                      <input type="date" class="form-control" placeholder="End Date" name="n_end_date" id="n_end_date" min="<?php echo $startdate; ?>" max="<?php echo $enddate; ?>"  />
					  </div>

            <!-- Form Group for Active/Inactive Toggle -->
<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12 m-r-0">
  <label for="status">Status</label>
  <label class="switch">
    <input type="checkbox" id="status-toggle" name="status" value="1">
    <span class="slider"></span>
  </label>
  <span id="status-label" style="margin-left: 10px;">Inactive</span>
</div>
                   
                   
					  </div>
					
					 <div class="row">
					  <div class="box-footer col-md-12 m-r-0" style="padding: 10px 0;">
                    	<button type="submit" class="btn btn-primary" name="btnadd">Add Leaderboard</button>
                  	  </div>
				  </div>
					</div>
					  
                    
                    
                  <!--  <div class="form-group" >
                      <label>Order</label>
                      <input type="number" class="form-control" placeholder="Order" name="order" />
                    </div>-->
                  </div><!-- /.box-body -->

                  
                </form>
            </div><!-- /.box-body -->

			<?php
			$sql="select * from `".TB_pre."leaderboards` WHERE `active` = 1 ORDER BY `id` DESC ";
			$r1=mysqli_query($url,$sql) or die("Failed".mysqli_error($url));
			?>
		<div class="box-body">
                  <table id="example2" class="table table-bordered table-hover center-table" style="width: 100%; max-width: 650px; float: left;">
                    <thead>
                      <tr>
                      <th>No.</th>
                      <th>User</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php 
					$i = 1;
					while($res = mysqli_fetch_array($r1)){ ?>
                      <tr>
                        <td><?php echo $i++; ?></td>
                        <?php
// Assuming $res['user'] contains the user ID
$user_id = $res['user'];

// Query to fetch first_name and last_name from users table
$user_query = "SELECT first_name, last_name FROM `".TB_pre."users` WHERE id='$user_id'";
$user_result = mysqli_query($url, $user_query) or die(mysqli_error($url));

if ($user_row = mysqli_fetch_assoc($user_result)) {
    // Extract first_name and last_name from the result
    $first_name = $user_row['first_name'];
    $last_name = $user_row['last_name'];
    
    // Echo the first name and last name in the table
    echo "<td>" . $first_name . " " . $last_name . "</td>";
} else {
    // Handle case where no user is found
    echo "<td>User not found</td>";
}
?>
                        <td><?php echo $res['start_date']; ?></td>
                        <td><?php echo $res['end_date']; ?></td>
                        
<td>
<a href="edit-leaderboard.php?id=<?php echo $res['id']; ?>" class="btn btn-primary" title="Edit">Edit </a>
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
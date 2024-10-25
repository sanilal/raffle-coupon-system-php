<?php $active="campaign"; ?>
<?php
	ob_start();
	include("includes/conn.php"); 
?>
<?php include_once('includes/header.php'); ?>

      <!-- Left side column. contains the sidebar -->
<?php include_once('includes/side_bar.php'); ?>

<?php  
 $startdate_query = "SELECT `c_start`, `c_ends` FROM `".TB_pre."zone`";
 $startdate_r = mysqli_query($url, $startdate_query) or die(mysqli_error($url));
 $startdate_assoc = mysqli_fetch_assoc( $startdate_r );
$startdate=$startdate_assoc['c_start'];
$enddate=$startdate_assoc['c_ends'];


 if(isset($_REQUEST['btnadd'])){
	 
	$name=$_POST['wname'];	
	$start_date	= $_POST['gw_start_date'];
	$end_date	= $_POST['gw_end_date'];
	$multiplier=$_POST['multiplier'];
  $notification=$_POST['notification'];
  $arabicnotification=$_POST['arabicnotification'];
  $active= $_POST['status'];
// var_dump($notification); die;
  if($active!=1) {
    $active =0;
  }

  
  $notification = mysqli_real_escape_string($url, $notification);
  $arabicNotification = mysqli_real_escape_string($url, $arabicNotification);

	if($name!="" && $start_date!="" && $end_date!="" && $multiplier!=""  ){

		 // var_dump($multiplier); exit;
		  $query = "INSERT INTO `".TB_pre."golden_week` (`name`,`start_date`,`end_date`,`prize_multiplication`,`notification`,`notification_arabic`,`active`) VALUES('$name','$start_date','$end_date','$multiplier','$notification','$arabicnotification','$active')";
		 // echo $query; exit;
		  $r = mysqli_query($url, $query) or die(mysqli_error($url));
		  if($r){
			  $msg.= "Golden Week Successfully Added";
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
  
<style>
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
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Add Golden Week
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
					  <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12 m-r-0" style="margin-left: 0;">
                      <label>Name</label>
					  <?php
					  ?>
                      <input type="text" class="form-control" placeholder="Week Name" name="wname" id="wname" />
                    </div>

                    <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12 m-r-0">
                    <label>Multiplier</label>
            
            <input type="number" class="form-control"  placeholder="0.00" required name="multiplier" min="0" value="0" step="0.01" pattern="^\d+(?:\.\d{1,2})?$" onblur="
this.parentNode.parentNode.style.backgroundColor=/^\d+(?:\.\d{1,2})?$/.test(this.value)?'inherit':'red'">
					  </div>
				
                   
					  </div>
                      <div class="row">
					  <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12 m-r-0" style="margin-left: 0;">
            
                      <label>Select Start Date</label>
					  <?php
					  ?>
                      <input type="date" class="form-control" placeholder="Start Date" name="gw_start_date" id="gw_start_date" min="<?php echo $startdate; ?>" max="<?php echo $enddate; ?>" />
					  </div>

                      <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12 m-r-0">
                      <label>Select End Date</label>
					  <?php
					  ?>
                      <input type="date" class="form-control" placeholder="End Date" name="gw_end_date" id="gw_end_date" min="<?php echo $startdate; ?>" max="<?php echo $enddate; ?>"  />
					  </div>
                   
                   
					  </div>
            <div class="row">
            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12 m-r-0">
                      <label>Notification</label>
                      <textarea class="form-control" placeholder="Enter Notification" name="notification" id="notification"></textarea>
                    </div>
            </div>
            <div class="row">
            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12 m-r-0">
                      <label>Notification</label>
                      <textarea class="form-control" placeholder="Enter Notification" name="arabicnotification" id="arabicnotification"></textarea>
                    </div>
            </div>
            <div class="row">
              <div class="form-group col-md-6">
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
            </div>
					
					 <div class="row">
					  <div class="box-footer col-md-12 m-r-0" style="padding: 10px 0;">
                    	<button type="submit" class="btn btn-primary" name="btnadd">Add Golden Week</button>
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
			$sql="select * from `".TB_pre."golden_week` WHERE `active` = 1 ORDER BY `id` DESC ";
			$r1=mysqli_query($url,$sql) or die("Failed".mysqli_error($url));
			?>
		<div class="box-body">
                  <table id="example2" class="table table-bordered table-hover center-table" style="width: 100%; max-width: 650px; float: left;">
                    <thead>
                      <tr>
                      <th>No.</th>
                      <th>Name</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Multiplier</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php 
					$i = 1;
					while($res = mysqli_fetch_array($r1)){ ?>
                      <tr>
                        <td><?php echo $i++; ?></td>
                        <td><?php echo $res['name']; ?></td>
                        <td><?php echo $res['start_date']; ?></td>
                        <td><?php echo $res['end_date']; ?></td>
                        <td><?php echo $res['prize_multiplication']; ?></td>
                        
<td>
<a href="goldenweek.php?gwid=<?php echo $res['id']; ?>" class="btn btn-primary" title="Edit">View</a>
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
    CKEDITOR.replace('arabicnotification');
    
  });

$('#countryname').on('change', function(){
    var countryid = $(this).val();
    var prize_date = $('#prize_date');
 //   console.log(countryid);

    $.ajax({
        url: "ajax_date_check.php",
        method: "POST",
        data: { cid: countryid },
        success: function(data) {
       //     console.log(data);
			prize_date.replaceWith(data)
            prize_date.attr({
                data
            });
        }
    });
});

$(function () {

  document.getElementById('status-toggle').addEventListener('change', function() {
    var statusLabel = document.getElementById('status-label');
    if (this.checked) {
      statusLabel.textContent = 'Active';
    } else {
      statusLabel.textContent = 'Inactive';
    }
  });
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
    
  </body>
</html>
<?php ob_end_flush(); ?>
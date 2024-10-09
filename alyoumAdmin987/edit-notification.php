<?php $active="campaign"; ?>
<?php
	ob_start();
	include("includes/conn.php"); 
?>
<?php include_once('includes/header.php'); ?>

      <!-- Left side column. contains the sidebar -->
<?php include_once('includes/side_bar.php'); ?>

<?php  
$pr_res=mysqli_fetch_object(mysqli_query($url,"select * from `".TB_pre."notifications` WHERE `id`=".$_GET['nid']));

 // var_dump($pr_res->notification_name); 

 // Users query
$users_query = "SELECT `id`, `first_name`, `last_name`, `email` FROM `".TB_pre."users`";
$users_r = mysqli_query($url, $users_query) or die(mysqli_error($url));

 if(isset($_REQUEST['btnedit'])){
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
		$msg=""; $error="";

      $query = "UPDATE `".TB_pre."notifications` SET `notification_name`='$name',`notification_message`='$notification',`applicable_users`='$userString',`duration`='duration', `start_date`='$start_date',`end_date`='$end_date',`active`='$active' WHERE id=".$_GET['nid'];
    // print_r($query);
      $r = mysqli_query($url, $query) or die(mysqli_error($url));
		  if($r){
			  $msg.= "Notification Successfully Updated";
		  }
		  else {
			  $error.= "Failed: Error occured";
		  }
	  
	} else {
			  $error.= "Failed: Fill all the required fields";
		  }
}
////



?>
  
  <style type="text/css">
  	.grey-img{ opacity:0.4;}
  </style>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Edit Prize
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
              <form role="form" method="post"  action="" enctype="multipart/form-data" id="product_form">
                  <div class="box-body">
                  
                  	
                  <div class="row">
                  <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12 m-r-0" style="margin-left: 0;">
                      <label>Title</label>
					  <?php
					  ?>
                      <input type="text" class="form-control" placeholder="Notification Title" name="nname" id="nname" value="<?php echo $pr_res->notification_name; ?>" />
                    </div>

                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12 m-r-0">
                    <label>Applicable Users</label>
                    <select id="applicable-users" name="users[]" multiple="multiple" class="form-control">
                      <option value="0">All</option>
                      <?php
                      // Fetch each user and display in the dropdown
                      while($users_assoc = mysqli_fetch_object($users_r)) { 
                       // var_dump($pr_res->id); die;
                        ?>
                        <option value="<?php echo $users_assoc->id; ?>" <?php if($pr_res->id==$users_assoc->id){ echo 'selected="selected"';} ?>>
                          <?php echo $users_assoc->first_name . ' ' . $users_assoc->last_name . ' &lt;' . trim($users_assoc->email) . '&gt;'; ?>
                        </option>
                      <?php } ?>
                    </select>
                  </div>


					  <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12 m-r-0" style="margin-left: 0;">
            <label>Select Country</label>
                      <select class="form-control" name="countryname" id="countryname" required >
                      	<option value="">Select</option>
                        <?php 
						$res_cat=mysqli_query($url,"SELECT * FROM `".TB_pre."zone`");
						while($row=mysqli_fetch_object($res_cat)){
						?>
                        <option value="<?php echo $row->zone_id; ?>" <?php if($pr_res->zone==$row->zone_id){ echo 'selected="selected"';} ?>><?php echo $row->country; ?></option>
                        
                       
                      	<?php } ?>
                      </select>
						  
						</div>
            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12 m-r-0">
                      <label>Select Date</label>
                      <?php 
                      $Zres = mysqli_query($url, "SELECT * FROM `" . TB_pre . "zone` WHERE zone_id = '" . $pr_res->zone . "'");
                      $zrow=mysqli_fetch_array($Zres); ?>
                      <input type="date" min="<?php echo $zrow['c_start']; ?>" max="<?php echo $zrow['c_ends']; ?>" value="<?php echo $pr_res->date; ?>" class="form-control" placeholder="Date" name="prize_date" id="prize_date" />
					  </div>
					  </div>
            <div class="row">
					  <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12 m-r-0" style="margin-left: 0;">
                      <label>Select Prize</label>
                      <select class="form-control" name="prize" id="prize" required >
                      	<!-- <option value="">Select Prize</option> -->
                        <?php
$prizes = [
  'airfryer' => 'PHILIPS AIRFRYER',
    // 'blender' => 'PHILIPS HAND BLENDER',
    // 'foodprocessor' => 'PHILIPS FOOD PROCESSOR',
    // 'ricecooker' => 'PHILIPS RICE COOKER'
];

$prizeKey = isset($pr_res->prize) ? $pr_res->prize : ''; // Assuming $pr_res->prize contains the selected prize

foreach ($prizes as $key => $value) {
    echo '<option value="' . $key . '"';
    if ($prizeKey === $key) {
        echo ' selected="selected"';
    }
    echo '>' . $value . '</option>';
}
?>
                      </select>
                    </div>
				
                   
					  </div>
				 
                    <div class="row">
                  </div><!-- /.box-body -->

                  <div class="box-footer">
                    <button type="submit" class="btn btn-primary" name="btnedit" id="submit_button">Update Product</button>
                    <input type="hidden" name="product_id" value="<?php echo $_GET['product_id']; ?>" />
                  </div>
                </form>
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
	});


</script>
    
  </body>
</html>
<?php ob_end_flush(); ?>
<?php $active="brands"; ?>
<?php
	ob_start();
	include("includes/conn.php"); 
?>
<?php include_once('includes/header.php'); ?>

      <!-- Left side column. contains the sidebar -->
<?php include_once('includes/side_bar.php'); ?>

<?php  

 if(isset($_REQUEST['btnedit'])){
	 
	$c_start=$_POST['from'];	
	$c_ends=$_POST['to'];	
	//
	$msg=""; $error="";
	//
	if($c_start!="" || $c_sends!=""){
		
		  //var_dump($num); exit;
		  $query = "UPDATE `".TB_pre."zone` SET `c_start`='$c_start',`c_ends`='$c_ends' WHERE zone_id=".$_GET['zone_id'];
		  $r = mysqli_query($url, $query) or die(mysqli_error($url));
		  if($r){
			  $msg.= "Scheme Successfully updated";
		  }
		  else {
			  $error.= "Failed: Error occured";
		  }
	  
	}
	else {
			  $error.= "Failed: Fill all the required fields";
		  }
}
$s_res=mysqli_fetch_object(mysqli_query($url,"select * from `".TB_pre."zone` WHERE zone_id=".$_GET['zone_id']));


?>
  

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Edit Capmaign Date of <?php echo $s_res->country?>
          </h1>
          
          <!--<ol class="breadcrumb">
            <li><a href="brands.php" class="btn btn-block"><i class="fa fa-eye"></i>View Brands</a></li>
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
              <form role="form" method="post"  class="form-horizontal" action="" enctype="multipart/form-data">
                  <div class="box-body">
                  
                  	<div class="form-group">
                      <label>Start Date</label>
                      <input type="date" min='2024-09-25' max='2024-12-31' class="form-control" placeholder="Start Date" name="from" id="cfrom" value="<?php echo $s_res->c_start;  ?>" />
                    </div>
                    <div class="form-group">
                      <label>End Date</label>
                      <input type="date" min='2024-09-25' max='2024-12-31' class="form-control" placeholder="End Date" name="to" id="cto" value="<?php echo $s_res->c_ends;  ?>" />
                    </div>
                   
                  </div><!-- /.box-body -->

                  <div class="box-footer">
                    <button type="submit" class="btn btn-primary" name="btnedit">Update Contact</button>
                    <input type="hidden" name="zone_id" value="<?php echo $_GET['zone_id']; ?>" />
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
<script src="https://cdn.ckeditor.com/4.5.7/standard/ckeditor.js"></script>
<script>
$(function () {
    // Replace the <textarea id="editor1"> with a CKEditor
    // instance, using default configuration.
    CKEDITOR.replace('scheme_desc');
  });
</script>
    
  </body>
</html>
<?php ob_end_flush(); ?>
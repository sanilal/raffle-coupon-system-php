<?php $active="submissions"; 
ob_start();
include("includes/conn.php"); 
?>

<?php include_once('includes/header.php'); ?>


 <!-- Left side column. contains the sidebar -->
 <?php include_once('includes/side_bar.php'); ?>

<?php  

 
$entry_id = $_GET['e_id'];

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
$sql="select * from `".TB_pre."shop_win` WHERE `entry_id` = '$entry_id'  ORDER BY entry_id DESC ";
$r1=mysqli_query($url,$sql) or die("Failed".mysqli_error($url));

$prizes = [
  'airfryer' => 'Air Fryer'
];
?>  

      <!-- =============================================== -->

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            View Submission
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
                        <td><?php

if ($res['prize'] == 'airfryer') {
  echo $prizes['airfryer'];
} else {
  echo 'Recipe Book';
}
                        
                   
                        
                        ?></td>
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
                      <img src="../alyoumAdmin987/uploads/<?php echo $res["invoice_img"]; ?>" />
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
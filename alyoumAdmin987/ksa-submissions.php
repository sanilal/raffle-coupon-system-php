<?php $active="submissions"; 
ob_start();
include("includes/conn.php"); 
?>

<?php include_once('includes/header.php'); ?>


 <!-- Left side column. contains the sidebar -->
 <?php include_once('includes/side_bar.php'); ?>

<?php  


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
 $sql="select * from `".TB_pre."shop_win` WHERE `zone_country` = 'ksa' GROUP BY `email` ORDER BY entry_id DESC ";
// $sql="select * from `".TB_pre."shop_win` ORDER BY entry_id DESC ";
$r1=mysqli_query($url,$sql) or die("Failed".mysqli_error($url));

?>  

      <!-- =============================================== -->

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            View Submissions
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
                      	<th>Full Name</th>
                        <th>Email</th>
                        <th>City</th>
                        <th>Mobile</th>
                        <!-- <th>National ID / Iqama ID</th> -->
                        <th>Product Image</th>
                        <th>Invoice Image</th>
                        <th>Country</th>
                        <th>Prize</th>
                        <th>View</th>
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
						<td><?php echo $res['full_name']; ?></td>
                        <td><?php echo $res['email']; ?></td>
                        <td><?php echo $res['emirate']; ?></td>
						<td><?php echo $res['mobile']; ?></td>
						<!-- <td><?php // echo $res['eid']; ?></td> -->
            <td><a download="<?php echo $res["product_img"]; ?>" href="/uploads/<?php echo $res["product_img"]; ?>"><img src="uploads/<?php echo $res['product_img']; ?>" width="75px" height="75px" /></a></td>
						<td><a download="<?php echo $res["invoice_img"]; ?>" href="/uploads/<?php echo $res["invoice_img"]; ?>"><img src="uploads/<?php echo $res['invoice_img']; ?>" width="75px" height="75px" /></a></td>
            <td><?php echo $res['zone_country']; ?></td>
                        <td><?php echo $res['prize']; ?></td>
                        <td><a href="view-submission.php?e_id=<?php echo $res['entry_id']; ?>" class="btn btn-primary" title="">View</a>&nbsp;
                        <a href="javascript:removeItem(<?php echo $res['entry_id']; ?>);" class="btn btn-danger">Remove</a></td>
                      

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

     
      <!-- Control Sidebar -->


	<?php include_once('includes/footer.php'); ?>
    <!-- jQuery 2.1.4 -->
   <?php include_once('includes/footer-scripts.php'); ?>
    
    
    <!-- AdminLTE for demo purposes -->
     <script>
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
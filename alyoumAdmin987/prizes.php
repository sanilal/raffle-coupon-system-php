<?php $active="campaign"; ?>
<?php
	ob_start();
	include("includes/conn.php"); 
?>
<?php include_once('includes/header.php'); ?>


 <!-- Left side column. contains the sidebar -->
 <?php include_once('includes/side_bar.php'); ?>

<?php  


if(isset($_GET['remove_bn'])){
	$id = $_GET['remove_bn'];
	$s_img_res=mysqli_fetch_object(mysqli_query($url,"select brand_logo from `".TB_pre."brands` WHERE `brand_id`='$id'"));
	unlink( "uploads/".$s_img_res->brand_logo);
	$query = "DELETE FROM `".TB_pre."brands` WHERE `brand_id`='$id'";
	$r = mysqli_query($url, $query) or die(mysqli_error($url));
	
	if($r){
		$msg = "The selected brand deleted successfully.";
	}
}
$sql="select * from `".TB_pre."prize` ORDER BY `pid` ASC ";
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
            View Prize Details
            <small></small>
          </h1>
          
          <ol class="breadcrumb">
            <li><a href="add-prize.php" class="btn btn-block"><i class="fa fa-plus"></i> Add Prize</a></li>
          </ol>
          
        </section>

        <!-- Main content -->
        <section class="content">

          <!-- Default box -->
          <div class="box">
            <div class="box-header with-border">
              <!--<h3 class="box-title">List - Brands</h3> -->
              <?php if(isset($msg)){ ?>
              	<div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4><i class="icon fa fa-check"></i> <?php echo $msg; ?></h4>
               	</div>
               <?php } ?> 
            </div>
            
            <div class="box-body">
                  <table id="example2" class="table table-bordered table-hover center-table" style="width: 100%; max-width: 650px; float: left;">
                    <thead>
                      <tr>
                      <th>No.</th>
                        <th>Country</th>
                        <th>Date</th>
                        <th>Prize</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php 
					$i = 1;
					while($res = mysqli_fetch_array($r1)){ ?>
                      <tr>
                        <td><?php echo $i++; ?></td>
          
             <td><?php 
                        $zsql = "SELECT * FROM `" . TB_pre . "zone` WHERE `zone_id` = '" . $res['zone'] . "' ";
                        $zr1=mysqli_query($url,$zsql) or die("Failed".mysqli_error($url));

                        $zone = mysqli_fetch_array($zr1);
                        echo $zone['country']; ?></td>
                        <td><?php echo $res['date']; ?></td>
                        <td><?php
                          if ($res['prize'] == 'airfryer') {
                            echo $prizes['airfryer'];
                        } else {
                            echo 'Recipe Book';
                        }
                          
                        
                        ?></td>
		
                        <td>
                        <?php if($res['claimed'] == '1' && $res['confirm'] == '1'): ?>
        <div class="btn btn-success">Prize Confirmed</div>
    <?php elseif($res['claimed'] == '1' && $res['rejected'] == '1'): ?>
        <div class="btn btn-danger">Prize Rejected</div>
    <?php elseif($res['claimed'] == '1' && $res['rejected'] == '0' && $res['confirm'] == '0'): ?>
      <div class="btn btn-warning">Prize Claimed</div>
    <?php else: ?>
        <a href="edit-prize.php?pid=<?php echo $res['pid']; ?>" class="btn btn-primary" title="Edit">Edit</a>
    <?php endif; ?>
</td>

                        
                      </tr>
                      <?php }?>
                    </tbody>
                   
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
		var c= confirm("Do you want to remove this item?");
		if(c){
			location = "brands.php?remove_bn="+id;
		}
	}
	
  
    </script>
    
  </body>
</html>
<?php ob_end_flush(); ?>
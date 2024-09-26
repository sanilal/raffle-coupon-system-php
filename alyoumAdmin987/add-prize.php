<?php $active="campaign"; ?>
<?php
	ob_start();
	include("includes/conn.php"); 
?>
<?php include_once('includes/header.php'); ?>

      <!-- Left side column. contains the sidebar -->
<?php include_once('includes/side_bar.php'); ?>

<?php  

 if(isset($_REQUEST['btnadd'])){
	 
	$zone=$_POST['countryname'];	
	$date	= $_POST['prize_date'];
	$prize=$_POST['prize'];

	if($zone!="" && $date!="" && $prize!=""  ){

		//  var_dump($prize); exit;
		  $query = "INSERT INTO `".TB_pre."prize` (`date`,`prize`,`zone`) VALUES('$date','$prize','$zone')";
		  //echo $query; exit;
		  $r = mysqli_query($url, $query) or die(mysqli_error($url));
		  if($r){
			  $msg.= "Prize Successfully Added";
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
            Add New Prize
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
                      <label>Select Country</label>
                      <select class="form-control" name="countryname" id="countryname" required >
                        <?php 
						$res_cat=mysqli_query($url,"SELECT * FROM `".TB_pre."zone`");
						while($row=mysqli_fetch_object($res_cat)){
						?>
                        <option value="<?php echo $row->zone_id; ?>"><?php echo $row->country; ?></option>
                        
                       
                      	<?php } ?>
                      </select>
                    </div>
						  <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12 m-r-0">
                      <label>Select Date</label>
					  <?php
					  ?>
                      <input type="date" class="form-control" placeholder="Date" name="prize_date" id="prize_date" />
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
    echo '>' . $value . '</option>';
}

?>
                       
                                   
                      </select>
                    </div>
				
                   
					  </div>
					 <div class="row">
					  <div class="box-footer col-md-12 m-r-0" style="padding: 10px 0;">
                    	<button type="submit" class="btn btn-primary" name="btnadd">Add Prize</button>
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
			$sql="select * from `".TB_pre."prize` ORDER BY `pid` DESC ";
			$r1=mysqli_query($url,$sql) or die("Failed".mysqli_error($url));
			?>
		<div class="box-body">
                  <table id="example2" class="table table-bordered table-hover center-table" style="width: 100%; max-width: 650px; float: left;">
                    <thead>
                      <tr>
                      <th>No.</th>
                      <!--	<th>Logo</th>-->
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
                         <!--<td><?php
						// if($res['brand_logo']!=""){ ?>
                      <img src="uploads/<?php // echo $res['brand_logo']; ?>" width="200" />
                      <?php // } else{ echo "No-image";} ?>-->
						 </td>
             <td><?php 
                        $zsql = "SELECT * FROM `" . TB_pre . "zone` WHERE `zone_id` = '" . $res['zone'] . "' ";
                        $zr1=mysqli_query($url,$zsql) or die("Failed".mysqli_error($url));

                        $zone = mysqli_fetch_array($zr1);
                        echo $zone['country']; ?></td>
                        <td><?php echo $res['date']; ?></td>
                        <td>
                        <?php


if ($res['prize'] === 'airfryer') {
    echo $prizes['airfryer'];
} else {
    echo 'Recipe Book';
}
?>

</td>
		
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
<script>

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
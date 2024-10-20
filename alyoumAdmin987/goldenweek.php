<?php $active="campaign"; ?>
<?php
	ob_start();
	include("includes/conn.php"); 
?>
<?php include_once('includes/header.php'); ?>

      <!-- Left side column. contains the sidebar -->
<?php include_once('includes/side_bar.php'); ?>

<?php  
$pr_res=mysqli_fetch_object(mysqli_query($url,"select * from `".TB_pre."golden_week` WHERE `id`=".$_GET['gwid']));



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
            Golden Week
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
                      <input type="text" class="form-control" placeholder="Week Name" name="wname" id="wname" value="<?php echo $pr_res->name; ?>" disabled/>
                    </div>

                    <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12 m-r-0">
                    <label>Multiplier</label>
            <input type="number" class="form-control"  placeholder="0.00" required name="multiplier" disabled value="<?php echo $pr_res->prize_multiplication; ?>">
					  </div>
				
                   
					  </div>
                      <div class="row">
					  <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12 m-r-0" style="margin-left: 0;">
            
                      <label>Select Start Date</label>
					  <?php
					  ?>
                      <input type="date" class="form-control" placeholder="Start Date" name="gw_start_date" id="gw_start_date" value="<?php echo $pr_res->start_date; ?>" disabled />
					  </div>

                      <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12 m-r-0">
                      <label>Select End Date</label>
					  <?php
					  ?>
                      <input type="date" class="form-control" placeholder="End Date" name="gw_end_date" id="gw_end_date" value="<?php echo $pr_res->end_date; ?>"  disabled />
					  </div>
                   
                   
					  </div>
            <div class="row">
            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12 m-r-0">
                      <label>Notification</label>
                      <textarea class="form-control" placeholder="Enter Notification" name="notification" id="notification">
                        <?php echo $pr_res->notification; ?>
                      </textarea>
                    </div>
            </div>
            <div class="row">
              <div class="form-group col-md-6">
                            <!-- Form Group for Active/Inactive Toggle -->
<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12 m-r-0">
  <label for="status">Status</label>
  <label class="switch">
    <input type="checkbox" id="status-toggle" name="status" value="<?php echo $pr_res->active; ?>" <?php if($pr_res->active == 1) {echo 'checked'; }?> disabled>
    <span class="slider"></span>
  </label>
  <span id="status-label" style="margin-left: 10px;"><?php if($pr_res->active == 1) {echo 'Active'; }else { echo 'Inactive'; }?></span>
</div>
              </div>
            </div>
					
					 <div class="row">
					  <div class="box-footer col-md-12 m-r-0" style="padding: 10px 0;">
                    	<!-- <button type="submit" class="btn btn-primary" name="btnadd">Add Prize</button> -->
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
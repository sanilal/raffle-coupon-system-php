<?php $active="winners"; ?>
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
$sql="SELECT * FROM `" . TB_pre . "rejections`";
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
            View Rejected Entries
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
                  <table id="example2" class="table table-bordered table-hover center-table" style="width: 100%; max-width: 90%; float: left;">
                    <thead>
                      <tr>
                      <th>No.</th>
                      <!--	<th>Logo</th>-->
                        <th>Prize</th>
                        <th>Name</th>
                        <th>Mobile</th>
                        <th>Email</th>
                        <th>Store</th>
                        <th>Rejected On</th>
                        <th>Reason</th>
                        <th>View Entry</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php 
					$i = 1;
					while($res = mysqli_fetch_array($r1)){ ?>
                      <tr>
                        <td><?php echo $i++; ?></td>
          
             
                        <td><?php
                        $prizesql="SELECT * FROM `" . TB_pre . "prize` WHERE `pid`= '" . $res['prize_id'] . "'";
                        $prizer1=mysqli_query($url,$prizesql) or die("Failed".mysqli_error($url));

                        $prizeRes = mysqli_fetch_array($prizer1);

                        
                        if ($prizeRes['prize'] == 'airfryer') {
                          echo $prizes['airfryer'];
                      } else {
                          echo 'Recipe Book';
                      }
                        
                        ?></td>
                        <td><?php  
                         $entrysql="SELECT * FROM `" . TB_pre . "shop_win` WHERE `entry_id`= '" . $res['entry_id'] . "'";
                         $entryr1=mysqli_query($url,$entrysql) or die("Failed".mysqli_error($url));
 
                         $entryRes = mysqli_fetch_array($entryr1);
 
                        
                        echo $entryRes['first_name'] ." ". $entryRes['last_name'] ;?></td>
                         <td><?php echo $entryRes['mobile']; ?></td>
                         <td><?php echo $entryRes['email']; ?></td>
                         <td><?php echo $entryRes['store']; ?></td>
                         
                                                
                        <td><?php echo $res['rejection_time']; ?></td>
                        <td>
                            
                        <?php echo $res['reason']; ?>
                    </td>
                    <td><a href="view-submission.php?e_id=<?php echo $entryRes['entry_id']; ?>" class="btn btn-primary" title="">View</a></td>
                       
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/PapaParse/5.3.0/papaparse.min.js"></script>
    <!-- <script src="./dist/jquery-Excel/excel-gen.js"></script>
    <script src="./dist/jquery-Excel/FileSaver.min.js"></script>
    <script src="./dist/jquery-Excel/jszip.min.js"></script>
    <script src="./dist/jquery-Excel/excel-gen.js"></script>
    <script src="./dist/jquery-Excel/xlsx.full.min.js"></script> -->

<script>
    $(function () {

  //     function ExportToExcel(type, fn, dl) {
  //     var elt = document.getElementById('example2');
  //     var wb = XLSX.utils.table_to_book(elt, { sheet: "sheet1" });
  //     return dl ?
  //         XLSX.write(wb, { bookType: type, bookSST: true, type: 'base64' }) :
  //         XLSX.writeFile(wb, fn || ('alyoum.' + (type || 'xlsx')));
  // }

  // $(document).ready(function () {
  //     excel = new ExcelGen({
  //         "src_id": "DataTable",
  //         "show_header": true
  //     });
  //     excel.generate();
  // });

        $('#example2').DataTable({
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'copyHtml5',
                    exportOptions: {
                        columns: [0, ':visible']
                    }
                },
                {
                    extend: 'excelHtml5',
                    title: 'alyoum Winners',
                    exportOptions: {
                        columns: ':visible'
                    },
                    customize: function (xlsx) {
                        var sheet = xlsx.xl.worksheets['sheet1.xml'];
                        $('row c', sheet).attr('s', '2');
                    }
                },
                {
                    extend: 'csvHtml5',
                    extension: '.txt',
                    exportOptions: {
                        columns: ':visible'
                    },
                    action: function (e, dt, button, config) {
                        var data = dt.buttons.exportData(config);
                        var csv = Papa.unparse({
                            fields: data.header,
                            data: data.body
                        });

                        // Add BOM (Byte Order Mark)
                        var blob = new Blob(["\ufeff", csv]);
                        saveAs(blob, config.title + '.csv');
                    }
                },
                {
                    extend: 'pdfHtml5',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4]
                    }
                },
                {
                    extend: 'print',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4]
                    }
                },
                'colvis'
            ]
        });
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
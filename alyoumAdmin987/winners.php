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
$sql="select * from `".TB_pre."prize` WHERE `claimed` = 1 ORDER BY `pid` ASC ";
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
            View Winners
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
                        <th>Winner</th>
                        <th>Mobile</th>
                        <th>Email</th>
                        <th>Store</th>
                        <th>City</th>
                        <th>Invoice Number</th>
                        <th>Invoice Copy</th>
                        <th>Submitted On</th>
                        <th>View</th>
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
                        
                        if ($res['prize'] == 'airfryer') {
                          echo $prizes['airfryer'];
                      } else {
                          echo 'Recipe Book';
                      }
                        
                        ?></td>
                        <td><?php
                        $wsql = "SELECT * FROM `" . TB_pre . "shop_win` WHERE `entry_id` = '" . $res['winner'] . "' ";
                        $wr1=mysqli_query($url,$wsql) or die("Failed".mysqli_error($url));
                        $user = mysqli_fetch_array($wr1);

                        
                        echo $user['first_name'] ." ". $user['last_name'] ;?></td>
                         <td><?php echo $user['mobile']; ?></td>
                         <td><?php echo $user['email']; ?></td>
                         <td><?php echo $user['store']; ?></td>
                         <td><?php echo $user['emirate']; ?></td>
                         <!-- <td><?php // echo $user['invoice_no']; ?></td> -->
                         <td><?php echo strval($user['invoice_no']); ?>.</td>
                         <td><a href="#" > <img width="75px" src="../alyoumAdmin987/uploads/<?php echo $user['invoice_img']; ?>" alt=""></a></td>
                        
                        <td><?php echo $res['date']; ?></td>
                        <td>
                        
                        <a href="view-submission.php?e_id=<?php  echo $user['entry_id']; ?>" style="width:50px;" class="btn btn-primary" title="">View</a>
                    </td>
                    <td>
                    <?php if( $res['confirm'] == '1' AND $res['rejected'] == '0') { echo "<span style='background-color:#0dc736; color:#fff; padding: 7px 10px; margin-top:10px'>Confirmed</span>"; } elseif ($res['confirm'] == '0' AND $res['rejected'] == '1'){
echo "<span style='background-color:#e90606; color:#fff; padding: 7px 10px; margin-top:10px'>Rejected</span>";
                    }else { ?>
                        <button onclick="approveClaim(<?php  echo $user['entry_id']; ?>)"  href="approve-submission.php?e_id=<?php  echo $user['entry_id']; ?>" style="width:70px; margin-bottom:10px" class="btn btn-success" title="">Approve</button>
                        <a href="reject-submission.php?e_id=<?php  echo $user['entry_id']; ?>" style="width:70px; margin-bottom:10px" class="btn btn-warning" title="">Reject</a>
                        <?php } ?>
                        
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/PapaParse/5.3.0/papaparse.min.js"></script>
    <!-- <script src="./dist/jquery-Excel/excel-gen.js"></script>
    <script src="./dist/jquery-Excel/FileSaver.min.js"></script>
    <script src="./dist/jquery-Excel/jszip.min.js"></script>
    <script src="./dist/jquery-Excel/excel-gen.js"></script>
    <script src="./dist/jquery-Excel/xlsx.full.min.js"></script> -->

<script>
function approveClaim(entryId) {
    // Construct the URL with the entryId as a query parameter
    var url = "ajax-approve-claim.php?entryId=" + encodeURIComponent(entryId);

    // Make an AJAX request
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            // Response from the server
            console.log(this.responseText);
        }
    };
    xhttp.open("GET", url, true);
    xhttp.send();
    setTimeout(function(){
      window.location.reload()
     }, 1500)
    
}


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
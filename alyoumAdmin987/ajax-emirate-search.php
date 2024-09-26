<?php  
error_reporting(0); 
ob_start();
session_start();
include("includes/conn.php");
if(!isset($_SESSION['user_id'])){
	header("Location: logout.php");
	echo "<script type='text/javascript'>window.top.location='logout.php';</script>";
	exit;
}
else if($_SESSION['user_id']=="" || $_SESSION['user_id']==NULL){
	header("Location: logout.php");
	echo "<script type='text/javascript'>window.top.location='logout.php';</script>";
	exit;
}

$output = '';
$emirate = $_POST["emirate"];
if(isset($_POST["emirate"]))
{
 //$search = mysqli_real_escape_string($url, $emirate);
 $query = "
  SELECT * FROM `".TB_pre."shop_win` 
  WHERE emirate = '$emirate'
 ";
}
/*else
{
 $query = "
  SELECT * FROM `".TB_pre."products` ORDER BY product_id
 ";
}*/
$result = mysqli_query($url, $query);
if(mysqli_num_rows($result) > 0)
{
/*$product = mysqli_fetch_array($result);
	$brand_id = $product['manufacture'];
$cat_query = "
SELECT * FROM `".TB_pre."brands`
WHERE brand_id = $brand_id
";
$cat_result = mysqli_query($url, $cat_query);*/
 $output .= '
  <table id="example3" class="table table-bordered table-hover">
                    <thead>
                      <tr>
                      <th>Sl. No</th>
                      	<th>Full Name</th>
                        <th>Email</th>
                        <th>Mobile</th>
                        <th>Invoice No.</th>
						<th>Emirate</th>
                        <th>View</th>
                      </tr>
                    </thead>
                    <tbody>
 ';
	$counter = 1;
 while($row = mysqli_fetch_array($result))
 {
	 $i=$i++;
	 $id=$row["entry_id"];
	 $name=$row['full_name'];
	 $email=$row['email'];
	 $mobile=$row['mobile'];
	 $invoice=$row['invoice_no'];
	 $emirate=$row['emirate'];

  $output .= '
   <tr>
   	<td>'.$counter++.'</td>
     <td>'.$name.'</td>
	 <td>'.$email.'</td>
	 <td>'.$mobile.'</td>
	 <td>'. $invoice.'</td>
	 <td>'.$emirate.'</td>
	 <td><a href="view-submission.php?e_id='.$id.'" class="btn btn-primary" title="">View</a>&nbsp;
                        <a href="javascript:removeItem('.$id.');" class="btn btn-danger">Remove</a></td>
   
   </tr>
  ';
 }
	$output .= '
	</tbody>
	<tfoot>
                    </tfoot>
   </table>

   ';
 echo $output;
}
else
{
 echo 'Data Not Found';
}

?>
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
		  $('#example3').DataTable( {
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
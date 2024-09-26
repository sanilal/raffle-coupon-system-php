<!DOCTYPE html>
<html>
  <head>
     
    <script type="application/javascript" src="plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <script type="application/javascript" src="plugins/jQueryUI/jquery-ui.js"></script>
    <!--<script src="blogs.js"></script>-->
    <script>
      $(function(){
        $('h2').click(function(){
          $(this).next().toggle('slow')
        })
      })
    </script>
    <script>
	 $(document).ready(function(){
   // $('.reorder_link').on('click',function(){
	 
        $(".reorder-photos-list").sortable({ tolerance: 'pointer' });
        $('.reorder_link').html('save reordering');
        $('.reorder_link').attr("id","save_reorder");
        $('#reorder-helper').slideDown('slow');
        $('.image_link').attr("href","javascript:void(0);");
        $('.image_link').css("cursor","move");
        $("#save_reorder").click(function( e ){
            if( !$("#save_reorder i").length )
            {
                $(this).html('').prepend('<img src="images/refresh-animated.gif"/>');
                $("ul.reorder-photos-list").sortable('destroy');
                $("#reorder-helper").html( "Reordering Photos - This could take a moment. Please don't navigate away from this page." ).removeClass('light_box').addClass('notice notice_error');
                var h = [];
                $("ul.reorder-photos-list li").each(function() {  h.push($(this).attr('id').substr(9));  });
                $.ajax({
                    type: "POST",
                    url: "order_update.php",
                    data: {ids: " " + h + ""},
                    success: function(html) 
                    {
                        window.location.reload();
                    }
                }); 
                return false;
            }   
            e.preventDefault();     
        });
    //});
});</script>

  </head>
  <body> 
 
<?php include("includes/conn.php");
 
		if(isset($_GET['pitem_id'])){
	$id = $_GET['pitem_id'];
	//$sql="select * from `productitem` WHERE `pitem_id`='$id' ";
	
	$sql="SELECT * FROM `productitem` p  WHERE `pitem_id`='$id'";
	$r1=mysqli_query($url,$sql) or die("Failed".mysqli_error($url));
	 //$cname = mysqli_fetch_array($r1);

$mess= '<div class="gallery" style="width:100%; background:#fff; float:left; ">
    <ul class="reorder_ul reorder-photos-list" style="margin:0; padding:0; list-style-type:none;">' ;   
   $i = 1;
										 $res = mysqli_fetch_array($r1); 
 //$str = $cname['thumbimage'];
 //echo $str;
		//$pieces = explode(",", $str);
      // for($i=0;$i<count($str)-1;$i++){ 
	  if($res['pitemthumb']!=""){
$mess.=' <li id="image_li_'.$i.'" class="ui-sortable-handle" style="padding:7px; border:2px solid #ccc; float:left; margin:10px 7px; background:none; width:auto; height:auto;"><a href="javascript:void(0);" style="float:none;" class="image_link"><img style=" width:150px;" src="products/item/'.$res['pitemthumb'].'" alt=""></a></li>';}
if($res['pdescimg']!=""){
$mess.='<li id="image_li_'.$i.'" class="ui-sortable-handle" style="padding:7px; border:2px solid #ccc; float:left; margin:10px 7px; background:none; width:auto; height:auto;"><a href="javascript:void(0);" style="float:none;" class="image_link"><img style=" width:150px;" src="products/item/'.$res['pdescimg'].'" alt=""></a></li>';
}
if($res['pgraphimg']!=""){
$mess.='<li id="image_li_'.$i.'" class="ui-sortable-handle" style="padding:7px; border:2px solid #ccc; float:left; margin:10px 7px; background:none; width:auto; height:auto;"><a href="javascript:void(0);" style="float:none;" class="image_link"><img style=" width:150px;" src="products/item/'.$res['pgraphimg'].'" alt=""></a></li>';
}
if($res['pcodeimg']){
$mess.='<li id="image_li_'.$i.'" class="ui-sortable-handle" style="padding:7px; border:2px solid #ccc; float:left; margin:10px 7px; background:none; width:auto; height:auto;"><a href="javascript:void(0);" style="float:none;" class="image_link"><img style=" width:150px;" src="products/item/'.$res['pcodeimg'].'" alt=""></a></li>';
}
	} //}
$mess.=' </ul></div>'; 
 
 

echo $mess;?>

 </body>
</html>
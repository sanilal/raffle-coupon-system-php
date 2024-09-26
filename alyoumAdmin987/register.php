<?php
   error_reporting(0);
   ob_start();
   session_start();
   require_once("includes/conn.php");
   ?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <title>Elay </title>
      <!-- Tell the browser to be responsive to screen width -->
      <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
      <!-- Bootstrap 3.3.5 -->
      <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
      <!-- Font Awesome -->
      <link rel="stylesheet" href="dist/css/font-awesome.min.css">
      <!-- Ionicons -->
      <link rel="stylesheet" href="dist/css/ionicons.min.css">
      <!-- Theme style -->
      <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
      <!-- iCheck -->
      <link rel="stylesheet" href="plugins/iCheck/square/blue.css">
      <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
      <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
      <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
      <![endif]-->
   </head>
   <body class="hold-transition register-page">
      <!--styleswitcher-->
      <!--==============================end header==============================-->
      <!--==============================content=================================-->
      <?php
         if(isset($_POST['name'])){
         	$name=mysqli_real_escape_string($url,$_POST['name']);
			$lname=mysqli_real_escape_string($url,$_POST[$lname]);
         	$email=mysqli_real_escape_string($url,$_POST['email']);
         	$password=mysqli_real_escape_string($url,$_POST['password']);
         	$phone=mysqli_real_escape_string($url,$_POST['phone']);
         	$address=mysqli_real_escape_string($url,$_POST['address']);
			$last_login=date("Y-m-d H:i:s");
         	if($name!="" && $email!="" && $password!=""){
         		if($password==$_POST['c_password']){
         			$msg=""; $error="";
         			$password=md5($password);
         			$num=mysqli_num_rows(mysqli_query($url,"SELECT `first_name` FROM `".TB_pre."admin` WHERE `email`='$email' "));
         			if($num < 1){
         				$result=mysqli_query($url,"INSERT INTO `".TB_pre."admin` (email, first_name, last_name, contact_number, address, password, last_login) VALUES ( '$email', '$name', '$lname', '$phone', '$address', '$password', '$$last_login') ");
         			if($result){
         			  $msg.= "User Successfully Added";
         			  }
         			  else {
         				  $error.= "Failed: Error occured";
         			  }
         			}
         			else{
         				$error.= "Error: The email id you entered is already exist";
         			}
         		}
         	}
         }
         
         ?>
         <div id="become-a-member">
            <div class="row-title">
               <h2>Hello! </h2>
            </div>
            <div class="content-div">
               <article class="span9 m_top_20" style="margin-bottom:40px;">
                  <form id="registerform" class="post_form v_form form-horizontal m_b_no_space" method="post" action="" onSubmit="return validate(this);">
                     <h3>Welcome to Elay Center<br>
                        Tell us more about you...
                     </h3>
                     <div class="box-header">
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
                     <ul>
						  <li>
							 <div class="full_width">
								<input type="text" id="cf_name" name="name" minlength="1" placeholder="First Name " class="full_width" required>
							 </div>
						  </li>
						 <li>
							 <div class="full_width">
								<input type="text" id="cf_lname" name="lname" placeholder="Last Name " class="full_width" required>
							 </div>
						  </li>
						  <li>
							 <div class="full_width">
								<input type="email" id="cf_email" name="email" placeholder="Email" class="full_width" required>
							 </div>
						  </li>
						 <li>
							 <div class="full_width">
								<input type="text" id="cf_phone" name="phone" placeholder="Contact Number" class="full_width">
							 </div>
						  </li>
						 <li class="clearfix">
					   		<textarea id="address" name="address" placeholder="Address"></textarea>
						</li>
						  <li>
							 <div class="full_width">
								<input type="password" id="cf_pass" name="password" placeholder="Password" class="full_width" required>
							 </div>
						  </li>
						  <li>
							 <div class="full_width">
								<input type="password" id="cf_c_pass" name="c_password" placeholder="Confirm Password" class="full_width" required>
							 </div>
						  </li>
                  </ul>
					  <div class="clearfix become-button">
					   <button class="btn-small">Become a Member</button>
					</div>
                  </form>
               </article>
            </div>
         </div>

      <script type="text/javascript">
         function validate(obj){
         var filter = /^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/;
         if($("#cf_name").val()!="" && $("#cf_email").val()!="" && $("#cf_pass").val()!="" && $("#cf_c_pass").val()!=""  ){
         if(filter.test($("#cf_email").val())){
         if($("#cf_pass").val()==$("#cf_c_pass").val()){
          return true;
         }
         else{
         	alert("Both passwords must be same")
         }
         }
         else{
         alert("Please enter valid email");
         }
         
         }
         else{
         alert("Please fill required fieilds");
         }
         return false;
         }
      </script>
   </body>
</html>
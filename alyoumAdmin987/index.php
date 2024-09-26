<?php
error_reporting(0);
ob_start();
session_start();
require_once("includes/conn.php");
$msg = "";
//var_dump(tb_pre); exit;
if($_POST){
	$email = mysqli_real_escape_string($url, $_POST['email']);
	$pass = mysqli_real_escape_string($url, $_POST['password']);
	$pass=md5($pass);
	if($email && $pass){
		$query = "SELECT * FROM `".TB_pre."admin` WHERE `email`='$email' AND `password`='$pass'";

		$r = mysqli_query($url, $query) or die(mysqli_error($url));
		if(mysqli_num_rows($r) == 1){
			$_SESSION["logged"] = "true";
			$res=mysqli_fetch_object($r);
			$_SESSION['user_id']=$res->id;
			$_SESSION['last_login']=$res->last_login;
			mysqli_query($url, "UPDATE `".TB_pre."admin` SET last_login='".date("Y-m-d H:i:s")."' WHERE id=".$_SESSION['user_id']);
			header("location:home.php");
		}
		else{
			$msg = "Invalid Email or Password";
		}
	}
	else{
		$msg = "Please enter email and password";
	}
}
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>alyoum | Admin panel </title>
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
  <body class="hold-transition login-page">
    <div class="login-box">
      <div class="login-logo">
        <a href="#"><img src="dist/img/logo.webp" width="153"  alt=""/></a>
      </div><!-- /.login-logo -->
      <div class="login-box-body">
        <p class="login-box-msg">Sign in</p>
          <?php if($msg){ ?>
                 	<p class="alert alert-danger"><?php echo $msg; ?></p>
                 <?php } ?>
        <form action="index.php" method="post">
          <div class="form-group has-feedback">
            <input type="text" name="email" class="form-control" placeholder="Email">
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input type="password" name="password" class="form-control" placeholder="Password">
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
          <div class="row">
            <div class="col-xs-8">
              <div class="checkbox icheck">
                <label>
                  <input type="checkbox"> Remember Me
                </label>
              </div>
            </div><!-- /.col -->
            <div class="col-xs-4">
              <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
            </div><!-- /.col -->
          </div>
        </form>

        
        <?php /*?><a href="#">I forgot my password</a><br><?php */?>

      </div><!-- /.login-box-body -->
    </div><!-- /.login-box -->

    <!-- jQuery 2.1.4 -->
    <script src="plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <!-- iCheck -->
    <script src="plugins/iCheck/icheck.min.js"></script>
    <script>
      $(function () {
        $('input').iCheck({
          checkboxClass: 'icheckbox_square-blue',
          radioClass: 'iradio_square-blue',
          increaseArea: '20%' // optional
        });
      });
    </script>
  </body>
</html>
<?php ob_end_flush(); ?>
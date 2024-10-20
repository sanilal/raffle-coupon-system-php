   <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
          
           <div class="user-panel">
            <div class="pull-left image">
              <img src="dist/img/profile-dummy.jpg" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
              <p><a href="profile.php" >Administartor</p>
              <!-- Status -->
              <a href="#"><i class="fa fa-circle text-green"></i> Online</a>
              
            </div>
            
          </div>
          
          <?php 
          $sid = $_SESSION['user_id']; 
//           $csql="select `zone_access` from `".TB_pre."admin`WHERE `id`='$sid' ";
// $cr1=mysqli_query($url,$csql) or die("Failed".mysqli_error($url));
//$crow=mysqli_fetch_object($cr1);
//$zone =  $crow->zone_access;
          ?>
          <ul class="sidebar-menu">
          	
            <li class="header"> <a href="logout.php" ><i class="fa fa-power-off"></i> &nbsp;Sign out</a></li>
              <li class="treeview <?php if($active=="submissions"){ echo "active";} ?>">
              <a href="transactions.php">
                <i class="fa fa-book"></i>
                <span>Transactions</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
            
              	<li class="<?php if($active=="submissions"){ echo "active";} ?>"><a href="transactions.php"><i class="fa fa-user" style="font-size: 10px;"></i> Transactions</a></li>     
              	 
              </ul>
            </li>
            <li class="treeview <?php if($active=="users"){ echo "active";} ?>">
              <a href="users.php">
                <i class="fa fa-users"></i>
                <span>Users</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
            
              	<li class="<?php if($active=="users"){ echo "active";} ?>"><a href="users.php"><i class="fa fa-user"></i> Registered Users</a></li>     
              	 
              </ul>
            </li>
            <li class="treeview <?php if($active=="notification"){ echo "active";} ?>">
              <a href="#">
                <i class="fa fa-bullhorn"></i>
                <span>Manage Notifications</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                  <li>
                      <a href="notifications.php">
                        <i class="fa fa-bell"></i>
                        <span>View All Notifications</span>
                      </a>
                   </li>
                   
                   <li>
                      <a href="add-notification.php">
                        <i class="fa fa-bell-o"></i>
                        <span>Add Notification</span>
                      </a>
                   </li>
                  
                 </ul>
           
             </li>
         <li class="treeview <?php if($active=="campaign"){ echo "active";} ?>">
              <a href="#">
                <i class="fa fa-calendar"></i>
                <span>Golden Weeks</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
              <li>
                        <a href="goldenweeks.php">
                            <i class="fa fa-braille"></i>
                            <span>View Golden Weeks</span>
                        </a>
                  </li>
                  <li>
                        <a href="add-golden-week.php">
                            <i class="fa fa-gift"></i>
                            <span>Add Golden Week</span>
                        </a>
                  </li>
                 
                 
                 </ul>
           
             </li>
     
       		
          </ul>
        </section>
        <!-- /.sidebar -->
   </aside>
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
              <a href="submissions.php">
                <i class="fa fa-shopping-bag"></i>
                <span>Shop & Win</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
            
              	<li><a href="submissions.php"><i class="fa fa-folder-open"></i> All Submissions</a></li>     
              	<li><a href="union-submissions.php"><i class="fa fa-folder-open"></i> Union Coop Submissions</a></li>     
              	<li><a href="emirates-submissions.php"><i class="fa fa-folder-open"></i> Emirates Co-Op Submissions</a></li>     
              	<li><a href="noon-submissions.php"><i class="fa fa-folder-open"></i> Noon Submissions</a></li>     
              	<li><a href="careem-submissions.php"><i class="fa fa-folder-open"></i> Careem Submissions</a></li>     
              </ul>
            </li>
            <li class="treeview <?php if($active=="winners"){ echo "active";} ?>">
              <a href="#">
                <i class="fa fa-newspaper-o"></i>
                <span>Winners</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                  <li>
                      <a href="winners.php">
                        <i class="fa fa-trophy"></i>
                        <span>Winners</span>
                      </a>
                   </li>
                   
                   <li>
                      <a href="confirmed-winners.php">
                        <i class="fa fa-trophy"></i>
                        <span>Confirmed Winners</span>
                      </a>
                   </li>
                   <li>
                      <a href="rejections.php">
                        <i class="fa fa-thumbs-o-down"></i>
                        <span>Rejected Entries</span>
                      </a>
                   </li>
                 </ul>
           
             </li>
         <li class="treeview <?php if($active=="campaign"){ echo "active";} ?>">
              <a href="#">
                <i class="fa fa-newspaper-o"></i>
                <span>Campaign Settings</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
              <li>
                        <a href="dates.php">
                            <i class="fa fa-braille"></i>
                            <span>View Active Dates</span>
                        </a>
                  </li>
                  <li>
                        <a href="prizes.php?section_id=1">
                            <i class="fa fa-gift"></i>
                            <span>Prizes</span>
                        </a>
                  </li>
                  <li>
                        <a href="add-prize.php">
                            <i class="fa fa-gift"></i>
                            <span> + Add Prize</span>
                        </a>
                  </li>
                 
                 </ul>
           
             </li>
     
       		
          </ul>
        </section>
        <!-- /.sidebar -->
   </aside>
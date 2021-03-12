<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

    session_start();
    session_destroy();
    session_start();
    $page_title = "Sign-in";
    // Core
    require_once("core/config.php");
    // Header
    require_once("includes/header.php");
    // Navigation
    //require_once("config/init.php");
    require_once("nav/nav_login.php");

    if (isset($_POST['formLogin'])){
       $loginUsername = $_POST['loginUsername'];
       $loginPassword = $_POST['loginPassword'];

       if ($loginUsername=='admin' && $loginPassword=='directorate')
       {
            $_SESSION['ulogin_state'] = 200;
            if (headers_sent()){
                die("<br/><br/><div class='mt-5 text-center'><big><strong>You are signed-in.</strong><br/> If not re-directed. Please click on this link: <a href='cadmin/admin_dashboard.php'>SIWES Online Office.</a></big></div>");
            }else{
                header("location: cadmin/admin_dashboard.php");
            }

       }else{
         $err_flag = 1;
         $err_msg = "Invalid User Login";
       }
    }

 ?>

 <div class="container-fluid">
     <div class="row d-flex justify-content-center" style="margin-top:20px;">

       <!-- top pane //-->
       <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-content-center">
           <h3>SIWES Office</h3>
       </div>
       <!-- end of top pane //-->

       <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
             <!-- Material form login -->
             <div class="card">
                 <!--<h5 class="card-header primary-color white-text text-center py-4" style="opacity:0.6;> //-->
                 <h5 class="card-header white-text text-center py-4" style="opacity:0.6; background-color: #3f8c3e;">
                   <strong>Sign in</strong>
                 </h5>

                 <!--Card content-->
                 <div class="card-body px-lg-5 pt-0">

                     <!-- Form -->
                     <form class="text-center" style="color: #757575;" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

                           <!-- Submit Feedback  -->
                           <div class="md-form">
                               <?php
                                   if (isset($_POST['formLogin'])){
                                         if ($err_flag==1){
                                               miniErrorAlert($err_msg);
                                         }
                                   }
                               ?>
                           </div>

                           <!-- Email -->
                           <div class="md-form">
                             <input type="text" id="loginUsername" name="loginUsername" class="form-control">
                             <label for="username">Username</label>
                           </div>

                           <!-- Password -->
                           <div class="md-form">
                             <input type="password" id="loginPassword" name="loginPassword" class="form-control">
                             <label for="loginPassword">Password</label>
                           </div>

                           <div class="d-flex justify-content-around">
                             <div>
                               <!-- Remember me -->
                               <div class="form-check">
                                 <input type="checkbox" class="form-check-input" id="loginFormRemember">
                                 <label class="form-check-label" for="loginFormRemember">Remember me</label>
                               </div>
                             </div>
                             <div>
                               <!-- Forgot password -->
                               <a href="">Forgot password?</a>
                             </div>
                           </div>

                           <!-- Sign in button -->
                           <button name="formLogin" class="btn btn-outline-success btn-rounded btn-block my-4 waves-effect z-depth-0" type="submit">Sign in</button>


                       </form>
                       <!-- Form -->

                 </div><!-- Card content //-->


             </div><!-- Material form login -->

       </div><!-- end of columm //-->



     </div><!-- end of row //-->
 </div><!-- end of container //-->

 <br/><br/>
 <?php
       //footer
       require_once("includes/footer.php");
  ?>

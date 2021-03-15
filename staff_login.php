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



    $err_flag = '';
    $err_flag = 0;

    if (isset($_POST['formLogin'])){
       $loginUsername = $_POST['loginUsername'];
       $loginPassword = $_POST['loginPassword'];

       if (!empty($loginUsername) && !empty($loginPassword)){
          $staff = new StaffUser();

          // password encrypt
          //$password_encrypt = sha1(md5(sha1($loginPassword)));
          $loginPassword = sha1(md5(sha1($loginPassword)));

          $result = $staff->get_staff_by_username_password($loginUsername, $loginPassword);

          if ($result->rowCount()){
                $staff_info = $result->fetch(PDO::FETCH_ASSOC);

                $_SESSION['app_login'] = 'staff';
                $_SESSION['ulogin_state'] = $staff_info['id'];
                $_SESSION['ulogin_userid'] = $staff_info['id'];
                $_SESSION['username'] = $staff_info['file_no'];
                $_SESSION['file_no'] = $staff_info['file_no'];
                $_SESSION['names'] = $staff_info['names'];
                $_SESSION['email'] = $staff_info['email'];
                $_SESSION['phone'] = $staff_info['phone'];
                $_SESSION['unit_id'] = $staff_info['unit_id'];
                $_SESSIOn['verification_code'] = $staff_info['verification_code'];

                //$_SESSION['staffData'] = $dataArray;

                 if (headers_sent()){
                     die("<br/><br/><div class='mt-5 text-center'><big><strong>You are Sign-in</strong><br/>If not re-directed. Please click on this link: <a href='staff/clearing_division.php'>Online Clearance Office</a></big></div>");
                 }else{
                     header("location:staff/clearing_division.php");
                 }

          }else{
              $err_flag = 1;
              $err_msg = 'Invalid Sign-in Credentials';
          }

       }else{
          $err_flag = 1;
          $err_msg = '[Invalid Entry] Username and Password are required to sign-in';
       }



    }

 ?>

 <div class="container-fluid">
     <div class="row d-flex justify-content-center" style="margin-top:20px;">

       <!-- top pane //-->
       <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-content-center">
           <h3>Clearance Unit Online Office</h3>
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
                             <input type="text" id="loginUsername" name="loginUsername" class="form-control" required>
                             <label for="username">Username</label>
                           </div>

                           <!-- Password -->
                           <div class="md-form">
                             <input type="password" id="loginPassword" name="loginPassword" class="form-control" required>
                             <label for="loginPassword">Password</label>
                           </div>
                           <!--
                           <div class="d-flex justify-content-around">
                             <div>
                               <!-- Remember me -->
                               <!--
                               <div class="form-check">
                                 <input type="checkbox" class="form-check-input" id="loginFormRemember">
                                 <label class="form-check-label" for="loginFormRemember">Remember me</label>
                               </div>
                             </div>
                             <div>
                               <!-- Forgot password -->
                               <!--
                               <a href="">Forgot password?</a>
                             </div>
                           </div>
                           //-->

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

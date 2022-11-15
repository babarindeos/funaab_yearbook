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

      $active_session = AcademicSession::active_session();



      $err_flag = 0;
      $err_msg = '';
      if (isset($_POST['formLogin'])){


          $username = FieldSanitizer::inClean($_POST['loginUsername']);
          $password = FieldSanitizer::inClean($_POST['loginPassword']);

          if (($username != "") || ($password != "")){

              $auth = new Auth();
              $stmt = $auth->deanLogin($username, $password, $active_session);
              $recordFound = $stmt->rowCount();
              //echo $recordFound;

              if ($recordFound){
                  // Record found ..check for verification_code
                      $row = $stmt->fetch(PDO::FETCH_ASSOC);
                      $_SESSION['ulogin_state'] = 200;
                      $_SESSION['auth_id'] = $row['id'];
                      $_SESSION['app_login'] = 'dean';
                      //$_SESSION['auth_applicant_id'] = $row['applicant_id'];
                      $_SESSION['auth_username'] = $row['file_no'];
                      $_SESSION['auth_password'] = $row['access_code'];
                      $_SESSION['auth_college'] = $row['college_id'];
                      $_SESSION['auth_fullname'] = $row['fullname'];
                      $_SESSION['auth_email'] = $row['email'];
                      $_SESSION['auth_phone'] = $row['phone'];
                      $_SESSION['auth_verification_code'] = $row['verification_code'];


                      // check the user type
                      if ($_SESSION['ulogin_state']==200){
                           $_SESSION['myLogin'] = 'deans1989';
                            if (headers_sent()){
                                die("<br/><br/><div class='mt-5 text-center'><big><strong>You are signed-in.</strong><br/> If not redirected. Please click on this link: <a href='dean/profile_form.php'>Dean YearBook Profile form & Message.</a></big></div>");
                            }else{
                                 header("location:dean/profile_form.php");
                            }
                      }else{
                          session_destroy();
                      }
                      // end of user type check



              }else{
                    $err_flag = 1;
                    $err_msg = "Invalid sign-in credentials";
              }

          }else{
              $err_msg = "Username and Password are required.";
              $err_flag = 1;
          }

      }



 ?>

 <div class="container-fluid">
     <div class="row d-flex justify-content-center" style="margin-top:20px;">

       <!-- left pane //-->
       <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
           <h4 class=''>FUNAAB YearBook Online Access for Deans<br><small>2019/2020 Academic Session</small></h4>
           <hr class='mb-4'/>

       </div>
       <!-- end of left pane //-->

       <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
             <!-- Material form login -->
             <div class="card">
                 <!--<h5 class="card-header primary-color white-text text-center py-4" style="opacity:0.6;> //-->
                 <h5 class="card-header white-text text-center py-4" style="opacity:0.6; background-color: #3f8c3e;">
                   <strong>Sign In</strong>
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

                           <!-- Sign in button -->
                           <button name="formLogin" class="btn btn-outline-success btn-rounded btn-block my-4 waves-effect z-depth-0" type="submit">Sign In</button>


                       </form>
                       <!-- Form -->



                 </div><!-- Card content //-->


             </div><!-- Material form login -->
             <br/>
             <a  href='index.php' class="mt-4"><h5><u> <i class="fas fa-home"></i> Home</u></h5></a>

       </div><!-- end of columm //-->



     </div><!-- end of row //-->
 </div><!-- end of container //-->

 <br/><br/>
 <?php
       //footer
       require_once("includes/footer.php");
  ?>

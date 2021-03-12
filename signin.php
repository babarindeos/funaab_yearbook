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




      $err_flag = 0;
      $err_msg = '';
      if (isset($_POST['formLogin'])){


          $username = FieldSanitizer::inClean($_POST['loginUsername']);
          $password = FieldSanitizer::inClean($_POST['loginPassword']);

          if (($username != "") || ($password != "")){

              $auth = new Auth();
              $stmt = $auth->login($username, $password);
              $recordFound = $stmt->rowCount();

              if ($recordFound){
                  // Record found ..check for verification_code

                  $row = $stmt->fetch(PDO::FETCH_ASSOC);
                  $verification_status = $row['verified'];

                  $err_flag = $verification_status ? "" : 1;
                  if ($verification_status=='' && $verification_status!=1){
                    $err_msg = 'Your account is yet to be verified. Check the email sent to you and follow the link to verify your account.';
                  }else{

                      $_SESSION['ulogin_state'] = 200;
                      $_SESSION['auth_id'] = $row['id'];
                      //$_SESSION['auth_applicant_id'] = $row['applicant_id'];
                      $_SESSION['auth_username'] = $row['username'];
                      $_SESSION['auth_password'] = $row['password'];
                      $_SESSION['auth_verification_code'] = $row['verification_code'];
                      $_SESSION['auth_verified'] = $row['verified'];
                      $_SESSION['auth_user_type'] = $row['user_type'];
                      $_SESSION['auth_user_role'] = $row['role'];

                      // check the user type
                      if ($row['user_type']==1){
                           $_SESSION['myLogin'] = 'student1989';
                            if (headers_sent()){
                                die("<br/><br/><div class='mt-5 text-center'><big><strong>You are signed-in.</strong><br/> If not redirected. Please click on this link: <a href='student/registration_form.php'>SIWES Registration Form.</a></big></div>");
                            }else{
                                 header("location:student/registration_form.php");
                            }
                      }else{
                          session_destroy();
                      }
                      // end of user type check
                  }


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
     <div class="row" style="margin-top:20px;">

       <!-- left pane //-->
       <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
           <h4 class=''>SIWES Registration<br><small>2019/2020 Academic Session</small></h4>
           <hr class='mb-4'/>
           <h4>Get Started Here: Obtain your sign-in credentials</h4>

           <ul class='mt-3 mb-4' style='list-style-type: disc;'>

               <li class='mb-1'> Click on the <strong>'Get Started'</strong> link below to navigate to the Login page.</li>
               <li class='mb-1'> Login in with your Matriculation Number to get to the pre-payment page.</li>
               <li class='mb-1'> On the pre-payment page, verify your profile information as correct. Click on the <strong>'Make Payment'</strong> button to pay for your 'SIWES dues and Logbook Charges'</li>
               <li class='mb-1'> After payment, an email containing your username and password is sent to the email account you have on your student profile as displayed in the
                    pre-payment page.</li>
               <li class='mb-1'> Use the username and password sent to your email to sign-in to complete your registration.</li>
               <li class='mb-1'> After completing your registration, a day will be scheduled for collection of your logbook and other documents.</li>




           </ul>
           <a  href='get_started.php' class="color:#006600;"><h5><u>Get Started</u></h5></a>
       </div>
       <!-- end of left pane //-->

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

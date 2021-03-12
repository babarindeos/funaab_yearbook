<?php

  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);
  session_start();

  if (!(isset($_GET['q']) && $_GET['q'] != '')) {
      header("Location: signin.php");
      exit();
  }

  $username = '';

  if (!(isset($_GET['regno']) && $_GET['regno'] != '')) {
      // if regno is not set...check if myregno is set

      if (!(isset($_GET['myregno']) && $_GET['myregno'] != '')) {
          header("Location: signin.php");
          exit();
      }else{
         $username = $_GET['myregno'];
      }

  }else{
        $username = $_GET['regno'];
  }

  $page_title = "Account Activation";
  // Core
  require_once("core/config.php");
  // Header
  require_once("includes/header.php");
  // Navigation
  require_once("nav/nav_login.php");

  require_once("includes/funaabWS.php");
  require_once("includes/ws_functions.php");
  require_once("includes/ws_parameters.php");

  //-------------- flag and message variables declared and initialized -------------------------------
      $err_flag = 0;
      $err_msg = null;
      $message = "";
      $info = '';



  $verification_code =  FieldSanitizer::inClean($_GET['q']);



  // verify if verification for that user auth_exists
  $auth = new Auth();
  $verify_auth = $auth->verification($username, $verification_code);

  if ($verify_auth->rowCount()){
      // record is found

      //check if record has been activated already
      $is_activated = $auth->is_verified($username, $verification_code);

      if ($is_activated->rowCount())
      {
              // account has been actiavted already... display Message
              $message = "<h3>Your account has been activated</h3>You can proceed to sign-in and complete the registration form.";


      }else{
             // not yet activated...proceed to activate it
             // activate user account
             $activate = $auth->activate_auth_account($username, $verification_code);

             if ($activate->rowCount()){
               $message = "<h3>Your account has been activated</h3>You can proceed to sign-in and complete the registration form.";
             }else{
               $err_msg = 1;
               $message = "<h3>An error occurred!</h3>Your account could not be activated. Please contact the SIWES office.";
             }
      }



  }else{
    if (headers_sent()){
        die("<br/><br/><div class='mt-5 text-center'><big><strong>Invalid Verification Code.</strong><br/> If not re-directed. Please click on this link: <a href='signin.php'>SIWES Sign-in.</a></big></div>");
    }else{
      header("Location: signin.php");
      exit();
  }


}








 ?>

<div class="container-fluid">


    <div class="row d-flex justify-content-center" style="margin-top:20px;">





      <!-- left pane //-->
      <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 mt-5">
          <h4 class='mb-4'>SIWES Registration<br><small>2019/2020 Academic Session</small></h4>

          <hr>
          <h3>Account Activation</h3><br/>

            <!-- Notification Bar //-->
            <?php
                //---------------------------- Info Notification Section ---------------------------------------
                if ($err_flag==1){
                ?>
                  <div class="alert alert-danger mt-1" role="alert">
                       <i class="fas fa-info-circle"></i>  <?php echo $message; ?>
                  </div>

                <?php
                }
                // ---------------------------- End of Info Notification Section -------------------------------

                //---------------------------- Error Message Notification Section ---------------------------------------
                if ($err_flag==0){
                ?>
                  <div class="alert alert-success mt-1" role="alert">
                       <i class="fas fa-exclamation-circle"></i>  <?php echo $message; ?>
                  </div>

                  <!-- instructions //-->
                  <ul class='mt-4 mb-4'>
                      <li>Sign-in with your username and password</li>
                      <li>Complete and save the registration form.</li>

                  </ul>

                  <a href='signin.php'>Sign-in page</a>

                  <!-- end of instruction //-->

                <?php
                }
                // ---------------------------- End of Error Message Notification Section
            ?>
            <!-- end of Notification Bar //-->






      </div><!-- end of columm //-->
      <!-- end of right column //-->



    </div><!-- end of row //-->



</div><!-- end of container //-->

<br/><br/>
<?php
      //footer
      require_once("includes/footer.php");
 ?>

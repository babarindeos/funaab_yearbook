<?php

  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);
  session_start();

  if (!(isset($_SESSION['app_login']) && $_SESSION['app_login'] != '')) {

  header ("Location: signin.php");

  }

      $studentData = $_SESSION['studentData'];








      $page_title = "Payment Confirmation";
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


  // ------------ get currently active session -------------------------------------------------------

      $academic_session = new AcademicSession();
      $get_active_session = $academic_session->get_active_session();

      $current_academic_session = $get_active_session->fetch(PDO::FETCH_ASSOC);
      $current_academic_session = $current_academic_session['session'];

      //------------------ Check if login credential has been created and sent to user -------- ------






//------------------- Student new and functional email from the SIWES DB ----------------------


            $applicant = new Applicant();
            $applicant_email = $applicant->get_applicant_email($studentData['Matric']);
            $get_email = $applicant_email->fetch(PDO::FETCH_ASSOC);
            $student_email = $get_email['email'];

            // Modified - March 3rd , 2021  --- additional email info
            $student_emailFunaab = $get_email['emailFunaab'];

            $_SESSION['email'] = $student_email;
            $studentData['email'] = $student_email;


            // ----- Modification 3rd March 2021
            // ----- To send email to both student email addresses instead of first emails
            $recipientEmails = array($student_email,$student_emailFunaab);





//------------------- End of student new and functional email from the SIWES DB ---------------


  $auth = new Auth();
  $is_auth = $auth->is_auth_created($_SESSION['regNumber']);

  if (!$is_auth->rowCount()){
      $verification_code = $auth->generate_verification_code();
      $password = $auth->generate_password();
      $password_encrypt = sha1(md5(sha1($password)));
      $user_type = '1';
      $role = '';
      $authData = array("username"=>$_SESSION['regNumber'], "password"=>$password_encrypt,"user_type"=>$user_type,"role"=>$role,
                      "verification_code"=>$verification_code);


      // create auth record for the user
      $result = $auth->create_auth($authData);

      //----------- Send mail ----------------------------
      if ($result->rowCount()){
        // send mail
        $sender = "SIWES";
        $subject = "FUNAAB SIWES Registration";
        $sender_email = 'FUNAAB SIWES siwes@siwes.unaab.edu.ng';

        //echo $_SESSION['email'];
        //$recipient = $_SESSION['studentData']['email'];

        // Running $recipientEmails Loop to send message to student $recipientEmails
        //************************* Send email ******************************************************
            $sent_response = '';
            foreach($recipientEmails as $student_email_address){
                  //$recipient = "kondishiva007@gmail.com";
                  $recipient = $student_email_address;
                  $send_message = 'Dear '.$_SESSION['studentData']['surname'].' '.$_SESSION['studentData']['firstname'].',<br/><br/>';
                  $send_message .= 'Please find below your login credentials to access the SIWES portal to complete your registration.<br/>To use the login credentials you have to activate your account by clicking the link below.<br/><br/>';
                  $send_message .= 'Username: '.$_SESSION['regNumber'].'<br/>';
                  $send_message .= 'Password: '.$password.'<br/><br/>';

                  $send_message .= "http://siwes.unaab.edu.ng/activate_my_account.php?q={$verification_code}&myregno=".$_SESSION['regNumber'];


                  $mail = new Mail();
                  //$sent_response = $mail->sendMail($sender, $sender_email, $recipient, $subject, $send_message);
            }

            if ($sent_response=='sent'){
              $message = "An email has been sent to your personal and FUNAAB email accounts containing your Sign-in credentials. If you do not find the mail in you inbox, check the spam/bulk portion of your email account.";

            }else{
              $err_flag = 1;
              $message = "An error occurred sending your Sign-in credentials. Please try again.";
            }

            //************************** End of send email ************************************************

    }else{
      $err_flag = 1;
      $message = "An error occurred creating your Sign-in credentials. Please contact the SIWES Office.";
    }
    // -----end of send mail //----------------


  }else{
      $message = 'Your Sign-in credentials has been generated and sent to your mail. If you can not find the mail in you inbox, check the spam/bulk portion of your email account.';
  }




 ?>

<div class="container-fluid">


    <div class="row d-flex justify-content-center" style="margin-top:20px;">





      <!-- left pane //-->
      <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 mt-5">
          <h4 class='mb-4'>SIWES Registration<br><small>2019/2020 Academic Session</small></h4>

          <hr>
          <h3>Obtain your sign-in credentials</h3><br/>

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

                <?php
                }
                // ---------------------------- End of Error Message Notification Section
            ?>
            <!-- end of Notification Bar //-->

            <!-- instructions //-->
            <ul class='mt-4 mb-4'>
                <li>Check your email account for the mail sent to you</li>
                <li>Click the verification link in the email to verify your email account and activate your account on the SIWES portal</li>
                <li>After your account has been activated, sign-in to the SIWES portal with your username and password</li>
                <li>Complete and save the registration form.</li>

            </ul>

            <a href='signin.php'>Sign-in page</a>




            <!-- end of instruction //-->


      </div><!-- end of columm //-->
      <!-- end of right column //-->



    </div><!-- end of row //-->



</div><!-- end of container //-->

<br/><br/>
<?php
      //footer
      require_once("includes/footer.php");
 ?>

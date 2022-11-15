<?php

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    $page_title = 'Register Dean Access';

    require_once("../../config/step2/init_wp.php");
    require_once("../../nav/admin_nav.php");
    //require_once("../includes/staff_header.php");

    //require_once("../../classes/Department.php");
    //require_once("../../classes/StaffUser.php");

    $active_session = AcademicSession::active_session();


    $college = new College();
    $get_colleges = $college->get_colleges();

    $auth = new Auth();

    $err_msg = null;
    $err_flag = 0;

    if (isset($_POST['btnRegisterDean'])){
            $file_no = FieldSanitizer::inClean($_POST['file_no']);
            $full_name = FieldSanitizer::inClean($_POST['full_name']);
            $funaab_email = FieldSanitizer::inClean($_POST['funaab_email']);
            $phone = FieldSanitizer::inClean($_POST['phone']);
            $college_id = $_POST['college_id'];


            $verification_code = $auth->generate_verification_code();
            $password = $auth->generate_password();
            $password_encrypt = sha1(md5(sha1($password)));


            if ($file_no!='' && $full_name!='' && $funaab_email!='' && $college_id!=''){

                    $dataArray = array("session"=>$active_session, "file_no"=>$file_no, "fullname"=>$full_name, "funaab_email"=>$funaab_email, "phone"=>$phone,
                             "college_id"=>$college_id, "password"=>$password, "password_encrypt"=>$password_encrypt,
                             "verification_code"=>$verification_code);

                    $staff = new StaffUser();
                    $dean_access = $staff->register_dean($dataArray);



                    if ($dean_access->rowCount()){
                          $err_msg .= "A Sign-In credentials has been registered for the Dean.<br/>";

                          $subject = "FUNAAB YearBook Dean Online Access";
                          $sendMessage = "Dear ".$full_name.",<br/><br/>";
                          $sendMessage .= "Please find below your <strong>Sign-In Credentails</strong> to access the YearBook Submission
                                            for Deans.<br/>To make your submission, please click on the access url presented below.<br/><br/>";
                          $sendMessage .= 'Username: '.$file_no.'<br/>';
                          $sendMessage .= 'Password: '.$password.'<br/><br/>';

                          $sendMessage .= "Your access url: http://servicebill.unaab.edu.ng/yearbook/dean_login.php?q={$verification_code}&f={$file_no}";



                          $mail = new Mail();
                          $compose_email = $mail->compose_email($full_name, $funaab_email, $subject, $sendMessage);
                          $sent_response = $mail->sendMail();

                          if ($sent_response=='sent'){
                              $err_msg .= "An email has been sent to the Dean containing his/her Sign-In credentials. ";
                              $err_flag = 0;
                          }else{
                              $err_flag = 1;
                              $err_msg .= "An error occurred sending Sign-in credentials to the Dean.";
                          }
                    }else{
                          $err_flag = 1;
                          $err_msg = "An error occurred registering the Dean Sign-in credentials. Please contact the Admin.";
                    }


            }else{
                $err_msg = "Required fields must be supplied to register a Dean";
                $err_flag = 1;
            }




    }


  ?>


  <!-- Dashboard body //-->
  <div class="container">

      <!-- Page header //-->
      <div class="row mb-4">
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 page_header_spacer">
              <h3>Register Dean Access </h3>

          </div>

      </div>
      <!-- end of page header //-->






      <!-- Payment table //-->
      <div class="row">

        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 px-3 py-1 border rounded">

                  <!-- isPostBack Feedback  -->
                  <div class="md-form">
                      <?php
                          if (isset($_POST['btnRegisterDean'])){
                                //$err_msg = $message;
                                if ($err_flag==1){
                                      miniErrorAlert($err_msg);
                                }else{
                                      miniSuccessAlert($err_msg);
                                }
                          }
                      ?>
                  </div>
                  <!-- end of isPostBack feedback //-->
                  <form action="register_dean_access.php" method="post">

                        <!-- Select College -->
                        <label for="collegeCode"><strong>College <span class='text-danger'>*</span></strong></label>
                        <select class="browser-default custom-select mb-3 col-md-5" name="college_id" required>
                          <option selected value="">-- Select College --</option>
                          <?php
                              foreach($get_colleges as $row){
                                  echo "<option value='".$row['id']."'>".$row['college_name']."</option>";
                              }

                          ?>
                        </select>


                        <!-- File No input -->
                        <label for="file_no"><strong>File No. <span class='text-danger'>*</span></strong></label>
                        <input type="text" id="file_no" name="file_no" class="form-control col-md-4 mb-3" required>


                        <!-- Full name -->
                        <label for="full_name"><strong>Full Name <span class='text-danger'>*</span></strong></label>
                        <input type="text" id="full_name" name="full_name" class="form-control col-md-8 mb-3" required>


                        <!-- FUNAAB email -->
                        <label for="funaab_email"><strong>FUNAAB Email <span class='text-danger'>*</span></strong></label>
                        <input type="text" id="funaab_email" name="funaab_email" class="form-control col-md-8 mb-3" required>


                        <!-- Phone -->
                        <label for="phone"><strong>Phone</strong></label>
                        <input type="text" id="phone" name="phone" class="form-control col-md-8 mb-3">





                        <button type="submit" name="btnRegisterDean" class="btn btn-primary btn-rounded btn-sm">Register Dean</button>
                  </form>


        </div><!-- end of column //-->
    </div><!-- end of row //-->
    <!-- end of payment table //-->


  </div> <!-- end of container //-->

<br/><br/><br/>
<input type='hidden' id='is_firstLogin' value="<?php echo $already_logged_in; ?>" />
<?php

    //footer.php
    require('../../includes/footer.php');
 ?>
<script src="../../lib/js/custom/tblData.js"></script>

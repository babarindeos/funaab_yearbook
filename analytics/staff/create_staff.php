<?php

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    $page_title = 'Create Staff';

    require_once("../../config/step2/init_wp.php");
    require_once("../../nav/admin_nav.php");
    //require_once("../includes/staff_header.php");

    require_once("../../classes/Department.php");
    require_once("../../classes/StaffUser.php");

    $staff = new StaffUser();
    $auth = new Auth();

    $department = new Department();
    $get_units = $department->get_all_units_dept_code();

    if (isset($_POST['btnCreateStaff'])){
        $file_no = FieldSanitizer::inClean($_POST['file_no']);
        $full_name = FieldSanitizer::inClean($_POST['names']);
        $funaab_email = FieldSanitizer::inClean($_POST['funaab_email']);
        $phone = FieldSanitizer::inClean($_POST['phone']);
        $unit_id = $_POST['unit_id'];
        $dept_code = FieldSanitizer::inClean($_POST['dept_code']);
        $dept_name = FieldSanitizer::inClean($_POST['dept_name']);


        $verification_code = $auth->generate_verification_code();
        $password = $auth->generate_password();
        $password_encrypt = sha1(md5(sha1($password)));

        $dataArray = array("file_no"=>$file_no, "full_name"=>$full_name, "funaab_email"=>$funaab_email, "phone"=>$phone,
                     "unit_id"=>$unit_id, "dept_code"=>$dept_code, "dept_name"=>$dept_name, "password"=>$password_encrypt, "verification_code"=>$verification_code);

        $result = $staff->create_staff($dataArray);

        if ($result->rowCount()){
                    $message = "Staff has been successfully created.<br/>";
                    // send mail
                    $sender = "FUNAAB";
                    $subject = "FUNAAB Student Clearance";
                    $sender_email = 'FUNAAB Exams & Records clearance@servicebill.unaab.edu.ng';


                    //$recipient = $_SESSION['studentData']['email'];
                    //$recipient = $_SESSION['email'];
                    //$recipient = "kondishiva007@gmail.com";

                    // Running $recipientEmails Loop to send message to student $recipientEmails
                    //************************* Send email ******************************************************
                        $sent_response = '';


                              $recipient = $funaab_email ;
                              $send_message = 'Dear '.$full_name.',<br/><br/>';
                              $send_message .= 'Please find below your staff sign-in credentials to access the University Online Clearance Platform.<br/>To login click on your access url presented below.<br/><br/>';
                              $send_message .= 'Username: '.$file_no.'<br/>';
                              $send_message .= 'Password: '.$password.'<br/><br/>';

                              $send_message .= "Your access url: http://servicebill.unaab.edu.ng/clearance/staff_login.php?q={$verification_code}&f={$file_no}";


                              $mail = new Mail();
                              $sent_response = $mail->sendMail($sender, $sender_email, $recipient, $subject, $send_message);


                        if ($sent_response=='sent'){
                              $message .= "An email has been sent to Staff containing your Sign-in credentials. ";
                              $err_flag = 0;

                        }else{
                              $err_flag = 1;
                              $message .= "An error occurred sending Sign-in credentials to Staff.";
                        }


                        //************************** End of send email ************************************************

              }else{
                        $err_flag = 1;
                        $message = "An error occurred creating Staff Sign-in credentials. Please contact the Admin.";
              }
              // -----end of send mail //----------------

    }


  ?>


  <!-- Dashboard body //-->
  <div class="container">

      <!-- Page header //-->
      <div class="row mb-4">
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 page_header_spacer">
              <h3>Staff </h3>

          </div>

      </div>
      <!-- end of page header //-->






      <!-- Payment table //-->
      <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mb-4">
          <h5>Create Staff</h5>

        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 px-3 py-3 border rounded">

                  <!-- isPostBack Feedback  -->
                  <div class="md-form">
                      <?php
                          if (isset($_POST['btnCreateStaff'])){
                                $err_msg = $message;
                                if ($err_flag==1){
                                      miniErrorAlert($err_msg);
                                }else{
                                      miniSuccessAlert($err_msg);
                                }
                          }
                      ?>
                  </div>
                  <!-- end of isPostBack feedback //-->
                  <form action="create_staff.php" method="post">
                        <!-- File No input -->
                        <label for="file_no"><strong>File No.</strong></label>
                        <input type="text" id="file_no" name="file_no" class="form-control col-md-4 mb-3" required>


                        <!-- Full name -->
                        <label for="names"><strong>Full Name</strong></label>
                        <input type="text" id="names" name="names" class="form-control col-md-8 mb-3" required>


                        <!-- FUNAAB email -->
                        <label for="funaab_email"><strong>FUNAAB email</strong></label>
                        <input type="text" id="funaab_email" name="funaab_email" class="form-control col-md-8 mb-3" required>


                        <!-- Phone -->
                        <label for="phone"><strong>Phone</strong></label>
                        <input type="text" id="phone" name="phone" class="form-control col-md-8 mb-3" required>

                        <!--  -->
                        <label for="unit"><strong>Unit & Dept Code</strong></label>
                        <select class="browser-default custom-select mb-3 col-md-5" name="unit_id">
                          <option selected value="">Open this select menu</option>
                          <?php
                              foreach($get_units as $row){
                                  echo "<option value='".$row['id']."'>".$row['name']."</option>";
                              }

                          ?>

                        </select>

                        <!-- Department Code -->
                        <label for="dept_code"><strong>Department Code</strong></label>
                        <input type="text" id="dept_code" name="dept_code" class="form-control col-md-8 mb-3">

                        <!-- Department Name -->
                        <label for="dept_name"><strong>Department Name</strong></label>
                        <input type="text" id="dept_name" name="dept_name" class="form-control col-md-8 mb-3">

                        <button type="submit" name="btnCreateStaff" class="btn btn-primary btn-rounded btn-sm">Create Staff</button>
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

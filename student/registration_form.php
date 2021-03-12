<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


    $page_title = 'Registration Form';

    require_once("../core/wp_config.php");
    require_once("../nav/nav_login.php");
    //require_once("../includes/staff_header.php");

    //------------- Student Account Check ---------------------
    require_once("../includes/is_student_login.php");



    //-------------- flag and message variables declared and initialized -------------------------------
        $err_flag = 0;
        $err_msg = null;
        $message = "";
        $info = '';


    // get currently active session
    $academic_session = new AcademicSession();
    $get_active_session = $academic_session->get_active_session();

    $current_academic_session = $get_active_session->fetch(PDO::FETCH_ASSOC);
    $current_academic_session = $current_academic_session['session'];



    // get read-only student data
    $regNumber = $_SESSION['auth_username']; // regNumber is the same as the student Matriculation No, which is the student username
    $matric_no = $regNumber;
    $studentPhoto = "https://portal.unaab.edu.ng/TEMP/${matric_no}.jpg";


    $applicant = new Applicant();
    $get_readOnlyData = $applicant->getApplicant($regNumber);


    // applicant record is found
    if ($get_readOnlyData->rowCount()){

        // fetch the user data
        $row = $get_readOnlyData->fetch(PDO::FETCH_ASSOC);

        $surname = $row['surname'];
        $firstname = $row['firstname'];
        $othername = $row['othername'];
        $email = $row['email'];
        $phone = $row['phone'];
        $level = $row['level'];
        $deptCode = $row['deptCode'];
        $collegeCode = $row['collegeCode'];

    }

    $studentData = array("surname"=>$surname, "firstname"=>$firstname, "othername"=>$othername, "email"=>$email, "phone"=>$phone,
                        "level"=>$level, "deptCode"=>$deptCode, "collegeCode"=>$collegeCode);


  // ------------------------------- Save Registration -----------------------------------------------------------------

    if (isset($_POST['btnSave'])){

        $matric_no = FieldSanitizer::inClean($regNumber);
        $alt_email = FieldSanitizer::inClean($_POST['alt_email']);
        $alt_phone = FieldSanitizer::inClean($_POST['alt_phone']);
        $home_address = FieldSanitizer::inClean($_POST['homeAddr']);
        $parent_names = FieldSanitizer::inClean($_POST['parent_names']);
        $parent_phone_no = FieldSanitizer::inClean($_POST['parent_phone_no']);
        $next_of_kin = FieldSanitizer::inClean($_POST['nok_names']);
        $nok_phone_no = FieldSanitizer::inclean($_POST['nok_phone_no']);
        $bank_name = FieldSanitizer::inClean($_POST['bank_name']);
        $bank_account_no = FieldSanitizer::inClean($_POST['bank_account_no']);
        $bank_sort_code = FieldSanitizer::inClean($_POST['bank_sort_code']);

        $regData = array("academic_session"=>$current_academic_session, "matric_no"=>$matric_no, "alt_email"=>$alt_email, "alt_phone"=>$alt_phone, "home_address"=>$home_address,
                            "parent_names"=>$parent_names, "parent_phone_no"=>$parent_phone_no, "next_of_kin"=>$next_of_kin,
                            "nok_phone_no"=>$nok_phone_no, "bank_name"=>$bank_name, "bank_account_no"=>$bank_account_no,
                            "bank_sort_code"=>$bank_sort_code);


        $registration = new Registration();

        $crud_action = $_POST['crud_action'];

        if ($crud_action=='insert'){
            $result = $registration->new_registration($regData);

            if ($result->rowCount()){
                $message = "Registration form has been successfully saved.";
            }else{
                $err_flag = 1;
                $message = "An error occurred! Registration form has not been saved.";
            }
        }else{
            $result = $registration->update_registration($regData);

            if ($result->rowCount()){
                $message = "Registration form has been successfully updated.";
            }else{
                $err_flag = 1;
                $message = "No update has been performed.";
            }
        }


    }
  //-------------------------------- End of Save Registration form ------------------------------------------------------


  // ------------------------------ get registration record for the logged-in user  -------------------------------------

      $registration = new Registration();
      $is_user_registered = $registration->is_user_registered($matric_no);

      $crud_action = '';
      $regData = '';

      if ($is_user_registered->rowCount()){
          $crud_action = "update";

          $row = $is_user_registered->fetch(PDO::FETCH_ASSOC);

          $reg_id = $row['id'];
          $academic_session = $row['academic_session'];
          $alt_email = FieldSanitizer::outClean($row['alt_email']);
          $alt_phone = FieldSanitizer::outClean($row['alt_phone']);
          $home_address = FieldSanitizer::outClean($row['home_address']);
          $parent_names = FieldSanitizer::outClean($row['parent_names']);
          $parent_phone_no = FieldSanitizer::outClean($row['parent_phone_no']);
          $next_of_kin = FieldSanitizer::outClean($row['next_of_kin']);
          $nok_phone_no = FieldSanitizer::outClean($row['nok_phone_no']);
          $bank_name = FieldSanitizer::outClean($row['bank_name']);
          $bank_account_no = FieldSanitizer::outClean($row['bank_account_no']);
          $bank_sort_code = FieldSanitizer::outClean($row['bank_sort_code']);


      }else{
          $crud_action = "insert";
          $reg_id =''; $academic_session=''; $alt_email=''; $alt_phone=''; $home_address=''; $parent_names=''; $parent_phone_no='';
          $next_of_kin=''; $next_of_kin=''; $nok_phone_no=''; $bank_name=''; $bank_account_no=''; $bank_sort_code='';


      }







  ?>


  <div class="container-fluid">

    <!-- Pre-payment Form //-->
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <div class="row" style="margin-top:20px;">





      <!-- left pane //-->
      <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
          <h4 class='mb-4'>SIWES Registration<br><small><?php echo $current_academic_session; ?> Academic Session</small></h4>


          <!-- Notification Bar //-->
          <?php
              //---------------------------- Info Notification Section ---------------------------------------
              if (isset($_POST['btnSave'])){
                    if ($err_flag==1){
                    ?>
                      <div class="alert alert-danger mt-1" role="alert">
                           <i class="fas fa-exclamation-circle"></i>  <?php echo $message; ?>
                      </div>

                    <?php
                    }
                }
              // ---------------------------- End of Info Notification Section -------------------------------

              //---------------------------- Error Message Notification Section ---------------------------------------
              if (isset($_POST['btnSave'])){
                  if ($err_flag==0){
                  ?>
                    <div class="alert alert-success mt-1" role="alert">
                         <i class="fas fa-info-circle"></i>  <?php echo $message; ?>
                         <br/><small><strong>Note:</strong> You will be required to update your registration form when you have secured a placement.</small>
                    </div>

                  <?php
                  }
              }
              // ---------------------------- End of Error Message Notification Section
          ?>
          <!-- end of Notification Bar //-->



          <div class="d-flex justify-content-end">
              <button type="button" id='btn_toggle_readonly_fields' class="btn btn-primary btn-sm">
                Read Only Fields
              </button>
          </div>

            <!-- Grid row 1 //-->
            <div class="form-row" id='row_names' style="display: none;">
                <!-- surname //-->
                <div class="form-group col-md-4">
                    <label for="surname" disabled>Surname</label>
                    <input type='text' class='form-control' id='surname' name='surname' value="<?php echo $studentData['surname']; ?>" disabled>
                </div>
                <!-- end of surname //-->

                <!-- firstname //-->
                <div class="form-group col-md-4">
                    <label for="firstname" disabled>Firstname</label>
                    <input type='text' class='form-control' id='firstname' name='firstname' value="<?php echo $studentData['firstname']; ?>" disabled>
                </div>
                <!-- end of firstname //-->

                <!-- Othernames //-->
                <div class="form-group col-md-4">
                    <label for="othernames" disabled>Othernames</label>
                    <input type='text' class='form-control' id='othername' name='othername' value="<?php echo $studentData['othername'] ?>" disabled>
                </div>
                <!-- end of firstname //-->


            </div>
            <!-- end of Grid 1 //-->



            <!-- Grid row 2 //-->
            <div class="form-row" id='row_contact' style='display:none;'>
                <!-- email //-->
                <div class="form-group col-md-8">
                    <label for="email" disabled>Email</label>
                    <input type="email" class="form-control" id="email" name='email' value="<?php echo $studentData['email']; ?>" disabled>
                </div>
                <!-- end of email //-->

                <!-- phone //-->
                <div class="form-group col-md-4">
                    <label for="phone" disabled>Phone</label>
                    <input type="phone" class="form-control" id="phone" name='phone' value="<?php echo $studentData['phone']; ?>" disabled>
                </div>

                <!-- end of phone //-->


            </div>
            <!-- end of Grid row 2 //-->


            <!-- Grid row 3 //-->
            <div class="form-row" id='row_discipline' style="display:none;">
                <!-- level //-->
                <div class="form-group col-md-4">
                    <label for="level" disabled>Level</label>
                    <input type="text" class="form-control" id="level" name='level' value="<?php echo $studentData['level']; ?>" disabled>
                </div>
                <!-- end of level //-->

                <!-- department //-->
                <div class="form-group col-md-4">
                    <label for="deptCode" disabled>Department</label>
                    <input type="deptCode" class="form-control" id="deptCode" name='deptCode' value="<?php echo $studentData['deptCode']; ?>" disabled>
                </div>

                <!-- end of department //-->

                <!-- college //-->
                <div class="form-group col-md-4">
                    <label for="collegeCode" disabled>College</label>
                    <input type="text" class="form-control" id="collegeCode" name='collegeCode' value="<?php echo $studentData['collegeCode']; ?>" disabled>
                </div>

                <!-- end of college //-->


            </div>
            <!-- end of Grid row 3 //-->

            <!-- Grid row 4 //-->
            <div class="form-row">
                <!-- Alternate email //-->
                <div class="form-group col-md-7">
                    <label for="alt_email">Alternate Email</label>
                    <input type="email" class="form-control" id="alt_email" name='alt_email' value="<?php echo $alt_email; ?>">
                    <small id="alt_emailHelpBlock" class="form-text text-muted text-left">
                      Another personal email account that is active and functional.
                    </small>
                </div>
                <!-- end of alternate email //-->

                <!-- alternate phone //-->
                <div class="form-group col-md-5">
                    <label for="alt_phone">Alternate Phone</label>
                    <input type="phone" class="form-control" id="alt_phone" name='alt_phone' value="<?php echo $alt_phone; ?>" >
                    <small id="alt_phoneHelpBlock" class="form-text text-muted text-left">
                      Another personal phone number on which you can be reached.
                    </small>
                </div>
                <!-- end of alternate phone //-->
            </div>
            <!-- end of Grid row 4 //-->


            <!--  Grid row 4 //-->
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label for='homeAddr'>Home Address</label>
                    <input type='text' class='form-control' id='homeAddr' name='homeAddr' required value="<?php echo $home_address; ?>">
                </div>
            </div>
            <!-- end of Grid row 4 //-->

            <!-- // Grid row 5-->
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="parent_names">Parent/Guardian</label>
                    <input type="text" class="form-control" id="parent_names" name="parent_names" required value="<?php echo $parent_names; ?>">
                </div>
                <div class="form-group col-md-6">
                    <label for="parent_phone_no">Parent/Guardian Phone No.</label>
                    <input type="text" class="form-control" id="parent_phone_no" name="parent_phone_no" required value="<?php echo $parent_phone_no; ?>">
                </div>
            </div>
            <!-- end of Grid row 5 //-->


            <!-- // Grid row 6-->
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="nok_names">Name of Next of Kin</label>
                    <input type="text" class="form-control" id='nok_names' name="nok_names" required value="<?php echo $next_of_kin; ?>">
                </div>
                <div class="form-group col-md-6">
                    <label for="nok_phone_no">Phone No. of Next of Kin</label>
                    <input type="text" class="form-control" id="nok_phone_no" name="nok_phone_no" required value="<?php echo $nok_phone_no; ?>">
                </div>
            </div>
            <!-- end of Grid row 6 //-->

            <!--  Grid row 7  //-->
            <div class="form-row">
                <!-- Bank Name //-->
                <div class="form-group col-md-5">
                        <label for="bank_name">Bank Name</label>
                        <select class="form-control browser-default custom-select" id="bank_name" name="bank_name" required>
                              <option value='' <?php if($bank_name==''){echo 'selected'; } ?> > -- Choose Bank --</option>
                              <option value="access" <?php if($bank_name=='access'){echo 'selected'; } ?> >Access Bank</option>
                              <option value="citibank" <?php if($bank_name=='citibank'){echo 'selected'; } ?> >Citibank</option>
                              <option value="access_diamond"  <?php if($bank_name=='access_diamond'){echo 'selected'; } ?> >Access Diamond Bank</option>
                              <option value="ecobank" <?php if($bank_name=='ecobank'){echo 'selected'; } ?> >Ecobank</option>
                              <option value="fidelity" <?php if($bank_name=='fidelity'){echo 'selected'; } ?> >Fidelity Bank</option>
                              <option value="firstbank" <?php if($bank_name=='firstbank'){echo 'selected'; } ?> >First Bank</option>
                              <option value="fcmb" <?php if($bank_name=='fcmb'){echo 'selected'; } ?>>First City Monument Bank (FCMB)</option>
                              <option value="gtb" <?php if($bank_name=='gtb'){echo 'selected'; } ?>>Guaranty Trust Bank (GTB)</option>
                              <option value="heritage" <?php if($bank_name=='heritage'){echo 'selected'; } ?> >Heritage Bank</option>
                              <option value="keystone" <?php if($bank_name=='keystone'){echo 'selected'; } ?> >Keystone Bank</option>
                              <option value="polaris" <?php if($bank_name=='polaris'){echo 'selected'; } ?> >Polaris Bank</option>
                              <option value="providus" <?php if($bank_name=='providus'){echo 'selected'; } ?> >Providus Bank</option>
                              <option value="stanbic" <?php if($bank_name=='stanbic'){echo 'selected'; } ?> >Stanbic IBTC Bank</option>
                              <option value="standard" <?php if($bank_name=='standard'){echo 'selected'; } ?> >Standard Chartered Bank</option>
                              <option value="sterling" <?php if($bank_name=='sterling'){echo 'selected'; } ?> >Sterling Bank</option>
                              <option value="suntrust" <?php if($bank_name=='suntrust'){echo 'selected'; } ?> >Suntrust Bank</option>
                              <option value="union" <?php if($bank_name=='union'){echo 'selected'; } ?> >Union Bank</option>
                              <option value="uba" <?php if($bank_name=='uba'){echo 'selected'; } ?> >United Bank for Africa (UBA)</option>
                              <option value="unity" <?php if($bank_name=='unity'){echo 'selected'; } ?> >Unity Bank</option>
                              <option value="wema" <?php if($bank_name=='wema'){echo 'selected'; } ?>>Wema Bank</option>
                              <option value="zenith" <?php if($bank_name=='zenith'){echo 'selected'; } ?>>Zenith Bank</option>
                        </select>

                </div>
                <!-- Bank Name  //-->

                <!-- Bank Account Number //-->
                <div class="form-group col-md-4">
                      <label for="bank_account_no">Bank Account No.</label>
                      <input type="text" class="form-control" id="bank_account_no" name="bank_account_no" required value="<?php echo $bank_account_no; ?>">
                </div>

                <!-- Bank Sort Code -->
                <div class="form-group col-md-3">
                  <label for="bank_sort_codee">Bank Sort Code</label>
                  <input type="text" class="form-control" id="bank_sort_code" name="bank_sort_code" required value="<?php echo $bank_sort_code; ?>">

                </div>
                <!-- Bank Sort Code //-->

            </div>
            <!-- End of Grid row 7  //-->

            <!-- Grid row 8 //-->
                <!-- Save/Update Button //-->
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <button type='submit' name='btnSave' class="btn btn-rounded btn-md btn-primary"><i class="fas fa-save"></i> Save</button>
                        <input type='hidden' name='crud_action' value='<?php echo $crud_action; ?>' />
                    </div>
                </div>
                <!-- end of Save/Update Button //-->
            <!-- end of Grid row 8 //-->

      </div>
      <!-- end of left pane //-->


      <!--  right column  //-->
      <div class="col-xs-12 col-sm-12 col-md-4 col-lg text-center">
           <?php
                echo "<h4>User: [<strong>".$matric_no."</strong>] &nbsp;
                  <a href='../signin.php'>
                    <small><i class='fas fa-power-off'></i> Log-out</small>
                  </a>
                </h4>";
           ?>


           <div class="avatar mx-auto white mt-5"><img src="<?php echo $studentPhoto; ?>"
                  alt="avatar mx-auto white" class="rounded-circle img-fluid border">
           </div>


      </div><!-- end of columm //-->
      <!-- end of right column //-->



    </div><!-- end of row //-->

  </form>
  <!-- end of Prepayment form //-->

</div><!-- end of container //-->

<br/><br/>
<?php
      //footer
      require_once("../includes/footer.php");
 ?>

 <script>
  $(document).ready(function(){

      $("#btn_toggle_readonly_fields").bind("click", function(){

          $("#row_names").toggle();
          $("#row_contact").toggle();
          $("#row_discipline").toggle();
      });
  });

 </script>

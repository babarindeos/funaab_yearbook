<?php
      session_start();
      unset($_SESSION['yearbook_passport']);
      session_destroy();

      session_start();

      //ini_set('display_errors', 1);
      //ini_set('display_startup_errors', 1);
      //error_reporting(E_ALL);


      $page_title = "Yearbook";

      // Core
      require_once("core/config.php");

      // Header
      require_once("includes/header.php");

      // Navigation
      require_once("nav/nav_login.php");

      require_once("includes/ws_parameters.php");
      require_once("includes/ws_functions.php");
      include_once("includes/funaabWS.php");
      //include_once("includes/Eligibility.php");

      //functions
      require_once("functions/Login_ProcessStudentData.php");


      $acadaSession = new AcademicSession();
      $get_acada_session = $acadaSession->get_active_session();
      $acada_session_recordset = $get_acada_session->fetch(PDO::FETCH_ASSOC);
      $current_session = $acada_session_recordset['session'];





      $err_flag = 0;
      $err_msg = null;

      if (isset($_POST['formLogin'])){

          //require_once("functions/Spinner_small_blue.php");
          $login_matriculation_no = FieldSanitizer::inClean($_POST['login_Matriculation_Number']);
          $regNumber = $login_matriculation_no;

          $login_portal_password = trim($_POST['portal_password']);

          //$acadaSession = '2019/2020';
          $acadaSession = $current_session;

          @$studentDetails = getStudentRecord($regNumber, $acadaSession);

          if ($studentDetails == 'Fault') {
              $err_flag==1;
              //$err_msg = "Student Portal not available ($studentDetails), please try again later. ";
              $err_msg = "Student Portal not available, please try again later. ";
          }else{
              //Retrieve Record from Portal
              $json =json_decode(json_encode($studentDetails));
              //print_r($json);
              //exit;


              //check if portal password is current
              $portal_passwordHash = trim($json->PasswordHash);
              $form_login_portal_password = trim(md5($login_portal_password));


              $start_year = substr($matric_no,0,4);
              $current_year = Date('Y');
              $studentship_duration = $current_year - $start_year;
              $isEligible = false;

              //var_dump($json);
              $minDuration = $json->minDuration;


              if ($minDuration!=''  && $studentship_duration >= $minDuration){
                $isEligible = true;
              }



              //echo "<br/><br/><br/><br/><p><p>".$json->Level;
              //if ($isEligible){
                    if ($form_login_portal_password==$portal_passwordHash){

                        $err_msg = processStudentData($regNumber, $json);

                        if ($err_msg!=''){
                          $err_flag = 1;
                        }
                    }else{

                        $err_flag = 1;
                        $err_msg = "Invalid Sign-in Credentials";

                    } //  end of $form_login_portal_password
              //}else{
                      //  $err_flag = 1;
                      ///  $err_msg = "You are ineligible to access this service.";
              //}



          } // end of else if

   }  // end of POST['form_login']



 ?>

<div class="container-fluid">
    <div class="row" style="margin-top:0;">
      <div class="col-xs-12 col-sm-12 col-md-8 col-xs-d-none col-lg-8"   >
          <div>
              <!-- <div style="background-image:url('assets/images/funaab_student_graduands.jpg'); height:450px;">
                    <div class='px-2 py-2' style='background-color:#f1f1f1;opacity: 0.8; font-weight:bold;'><h2 class='mt-1'>Clearance for Students Withdrawing/Graduating<br/>from the University.</h2></div>
              </div> -->
              <div>
                    <div class='px-2 py-2' style='background-color:#f1f1f1;opacity: 0.8; font-weight:bold;'><h2 class='mt-1'>Yearbook <?php echo $current_session; ?></h2></div>
              </div>

              <h4 class='mt-5 ml-3'>For Final Year Students</h4>
              <ol>
                  <li>Enter your Matriculation No. and Portal Password to login</li>
                  <li>Upload a good quality passport photograph of yourself</li>
                    <ul>
                        <li>Photograph must be of passport-size</li>
                        <li>Photograph must cover only between head to shoulder portion of body</li>
                        <li>Photograph must be on plain background</li>
                    </ul>
                  <li>Provide your Day and Month of Birth</li>
                  <li>Provide accurate and functional email address</li>
                  <li>Provide one or two functional phone number(s)</li>
                  <li>Provide your contact address</li>

              </ol>
          </div>
          <div class='ml-3 mt-5'>
                <h5 class='font-weight-bold'>Deadline for submission is 6th December, 2022.</h5>
          </div>


      </div>



      <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 mt-4 px-3">
            <!-- Material form login -->

                    <!-- Form -->
                    <form action="index.php" method="post">
                        <!-- form //-->
                            <h3>Sign-In</h3>
                            <div class="form border rounded z-index-5 py-4 px-4 ">
                                      <div>
                                          <?php
                                                if (isset($_POST['formLogin'])){
                                                      if ($err_flag==1){
                                                            miniErrorAlert($err_msg);
                                                      }
                                                }
                                          ?>
                                      </div>

                                      <!-- Matriculation No. //-->
                                      <div class="form-group col-md-12">
                                          <label for="matriculation_no" disabled>Matriculation No.</label>
                                          <input type='text' class='form-control' id='login_Matriculation_Number' name='login_Matriculation_Number' >
                                      </div>
                                      <!-- end of matriculation No. //-->

                                      <!-- DOB //-->
                                      <!-- <div class="form-group col-md-12">
                                          <label for="DOB" disabled>Date of Birth <small style='cursor:pointer;' title='Click to pick your Date of Birth'><i class="far fa-calendar-alt"></i></small></label>
                                          <input type='text' class='form-control datepicker' id='DOB' name="dob">
                                      </div> -->
                                      <!-- end of DOB //-->

                                      <!-- FUNAAB email //-->
                                      <div class="form-group col-md-12">
                                          <label for="portal_password" disabled>Portal Password </label>
                                          <input type='password' class='form-control' id='portal_password' name="portal_password">
                                      </div>
                                      <!-- end of FUNAAB email //-->

                                      <!-- Button Submit //-->
                                      <div class="form-group col-md-12">
                                          <button type='submit' class='btn btn-primary btn-sm rounded'  id='formLogin' name="formLogin">Sign in</button>
                                      </div>
                                      <!-- end of DOB //-->



                            </div>
                            <!-- end of form //-->
                    </form>
                    <!-- Form -->

      </div><!-- end of columm //-->



    </div><!-- end of row //-->
</div><!-- end of container //-->

<br/><br/>
<?php
      //footer
      require_once("includes/footer.php");
 ?>
 <script>
 $(document).ready(function(){

 })
</script>

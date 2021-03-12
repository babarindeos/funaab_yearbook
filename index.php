<?php
      session_start();
      session_destroy();

      session_start();

      //ini_set('display_errors', 1);
      //ini_set('display_startup_errors', 1);
      //error_reporting(E_ALL);


      $page_title = "Clearance for Students";

      // Core
      require_once("core/config.php");

      // Header
      require_once("includes/header.php");

      // Navigation
      require_once("nav/nav_login.php");

      require_once("includes/ws_parameters.php");
      require_once("includes/ws_functions.php");
      include_once("includes/funaabWS.php");

      //functions
      require_once("functions/Login_ProcessStudentData.php");




      $err_flag = 0;
      $err_msg = null;
      if (isset($_POST['formLogin'])){

          //require_once("functions/Spinner_small_blue.php");
          $login_matriculation_no = FieldSanitizer::inClean($_POST['login_Matriculation_Number']);
          $regNumber = $login_matriculation_no;

          $login_funaab_email = strtolower(trim($_POST['funaabEmail']));

          $acadaSession = new AcademicSession();
          $get_acada_session = $acadaSession->get_active_session();
          $acada_session_recordset = $get_acada_session->fetch(PDO::FETCH_ASSOC);
          $current_session = $acada_session_recordset['session'];

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

              //check if matric no and user official email matches
              $funaabEmail = strtolower(trim($json->OfficialEmail));
              if ($login_funaab_email==$funaabEmail){
                  processStudentData($regNumber, $json);
              }else{
                  $err_flag = 1;
                  $err_msg = "Invalid Sign-in Credentials";

              }

          } // end of else if

   }  // end of POST['form_login']



 ?>

<div class="container-fluid">
    <div class="row" style="margin-top:0;">
      <div class="col-xs-12 col-sm-12 col-md-8 col-xs-d-none col-lg-8"   >
          <div>
              <h2 class='mt-5'>Clearance for Students Withdrawing/Graduating<br/>from the University.</h2>
              <div>
                    <big></big>
              </div>
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
                                          <label for="funaabemail" disabled>FUNAAB email </label>
                                          <input type='text' class='form-control' id='funaabEmail' name="funaabEmail">
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

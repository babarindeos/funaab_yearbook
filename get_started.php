<?php
      session_start();
      session_destroy();

      session_start();

      //ini_set('display_errors', 1);
      //ini_set('display_startup_errors', 1);
      //error_reporting(E_ALL);


      $page_title = "Registration";
      // Core
      require_once("core/config.php");
      // Header
      require_once("includes/header.php");
      // Navigation

      require_once("nav/nav_login.php");

      require_once("includes/ws_parameters.php");

      require_once("includes/ws_functions.php");

      include_once("includes/funaabWS.php");




      $err_flag = 0;
      $err_msg = null;
      if (isset($_POST['formLogin'])){


          //require_once("functions/Spinner_small_blue.php");

          $login_martriculation_no = FieldSanitizer::inClean($_POST['login_Matriculation_Number']);
          $regNumber = $login_martriculation_no;
          $acadaSession = '2017/2018';

          @$studentDetails = getStudentRecord($regNumber,$acadaSession);

          if ($studentDetails == 'Fault') {
              $err_flag==1;
              $err_msg = "Student Portal not available ($studentDetails), please try again later. ";
          }else{
            //Retrieve Record from Portal
            $json =json_decode(json_encode($studentDetails));
            //print_r($json);
            $studentStatus=$json->PaymentStatus;
  					$surname=htmlentities(strtoupper(trim($json->Surname)), ENT_QUOTES);
  					$firstname=htmlentities(ucfirst(strtolower(trim($json->Firstname))), ENT_QUOTES);
  					$othername= htmlentities(ucfirst(strtolower(trim($json->Middlename))), ENT_QUOTES);
  					$gender=strtoupper(trim($json->Sex));
  					$deptCode=strtoupper(trim($json->Department));
  					$level=strtoupper(trim($json->Level));
  					//echo $level;
  					$minDuration=strtoupper(trim($json->MinDuration));
  					$phone=strtoupper(trim($json->Phone));
  					$email=strtolower(trim($json->Email));
  					$collegeCode=strtoupper(trim($json->College));
  					$sex=strtoupper(trim($json->Sex));
  					$CGPA=strtoupper(trim($json->CGPA));
  					$Matric=strtoupper(trim($json->MatricNo));
  					$programme=ucfirst(strtolower(trim($json->Programme)));
  					//echo "Duration:$minDuration, Level: $level, $collegeCode, $regNumber<br>";

            $dataArray = array("studentStatus"=>$studentStatus, "surname"=>$surname, "firstname"=>$firstname, "othername"=>$othername,
            "gender"=>$gender, "deptCode"=>$deptCode, "level"=>$level, "MinDuration"=>$minDuration, "phone"=>$phone, "email"=>$email,
            "collegeCode"=>$collegeCode, "sex"=>$sex, "CGPA"=>$CGPA, "Matric"=>$Matric, "programme"=>$programme);

            //echo $studentStatus;
            // verify if the student record is found
            if (($surname=='') || ($firstname=='') || ($email=='') || ($phone=='')){
              $err_flag = 1;
              $err_msg = 'Error retrieving record. <br/>Check the Matriculation No. entered';
            }else{

              // Record found proceed to insert user data into siwes applicant database if not already other
              // check student Status: if PAID
              $applicant = new Applicant();

              if ($studentStatus=="PAID"){
                  $getApplicant = $applicant->getApplicant($regNumber);

                  // check if record is not found and insert into applicants
                  if ($getApplicant->rowCount()==0){
                      // create applicant record for the user
                      $applicantData = array("regNumber"=>$regNumber,"surname"=>$surname,"firstname"=>$firstname,"othername"=>$othername,"phone"=>$phone,
                                       "email"=>$email,"level"=>$level,"acadaLevel"=>$acadaLevel,"gender"=>$gender,"deptCode"=>$deptCode,"collegeCode"=>$collegeCode,
                                       "CGPA"=>$CGPA,"highflyer"=>$highflyer, "minDuration"=>$minDuration);

                      $new_applicant = $applicant->create_new_applicant($applicantData);

                      // if new applicant is created
                      if ($new_applicant->rowCount()){
                          //session_start();
                          $_SESSION['app_login'] = '2021';
                          $_SESSION['regNumber'] = $regNumber;
                          $_SESSION['studentData'] = $dataArray;
                          header("location:prepayment.php");

                      }else{
                        // creating new applicant failed
                         $err_flag = 1;
                         $err_msg .= 'Record not saved. Please try again.';
                      }
                  }else{
                      // applicant had already been created...then redirect to the prepayment page
                          //session_start();
                          $_SESSION['app_login'] = '2021';
                          $_SESSION['regNumber'] = $regNumber;
                          $_SESSION['studentData'] = $dataArray;
                          if (headers_sent()){
                            die("<div class='mt-5 text-center'><big>If not redirected. Please click on this link: <a href='prepayment.php'>Payment for SIWES Dues and Logbook Charges.</a></big></div>");
                          }else{
                            header("location:prepayment.php");
                          }

                  }

              }else{
                  // School fees status not PAID
                  $err_flag = 1;
                  $err_msg .= "School Fees Payment Status: {$studentStatus}";

              }


            }
            // end of verification of student record

          } // end of else if





      }  // end of POST['form_login']



 ?>

<div class="container-fluid">
    <div class="row d-flex justify-content-center" style="margin-top:20px;">



      <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
            <!-- Material form login -->
            <center><h4>SIWES Registration <br/><small>2019/2020 Academic Session </h4></center>
            <div class="card">
                <h5 class="card-header white-text text-center py-4" style="opacity:0.6; background-color:#3f8c3e">
                  <strong>Log in</strong>
                </h5>

                <!--Card content-->
                <div class="card-body px-lg-5 pt-0">

                    <!-- Form -->
                    <form class="text-center" style="color:#3f8c3e;" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

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
                            <label for="login_Matriculation_Number">Matriculation Number </label>
                            <input type="text" id="login_Matriculation_Number" name="login_Matriculation_Number" class="form-control">
                            <small id="loginHelpBlock" class="form-text text-muted text-left">
                              Your Matriculation Number Format: 20######
                            </small>

                          </div>


                          <!-- Sign in button -->
                          <button name="formLogin" class="btn btn-outline-success btn-rounded btn-block my-4 waves-effect z-depth-0" style='opacity:0.8' type="submit">Log in</button>


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
 <script>
 $(document).ready(function(){

 })
</script>

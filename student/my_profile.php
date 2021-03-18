<?php

  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);
  //session_start();

  //$studentData = $_SESSION['studentData'];

      $page_title = "My Profile";
      // Core
      require_once("../core/wp_config.php");

      if (!(isset($_SESSION['app_login']) && $_SESSION['app_login'] != '' && $_SESSION['app_login'] == 'student')) {
          header ("Location: login.php");
      }
      // Header
      //require_once("includes/header.php");
      // Navigation
      require_once("../nav/student_nav.php");





      require_once("../includes/funaabWS.php");
      require_once("../includes/ws_functions.php");
      require_once("../includes/ws_parameters.php");

      //require_once("../classes/StudentManuals.php");
      //require_once("../classes/Collection.php");
      //require_once("../classes/Payment.php");


      //-------------- flag and message variables declared and initialized -------------------------------
      $err_flag = 0;
      $err_msg = null;
      $message = "";
      $info = '';

      //------------------------- Student Data ----------------------------------------------------------
      $studentData = $_SESSION['studentData'];
      $matric_no = $studentData['regNumber'];
      $surname = $studentData['surname'];
      $firstname = $studentData['firstname'];
      $othername = $studentData['othername'];
      $email = $studentData['email'];
      $emailFunaab = $studentData['funaabEmail'];
      $phone = $studentData['phone'];
      $photo = $studentData['photo'];
      $collegeCode  = $studentData['collegeCode'];
      $deptCode = $studentData['deptCode'];
      $level  = $studentData['level'];

      //------------------------- End of Student Data --------------------------------------------------



 ?>

<div class="container">


    <div class="row border" style="margin-top:20px;">
      <div class="col-xs-12 col-sm-12 col-md-8 col-lg-12 py-3 mb-1 border-bottom ">
        <?php

            echo "<div class=''><strong>Welcome, </strong>".$surname." ".$firstname." ".$othername."</div>";

        ?>
      </div>


      <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8 mt-4">

          <h3>My Profile </h3>
          <div class="table-responsive">
              <table class="table table-striped">

                <tbody>
                  <tr><td width='20%'><strong>Matric No.</strong></td><td><?php echo $matric_no; ?></td></tr>
                  <tr><td width='20%'><strong>Surname</strong></td><td><?php echo $surname; ?></td></tr>
                  <tr><td width='20%'><strong>Firstname</strong></td><td><?php echo $firstname; ?></td></tr>
                  <tr><td width='20%'><strong>Othername</strong></td><td><?php echo $othername; ?></td></tr>
                  <tr><td width='20%'><strong>Email</strong></td><td><?php echo $email; ?></td></tr>
                  <tr><td width='20%'><strong>FUNAAB Email</strong></td><td><?php echo $emailFunaab; ?></td></tr>
                  <tr><td width='20%'><strong>Phone</strong></td><td><?php echo $phone; ?></td></tr>
                  <tr><td width='20%'><strong>College Code</strong></td><td><?php echo $collegeCode; ?></td></tr>
                  <tr><td width='20%'><strong>Dept Code</strong></td><td><?php echo $deptCode; ?></td></tr>
                  <tr><td width='20%'><strong>Level</strong></td><td><?php echo $level; ?></td></tr>





                </tbody>
              </table>
        </div> <!-- end of table div //-->

      </div><!-- end of second column //-->

      <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 mt-4 text-center" style='background-color:#f9f9f9'>
          <?php
              echo "<div class='avatar mx-auto white mt-5'><img src='{$user_photo}' alt='avatar mx-auto white' class='rounded-circle img-fluid border'></div> ";

          ?>

      </div>





    </div><!-- end of row //-->


</div><!-- end of container //-->

<input id='matric_no' type='hidden' value="<?php echo $matric_no; ?>" />
<br/><br/>
<?php
      //footer
      require_once("../includes/footer.php");
 ?>
<script>

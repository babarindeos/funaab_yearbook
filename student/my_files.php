<?php

  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);
  //session_start();






      $page_title = "Clearance for Students";

      // Core
      require_once("../core/wp_config.php");


      // authentication
      if (!(isset($_SESSION['app_login']) && $_SESSION['app_login'] != '' && $_SESSION['app_login'] == 'student')) {
          header ("Location: ../index.php");
      }


      // classes
      require_once("../classes/StudentClearance.php");
      require_once("../classes/Department.php");
      require_once("../classes/Payment.php");



      // Header
      //require_once("includes/header.php");


      // Navigation

      // Portal WebServices integrated
      require_once("../nav/student_nav.php");

      require_once("../includes/funaabWS.php");
      require_once("../includes/ws_functions.php");
      require_once("../includes/ws_parameters.php");


  //----------------------- Student Data -------------------------------------------------------------
      //Initialise
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

//----------------------- End of Student Data --------------------------------------------------------







?>




<div class="container">


    <div class="row" style="margin-top:20px;">





        <!-- Heading pane //-->
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
          <h4 class='mb-4'>Clearance for Students Withdrawing/Graduating from the University<br><small>2019/2020 Academic Session</small></h4>

          <hr>
          <!-- Salutation //-->
          <?php

              echo "<div class='mb-2'><strong>Welcome, </strong>".$surname." ".$firstname." ".$othername."</div>";

          ?>
        </div>
        <!-- Clearance form //-->
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-3">

        </div>
    </div>
</div>

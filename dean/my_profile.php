<?php

  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);
  //session_start();

  //$studentData = $_SESSION['studentData'];

      $page_title = "My Profile";
      // Core
      require_once("../core/wp_config.php");

      if (!(isset($_SESSION['app_login']) && $_SESSION['app_login'] != '' && $_SESSION['app_login'] == 'dean')) {
          header ("Location: ../deanLogin.php");
      }
      // Header
      //require_once("includes/header.php");
      // Navigation
      require_once("../nav/dean_nav.php");





      //require_once("../includes/funaabWS.php");
      //require_once("../includes/ws_functions.php");
      //require_once("../includes/ws_parameters.php");

      //require_once("../classes/StudentManuals.php");
      //require_once("../classes/Collection.php");
      //require_once("../classes/Payment.php");


      //-------------- flag and message variables declared and initialized -------------------------------
      $err_flag = 0;
      $err_msg = null;
      $message = "";
      $info = '';

      //------------------------- Student Data ----------------------------------------------------------
      //$studentData = $_SESSION['studentData'];
      //$matric_no = $studentData['regNumber'];
      $fullname = $_SESSION['auth_fullname'];
      $file_no = $_SESSION['auth_username'];


      //------------------------- End of Student Data --------------------------------------------------

      $college = new College();
      $get_college = $college->get_colleges_by_id($_SESSION['auth_college']);

      $dean_college = $get_college->fetch(PDO::FETCH_ASSOC);
      $dean_college = $dean_college['college_name'];


      //------------------------------------------------------------------------------------------------


 ?>

<div class="container">


    <div class="row border" style="margin-top:20px;">
      <div class="col-xs-12 col-sm-12 col-md-8 col-lg-12 py-3 mb-1 border-bottom ">
        <?php

            echo "<div class=''><strong>Welcome, </strong>".$fullname."</div>";

        ?>
      </div>


      <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8 mt-4">

          <h3>My Profile </h3>
          <div class="table-responsive">
              <table class="table table-striped">

                <tbody>
                  <tr><td width='20%'><strong>File No</strong></td><td><?php echo $file_no; ?></td></tr>
                  <tr><td width='20%'><strong>Names</strong></td><td><?php echo $fullname; ?></td></tr>
                  <tr><td width='20%'><strong>College</strong></td><td><?php echo $dean_college; ?></td></tr>

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

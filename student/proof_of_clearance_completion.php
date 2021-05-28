<?php



if (!isset($_GET['q']) || $_GET['q']==''){
      header("location: clearance_form.php");
}

if (!isset($_GET['m']) || $_GET['m']==''){
      header("location: clearance_form.php");
}

if (!isset($_GET['z']) || $_GET['z']==''){
      header("location: clearance_form.php");
}

if (!isset($_GET['v']) || $_GET['v']==''){
      header("location: clearance_form.php");
}


//$_GET_URL_matric_no = explode("-",htmlspecialchars(strip_tags($_GET['m'])));
//$_GET_URL_matric_no = $_GET_URL_matric_no[1];

$_GET_URL_matric_no = trim($_GET['m']);

//$_GET_URL_verification_code = explode("-",htmlspecialchars(strip_tags($_GET['v'])));
//$_GET_URL_verification_code = $_GET_URL_verification_code[1];

$_GET_URL_verification_code = trim($_GET['v']);




      $page_title = "Proof of Clearance Completion";

      // Core
      require_once("../core/wp_config.php");

      require_once('../lib/vendor/autoload.php');


      // authentication
      if (!(isset($_SESSION['app_login']) && $_SESSION['app_login'] != '' && $_SESSION['app_login'] == 'student')) {
          header ("Location: ../index.php");
      }


      // classes
      require_once("../classes/StudentClearance.php");
      require_once("../classes/Department.php");
      require_once("../classes/Payment.php");



  //------------------ Clearance Completed --------------------------------------------------

      $clearance = new StudentClearance();
      $is_clearance_completed = $clearance->is_clearance_completed($_GET_URL_matric_no);


      //echo $is_clearance_completed->rowCount();
      if ($is_clearance_completed->rowCount()==0){
          echo "<div class='mt-5 text-center'><h3>No such record exist. Please contact the Site Administrator.</h3></div>";
          exit;
          die;
      }else{
          $recordSet = $is_clearance_completed->fetch(PDO::FETCH_ASSOC);
          $qr_code = $recordSet['qr_code'];
          $qr_code = 'images/qrcode/'.$qr_code;

      }



  //----------------------- Student Data ----------------------------------------------------
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

//----------------------- End of Student Data -----------------------------------------------



//----------------------- Currently active academic session ---------------------------------

        $academic_session = new AcademicSession();
        $get_current_active_session = $academic_session->get_active_session();
        $get_current_active_session = $get_current_active_session->fetch(PDO::FETCH_ASSOC);

        $current_active_session = $get_current_active_session['session'];





//---------------------- End of Academic Session --------------------------------------------

        $user_photo = '';
        if ($studentData['photo']==''){
          $user_photo = $baseUrl."images/avatars/avatar-2.jpg";
        }else{
          $user_photo = substr($studentData['photo'],1);
          $user_photo = "https://portal.unaab.edu.ng{$user_photo}";
        }
//----------------------  End of User Photo ---------------------------------------------------------



?>




<div class="container border rounded py-2 z-depth-5 mt-2">

    <!-- header //-->
    <div class="row text-center" style="margin-top:20px;">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
                <img width='7%' src="<?php echo $baseUrl; ?>assets/images/FUNAAB-Logosm.png" class="d-inline-block align-middle">
                <div style='font-size:25px; font-weight:bold;'>FEDERAL UNIVERSITY OF AGRICULTURE, ABEOKUTA</div>
                <div style='font-size:25px; margin-top:-10px; font-weight:bold;' class='mb-3'>(EXAMINATIONS AND RECORDS UNIT)</div>
                <h5><strong>Proof of Clearance Completion</strong></h5>
        </div>
    </div>
    <!-- end of header //-->


    <!-- Student Profile //-->
    <div class="row" style="margin-top:20px;">
          <!-- Photo //-->
          <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 text-right">
              <?php
                  echo "<div class='avatar mx-auto white mt-3'><img src='{$user_photo}' alt='{$surname}' width='150px' class='rounded img-fluid border z-depth-1'></div> ";
              ?>
          </div>
          <!-- end of photo //-->

          <!-- Student Data //-->
          <div class="col-xs-12 col-sm-12 col-md-7 col-lg-7 mt-3">
                <div style='border-bottom:1px solid #f1f1f1; font-weight:400;' class='py-1 px-3'><big><?php echo $matric_no;  ?></big></div>
                <div style='border-bottom:1px solid #f1f1f1;font-weight:300; ' class='py-1 px-3'><big><?php echo $surname.' '.$firstname.' '.$othername; ?></big></div>
                <div style='border-bottom:1px solid #f1f1f1; font-weight:300;' class='py-1 px-3'><big><?php echo $emailFunaab;  ?></big></div>
                <div style='border-bottom:1px solid #f1f1f1; font-weight:300;' class='py-1 px-3'><big><?php echo $phone;  ?></big></div>
                <div style='border-bottom:1px solid #f1f1f1; font-weight:300;' class='py-1 px-3'><big><?php echo $deptCode.', '.$collegeCode;  ?></big></div>

          </div>
          <!-- end of Data //-->

          <!-- QR Code //-->
          <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 mt-4">
              <?php
                    //http://localhost/students_clearance/student/images/qrcode/20152664_6081250fcbcb7.png
                    echo "<img src='{$qr_code}' class='rounded img-fluid border' />";

              ?>

          </div>
          <!-- End of QR Code //-->

    </div>
    <!-- end of Student Profile //-->

    <!-- Cleared Units //-->
    <div class="row mt-3 px-3">
          <div class='table-responsive mr-'>
                <table class='table table-striped'>
                      <thead>
                          <tr>
                              <th scope="col"><big>DEPARTMENT/DIVISION</big></th>
                              <th scope="col" class='text-center'><big>STATUS</big></th>
                          </tr>
                      </thead>
                      <tbody>
                          <tr >
                                <td><big>Department/Programme</big></td><td class='text-center'><i class="far fa-check-square fa-2x text-success"></i></td>
                          </tr>
                          <tr>
                                <td><big>Library</big></td><td class='text-center'><i class="far fa-check-square fa-2x text-success"></i></td>
                          </tr>
                          <tr>
                                <td><big>Health Center</big></td><td class='text-center'><i class="far fa-check-square fa-2x text-success"></i></td>
                          </tr>
                          <tr>
                                <td><big>Bursary</big></td><td class='text-center'><i class="far fa-check-square fa-2x text-success"></i></td>
                          </tr>
                          <tr>
                                <td><big>Directorate of Sports</big></td><td class='text-center'><i class="far fa-check-square fa-2x text-success"></i></td>
                          </tr>
                          <tr>
                                <td><big>Office of Advancement</big></td><td class='text-center'><i class="far fa-check-square fa-2x text-success"></i></td>
                          </tr>
                          <tr>
                                <td><big>Students Affairs Office</big></td><td class='text-center'><i class="far fa-check-square fa-2x text-success"></i></td>
                          </tr>
                          <tr>
                                <td><big>Alumni</big></td><td class='text-center'><i class="far fa-check-square fa-2x text-success"></i></td>
                          </tr>
                          <tr>
                                <td><big>Exams and Records Office</big></td><td class='text-center'><i class="far fa-check-square fa-2x text-success"></i></td>
                          </tr>

                      </tbody>
                </table>
          </div>

    </div>
    <!-- End of cleared Units//-->

    <!-- barcode //-->
    <div class="row mb-4 mt-4 ">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right">
              <?php
                     $bar_code = $clearance->generate_bar_code($matric_no, $surname);
                     echo $bar_code;
              ?>
        </div>
    </div>
    <!-- end of barcode //-->

</div>

<?php

      $page_title = "Login";
      // Core
      require_once("core/config.php");
      // Header
      require_once("includes/header.php");
      // Navigation
      require_once("nav/nav_login.php");




      $err_flag = 0;
      $err_msg = null;
      if (isset($_POST['formLogin'])){
          $username = FieldSanitizer::inClean($_POST['loginUsername']);
          $password = FieldSanitizer::inClean($_POST['loginPassword']);

          if (($username != "") || ($password != "")){

              $auth = new Auth();
              $stmt = $auth->login($username, $password);
              $recordFound = $stmt->rowCount();
              if ($recordFound){

                  // login succeeds
                  $row = $stmt->fetch(PDO::FETCH_ASSOC);

                  //Start session
                  session_start();
                  $_SESSION['ulogin_state'] = 200;
                  $_SESSION['ulogin_id'] = $row['id'];
                  $_SESSION['ulogin_userid'] = $row['user_id'];
                  $_SESSION['ulogin_role'] = $row['role'];
                  $_SESSION['ulogin_fileno'] = $row['file_no'];
                  $_SESSION['ulogin_email'] = $row['email'];


                  //Redirect to appropriate dashboard
                  if ($_SESSION['ulogin_role']=='admin'){
                      header("location: cadmin/admin_dashboard.php");
                  }
                  elseif($_SESSION['ulogin_role']=='hod'){
                      header("location: hod/hod_dashboard.php");
                  }elseif($_SESSION['ulogin_role']=='staff'){
                      header("location: staff/my_dashboard.php");
                  }


              }else{
                 // login fails
                 $err_flag = 1;
                 $err_msg = "Invalid login credentials";
              }

          }else{
              $err_msg = "Username and Password are required.";
              $err_flag = 1;
          }

      }



 ?>

 <div class="container-fluid">
    <div class="row" style="margin-top:20px;">

      <!-- left pane //-->
      <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
           <div class="row"><!-- row //-->
                     <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 text-center" style="background-color:#ffffff;padding:2px;">
                             <img src="assets/images/siwes_director.jpg"><div class='font-weight-bold mt-1'>Prof. Francisca George</div>
                     </div>
                     <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9 text-justify" >
                             <h3 class="mt-4 mb-3">From the Director's Desk</h3>
                             Welcome to the SIWES Portal, Federal University of Agriculture, Abeokuta (FUNAAB).
                             This Platform became necessary due to the myriad of challenges being encountered in
                             strategies being deployed previously in managing the Students’ Industrial Work
                             Experience Scheme within and outside the University.
                             <br/><br/>
                             The SIWES Portal is an innovative platform developed by the SIWES Directorate,
                             FUNAAB for the effective enrolment of eligible students for SIWES and the
                             management of all activities involved in their SIWES experience. <br/>

                             <br/>
                             Using this new Platform, the Directorate aims to:
                             <br/><br/>
                             <ul>
                               <li class='mb-3'>Seamlessly create and submit required data on eligible students to the National Universities Commission, NUC (the Body entrusted with the supervision of academic activities of Universities in Nigeria) and the
                                  Industrial Training Fund (the Organization that manages training and Industrial activities in Nigeria)</li>
                                <li class='mb-3'>Supervise, and ensure that all students enrolled for SIWES effectively acquire the necessary skills and experiences they are exposed to during the Programme</li>
                                <li class='mb-3'>Document the Industrial Training experiences of Students</li>
                                <li class='mb-3'>Collate feedback from all Stakeholders (students, Lecturers, Industry, parents, NUC and ITF) towards the enhancement of the SIWES experience for Stakeholders.</li>
                             </ul>

                             <br/>
                             Thank you.








                     </div>

           </div><!-- end of row //-->
      </div>
      <!-- end of left pane //-->

      <!-- right pane //-->
      <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">

      </div><!-- end of columm //-->
      <!-- end of right pane //-->



    </div><!-- end of row //-->
</div><!-- end of container //-->

<br/><br/>
<?php
      //footer
      require_once("includes/footer.php");
 ?>

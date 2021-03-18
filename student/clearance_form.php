<?php

  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);
  //session_start();






      $page_title = "Clearance for Students";

      // Core
      require_once("../core/wp_config.php");

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

       // matric_no = "15064";





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

          <!--Accordion wrapper-->
          <div class="accordion md-accordion accordion-blocks" id="accordionEx78" role="tablist"
                aria-multiselectable="true">

                    <!-- **************** Accordion card - Department/Programme ************************************ -->
                    <?php
                          $division_id = 1;
                          $clearance = new StudentClearance();
                          $get_dept_clearance = $clearance->get_checkin_status($division_id, $matric_no);

                          $clearance_value = $get_dept_clearance;

                          $division_header_icon = "dept_header_icon";
                          include("../functions/Clearance_Status.php");

                    ?>
                    <div class="card">

                            <!--  Card header  -->
                            <div class="card-header" role="tab" id="headingUnfiled">

                                  <!--Options/ Icon-->
                                  <div class="dropdown float-left">
                                        <button id='btn_dept_header' title="<?php echo $title; ?>" class="btn btn-sm m-0 mr-3 p-2 <?php echo $button_color; ?>" type="button" data-toggle="dropdown"
                                          aria-haspopup="true" aria-expanded="false"><?php echo $button_icon; ?>
                                        </button>
                                  </div>

                                  <!-- Heading -->
                                  <a data-toggle="collapse" data-parent="#accordionEx78" href="#collapseUnfiled" aria-expanded="true"
                                    aria-controls="collapseUnfiled">
                                    <h5 class="mt-1 mb-0">
                                      <span>Department/Programme</span>
                                      <i class="fas fa-angle-down rotate-icon"></i>
                                    </h5>
                                  </a>

                            </div>
                            <!--  end of Card Header //-->

                            <!--  Card body  -->
                            <div id="collapseUnfiled" class="collapse" role="tabpanel" aria-labelledby="headingUnfiled"
                                  data-parent="#accordionEx78">
                                  <div class="card-body">

                                      <?php
                                            require_once("department_programme.php");
                                      ?>

                                  </div>
                            </div>
                            <!--  End of Card body -->
                    </div>
                    <!-- ****************************** Accordion card - Department/Programme ****************************** -->

                    <!-- ***************************** Accordion card - Library  ******************************************************-->
                    <?php
                          $division_id = 2;
                          $clearance = new StudentClearance();
                          $get_library_clearance = $clearance->get_checkin_status($division_id, $matric_no);

                          $clearance_value = $get_library_clearance;

                          $division_header_icon = "library_header_icon";
                          include("../functions/Clearance_Status.php");

                    ?>
                    <div class="card">

                            <!--  Card header -->
                            <div class="card-header" role="tab" id="heading79">

                                  <!--Options-->
                                  <div class="dropdown float-left">
                                      <button id='btn_library_header' title="<?php echo $title; ?>"  class="btn btn-sm m-0 mr-3 p-2 <?php echo $button_color; ?>" type="button" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false"><?php echo $button_icon; ?>
                                      </button>

                                  </div><!-- end of Options //-->

                                  <!-- Heading -->
                                  <a data-toggle="collapse" data-parent="#accordionEx78" href="#collapse79" aria-expanded="true"
                                    aria-controls="collapse79">
                                      <h5 class="mt-1 mb-0">
                                        <span>Library</span>
                                        <i class="fas fa-angle-down rotate-icon"></i>
                                      </h5>
                                  </a><!-- end of Heading //-->

                            </div>
                            <!--   End of Card header  //-->

                            <!-- Card body -->
                            <div id="collapse79" class="collapse" role="tabpanel" aria-labelledby="heading79"
                              data-parent="#accordionEx78">
                              <div class="card-body">
                                      <?php
                                            require_once("library.php");
                                      ?>


                              </div>
                            </div>
                            <!-- End of Card body //-->
                    </div>
                    <!-- **************************** End of Accordion card - Library ***************** //-->

                    <!-- **************************** Accordion card - Health Centre ****************** //-->
                    <?php
                          $division_id = 3;
                          $clearance = new StudentClearance();
                          $get_health_center_clearance = $clearance->get_checkin_status($division_id, $matric_no);

                          $clearance_value = $get_health_center_clearance;

                          $division_header_icon = "health_center_header_icon";
                          include("../functions/Clearance_Status.php");

                    ?>
                    <div class="card">

                            <!-- Card header -->
                            <div class="card-header" role="tab" id="heading80">
                                  <!--Options-->
                                  <div class="dropdown float-left">
                                    <button id='btn_health_center_header'  title="<?php echo $title; ?>" class="btn btn-sm m-0 mr-3 p-2 <?php echo $button_color; ?>" type="button" data-toggle="dropdown"
                                      aria-haspopup="true" aria-expanded="false"><?php echo $button_icon; ?>
                                    </button>
                                  </div><!-- end of options //-->

                                  <!-- Heading -->
                                  <a data-toggle="collapse" data-parent="#accordionEx78" href="#collapse80" aria-expanded="true"
                                    aria-controls="collapse80">
                                    <h5 class="mt-1 mb-0">
                                      <span>Health Centre</span>
                                      <i class="fas fa-angle-down rotate-icon"></i>
                                    </h5>
                                  </a><!-- end of heading //-->
                            </div><!-- end of Card header //-->

                            <!-- Card body -->
                                <div id="collapse80" class="collapse" role="tabpanel" aria-labelledby="heading80"
                                  data-parent="#accordionEx78">
                                  <div class="card-body">
                                      <?php
                                          require_once("health_center.php");
                                      ?>

                                  </div>
                                </div>
                      </div>
                      <!-- ******************************** Accordion card - Health Centre ******************************************* -->

                      <!-- ********************************* Accordion card - Bursary  *********************************************** -->
                      <?php
                            $division_id = 4;
                            $clearance = new StudentClearance();
                            $get_bursary_clearance = $clearance->get_checkin_status($division_id, $matric_no);

                            $clearance_value = $get_bursary_clearance;

                            $division_header_icon = "bursary_header_icon";
                            include("../functions/Clearance_Status.php");

                      ?>
                      <div class="card">

                                  <!-- Card header -->
                                  <div class="card-header" role="tab" id="heading">
                                        <!--Options-->
                                        <div class="dropdown float-left">
                                          <button id='btn_bursary_header' title="<?php echo $title; ?>" class="btn btn-sm m-0 mr-3 p-2 <?php echo $button_color; ?>" type="button" data-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="false"><?php echo $button_icon; ?>
                                          </button>
                                        </div>

                                        <!-- Heading -->
                                        <a data-toggle="collapse" data-parent="#accordionEx78" href="#collapse81" aria-expanded="true"
                                          aria-controls="collapse81">
                                          <h5 class="mt-1 mb-0">
                                            <span>Bursary</span>
                                            <i class="fas fa-angle-down rotate-icon"></i>
                                          </h5>
                                        </a>
                                  </div><!-- end of Card header //-->

                                  <!-- Card body -->
                                  <div id="collapse81" class="collapse" role="tabpanel" aria-labelledby="heading"
                                    data-parent="#accordionEx78">
                                    <div class="card-body">
                                          <?php
                                                require_once("bursary.php");
                                          ?>

                                    </div>
                              </div>
                        </div>
                        <!--********************************** Accordion card - Bursary ****************************** -->


                        <!-- ********************************* Accordion card - Directorate of Sports  *********************************************** -->
                        <?php
                              $division_id = 5;
                              $clearance = new StudentClearance();
                              $get_sports_clearance = $clearance->get_checkin_status($division_id, $matric_no);

                              $clearance_value = $get_sports_clearance;

                              $division_header_icon = "sports_header_icon";
                              include("../functions/Clearance_Status.php");

                        ?>
                        <div class="card">

                                    <!-- Card header -->
                                    <div class="card-header" role="tab" id="heading92">
                                          <!--Options-->
                                          <div class="dropdown float-left">
                                            <button id='btn_sports_header' title="<?php echo $title; ?>" class="btn btn-sm m-0 mr-3 p-2 <?php echo $button_color; ?>" type="button" data-toggle="dropdown"
                                              aria-haspopup="true" aria-expanded="false"><?php echo $button_icon; ?>
                                            </button>
                                          </div>

                                          <!-- Heading -->
                                          <a data-toggle="collapse" data-parent="#accordionEx78" href="#collapse82" aria-expanded="true"
                                            aria-controls="collapse82">
                                            <h5 class="mt-1 mb-0">
                                              <span>Directorate of Sports</span>
                                              <i class="fas fa-angle-down rotate-icon"></i>
                                            </h5>
                                          </a>
                                    </div><!-- end of Card header //-->

                                    <!-- Card body -->
                                    <div id="collapse82" class="collapse" role="tabpanel" aria-labelledby="heading92"
                                      data-parent="#accordionEx78">
                                      <div class="card-body">
                                          <?php
                                                require_once("sports.php");
                                          ?>


                                      </div>
                                </div>
                          </div>
                          <!--********************************** Accordion card - Directorate of Sports ****************************** -->


                          <!-- ********************************* Accordion card - Office of Advancement  *********************************************** -->
                          <?php
                                $division_id = 6;
                                $clearance = new StudentClearance();
                                $get_advancement_clearance = $clearance->get_checkin_status($division_id, $matric_no);

                                $clearance_value = $get_advancement_clearance;

                                $division_header_icon = "advancement_header_icon";
                                include("../functions/Clearance_Status.php");

                          ?>
                          <div class="card">

                                      <!-- Card header -->
                                      <div class="card-header" role="tab" id="heading84">
                                            <!--Options-->
                                            <div class="dropdown float-left">
                                              <button id='btn_advancement_header' title="<?php echo $title; ?>" class="btn btn-sm m-0 mr-3 p-2 <?php echo $button_color; ?>" type="button" data-toggle="dropdown"
                                                aria-haspopup="true" aria-expanded="false"><?php echo $button_icon; ?>
                                              </button>
                                            </div>

                                            <!-- Heading -->
                                            <a data-toggle="collapse" data-parent="#accordionEx78" href="#collapse84" aria-expanded="true"
                                              aria-controls="collapse84">
                                              <h5 class="mt-1 mb-0">
                                                <span>Office of Advancement</span>
                                                <i class="fas fa-angle-down rotate-icon"></i>
                                              </h5>
                                            </a>
                                      </div><!-- end of Card header //-->

                                      <!-- Card body -->
                                      <div id="collapse84" class="collapse" role="tabpanel" aria-labelledby="heading84"
                                        data-parent="#accordionEx78">
                                        <div class="card-body">
                                              <?php
                                                    require_once("advancement.php");
                                              ?>


                                        </div>
                                  </div>
                            </div>
                            <!--********************************** Accordion card - Office of Advancement ****************************** -->

                            <!-- ********************************* Accordion card - Student Affairs Office  *********************************************** -->
                            <div class="card">

                                        <!-- Card header -->
                                        <div class="card-header" role="tab" id="heading85">
                                              <!--Options-->
                                              <div class="dropdown float-left">
                                                <button class="btn btn-info btn-sm m-0 mr-3 p-2" type="button" data-toggle="dropdown"
                                                  aria-haspopup="true" aria-expanded="false"><i class="fas fa-question"></i>
                                                </button>
                                              </div>

                                              <!-- Heading -->
                                              <a data-toggle="collapse" data-parent="#accordionEx78" href="#collapse85" aria-expanded="true"
                                                aria-controls="collapse85">
                                                <h5 class="mt-1 mb-0">
                                                  <span>Student Affair Office</span>
                                                  <i class="fas fa-angle-down rotate-icon"></i>
                                                </h5>
                                              </a>
                                        </div><!-- end of Card header //-->

                                        <!-- Card body -->
                                        <div id="collapse85" class="collapse" role="tabpanel" aria-labelledby="heading85"
                                          data-parent="#accordionEx78">
                                          <div class="card-body">
                                              <?php
                                                    require_once("student_affairs.php");
                                              ?>


                                          </div>
                                    </div>
                              </div>
                              <!--********************************** Accordion card - Student Affairs Office ****************************** -->

                              <!-- ********************************* Accordion card - Alumni  *********************************************** -->
                              <div class="card">

                                          <!-- Card header -->
                                          <div class="card-header" role="tab" id="heading86">
                                                <!--Options-->
                                                <div class="dropdown float-left">
                                                  <button class="btn btn-info btn-sm m-0 mr-3 p-2" type="button" data-toggle="dropdown"
                                                    aria-haspopup="true" aria-expanded="false"><i class="fas fa-question"></i>
                                                  </button>
                                                </div>

                                                <!-- Heading -->
                                                <a data-toggle="collapse" data-parent="#accordionEx78" href="#collapse86" aria-expanded="true"
                                                  aria-controls="collapse86">
                                                  <h5 class="mt-1 mb-0">
                                                    <span>Alumni</span>
                                                    <i class="fas fa-angle-down rotate-icon"></i>
                                                  </h5>
                                                </a>
                                          </div><!-- end of Card header //-->

                                          <!-- Card body -->
                                          <div id="collapse86" class="collapse" role="tabpanel" aria-labelledby="heading86"
                                            data-parent="#accordionEx78">
                                            <div class="card-body">



                                            </div>
                                      </div>
                                </div>
                                <!--********************************** Accordion card - Alumni ****************************** -->



                </div>
                <!--/.Accordion wrapper-->

        </div>
        <!-- end of Clearance form //-->

      </div><!-- end of row //-->




  </div><!-- end of container //-->

        <input id='matric_no' type='hidden' value="<?php echo $matric_no; ?>" />
        <!-- <input id='matric_no' type='hidden' value="15064" /> //-->
        <br/><br/>
        <?php
              //footer
              require_once("../includes/footer.php");
         ?>


<script src="../async/client/department_programme/department_programme.js"></script>
<script src="../async/client/library/library_checkin.js"></script>
<script src="../async/client/health_center/health_center_checkin.js"></script>
<script src="../async/client/bursary/bursary_checkin.js"></script>
<script src="../async/client/sports/sports_checkin.js"></script>
<script src="../async/client/advancement/advancement_checkin.js"></script>

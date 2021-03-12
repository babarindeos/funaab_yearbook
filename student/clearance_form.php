<?php

  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);
  //session_start();

      $matric_no = "20162251";

  //$studentData = $_SESSION['studentData'];

      $page_title = "Clearance for Students";
      // Core
      require_once("../core/wp_config.php");

      // if (!(isset($_SESSION['app_login']) && $_SESSION['app_login'] != '')) {
      //     header ("Location: ../index.php");
      // }

      // Header
      //require_once("includes/header.php");
      // Navigation
      require_once("../nav/student_nav.php");

      require_once("../includes/funaabWS.php");
      require_once("../includes/ws_functions.php");
      require_once("../includes/ws_parameters.php");




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
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

          <!--Accordion wrapper-->
          <div class="accordion md-accordion accordion-blocks" id="accordionEx78" role="tablist"
                aria-multiselectable="true">

                    <!-- **************** Accordion card - Department/Programme ************************************ -->
                    <div class="card">

                            <!--  Card header  -->
                            <div class="card-header" role="tab" id="headingUnfiled">

                                  <!--Options/ Icon-->
                                  <div class="dropdown float-left">
                                        <button class="btn btn-info btn-sm m-0 mr-3 p-2" type="button" data-toggle="dropdown"
                                          aria-haspopup="true" aria-expanded="false"><i class="fas fa-question"></i>
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
                    <div class="card">

                            <!--  Card header -->
                            <div class="card-header" role="tab" id="heading79">

                                  <!--Options-->
                                  <div class="dropdown float-left">
                                      <button class="btn btn-info btn-sm m-0 mr-3 p-2" type="button" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false"><i class="fas fa-question"></i>
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



                              </div>
                            </div>
                            <!-- End of Card body //-->
                    </div>
                    <!-- **************************** End of Accordion card - Library ***************** //-->

                    <!-- **************************** Accordion card - Health Centre ****************** //-->
                    <div class="card">

                            <!-- Card header -->
                            <div class="card-header" role="tab" id="heading80">
                                  <!--Options-->
                                  <div class="dropdown float-left">
                                    <button class="btn btn-info btn-sm m-0 mr-3 p-2" type="button" data-toggle="dropdown"
                                      aria-haspopup="true" aria-expanded="false"><i class="fas fa-question"></i>
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


                                  </div>
                                </div>
                      </div>
                      <!-- ******************************** Accordion card - Health Centre ******************************************* -->

                      <!-- ********************************* Accordion card - Bursary  *********************************************** -->
                      <div class="card">

                                  <!-- Card header -->
                                  <div class="card-header" role="tab" id="heading">
                                        <!--Options-->
                                        <div class="dropdown float-left">
                                          <button class="btn btn-info btn-sm m-0 mr-3 p-2" type="button" data-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="false"><i class="fas fa-question"></i>
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



                                    </div>
                              </div>
                        </div>
                        <!--********************************** Accordion card - Bursary ****************************** -->


                        <!-- ********************************* Accordion card - Directorate of Sports  *********************************************** -->
                        <div class="card">

                                    <!-- Card header -->
                                    <div class="card-header" role="tab" id="heading92">
                                          <!--Options-->
                                          <div class="dropdown float-left">
                                            <button class="btn btn-info btn-sm m-0 mr-3 p-2" type="button" data-toggle="dropdown"
                                              aria-haspopup="true" aria-expanded="false"><i class="fas fa-question"></i>
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



                                      </div>
                                </div>
                          </div>
                          <!--********************************** Accordion card - Directorate of Sports ****************************** -->


                          <!-- ********************************* Accordion card - Office of Advancement  *********************************************** -->
                          <div class="card">

                                      <!-- Card header -->
                                      <div class="card-header" role="tab" id="heading84">
                                            <!--Options-->
                                            <div class="dropdown float-left">
                                              <button class="btn btn-info btn-sm m-0 mr-3 p-2" type="button" data-toggle="dropdown"
                                                aria-haspopup="true" aria-expanded="false"><i class="fas fa-question"></i>
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
        <br/><br/>
        <?php
              //footer
              require_once("../includes/footer.php");
         ?>

<script>

$(document).ready(function(){

  //--------------------------------- Department /Programme //------------------------
      $("#btn_department_programme").on("click",function(){
          var division_id = 1;
          var matric_no = $("#matric_no").val();



          //----------------- Ajax -------------------------------------
          //------------- --------- Ajax call ------------------------------------
          $.ajax({
              url: '../async/server/clearance/checkin.php',
              method: "POST",
              data: {division_id: division_id, matric_no: matric_no},
              cache: false,
              beforeSend: function(){},
              success: function(data){
                  //$("#my_shopping_cart_pane").html(data);
                  if (data==1){
                      $("#department_programme_pane").html("<h2>Awaiting Response. Please check back for feedback</h2>");
                  }else{
                     alert("An error occurred. Please try again.");
                  }
              }
          })
          //------------------------ End of Ajax call ----------------------------
          //----------------- End of Ajax -----------------------------
      });
  //---------------------------------- End of Department Programme ------------------------
});



</script>

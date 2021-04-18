<?php

  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);
  //session_start();



      $page_title = "Clearance for Students";
      // Core
      require_once("../core/wp_config.php");

      if (!(isset($_SESSION['app_login']) && $_SESSION['app_login'] != '' && $_SESSION['app_login'] == 'staff')) {
          header ("Location: ../index.php");
      }

      // Header
      //require_once("includes/header.php");
      // Navigation
      require_once("../nav/staff_nav.php");

      //require_once("../includes/funaabWS.php");
      //require_once("../includes/ws_functions.php");
      //require_once("../includes/ws_parameters.php");


      $clearance = new StudentClearance();
      $awaiting_clearance = $clearance->awaiting_clearance_in_unit($_SESSION['unit_id'])->rowCount();

      $approved_clearance = $clearance->approved_clearance_in_unit($_SESSION['unit_id'])->rowCount();

      $declined_clearance = $clearance->declined_clearance_in_unit($_SESSION['unit_id'])->rowCount();

      $total_submission = $awaiting_clearance + $approved_clearance + $declined_clearance;

?>




<div class="container">


    <div class="row" style="margin-top:20px;">





      <!-- Heading pane //-->
      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-3">
          <h4 class='mb-4'>Clearance for Students Withdrawing/Graduating from the University<br><small>2019/2020 Academic Session</small></h4>

          <hr>
          <!-- Salutation //-->
          <h2>Dashboard</h2>
          <?php
          echo "<div class='mb-4'><big>".$_SESSION['unit_name']."</big></div>";

              echo "<div class=' col-mb-0'><strong>Welcome, </strong>".$_SESSION['names']."</div>";


          ?>
        </div>


    </div> <!-- end of row //-->

    <!-- row //-->
    <div class="row">

                    <!-- Total Submission //-->
                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 py-3 px-2">
                          <a id='total_submissions' class='project_progress_status' title='See Total Submissions' href="clearing_division.php">
                                <div class="card primary-color order-card z-depth-2">
                                              <div class="card-body">
                                                  <h6 class="text-white">Total Submissions</h6>
                                                  <h2 class="text-right text-white">
                                                    <i class="far fa-copy float-left"></i><span><?php echo number_format($total_submission); ?></span>
                                                  </h2>
                                              </div>
                                </div>
                          </a>
                    </div>
                    <!-- end of Total Submission  //-->

                    <!-- Awaiting clearance //-->
                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 py-3 px-2">
                          <a id='awaiting_clearance' class='project_progress_status' title='See awaiting clearance' href="clearing_division.php">
                                <div class="card warning-color order-card z-depth-2">
                                              <div class="card-body">
                                                  <h6 class="text-white">Awaiting Clearance</h6>
                                                  <h2 class="text-right text-white">
                                                    <i class="far fa-copy float-left"></i><span><?php echo number_format($awaiting_clearance); ?></span>
                                                  </h2>
                                              </div>
                                </div>
                          </a>
                    </div>
                    <!-- end of awaiting clearance //-->


                    <!-- Approved Clearance //-->
                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 py-3 px-2">
                          <a id='approved_clearance' class='project_progress_status' title='See approved clearance' href="clearing_division.php" >
                                <div class="card success-color order-card z-depth-2">
                                              <div class="card-body">
                                                  <h6 class="text-white">Approved Clearance</h6>
                                                  <h2 class="text-right text-white">
                                                    <i class="far fa-copy float-left"></i><span><?php echo number_format($approved_clearance); ?></span>
                                                  </h2>
                                              </div>
                                </div>
                          </a>
                    </div>
                    <!-- end of approved clearance //-->


                    <!-- Declined Clearance //-->
                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 py-3 px-2">
                          <a id='declined_clearance' class='project_progress_status' title='See declined clearance' href="clearing_division.php" >
                              <div class="card danger-color order-card z-depth-2">
                                            <div class="card-body">
                                                <h6 class="text-white">Declined Clearance</h6>
                                                <h2 class="text-right text-white">
                                                  <i class="far fa-copy float-left"></i><span><?php echo number_format($declined_clearance); ?></span>
                                                </h2>
                                            </div>
                              </div>
                          </a>
                    </div>
                    <!-- end of declined clearance //-->

    </div>
    <!-- end of row //-->

    <div class="row mt-5">
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <?php
                    $message = new Message();
                    $unit_messages = $message->get_unit_messages($_SESSION['unit_id']);

                    echo "<a href='messaging/message_inbox.php'><h5>Conversations ({$unit_messages->rowCount()})</h5></a>";
                 ?>
          </div>
    </div>

</div><!-- end of container //-->

<br/><br/>
<?php
      //footer
      require_once("../includes/footer.php");
 ?>

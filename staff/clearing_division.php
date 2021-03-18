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




?>




<div class="container">


    <div class="row" style="margin-top:20px;">





      <!-- Heading pane //-->
      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-3">
          <h4 class='mb-4'>Clearance for Students Withdrawing/Graduating from the University<br><small>2019/2020 Academic Session</small></h4>

          <hr>
          <!-- Salutation //-->
          <?php

              echo "<div class='mb-2'><strong>Welcome, </strong>".$_SESSION['names']."</div>";

          ?>
        </div>
        <!-- Clearance form //-->
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-4">

                <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                          <?php
                                $clearance = new StudentClearance();
                                $awaiting_clearance = $clearance->awaiting_clearance_in_unit($_SESSION['unit_id']);
                                //$awaiting_clearance = $number_awaiting_clearance->fetch(PDO::FETCH_ASSOC);
                          ?>
                          <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home"
                            aria-selected="true">Awaiting Clearance (<?php echo $awaiting_clearance->rowCount(); ?>)</a>
                        </li>
                        <li class="nav-item">
                          <?php
                                $clearance = new StudentClearance();
                                $approved_clearance = $clearance->approved_clearance_in_unit($_SESSION['unit_id']);

                          ?>
                          <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile"
                            aria-selected="false">Clearance Approved (<?php echo $approved_clearance->rowCount(); ?>)</a>
                        </li>
                        <li class="nav-item">
                          <?php
                                $clearance = new StudentClearance();
                                $declined_clearance = $clearance->declined_clearance_in_unit($_SESSION['unit_id']);

                          ?>
                          <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact"
                            aria-selected="false">Clearance Declined (<?php echo $declined_clearance->rowCount(); ?>)</a>
                        </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                              <!-- Awaiting clearance //-->

                              <?php

                                  require_once("awaiting_clearance.php");
                              ?>
                        </div>
                        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                              <!-- Clearance Approved //-->
                              <?php
                                  require_once("approved_clearance.php");
                              ?>
                        </div>
                        <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                              <!-- Clearance Declined //-->
                              <?php
                                  require_once("declined_clearance.php");
                              ?>

                        </div>
                      </div>

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
<script src="../lib/js/custom/tblData.js"></script>
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

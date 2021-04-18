<?php

  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);
  //session_start();



      $page_title = "Message Inbox";

      // Config files
      require_once("../../config/step2/init_wp.php");


      if (!(isset($_SESSION['app_login']) && $_SESSION['app_login'] != '' && $_SESSION['app_login'] == 'staff')) {
          header ("Location: ../index.php");
      }


      // Navigation
      require_once("../../nav/staff_nav.php");

      //require_once("../includes/funaabWS.php");
      //require_once("../includes/ws_functions.php");
      //require_once("../includes/ws_parameters.php");

      $my_unit_id = $_SESSION['unit_id'];

      $message = new Message();
      $unit_messages = $message->get_unit_messages($my_unit_id);




?>




<div class="container">


    <div class="row" style="margin-top:20px;">





      <!-- Heading pane //-->
      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-3">
          <h4 class='mb-4'>Clearance for Students Withdrawing/Graduating from the University<br><small>2019/2020 Academic Session</small></h4>

          <hr>
          <!-- Salutation //-->
          <?php

              echo "<div class='mb-0'><strong>Welcome, </strong>".$_SESSION['names']."</div>";
              echo "<div class='mb-4'><strong>Clearance Unit: </strong>".$_SESSION['unit_name']."</div>";


          ?>
        </div>
        <!-- Clearance form //-->
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-4">
            <?php
                echo "<h4>Conversations ({$unit_messages->rowCount()})</h4>";

                echo "<table class='table table-striped'>";
                    echo "<thead>";
                        echo "<tr>";
                            echo "<th scope='col'>#</th>";
                            echo "<th scope='col'>Sender</th>";
                            echo "<th scope='col'>Messages</th>";
                        echo "</tr>";
                    echo "</thead>";
                    echo "<tbody>";

                    $counter = 1;

                    while($row = $unit_messages->fetch(PDO::FETCH_ASSOC)){

                            echo "<tr>";
                                echo "<td>{$counter}.</td>";
                                echo "<td><a class='text-info' title='See Student Profile' href='#  '>{$row['sender']}</a></td>";
                                echo "<td><a class='text-info' title='Open Conversation to See Messages' href='message.php?q=".mask($row['chat_id'])."'>{$row['messages']} messages</a></td>";
                            echo "</tr>";

                            $counter++;

                    }

                    echo "</tbody>";
                echo "</table>";


            ?>




        </div>
        <!-- end of Clearance form //-->

      </div><!-- end of row //-->




  </div><!-- end of container //-->

        <input id='matric_no' type='hidden' value="<?php echo $matric_no; ?>" />
        <br/><br/>
        <?php
              //footer
              require_once("../../includes/footer.php");
         ?>
<script src="../../lib/js/custom/tblData.js"></script>
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

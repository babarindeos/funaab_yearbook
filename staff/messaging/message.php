<?php

  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);
  //session_start();

  if (!isset($_GET['q']) || $_GET['q']==''){
        header("location: clearing_division.php");
  }


  $_GET_URL_message_id = explode("-",htmlspecialchars(strip_tags($_GET['q'])));
  $_GET_URL_message_id = $_GET_URL_message_id[1];


  $parties = explode("_",$_GET_URL_message_id);




      $page_title = "Message";

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

      //-------------------------------------------------------------------------


       $sender = $_SESSION['names'];

       //----------------- Form Link---------------------------
       $form_link = "message.php?q=".mask($_GET_URL_message_id);



      //------------------------------------------------------------------------

      //-------------------- isPostBack -------------------------------------------------------------------

            if (isset($_POST['btnSend'])){
                  $text_message = FieldSanitizer::inClean($_POST['message']);

                  $sender = $_POST['sender'];

                  if ($text_message!=''){
                    $chat_id = $_GET_URL_message_id;

                    $message = new Message();
                    $send_message = $message->send_message($chat_id, $sender, $text_message);
                  }

            }




      //--------------------- end of isPostBack ------------------------------------------------------------

      // --------------------- Get My Id and Other party Id ------------------------------------------------
      $my_unit_message_id = $_SESSION['unit_id'];
      $recipient_id = '';
      if ($parties[0]!==$my_unit_message_id){
        $recipient_id = $parties[0];
      }

      if ($parties[1]!=$my_unit_message_id){
        $recipient_id = $parties[1];
      }






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
              echo "<div class='mb-2'><strong>Clearance Unit: </strong>".$_SESSION['unit_name']."</div>";


          ?>
        </div>
        <!-- Messaging area //-->
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-1">
                    <!-- Send Message Form //-->
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
                              <form action="<?php echo $form_link; ?>" method="post">
                                      <div class="form-group purple-border">
                                          <label for="message"></label>
                                          <textarea class="form-control col-md-10" id="message" name="message"  rows="3" placeholder="Send message..." ></textarea>
                                          <input type="hidden" name="sender" value="<?php echo $sender; ?>" >
                                          <button type="submit" name="btnSend" class="btn btn-primary btn-sm">Send</button>
                                      </div>
                              </form>
                    </div>
                    <!-- end of Send Message //-->

        </div>


        <!-- Previous Messages //-->
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-3">
              <div class="table-responsive ">
                  <table class="table table-striped border rounded">
                      <tbody>
                      <?php
                            $chat_id = $_GET_URL_message_id;
                            $message = new Message();
                            $messages = $message->get_messages_by_chat_id($chat_id);



                            while($row = $messages->fetch(PDO::FETCH_ASSOC)){
                                $date_created_raw  = new DateTime($row['date_created']);
                                $date_created = $date_created_raw->format('l jS F, Y');
                                $time_created = $date_created_raw->format('g:i a');

                                $message = nl2br(FieldSanitizer::outClean($row['message']));
                                echo "<tr class='mt-2'><td class='mt-2'><strong>".$row['sender']."</strong><br/><small><i class='far fa-calendar-alt'></i> ".$date_created."  &nbsp;&nbsp;<i class='far fa-clock'></i> ".$time_created."</small><div class='mt-3 mb-3'>".$message."</div></td></tr>";

                            }

                      ?>
                      </tbody>
                </table>
            </div><!-- end of table responsive //-->

        </div>
        <!-- end of Messaging area //-->

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

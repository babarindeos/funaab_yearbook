<?php


    if (!isset($_GET['m']) || $_GET['m']==''){
          header("location: clearance_form.php");
    }


    $_GET_URL_message_id = explode("-",htmlspecialchars(strip_tags($_GET['m'])));
    $_GET_URL_message_id = $_GET_URL_message_id[1];


    $parties = explode("_",$_GET_URL_message_id);





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

       $sender = $surname." ".$firstname." ".$othername;

       //----------------- Form Link---------------------------
       $form_link = "message.php?m=".mask($_GET_URL_message_id);

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
$my_message_id = $matric_no;
$recipient_id = '';
if ($parties[0]!==$matric_no){
  $recipient_id = $parties[0];
}

if ($parties[1]!=$matric_no){
  $recipient_id = $parties[1];
}


// ----------- Get Recipient name ------------------------------------------------------------------
$department = new Department();
$get_unit = $department->get_unit_by_id($recipient_id);

$get_unit = $get_unit->fetch(PDO::FETCH_ASSOC);
$recipient_name = $get_unit['name'];




// ---------------------- End of Other party name ---------------------------------------------------

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

        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-3">
              <?php
                  echo "<big>Message with <strong>{$recipient_name}</strong> </big>";
              ?>

        </div>
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

        <!-- Previous Messages //-->
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-3">
              <div class="table-responsive">
                  <table class="table table-striped">
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
                                echo "<tr class='mt-2'><td><strong>".$row['sender']."</strong><br/><small><i class='far fa-calendar-alt'></i> ".$date_created."  &nbsp;&nbsp;<i class='far fa-clock'></i> ".$time_created."</small><hr/><div class='mt-2'>".$message."</div></td></tr>";
                            }

                      ?>
                      </tbody>
                </table>
            </div><!-- end of table responsive //-->

        </div>
        <!-- end of previous messages //-->

      </div><!-- end of row //-->




  </div><!-- end of container //-->

        <input id='matric_no' type='hidden' value="<?php echo $matric_no; ?>" />
        <!-- <input id='matric_no' type='hidden' value="15064" /> //-->
        <br/><br/>
        <?php
              //footer
              require_once("../includes/footer.php");
         ?>

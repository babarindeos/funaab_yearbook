<?php

// get user eligibility
  if (!isset($_GET['q']) || $_GET['q']==''){
        header("location: clearing_division.php");
  }

  $_GET_URL_checkin_id = explode("-",htmlspecialchars(strip_tags($_GET['q'])));
  $_GET_URL_checkin_id = $_GET_URL_checkin_id[1];


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

      //------------------ isPostBack ----------------------------------------------
      if (isset($_POST['btnSubmit'])){


            $radClearance = '';
            if (isset($_POST['rad_clearance'])){
                  $radClearance = $_POST['rad_clearance'];
            }

            if ($radClearance!=''){
                $remark = FieldSanitizer::inClean($_POST['txt_remark']);
                $reason = FieldSanitizer::inClean($_POST['txt_reason']);
                $remedy = FieldSanitizer::inClean($_POST['txt_remedy']);

                $dataArray = array("checkin_id"=>$_GET_URL_checkin_id, "clearance_option"=>$radClearance, "remark"=>$remark,
                             "reason"=>$reason, "remedy"=>$remedy);

                $clearance = new StudentClearance();
                $result = $clearance->execute_clearance_form($dataArray);

                if ($result->rowCount()){
                    $err_flag = 0;
                    $err_msg = "Clearance form has been successfully updated.";
                }else{
                    $err_flag = 0;
                    $err_msg = "An error occurred updating the Clearance form. Please try again.";
                }

            }else{

                $err_flag = 1;
                $err_msg = "A clearance option has to be selected to clear the student.";
            }
      }

      //----------------- end of isPostBack --------------------------------------






      //------------------ end of isPostBack --------------------------------------



      // Clearance information

      $clearance = new StudentClearance();
      $student_clearance = $clearance->get_clearance_checkin_by_id($_GET_URL_checkin_id);
      $student_clearance_info = $student_clearance->fetch(PDO::FETCH_ASSOC);
      $matric_no = $student_clearance_info['matric_no'];
      $surname = $student_clearance_info['surname'];
      $firstname = $student_clearance_info['firstname'];
      $othername = $student_clearance_info['othername'];
      $student_photo = $student_clearance_info['photo'];
      $email = $student_clearance_info['email'];
      $emailFunaab = $student_clearance_info['emailFunaab'];
      $phone = $student_clearance_info['phone'];
      $collegeCode = $student_clearance_info['collegeCode'];
      $deptCode = $student_clearance_info['deptCode'];
      $level = $student_clearance_info['level'];


      $clearance_option = $student_clearance_info['cleared'];
      $remark = $student_clearance_info['remark'];
      $reason = $student_clearance_info['reason'];
      $remedy = $student_clearance_info['remedy'];


      $remark_style = '';
      $reason_style = '';
      $remedy_style = '';
      $btnSubmit_style = '';

      if ($clearance_option==''){
          $remark_style = "style='display:none;' ";
          $reason_style = "style='display:none;' ";
          $remedy_style = "style='display:none;' ";
          $btnSubmit_style = "style='display:none;' ";
      }else if($clearance_option=='Y'){
          $reason_style = "style='display:none;' ";
          $remedy_style = "style='display:none;' ";
      }else if($clearance_option=='N'){
          $remark_style = "style='display:none;' ";
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

              echo "<div class='mb-2'><strong>Welcome, </strong>".$_SESSION['names']."</div>";

          ?>
        </div>
        <!-- Clearance form //-->
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-4">

            <!-- Row //-->
            <div class="row">


                  <!-- Student profile information //-->
                  <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                          <!-- student avatar //-->
                          <div class="text-center">
                              <?php
                                    $user_photo = '';

                                    if ($student_photo==''){
                                      $user_photo = $baseUrl."images/avatars/avatar_100.jpg";
                                    }else{
                                      //$user_photo = substr($student_photo,1);
                                      $user_photo = $student_photo;
                                      $user_photo = "https://portal.unaab.edu.ng{$user_photo}";
                                    }


                                    echo "<div class='avatar mx-auto white mt-1 mb-2'><img width='140px' src='{$user_photo}' alt='avatar mx-auto white' class='rounded-circle img-fluid border'></div> ";
                               ?>


                          </div>
                          <!-- end of student avatar //-->

                          <!-- Table //-->
                          <div class="table-responsive">
                                <table class="table table-striped">
                                  <tbody>
                                    <tr><td width='30%'><strong>Matric No.</strong></td><td><?php echo $matric_no; ?></td></tr>
                                    <tr><td width='30%'><strong>Surname</strong></td><td><?php echo $surname; ?></td></tr>
                                    <tr><td width='20%'><strong>Firstname</strong></td><td><?php echo $firstname; ?></td></tr>
                                    <tr><td width='20%'><strong>Othername</strong></td><td><?php echo $othername; ?></td></tr>
                                    <tr><td width='20%'><strong>Email</strong></td><td><?php echo $email; ?></td></tr>
                                    <tr><td width='20%'><strong>FUNAAB Email</strong></td><td><?php echo $emailFunaab; ?></td></tr>
                                    <tr><td width='20%'><strong>Phone</strong></td><td><?php echo $phone; ?></td></tr>
                                    <tr><td width='20%'><strong>College Code</strong></td><td><?php echo $collegeCode; ?></td></tr>
                                    <tr><td width='20%'><strong>Dept Code</strong></td><td><?php echo $deptCode; ?></td></tr>
                                    <tr><td width='20%'><strong>Level</strong></td><td><?php echo $level; ?></td></tr>
                                  </tbody>
                                </table>
                          </div> <!-- end of table div //-->
                  </div>
                  <!-- end of student information //-->



                      <!-- clearance //-->
                      <div class="col-xs-12 col-sm-12 col-md-6">
                              <!-- isPostBack Feedback  -->
                              <div class="md-form">
                                  <?php
                                      if (isset($_POST['btnSubmit'])){
                                            if ($err_flag==1){
                                                  miniErrorAlert($err_msg);
                                            }else{
                                                  miniSuccessAlert($err_msg);
                                            }
                                      }
                                  ?>
                              </div>
                              <!-- end of isPostBack feedback //-->


                              <?php
                                    $form_action_link = "student_clearance_form.php?q=".mask($_GET_URL_checkin_id);
                              ?>
                              <form action="<?php $form_action_link; ?>" method="post">

                                      <div class="z-depth-2 rounded py-4 px-2">
                                            Should <strong><?php echo $surname.' '.$firstname.' '.$othername; ?></strong> be Cleared?

                                                    <!-- Clearance radio button-->
                                                    <div class="mt-2 px-2">
                                                        <div class="custom-control custom-radio custom-control-inline">
                                                          <input type="radio" class="custom-control-input radClearance" id="rad_cleared" name="rad_clearance" value="Y" <?php if($clearance_option=='Y'){echo 'checked';} ?> >
                                                          <label class="custom-control-label" for="rad_cleared">Cleared</label>
                                                        </div>

                                                        <!-- Default inline 2-->
                                                        <div class="custom-control custom-radio custom-control-inline">
                                                          <input type="radio" class="custom-control-input radClearance" id="rad_not_cleared" name="rad_clearance" value="N" <?php if($clearance_option=='N'){echo 'checked';} ?>>
                                                          <label class="custom-control-label" for="rad_not_cleared">Not Cleared</label>
                                                        </div>
                                                    </div><!-- end of clearance radio buttons //-->

                                                    <div id="div_remark" class='mt-3' <?php echo $remark_style; ?> >
                                                            <div class="form-group">
                                                                <label for="txt_remark"><strong>Remark</strong></label>
                                                                <textarea class="form-control" name="txt_remark" id="txt_remark" rows="4"><?php echo $remark; ?></textarea>
                                                            </div>
                                                    </div>

                                                    <!--****************** Reason *************************************  //-->
                                                    <div id="div_reason" class='mt-3' <?php echo $reason_style;  ?> >
                                                            <div class="form-group">
                                                                <label for="txt_reason"><strong>Reason</strong></label>
                                                                <textarea class="form-control" name="txt_reason" id="txt_reason" rows="4"><?php echo $reason; ?></textarea>
                                                            </div>
                                                    </div>
                                                    <!-- ************ Remedy *****************************************//-->
                                                    <div id="div_remedy" class='mt-3' <?php echo $remedy_style; ?> >
                                                          <div class="form-group">
                                                              <label for="txt_remedy"><strong>Remedy</strong></label>
                                                              <textarea class="form-control" name="txt_remedy" id="txt_remedy" rows="4"><?php echo $remedy; ?></textarea>
                                                          </div>
                                                    </div>
                                                    <!--************* end of Remedy *********************************//-->


                                                    <div id="div_submit" class='mt-3' <?php echo $btnSubmit_style; ?>  >
                                                          <button type="submit" name="btnSubmit" class="btn btn-primary btn-rounded btn-sm">Submit</button>
                                                    </div>
                                      </div>


                              </form>
                      </div>
                      <!-- end of clearance //-->



            </div>
            <!-- End of row //-->



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

  //--------------------------------- RadClearance //------------------------
  $(document).bind("click",".radClearance", function(){
           var selected_rad_value = $("input[name=rad_clearance]:checked").val();
           if (selected_rad_value=='Y'){
                $("#div_remark").show();
                $("#div_submit").show();
                $("#div_reason").hide();
                $("#div_remedy").hide();
           }else if(selected_rad_value=='N'){
                $("#div_reason").show();
                $("#div_remedy").show();
                $("#div_remark").hide();
                $("#div_submit").show();
           }
  });


  //----------------------------------End of Rad Clearance ------------------------
});

</script>

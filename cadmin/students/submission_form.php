<?php


    if (!isset($_GET['id']) || $_GET['id']==''){
      header("location: submissions.php");
    }else{
      $_GET_URL_form_id = explode("-",htmlspecialchars(strip_tags($_GET['id'])));
      $_GET_URL_form_id = $_GET_URL_form_id[1];
    }

    if (!isset($_GET['sessionid']) || $_GET['sessionid']==''){
      header("location: submissions.php");
    }else{
      $_GET_URL_session_id = explode("-",htmlspecialchars(strip_tags($_GET['sessionid'])));
      $_GET_URL_session_id = $_GET_URL_session_id[1];
    }



    $page_title = 'Student Submissions';

    require_once("../../config/step2/init_wp.php");
    require_once("../../nav/admin_nav.php");
    //require_once("../includes/staff_header.php");


    $err_flag = 0;
    $err_msg = '';

    // isPostBack
    if (isset($_POST['btnSubmit'])){
        $clearance = '';
        if (isset($_POST['rad_clearance'])){
            $clearance = $_POST['rad_clearance'];
        }

        $remark = FieldSanitizer::inClean($_POST['txt_remark']);

        if ($clearance==''){
            $err_flag = 1;
            $err_msg = "Select either <strong>approved</strong> or <strong>declined</strong> to clear the submission";
        }else{
            $data_array = array("id"=>$_GET_URL_form_id, "status"=>$clearance, "status_msg"=>$remark);

            $submission = new Submission();
            $treat_submission = $submission->clearance($data_array);

            if ($treat_submission->rowCount()){
                $err_flag = 0;
                $err_msg = "The submission has been successfully updated.";
            }else{
                $err_flag = 1;
                $err_msg = "An error occurred updating the submission";
            }


        }
    }






    $acada_session = new AcademicSession();
    $get_acada_session = $acada_session->get_active_session();
    $get_current_active_session = $get_acada_session->fetch(PDO::FETCH_ASSOC);


    $get_current_active_session =  $get_current_active_session['session'];


    $yearbook = new YearBook();
    $get_current_yearbook = $yearbook->get_students($get_current_active_session);




    //get submission form by idea
    $submission = new Submission();
    $get_submission = $submission->get_submission_by_id($_GET_URL_form_id);
    $submission_info = $get_submission->fetch(PDO::FETCH_ASSOC);


    //applicant record
    $applicant = new Applicant();
    $get_applicant = $applicant->getApplicant($submission_info['matric_no']);

    $get_applicant_info = $get_applicant->fetch(PDO::FETCH_ASSOC);

    $matric_no = $get_applicant_info['regNumber'];
    $surname = $get_applicant_info['surname'];
    $firstname = $get_applicant_info['firstname'];
    $othername = $get_applicant_info['othername'];
    $email = $get_applicant_info['email'];
    $emailFunaab = $get_applicant_info['emailFunaab'];
    $phone = $get_applicant_info['phone'];
    $collegeCode = $get_applicant_info['collegeCode'];
    $deptCode = $get_applicant_info['deptCode'];
    $level = $get_applicant_info['level'];
    $user_photo = $get_applicant_info['photo'];

    $user_photo = substr($user_photo,1);
    $user_photo = "https://portal.unaab.edu.ng{$user_photo}";








  ?>


  <!-- Dashboard body //-->
  <div class="container-fluid">

    <!-- Page header //-->
    <div class="row mb-4">
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 page_header_spacer">
            <h3>Submission <br><small><?php echo $get_current_active_session; ?> Academic Session</small></h3>

        </div>
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 page_header_spacer text-right">
                <?php
                      $back_url = "submission_by_session.php?sessionid=".mask($_GET_URL_session_id);
                      echo "<h4><a href='{$back_url}'>&laquo; Submissions</a></h4>";
                ?>

        </div>
    </div>
    <!-- end of page header //-->

    <div class="row">
          <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                  <?php
                        $photo = '';
                        if($submission_info['photo']!=''){
                              $photo = "../../student/passports/".$submission_info['photo'];
                        }else{
                              $photo = '../../student/images/user_avatar.png';
                        }

                        $photo = "<img src='{$photo}' width='350px' style='border-top-left-radius:20px; border-bottom-right-radius:20px;'>";

                        echo $photo;

                        echo "<div class='mt-2 text-center'><img src='{$user_photo}' style='border-radius:50%'></div>";

                  ?>

          </div>
          <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5" style='border-left:1px solid #f1f1f1;'>

                  <?php
                        echo "<h2>{$submission_info['fullname']}</h2>";
                   ?>

                   <table class="table table-striped border">

                             <tbody>
                               <tr><td colspan='2'><h5><strong>YearBook Information</strong></h5></td></tr>
                               <tr><td width='20%' style='font-weight:bold'>Date of Birth</td><td><?php echo $submission_info['dob']; ?></td></tr>
                               <tr><td width='20%' style='font-weight:bold'>Email</td><td><?php echo $submission_info['email'] ; ?></td></tr>
                               <tr><td width='20%' style='font-weight:bold'>Phone</td><td><?php echo $submission_info['phone'] ; ?></td></tr>
                               <tr><td width='20%' style='font-weight:bold'>Address</td><td><?php echo $submission_info['address'] ; ?></td></tr>

                               <tr><td colspan='2'><h5><strong>Portal Information</strong></h5></td></tr>
                               <tr><td width='20%' style='font-weight:bold;'>Matric No.</td><td><?php echo $matric_no; ?></td></tr>
                               <tr><td width='20%' style='font-weight:bold;'>Surname</td><td><?php echo $surname; ?></td></tr>
                               <tr><td width='20%' style='font-weight:bold'>Firstname</td><td><?php echo $firstname; ?></td></tr>
                               <tr><td width='20%' style='font-weight:bold'>Othername</td><td><?php echo $othername; ?></td></tr>
                               <tr><td width='20%' style='font-weight:bold'>Email</td><td><?php echo $email; ?></td></tr>
                               <tr><td width='20%' style='font-weight:bold'>FUNAAB Email</td><td><?php echo $emailFunaab; ?></td></tr>
                               <tr><td width='20%' style='font-weight:bold'>Phone</td><td><?php echo $phone; ?></td></tr>
                               <tr><td width='20%' style='font-weight:bold'>College Code</td><td><?php echo $collegeCode; ?></td></tr>
                               <tr><td width='20%' style='font-weight:bold'>Dept Code</td><td><?php echo $deptCode; ?></td></tr>
                               <tr><td width='20%' style='font-weight:bold'>Level</td><td><?php echo $level; ?></td></tr>

                             </tbody>
                   </table>

          </div>
          <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
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
                            $form_action_link = "submission_form.php?id=".mask($_GET_URL_form_id);
                      ?>
                      <form action="<?php $form_action_link; ?>" method="post">

                              <div class="z-depth-2 rounded py-4 px-2">
                                    Should <strong><?php echo $surname.' '.$firstname.' '.$othername; ?></strong> submission be approved?

                                            <!-- Clearance radio button-->
                                            <div class="mt-2 px-2">
                                                <div class="custom-control custom-radio custom-control-inline">
                                                  <input type="radio" class="custom-control-input radClearance" id="rad_cleared" name="rad_clearance" value="Approved" <?php if($submission_info['status']=='Approved'){echo 'checked';} ?> >
                                                  <label class="custom-control-label" for="rad_cleared">Approved</label>
                                                </div>

                                                <!-- Default inline 2-->
                                                <div class="custom-control custom-radio custom-control-inline">
                                                  <input type="radio" class="custom-control-input radClearance" id="rad_not_cleared" name="rad_clearance" value="Declined" <?php if($submission_info['status']=='Declined'){echo 'checked';} ?>>
                                                  <label class="custom-control-label" for="rad_not_cleared">Declined</label>
                                                </div>
                                            </div><!-- end of clearance radio buttons //-->

                                            <div id="div_remark" class='mt-3' >
                                                    <div class="form-group">
                                                        <label for="txt_remark"><strong>Remark</strong></label>
                                                        <textarea class="form-control" name="txt_remark" id="txt_remark" rows="4"><?php echo $submission_info['status_msg']; ?></textarea>
                                                    </div>
                                            </div>




                                            <div id="div_submit" class='mt-3' >
                                                  <button type="submit" name="btnSubmit" class="btn btn-primary btn-rounded btn-sm">Submit</button>
                                            </div>
                              </div>


                      </form>



          </div>
    </div>



  </div><!-- end of container //-->

  <br/><br/><br/>
  <input type='hidden' id='is_firstLogin' value="<?php echo $already_logged_in; ?>" />
  <?php

      //footer.php
      require('../../includes/footer.php');
   ?>
  <script src="../../lib/js/custom/tblData.js"></script>

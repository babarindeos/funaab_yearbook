<?php

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

    $acada_session = new AcademicSession();
    $get_acada_session = $acada_session->get_active_session();
    $get_current_active_session = $get_acada_session->fetch(PDO::FETCH_ASSOC);


    $get_current_active_session =  $get_current_active_session['session'];


    $yearbook = new YearBook();
    $get_current_yearbook = $yearbook->get_students($get_current_active_session);




  ?>


  <!-- Dashboard body //-->
  <div class="container-fluid">

      <!-- Page header //-->
      <div class="row mb-4">
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 page_header_spacer">
              <h3>Submissions <br><small><?php echo $get_current_active_session; ?> Academic Session</small></h3>

          </div>

      </div>
      <!-- end of page header //-->






      <!-- Payment table //-->
      <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                  <?php

                      $session = new AcademicSession();
                      $get_selected_session = $session->get_session_by_id($_GET_URL_session_id);
                      $selected_session = $get_selected_session->fetch(PDO::FETCH_ASSOC);

                      $currently_selected_session = $selected_session['session'];

                      

                      $active ='';
                      if ($selected_session['active']==1){
                            $active = "<span class='badge badge-success'>Current Session</span>";
                      }
                      echo "<h4>Selected Academic Session: {$selected_session['session']} {$active}</h4>";

                  ?>

        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-4">
                  <?php
                          $pending_recordCount = Submission::submission_count('', $currently_selected_session);
                          $approved_recordCount = Submission::submission_count('Approved', $currently_selected_session);
                          $declined_recordCount = Submission::submission_count('Declined', $currently_selected_session);

                  ?>
                  <ul class='nav nav-tabs' id='myTab' role='tablist'>
                        <li class='nav-item'>
                            <a class="nav-link active" id="submission-tab" data-toggle="tab" href="#submission" role="tab"
                               aria-controls="submission" aria-selected="true">Submissions (<?php echo $pending_recordCount; ?>)</a>
                        </li>
                        <li class='nav-item'>
                            <a class="nav-link" id="approved-tab" data-toggle="tab" href="#approved" role="tab"
                              aria-controls="approved" aria-selected="true">Approved (<?php echo $approved_recordCount; ?>)</a>
                        </li>
                        <li class='nav-item'>
                            <a class="nav-link" id="declined-tab" data-toggle="tab" href="#declined" role="tab"
                              aria-controls="declined" aria-selected="true">Declined (<?php echo $declined_recordCount; ?>)</a>
                        </li>
                    </ul>
                        <div class="tab-content" id='myTabContent'>
                            <div class="tab-pane fade show active" id="submission" role="tabpanel" aria-labelledby="submission-tab">
                                  <?php
                                        include_once("pending_submission.inc.php");
                                  ?>
                            </div>

                            <div class="tab-pane fade" id="approved" role="tabpanel" aria-labelledby="approved-tab">
                                  <?php

                                        include_once("approved_submission.inc.php");
                                  ?>
                            </div>
                            <div class="tab-pane fade" id="declined" role="tabpanel" aria-labelledby="declined-tab">
                                  <?php
                                        include_once("declined_submission.inc.php");
                                  ?>
                            </div>

                        </div>


        </div><!-- end of column //-->
    </div><!-- end of row //-->
    <!-- end of payment table //-->


  </div> <!-- end of container //-->

<br/><br/><br/>
<input type='hidden' id='is_firstLogin' value="<?php echo $already_logged_in; ?>" />
<?php

    //footer.php
    require('../../includes/footer.php');
 ?>
<script src="../../lib/js/custom/tblData.js"></script>
<script src="../../lib/js/custom/tblData2.js"></script>
<script src="../../lib/js/custom/tblData3.js"></script>

<?php

    $page_title = 'Student Submission';

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
  <div class="container">

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
                      $get_session = $session->get_sessions();
                      $session_count = $get_session->rowCount();

                      echo "<h4>Records Found: {$session_count}</h4>";

                  ?>

        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

                  <table id='tblData' class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th class="th-sm" >SN</th>
                                <th class="th-sm" > Session </th>
                                <th class="th-sm" > No. of Submissions</th>
                                <th class="th-sm" > Pending</th>
                                <th class="th-sm" > Approved</th>
                                <th class="th-sm" > Declined</th>


                            </tr>
                        </thead>
                        <tbody id="tblBody">
                            <?php
                                  $counter = 1;
                                  while($row = $get_session->fetch(PDO::FETCH_ASSOC)){
                                      extract($row);

                                      $submission_by_session_href = "submission_by_session.php?sessionid=".mask($id);
                                      $submission_by_session = "<a class='text-primary'  href='{$submission_by_session_href}'>{$session}</a>";
                                      echo "<tr>";
                                          echo "<td class='text-center'>{$counter}.</td>";
                                          echo "<td>{$submission_by_session}</td>";
                                          echo "<td></td>";
                                          echo "<td></td>";
                                          echo "<td></td>";
                                          echo "<td></td>";
                                      echo "</tr>";
                                      $counter++;
                                  }
                            ?>

                        </tbody>
                  </table>

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

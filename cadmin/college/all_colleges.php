<?php

    // if(!isset($_GET['college_code']) || $_GET['college_code']==''){
    //   header("location: admin_dashboard.php");
    // }
    //
    // if (!isset($_GET['session']) || $_GET['session']==''){
    //   header("location: admin_dashboard.php");
    // }

    $page_title = 'Colleges';

    require_once("../../config/step2/init_wp.php");
    require_once("../../nav/admin_nav.php");
    //require_once("../includes/staff_header.php");



    $acada_session = new AcademicSession();
    $get_acada_session = $acada_session->get_active_session();
    $get_current_active_session = $get_acada_session->fetch(PDO::FETCH_ASSOC);


    $get_current_active_session =  $get_current_active_session['session'];


  ?>


  <!-- Dashboard body //-->
  <div class="container">

      <!-- Page header //-->
      <div class="row mb-4">
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 page_header_spacer">
              <h3>Colleges in <?php echo $get_current_active_session; ?> Academic Session</h3>

          </div>

      </div>
      <!-- end of page header //-->






      <!-- Payment table //-->
      <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                  <?php
                      $yearbook = new YearBook();
                      $get_colleges = $yearbook->get_all_colleges($get_current_active_session);
                      //echo "<h4>Records Found: {$records_found}</h4>";

                  ?>

        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

                  <table id='tblData' class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th class="th-sm" >SN</th>
                                <th class="th-sm" >Colleges</th>
                                <th class="th-sm" >Students</th>


                            </tr>
                        </thead>
                        <tbody id="tblBody">
                            <?php
                                $count = 0;

                                //$acad_session = $_GET['session'];
                                $acad_session = $get_current_active_session;
                                $total_no_of_students = 0;
                                while($row = $get_colleges->fetch(PDO::FETCH_ASSOC)){
                                    $count++;
                                    $college_code = $row['collegeCode'];


                                    $total_no_of_students += $row['collegeCount'];

                                    $college_link = "<a class='text-info' href='../college/college.php?college_code={$college_code}&session={$acad_session}'>{$college_code}</a>";

                                    echo "<tr>";
                                          echo "<td class='text-center' width='10%'>{$count}.</td><td width='50%' class='text-center'>{$college_link}</td><td class='text-center' width='50%'>{$row['collegeCount']}</td>";
                                    echo "</tr>";

                                }
                                echo "<tr>";
                                    echo "<td></td><td class='text-right' style='font-weight:bold;'>Total</td><td class='text-center' style='font-weight:bold;'>{$total_no_of_students}</td>";
                                echo "</tr>";

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

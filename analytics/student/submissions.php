<?php

    $page_title = 'Student Payments';

    require_once("../../config/step2/init_wp.php");
    require_once("../../nav/analytics_nav.php");
    //require_once("../includes/staff_header.php");




  ?>


  <!-- Dashboard body //-->
  <div class="container-fluid">

      <!-- Page header //-->
      <div class="row mb-4">
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 page_header_spacer">
              <h3>Submissions </h3>

          </div>

      </div>
      <!-- end of page header //-->






      <!-- Payment table //-->
      <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                  <?php
                      $applicant = new Applicant();
                      $get_applicants = $applicant->get_all_applicants();
                      $records_found = $get_applicants->rowCount();

                      echo "<h4>Records Found: {$records_found}</h4>";

                  ?>

        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

                  <table id='tblData' class="table table-responsive table-striped table-bordered table-sm" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th class="th-sm" >SN</th>
                                <th class="th-sm" > Matric No. </th>
                                <th class="th-sm" >User Identity</th>
                                <th class="th-sm" >Dept</th>
                                <th class="th-sm" >Library</th>
                                <th class="th-sm" >Health</th>
                                <th class="th-sm" >Bursary</th>
                                <th class="th-sm" >Sports</th>
                                <th class="th-sm" >Advancement</th>
                                <th class="th-sm" >Students Affairs</th>
                                <th class="th-sm" >Alumni</th>
                                <th class="th-sm" >Exams & Records</th>

                            </tr>
                        </thead>
                        <tbody id="tblBody">
                            <?php
                                  $clearance = new StudentClearance();

                                if ($get_applicants->rowCount())
                                {
                                    $counter = 1;

                                    foreach($get_applicants as $row){
                                      $fullname = $row['surname'].' '.$row['firstname'].' '.$row['othername'];
                                      $matric_no = $row['regNumber'];
                                      $deptCode = $row['deptCode'];
                                      $collegeCode = $row['collegeCode'];

                                      // //clearance forms submitted at different units

                                      //$division = '1';
                                      //$department = $clearance->get_checkin_status('1', $matric_no);


                                      echo "<tr>";
                                      echo "<td class='text-center'>{$counter}.</td>";
                                      echo "<td>{$matric_no}</td>";
                                      echo "<td width='40%'>{$fullname}<br/><small>{$deptCode}, {$collegeCode}</small></td>";
                                      echo "<td width='25%'></td>";
                                      echo "<td></td>";
                                      echo "<td class='text-right'></td>";
                                      echo "<td width='20%'></td>";


                                      echo "</tr>";
                                      $counter++;
                                    } // while loop end
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

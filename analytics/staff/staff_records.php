<?php

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    $page_title = 'Staff Records';

    require_once("../../config/step2/init_wp.php");
    require_once("../../nav/analytics_nav.php");
    //require_once("../includes/staff_header.php");

    require_once("../../classes/Department.php");
    require_once("../../classes/StaffUser.php");

    $staff = new StaffUser();
    $auth = new Auth();

    $department = new Department();
    $get_units = $department->get_all_units_dept_code();


    $get_staff = $staff->get_all_staff();


  ?>


  <!-- Dashboard body //-->
  <div class="container">

      <!-- Page header //-->
      <div class="row mb-4">
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 page_header_spacer">
              <h3>Staff </h3>

          </div>

      </div>
      <!-- end of page header //-->






      <!-- Payment table //-->
      <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mb-4">
          <h5>Staff Records (<?php echo $get_staff->rowCount(); ?>)</h5>

        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 px-3 py-3 border rounded">


                  <div>
                      <table id='tblData' class="table">
                          <thead>
                              <tr>
                                  <th scope="col">#</th>
                                  <th scope="col">Staff ID</th>
                                  <th scope="col">Names</th>
                                  <th scope="col">Email</th>
                                  <th scope="col">Phone</th>
                                  <th scope="col">Unit</th>
                              </tr>
                          </thead>
                          <tbody>
                              <?php
                                  $counter = 1;
                                  while($row = $get_staff->fetch(PDO::FETCH_ASSOC)){
                                      $file_no = FieldSanitizer::outClean($row['file_no']);
                                      $names = FieldSanitizer::outClean($row['names']);
                                      $email = FieldSanitizer::outClean($row['email']);
                                      $phone = FieldSanitizer::outClean($row['phone']);
                                      $unit = FieldSanitizer::outClean($row['unit']);

                                      echo "<tr>";
                                        echo "<td>{$counter}.</td>";
                                        echo "<td>{$file_no}</td>";
                                        echo "<td>{$names}</td>";
                                        echo "<td>{$email}</td>";
                                        echo "<td>{$phone}</td>";
                                        echo "<td>{$unit}</td>";
                                      echo "</tr>";

                                      $counter++;


                                  }



                              ?>
                          </tbody>
                      </table>
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

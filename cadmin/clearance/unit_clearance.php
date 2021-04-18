<?php

// get user eligibility
  if (!isset($_GET['u']) || $_GET['u']==''){
        header("location: ../admin_dashboard.php");
  }

  if (!isset($_GET['t']) || $_GET['t']==''){
        header("location: ../admin_dashboard.php");
  }


  $_GET_URL_unit_id = explode("-",htmlspecialchars(strip_tags($_GET['u'])));
  $_GET_URL_unit_id = $_GET_URL_unit_id[1];


  $_GET_URL_clearance_status = explode("-",htmlspecialchars(strip_tags($_GET['t'])));
  $_GET_URL_clearance_status = $_GET_URL_clearance_status[1];



$page_title = 'Unit '.ucwords($_GET_URL_clearance_status);

require_once("../../config/step2/init_wp.php");
require_once("../../nav/admin_nav.php");
//require_once("../includes/staff_header.php");

require_once("../../classes/Department.php");
require_once("../../classes/StaffUser.php");

$staff = new StaffUser();
$auth = new Auth();

$department = new Department();
$get_unit = $department->get_unit_by_id($_GET_URL_unit_id);

$get_unit = $get_unit->fetch(PDO::FETCH_ASSOC);

$unit_name = $get_unit['name'];




$clearance = new StudentClearance();



?>
<!-- Dashboard body //-->
<div class="container">

    <!-- Page header //-->
    <div class="row mb-4">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 page_header_spacer">
            <h3>Clearance <?php echo ucwords($_GET_URL_clearance_status).' in '.$unit_name; ?></h3>

        </div>

    </div>
    <!-- end of page header //-->






    <!-- Payment table //-->
    <div class="row">

      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 px-3 py-3 border rounded">

        <?php
              if ($_GET_URL_clearance_status=='submission'){
                 $clearance_forms = $clearance->clearance_submission_in_unit($_GET_URL_unit_id);
              }else if ($_GET_URL_clearance_status=='pending'){
                  $clearance_forms = $clearance->awaiting_clearance_in_unit($_GET_URL_unit_id);
              }else if ($_GET_URL_clearance_status=='approved'){
                  $clearance_forms = $clearance->approved_clearance_in_unit($_GET_URL_unit_id);
              } else if ($_GET_URL_clearance_status=='declined'){
                  $clearance_forms = $clearance->declined_clearance_in_unit($_GET_URL_unit_id);
              }

        ?>

        <div class="table">
          <table id='tblData' class="table table-striped">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Matric</th>
                <th scope="col">Surname</th>
                <th scope="col">Firstname</th>
                <th scope="col">Othername</th>
                <th scope="col">Date</th>
                <th scope="col"></th>

              </tr>
            </thead>
            <tbody>
              <?php
                  if ($clearance_forms->rowCount()){
                      $counter = 1;
                      foreach($clearance_forms as $row){
                         $matric_no = $row['matric_no'];
                         $surname = $row['surname'];
                         $firstname = $row['firstname'];
                         $othername = $row['othername'];
                         $date_created = new DateTime($row['date_created']);
                         $date_created = $date_created->format('D. jS F, Y');

                         $student_clearance_form_link = "student_clearance_form.php?q=".mask($row['checkin_id']);
                         $open_button = "<a href='{$student_clearance_form_link}' class='btn btn-primary btn-rounded btn-sm'>Open form</a>";

                         echo "<tr>";
                            echo "<td>{$counter}.</td>";
                            echo "<td>{$matric_no}</td>";
                            echo "<td>{$surname}</td>";
                            echo "<td>{$firstname}</td>";
                            echo "<td>{$othername}</td>";
                            echo "<td>{$date_created}</td>";
                            echo "<td>{$open_button}</td>";
                         echo "</tr>";

                         $counter++;
                      }

                  }else{
                      echo "<tr><td colspan='7'>There are currently no clearance forms to treat.</td></tr>";
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




<?php
    //footer.php
    require('../../includes/footer.php');
 ?>
 <script src="../../lib/js/custom/tblData.js"></script>

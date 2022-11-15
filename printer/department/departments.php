<?php

    $page_title = 'Departments';

    require_once("../../config/step2/init_wp.php");
    require_once("../../nav/printer_nav.php");
    //require_once("../includes/staff_header.php");



    if (!isset($_GET['dept_code']) || $_GET['dept_code']=='' ){
        header("location: ../printer_dashboard.php");
    }

    if (!isset($_GET['session']) || $_GET['session']==''){
        header("location: ../printer_dashboard.php");
    }

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
              <h3>Department (<?php echo $_GET['dept_code']; ?>) </h3>

          </div>

      </div>
      <!-- end of page header //-->






      <!-- Payment table //-->
      <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                  <?php
                      $yearbook = new YearBook();
                      $get_yearbook = $yearbook->get_students_by_department($get_current_active_session, $_GET['dept_code']);
                      $records_found = $get_yearbook->rowCount();

                      echo "<h4>Records Found: {$records_found}</h4>";

                  ?>

        </div>
      </div><!-- end of row //-->

      <div class="row mt-2">
          <?php

              $rowCounter = 1;
              while($row = $get_yearbook->fetch(PDO::FETCH_ASSOC)){
                    $photo = $row['photo'];
                    $photo = "../../student/passports/{$photo}";
                    $surname = $row['surname'];
                    $fullname = $row['surname'].' '.$row['firstname'].' '.$row['othername'];
                    $address = $row['address'];
                    $phone = $row['phone2'];
                    $email = $row['email2'];
                    $dob = $row['dob'];


                    if ($rowCounter==4){
                          echo "<div class='row'>";
                    }
            ?>


                        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3 text-center border py-1 px-1">
                            <?php
                                echo "<div class='avatar mx-auto white mt-1'><img style='width:150px;height:150px;' src='{$photo}' alt='{$surname} photo' class='rounded img-fluid border'></div> ";
                                echo "<div style='font-weight:bold;'>{$fullname}</div>";
                                echo "<div><small>{$email}</small></div>";
                                echo "<div>{$phone} (<small>{$dob}</small>)</div>";
                                echo "<div><small>{$address}</small></div>";


                            ?>
                        </div><!-- end of column //-->


            <?php
                      if ($rowCounter==4){
                          echo "</div>";
                          $rowCounter = 0;
                      }
                  $rowCounter++;
              }
          ?>
      </div><!-- end of row //-->







  </div> <!-- end of container //-->

<br/><br/><br/>
<input type='hidden' id='is_firstLogin' value="<?php echo $already_logged_in; ?>" />
<?php

    //footer.php
    require('../../includes/footer.php');
 ?>
<script src="../../lib/js/custom/tblData.js"></script>

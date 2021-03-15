
<?php
    $department = new Department();
    $get_department = $department->get_dept_full_name($deptCode);
    $get_department = $get_department->fetch(PDO::FETCH_ASSOC);
    $department_name = $get_department['dept_name'];

?>


<div class='px-2 py-2'><?php echo $department_name." (".$deptCode.")"; ?></div>
<!--Loader/Spinner-->
 <div id='department_programme_loader' style="display:none;">

      <?php
          include("../functions/BigBlueSpinner.php");
      ?>
 </div>

<div id='department_programme_pane'>
    <?php
        $get_dept_clearance = $clearance->get_checkin_status($division_id, $matric_no);
        if ($get_dept_clearance->rowCount()){
          //$get_dept_clearance = $get_dept_clearance->fetch(PDO:FETCH_ASSOC);
            foreach($get_dept_clearance as $row){
              $dept_clearance_status = $row['cleared'];
              $dept_clearance_reason = FieldSanitizer::outClean($row['reason']);
              $dept_clearance_remedy = FieldSanitizer::outClean($row['remedy']);
            }

            if ($dept_clearance_status==''){
                  echo "<div class='px-2'><h5><span class='text-info'>[Awaiting Response]</span> Your form has been submitted for clearance.<br/> Please check back for feedback. Thank you.</h5></div>";
            }

            if (trim($dept_clearance_status)=='Y'){
                  echo "<div class='px-2'><h5><span class='text-success'>[Cleared]</span> You have been cleared by your department.</h5></div>";
            }

            if ($dept_clearance_status=='N'){
                  echo "<div class='px-2'><h5><span class='text-danger'>[Not Cleared]</span> You are not cleared by your department.</h5></div>";
                  echo "<div class='px-2 mt-3'><strong>Reason</strong></div>";
                  echo "<div class='px-2 py-2 border'>{$dept_clearance_reason}</div>";

                  echo "<div class='px-2 mt-3'><strong>Remedy</strong></div>";
                  echo "<div class='px-2 py-2 border'>{$dept_clearance_remedy}</div>";

                  echo "<div class='px-2 py-3'><a href='#'><strong><i class='far fa-comments'></i> Send a message</strong></a></div>";
            }




        }else{
           echo "<button id='btn_department_programme' class='btn btn-primary btn-rounded btn-sm'>Check in for Clearance</button>";
        }
    ?>

</div>

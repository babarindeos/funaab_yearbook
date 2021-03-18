

<!--Loader/Spinner-->
 <div id='sports_loader' style="display:none;">
      <?php
          include("../functions/BigBlueSpinner.php");
      ?>
 </div>
  <div id='sports_pane'>
      <?php
          $get_sports_clearance = $clearance->get_checkin_status($division_id, $matric_no);
          if ($get_sports_clearance->rowCount()){
            //$get_dept_clearance = $get_dept_clearance->fetch(PDO:FETCH_ASSOC);
              foreach($get_sports_clearance as $row){
                $sports_clearance_status = $row['cleared'];
                $sports_clearance_remark = nl2br(FieldSanitizer::outClean($row['remark']));
                $sports_clearance_reason = nl2br(FieldSanitizer::outClean($row['reason']));
                $sports_clearance_remedy = nl2br(FieldSanitizer::outClean($row['remedy']));
              }

              if (trim($sports_clearance_status)==''){
                    echo "<div class='px-2'><h5><span class='text-info'>[Awaiting Response]</span> Your form has been submitted for clearance.<br/> Please check back for feedback. Thank you.</h5></div>";
              }

              if (trim($sports_clearance_status)=='Y'){
                    echo "<div class='px-2'><h5><span class='text-info'>[Cleared]</span> You have been cleared by the Directorate of Sports.</h5></div>";

                    if ($sports_clearance_remark!=''){
                        echo "<div class='px-2 mt-3'><strong>Remark</strong></div>";
                        echo "<div class='px-2 py-2 border'>{$sports_clearance_remark}</div>";
                    }

              }

              if (trim($sports_clearance_status)=='N'){
                    echo "<div class='px-2'><h5><span class='text-danger'>[Not Cleared]</span> You are not cleared by the Directorate of Sports.</h5></div>";
                    echo "<div class='px-2 mt-3'><strong>Reason</strong></div>";
                    echo "<div class='px-2 py-2 border'>{$sports_clearance_reason}</div>";

                    echo "<div class='px-2 mt-3'><strong>Remedy</strong></div>";
                    echo "<div class='px-2 py-2 border'>{$sports_clearance_remedy}</div>";


                    $parties = "{$row['unit_id']}_{$matric_no}";
                    $message_link = "message.php?m=".mask($parties);
                    echo "<div class='px-2 py-3'><a href='{$message_link}'><strong><i class='far fa-comments'></i> Send a message</strong></a></div>";
              }


          }else{
             echo "<button id='btn_sports_checkin' class='btn btn-primary btn-rounded btn-sm'>Check in for Clearance</button>";
          }
      ?>

  </div>

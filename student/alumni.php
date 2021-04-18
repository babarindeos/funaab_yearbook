<?php
    $get_alumni_clearance = $clearance->get_checkin_status($division_id, $matric_no);

    // Check if user has been checked in
    if ($get_alumni_clearance->rowCount()){

                    foreach($get_alumni_clearance as $row){
                      $alumni_clearance_status = $row['cleared'];
                      $alumni_clearance_remark = nl2br(FieldSanitizer::outClean($row['remark']));
                      $alumni_clearance_reason = nl2br(FieldSanitizer::outClean($row['reason']));
                      $alumni_clearance_remedy = nl2br(FieldSanitizer::outClean($row['remedy']));
                    }

                    if (trim($alumni_clearance_status)==''){
                          echo "<div class='px-2'><h5><span class='text-info'>[Awaiting Response]</span> Your form has been submitted for clearance.<br/> Please check back for feedback. Thank you.</h5></div>";
                    }

                    if (trim($alumni_clearance_status)=='Y'){
                          echo "<div class='px-2'><h5><span class='text-info'>[Cleared]</span> You have been cleared by the Students Affairs Office.</h5></div>";

                          if ($alumni_clearance_remark!=''){
                              echo "<div class='px-2 mt-3'><strong>Remark</strong></div>";
                              echo "<div class='px-2 py-2 border'>{$alumni_clearance_remark}</div>";
                          }

                    }

                    if (trim($alumni_clearance_status)=='N'){
                          echo "<div class='px-2'><h5><span class='text-danger'>[Not Cleared]</span> You are not cleared by the Students Affairs Office.</h5></div>";
                          echo "<div class='px-2 mt-3'><strong>Reason</strong></div>";
                          echo "<div class='px-2 py-2 border'>{$alumni_clearance_reason}</div>";

                          echo "<div class='px-2 mt-3'><strong>Remedy</strong></div>";
                          echo "<div class='px-2 py-2 border'>{$alumni_clearance_remedy}</div>";


                          $parties = "{$row['unit_id']}_{$matric_no}";
                          $message_link = "message.php?m=".mask($parties);
                          echo "<div class='px-2 py-3'><a href='{$message_link}'><strong><i class='far fa-comments'></i> Send a message</strong></a></div>";
                    }



    }else{
  ?>



<div id="alumni_bank_details" class="border rounder p-2 py-3  mb-3">
   <h4>Payment for Alumni</h4>
   <div class='px-1'><strong>Account Name </strong></div>
   <div class='border rounded px-2 py-2 col-xs-12 col-sm-12 col-md-4 col-lg-4' style="background-color:#f1f1f1;"><big><strong>UNAAB Alumni Association</strong></big></div>

   <div class='px-1 mt-2'><strong>Account Number </strong></div>
   <div class='border rounded px-2 py-2 col-xs-12 col-sm-12 col-md-4 col-lg-4' style="background-color:#f1f1f1;"><big><strong>4131000086</strong></big></div>

   <div class='px-1 mt-2'><strong>Bank </strong></div>
   <div class='border rounded px-2 py-2 col-xs-12 col-sm-12 col-md-4 col-lg-4' style="background-color:#f1f1f1;"><big><strong>FUNAAB Microfinance Bank</strong></big></div>


   <div class='py-2 mt-2'>After payment at the FUNAAB Microfinance Bank, tender the teller at the Alumni Office to obtain an </strong>Alumni Receipt</strong></div>
</div>


<!--Loader/Spinner-->
 <div id='alumni_loader' style="display:none;">
      <?php
          include("../functions/BigBlueSpinner.php");
      ?>

 </div>


<div id='alumni_proof_pane' class='border px-2 py-2'>
    <h4>Upload Copy of Alumni Receipt</h4>
    <!--<form> //-->
          <div class='form-group'>
              <label for='alumni_receipt_no'><strong>Receipt No.</strong></label>
              <input type='text' class='form-control col-xs-12 col-sm-6 col-md-4 col-lg-4' id='alumni_receipt_no'>
          </div>


          <!-- File Type  -->
              <div>
                <label for="file_upload" class="text-info font-weight-normal">File Upload Type (Receipt)<span class='text-danger'></span></label>
              </div>
              <!-- Default inline 1  Document-->
              <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" class="custom-control-input" id="alumni_file_upload_type_document" name="alumni_file_upload_type"  value="document"  >
                <label class="custom-control-label" for="alumni_file_upload_type_document">Document (.pdf)</label>
              </div>

              <!-- Default inline 2 Image-->
              <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" class="custom-control-input" id="alumni_file_upload_type_image" name="alumni_file_upload_type" value="image">
                <label class="custom-control-label" for="alumni_file_upload_type_image">Image (.jpg, .png, .gif)</label>
              </div>
          <!-- end of File Type //-->

          <!-- spinner //-->
          <div id='alumni_spinner' style="display:none;">
                <?php
                    include("../functions/BigBlueSpinner.php");
                    echo "<span class='text-primary'> Uploading Receipt Information...</span>";
                ?>
          </div>
          <!-- end of spinner //-->

          <div id='alumni_activity_notifier'>
              <?php
                  if (isset($_SESSION['alumni_receipt_file'])){
                       $msgblock = "<div class='py-3' id='alumni_myuploadedfile_div'><i class='fas fa-paperclip'></i> <span id='alumni_myuploadedfile'>".$_SESSION['alumni_receipt_file']."</span>";
                       $msgblock .= "</div>";
                      echo $msgblock;
                  }
              ?>
          </div>




          <!-- file uploader //-->
          <div class="md-form" id='alumni_file_uploader' style="display:none;">
              <div class="file-field">
                  <div class="btn btn-info btn-sm float-left">
                    <span>Choose file</span>
                    <input type="file" id="alumni_file">
                  </div>
                  <div class="file-path-wrapper">
                    <input class="file-path validate"  type="text" placeholder="Upload Receipt">
                  </div>
              </div>
          </div>
          <!-- end of file uploader //-->

          <button id="alumni_btnSubmit" name="alumni_btnSubmit" class="btn btn-primary btn-sm btn-rounded">Submit</button>
    <!--</form> //-->

</div><!-- end of submit_yearbook_proof_pane //-->





<?php
} // end of if else statement
?>

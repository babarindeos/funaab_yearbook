<!--Loader/Spinner-->
 <div id='exams_and_records_loader' style="display:none;">
      <?php
          include("../functions/BigBlueSpinner.php");
      ?>

 </div>
<div id='exams_and_records_pane'>

  <?php
      $get_exams_and_records_clearance = $clearance->get_checkin_status($division_id, $matric_no);

      // Check if user has been checked in
      if ($get_exams_and_records_clearance->rowCount()){

                //----------------------------- Check In found ------------------------------------------------
                      foreach($get_exams_and_records_clearance as $row){
                        $exams_and_records_clearance_status = $row['cleared'];
                        $exams_and_records_clearance_remark = nl2br(FieldSanitizer::outClean($row['remark']));
                        $exams_and_records_clearance_reason = nl2br(FieldSanitizer::outClean($row['reason']));
                        $exams_and_records_clearance_remedy = nl2br(FieldSanitizer::outClean($row['remedy']));
                      }

                      if (trim($exams_and_records_clearance_status)==''){
                            echo "<div class='px-2'><h5><span class='text-info'>[Awaiting Response]</span> Your form has been submitted for clearance.<br/> Please check back for feedback. Thank you.</h5></div>";
                      }

                      if (trim($exams_and_records_clearance_status)=='Y'){
                            echo "<div class='px-2'><h5><span class='text-info'>[Cleared]</span> You have been cleared by the Students Affairs Office.</h5></div>";

                            if ($exams_and_records_clearance_remark!=''){
                                echo "<div class='px-2 mt-3'><strong>Remark</strong></div>";
                                echo "<div class='px-2 py-2 border'>{$exams_and_records_clearance_remark}</div>";
                            }

                      }

                      if (trim($exams_and_records_clearance_status)=='N'){
                            echo "<div class='px-2'><h5><span class='text-danger'>[Not Cleared]</span> You are not cleared by the Students Affairs Office.</h5></div>";
                            echo "<div class='px-2 mt-3'><strong>Reason</strong></div>";
                            echo "<div class='px-2 py-2 border'>{$exams_and_records_clearance_reason}</div>";

                            echo "<div class='px-2 mt-3'><strong>Remedy</strong></div>";
                            echo "<div class='px-2 py-2 border'>{$exams_and_records_clearance_remedy}</div>";


                            $parties = "{$row['unit_id']}_{$matric_no}";
                            $message_link = "message.php?m=".mask($parties);
                            echo "<div class='px-2 py-3'><a href='{$message_link}'><strong><i class='far fa-comments'></i> Send a message</strong></a></div>";
                      }
                      //--------------------------------------- End of CheckIn found -------------------------



      }else{
          echo "<div id='link_to_e-records_portal' class='border rounded  px-3 py-2'>";
            echo "<strong><a href='http://e-records.unaab.edu.ng' target='_blank'>Click here to the e-records portal</a></strong> to make payment for the following items: ";
            echo "<ul><li>Certificate - N5,000</li><li>Notification/Statement of Result - N5,000</li><li>Academic Gown - N5,000</li></ul>";
          echo "</div>";


              ?>
                  <div id='buttons_to_upload_receipts' class='border rounded  px-3 py-2 mt-4'>
                      <strong>Already made payments for the above items, submit RRRs and upload receipts</strong>

                      <!-- start of Receipt of Certificate //-->

                              <div id='upload_certificate_receipt' class='text-primary' style='cursor:pointer;'>
                                    <strong>Upload a copy receipt for Certificate</strong>
                              </div>


                      <!-- end of Receipt of Certificate //-->

                        <!-- start of Receipt of Notification/Statement of Result //-->

                              <div id='upload_statement_of_result_receipt' class='text-primary' style='cursor:pointer;' >
                                    <strong>Upload a copy receipt for Notification/Statement of Result</strong>

                              </div>

                        <!-- end of Receipt of Notification/Statement of Result //-->


                        <!--  Start of Receipt of Academic Gown //-->

                              <div id='upload_academic_gown_receipt' class='text-primary' style='cursor:pointer;'>
                                        <strong>Upload a copy receipt for Academic Gown</strong>
                              </div>




                  </div>

                  <div id="receipt_form_uploader" class='mt-4 mb-3'>
                                <div id='submit_e-records_proof_pane' class='border px-2 py-2' style='display:none;'>
                                    <!--<form> //-->
                                          <div id='e-records_receipt_upload_type' class='border rounded px-2 py-2 col-xs-12 col-sm-12 col-md-6 col-lg-6 mb-3' style='background-color:#f1f1f1;font-weight:bold;'></div>
                                          <div class='form-group'>
                                              <label for='receipt_rrr'><strong>Remital Retrieval Reference (RRR)</strong></label>
                                              <input type='text' class='form-control col-xs-12 col-sm-6 col-md-4 col-lg-4' id='receipt_rrr'>
                                          </div>


                                          <!-- File Type  -->
                                              <div>
                                                <label for="e-records_file_upload" class="text-info font-weight-normal">File Upload Type (Receipt)<span class='text-danger'></span></label>
                                              </div>
                                              <!-- Default inline 1  Document-->
                                              <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" class="custom-control-input" id="e-records_file_upload_type_document" name="e-records_file_upload_type"  value="document" <?php if(isset($_POST['btnSubmit'])){ if(!$errFlag){echo "unchecked";} } ?> >
                                                <label class="custom-control-label" for="e-records_file_upload_type_document">Document (.pdf)</label>
                                              </div>

                                              <!-- Default inline 2 Image-->
                                              <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" class="custom-control-input" id="e-records_file_upload_type_image" name="e-records_file_upload_type" value="image">
                                                <label class="custom-control-label" for="e-records_file_upload_type_image">Image (.jpg, .png, .gif)</label>
                                              </div>
                                          <!-- end of File Type //-->

                                          <!-- spinner //-->
                                          <div id='e-records_upload_spinner' style="display:none;">
                                                <?php
                                                    include("../functions/BigBlueSpinner.php");
                                                    echo "<span class='text-primary'> Uploading Receipt Information...</span>";
                                                ?>
                                          </div>
                                          <!-- end of spinner //-->

                                          <div id='e-records_activity_notifier'>
                                              <?php
                                                  if (isset($_SESSION['e-records_receipt_file'])){
                                                       $msgblock = "<div class='py-3' id='e-records_myuploadedfile_div'><i class='fas fa-paperclip'></i> <span id='e-records_myuploadedfile'>".$_SESSION['e-records_receipt_file']."</span>";
                                                       $msgblock .= "</div>";
                                                      echo $msgblock;
                                                  }
                                              ?>
                                          </div>




                                          <!-- file uploader //-->
                                          <div class="md-form" id='e-records_file_uploader' style="display:none;">
                                              <div class="file-field">
                                                  <div class="btn btn-info btn-sm float-left">
                                                    <span>Choose file</span>
                                                    <input type="file" id="e-records_file">
                                                  </div>
                                                  <div class="file-path-wrapper">
                                                    <input class="file-path validate"  type="text" placeholder="Upload Receipt">
                                                  </div>
                                              </div>
                                          </div>
                                          <!-- end of file uploader //-->

                                          <button id="e-records_btnSubmit" name="e-records_btnSubmit" class="btn btn-primary btn-sm btn-rounded">Submit</button>
                                    <!--</form> //-->

                                </div><!-- end of submit_yearbook_proof_pane //-->

                  </div><!-- end of receipt_form_uploader //-->




                  <!-- See uploaded files //-->
                    <?php
                            $files = new FileUploader();
                            $unit_id = 48;
                            $get_receipts = $files->retrieve_user_uploaded_files_by_unit($matric_no, $unit_id);
                    ?>
                    <div><h5>Uploaded Receipts (<span id='no_of_uploaded_exams_and_records_receipts'><?php echo $get_receipts->rowCount(); ?></span>)</h5></div>
                    <div id='e-records_my_uploaded_receipts' class='mt-3 mb-3 border rounded px-3 py-3'>
                       <?php
                            // get records of uploaded files by User
                            echo "<ol>";
                            foreach($get_receipts as $row){
                                $payment_description = $row['payment_description'];
                                $file = $row['file'];
                                $file_type = $row['file_type'];

                                if ($file_type=='document')
                                {
                                    $file_type='documents';
                                }else if($file_type=='image')
                                {
                                    $file_type='images';
                                }


                                $file_href = "../uploads/exams_and_records/{$file_type}/{$file}";
                                $file_link = "<a target='_blank' href='{$file_href}'>{$file}</a>";
                                echo "<li><strong>{$payment_description} - </strong> {$file_link}</li>";


                            }
                            echo "</ol>";



                       ?>

                    </div>

                    <!-- end of uploaded Files //-->




                    <div class='border rounded px-2 py-2'>
                        <div>You can only check-in to the Exams and Records Office only when you have uploaded copies of your receipts as stated above.</div>
                        <div id='exams_and_records_checkin_feedback'></div>
                        <button id='btn_exams_and_records_checkin' class='btn btn-primary btn-rounded btn-sm mt-2'>Check in for Clearance</button>
                    </div>


              <?php

                } //end of else if statement


              ?>
              <!-- Uploaded Files //-->



</div><!-- end of exams_and_records_pane //-->

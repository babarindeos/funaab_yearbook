<!--Loader/Spinner-->
 <div id='students_affairs_loader' style="display:none;">
      <?php
          include("../functions/BigBlueSpinner.php");
      ?>

 </div>
<div id='students_affairs_pane'>

  <?php
      $get_students_affairs_clearance = $clearance->get_checkin_status($division_id, $matric_no);

      // Check if user has been checked in
      if ($get_students_affairs_clearance->rowCount()){

                      foreach($get_students_affairs_clearance as $row){
                        $students_affairs_clearance_status = $row['cleared'];
                        $students_affairs_clearance_remark = nl2br(FieldSanitizer::outClean($row['remark']));
                        $students_affairs_clearance_reason = nl2br(FieldSanitizer::outClean($row['reason']));
                        $students_affairs_clearance_remedy = nl2br(FieldSanitizer::outClean($row['remedy']));
                      }

                      if (trim($students_affairs_clearance_status)==''){
                            echo "<div class='px-2'><h5><span class='text-info'>[Awaiting Response]</span> Your form has been submitted for clearance.<br/> Please check back for feedback. Thank you.</h5></div>";
                      }

                      if (trim($students_affairs_clearance_status)=='Y'){
                            echo "<div class='px-2'><h5><span class='text-info'>[Cleared]</span> You have been cleared by the Students Affairs Office.</h5></div>";

                            if ($students_affairs_clearance_remark!=''){
                                echo "<div class='px-2 mt-3'><strong>Remark</strong></div>";
                                echo "<div class='px-2 py-2 border'>{$students_affairs_clearance_remark}</div>";
                            }

                      }

                      if (trim($students_affairs_clearance_status)=='N'){
                            echo "<div class='px-2'><h5><span class='text-danger'>[Not Cleared]</span> You are not cleared by the Students Affairs Office.</h5></div>";
                            echo "<div class='px-2 mt-3'><strong>Reason</strong></div>";
                            echo "<div class='px-2 py-2 border'>{$students_affairs_clearance_reason}</div>";

                            echo "<div class='px-2 mt-3'><strong>Remedy</strong></div>";
                            echo "<div class='px-2 py-2 border'>{$students_affairs_clearance_remedy}</div>";


                            $parties = "{$row['unit_id']}_{$matric_no}";
                            $message_link = "message.php?m=".mask($parties);
                            echo "<div class='px-2 py-3'><a href='{$message_link}'><strong><i class='far fa-comments'></i> Send a message</strong></a></div>";
                      }



      }else{ //else if user/student is not checked in


          // ----------------------------- Check for payment information of student
          $errFlag = 0;

          $payment = new Payment();
          $getInitialPayData = $payment->getInitialPayData($collectionAPP, $matric_no);

          // ----------------- If User Transaction is found ---------
          if ($getInitialPayData->rowCount()){



                  $row = $getInitialPayData->fetch(PDO::FETCH_ASSOC);

                  $surname = strtoupper(trim($row['surname']));
                  $firstname = ucfirst(strtolower(trim($row['firstname'])));
                	$othername = ucfirst(strtolower(trim($row['othername'])));
                	$phone = $row['phone'];
                	$email = strtolower($row['email']);
                	$transactionID = $row['transactionID'];
                	$referenceNo = $row['referenceNo'];
                	$prefix = $row['collectionPrefix'];
                	$confirmed = $row['confirmed'];
                	$dateCreated = $row['dateCreated'];
                	$registered = $row['registered'];
                	$amount = $row['amount'];
                	$commission = $row['commission'];
                	$payAmount = $amount + $commission;
                	$info = "Invoice details has been captured for <strong>$matric_no </strong> and cannot be altered.<br />";

                  //-------------------------   Check for Payment Invoice Status -----------------------------------------
                    //  Check if payment is not yet registered on FPAy
                    $regNumber = $matric_no;
                    if ($registered==0){
                        @$fPayResponse=addTransaction($prefix, $referenceNo,$regNumber,$surname,$firstname,$payAmount,$phone, $email);
                        //echo "fPayResponse: $fPayResponse<br>";

                        if (($fPayResponse == "Successful") OR ($fPayResponse == "AlreadyExist")) {
                            $registered = 1; // Payment registration successful
                            $uInitialPayData = $payment->updateInitialPayData_setRegistered($registered, $referenceNo);

                        }else{
                            $errFlag = 2;
                            $message .= "Generation of Yearbook Invoice failed: please try again later.<br />";
                            $message .= "<strong>Status: </strong>".myPayGeneration($fPayResponse). "<br /><strong>FPayResponse: </strong>$fPayResponse";
                        }
                    }

                    // 	//Payment Registered on FPay --------------------------------------------------------------------------------
                    if ($registered==1){
                        // --   Get payment status --- if confirmed  --------------------------------------------------------------
                        if ($confirmed == 0){
                            //RRR Yet To Be Issued
                            if ($transactionID == NULL){
                                //Get RRR From FPay
                                @$fPayResponse = getTransactionStatus2($prefix, $referenceNo);
                                $json =json_decode(json_encode($fPayResponse));
                                //print_r($json) . "<br>";
                                //$fPayResponse=$json->Status;
                                $transactionID=$json->ChannelReference;

                                if (strlen($transactionID)>= 8) {
                                    $uInitialPayData = $payment->updateInitialPayData_setTransactionID($transactionID, $referenceNo);
                                    $errFlag = 1;
                                    $message = "You have an outstanding Yearbook Invoice (RRR: $transactionID): <a href='../myAppInvoice.php?regNumber=$regNumber' target='_blank'>Print Invoice</a>
                                    | <a href = '../webPay.php?refNumber=$referenceNo&transID=$transactionID'  target='_blank' >Pay Online</a>";

                                }else{
                                    $uInitialPayData = $payment->updateInitialPayData_setFiled($referenceNo, $regNumber);
                                    $errFlag = 2;
                                    $message .= "Generation of Yearbook Invoice failed: please try again later.<br />";
                                    $message .= "<strong>Status: </strong>Awaiting valid RRR from Remita";
                                }
                            }else{
                                //Get Status From FPay
                                @$fPayResponse = getTransactionStatus2($prefix, $referenceNo);
                                $json =json_decode(json_encode($fPayResponse));
                                $fPayResponse=$json->Status;
                                $bank=$json->Bank;
                                $channelMessage=$json->ChannelResponseMessage;
                                //echo "fPayResponse: $fPayResponse<br>";

                                if (($fPayResponse == "Confirmed") OR ($fPayResponse == "AlreadyConfirmed")) {
                                    $confirmed = 1;
                                    $uInitialPayData = $payment->uInitialPayData_Confirmed($bank, $referenceNo);
                                }else{
                                    $errFlag = 1;
                                    $message = "<big>You have an outstanding Yearbook Invoice (RRR: $transactionID): <a href='../myAppInvoice.php?regNumber=$regNumber' target='_blank'>Print Invoice</a>
                                    | <a href = '../webPay.php?refNumber=$referenceNo&transID=$transactionID'  target='_blank' >Pay Online</a> </big><br />";


                                }
                            }  // end of if ($transactionID == NULL)
                        }// end of if ($confirmed == 0)
                        // ------- end of payment status confirmation -----------------------------------------

                              // --- If Confirmed"confirmed: $confirmed"; -----------------------------------------
                              if ($confirmed == 1) {
                                  //Invoice paid: Continue process
                                  //$_SESSION['utmeNumber'] = $utmeNumber;
                                    $errFlag = 0;
                                    $message =  "<div class='mt-1 text-left'><i class='fas fa-info-circle'></i> <big><strong>Your payment has been confirmed.</strong><br/> </big></div>";



                              }
                            // ----- end of confirm //----------------------------------------------------------
                      } // end of if ($registered==1)
                //----------------------------------------------------------- End of payment module --------------------------------------



                      // Display message --------------------------------------------------------

                      echo "<div class='alert alert-warning' role='alert'>";
                           echo "<i class='fas fa-info-circle'></i> {$info}";
                      echo "</div>";

                      if ($errFlag==0){
                          echo "<div class='alert alert-success' role='alert'>";
                               echo "{$message}";
                          echo "</div>";
                          echo "<button id='btn_students_affairs_checkin' class='btn btn-primary btn-rounded btn-sm'>Check in for Clearance</button>";
                      }else if ($errFlag==1){
                          echo "<div class='alert alert-warning' role='alert'>";
                               echo "<i class='fas fa-info-circle'></i> {$message}";
                          echo "</div>";
                      }else if ($errFlag==2){
                          echo "<div class='alert alert-danger' role='alert'>";
                               echo "<i class='fas fa-info-circle'></i> {$message}";
                          echo "</div>";

                      }



          }else{
                  echo "<div id='yearbook_paid_div'>I have already made payment for yearbook physically. Click here to <button id='btn_yearbook_paid' class='btn btn-success btn-sm btn-rounded'>Submit proof of payment</button></div>";
                  ?>
                        <div id='submit_yearbook_proof_pane' class='border px-2 py-2' style='display:none;'>
                            <!--<form> //-->
                                  <div class='form-group'>
                                      <label for='yearbook_rrr'><strong>Remital Retrieval Reference (RRR)</strong></label>
                                      <input type='text' class='form-control col-xs-12 col-sm-6 col-md-4 col-lg-4' id='yearbook_rrr'>
                                  </div>


                                  <!-- File Type  -->
                                      <div>
                                        <label for="file_upload" class="text-info font-weight-normal">File Upload Type (Receipt)<span class='text-danger'></span></label>
                                      </div>
                                      <!-- Default inline 1  Document-->
                                      <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" class="custom-control-input" id="file_upload_type_document" name="file_upload_type"  value="document" <?php if(isset($_POST['btnSubmit'])){ if(!$errFlag){echo "unchecked";} } ?> >
                                        <label class="custom-control-label" for="file_upload_type_document">Document (.pdf)</label>
                                      </div>

                                      <!-- Default inline 2 Image-->
                                      <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" class="custom-control-input" id="file_upload_type_image" name="file_upload_type" value="image">
                                        <label class="custom-control-label" for="file_upload_type_image">Image (.jpg, .png, .gif)</label>
                                      </div>
                                  <!-- end of File Type //-->

                                  <!-- spinner //-->
                                  <div id='spinner' style="display:none;">
                                        <?php
                                            include("../functions/BigBlueSpinner.php");
                                            echo "<span class='text-primary'> Uploading Receipt Information...</span>";
                                        ?>
                                  </div>
                                  <!-- end of spinner //-->

                                  <div id='activity_notifier'>
                                      <?php
                                          if (isset($_SESSION['yearbook_receipt_file'])){
                                               $msgblock = "<div class='py-3' id='myuploadedfile_div'><i class='fas fa-paperclip'></i> <span id='myuploadedfile'>".$_SESSION['yearbook_receipt_file']."</span>";
                                               $msgblock .= "</div>";
                                              echo $msgblock;
                                          }
                                      ?>
                                  </div>




                                  <!-- file uploader //-->
                                  <div class="md-form" id='file_uploader' style="display:none;">
                                      <div class="file-field">
                                          <div class="btn btn-info btn-sm float-left">
                                            <span>Choose file</span>
                                            <input type="file" id="file">
                                          </div>
                                          <div class="file-path-wrapper">
                                            <input class="file-path validate"  type="text" placeholder="Upload Receipt">
                                          </div>
                                      </div>
                                  </div>
                                  <!-- end of file uploader //-->

                                  <button id="btnSubmit" name="btnSubmit" class="btn btn-primary btn-sm btn-rounded">Submit</button>
                            <!--</form> //-->

                        </div><!-- end of submit_yearbook_proof_pane //-->
                  <?php
                  echo "<div id='yearbook_pay_online_div'>I want to pay for yearbook. <button id='yearbook_initiate_payment'  class='btn btn-primary btn-sm btn-rounded'>Initiate Payment</button></div>";

          } // end of if ($getInitialPayData->rowCount()){

      } // end of else statement for if ($get_students_affairs_clearance->rowCount()){


 ?>

</div><!-- end of students affairs pane //-->

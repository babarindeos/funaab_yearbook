<?php



  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);
  session_start();

  if (!(isset($_SESSION['app_login']) && $_SESSION['app_login'] != '')) {

  header ("Location: login.php");

  }

  $studentData = $_SESSION['studentData'];



      $page_title = "Prepayment";
      // Core
      require_once("core/config.php");
      // Header
      require_once("includes/header.php");
      // Navigation
      require_once("nav/nav_login.php");

      require_once("includes/funaabWS.php");
      require_once("includes/ws_functions.php");
      require_once("includes/ws_parameters.php");


      //-------------- flag and message variables declared and initialized -------------------------------
      $err_flag = 0;
      $err_msg = null;
      $message = "";
      $info = '';




  //------------------ Check if User has generated and initial Transaction on the payment gateway --------

      $regNumber = $studentData['Matric'];
      $payment = new Payment();
      $getInitialPayData = $payment->getInitialPayData($collectionAPP, $regNumber);




  // ----------------- If User Transaction is found ---------
      if ($getInitialPayData->rowCount()){
          $row = $getInitialPayData->fetch(PDO::FETCH_ASSOC);

          $surname = strtoupper(trim($row['surname']));
    			$firstname = ucfirst(strtolower(trim($row['firstname'])));
    			$othername = ucfirst(strtolower(trim($row['othername'])));
    			$phone = $row['mobile'];
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
    			$info = "Invoice details has been captured for <strong>$regNumber </strong> and cannot be altered.<br />";


          //-------------------------   CHeck for Payment Invoice Status -----------------------------------------
          //  Check if payment is not yet registered on FPAy
          if ($registered==0){
              @$fPayResponse=addTransaction($prefix, $referenceNo,$regNumber,$surname,$firstname,$payAmount,$phone, $email);


              if (($fPayResponse == "Successful") OR ($fPayResponse == "AlreadyExist")) {
                $registered = 1; // Payment registration successful
                $uInitialPayData = $payment->updateInitialPayData_setRegistered($registered, $referenceNo);


              }else{
                $message .= "Registration of SIWES Registration Invoice failed: please try again later.<br />";
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
                  					$fPayResponse=$json->Status;
                  					$transactionID=$json->ChannelReference;

                            if (strlen($transactionID)>= 8) {
                                $uInitialPayData = $payment->updateInitialPayData_setTransactionID($transactionID, $referenceNo);
                                $message = "You have an outstanding Hostel Application Invoice (RRR: $transactionID): <a href='myAppInvoice.php?regNumber=$regNumber' target='_blank'>Print</a>
                                | <a href = 'webPay.php?refNumber=$referenceNo&transID=$transactionID'  target='_blank' >Pay Online</a>
                                <br /><strong> Payment Gateway Status: </strong>".myPayConfirmation($fPayResponse);
                            }else{
                                $uInitialPayData = $payment->updateInitialPayData_setFiled($referenceNo, $regNumber);
                                $message .= "Generation of Acceptance Fee Invoice failed: please try again later.<br />";
						                    $message .= "<strong>Status: </strong>Awaiting valid RRR from Remita";
                            }
                      }else{
                        //Get Status From FPay
                                @$fPayResponse = getTransactionStatus2($prefix, $referenceNo);
                                $json =json_decode(json_encode($fPayResponse));
                                $fPayResponse=$json->Status;
                                $bank=$json->Bank;
                                $channelMessage=$json->ChannelResponseMessage;

                                if (($fPayResponse == "Confirmed") OR ($fPayResponse == "AlreadyConfirmed")) {
                                    $confirmed = 1;
                                    $uInitialPayData = $payment->uInitialPayData_Confirmed($bank, $referenceNo);


                                }else{
                                    $message .= "You have an outstanding Hostel Application Invoice (RRR: $transactionID): <a href='myAppInvoice.php?regNumber=$regNumber' target='_blank'>Print</a>
                                                | <a href = 'webPay.php?refNumber=$referenceNo&transID=$transactionID'  target='_blank' >Pay Online</a> <br />
                                                <strong> Payment Gateway Status: </strong>". myPayConfirmation($fPayResponse);
                                    //.myPayConfirmation($fPayResponse)
                                }
                      }
              }
              // ------- end of payment status confirmation -----------------------------------------

              // --- If Confirmed"confirmed: $confirmed"; -----------------------------------------
                  			if ($confirmed == 1) {
                  				//Invoice paid: Continue process
                  				//$_SESSION['utmeNumber'] = $utmeNumber;
                  				header('Location: sendmail.php');  // Place reservation
                  				exit();
                  			}
              // ----- end of confirm //----------------------------------------------------------
          }

      }


  //-------------- Post back  ----------------------------------------------------------------------------------------------------
      if (isset($_POST['btnPrepayment'])){

          //Initialise
          $surname = $studentData['surname'];
          $firstname = $studentData['firstname'];
          $othername = $studentData['othername'];
          $email = $studentData['email'];
          $phone = $studentData['phone'];

          $surname = (isset($surname)) ? $surname : strtoupper(trim($_POST['surname']));
          $firstname = (isset($firstname)) ? $firstname : ucfirst(strtolower(trim($_POST['firstname'])));
          $othername = (isset($othername)) ? $othername : ucfirst(strtolower(trim($_POST['othername'])));
          $phone = (isset($phone)) ? $phone : NULL;
          $email = (isset($email)) ? $email : NULL;


          // V A L I D A T E   I N P U T S
          //---------------------------------------------------------------------------------------------------------------------------
        	    //Name
            	If ((strlen($surname) < 3) || (strlen($firstname) < 1) || (!is_string($surname)) || (!is_string($firstname)) || (!is_string($othername))) {
            		$message .= "Invalid or missing Name(s). <br />";
            	}

            	//Mobile number
            	if (!preg_match('/^[+]?[0-9]{10,13}$/', $phone)) {
            		$message .= "Invalid or missing Mobile Phone Number. <br />";
            	} else {
            		$phone = $phone;
            	}

            	//email address
            	if (!preg_match('/^([_a-z0-9-]+)(\+)*(\.[_a-z0-9-]+)*@([a-z0-9-]+)(\.[a-z0-9-]+)*(\.[a-z]{2,6})$/',$email)){
            		$message .= "Invalid or missing Email Address. <br />";
            	} else {
            		$email = FieldSanitizer::inClean(strtolower($email));
            	}
          //---------------- End of Validation -----------------------------------------------------------------------------------------------

          if ($message==""){

              // Generate Invoice
              // Initial  Prefix for SIWES ---------------------------------------------------------------------------------------------

              $myPrefix = "$idPrefix/$collectionAPP/$collectionSession/$batch1";

              // Collection
              $collection = new Collection();
              $getCollection = $collection->getCollection($myPrefix, $acadaSession);

              //echo $getCollection->rowCount();
              // Collection found and pulled
              if ($getCollection->rowCount()){

                  $row = $getCollection->fetch(PDO::FETCH_ASSOC);

                  // fields
                  $amount = $row['amount'];
                  $commission = $row['commission'];
                  $payAmount = $row['amount'];
                  $prefix = $row['prefix'];
                  $random = "0123456789";
                  $userip = getUserIP();



              //------------------------- Build Unique ReferenceNo -----------------------------------------------------------



              }





          }

          echo $message;
      }

  //--------------- End of Post back





 ?>

<div class="container-fluid">

    <!-- Pre-payment Form //-->
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <div class="row" style="margin-top:20px;">





      <!-- left pane //-->
      <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
          <h4 class='mb-4'>SIWES Registration<br><small>2019/2020 Academic Session</small></h4>

          <hr>

            <!-- Notification Bar //-->
            <?php
                //---------------------------- Info Notification Section ---------------------------------------
                if ($info!=''){
                ?>
                  <div class="alert alert-warning" role="alert">
                       <i class="fas fa-info-circle"></i>  <?php echo $info; ?>
                  </div>

                <?php
                }
                // ---------------------------- End of Info Notification Section -------------------------------

                //---------------------------- Error Message Notification Section ---------------------------------------
                if ($info!=''){
                ?>
                  <div class="alert alert-danger" role="alert">
                       <i class="fas fa-exclamation-circle"></i>  <?php echo $message; ?>
                  </div>

                <?php
                }
                // ---------------------------- End of Error Message Notification Section
            ?>
            <!-- end of Notification Bar //-->

            <!-- Grid row 1 //-->
            <div class="form-row">
                <!-- surname //-->
                <div class="form-group col-md-4">
                    <label for="surname" disabled>Surname</label>
                    <input type='text' class='form-control' id='surname' name='surname' value="<?php echo $studentData['surname']; ?>" disabled>
                </div>
                <!-- end of surname //-->

                <!-- firstname //-->
                <div class="form-group col-md-4">
                    <label for="firstname" disabled>Firstname</label>
                    <input type='text' class='form-control' id='firstname' name='firstname' value="<?php echo $studentData['firstname']; ?>" disabled>
                </div>
                <!-- end of firstname //-->

                <!-- Othernames //-->
                <div class="form-group col-md-4">
                    <label for="othernames" disabled>Othernames</label>
                    <input type='text' class='form-control' id='othername' name='othername' value="<?php echo $studentData['othername'] ?>" disabled>
                </div>
                <!-- end of firstname //-->


            </div>
            <!-- end of Grid 1 //-->

            <!-- Get most recently updated email on the SIWES Portal aside from the email from the Portal  //-->
            <!-- code updated on 13th February, 2021 as a result of many students not able to access their email address  from the portal //-->
            <!-- Non-teaching staff are on strike and students are not able to get to MIS to make the change to their emails //-->
            <?php
                  $applicant = new Applicant();
                  $applicant_email = $applicant->get_applicant_email($studentData['Matric']);
                  $get_email = $applicant_email->fetch(PDO::FETCH_ASSOC);
                  $student_email = $get_email['email'];

                  $_SESSION['email'] = $student_email;
                  $studentData['email'] = $student_email;                  
            ?>




            <!-- Grid row 2 //-->
            <div class="form-row">
                <!-- email //-->
                <div class="form-group col-md-8">
                    <label for="email" disabled>Email</label>
                    <input type="email" class="form-control" id="email" name='email' value="<?php echo $studentData['email']; ?>" disabled>
                </div>
                <!-- end of email //-->

                <!-- phone //-->
                <div class="form-group col-md-4">
                    <label for="phone" disabled>Phone</label>
                    <input type="phone" class="form-control" id="phone" name='phone' value="<?php echo $studentData['phone']; ?>" disabled>
                </div>

                <!-- end of phone //-->


            </div>
            <!-- end of Grid row 2 //-->


            <!-- Grid row 3 //-->
            <div class="form-row">
                <!-- level //-->
                <div class="form-group col-md-4">
                    <label for="level" disabled>Level</label>
                    <input type="text" class="form-control" id="level" name='level' value="<?php echo $studentData['level']; ?>" disabled>
                </div>
                <!-- end of level //-->

                <!-- department //-->
                <div class="form-group col-md-4">
                    <label for="deptCode" disabled>Department</label>
                    <input type="deptCode" class="form-control" id="deptCode" name='deptCode' value="<?php echo $studentData['deptCode']; ?>" disabled>
                </div>

                <!-- end of department //-->

                <!-- college //-->
                <div class="form-group col-md-4">
                    <label for="collegeCode" disabled>College</label>
                    <input type="text" class="form-control" id="collegeCode" name='collegeCode' value="<?php echo $studentData['collegeCode']; ?>" disabled>
                </div>

                <!-- end of college //-->


            </div>
            <!-- end of Grid row 3 //-->



      </div>
      <!-- end of left pane //-->


      <!--  right column  //-->
      <div class="col-xs-12 col-sm-12 col-md-4 col-lg text-center">
           <?php
                echo "<h4>User: [<strong>".$studentData['Matric']."</strong>] &nbsp;<a href='signin.php'><small><i class='fas fa-power-off'></i> Log-out</small></a></h4>";
           ?>

           <div class="avatar mx-auto white mt-5"><img src="student/images/user_avatar.png"
                  alt="avatar mx-auto white" class="rounded-circle img-fluid border">
           </div>

           <!-- Make payment //-->
           <div class='mt-12 text-center'>
                  <button type="submit" name="btnPrepayment" class="btn btn-lg btn-rounded btn-primary">Make Payment</button>
           </div>

           <div class='mt-12 text-center'>
                <img  class='img-fluid' src="http://hostel.unaab.edu.ng/images/remita-payment-logo-horizonal.png">

           </div>
           <!-- end of Make Payment //-->



      </div><!-- end of columm //-->
      <!-- end of right column //-->



    </div><!-- end of row //-->

  </form>
  <!-- end of Prepayment form //-->

</div><!-- end of container //-->

<br/><br/>
<?php
      //footer
      require_once("includes/footer.php");
 ?>

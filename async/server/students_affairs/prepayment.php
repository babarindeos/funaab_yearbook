<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
//session_start();
//-------------- Abstract -----------------------------------
require_once("../../../abstract/User.php");
require_once("../../../abstract/Database.php");

// -------------- Interface ---------------------------------
require_once("../../../interface/UserInterface.php");
require_once("../../../interface/DBInterface.php");
require_once("../../../interface/CellInterface.php");
require_once("../../../interface/AcademicSessionInterface.php");
require_once("../../../interface/ApplicantInterface.php");
require_once("../../../interface/PaymentInterface.php");
require_once("../../../interface/CollectionInterface.php");


//--------------- Classes -----------------------------------
require_once("../../../classes/StaffUser.php");
require_once("../../../classes/Cell.php");
require_once("../../../classes/PDO_QueryExecutor.php");
require_once("../../../classes/PDODriver.php");
//require_once("../../../classes/StudentManuals.php");
require_once("../../../classes/StudentClearance.php");
require_once("../../../classes/AcademicSession.php");
require_once("../../../classes/Applicant.php");
require_once("../../../classes/Payment.php");
require_once("../../../classes/Collection.php");

//-------------- Functions ---------------------------------
require_once("../../../functions/FieldSanitizer.php");
require_once("../../../functions/Encrypt.php");

//require_once("functions/shopping_cart_factory.inc.php");


//-------------- Web service files ------------------------
require_once("../../../includes/funaabWS.php");
require_once("../../../includes/ws_functions.php");
require_once("../../../includes/ws_parameters.php");




if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH']=='XMLHttpRequest')
  {
      $matric_no = $_POST['matric_no'];

      $payment = new Payment();

      $applicant = new Applicant();
      $get_applicant = $applicant->getApplicant($matric_no);

      $get_applicant_info = $get_applicant->fetch(PDO::FETCH_ASSOC);

      $surname = $get_applicant_info['surname'];
      $firstname = $get_applicant_info['firstname'];
      $othername = $get_applicant_info['othername'];
      $gender = $get_applicant_info['gender'];
      $phone = $get_applicant_info['phone'];
      $photo = $get_applicant_info['photo'];
      $email = $get_applicant_info['email'];
      $emailFunaab = $get_applicant_info['emailFunaab'];
      $level = $get_applicant_info['level'];
      $majorCode = $get_applicant_info['majorCode'];
      $deptCode = $get_applicant_info['deptCode'];
      $collegeCode = $get_applicant_info['collegeCode'];


      $message = '';
      $info = '';

      // V A L I D A T E   I N P U T S --------------------------------------------------------------------------------------
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
                    // Initial  Prefix for Payment ---------------------------------------------------------------------------------------------

                    $myPrefix = "$idPrefix/$collectionAPP/$collectionSession/$batch1";

                    // Collection
                    $collection = new Collection();
                    $getCollection = $collection->getCollection($myPrefix, $acadaSession);


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
                          // Payment
                          $referenceNo = '';
                          if ($referenceNo=='') {
                                //Generate Unique Reference

                                do {

                                  $pin = substr(str_shuffle($random), 0, 5);
                                  $referenceNo = "$myPrefix/$pin";
                                  $getReferenceNo = $payment->getReferenceNo($pin);
                                  //echo $referenceNo;
                                } while ($getReferenceNo->rowCount());

                                //Payment data
                                $invoiceDataArray = array("regNumber"=>$matric_no, "surname"=>$surname, "firstname"=>$firstname, "othername"=>$othername, "photo"=>$photo,
                                  "phone"=>$phone,  "email"=>$email, "emailFunaab"=>$emailFunaab, "referenceNo"=>$referenceNo, "collectionPrefix"=>$myPrefix,
                                  "amount"=>$amount, "commission"=>$commission);

                                //Print_r($invoiceDataArray);


                                //Insert Record to initialPayData table
                                $new_invoice = $payment->create_new_invoice($invoiceDataArray);
                                $info = "<div class='alert alert-warning' role='alert'> <i class='fas fa-info-circle'></i> Invoice details for the payment of Yearbook has been captured for <strong>$matric_no </strong> and cannot be altered.</div>";

                          }


                          //Add transaction to Payment Gateway
                          $regNumber = $matric_no;

                          @$fPayResponse=addTransaction($prefix, $referenceNo,$regNumber,$surname,$firstname,$payAmount,$phone, $email);
                          if ($fPayResponse == "Successful") {

                              $pushInvoice = $payment->updateInitialPayData_setRegistered($registered, $referenceNo);


                              $response = array("status"=>'success', "msg"=>$info);

                          } else {
                              $message .= $info."<div class='alert alert-danger' role='alert'><i class='fas fa-info-circle'></i> Generation of Invoice for the Payment of FUNAAB Yearbook failed: Please try again later.<br />";
                              $message .= "<strong>FUNAABPay Gateway Status: </strong> ".myPayGeneration($fPayResponse)."</div>";
                              $response = array("status"=>'failed', "msg"=>$message);
                          }

                      } //end of if ($getCollection->rowCount())




              } else{
                  $response = array("status"=>'failed', "msg"=>$message);
              }// end of if($message=='')


          echo json_encode($response);

  } // end of if isset($_SERVER['HTTP_X_REQUESTED_WITH'])











?>

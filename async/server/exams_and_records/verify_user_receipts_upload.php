<?php

    //-------------- Abstract -----------------------------------
    require_once("../../../abstract/User.php");
    require_once("../../../abstract/Database.php");

    // -------------- Interface ---------------------------------
    require_once("../../../interface/UserInterface.php");
    require_once("../../../interface/DBInterface.php");
    require_once("../../../interface/CellInterface.php");
    require_once("../../../interface/FileUploaderInterface.php");


    //--------------- Classes -----------------------------------
    require_once("../../../classes/FileUploader.php");
    require_once("../../../classes/StaffUser.php");
    require_once("../../../classes/Cell.php");
    require_once("../../../classes/PDO_QueryExecutor.php");
    require_once("../../../classes/PDODriver.php");


  //header('Content-Type: text/html');

  if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH']=='XMLHttpRequest')
  {

      $matric_no = $_GET['matric_no'];


      $files = new FileUploader();

      $message = '';

      //check for Uploaded Certificate for the user
      $payment_description = 'Receipt of Certificate';
      $is_uploaded = $files->check_for_file_upload($matric_no, $payment_description);
      if ($is_uploaded->rowCount()==0){
          $message = '<li>Receipt of Certificate has not been uploaded</li>';
      }

      //check for Uploaded Receipt of Notification or Statement of Result for the user
      $payment_description = 'Receipt of Statement of Result';
      $is_uploaded = $files->check_for_file_upload($matric_no, $payment_description);
      if ($is_uploaded->rowCount()==0){
          $message .= '<li>Receipt of Notification or Statement of Result has not been uploaded</li>';
      }

      //check for Uploaded Receipt of Academic Gown for the user
      $payment_description = 'Receipt of Academic Gown';
      $is_uploaded = $files->check_for_file_upload($matric_no, $payment_description);
      if ($is_uploaded->rowCount()==0){
          $message .= '<li>Receipt of Academic Gown has not been uploaded</li>';
      }

      $response = '';
      if ($message!=''){
        $response = array("status"=>"failed","msg"=>$message);
      }else{
        $response = array("status"=>"success", "msg"=>$message);
      }

      echo json_encode($response);



  }



  ?>

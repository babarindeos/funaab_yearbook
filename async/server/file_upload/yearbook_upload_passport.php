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

      $source = $_GET['source'];
      $file = $_FILES['file'];
      $matric_no = $_GET['matric_no'];

      //echo $matric_no;


      //$file = round($file/1000);  // calculate file size in Kb, Mb, Gb, Tb

      $fileUtil = new FileUploader();
      $uploadAction = $fileUtil->uploadYearBookPassport($source, $file, $matric_no);

      session_start();
      if ($uploadAction['status']=='success'){
          //unset($_SESSION['yearbook_receipt_file']);
          $_SESSION['yearbook_passport'] = $uploadAction['wp_filename'];
      }else{
          unset($_SESSION['yearbook_passport']);
      }

      $result = json_encode($uploadAction);

      echo $result;


  }

 ?>

<?php

//-------------- Abstract -----------------------------------
require_once("../../../abstract/User.php");
require_once("../../../abstract/Database.php");

// -------------- Interface ---------------------------------
require_once("../../../interface/UserInterface.php");
require_once("../../../interface/DBInterface.php");
require_once("../../../interface/CellInterface.php");
require_once("../../../interface/AcademicSessionInterface.php");


//--------------- Classes -----------------------------------
require_once("../../../classes/StaffUser.php");
require_once("../../../classes/Cell.php");
require_once("../../../classes/PDO_QueryExecutor.php");
require_once("../../../classes/PDODriver.php");
//require_once("../../../classes/StudentManuals.php");
require_once("../../../classes/StudentClearance.php");
require_once("../../../classes/AcademicSession.php");

//-------------- Functions ---------------------------------
require_once("../../../functions/FieldSanitizer.php");
require_once("../../../functions/Encrypt.php");

//require_once("functions/shopping_cart_factory.inc.php");




if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH']=='XMLHttpRequest')
  {

    $receipt_rrr = $_POST['receipt_rrr'];
    $file = $_POST['file'];
    $matric_no = $_POST['matric_no'];
    $payment_description = $_POST['payment_description'];
    $unit_id = $_POST['unit_id'];



    $file_extension = substr($file, strpos($file, "."));

    $file_type = '';
    if ($file_extension=='.pdf'){
      $file_type= 'document';
    }else{
      $file_type = 'image';
    }

    // save upload file into Database
    if ($receipt_rrr!='' && $file!='' && $matric_no!='' && $payment_description!='' && $unit_id!='' && $file_extension!='' && $file_type!='')
    {
         $dataArray = array("rrr"=>$receipt_rrr, "file"=>$file, "matric_no"=>$matric_no, "payment_description"=>$payment_description,
                            "unit_id"=>$unit_id, "file_extension"=>$file_extension, "file_type"=>$file_type);

         $clearance = new StudentClearance();
         $save_file_info = $clearance->save_file_info($dataArray);

         // if successful set Session
         if ($save_file_info['status']=='success'){
            //session_start();
            //unset($_SESSION[$payment_description]);
            $_SESSION[$payment_description] = $file;
         }

    }else{
         $save_file_info = array("status"=>'failed', "msg"=>'Missing required parameters.');
    }

        $response = json_encode($save_file_info);

        echo $response;








  } // end of if isset($_SERVER['HTTP_X_REQUESTED_WITH'])











?>

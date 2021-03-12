<?php

//-------------- Abstract -----------------------------------
require_once("../../../abstract/User.php");
require_once("../../../abstract/Database.php");

// -------------- Interface ---------------------------------
require_once("../../../interface/UserInterface.php");
require_once("../../../interface/DBInterface.php");
require_once("../../../interface/CellInterface.php");


//--------------- Classes -----------------------------------
require_once("../../../classes/StaffUser.php");
require_once("../../../classes/Cell.php");
require_once("../../../classes/PDO_QueryExecutor.php");
require_once("../../../classes/PDODriver.php");
//require_once("../../../classes/StudentManuals.php");
require_once("../../../classes/StudentClearance.php");

//-------------- Functions ---------------------------------
require_once("../../../functions/FieldSanitizer.php");
require_once("../../../functions/Encrypt.php");

//require_once("functions/shopping_cart_factory.inc.php");




if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH']=='XMLHttpRequest')
  {

    $division_id = $_POST['division_id'];
    $matric_no = $_POST['matric_no'];

    $clearance  = new StudentClearance();
    $result = $clearance->checkIn($division_id, $matric_no);

    echo $result->rowCount();




  } // end of if isset($_SERVER['HTTP_X_REQUESTED_WITH'])











?>

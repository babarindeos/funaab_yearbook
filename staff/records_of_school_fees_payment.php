<?php

require_once("../includes/ws_parameters.php");
require_once("../includes/ws_functions.php");
include_once("../includes/funaabWS.php");



// ---------------------- Get current Session  -----------------------------------------
$academicSession = new AcademicSession();
$get_current_active_session = $academicSession->get_active_session();
$get_current_active_session = $get_current_active_session->fetch(PDO::FETCH_ASSOC);
$current_active_session = $get_current_active_session['session'];

//echo $current_active_session;
//------------------------End of Get Session -------------------------------------------

$student_start_year = substr($matric_no,0,4);

$continue_process = true;
$next_session = $student_start_year;

while($continue_process){

    $start_session = $next_session;
    $next_session = $start_session + 1;
    $acadaSession = "{$start_session}/{$next_session}";

    //echo $acadaSession;
    //echo "<br/>";
    @$student_reginfo_by_session = getStudentRecord($matric_no, $acadaSession);
    if ($student_reginfo_by_session == 'Fault') {
          $err_flag==1;
          //$err_msg = "Student Portal not available ($studentDetails), please try again later. ";
          $err_msg = "Student Portal not available, please try again later. ";
    }else{
        //Retrieve Record from Portal
        $json =json_decode(json_encode($student_reginfo_by_session));
        print_r($json);
        //exit;
    }

    if ($current_active_session==$acadaSession){
       $continue_process = false;
       break;
    }




}





?>

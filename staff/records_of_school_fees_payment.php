
<h5>Schools Fees Payment Details</h5>
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


echo "<table class='table table-striped border mt-3'>";
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

          echo "<tr><td>{$err_msg}</td></tr>";

    }else{
        //Retrieve Record from Portal
        $json =json_decode(json_encode($student_reginfo_by_session));
        //print_r($json);


        $payment_status = trim($json->PaymentStatus);
        $academic_level = trim($json->Level);

        if ($payment_status=='PAID'){
          $payment_status = "<span class='text-success'><strong>{$payment_status}</strong></span>";
        }else{
          $payment_status = "<span class='text-danger'><strong>{$payment_status}</strong></span>";
        }

        echo "<tr><td>{$acadaSession}</td><td>{$academic_level}</td><td>{$payment_status}</td></tr>";
        //exit;
    }

    if ($current_active_session==$acadaSession){
       $continue_process = false;
       break;
    }

} // end of while

echo "</table>";





?>

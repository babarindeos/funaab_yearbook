<?php

    // check if student initiated online payment
    $payment = new Payment();
    $get_payment = $payment->getInitialPayData_by_matric_no($matric_no);


    $message = '';
    if ($get_payment->rowCount()){
          echo "<div class='px-2 mt-2 mb-3'><h5>Online Payment for Yearbook</h5></div>";

          $get_payment_status = $get_payment->fetch(PDO::FETCH_ASSOC);
          $registered = $get_payment_status['registered'];
          $confirmed = $get_payment_status['confirmed'];

          if ($registered==0 && $confirmed==0){
              echo "<div class='alert alert-danger' role='alert'>";
                  echo "<i class='fas fa-info-circle'></i> Online payment has been initiated. Payment is yet to be made.";
              echo "</div>";

          }else if($registered==1 && $confirmed==0){
              echo "<div class='alert alert-warning' role='alert'>";
                  echo "<i class='fas fa-info-circle'></i> Payment is pending. Payment not confirmed.";
              echo "</div>";

          }else if($registered==1 && $confirmed==1){
              echo "<div class='alert alert-success' role='alert'>";
                  echo "<i class='fas fa-info-circle'></i> Payment has been made and confirmed.";
              echo "</div>";
          }

    }




?>

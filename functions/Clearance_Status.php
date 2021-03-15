<?php

if ($clearance_value->rowCount())
 {      $button_color = '';
        $clearance_status = $clearance_value->fetch(PDO::FETCH_ASSOC);
        if ($clearance_status['cleared']==''){
                $title = 'PENDING: Your clarification form has been queued for clearance. Please be patient.';
                $button_color = 'btn-warning';
                $button_icon =  "<i id='{$division_header_icon}' class='far fa-clock'></i>";
        }else if ($clearance_status['cleared']=='Y'){
                $title = 'CLEARED: Congratulations! You have been cleared.';
                $button_color = 'btn-success';
                $button_icon =  "<i id='{$division_header_icon}' class='fas fa-check'></i>";
        }else if ($clearance_status['cleared']=='N'){
                $title = 'NOT CLEARED: Sorry! Your clearance has been declined.';
                $button_color = 'btn-danger';
                $button_icon =  "<i id='{$division_header_icon}' class='fas fa-times'></i>";
        }

  }else{
        // Student has not checked in for clearance
        $title = 'NOT CHECKED IN: You are yet to check in for clearance';
        $button_color = 'btn-info';
        $button_icon =  "<i id='{$division_header_icon}' class='fas fa-question'></i>";
  }





?>

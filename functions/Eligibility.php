<?php

    function isEligible($matric_no, $minDuration){
      $isEligible = false;

      $start_year = substr($matric_no,0,4);
      $current_year = Date('Y');
      $studentship_duration = $current_year - $start_year;

      if ($studentship_duration >= $minDuration){
        $isEligible = true;
        echo "true";
      }else{
        $isEligible = false;
        echo "false";
      }

      return $isEligible;
    }


?>

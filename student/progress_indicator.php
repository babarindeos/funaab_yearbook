<?php
    $not_submitted = '';
    $not_submitted_percentage = '';
    $awaiting  = '';
    $awaiting_percentage = '';
    $approved = '';
    $approved_percentage = '';
    $declined = '';
    $declined_percentage= '';

    $clearance = new StudentClearance();

    for($i=1; $i<=9; $i++){
        $division_id =$i;

        $get_division_clearance = $clearance->get_division_clearance($matric_no, $division_id);
          if ($get_division_clearance->rowCount()){
                $division_clearance = $get_division_clearance->fetch(PDO::FETCH_ASSOC);
                $cleared_status = $division_clearance['cleared'];
                if ($cleared_status==''){
                    $awaiting++;
                }else if($cleared_status=='Y'){
                    $approved++;
                }else if($cleared_status=='N'){
                    $declined++;
                }

          }else{
                $not_submitted++;
          }
    }


    // -----------------  Approved --------------------------------------------------------
    if ($approved>0){
        $approved_percentage = round($approved/9 * 100/1);

        echo "<small>{$approved} Approved of 9</small>";
        echo "<div class='progress md-progress' style='height: 20px'>";
            echo "<div class='progress-bar bg-success' role='progressbar' style='width: {$approved_percentage}%; height: 20px' aria-valuenow='{$approved_percentage}' aria-valuemin='0' aria-valuemax='100'>{$approved_percentage}%</div>";
        echo "</div>";
    }
    //------------------   End of Approved -----------------------------------------------

    // -----------------  Declined --------------------------------------------------------
    if ($declined>0){
        $declined_percentage = round($declined/9 * 100/1);

        echo "<small>{$declined} Declined of 9</small>";
        echo "<div class='progress md-progress' style='height: 20px'>";
            echo "<div class='progress-bar bg-danger' role='progressbar' style='width: {$declined_percentage}%; height: 20px' aria-valuenow='{$declined_percentage}' aria-valuemin='0' aria-valuemax='100'>{$declined_percentage}%</div>";
        echo "</div>";
    }
    //------------------   End of Declined -----------------------------------------------

?>

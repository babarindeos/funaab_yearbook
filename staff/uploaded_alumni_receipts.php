<?php

    $files = new FileUploader();
    $get_files = $files->retrieve_user_uploaded_files_by_unit($matric_no, $_SESSION['unit_id']);

    if ($get_files->rowCount()){

        echo "<div class='mt-5 mb-2 px-2'><h5>Uploaded Receipts (".$get_files->rowCount().")</h5></div>";
        echo "<ol>";
            foreach($get_files as $rows){
              $file = $rows['file'];
              $file_type = $rows['file_type'];
              $payment_description = ucwords($rows['payment_description']);
              $date_created_raw = new DateTime($rows['date_created']);
              $date_created = $date_created_raw->format('l jS F, Y');
              $time_created = $date_created_raw->format('g:i a');


              if ($file_type=='document')
              {
                  $file_type='documents';
              }else if($file_type=='image')
              {
                  $file_type='images';
              }


              $file_href = "../uploads/alumni/{$file_type}/{$file}";
              $file_link = "<a target='_blank' href='{$file_href}'>{$file}</a>";
              echo "<li class='py-2'><strong>{$payment_description} - </strong> {$file_link} <br/><small>{$date_created} @ {$time_created}</small></li>";


            }
        echo "</ol>";
    }

?>

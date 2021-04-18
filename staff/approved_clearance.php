<?php

$clearance = new StudentClearance();
$applicant = new Applicant();
//$get_clearance_forms = $clearance->get_clearance_forms_by_unit($_SESSION['unit_id']);

?>

<div class="table">
  <table id='tblData2' class="table table-striped">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Matric</th>
        <?php
            if ($_SESSION['unit_id']=='41'){
                echo "<th scope='col'>Health Center No.</th>";
            }

        ?>
        <th scope="col">Surname</th>
        <th scope="col">Firstname</th>
        <th scope="col">Othername</th>
        <th scope="col">Date</th>
        <th scope="col"></th>

      </tr>
    </thead>
    <tbody>
      <?php
          if ($approved_clearance->rowCount()){
              $counter = 1;
              foreach($approved_clearance as $row){
                 $matric_no = $row['matric_no'];
                 $surname = $row['surname'];
                 $firstname = $row['firstname'];
                 $othername = $row['othername'];
                 $date_created = new DateTime($row['date_created']);
                 $date_created = $date_created->format('D. jS F, Y');

                 $student_clearance_form_link = "student_clearance_form.php?q=".mask($row['checkin_id']);
                 $open_button = "<a href='{$student_clearance_form_link}' class='btn btn-primary btn-rounded btn-sm'>Open form</a>";

                 // ------------- Get Student Health Center No ---------------------------
                 if ($_SESSION['unit_id']=='41'){
                       $health_center_no = '';
                       $get_health_center_no = $applicant->get_applicant_health_center_number($matric_no);
                       $get_health_center_no = $get_health_center_no->fetch(PDO::FETCH_ASSOC);


                       if ($get_health_center_no!=''){
                           $health_center_no = $get_health_center_no['HCN'];
                       }
                 }
                 //----------------End of Get Student Health Center No -----------------

                 echo "<tr>";
                    echo "<td>{$counter}.</td>";
                    echo "<td>{$matric_no}</td>";
                    if ($_SESSION['unit_id']=='41'){
                        echo "<td>{$health_center_no}</td>";
                    }
                    echo "<td>{$surname}</td>";
                    echo "<td>{$firstname}</td>";
                    echo "<td>{$othername}</td>";
                    echo "<td>{$date_created}</td>";
                    echo "<td>{$open_button}</td>";
                 echo "</tr>";

                 $counter++;
              }

          }else{
              echo "<tr><td colspan='7'>There are currently no approved clearance forms.</td></tr>";
          }
      ?>

    </tbody>
  </table>
</div>

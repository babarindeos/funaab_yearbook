<?php

$clearance = new StudentClearance();
//$get_clearance_forms = $clearance->get_clearance_forms_by_unit($_SESSION['unit_id']);

?>

<div class="table">
  <table id='tblData' class="table table-striped">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Matric</th>
        <th scope="col">Surname</th>
        <th scope="col">Firstname</th>
        <th scope="col">Othername</th>
        <th scope="col">Date</th>
        <th scope="col"></th>

      </tr>
    </thead>
    <tbody>
      <?php
          if ($awaiting_clearance->rowCount()){
              $counter = 1;
              foreach($awaiting_clearance as $row){
                 $matric_no = $row['matric_no'];
                 $surname = $row['surname'];
                 $firstname = $row['firstname'];
                 $othername = $row['othername'];
                 $date_created = new DateTime($row['date_created']);
                 $date_created = $date_created->format('D. jS F, Y');

                 $student_clearance_form_link = "student_clearance_form.php?q=".mask($row['checkin_id']);
                 $open_button = "<a href='{$student_clearance_form_link}' class='btn btn-primary btn-rounded btn-sm'>Open form</a>";

                 echo "<tr>";
                    echo "<td>{$counter}.</td>";
                    echo "<td>{$matric_no}</td>";
                    echo "<td>{$surname}</td>";
                    echo "<td>{$firstname}</td>";
                    echo "<td>{$othername}</td>";
                    echo "<td>{$date_created}</td>";
                    echo "<td>{$open_button}</td>";
                 echo "</tr>";

                 $counter++;
              }

          }else{
              echo "<tr><td colspan='7'>There are currently no clearance forms to treat.</td></tr>";
          }
      ?>

    </tbody>
  </table>
</div>

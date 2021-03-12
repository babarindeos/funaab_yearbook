<?php
  class StudentClearance{

      public function checkIn($division_id, $matric_no){



         $sqlQuery = "Insert into clearance_checkin set matric_no=:matric_no, division_id=:division_id,
                      date_created=:date_created, date_modified=:date_modified";

         $QueryExecutor = new PDO_QueryExecutor();
         $stmt = $QueryExecutor->customQuery()->prepare($sqlQuery);

         $date_created = date('Y-m-d H:i:s');
         $date_modified = date('Y-m-d H:i:s');

         // bind Params
         $stmt->bindParam(":matric_no", $matric_no);
         $stmt->bindParam(":division_id", $division_id);
         $stmt->bindParam(":date_created", $date_created);
         $stmt->bindParam(":date_modified", $date_modified);

         $stmt->execute();

         return $stmt;


      }

  }

?>

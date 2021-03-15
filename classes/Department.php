<?php
  class Department{

      public function get_dept_full_name($deptCode){
         //SqlQuery
         $sqlQuery = "Select dept_name from departments where dept_code=:dept_code";

         // PDO object
         $QueryExecutor = new PDO_QueryExecutor();
         $stmt = $QueryExecutor->customQuery()->prepare($sqlQuery);

         // bind Params
         $stmt->bindParam(":dept_code", $deptCode);

         // execute
         $stmt->execute();

         return $stmt;
      }


  }



?>

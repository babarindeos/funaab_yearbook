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


      public function get_all_units_dept_code(){
          //$sqlQuery
          $sqlQuery = "Select id, name from units order by id";

          $QueryExecutor = new PDO_QueryExecutor();
          $stmt = $QueryExecutor->customQuery()->prepare($sqlQuery);

          $stmt->execute();

          return $stmt;
      }

      public function get_all_units(){
          //$sqlQuery
          $sqlQuery = "Select id, name from units order by name";

          $QueryExecutor = new PDO_QueryExecutor();
          $stmt = $QueryExecutor->customQuery()->prepare($sqlQuery);

          $stmt->execute();

          return $stmt;
      }

      public function get_department_unit_id($deptCode){
          // $sqlQuery
          $sqlQuery = "Select id, name from units where name=:deptCode";

          $QueryExecutor = new PDO_QueryExecutor();
          $stmt = $QueryExecutor->customQuery()->prepare($sqlQuery);

          $stmt->bindParam(":deptCode", $deptCode);

          $stmt->execute();

          return $stmt;

      }


      public function get_unit_by_id($unit_id){
          // $sqlQuery
          $sqlQuery = "Select id, name from units where id=:id";

          $QueryExecutor = new PDO_QueryExecutor();
          $stmt = $QueryExecutor->customQuery()->prepare($sqlQuery);

          $stmt->bindParam(":id", $unit_id);

          $stmt->execute();

          return $stmt;

      }


  }



?>

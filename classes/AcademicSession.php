<?php

class AcademicSession implements AcademicSessionInterface{

    public function get_active_session(){

        // sqlQuery
        $sqlQuery = "Select * from academic_sessions where active=1";

        // pdo object
        $QueryExecutor = new PDO_QueryExecutor();
        $stmt = $QueryExecutor->customQuery()->prepare($sqlQuery);

        // pdo execute
        $stmt->execute();

        return $stmt;
    }

    static function active_session(){
      $sqlQuery = "Select * from academic_sessions where active=1";

      // pdo object
      $QueryExecutor = new PDO_QueryExecutor();
      $stmt = $QueryExecutor->customQuery()->prepare($sqlQuery);

      // pdo execute
      $stmt->execute();

      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      return $row['session'];
    }



}


?>

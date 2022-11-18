<?php

class AcademicSession implements AcademicSessionInterface{

    private $sqlQuery;
    private $stmt;
    private $QueryExecutor;

    public function __construct(){
        $this->sqlQuery = null;
        $this->stmt = null;
        $this->QueryExecutor = null;
    }



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

    public function get_sessions(){
        $this->sqlQuery = "Select id, session, active, date_created from academic_sessions order by id desc";

        // pdo object
        $this->QueryExecutor = new PDO_QueryExecutor();
        $this->stmt = $this->QueryExecutor->customQuery()->prepare($this->sqlQuery);

        $this->stmt->execute();

        return $this->stmt;
    }

    public function get_session_by_id($session_id){
        $this->sqlQuery = "Select id, session, active, date_created from academic_sessions where id=:id";

        // pdo object
        $this->QueryExecutor = new PDO_QueryExecutor();
        $this->stmt = $this->QueryExecutor->customQuery()->prepare($this->sqlQuery);

        $this->stmt->bindParam(":id", $session_id);
        $this->stmt->execute();

        return $this->stmt;
    }



}


?>

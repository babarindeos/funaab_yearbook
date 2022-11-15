<?php

  class College{

      private $sqlQuery;
      private $stmt;
      private $QueryExecutor;

      public function __construct(){
          $this->sqlQuery = null;
          $this->stmt = null;
          $this->QueryExecutor = null;
      }


      public function get_colleges(){
          $this->sqlQuery = "Select id, college_code, college_name, date_created from colleges order by college_code";

          $this->QueryExecutor = new PDO_QueryExecutor();
          $this->stmt =  $this->QueryExecutor->customQuery()->prepare($this->sqlQuery);

          $this->stmt->execute();
          return $this->stmt;
      }

      public function get_colleges_by_id($college_id){
          $this->sqlQuery = "Select id, college_code, college_name from colleges where id=:id";

          $this->QueryExecutor = new PDO_QueryExecutor();
          $this->stmt =  $this->QueryExecutor->customQuery()->prepare($this->sqlQuery);

          $this->stmt->bindParam(":id", $college_id);

          $this->stmt->execute();
          return $this->stmt;
      }


  }

?>

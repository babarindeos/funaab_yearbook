<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

  class YearBook{
      private $sqlQuery;
      private $QueryExecutor;
      private $stmt;

      public function __construct(){
          $this->sqlQuery = null;
          $this->QueryExecutor = null;
          $this->stmt = null;
      }

      public function checkforStudentData($matric_no){

          $this->sqlQuery = "Select * from yearbook where matric_no=:matric_no";

          $this->QueryExecutor = new PDO_QueryExecutor();
          $this->stmt = $this->QueryExecutor->customQuery()->prepare($this->sqlQuery);

          // bind param
          $this->stmt->bindParam(":matric_no", $matric_no);

          $this->stmt->execute();

          return $this->stmt;
      }

      public function updateYearBookData($fields){
        $matric_no = $fields['matric_no'];
        $session = $fields['session'];
        $fullname = $fields['fullname'];
        $dob_day = $fields['dob_day'];
        $dob_month = $fields['dob_month'];
        $dob = $fields['dob'];
        $email = $fields['email'];
        $phone = $fields['phone'];
        $address = $fields['address'];
        $photo = $fields['uploaded_passport'];

        echo $photo;


        $this->sqlQuery = "Update yearbook set session=:session, fullname=:fullname, dob_day=:dob_day, dob_month=:dob_month,
                           dob=:dob, email=:email, phone=:phone, address=:address, photo=:photo where matric_no=:matric_no";

        $this->QueryExecutor = new PDO_QueryExecutor();
        $this->stmt = $this->QueryExecutor->customQuery()->prepare($this->sqlQuery);

        // bind param
        $this->stmt->bindParam(":matric_no", $matric_no);
        $this->stmt->bindParam(":session", $session);
        $this->stmt->bindParam(":fullname", $fullname);
        $this->stmt->bindParam(":dob_day", $dob_day);
        $this->stmt->bindParam(":dob_month", $dob_month);
        $this->stmt->bindParam(":dob", $dob);
        $this->stmt->bindParam(":email", $email);
        $this->stmt->bindParam(":phone", $phone);
        $this->stmt->bindParam(":address", $address);
        $this->stmt->bindParam(":photo", $photo);

        $this->stmt->execute();

        return $this->stmt;
      }

      public function createYearBookData($fields){

          $matric_no = $fields['matric_no'];
          $session = $fields['session'];
          $fullname = $fields['fullname'];
          $dob_day = $fields['dob_day'];
          $dob_month = $fields['dob_month'];
          $dob = $fields['dob'];
          $email = $fields['email'];
          $phone = $fields['phone'];
          $address = $fields['address'];
          $photo = $fields['uploaded_passport'];


          $this->sqlQuery = "Insert into yearbook set session=:session, matric_no=:matric_no, fullname=:fullname, dob_day=:dob_day,
                             dob_month=:dob_month, dob=:dob, email=:email, phone=:phone, address=:address, photo=:photo";

          $this->QueryExecutor = new PDO_QueryExecutor();
          $this->stmt = $this->QueryExecutor->customQuery()->prepare($this->sqlQuery);

          // bind param
          $this->stmt->bindParam(":matric_no", $matric_no);
          $this->stmt->bindParam(":session", $session);
          $this->stmt->bindParam(":fullname", $fullname);
          $this->stmt->bindParam(":dob_day", $dob_day);
          $this->stmt->bindParam(":dob_month", $dob_month);
          $this->stmt->bindParam(":dob", $dob);
          $this->stmt->bindParam(":email", $email);
          $this->stmt->bindParam(":phone", $phone);
          $this->stmt->bindParam(":address", $address);
          $this->stmt->bindParam(":photo", $photo);

          $this->stmt->execute();

          return $this->stmt;
      }

  }


?>

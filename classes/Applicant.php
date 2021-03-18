<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class Applicant implements ApplicantInterface{

   public function getApplicant($regNumber){

      // $sqlQuery
      $sqlQuery = "SELECT regNumber, surname, firstname, othername, photo, gender, phone, email, level, majorCode, deptCode,
                   collegeCode, CGPA, acadaLevel, programme, dateCreated FROM applicants WHERE regNumber=:regNumber";

      // pdo object
      $QueryExecutor = new PDO_QueryExecutor();
      $stmt = $QueryExecutor->customQuery()->prepare($sqlQuery);

      // bind parameters
      $stmt->bindParam(":regNumber", $regNumber);

      // execute pdo
      $stmt->execute();

      return $stmt;

   }

   public function create_new_applicant($applicantData){
      $regNumber = $applicantData['regNumber'];
      $surname = $applicantData['surname'];
      $firstname = $applicantData['firstname'];
      $othername = $applicantData['othername'];
      $photo = $applicantData['photo'];
      $phone = $applicantData['phone'];
      $email = $applicantData['email'];
      $funaabEmail = $applicantData['funaabEmail'];
      $level = $applicantData['level'];
      $acadaLevel = $applicantData['acadaLevel'];
      $gender = $applicantData['gender'];
      $deptCode = $applicantData['deptCode'];
      $collegeCode = $applicantData['collegeCode'];
      $CGPA = $applicantData['CGPA'];
      //$highflyer = $applicantData['highflyer'];
      $minDuration = $applicantData['minDuration'];
      //$dateCreated = now();
      $dateCreated = date('Y-m-d H:i:s');

      $sqlQuery = "Insert into applicants set regNumber=:regNumber, surname=:surname, firstname=:firstname, othername=:othername, photo=:photo, phone=:phone,
                  email=:email, emailFunaab=:emailFunaab, level=:level, acadaLevel=:acadaLevel, gender=:gender, deptCode=:deptCode, collegeCode=:collegeCode, CGPA=:CGPA,
                  minDuration=:minDuration, dateCreated=:dateCreated";

      // pdo Object
      $QueryExecutor = new PDO_QueryExecutor();
      $stmt = $QueryExecutor->customQuery()->prepare($sqlQuery);

      //bindParams
      $stmt->bindParam(":regNumber", $regNumber);
      $stmt->bindParam(":surname", $surname);
      $stmt->bindParam(":firstname", $firstname);
      $stmt->bindParam(":othername", $othername);
      $stmt->bindParam(":photo", $photo);
      $stmt->bindParam(":phone", $phone);
      $stmt->bindParam(":email", $email);
      $stmt->bindParam(":emailFunaab", $funaabEmail);
      $stmt->bindParam(":level", $level);
      $stmt->bindParam(":acadaLevel", $acadaLevel);
      $stmt->bindParam(":gender", $gender);
      $stmt->bindParam(":deptCode", $deptCode);
      $stmt->bindParam(":collegeCode", $collegeCode);
      $stmt->bindParam(":CGPA", $CGPA);
      //$stmt->bindParam(":highflyer", $highflyer);
      $stmt->bindParam(":minDuration", $minDuration);
      $stmt->bindParam(":dateCreated", $dateCreated);

      // execute pdo
      $stmt->execute();

      return $stmt;
   }

   public function get_applicant_email($matric){
      $sqlQuery = "Select email from applicants where regNumber=:regNumber";

      // pdo Object
      $QueryExecutor = new PDO_QueryExecutor();
      $stmt = $QueryExecutor->customQuery()->prepare($sqlQuery);

      //bind Params
      $stmt->bindParam(":regNumber", $matric);

      $stmt->execute();

      return $stmt;
   }


}



?>

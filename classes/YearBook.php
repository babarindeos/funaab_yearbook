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
        $hoc = $fields['hoc'];
        $status = '';
        $status_msg = '';
        $date_modified = date('Y-m-d H:i:s');

        $this->sqlQuery = "Update yearbook set session=:session, fullname=:fullname, dob_day=:dob_day, dob_month=:dob_month,
                           dob=:dob, email=:email, phone=:phone, address=:address, photo=:photo, hoc=:hoc, status=:status,
                           status_msg=:status_msg, date_modified=:date_modified where matric_no=:matric_no";

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
        $this->stmt->bindParam(":hoc", $hoc);
        $this->stmt->bindParam(":status", $status);
        $this->stmt->bindParam(":status_msg", $status_msg);
        $this->stmt->bindParam(":date_modified", $date_modified);


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
          $hoc = $fields['hoc'];
          $status = '';
          $status_msg = '';


          $this->sqlQuery = "Insert into yearbook set session=:session, matric_no=:matric_no, fullname=:fullname, dob_day=:dob_day,
                             dob_month=:dob_month, dob=:dob, email=:email, phone=:phone, address=:address, photo=:photo, hoc=:hoc,
                             status=:status, status_msg=:status_msg";

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
          $this->stmt->bindParam(":hoc", $hoc);
          $this->stmt->bindParam(":status", $status);
          $this->stmt->bindParam(":status_msg", $status_msg);

          $this->stmt->execute();

          return $this->stmt;
      }

      public function get_students($academic_session){

          $this->sqlQuery = "Select a.regNumber, a.surname, a.firstname, a.othername, a.photo as avatar, a.gender, a.phone as phone1, a.email as email1,
          a.emailFunaab, a.level, a.deptCode, a.collegeCode, a.acadaLevel, y.session, y.fullname, y.matric_no, y.dob, y.email as email2, y.phone as phone2,
          y.address, y.photo, y.date_created from yearbook y inner join applicants a on a.regNumber=y.matric_no where y.session=:session order by y.id desc";

          $this->QueryExecutor = new PDO_QueryExecutor();
          $this->stmt = $this->QueryExecutor->customQuery()->prepare($this->sqlQuery);

          // bind param
          $this->stmt->bindParam(":session", $academic_session);

          $this->stmt->execute();

          return $this->stmt;
      }

      public function get_students_by_department($academic_session, $dept_code){
          $this->sqlQuery = "Select a.regNumber, a.surname, a.firstname, a.othername, a.photo as avatar, a.gender, a.phone as phone1, a.email as email1,
          a.emailFunaab, a.level, a.deptCode, a.collegeCode, a.acadaLevel, y.session, y.fullname, y.matric_no, y.dob, y.email as email2, y.phone as phone2,
          y.address, y.photo, y.date_created from yearbook y inner join applicants a on a.regNumber=y.matric_no where a.deptCode=:deptCode and y.session=:session order by y.id desc";

          $this->QueryExecutor = new PDO_QueryExecutor();
          $this->stmt = $this->QueryExecutor->customQuery()->prepare($this->sqlQuery);

          // bind param
          $this->stmt->bindParam(":session", $academic_session);
          $this->stmt->bindParam(":deptCode", $dept_code);

          $this->stmt->execute();

          return $this->stmt;
      }

      public function get_college_depts($academic_session, $collegeCode){
          $this->sqlQuery = "SELECT a.collegeCode, a.deptCode, y.session, count(a.deptCode) as studentCount from applicants a inner join yearbook y on a.regNumber=y.matric_no
                            GROUP by a.collegeCode, a.deptCode, y.session having a.collegeCode=:collegeCode and y.session=:session";

          $this->QueryExecutor = new PDO_QueryExecutor();
          $this->stmt = $this->QueryExecutor->customQuery()->prepare($this->sqlQuery);

          //bind param
          $this->stmt->bindParam(":collegeCode", $collegeCode);
          $this->stmt->bindParam(":session", $academic_session);

          $this->stmt->execute();

          return $this->stmt;
      }

      public function get_all_colleges($current_session){
          $this->sqlQuery = "SELECT a.collegeCode, count(a.collegeCode) as collegeCount, y.session  from applicants a inner join yearbook y on a.regNumber=y.matric_no
                          GROUP by a.collegeCode, y.session having y.session=:session";

          $this->QueryExecutor = new PDO_QueryExecutor();
          $this->stmt = $this->QueryExecutor->customQuery()->prepare($this->sqlQuery);

          //bind param
          $this->stmt->bindParam(":session", $current_session);

          $this->stmt->execute();

          return $this->stmt;
      }

      public function checkforDeanData($file_no, $current_session){

          $this->sqlQuery = "Select * from deans_submissions where file_no=:file_no and session=:session";

          $this->QueryExecutor = new PDO_QueryExecutor();
          $this->stmt = $this->QueryExecutor->customQuery()->prepare($this->sqlQuery);

          // bind param
          $this->stmt->bindParam(":file_no", $file_no);
          $this->stmt->bindParam(":session", $current_session);

          $this->stmt->execute();

          return $this->stmt;
      }


      public function updateDeanData($fields){
        $file_no = $fields['file_no'];
        $session = $fields['session'];
        $fullname = $fields['fullname'];
        $qualifications = $fields['qualifications'];
        $photo = $fields['uploaded_passport'];
        $message = $fields['message'];


        $this->sqlQuery = "Update deans_submissions set session=:session, fullname=:fullname,
                           qualifications=:qualifications, passport=:passport, message=:message where file_no=:file_no";

        $this->QueryExecutor = new PDO_QueryExecutor();
        $this->stmt = $this->QueryExecutor->customQuery()->prepare($this->sqlQuery);

        // bind param
        $this->stmt->bindParam(":file_no", $file_no);
        $this->stmt->bindParam(":session", $session);
        $this->stmt->bindParam(":fullname", $fullname);
        $this->stmt->bindParam(":qualifications", $qualifications);
        $this->stmt->bindParam(":passport", $photo);
        $this->stmt->bindParam(":message", $message);

        $this->stmt->execute();

        return $this->stmt;
      }

      public function createDeanData($fields){

          $file_no = $fields['file_no'];
          $session = $fields['session'];
          $fullname = $fields['fullname'];
          $qualifications = $fields['qualifications'];
          $college = $fields['college'];
          $photo = $fields['uploaded_passport'];
          $message =  $fields['message'];


          $this->sqlQuery = "Insert into deans_submissions set session=:session, college_id=:college_id, file_no=:file_no, fullname=:fullname,
                             qualifications=:qualifications, passport=:passport, message=:message";

          $this->QueryExecutor = new PDO_QueryExecutor();
          $this->stmt = $this->QueryExecutor->customQuery()->prepare($this->sqlQuery);

          // bind param
          $this->stmt->bindParam(":file_no", $file_no);
          $this->stmt->bindParam(":session", $session);
          $this->stmt->bindParam(":fullname", $fullname);
          $this->stmt->bindParam(":college_id", $college);
          $this->stmt->bindParam(":qualifications", $qualifications);
          $this->stmt->bindParam(":message", $message);
          $this->stmt->bindParam(":passport", $photo);

          $this->stmt->execute();

          return $this->stmt;
      }

      public function get_dean_access($acad_session){
          $this->sqlQuery = "Select id, session, college_id, file_no, fullname, email, phone, date_created from registered_deans where session=:session";

          $this->QueryExecutor = new PDO_QueryExecutor();
          $this->stmt = $this->QueryExecutor->customQuery()->prepare($this->sqlQuery);

          // bind param
          $this->stmt->bindParam(":session", $acad_session);

          $this->stmt->execute();

          return $this->stmt;

      }


      public function get_hod_access($acad_session){
          $this->sqlQuery = "Select id, session, college_id, file_no, fullname, email, phone, date_created from registered_deans where session=:session";

          $this->QueryExecutor = new PDO_QueryExecutor();
          $this->stmt = $this->QueryExecutor->customQuery()->prepare($this->sqlQuery);

          // bind param
          $this->stmt->bindParam(":session", $acad_session);

          $this->stmt->execute();

          return $this->stmt;
      }



  }


?>

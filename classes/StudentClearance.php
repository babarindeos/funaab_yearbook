<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

  class StudentClearance{

      private $stmt;
      private $QueryExecutor;

      public function __construct(){
          $this->stmt = null;
          $this->QueryExecutor = null;
      }

      public function __destruct(){
          $this->stmt = null;
          $this->QueryExecutor = null;
      }

      public function checkIn($current_active_session, $division_id, $unit_id, $matric_no){

         $sqlQuery = "Insert into clearance_checkin set acad_session=:acad_session, matric_no=:matric_no, division_id=:division_id,
                      unit_id=:unit_id, date_created=:date_created, date_modified=:date_modified";

         $this->QueryExecutor = new PDO_QueryExecutor();
         $this->stmt = $this->QueryExecutor->customQuery()->prepare($sqlQuery);
         $this->QueryExecutor = null;

         $date_created = date('Y-m-d H:i:s');
         $date_modified = date('Y-m-d H:i:s');

         // bind Params
         $this->stmt->bindParam(":acad_session", $current_active_session);
         $this->stmt->bindParam(":matric_no", $matric_no);
         $this->stmt->bindParam(":division_id", $division_id);
         $this->stmt->bindParam(":unit_id", $unit_id);
         $this->stmt->bindParam(":date_created", $date_created);
         $this->stmt->bindParam(":date_modified", $date_modified);

         $this->stmt->execute();

         return $this->stmt;

      }

      public function get_checkin_status($division_id, $matric_no){

          //echo $division_id;
          //echo "<br/>".$matric_no;
         // SqlQuery

         $sqlQuery = "Select * from clearance_checkin where division_id=:division_id and matric_no=:matric_no";

         // PDO object
         $this->QueryExecutor = new PDO_QueryExecutor();
         $this->stmt = $this->QueryExecutor->customQuery()->prepare($sqlQuery);
         $this->QueryExecutor = null;

         // bind Params
         $this->stmt->bindParam(":division_id", trim($division_id));
         $this->stmt->bindParam(":matric_no", trim($matric_no));

         // stmt execute
         $this->stmt->execute();

         return $this->stmt;


      }


      public function clearance_submission_in_unit($unit_id){

          // SqlQuery
          $sqlQuery = "Select cc.id as checkin_id, cc.matric_no, cc.division_id, cc.unit_id, cc.cleared, cc.reason, cc.remedy, cc.date_created,
                      a.surname, a.firstname, a.othername, a.photo, a.gender, a.phone, a.email, a.emailFunaab, a.level, a.deptCode
                      from clearance_checkin cc inner join applicants a on cc.matric_no=a.regNumber where cc.unit_id=:unit_id ";

          $this->QueryExecutor = new PDO_QueryExecutor();
          $this->stmt = $this->QueryExecutor->customQuery()->prepare($sqlQuery);
          $this->QueryExecutor = null;

          // bindParam
          $this->stmt->bindParam(":unit_id", $unit_id);

          // execute
          $this->stmt->execute();

          return $this->stmt;
      }


      public function awaiting_clearance_in_unit($unit_id){

          // SqlQuery
          $sqlQuery = "Select cc.id as checkin_id, cc.matric_no, cc.division_id, cc.unit_id, cc.cleared, cc.reason, cc.remedy, cc.date_created,
                      a.surname, a.firstname, a.othername, a.photo, a.gender, a.phone, a.email, a.emailFunaab, a.level, a.deptCode
                      from clearance_checkin cc inner join applicants a on cc.matric_no=a.regNumber where cc.unit_id=:unit_id and cc.cleared='' ";

          $this->QueryExecutor = new PDO_QueryExecutor();
          $this->stmt = $this->QueryExecutor->customQuery()->prepare($sqlQuery);
          $this->QueryExecutor = null;

          // bindParam
          $this->stmt->bindParam(":unit_id", $unit_id);

          // execute
          $this->stmt->execute();

          return $this->stmt;
      }



      public function approved_clearance_in_unit($unit_id){

          // SqlQuery
          $sqlQuery = "Select cc.id as checkin_id, cc.matric_no, cc.division_id, cc.unit_id, cc.cleared, cc.reason, cc.remedy, cc.date_created,
                      a.surname, a.firstname, a.othername, a.photo, a.gender, a.phone, a.email, a.emailFunaab, a.level, a.deptCode
                      from clearance_checkin cc inner join applicants a on cc.matric_no=a.regNumber where cc.unit_id=:unit_id and cc.cleared='Y' ";

          $this->QueryExecutor = new PDO_QueryExecutor();
          $this->stmt = $this->QueryExecutor->customQuery()->prepare($sqlQuery);
          $this->QueryExecutor = null;

          // bindParam
          $this->stmt->bindParam(":unit_id", $unit_id);

          // execute
          $this->stmt->execute();

          return $this->stmt;
      }


      public function declined_clearance_in_unit($unit_id){

          // SqlQuery
          $sqlQuery = "Select cc.id as checkin_id, cc.matric_no, cc.division_id, cc.unit_id, cc.cleared, cc.reason, cc.remedy, cc.date_created,
                      a.surname, a.firstname, a.othername, a.photo, a.gender, a.phone, a.email, a.emailFunaab, a.level, a.deptCode
                      from clearance_checkin cc inner join applicants a on cc.matric_no=a.regNumber where cc.unit_id=:unit_id and cc.cleared='N' ";

          $this->QueryExecutor = new PDO_QueryExecutor();
          $this->stmt = $this->QueryExecutor->customQuery()->prepare($sqlQuery);
          $this->QueryExecutor = null;

          // bindParam
          $this->stmt->bindParam(":unit_id", $unit_id);

          // execute
          $this->stmt->execute();


          return $this->stmt;
      }


      public function get_clearance_checkin_by_id($checkin_id){
          // SqlQuery
          $sqlQuery = "Select cc.id as checkin_id, cc.matric_no, cc.division_id, cc.unit_id, cc.cleared, cc.remark, cc.reason, cc.remedy, cc.date_created,
                      a.surname, a.firstname, a.othername, a.photo, a.gender, a.phone, a.email, a.emailFunaab, a.level, a.deptCode, a.collegeCode
                      from clearance_checkin cc inner join applicants a on cc.matric_no=a.regNumber where cc.id=:id";

          $this->QueryExecutor = new PDO_QueryExecutor();
          $this->stmt = $this->QueryExecutor->customQuery()->prepare($sqlQuery);
          $this->QueryExecutor = null;

          // bindParam
          $this->stmt->bindParam(":id", $checkin_id);

          // execute
          $this->stmt->execute();

          return $this->stmt;
      }

      public function execute_clearance_form($fields){
          $checkin_id = $fields['checkin_id'];
          $clearance_option = $fields['clearance_option'];
          $remark = $fields['remark'];
          $reason = $fields['reason'];
          $remedy = $fields['remedy'];

          $date_modified = date('Y-m-d H:i:s');

          //SqlQuery
          $sqlQuery = "Update clearance_checkin set cleared=:clearance_option, remark=:remark, reason=:reason, remedy=:remedy,
                      date_modified=:date_modified where id=:checkin_id";

          $this->QueryExecutor = new PDO_QueryExecutor();
          $this->stmt = $this->QueryExecutor->customQuery()->prepare($sqlQuery);
          $this->QueryExecutor = null;

          //bind Params
          $this->stmt->bindParam(":clearance_option", $clearance_option);
          $this->stmt->bindParam(":remark", $remark);
          $this->stmt->bindParam(":reason", $reason);
          $this->stmt->bindParam(":remedy", $remedy);
          $this->stmt->bindParam(":date_modified", $date_modified);
          $this->stmt->bindParam(":checkin_id", $checkin_id);

          //execute
          $this->stmt->execute();

          return $this->stmt;
      }



      public function get_no_of_clearance_submission_by_unit($unit_id){
          $sqlQuery= "Select count(id) as total_submission from clearance_checkin where unit_id=:unit_id ";

          $this->QueryExecutor = new PDO_QueryExecutor();
          $this->stmt = $this->QueryExecutor->customQuery()->prepare($sqlQuery);
          $this->QueryExecutor = null;

          // bindParam
          $this->stmt->bindParam(":unit_id", $unit_id);

          // execute
          $this->stmt->execute();

          $this->stmt = $this->stmt->fetch(PDO::FETCH_ASSOC);

          return $this->stmt['total_submission'];
      }


      public function get_no_of_awaiting_clearance_in_unit($unit_id){
          $sqlQuery= "Select count(id) as pending from clearance_checkin where unit_id=:unit_id and cleared='' ";

          $this->QueryExecutor = new PDO_QueryExecutor();
          $this->stmt = $this->QueryExecutor->customQuery()->prepare($sqlQuery);
          $this->QueryExecutor = null;

          // bindParam
          $this->stmt->bindParam(":unit_id", $unit_id);

          // execute
          $this->stmt->execute();

          $this->stmt = $this->stmt->fetch(PDO::FETCH_ASSOC);
          return $this->stmt['pending'];
      }

      public function get_no_of_approved_clearance_in_unit($unit_id){
          $sqlQuery= "Select count(id) as approved from clearance_checkin where unit_id=:unit_id and cleared='Y' ";

          $this->QueryExecutor = new PDO_QueryExecutor();
          $this->stmt = $this->QueryExecutor->customQuery()->prepare($sqlQuery);
          $this->QueryExecutor = null;

          // bindParam
          $this->stmt->bindParam(":unit_id", $unit_id);

          // execute
          $this->stmt->execute();

          $this->stmt = $this->stmt->fetch(PDO::FETCH_ASSOC);
          return $this->stmt['approved'];
      }

      public function get_no_of_declined_clearance_in_unit($unit_id){
          $sqlQuery= "Select count(id) as declined from clearance_checkin where unit_id=:unit_id and cleared='N' ";

          $this->QueryExecutor = new PDO_QueryExecutor();
          $this->stmt = $this->QueryExecutor->customQuery()->prepare($sqlQuery);
          $this->QueryExecutor = null;

          // bindParam
          $this->stmt->bindParam(":unit_id", $unit_id);

          // execute
          $this->stmt->execute();

          $this->stmt = $this->stmt->fetch(PDO::FETCH_ASSOC);
          return $this->stmt['declined'];
      }


      public function save_file_info($fields){

          $rrr = $fields['rrr'];
          $file = $fields['file'];
          $matric_no = $fields['matric_no'];
          $payment_description = $fields['payment_description'];
          $unit_id = $fields['unit_id'];
          $file_type = $fields['file_type'];
          $file_extension = $fields['file_extension'];

          // SqlQuery
          $sqlQuery = "Insert into files set matric_no=:matric_no, unit_id=:unit_id, rrr=:rrr, file=:file, payment_description=:payment_description,
                      file_type=:file_type, file_extension=:file_extension";

          // PDO Object
          $this->QueryExecutor = new PDO_QueryExecutor();
          $this->stmt = $this->QueryExecutor->customQuery()->prepare($sqlQuery);
          $this->QueryExecutor = null;

          // bind parameters
          $this->stmt->bindParam(":matric_no", $matric_no);
          $this->stmt->bindParam(":unit_id", $unit_id);
          $this->stmt->bindParam(":rrr", $rrr);
          $this->stmt->bindParam(":file", $file);
          $this->stmt->bindParam(":payment_description", $payment_description);
          $this->stmt->bindParam(":file_type", $file_type);
          $this->stmt->bindParam(":file_extension", $file_extension);

          // execute PDO Object
          $this->stmt->execute();

          $response = '';

          if ($this->stmt->rowCount()){
              $response = array("status"=>'success', "msg"=>'File has been successfully saved.');
          }else{
              $response = array("status"=>'failed', "msg"=>'An error occurred saving info into the database');
          }

          return $response;

      }



  }

?>

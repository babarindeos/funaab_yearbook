<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

  class Registration implements RegistrationInterface{

    private $matric_no;

    public function is_user_registered($matric_no){

      $this->matric_no = $matric_no;

      // sqlQuery
      $sqlQuery = "Select * from registration where matric_no=:matric_no";

      // pdo Object
      $QueryExecutor = new PDO_QueryExecutor();
      $stmt = $QueryExecutor->customQuery()->prepare($sqlQuery);

      // bind Params
      $stmt->bindParam(":matric_no", $this->matric_no);

      // execute pdo
      $stmt->execute();

      return $stmt;

    }

    public function new_registration($regData){

        // $sqlQuery
        $sqlQuery = "Insert into registration set academic_session=:academic_session, matric_no=:matric_no, alt_email=:alt_email, alt_phone=:alt_phone,
                    home_address=:home_address, parent_names=:parent_names, parent_phone_no=:parent_phone_no, next_of_kin=:next_of_kin,
                    nok_phone_no=:nok_phone_no, bank_name=:bank_name, bank_account_no=:bank_account_no, bank_sort_code=:bank_sort_code,
                    date_created=:date_created, date_modified=:date_modified
";

        $QueryExecutor = new PDO_QueryExecutor();
        $stmt = $QueryExecutor->customQuery()->prepare($sqlQuery);

        $date_created = date('Y-m-d H:i:s');
        $date_modified = date('Y-m-d H:i:s');

        // bind parameters
        $stmt->bindParam(":academic_session", $regData['academic_session']);
        $stmt->bindParam(":matric_no", $regData['matric_no']);
        $stmt->bindParam(":alt_email", $regData['alt_email']);
        $stmt->bindParam(":alt_phone", $regData['alt_phone']);
        $stmt->bindParam(":home_address", $regData['home_address']);
        $stmt->bindParam(":parent_names", $regData['parent_names']);
        $stmt->bindParam(":parent_phone_no", $regData['parent_phone_no']);
        $stmt->bindParam(":next_of_kin", $regData['next_of_kin']);
        $stmt->bindParam(":nok_phone_no", $regData['nok_phone_no']);
        $stmt->bindParam(":bank_name", $regData['bank_name']);
        $stmt->bindParam(":bank_account_no", $regData['bank_account_no']);
        $stmt->bindParam(":bank_sort_code", $regData['bank_sort_code']);
        $stmt->bindParam(":date_created", $date_created);
        $stmt->bindParam(":date_modified", $date_modified);


        $stmt->execute();

        return $stmt;
    }

    public function update_registration($regData){
      // $sqlQuery
      $sqlQuery = "Update registration set academic_session=:academic_session, alt_email=:alt_email, alt_phone=:alt_phone,
                  home_address=:home_address, parent_names=:parent_names, parent_phone_no=:parent_phone_no, next_of_kin=:next_of_kin,
                  nok_phone_no=:nok_phone_no, bank_name=:bank_name, bank_account_no=:bank_account_no, bank_sort_code=:bank_sort_code,
                  date_modified=:date_modified where matric_no=:matric_no ";

      $QueryExecutor = new PDO_QueryExecutor();
      $stmt = $QueryExecutor->customQuery()->prepare($sqlQuery);


      $date_modified = date('Y-m-d H:i:s');

      // bind parameters
      $stmt->bindParam(":academic_session", $regData['academic_session']);
      $stmt->bindParam(":matric_no", $regData['matric_no']);
      $stmt->bindParam(":alt_email", $regData['alt_email']);
      $stmt->bindParam(":alt_phone", $regData['alt_phone']);
      $stmt->bindParam(":home_address", $regData['home_address']);
      $stmt->bindParam(":parent_names", $regData['parent_names']);
      $stmt->bindParam(":parent_phone_no", $regData['parent_phone_no']);
      $stmt->bindParam(":next_of_kin", $regData['next_of_kin']);
      $stmt->bindParam(":nok_phone_no", $regData['nok_phone_no']);
      $stmt->bindParam(":bank_name", $regData['bank_name']);
      $stmt->bindParam(":bank_account_no", $regData['bank_account_no']);
      $stmt->bindParam(":bank_sort_code", $regData['bank_sort_code']);
      $stmt->bindParam(":date_modified", $date_modified);

      $stmt->execute();

      return $stmt;
    }

    public function report_get_registrations()
    {
      // sql query
      $sqlQuery = "Select r.academic_session, r.matric_no, r.alt_email, r.alt_phone, r.home_address, r.parent_names, r.parent_phone_no,
                  r.next_of_kin, r.nok_phone_no, r.bank_name, r.bank_account_no, r.bank_sort_code, r.date_created, a.surname, a.firstname,
                  a.othername, a.photo from registration r inner join applicants a on r.matric_no=a.regNumber order by r.id desc";

      $QueryExecutor = new PDO_QueryExecutor();
      $stmt = $QueryExecutor->customQuery()->prepare($sqlQuery);

      $stmt->execute();

      return $stmt;

    }



  }



?>

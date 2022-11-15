<?php

  class StaffUser extends User implements UserInterface {

      // public function __construct($file_no, $title, $firstname, $lastname, $othernames, $avatar){
      //     parent::__construct($file_no, $title, $firstname, $lastname, $othernames, $avatar);
      // }
      private $username;
      private $password;

      public function getUserById($user_id){
          $this->user_id = $user_id;
          $sqlQuery =  "Select * from users where id=:id";

          $QueryExecutor = new PDO_QueryExecutor();
          $stmt = $QueryExecutor::customQuery()->prepare($sqlQuery);
          $QueryExecutor = null;

          $stmt->bindParam(":id",$this->user_id);

          $stmt->execute();

          return $stmt;
      }

      public function get_staff_by_id($user_id){
          $this->user_id = $user_id;

          $sqlQuery =  "Select * from staff where id=:id";

          $QueryExecutor = new PDO_QueryExecutor();
          $stmt = $QueryExecutor::customQuery()->prepare($sqlQuery);
          $QueryExecutor = null;

          $stmt->bindParam(":id",$this->user_id);

          $stmt->execute();

          return $stmt;
      }

      public function get_all_staff(){

          // sql statement
          $sqlQuery = "Select s.id, s.file_no, s.names, s.email, s.phone, s.unit_id, u.name as unit, s.date_created from staff s inner join units u
                       on s.unit_id=u.id order by s.id desc";

          // PDOStatement, prepare and execute
          $QueryExecutor = new PDO_QueryExecutor();
          $stmt = $QueryExecutor->customQuery()->prepare($sqlQuery);
          $QueryExecutor = null;

          $stmt->execute();
          return $stmt;

      }

      // public function get_all_staff(){
      //
      //     // sql statement
      //     $sqlQuery = "Select u.id, u.file_no, u.title, u.first_name, u.last_name,
      //                 u.other_names, u.position, u.avatar, u.date_created, u.date_modified, a.email, a.role from
      //                 users u inner join auth a on u.id=a.user_id where a.role='staff' ";
      //
      //     // PDOStatement, prepare and execute
      //     $QueryExecutor = new PDO_QueryExecutor();
      //     $stmt = $QueryExecutor->customQuery()->prepare($sqlQuery);
      //     $stmt->execute();
      //     return $stmt;
      //
      // }


      public function email_exist($email){
          $this->email = $email;

          // sql statement
          $sqlQuery = "Select * from auth where email=:email";

          // pdo object, prepare
          $QueryExecutor = new PDO_QueryExecutor();
          $stmt = $QueryExecutor->customQuery()->prepare($sqlQuery);
          $QueryExecutor = null;

          // bind parameters
          $stmt->bindParam(":email", $this->email);

          // execute $stmt
          $stmt->execute();
          return $stmt;
      }


      public function get_staff_by_username_password($username, $password){
          $this->username = $username;
          $this->password = $password;

          // sql statement
          $sqlQuery = "Select * from staff where file_no=:username and password=:password";

          //PDO object
          $QueryExecutor = new PDO_QueryExecutor();
          $stmt = $QueryExecutor->customQuery()->prepare($sqlQuery);
          $QueryExecutor = null;

          // bind Params
          $stmt->bindParam(":username", $this->username);
          $stmt->bindParam(":password", $this->password);

          // execute
          $stmt->execute();

          return $stmt;

      }


      public function confirm_user_password($user_id, $current_password_encrypt){
          // $sqlQuery
          $sqlQuery = "Select * from staff where id=:user_id and password=:password";

          //PDO Object
          $QueryExecutor = new PDO_QueryExecutor();
          $stmt = $QueryExecutor->customQuery()->prepare($sqlQuery);
          $QueryExecutor = null;

          // bind parameter
          $stmt->bindParam(":user_id", $user_id);
          $stmt->bindParam(":password", $current_password_encrypt);

          // execute
          $stmt->execute();

          return $stmt;
      }

      public function change_user_password($user_id, $new_password_encrypt){
          //$sqlQuery
          $sqlQuery = "Update staff set password=:password where id=:user_id";

          //PDO Object
          $QueryExecutor = new PDO_QueryExecutor();
          $stmt = $QueryExecutor->customQuery()->prepare($sqlQuery);
          $QueryExecutor = null;

          // bind Params
          $stmt->bindParam(":user_id", $user_id);
          $stmt->bindParam(":password", $new_password_encrypt);

          // execute
          $stmt->execute();

          return $stmt;
      }


      public function create_staff($fields){


          $file_no = $fields['file_no'];
          $names = $fields['full_name'];
          $funaab_email = $fields['funaab_email'];
          $phone = $fields['phone'];
          $unit_id = $fields['unit_id'];
          $dept_code = $fields['dept_code'];
          $dept_name = $fields['dept_name'];
          $password = $fields['password'];
          $verification_code = $fields['verification_code'];

          $date_created = date('Y-m-d H:i:s');
          $date_modified = date('Y-m-d H:i:s');

          //$sqlQuery
          $sqlQuery = "Insert into staff set file_no=:file_no, names=:names, email=:email, phone=:phone, unit_id=:unit_id,
                      dept_code=:dept_code, dept_name=:dept_name, password=:password, verification_code=:verification_code,
                      date_created=:date_created, date_modified=:date_modified";

          $QueryExecutor = new PDO_QueryExecutor();
          $stmt =  $QueryExecutor->customQuery()->prepare($sqlQuery);
          $QueryExecutor = null;

          // bind Params
          $stmt->bindParam(":file_no", $file_no);
          $stmt->bindParam(":names", $names);
          $stmt->bindParam(":email", $funaab_email);
          $stmt->bindParam(":phone", $phone);
          $stmt->bindParam(":unit_id", $unit_id);
          $stmt->bindParam(":dept_code", $dept_code);
          $stmt->bindParam(":dept_name", $dept_name);
          $stmt->bindParam(":password", $password);
          $stmt->bindParam(":verification_code", $verification_code);
          $stmt->bindParam(":date_created", $date_created);
          $stmt->bindParam(":date_modified", $date_modified);

          //is_executable
          $stmt->execute();

          return $stmt;
      }


      public function register_dean($fields){
          $session = $fields['session'];
          $file_no = $fields['file_no'];
          $college_id = $fields['college_id'];
          $file_no = $fields['file_no'];
          $fullname = $fields['fullname'];
          $email = $fields['funaab_email'];
          $phone = $fields['phone'];
          $password = $fields['password'];
          $password_encrypt = $fields['password_encrypt'];
          $access_code = $password_encrypt;
          $verification_code = $fields['verification_code'];

          $sqlQuery = "Insert into registered_deans set session=:session, college_id=:college_id, file_no=:file_no,
                      fullname=:fullname, email=:email, phone=:phone, access_code=:access_code, verification_code=:verification_code";

          $QueryExecutor = new PDO_QueryExecutor();
          $stmt = $QueryExecutor->customQuery()->prepare($sqlQuery);

          $stmt->bindParam(":session", $session);
          $stmt->bindParam(":college_id", $college_id);
          $stmt->bindParam(":file_no", $file_no);
          $stmt->bindParam(":fullname", $fullname);
          $stmt->bindParam(":email", $email);
          $stmt->bindParam(":phone", $phone);
          $stmt->bindParam(":access_code", $access_code);
          $stmt->bindParam(":verification_code", $verification_code);

          $stmt->execute();

          return $stmt;
      }

      public function get_dean_info($auth_id){
          $sqlQuery = "Select id, session, college_id, file_no, fullname, email, phone, access_code, verification_code, date_created
                       from registered_deans where id=:id";

          $QueryExecutor = new PDO_QueryExecutor();
          $stmt = $QueryExecutor->customQuery()->prepare($sqlQuery);

          $stmt->bindParam(":id", $auth_id);

          $stmt->execute();

          return $stmt;

      }


      public function is_dean_registered($active_session, $file_no){

          $this->sqlQuery = "Select id, file_no, fullname from registered_deans where session=:session and file_no=:file_no";
          $this->QueryExecutor = new PDO_QueryExecutor();
          $this->stmt = $this->QueryExecutor->customQuery()->prepare($this->sqlQuery);

          // bind param
          $this->stmt->bindParam(":session", $active_session);
          $this->stmt->bindParam(":file_no", $file_no);

          $this->stmt->execute();

          return $this->stmt;
      }

  }


 ?>

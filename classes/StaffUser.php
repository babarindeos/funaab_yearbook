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

          $stmt->bindParam(":id",$this->user_id);

          $stmt->execute();

          return $stmt;
      }

      public function get_staff_by_id($user_id){
          $this->user_id = $user_id;
          $sqlQuery =  "Select * from staff where id=:id";
          $QueryExecutor = new PDO_QueryExecutor();
          $stmt = $QueryExecutor::customQuery()->prepare($sqlQuery);

          $stmt->bindParam(":id",$this->user_id);

          $stmt->execute();

          return $stmt;
      }

      public function get_all_staff(){

          // sql statement
          $sqlQuery = "Select u.id, u.file_no, u.title, u.first_name, u.last_name,
                      u.other_names, u.position, u.avatar, u.date_created, u.date_modified, a.email, a.role from
                      users u inner join auth a on u.id=a.user_id where a.role='staff' ";

          // PDOStatement, prepare and execute
          $QueryExecutor = new PDO_QueryExecutor();
          $stmt = $QueryExecutor->customQuery()->prepare($sqlQuery);
          $stmt->execute();
          return $stmt;

      }


      public function email_exist($email){
          $this->email = $email;

          // sql statement
          $sqlQuery = "Select * from auth where email=:email";

          // pdo object, prepare
          $QueryExecutor = new PDO_QueryExecutor();
          $stmt = $QueryExecutor->customQuery()->prepare($sqlQuery);

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

          // bind Params
          $stmt->bindParam(":user_id", $user_id);
          $stmt->bindParam(":password", $new_password_encrypt);

          // execute
          $stmt->execute();

          return $stmt;
      }

  }


 ?>

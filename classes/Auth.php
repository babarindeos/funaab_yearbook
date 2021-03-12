<?php


  class Auth implements AuthInterface{

      //private date_created;

      public function login($username, $password){
          $sqlQuery  = "Select id, username, password, user_type, role, verification_code,
                        verified, date_created, date_modified from user_auth where username=:username  and password=:password";
          $QueryExecutor = new PDO_QueryExecutor();
          $stmt = $QueryExecutor::customQuery()->prepare($sqlQuery);

          //$this->date_created = date('Y-m-d H:i:s');
          $password_encrypt = sha1(md5(sha1($password)));

          $stmt->bindParam(":username",$username);
          $stmt->bindParam(":password", $password_encrypt);

          $stmt->execute();
          return $stmt;
      }// end of logged


      public function is_firstLogin($userid){
          //check the Auth login table for first time login to
          //know if the onboarding message is to be displayed
          $sqlQuery = "Select id from auth_log where user_id=:userid limit 1";
          $QueryExecutor = new PDO_QueryExecutor();
          $stmt = $QueryExecutor::customQuery()->prepare($sqlQuery);

          $stmt->bindParam(":userid",$userid);

          $stmt->execute();
          return $stmt;
      }


      public function is_auth_created($username){

          // $sqlQuery
          $sqlQuery = "Select username from user_auth where username=:username";

          // pdo Object
          $QueryExecutor = new PDO_QueryExecutor();
          $stmt = $QueryExecutor->customQuery()->prepare($sqlQuery);

          // bind Parameter
          $stmt->bindParam(":username", $username);

          // pdo execute
          $stmt->execute();

          return $stmt;
      }

      public function generate_password()
      {
            $code = '';
            $i = 0;
            $characters = "012345689abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
            $character_length = strlen($characters);

             $randIndex = mt_rand(0, $character_length-1);
             for($i=0; $i<8; $i++ ){
                $randIndex = mt_rand(0, $character_length-1);
                $code .= $characters[$randIndex];
             }
             return $code;
      }

      public function generate_verification_code()
      {
          $code = '';
          $i = 0;
          $characters = "012345689abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!.%@*(){}[]$";
          $character_length = strlen($characters);

           $randIndex = mt_rand(0, $character_length-1);
           for($i=0; $i<100; $i++ ){
              $randIndex = mt_rand(0, $character_length-1);
              $code .= $characters[$randIndex];
           }
           return $code;
      }

      public function create_auth($authData){


          // sqlQuery
          $sqlQuery = "insert into username=:username, password=:password, user_type=:user_type, role=:role, verification_code=:verification_code,
                      verified=:verified, date_created=:date_created, date_modified=:date_modified";

          // pdo object
          $QueryExecutor = new PDO_QueryExecutor();
          $stmt = $QueryExecutor->customQuery()->prepare($sqlQuery);

          $date_created = date('Y-m-d H:i:s');
          $date_modified = date('Y-m-d H:i:s');


          //bind parameters
          $stmt->bindParam(":username", $authData['username']);
          $stmt->bindParam(":password", $authData['password']);
          $stmt->bindParam(":user_type", $authData['user_type']);
          $stmt->bindParam(":role", $authData['role']);
          $stmt->bindParam(":verification_code", $authData['verification_code']);
          $stmt->bindParam(":date_created", $date_created);
          $stmt->bindParam(":date_modified", $date_modified);

          // pdo execute
          $stmt->execute();

          return $stmt;

      }


      public function verification($username, $verification_code)
      {
          //$sqlQuery
          $sqlQuery = "Select * from user_auth where username=:username and verification_code=:verification_code";

          //pdo object
          $QueryExecutor = new PDO_QueryExecutor();
          $stmt = $QueryExecutor->customQuery()->prepare($sqlQuery);

          // bind Params
          $stmt->bindParam(":username", $username);
          $stmt->bindParam("verification_code", $verification_code);

          // execute PDO
          $stmt->execute();

          return $stmt;
      }


      public function is_verified($username, $verification_code){
          //$sqlQuery
          $sqlQuery = "Select * from user_auth where username=:username and verification_code=:verification_code and verified='1'";

          // pdo Object
          $QueryExecutor = new PDO_QueryExecutor();
          $stmt = $QueryExecutor->customQuery()->prepare($sqlQuery);

          // bind Params
          $stmt->bindParam(":username", $username);
          $stmt->bindParam(":verification_code", $verification_code);

          // execute PDO
          $stmt->execute();

          return $stmt;

      }


      public function activate_auth_account($username, $verification_code)
      {
          // $sqlQuery
          $sqlQuery = "Update user_auth set verified='1' where username=:username and verification_code=:verification_code";

          // pdo Object
          $QueryExecutor = new PDO_QueryExecutor();
          $stmt = $QueryExecutor->customQuery()->prepare($sqlQuery);

          // bind Params
          $stmt->bindParam(":username", $username);
          $stmt->bindParam(":verification_code", $verification_code);

          // execute PDO
          $stmt->execute();

          return $stmt;
      }




  }



 ?>

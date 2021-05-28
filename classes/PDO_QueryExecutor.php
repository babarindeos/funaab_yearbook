<?php

  ('PDODriver.php');
  class PDO_QueryExecutor{

      private static $host = '127.0.0.1';
      private static $uid = 'root';
      private static $password = '';
      private static $db = 'students_affairs_yearbook';

      public static function customQuery(){
          try{
              $pdo = null;
              $connection = null;

              $pdo = new PDODriver(self::$host, self::$uid, self::$password, self::$db);
              $connection = $pdo->db_connect();

              return $connection;


          }catch(Exception $e){
              echo 'Message'.$e->getMessage();
          }



      }



  }

 ?>

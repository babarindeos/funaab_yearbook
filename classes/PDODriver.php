<?php

    class PDODriver extends Database Implements DBInterface{

        private $host;
        private $uid;
        private $password;
        private $db;

        public static $pdo_conn;
        //private static $counter;


        // Constructor
        public function __construct($host, $uid, $password, $db){

            parent::__construct($host, $db, $uid, $password);
            $this->host = $host;
            $this->db = $db;
            $this->uid = $uid;
            $this->password = $password;
        }

        //Establish Database connection
        public function db_connect(){

            if (self::$pdo_conn!=null){
                  //echo "returning connection";
                  //self::$counter++;
                  //print("Counter ".self::$counter);
                  //print "<br/>";
                  //print_r(self::$pdo_conn);
                  return self::$pdo_conn;

            }else{
                  try{
                      //echo "new connection";
                      self::$pdo_conn = null;
                      self::$pdo_conn = new PDO("mysql:host={$this->host};dbname={$this->db}", $this->uid, $this->password);
                      self::$pdo_conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                      return self::$pdo_conn;
                  }catch(PDOException $e){
                      echo "Connection Error: ".$e->getMessage();
                      print_r($e);
                  }
            }

        }

    }

 ?>

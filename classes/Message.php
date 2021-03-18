<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
//session_start();

class Message{

    public function send_message($chat_id, $sender, $message){

      $date_created = date('Y-m-d H:i:s');

      //sqlQuery
      $sqlQuery = "Insert into messages set chat_id=:chat_id, sender=:sender, message=:message, date_created=:date_created";

      $QueryExecutor = new PDO_QueryExecutor();
      $stmt = $QueryExecutor->customQuery()->prepare($sqlQuery);

      $stmt->bindParam(":chat_id", $chat_id);
      $stmt->bindParam(":sender", $sender);
      $stmt->bindParam(":message", $message);
      $stmt->bindParam(":date_created", $date_created);

      $stmt->execute();

      return $stmt;
     }

    public function get_messages_by_chat_id($chat_id){

        //$sqlQuery
        $sqlQuery = "Select sender, message, date_created from messages where chat_id=:chat_id order by id desc";

        $QueryExecutor = new PDO_QueryExecutor();
        $stmt = $QueryExecutor->customQuery()->prepare($sqlQuery);

        $stmt->bindParam(":chat_id", $chat_id);

        $stmt->execute();

        return $stmt;

    }

    public function get_unit_distinct_messages_by_chat($unit_id){
        //SqlQuery
        $search_item = $unit_id."_";
        $sqlQuery = "Select * from messages where chat_id like '%$search_item%' order by id desc";

        $QueryExecutor = new PDO_QueryExecutor();
        $stmt = $QueryExecutor->customQuery()->prepare($sqlQuery);

        $stmt->execute();

        return $stmt;
    }

}


?>

<?php

 class Collection implements CollectionInterface{

   private $prefix;
   private $session;

   public function getCollection($myPrefix, $acadaSession){


     $this->prefix = $myPrefix;
     $this->session = $acadaSession;     

     // sqlQuery
     $sqlQuery = "SELECT prefix, amount, commission FROM collection WHERE prefix=:prefix and session=:session";


     // pdo Object
     $QueryExecutor = new PDO_QueryExecutor();
     $stmt = $QueryExecutor->customQuery()->prepare($sqlQuery);

     // bind Parameters
     $stmt->bindParam(":prefix", $this->prefix);
     $stmt->bindParam(":session", $this->session);

     // pdo execute
     $stmt->execute();

     return $stmt;

   }


 }



?>

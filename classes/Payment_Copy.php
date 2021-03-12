<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class Payment implements PaymentInterface{

              public function getInitialPayData($collectionAPP, $regNumber){


                  // $sqlQuery
                  $sqlQuery = "SELECT surname, firstname, othername, mobile, email, transactionID, referenceNo, collectionPrefix, amount, commission, dateCreated,
                               registered, confirmed, filed FROM initialpaydata WHERE filed = 0 AND referenceNo LIKE '%$collectionAPP%' AND custID =:regNumber";

                  // pdo Object
                  $QueryExecutor = new PDO_QueryExecutor();
                  $stmt = $QueryExecutor->customQuery()->prepare($sqlQuery);

                  //bind parameters
                  $stmt->bindParam(":regNumber", $regNumber);

                  // execute PDO
                  $stmt->execute();

                  return $stmt;
            }

            public function updateInitialPayData_setRegistered($registered, $referenceNo){

              //  sqlQuery
                  $sqlQuery = "UPDATE initialPayData SET registered = 1, dateRegistered = now() WHERE referenceNo = '$referenceNo'";

              // pdo object
                 $QueryExecutor = new PDO_QueryExecutor();
                 $stmt = $QueryExecutor->customQuery()->prepare($sqlQuery);

                 // pdo execute
                 $stmt->execute();

                 return $stmt;
           }


           public function updateInitialPayData_setTransactionID($transactionID, $referenceNo){

             //  sqlQuery
                 $sqlQuery = "UPDATE initialPayData SET transactionID='$transactionID' WHERE filed <> 1 AND referenceNo = '$referenceNo'";

             // pdo object
                $QueryExecutor = new PDO_QueryExecutor();
                $stmt = $QueryExecutor->customQuery()->prepare($sqlQuery);

                // pdo execute
                $stmt->execute();

                return $stmt;
          }

          public function updateInitialPayData_setFiled($referenceNo, $regNumber){

            //  sqlQuery
                $sqlQuery = "UPDATE initialPayData SET filed = 1 WHERE referenceNo = '$referenceNo' AND custId = '$regNumber'";

            // pdo object
               $QueryExecutor = new PDO_QueryExecutor();
               $stmt = $QueryExecutor->customQuery()->prepare($sqlQuery);

               // pdo execute
               $stmt->execute();

               return $stmt;
         }

         public function uInitialPayData_Confirmed($bank, $referenceNo){

            $sqlQuery = "UPDATE initialPayData SET confirmed = '1', confirmedBy='$bank', dateConfirmed = now() WHERE filed <> 1 AND referenceNo = '$referenceNo'";

            // pdo Object
            $QueryExecutor = new PDO_QueryExecutor();
            $stmt = $QueryExecutor->customQuery()->prepare($sqlQuery);

            // execute PDO
            $stmt->execute();

            return $stmt;
         }

         public function get_payment_by_transactID_and_refNo($transactionID, $referenceNo){

           //sqlQuery
           $sqlQuery = "SELECT custID FROM initialpaydata WHERE filed <> 1  AND referenceNo LIKE '$referenceNo' AND transactionID = '$transactionID'";

           $QueryExecutor = new PDO_QueryExecutor();
           $stmt = $QueryExecutor->customQuery()->prepare($sqlQuery);

           $stmt->execute();

           return $stmt;

         }

         public function report_get_payments_confirmed(){
            // $sqlQuery
            $sqlQuery = "Select p.payDataID, p.custID, p.surname, p.firstname, p.othername, p.phone, p.email, p.transactionID, p.referenceNo, p.collectionPrefix,
                        p.amount, p.commission, p.dateCreated, p.confirmed, a.photo, a.level, a.deptCode, a.collegeCode, a.CGPA from initialpaydata p
                        inner join applicants a on p.custID=a.regNumber where confirmed='1' ";

            $QueryExecutor = new PDO_QueryExecutor();
            $stmt = $QueryExecutor->customQuery()->prepare($sqlQuery);

            $stmt->execute();

            return $stmt;
         }


         public function generate_invoice($collectionAPP, $regNumberFound)
         {
              // sqlQuery
             $sqlQuery = "SELECT i.custId, a.surname, a.firstname, a.othername, a.phone, a.email, i.transactionID, i.referenceNo, i.collectionPrefix, c.description, c.amount AS amount, c.commission AS commission FROM applicants a JOIN initialpaydata i ON a.regNumber = i.custID JOIN  collection c ON i.collectionprefix = c.prefix WHERE i.filed = 0 AND i.collectionPrefix LIKE '%$collectionAPP%' AND i.custId = '$regNumberFound' LIMIT 1";

             $QueryExecutor = new PDO_QueryExecutor();
             $stmt = $QueryExecutor->customQuery()->prepare($sqlQuery);

             $stmt->execute();

             return $stmt;
         }



}



?>

<?php
  $payment = new Payment();
  $getInitialPayData = $payment->getInitialPayData($collectionAPP, $matric_no);
  // ----------------- If User Transaction is found ---------
  if ($getInitialPayData->rowCount()){

          $row = $getInitialPayData->fetch(PDO::FETCH_ASSOC);

          $surname = strtoupper(trim($row['surname']));
          $firstname = ucfirst(strtolower(trim($row['firstname'])));
        	$othername = ucfirst(strtolower(trim($row['othername'])));
        	$phone = $row['phone'];
        	$email = strtolower($row['email']);
        	$transactionID = $row['transactionID'];
        	$referenceNo = $row['referenceNo'];
        	$prefix = $row['collectionPrefix'];
        	$confirmed = $row['confirmed'];
        	$dateCreated = $row['dateCreated'];
        	$registered = $row['registered'];
        	$amount = $row['amount'];
        	$commission = $row['commission'];
        	$payAmount = $amount + $commission;
        	$info = "Invoice details has been captured for <strong>$matric_no </strong> and cannot be altered.<br />";
  }else{
          echo "<button  class='btn btn-primary btn-sm btn-rounded'>Initiate Payment</button>";

  }




 ?>

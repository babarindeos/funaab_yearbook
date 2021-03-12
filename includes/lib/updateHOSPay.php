<?php

//Setup
include_once 'include/db.inc.php';
include_once 'include/funaabPay.php';
require_once 'include/function.php';
$done = 0;


$qPinitialPayData = mysql_query("SELECT referenceNo, custID, collectionprefix, surname,firstname,amount FROM initialPayData  WHERE filed = 0 AND registered = 0 AND (referenceNo LIKE '%$idPrefix/F%$collectionSession%' OR referenceNo LIKE '%$idPrefix/M%$collectionSession%')");
echo "SELECT referenceNo, custID, collectionprefix, surname,firstname,amount FROM initialPayData  WHERE filed = 0 AND registered = 0 AND (referenceNo LIKE '%$idPrefix/F%$collectionSession%' OR referenceNo LIKE '%$idPrefix/M%$collectionSession%')");

	if (!$qPinitialPayData) {
		die('Invalid query: ' . mysql_error());
	}

	$c=0; $currentId="";
	while ($row = mysql_fetch_array($qPinitialPayData, MYSQL_BOTH)) {
		//printf ($row["custID"]);
		$refNo=$row["referenceNo"];
		$custID=$row["custID"];
		$prefix=$row["collectionprefix"];
		$surname=$row["surname"];
		$firstname=$row["firstname"];
		$amount=$row["amount"];
		$r1 = mysql_query("SELECT  email, mobile FROM initialPayData WHERE custID = '$custID'");
		//echo "SELECT  email, mobile FROM applicants WHERE utmeNumber = '$custID'";		

		$count = mysql_num_rows($r1);

		if ($count > 0) {
			$row = mysql_fetch_assoc($r1);
			$phone = $row['mobile'];
			$email = $row['email'];
		}
		//echo "$prefix, $refNo,$custID,$surname,$firstname,$amount,$phone, $email <br />";

		$fPayResponse=addTransaction($prefix, $refNo,$custID,$surname,$firstname,$amount,$phone, $email);
		//echo $fPayResponse;
		if (($fPayResponse == "Successful") OR ($fPayResponse == "AlreadyExist")) {
			//echo "Success";
			$uInitialPayData = mysql_query("UPDATE initialPayData SET registered = 1,mobile = '$phone', email = '$email', dateRegistered = now() WHERE referenceNo = '$refNo'");
			if ( false===$uInitialPayData ) {
				printf("error: $%s\n", mysql_error());
				exit;
			}
		} else {
			echo "$custID: $fPayResponse | $refNo<br />";
		}
		echo "Done = ". $done++. ": ";
	}
//mysql_free_result($result);
echo "Complete";
?>
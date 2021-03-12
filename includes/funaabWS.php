<?php
//Setup
error_reporting (0);
ini_set ('soap.wsdl_cache_enabled', 0);
require_once('lib/nusoap.php');

//Configuration
//$client = new nusoap_client('http://portal.unaab.edu.ng:89/TestingServ/WebAppIntegration.svc?wsdl', true);
//$client = new nusoap_client('http://portal.unaab.edu.ng:89/WebAppIntegration.svc?wsdl', true);
//$client = new nusoap_client('http://41.222.44.196:89/WebAppIntegration.svc?wsdl', true);
//$client = new nusoap_client('http://197.253.10.98:89/WebAppIntegration.svc?wsdl', true);
//$client = new nusoap_client('https://paymentgateway.unaab.edu.ng:8089/WebAppIntegration.svc?wsdl', true);
//$client = new nusoap_client('http://10.0.20.20:89/WebAppIntegration.svc?wsdl', true);
$client = new nusoap_client('http://102.141.234.11:89/WebAppIntegration.svc?wsdl', true);

//$client = new nusoap_client('https://10.0.20.21:8089/WebAppIntegration.svc?wsdl', true);
$soapaction = "http://tempuri.org/IWebAppIntegration/addTransaction";
$namespace = "http://www.unaab.edu.ng/PGPayService";
$client->soap_defencoding = 'UTF-8';
$apiKey='hkjsd739jdmc83jdmjd83kjmdywspewmdiue6shmet4msu82'; 

//PG Service
//$client2 = new nusoap_client('http://pg.unaab.edu.ng/Webservice/PGService.svc?wsdl', true);
$client2 = new nusoap_client('http://102.141.234.13/Webservice/PGService.svc?wsdl', true);

//$client2 = new nusoap_client('http://10.0.20.20/Webservice/PGService.svc?wsdl', true);
$client2->soap_defencoding = 'UTF-8';
$soapaction2 = "http://tempuri.org/IPGService/getStudentRecordWithSession";
$namespace2 = "http://tempuri.org/";

//Portal Service

$client3 = new nusoap_client('https://portal.unaab.edu.ng/webservices/ProfileService.svc?wsdl', true);
//$client3 = new nusoap_client('https://102.141.234.6/webservices/ProfileService.svc?wsdl', true);
//$client3 = new nusoap_client('http://10.0.20.17/webservices/ProfileService.svc?wsdl', true);
//$client3 = new nusoap_client('http://portal.unaab.edu.ng/webservices/ProfileService.svc?wsdl', true);
//$client3 = new nusoap_client('http://197.253.10.98/webservices/ProfileService.svc?wsdl', true);
$client3->soap_defencoding = 'UTF-8';
$soapaction3 = "http://tempuri.org/IProfileService/getStudentRecordWithSession";
$namespace3 = "http://tempuri.org/";


//Add New Transaction
function addTransaction($prefix, $referenceNo,$CustID,$surname,$firstname,$amount,$mobile, $email){
	//echo $referenceNo;
	global $apiKey,$client,$soapaction,$namespace;
	$MethodToCall= "addTransaction2";
	$param =array('referenceNo'=>$referenceNo,'CustID'=>$CustID,'surname'=>$surname,'firstname'=>$firstname,'amount'=>$amount,'mobile'=>$mobile,'email'=>$email,'otherDetails'=>"",'collectionPrefix'=>$prefix,'apiKey'=>$apiKey);
	//$param =array('tranDetail'=>$tranDet,'collectionPrefix'=>$prefix,'apiKey'=>$apiKey);
	$result = $client->call($MethodToCall, 
	array('parameters' => $param), $namespace, $soapaction, false, true);
	if ($client->fault) {
		return 'Fault';
		//return $result;
	} else {
		// Check for errors
		$err = $client->getError();
		if ($err) {
			// Display the error
			//echo '<h2>Error</h2><pre>' . $err . '</pre>';
			return 'Error';
		} else {
			// Display the result
			//echo '<h2>Result</h2><br>';
			$WebResult=$MethodToCall."Result";//This gives getTransactionsResult
			//echo $WebResult."<br>";
			return $result[$WebResult];
		}
	}
}

//Add New Expiring Transaction
function addExpireTransaction($prefix, $referenceNo,$CustID,$surname,$firstname,$amount,$mobile, $email,$otherDetails, $dateExpired){
	//echo " in func date: $dateExpired<br/>";
	global $apiKey,$client,$soapaction,$namespace;
	$MethodToCall= "addTransactionWithExpireDate";
	//$otherDetails='';
	$param =array('referenceNo'=>$referenceNo,'CustID'=>$CustID,'surname'=>$surname,'firstname'=>$firstname,'amount'=>$amount,'mobile'=>$mobile,'email'=>$email,'otherDetails'=>$otherDetails,'collectionPrefix'=>$prefix,'apiKey'=>$apiKey, 'ExpiredDate'=>$dateExpired);
	
	//$param =array('tranDetail'=>$tranDet,'collectionPrefix'=>$prefix,'apiKey'=>$apiKey);
	$result = $client->call($MethodToCall, 
	array('parameters' => $param), $namespace, $soapaction, false, true);
	if ($client->fault) {
	     echo $client->getError();
		//return 'Fault'." prefix:$prefix, refno:$referenceNo, custid:$CustID, surname:$surname, firstanme:$firstname, amt:$amount, mob:$mobile, email:$email,otherDetails:$otherDetails";
		//return $result;
	} else {
		// Check for errors
		$err = $client->getError();
		if ($err) {
			// Display the error
			//echo '<h2>Error</h2><pre>' . $err . '</pre>';
			return 'Error';
		} else {
			// Display the result
			//echo '<h2>Result</h2><br>';
			$WebResult=$MethodToCall."Result";//This gives getTransactionsResult
			//echo $WebResult."<br>";
			return $result[$WebResult];
		}
	}
}


//Get Transaction Status
function getTransactionStatus($prefix, $referenceNo){
	$MethodToCall= "getConfirmationStatus";
	global $apiKey,$client,$soapaction,$namespace;
	$param =array('referenceNo'=>$referenceNo,'collectionPrefix'=>$prefix,'apiKey'=>$apiKey);
	$result = $client->call($MethodToCall, 
	
	array('parameters' => $param), $namespace, $soapaction, false, true);
	if ($client->fault) {
		return 'Fault';
		//return $result;
	} else {
		// Check for errors
		$err = $client->getError();
		if ($err) {
			// Display the error
			//echo '<h2>Error</h2><pre>' . $err . '</pre>';
			return 'Error';
		} else {
			// Display the result
			//echo '<h2>Result</h2><br>';
			$WebResult=$MethodToCall."Result";//This gives getTransactionsResult
			//echo $WebResult."<br>";
			return $result[$WebResult];
		}
	}
}

//Get Transaction Status with Bank
function getTransactionStatus2($prefix, $referenceNo){
	$MethodToCall= "getConfirmationStatus2";
	global $apiKey,$client,$soapaction,$namespace;
	
	$param =array('referenceNo'=>$referenceNo,'collectionPrefix'=>$prefix,'apiKey'=>$apiKey);
	$result = $client->call($MethodToCall, 
	array('parameters' => $param), $namespace, $soapaction, false, true);
	if ($client->fault) {
	//echo   'Fault';
		return 'Fault';
		//return $result;
	} else {
		// Check for errors
		$err = $client->getError();
		if ($err) {
			// Display the error
			//echo '<h2>Error</h2><pre>' . $err . '</pre>';
			return 'Error';
		} else {
			// Display the result
			//echo '<h2>Result</h2><br>';
			$WebResult=$MethodToCall."Result";//This gives getTransactionsResult
			//echo $WebResult."<br>";
			$json = json_decode(json_encode( $result[$WebResult]));
			//echo $json->Status;
			return $result[$WebResult];
		}
	}
}

//Get PG Student Record
function getPGStudentRecord($referenceNo, $session){
	//echo "$session, $referenceNo";
	$MethodToCall= "getStudentRecordWithSession";
	global $apiKey,$client2,$soapaction,$namespace;
	
	$param =array('MatricNo'=>$referenceNo,'Session'=>$session);
	$result = $client2->call($MethodToCall, 
	array('parameters' => $param), $namespace2, $soapaction2, false, true);
	if ($client2->fault) {
	//echo   'Fault';
		return 'Fault';
		//return $result;
	} else {
		// Check for errors
		$err = $client2->getError();
		if ($err) {
			// Display the error
			//echo '<h2>Error</h2><pre>' . $err . '</pre>';
			return 'Error';
		} else {
			// Display the result
			//echo '<h2>Result</h2><br>';
			$WebResult=$MethodToCall."Result";//This gives getTransactionsResult
			//echo $WebResult."<br>";
			$json = json_decode(json_encode( $result[$WebResult]));
			//echo $json->Status;
			return $result[$WebResult];
		}
	}
}


//Get Portal Record
function getStudentRecord($studentNumber, $session){
	$MethodToCall= "getStudentRecordWithSession";
	global $apiKey,$client3,$soapaction3,$namespace3;
	
	$param =array('MatricNo'=>$studentNumber,'Session'=>$session);
	$result = $client3->call($MethodToCall, 
	array('parameters' => $param), $namespace3, $soapaction3, false, true);
	
	if ($client3->fault) {
	//echo   'Fault';
		return 'Fault';
		//return $result;
	} else {
		// Check for errors
		$err = $client3->getError();
		if ($err) {
			// Display the error
			echo '<h2>Error</h2><pre>' . $err . '</pre>';
			return 'Error';
		} else {
			// Display the result
			//echo '<h2>Result</h2><br>';
			//exit;
			$WebResult=$MethodToCall."Result";//This gives getTransactionsResult
			//echo $WebResult."<br>";
			$json = json_decode(json_encode( $result[$WebResult]));
			//print_r($json);
			//echo $json->Surname;
			return $result[$WebResult];
		}
	}
}


//$prefix='FUN/DEM/APP/201314/1';
// $referenceNo="FUN/DEM/APP/201314/1/12347"; 
// $CustID="15262782JA" ; 
//$surname="POST UTME"; 
// $firstname="TEST"; 
// $amount="1000"; 
// $mobile="08062061644"; 
// $email="yusfate81@yahoo.com"; 
//echo getTransactionStatus($prefix, $referenceNo);

 
function myPayGeneration($fPayResponse) {

	switch ($fPayResponse) {
		case "Successful":
			return "Successful operation";
			break;
		case "ExpiredRef":
			return "Payment has closed";
			break;
		case "Fault":
		case "Error":
		case "ServerError":
			return "Payment Gateway presently not available, please try again later.";
			break;
		default:
			return "Try again later";
	}
}

function myPayConfirmation($fPayResponse) {

	switch ($fPayResponse) {
		case "Confirmed":
			return "Successful operation";
			break;
		case "ExpiredRef":
			return "Expired Reference Number";
			break;
		case "NotConfirmed":
			return "Payment not yet confirmed by the Bank.";
			break;
		case "ServerError":
		case "Error":
			return "Payment Gateway presently not available, please try again later.";
			break;
		default:
			return "Try again later";
	}
}

function myStudentDetails($pgResponse) {

	switch ($pgResponse) {
		case "Fault":
			return "PG Server not available, please try again later.";
			break;
		case "PAID":
			return "Successful operation";
			break;
		case "UNPAID":
			return "Outstanding School Fees";
			break;
		case "ServerError":
		case "Error":
			return "";
			break;
		default:
			return "Try again later";
	}
}
?>
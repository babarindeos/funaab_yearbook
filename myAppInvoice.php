<?php
session_start();
if (!isset($_GET['regNumber'])) {
	//Show Login forms
	header("location: signin.php");
	exit();
} else {
	$regNumberFound = $_GET['regNumber'];

}


// Initialised
$message = "";  //Error Message
//$regNumberFound = $_GET['regNumber'];

$page_title = "My Invoice - FUNAAB Yearbook";
// Core
require_once("core/config.php");
// Header
require_once("includes/header.php");
// Navigation
require_once("nav/nav_login.php");

//include_once 'include/db.inc.php';
include_once 'includes/funaabWS.php';
include_once 'includes/ws_functions.php';
include_once 'includes/ws_parameters.php';

	//Retrieve from database
	$payment = new Payment();
	$rStudent = $payment->generate_invoice($collectionAPP, $regNumberFound);
//echo "$rStudent";



	if ($rStudent->rowCount()) {
		while ($row = $rStudent->fetch(PDO::FETCH_ASSOC)) {
			$surname = $row['surname'];
			$firstname = $row['firstname'];
			$othername = $row['othername'];
			$mobile = $row['phone'];
			$email = $row['email'];
			$transactionID = $row['transactionID'];
			$referenceNo = $row['referenceNo'];
			$collectionPrefix = $row['collectionPrefix'];
			$description = $row['description'];
			$amount = $row['amount'];
			$printAmount = number_format($amount , 2, '.', ',');
			$commission = $row['commission'];
			$printCommission  = number_format($commission , 2, '.', ',');
			$totalPayment = $commission + $amount;
			$printTotalPayment = number_format($totalPayment , 2, '.', ',');
		}
	} else {
		//UTME Number NOT found in database
		//$message == "You did not apply to UNAAB";
		//header('Location: error.php?message=1');
		//exit();
	}


	 $acadaSession = "2019/2020";


	//Add Participating Banks from Database
	//$rBanks = mysql_query("SELECT custId, accountNumber, bankName from accounts, banks where accounts.bankId = banks.bankId");
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title><?php echo $page_title; ?></title>
<style type="text/css">
<!--

.inputtext{font-family:Verdana, Arial, Helvetica, sans-serif;font-size:12px;border:1px solid #009504}
.inputbtn{font-family:Verdana, Arial, Helvetica, sans-serif;font-size:12px;border:2px solid #009504;background-color:#009504;color:white;}
body {
	background-image: url(images/result_online_backdrop.png);
	font-family:Verdana, Arial, Helvetica, sans-serif;
}
.heading { margin:0; padding: 2px 0; font-size: 14px; font-weight: bold; color: #005802;}
.header { color: #FFFFFF; font-weight: bold; font-size:12px; background-color:#009504;}
table {width:750; background-color: #fff; font-family:Verdana, Arial, Helvetica, sans-serif;font-size:12px;}

.wrapper {margin: 0 auto; width: 750px; background-color: #fff;}

.tableHeader {border-bottom:1px dotted green;font-size:14px; padding-bottom: 0}
.tableLabel {font-size:9px; padding: 0 0 5px 5px}

.results .tableData {text-align:center;}
.table1Data {border-bottom:1px dotted #009504; padding-bottom: 0; padding: 12px 0 0 0}
.table1DataHeader {padding-top: 12px}
.tableData {border-bottom:1px dotted #009504; padding: 1px 0 0 0; width: 50px}
.tableDataHeader {border-bottom:1px dotted #009504;border-right:1px solid #009504; padding-bottom: 0; width:300px;}
.tableDataDE {border-bottom:1px dotted #009504; padding: 1px 0 0 0; width: 250px}
.tableDataHeaderDE {border-bottom:1px dotted #009504;border-right:1px solid #009504; padding-bottom: 0; width:100px;}

#control {float:right; font-size:11px; margin: 2px 10px 0 0;}

.auto-style1 {
	margin-right: 0px;
}

-->
</style>
</head>

<body>
<?php //include_once 'include/analyticstracking.php'; ?>
<table class="wrapper" border="0" >
	<tr>
		<td>
		<!--Banner -->
		<table width="750px">
			<tr>
				<td ><img name="logo" src="images/wHeader.png" alt="" ></td>
			</tr>
			<tr>
				<td class="heading"><?php echo "Invoice: FUNAAB Yearbook ($acadaSession Academic Session)";?>
				<span id="control"><a href="#" onClick="window.print()">Print</a> | <a href="signin.php">Log Out</a></span> </td>
			</tr>
		</table>
        <!--Personal Information -->

      <table width="750" style="border:2px solid #009504; background: transparent; z-index: 1;" cellpadding="6px"  cellspacing="0" >
        <tr bgcolor="#009504">
          <td colspan="2" width="750" class="header" style="border-right:1px solid #009504;"><strong>Reference Number: </strong><?php echo $referenceNo ?></td>
        </tr>
        <tr>
          <td colspan="2" width="750"  style="border-right:1px solid #009504;"><strong>Remita Retrieval Reference (RRR): </strong><?php echo $transactionID ?></td>
        </tr>
		<tr>
			<td width="30%">
			<?php echo "<strong>Invoice Description: </strong> ";?></td>
			<td width="120"> <?php echo "$description<br />";?></td>
		</tr>
		<tr>
			<td width="30%"><?php echo "<strong>Amount: </strong>"?></td>
			<td><?php echo "=N=$printTotalPayment <em>(Excluding transactions charges)</em>"?></td>
		</tr>
		</table>
		<br />
		<table width="750" style="border:2px solid #009504; background: transparent; z-index: 1; " cellpadding="6px" cellspacing="0">
			<tr bgcolor="#009504">
				<td colspan="3" class="header">Student's Information</td>
			</tr>
			<tr>
				<td class="table1DataHeader" width="120"><strong>Full Name:</strong></td>
				<td width="630" class="table1Data"><?php echo (isset($surname)) ? "<strong>$surname,</strong> $firstname $othername" : NULL; ?></td>
			</tr>
			<tr>
				<td class="table1DataHeader"><strong>Number:</strong></td>
				<td class="table1Data"><?php echo (isset($regNumberFound)) ? "$regNumberFound" : NULL; ?> </td>
			</tr>
			<tr>
				<td class="table1DataHeader"><strong>Mobile:</strong></td>
				<td class="table1Data"><?php echo "$mobile"; ?></td>
			</tr>
			<tr>
				<td class="table1DataHeader"><strong>Email:</strong></td>
				<td class="table1Data"><?php echo "$email"; ?></td>
			</tr>
		</table>
			<br />
      <table width="750" border="0" cellpadding="6"  cellspacing="1" style="border:2px solid #009504;">
        <tr>
          <td width="750" class="header" style="border-right:1px solid #009504;"><strong>Payment Information</strong></td>
        </tr>
		<tr>
			<td style="border-top:1px solid #009504; font-size:13px">
			Ensure you take this bill to any bank branch that accept <strong>Remita Payment</strong> including FUNAAB Micro Finance Bank (UMFB), keep a copy for record purpose. 

			<p><em>Payment can be made at any of the branches/locations nationwide.</em></p>
			<strong>Payment is NOT by regular cash deposit: </strong>Ensure the bank posts the payment through <strong>Remita</strong> platform.

			<p>Payment is also possible online with your debit card or Internet Banking.</p>


			</td>
		</tr>
		</table>



    </td>
  </tr>
   <tr>
    <td style="font-family:Verdana, Arial, Helvetica, sans-serif;font-size:11px;color:#777777;border-top:1px solid #009504; ">
  <small>Copyright &copy; <?php echo "2012 - ".date("Y"); ?> Federal University of Agriculture, Abeokuta. All Rights Reserved.<br>Powered by ICTREC, FUNAAB.</small>
 </td>
  </tr>
</table>

</body>
</html>

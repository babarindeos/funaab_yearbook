<?php
session_start();
if (!isset($_GET['refNumber'])) {
	//Show Login forms
	header("location: signin.php");
	exit();
} else {
	$transactionID = $_GET['transID'];
	$referenceNo = $_GET['refNumber'];
	session_destroy();
}


$page_title = 'WebPay - Pay for FUNAAB YearBook Online';

// Initialised
$message = "";  //Error Message
//$utmeFound = $_GET['utmeNumber'];

require_once("core/config.php");
// Header
require_once("includes/header.php");
// Navigation
require_once("nav/nav_login.php");
//include_once 'include/db.inc.php';
include_once 'includes/funaabWS.php';

	//Retrieve from database
	$payment = new Payment();
	$rStudent = $payment->get_payment_by_transactID_and_refNo($transactionID, $referenceNo);

	//$rs = $conn->query($rStudent) or die('Invalid Query: ' .$conn->error);

	if ($rStudent->rowCount()) {
		//Applicant has provided initial information
		while ($row = $rStudent->fetch(PDO::FETCH_ASSOC)) {
			$custID = $row['custID'];
		}

	} else {
		//NOT found in Payment Record
		//header('Location: error.php?message=1');
		echo "Not Allowed!";
		exit();
	}
?>

<?php //include 'include/head.inc.php'; ?>
</head>
<body>

<?php //include 'include/banner.inc.php'; ?>


<section id="main">
    <div class="container">
		<div class="row d-flex justify-content-center">



			<div class="col-xs-12 mt-3 mb-5">
				<h3>Pay FUNAAB YearBook Online</h3>
				<p class="lead">Students Affairs Office</p>

					<iframe src="<?php echo "http://paymentgateway.unaab.edu.ng/Remita/ProcessPayment.aspx?RefNo=$referenceNo"; ?>" name = "myIframe"  height="520px" width="100%" ></iframe>

				<img src="images/remita-payment-logo-horizonal.png" />

			</div><!-- row -->
		</div>
	</div>
</section>
<?php include_once("includes/footer.php") ?>

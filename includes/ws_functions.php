<?php
//functions
function myAcadaLevel($courseDuration, $currentLevel, $college, $regNo) {
	if (strlen($regNo) > '8') {
		return "FS"; //Fresh Student
	}elseif (substr($currentLevel,0,3) == 'FNG'){
		return "FNG";
	} else {
		$currentLevel = substr($currentLevel,0,1);
		$status = $courseDuration - $currentLevel;
		//echo "currentLevel: $currentLevel";
		if (($currentLevel == 5) AND ($college == 'COLPLANT' OR $college == 'COLANIM' OR $college == 'COLAMRUD')){
			return "FYF"; //Farm Practical Year
		} else if (($currentLevel == 5) AND ($college == 'COLENG'  OR $college == 'COLERM')){
			return "FYS"; //SIWES
		} else if (($currentLevel == 4) AND ($college == 'COLPHYS' OR $college == 'COLBIOS')){
			return "FYS"; //SIWES
		} else if (($currentLevel == 4) AND ($deptCode == 'HSM' OR $deptCode == 'NUD')){
			return "FYS"; //SIWES
		} else if (($currentLevel == 5) AND ($deptCode == 'HTM' OR $deptCode == 'FST')){
			return "FYS"; //SIWES
		} else if ($status == $courseDuration -1) {
			return "FS"; //Fresh Student ?????
		} else if ($status > 0) {
			return "NFY"; //Non-Final Year
		} else if ($status == 0)  {
			return "FYG"; //Final Year Graduating Student
		}
	}

}

function myAcadaCriteria($acada) {
	if ($acada == "FS") {
		return "fresher"; //Fresh Student
	} else if ($acada == "NFY") {
		return "returning"; //Non-Final Year
	} else if (($acada == "FYG") OR ($acada == "FNG")) {
		return "finalYear"; //Final Year Management and FNG
	} else if ($acada == "FYF") {
		return "finalYearFPY"; //Final Year FPY
	} else if ($acada == "FYS") {
		return "finalYearSIWES"; //Final Year SIWES
	} else if ($acada == "I") {
		return "illegal"; //Illegal Entry
	} else if ($acada == "PGF")  {
		return "pgFresher"; //PG Fresher
	} else if ($acada == "PGR")  {
		return "pgReturning"; //PG Returning
	} else if ($acada == "PGCF")  {
		return "pgcFresher"; //PG CADESE Fresher
	} else if ($acada == "PGCR")  {
		return "pgcReturning"; //PG CADESE Returning
	}
}

function mySponsor($sponsor) {
	if ($sponsor == "VC") {
		return "VC's List"; 
	} else if ($sponsor == "PO") {
		return "Management Staff's List"; 
	} else if ($sponsor == "STAFF") {
		return "Staff's List"; 
	} else if ($sponsor == "DSA") {
		return "DSA's List"; 
	} else if ($sponsor == "PGC") {
		return "PG Concession List"; 
	} else if ($sponsor == "PGCC") {
		return "PGC Concession List"; 
	}
}

function myGender($sex) {
	if ($sex == "M") {
		return "Male"; //Male
	} else if ($sex == "F") {
		return "Female"; //Female
	}
}

function myQualifier($values) {
	switch ($values) {
		case "FS":
		case "fresher":
			return "Fresh Student";
			break;
		case "NFY":
		case "returning":
			return "Returning Student";
			break;
		case "returning":
			return "FPY Student";
			break;
		case "FYG":
		case "FNG":
		case "finalYear":
			return "Final Year Student";
			break;
		case "FYF":
		case "finalYearFPY":
			return "Final Year Student from FPY";
			break;
		case "FYS":
		case "finalYearSIWES":
			return "Final Year Student from SIWES";
			break;
		case "VC":
			return "VC's List";
			break;
		case "PO":
			return "Principal Officers' List";
			break;
		case "STAFF":
			return "Staff List";
			break;
		case "DSA":
			return "DSA List";
			break;
		case "studentRep":
			return "Students' Representative";
			break;
		case "foreigner":
			return "Foreign Students";
			break;
		case "sportman":
			return "Outstanding Sport Person";
			break;
		case "biological":
			return "Biological Child of a Staff";
			break;
		case "health":
			return "Students with Health Consideration";
			break;
		case "indigent":
			return "Indigent Student";
			break;
		case "highflyer":
			return "University Scholars";
			break;
		case "vet":
			return "Veterinary Student";
			break;
		case "PGF":
		case "pgFresher":
			return "Fresh PG Student";
			break;
		case "PGR":
		case "pgReturning":
			return "Returning PG Student";
			break;
		case "PGC":
			return "PG Concessional List";
			break;
		case "PGCF":
		case "pgcFresher":
			return "Fresh PG (CEADESE) Student";
			break;
		case "PGCR":
		case "pgcReturning":
			return "Returning PG (CEADESE) Student";
			break;
		case "PGCC":
			return "CEADESE Concessional List";
			break;
		case "I":
		case "illegal":
			return "Ilegal Entry";
			break;
	}
}

function myHostel($hostelName) {
	switch ($hostelName) {
		case "MUO":
			return "Umar Kabir Male Hostel - Old block";
			break;
		case "MUN":
			return "Umar Kabir Male Hostel - New block";
			break;
		case "MNA":
			return "Needs Assessment Male Hostel - New block";
			break;
		case "FIO":
			return "Iyalode Tinunbu Female Hostel - Old block";
			break;
		case "FIN":
			return "Iyalode Tinunbu Female Hostel - New block";
			break;
		case "FNC":
			return "Female Hostel - Marble";
			break;
		case "FIP":
			return "PG Female Hall - Iyalode Tinunbu  Hostel";
			break;
		case "FNA":
			return "Needs Assessment Female Hostel - New block";
			break;
		case "MUP":
			return "PG Male Hall - Umar Kabir Hostel";
			break;
		case "FMP":
			return "PG Female Hall - Marble Hostel";
			break;
		case "FFP":
			return "PG Female (International) - Iyalode Tinunbu Hostel";
			break;
		case "MFP":
			return "PG Male (International) - Iyalode Tinunbu Hostel";
			break;	
	}
}
function myDate($date) {
	$dateTime = new DateTime($date);
	$expiration = date_format ( $dateTime, 'l, jS F Y (h:ia)' );
	return $expiration;
}



function MSDate($mysql_date) {
	$dateTime = new DateTime($mysql_date);
	$mssql_date = date_format ($dateTime, 'd/m/Y H:i:s' );
	return $mssql_date;
}

//Allocated Bedspace and Update booking record
function myBooking($hall, $reference, $id) {
	//Get next available bedspace
	//include_once 'db.inc.php';
	global $conn;
	
	//Check for Pre-reserved Bedspace for 
	//$qBedspacesBooked = "SELECT bedspaceID FROM bedspace WHERE hostelID = '$hall' AND preBookedID = '$id' AND referenceNo is NULL ORDER BY bedspaceID  ASC LIMIT 1";
	//Allocation to hall based on gender
	$qBedspacesBooked = "SELECT bedspaceID FROM bedspace WHERE preBookedID = '$id' AND referenceNo is NULL ORDER BY bedspaceID  ASC LIMIT 1";
	//echo "$qBedspacesBooked";
	//HostelID not passed to allows allocation to hall (PG) without considering gender
	
	//Obtain details of pre-reserved bedspace
	$result = $conn->query($qBedspacesBooked);
	if ($result->num_rows > 0) {
		while ($row = $result->fetch_assoc()) {
			$bedspaceID = $row['bedspaceID'];
		}
	}else{
	    //Obtain details of next available bedspace
		$qBedspaces1 = "SELECT bedspaceID FROM bedspace WHERE hostelID = '$hall' AND referenceNo is NULL AND isReserved = 'N' ORDER BY bedspaceID  ASC LIMIT 1";
		//echo "$qBedspaces1";
		$result = $conn->query($qBedspaces1);

		if ($result->num_rows > 0) {
			while ($row = $result->fetch_assoc()) {
				$bedspaceID = $row['bedspaceID'];
			}
		}
	}
	
	//echo "BedspaceID: $bedspaceID";
	//exit;

	//Bedspace Allocation
	//START TRANSACTION
	$conn->autocommit(FALSE);
	$flag = true;
	
	//Assign Bedspace
	$uBedspace1 = "UPDATE bedspace SET referenceNo = '$reference', dateAssigned = now() WHERE bedspaceID = '$bedspaceID' AND referenceNo is NULL";
	$rs1 = $conn->query($uBedspace1);
	if ($conn->error) {
		$flag = false;
		die('<strong>Invalid query: $uBedspace</strong> '. $conn->error);
	} else {
		If ($conn->affected_rows <> 1) {
			$flag = false;
		}
	}		

	//Update booking
	$uBooking = "UPDATE booking SET statusID = '2', dateModified = now() WHERE referenceNo = '$reference'";
	$rs2 = $conn->query($uBooking);
	if ($conn->error) {
		$flag = false;
		//echo "<strong>Invalid query: </strong> ". $conn->error;
	} else {
		If ($conn->affected_rows <> 1) {
			$flag = false;
		}
	//echo "Here1";
	}

	if ($flag) {
		$conn->commit();
		//echo "All queries were executed successfully";
		//exit;
		return 1;
	} else {
		$conn->rollback();
		//echo "All queries were rolled back";
		//exit;
		return 0;
		//echo "Currently No Available Bed-space ";
	}
}

//Get ip 
function getUserIP()
{
    $client  = @$_SERVER['HTTP_CLIENT_IP'];
    $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
    $remote  = $_SERVER['REMOTE_ADDR'];

    if(filter_var($client, FILTER_VALIDATE_IP))
    {
        $ip = $client;
    }
    elseif(filter_var($forward, FILTER_VALIDATE_IP))
    {
        $ip = $forward;
    }
    else
    {
        $ip = $remote;
    }

    return $ip;
}
?>
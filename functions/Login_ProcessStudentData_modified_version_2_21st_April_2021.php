<?php

//*****************************************  FUNAAB to Process Student Records *************************************************
   function processStudentData($regNumber, $json){
     $err_flag = 0;
     $err_msg = null;

     $studentStatus=$json->PaymentStatus;
     $surname=htmlentities(strtoupper(trim($json->Surname)), ENT_QUOTES);
     $firstname=htmlentities(ucfirst(strtolower(trim($json->Firstname))), ENT_QUOTES);
     $othername= htmlentities(ucfirst(strtolower(trim($json->Middlename))), ENT_QUOTES);
     $photo = trim($json->ProfileUrl);
     $gender=strtoupper(trim($json->Sex));
     $deptCode=strtoupper(trim($json->Department));
     $level=strtoupper(trim($json->Level));
     //echo $level;
     $minDuration=strtoupper(trim($json->MinDuration));
     $phone=strtoupper(trim($json->Phone));
     $email=strtolower(trim($json->Email));
     $funaabEmail = strtolower(trim($json->OfficialEmail));
     $collegeCode=strtoupper(trim($json->College));
     $sex=strtoupper(trim($json->Sex));
     $CGPA=strtoupper(trim($json->CGPA));
     $Matric=strtoupper(trim($json->MatricNo));
     $programme=ucfirst(strtolower(trim($json->Programme)));
     //echo "Duration:$minDuration, Level: $level, $collegeCode, $regNumber<br>";

     $dataArray = array("regNumber"=>$regNumber,"studentStatus"=>$studentStatus, "surname"=>$surname, "firstname"=>$firstname, "othername"=>$othername,
     "photo"=>$photo,"gender"=>$gender, "deptCode"=>$deptCode, "level"=>$level, "MinDuration"=>$minDuration, "phone"=>$phone, "email"=>$email,
     "funaabEmail"=>$funaabEmail, "collegeCode"=>$collegeCode, "sex"=>$sex, "CGPA"=>$CGPA, "Matric"=>$Matric, "programme"=>$programme);

     //echo $studentStatus;
     // verify if the student record is found
     if (($surname=='') || ($firstname=='') || ($email=='') || ($phone=='')){
         $err_flag = 1;
         $err_msg = 'Error retrieving record. <br/>Check the Matriculation No. entered';
     }else{

        // Record found proceed to insert user data into siwes applicant database if not already other
        // check student Status: if PAID
        $applicant = new Applicant();

       if ($studentStatus=="PAID"){
             //echo 'PAID';
             $getApplicant = $applicant->getApplicant($regNumber);

             // check if record is not found and insert into applicants
             if ($getApplicant->rowCount()==0){
                       // create applicant record for the user
                       //echo "Applicant is not created";

                       $applicantData = array("regNumber"=>$regNumber,"surname"=>$surname,"firstname"=>$firstname,"othername"=>$othername,"phone"=>$phone,
                                        "email"=>$email,"funaabEmail"=>$funaabEmail,"photo"=>$photo,"level"=>$level,"acadaLevel"=>$level,"gender"=>$gender,"deptCode"=>$deptCode,"collegeCode"=>$collegeCode,
                                        "CGPA"=>$CGPA,"minDuration"=>$minDuration);

                       $new_applicant = $applicant->create_new_applicant($applicantData);



                       // if new applicant is created
                       if ($new_applicant->rowCount()){
                           //session_start();

                           $_SESSION['app_login'] = 'student';
                           $_SESSION['ulogin_state'] = $regNumber;
                           $_SESSION['regNumber'] = $regNumber;
                           $_SESSION['studentData'] = $dataArray;

                            if (headers_sent()){
                                die("<br/><br/><div class='mt-5 text-center'><big>If not re-directed. Please click on this link: <a href='student/clearance_form.php'>Clearance Form</a></big></div>");
                            }else{
                                header("location:student/clearance_form.php");
                            }

                       }else{
                            // creating new applicant failed
                            //echo "Applicant Saving failed";

                            $err_flag = 1;
                            $err_msg .= 'Record not saved. Please try again.';
                       }
             }else{
                     // applicant had already been created...then redirect to the prepayment page
                         //session_start();

                         $_SESSION['app_login'] = 'student';
                         $_SESSION['ulogin_state'] = $regNumber;
                         $_SESSION['regNumber'] = $regNumber;
                         $_SESSION['studentData'] = $dataArray;
                         if (headers_sent()){
                           die("<div class='mt-5 text-center'><big>If not redirected. Please click on this link: <a href='student/clearance_form.php'>Clearance Form</a></big></div>");
                         }else{
                           header("location:student/clearance_form.php");
                         }

             }

         }else{
                         // School fees status not PAID
                         //echo "School fees not PAID";

                         $err_flag = 1;
                         $err_msg .= "School Fees Payment Status: Not PAID";

         }


     }
     // end of verification of student record

                        return $err_msg;
   } //end of function to process student data




?>

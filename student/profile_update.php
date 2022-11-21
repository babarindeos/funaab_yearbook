<?php

  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);
  //session_start();


      require_once('../lib/phpqrcode/qrlib.php');




      $page_title = "Student Affairs | YearBook";

      // Core
      require_once("../core/wp_config.php");


      // authentication
      if (!(isset($_SESSION['app_login']) && $_SESSION['app_login'] != '' && $_SESSION['app_login'] == 'student')) {
          header ("Location: ../index.php");
      }


      // classes
      require_once("../abstract/Database.php");

      require_once("../classes/PDO_QueryExecutor.php");
      require_once("../classes/PDODriver.php");
      require_once("../classes/YearBook.php");



      // Header
      //require_once("includes/header.php");


      // Navigation

      // Portal WebServices integrated
      require_once("../nav/student_nav.php");
      require_once("../includes/funaabWS.php");
      require_once("../includes/ws_functions.php");
      require_once("../includes/ws_parameters.php");
      require_once("../functions/FieldSanitizer.php");


  //----------------------- Student Data ----------------------------------------------------
      //Initialise
          $studentData = $_SESSION['studentData'];
          $matric_no = $studentData['regNumber'];
          $surname = $studentData['surname'];
          $firstname = $studentData['firstname'];
          $othername = $studentData['othername'];
          $email = $studentData['email'];
          $emailFunaab = $studentData['funaabEmail'];
          $phone = $studentData['phone'];
          $photo = $studentData['photo'];
          $collegeCode  = $studentData['collegeCode'];
          $deptCode = $studentData['deptCode'];
          $level  = $studentData['level'];


          //initialize $hoc_value
          $hoc_value = 'N';
//----------------------- End of Student Data -----------------------------------------------



//----------------------- Currently active academic session ---------------------------------

        $academic_session = new AcademicSession();
        $get_current_active_session = $academic_session->get_active_session();
        $get_current_active_session = $get_current_active_session->fetch(PDO::FETCH_ASSOC);

        $current_active_session = $get_current_active_session['session'];





//---------------------- End of Academic Session --------------------------------------------


// ------------------------ isPostBack ------------------------------------------------------

$err_flag = 0;
$err_msg = '';

if (isset($_POST['btnSubmit'])){

  $dob_day = $_POST['dob_day'];
  $dob_month = $_POST['dob_month'];
  $phone = FieldSanitizer::inClean($_POST['phone']);
  $email = FieldSanitizer::inClean($_POST['email']);
  $address = FieldSanitizer::inClean($_POST['address']);
  //$uploaded_passport = trim($_POST['uploaded_passport']);


  //$uploaded_passport = trim($_SESSION['yearbook_passport']);
  $uploaded_passport = trim($_POST['uploaded_passport']);



  $hoc = $_POST['hoc'];

  //echo "postback";


    if ($dob_day==''){
      $err_flag = 1;
      $err_msg = '<small><i class="fas fa-asterisk"></i></small> Missing Day of Birth. Provide your day of birth.';
    }

    if ($dob_month==''){
      $err_msg .= '<div><small><i class="fas fa-asterisk"></i></small> Missing Month of Birth. Provide your month of birth.</div>';
      $err_flag = 1;
    }


    if ($email==''){
      $err_msg .= '<div><small><i class="fas fa-asterisk"></i></small> Missing Email Address. Provide your email address.</div>';
      $err_flag = 1;
    }

    if ($phone==''){
      $err_msg .= '<div><small><i class="fas fa-asterisk"></i></small> Missing Phone No. Provide your functional phone number.</div>';
      $err_flag = 1;
    }

    if ($address==''){
      $err_msg .= '<div><small><i class="fas fa-asterisk"></i></small> Missing Address. Provide your residence address.</div>';
      $err_flag = 1;
    }

    if ($uploaded_passport=='../../images/generic_avatar.png' || $uploaded_passport==''){
      $err_msg .= '<div><small><i class="fas fa-asterisk"></i></small> Missing Passport Photograph. Upload a good quality passport of yourself.</div>';
      $err_flag = 1;
    }




    if ($dob_day!='' && $dob_month!='' && $email!='' && $phone!='' && $address!='' && $uploaded_passport!=''){
        $fullname = $surname.' '.$firstname.' '.$othername;
        $dob = '';
        switch($dob_day){
          case '1':
            $dob = '1st '.$dob_month;
            break;
          case '2':
            $dob = '2nd '.$dob_month;
            break;
          case '3':
            $dob = '3rd '.$dob_month;
            break;
          default:
            $dob = $dob_day.'th '.$dob_month;
            break;
        }

        $data_array = array("matric_no"=>$matric_no, "session"=>$current_active_session,"fullname"=>$fullname,"dob_day"=>$dob_day,
                            "dob_month"=>$dob_month,"dob"=>$dob, "email"=>$email, "phone"=>$phone, "address"=>$address,
                            "uploaded_passport"=>$uploaded_passport, "hoc"=>$hoc);

        $yearbook = new YearBook();
        $isYearBookDataCreated = $yearbook->checkforStudentData($matric_no);


        if ($err_flag==1){
                  echo "error";
                  $err_msg = "<span>Missing Passport Photograph. <div><small>You must upload a passport with the stipulated specification</small></div></span>";
        }else{
                if ($isYearBookDataCreated->rowCount()){
                    //echo "update<br/>";
                    $result = $yearbook->updateYearBookData($data_array);
                    //echo $result->rowCount();
                        if ($result->rowCount()){
                            $err_flag = 0;
                            $err_msg = "<span>Your YearBook record has been successfully updated. <div><small>Note: Please check back in 24 hours to know the status of your submission. Thank you.</small></div></span>";
                        }else{
                            $err_flag = 1;
                            $err_msg = "<span>An error occurred updating your profile. <div><small>Note: Please try again. If problem persist contact the Student Affairs Office. Thank you.</small></div></span>";
                        }


                }else{
                    //echo "creation";
                    $result = $yearbook->createYearBookData($data_array);
                    //echo $result->rowCount();
                    if ($result){
                        $err_flag = 0;
                        $err_msg = "<span>Your YearBook record has been successfully submitted awaiting acceptance.<div><small>Note: Please check back in 24 hours to know the status of your submission. Thank you.</small></div></span>";
                    }else{
                        $err_flag = 1;
                        $err_msg = "There was a problem creating your YearBook record.";
                    }
                } // end of else if
        }




    } // end of if($dob_day)



}




//-------------------------- end of isPostBack ----------------------------------------------



//---------------------------- Retrieve User Data ------------------------------------------
    $dob_day = '';
    $dob_month ='';
    $dob = '';
    $email = '';
    $phone = '';
    $address = '';


    $yearbook = new YearBook();
    $isYearBookDataCreated = $yearbook->checkforStudentData($matric_no);


    //$passport = "../../images/generic_avatar.png";
    if ($isYearBookDataCreated->rowCount()){

        while($row = $isYearBookDataCreated->fetch(PDO::FETCH_ASSOC)){
            $dob_day = $row['dob_day'];
            $dob_month = $row['dob_month'];
            $dob = $row['dob'];
            $email = FieldSanitizer::outClean($row['email']);
            $phone = FieldSanitizer::outClean($row['phone']);
            $address = FieldSanitizer::outClean($row['address']);
            $hoc_value = $row['hoc'];
            $status = $row['status'];
            $status_feedback = $row['status_msg'];



            if ($row['photo']!=''){
                $passport = $row['photo'];
                $_SESSION['yearbook_passport'] = $passport;
            }


        }
    }


//--------------------------- End of retrieve Data ------------------------------------------



if (isset($_GET['dob_day'])){
    $dob_day = $_GET['dob_day'];
}

if (isset($_GET['dob_month'])){
    $dob_month = $_GET['dob_month'];
}

if (isset($_GET['phone'])){
    $phone = $_GET['phone'];
}

if (isset($_GET['email'])){
    $email = $_GET['email'];
}

if (isset($_GET['address'])){
    $address = $_GET['address'];
}

//--------------------------- End of GET ---------------------------------------------------


?>

<div class="container">


    <div class="row" style="margin-top:20px;">




                <!-- Heading pane //-->
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <h4 class='mb-4'>Student YearBook<br><small><?php echo $current_active_session; ?> Academic Session</small></h4>

                    <hr>
                    <!-- Salutation //-->
                    <?php

                        echo "<div class='mb-2'><strong>Welcome, </strong>".$surname." ".$firstname." ".$othername."</div>";

                    ?>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5 border rounded text-center mt-3">
                      <label for="file">
                      <?php

                          if (isset($_SESSION['yearbook_passport']))
                          {
                                $generic_photo = "passports/".$_SESSION['yearbook_passport'];
                                //echo "Session: ".$_SESSION['yearbook_passport'];
                          }else{
                                $generic_photo = "../images/generic_avatar.png";
                                //echo $generic_photo;
                          }



                          echo "<div class='avatar mx-auto white mt-4'><img width='350px' id='img_passport' src='{$generic_photo}' alt='{$surname} photo' class='rounded img-fluid border' style='border-radius:15px;'></div> ";

                          echo "<div class=' mt-1 mb-4 font-weight-bold'>Passport Photograph</div>";

                      ?>
                      <input id='user_passport' type='hidden' value="<?php echo $generic_photo; ?>" />




                      <!-- spinner //-->
                                  <div id='spinner' style="display:none;">
                                        <?php
                                            include("../functions/BigBlueSpinner.php");
                                            echo "<span class='text-primary'> Uploading Passport Photograph...</span>";
                                        ?>
                                  </div>
                      <!-- end of spinner //-->

                      <!-- file uploader //-->
                                  <?php
                                    if($status=='' || $status=='Declined')
                                    {

                                  ?>
                                  <div class="md-form text-center" id='file_uploader'  >
                                      <div class="file-field">
                                          <div class="btn btn-info btn-sm float-left">
                                            <span>Choose Passport to Upload</span>
                                            <input type="file" id="file" >
                                          </div>
                                          <div class="file-path-wrapper" >
                                            <input class="file-path validate" type="text" placeholder="Upload Passport">
                                          </div>
                                      </div>
                                  </div>
                                <?php
                                    }
                                ?>
                      <!-- end of file uploader //-->
                      <!--<button id='upload_passport' type='btn btn-sm btn-warning'>Upload Passport</button> //-->
                      </label>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-7 col-lg-7">
                          <!-- Postback feedback //-->
                            <?php
                                if (isset($_POST['btnSubmit'])){
                                    if ($err_flag){
                                        $err_msg = 'An error has occurred!<hr/>'.$err_msg;
                                        miniErrorAlert($err_msg);
                                    }else{
                                        miniSuccessAlert($err_msg);
                                    }
                                }
                            ?>

                            <?php

                                  if ($isYearBookDataCreated->rowCount()){
                                          if ($status==''){
                                              $status_msg = "<span class='font-weight-normal'>Your submission is <strong>PENDING</strong> Acceptance</span>";
                                              miniPendingAlert($status_msg);

                                          }else if($status=='Approved'){
                                              $status_msg = "<span class='font-weight-normal'><strong>Congratulation!</strong>  Your submission has been approved</span>";
                                              miniApprovedAlert($status_msg);

                                          }else if($status=='Declined'){
                                              $status_msg = "<span class='font-weight-normal'>Your submission has been declined<div><small><strong>Feedback: </strong>".$status_feedback."</small></div></span>";
                                              miniDeclinedAlert($status_msg);
                                          }
                                  }
                            ?>

                          <!-- End of postback feedback //-->
                          <form action="profile_update.php" method="post">


                                      <div class='form-group mt-4'>
                                          <label for='fullname'><strong>Full Name</strong></label>
                                          <input type='text' class='form-control col-xs-12 col-sm-12 col-md-12 col-lg-12' readonly id='fullname' value="<?php echo $surname.' '.$firstname.' '.$othername; ?>" required>
                                      </div>

                                      <!-- Form Row  //-->
                                      <div style='margin-bottom:-5px'>
                                          <label for='dob'><strong>Day & Month of Birth</strong></label>
                                      </div>
                                      <div class='form-row' >
                                            <div class='col'>
                                              <div class='form-group mt-2 '>
                                                <select class="browser-default custom-select" name="dob_day" id="dob_day" <?php if($status=='Approved'){echo 'disabled'; } ?>>
                                                  <option value=''>--Select Day --</option>
                                                  <?php
                                                      $selected = '';
                                                      for($i=1; $i<=31; $i++){
                                                        if ($i==$dob_day){$selected='selected';}else{$selected='';}
                                                        echo "<option $selected value='".$i."'>".$i."</option>";
                                                      }
                                                  ?>
                                                </select>
                                              </div>
                                            </div>

                                            <div class='col'>
                                              <div class='form-group mt-2'>
                                                <select class="browser-default custom-select" name="dob_month" id="dob_month" <?php if($status=='Approved'){echo 'disabled'; } ?>>
                                                  <option value=''>-- Select Month--</option>
                                                  <option <?php if($dob_month=='January'){echo 'selected';} ?> value="January">January</option>
                                                  <option <?php if($dob_month=='February'){echo 'selected';} ?> value="February">February</option>
                                                  <option <?php if($dob_month=='March'){echo 'selected';} ?> value="March">March</option>
                                                  <option <?php if($dob_month=='April'){echo 'selected';} ?> value="April">April</option>
                                                  <option <?php if($dob_month=='May'){echo 'selected';} ?> value="May">May</option>
                                                  <option <?php if($dob_month=='June'){echo 'selected';} ?> value="June">June</option>
                                                  <option <?php if($dob_month=='July'){echo 'selected';} ?> value="July">July</option>
                                                  <option <?php if($dob_month=='August'){echo 'selected';} ?> value="August">August</option>
                                                  <option <?php if($dob_month=='September'){echo 'selected';} ?> value="September">September</option>
                                                  <option <?php if($dob_month=='October'){echo 'selected';} ?> value="October">October</option>
                                                  <option <?php if($dob_month=='November'){echo 'selected';} ?> value="November">November</option>
                                                  <option <?php if($dob_month=='December'){echo 'selected';} ?> value="December">December</option>
                                                </select>
                                              </div>
                                            </div>
                                      </div>
                                      <!-- End of Form Row //-->


                                      <div class='form-group mt-1'>
                                          <label for='phone'><strong>Phone No.</strong></label>
                                          <input type='text' class='form-control col-xs-12 col-sm-12 col-md-12 col-lg-12' id='phone' name='phone' value="<?php echo $phone; ?>" <?php if($status=='Approved'){echo 'disabled'; } ?> required>
                                      </div>

                                      <div class='form-group mt-1'>
                                          <label for='email'><strong>Email</strong></label>
                                          <input type='text' class='form-control col-xs-12 col-sm-12 col-md-12 col-lg-12' id='email' name='email' value="<?php echo $email; ?>" <?php if($status=='Approved'){echo 'disabled'; } ?> required>
                                      </div>

                                      <div class='form-group mt-1'>
                                          <label for='address'><strong>Address</strong></label>
                                          <input type='text' class='form-control col-xs-12 col-sm-12 col-md-12 col-lg-12' id='address' name='address' value="<?php echo $address; ?>" <?php if($status=='Approved'){echo 'disabled'; } ?> required>
                                      </div>

                                      <div class="form-group">
                                            <div>
                                              <label for='hoc'><strong>Are you the Head of the Class (HOC)? </label>
                                            </div>
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" class="custom-control-input" id="hoc_no" name="hoc" value="N" <?php if($hoc_value=='N'){echo 'checked';}  ?>  <?php if($status=='Approved'){echo 'disabled'; } ?> >
                                                <label class="custom-control-label" for="hoc_no">No</label>
                                            </div>
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" class="custom-control-input" id="hoc_yes" value="Y" name="hoc" <?php if($hoc_value=='Y'){echo 'checked';}  ?>  <?php if($status=='Approved'){echo 'disabled'; } ?> >
                                                <label class="custom-control-label" for="hoc_yes">Yes</label>
                                            </div>
                                      </div>



                                      <div><input type='hidden' name='uploaded_passport' id='uploaded_passport' value="<?php if(isset($_SESSION['yearbook_passport'])){ echo $_SESSION['yearbook_passport']; }else{ echo $passport; } ?>"></div>


                                      <?php
                                          $styleHidden = "style='display:none'";

                                          if ($status=='' || $status=='Declined'){
                                      ?>

                                      <div class='form-group mt-1'>
                                          <button type='submit' class='btn btn-sm btn-primary' id='btnSubmit' name='btnSubmit'>Submit</button>
                                      </div>
                                      <?php
                                          }
                                      ?>


                            </form>
                </div>



      </div><!-- end of row //-->




  </div><!-- end of container //-->

        <input id='matric_no' type='hidden' value="<?php echo $matric_no; ?>" />



        <br/><br/><br/>
        <?php
              //footer
              require_once("../includes/footer.php");
         ?>
<script>
  $(document).ready(function(){
        $(document).on('change', '#file', function(){
            var property = document.getElementById("file").files[0];
            var image_name = property.name;
            var image_extension = image_name.split('.').pop().toLowerCase();

            if (jQuery.inArray(image_extension, ['gif', 'png', 'jpg', 'jpeg', 'jpeg'])==-1){
                alert("The selected file is invalid for upload as a picture");
            }else{
                var image_size = property.size;
                var matric_no = $("#matric_no").val();

                if (image_size>5000000){
                        alert("The selected picture is larger than the required picture size. Please resize the picture.");
                }else{
                        $("#img_passport").attr('src', '../assets/spinner.gif');

                        var form_data = new FormData();

                        console.log(form_data);
                        form_data.append("file", property);

                        $.ajax({
                            url: '../async/server/file_upload/yearbook_upload_passport.php?source=students_affairs&matric_no='+matric_no,
                            method: 'POST',
                            data: form_data,
                            dataType: 'json',
                            contentType:false,
                            cache: false,
                            processData: false,
                            beforeSend: function(){},
                            success: function(data){
                               console.log(data);
                               if (data.status=='success'){
                                  var img_location = "passports/"+data.wp_filename;
                                  console.log(img_location);
                                  $("#img_passport").attr("src",img_location + '?' + new Date().getTime());
                                  $("#user_passport").val(img_location);
                                  $("#uploaded_passport").val(data.wp_filename);
                               }else{
                                  var img_location = $("#user_passport").val();
                                  $("#img_passport").attr("src",img_location);
                                  alert(data.message);

                               }
                            }
                        });
                }


            }
        });
  });


</script>

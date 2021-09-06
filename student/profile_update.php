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
  $uploaded_passport = $_POST['uploaded_passport'];


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

    if ($uploaded_passport=='../../images/generic_avatar.png'){
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
                            "uploaded_passport"=>$uploaded_passport);

        $yearbook = new YearBook();
        $isYearBookDataCreated = $yearbook->checkforStudentData($matric_no);
        //echo $isYearBookDataCreated->rowCount();

        if ($isYearBookDataCreated->rowCount()){
            $result = $yearbook->updateYearBookData($data_array);
                $err_flag = 0;
                $err_msg = "Your YearBook record has been successfully updated.";

        }else{
            $result = $yearbook->createYearBookData($data_array);
            if ($result->rowCount()){
                $err_flag = 0;
                $err_msg = "Your YearBook record has been successfully created.";
            }else{
                $err_flag = 1;
                $err_msg = "There was a problem creating your YearBook record.";
            }
        } // end of else if



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


    $passport = "../../images/generic_avatar.png";
    if ($isYearBookDataCreated->rowCount()){
        while($row = $isYearBookDataCreated->fetch(PDO::FETCH_ASSOC)){
            $dob_day = $row['dob_day'];
            $dob_month = $row['dob_month'];
            $dob = $row['dob'];
            $email = FieldSanitizer::outClean($row['email']);
            $phone = FieldSanitizer::outClean($row['phone']);
            $address = FieldSanitizer::outClean($row['address']);

            if ($row['photo']!=''){
                $passport = $row['photo'];

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

                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 border rounded text-center mt-3">
                      <?php

                          if (isset($_SESSION['yearbook_passport']))
                          {
                                $generic_photo = "passports/".$_SESSION['yearbook_passport'];
                                //echo "Session: ".$_SESSION['yearbook_passport'];
                          }else{
                                $generic_photo = "passports/".$passport;
                          }



                          echo "<div class='avatar mx-auto white mt-4'><img width='250px' id='img_passport' src='{$generic_photo}' alt='{$surname} photo' class='rounded img-fluid border'></div> ";
                          echo "<div class=' mt-1 mb-4'>Passport Photograph</div>";

                      ?>

                      <!-- spinner //-->
                                  <div id='spinner' style="display:none;">
                                        <?php
                                            include("../functions/BigBlueSpinner.php");
                                            echo "<span class='text-primary'> Uploading Passport Photograph...</span>";
                                        ?>
                                  </div>
                      <!-- end of spinner //-->

                      <!-- file uploader //-->
                                  <div class="md-form text-center" id='file_uploader' >
                                      <div class="file-field">
                                          <div class="btn btn-info btn-sm float-left">
                                            <span>Choose Passport to Upload</span>
                                            <input type="file" id="file">
                                          </div>
                                          <div class="file-path-wrapper" >
                                            <input class="file-path validate" type="text" placeholder="Upload Passport">
                                          </div>
                                      </div>
                                  </div>
                      <!-- end of file uploader //-->
                      <!--<button id='upload_passport' type='btn btn-sm btn-warning'>Upload Passport</button> //-->
                </div>
                <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
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
                          <!-- End of postback feedback //-->
                          <form action="profile_update.php" method="post">


                                      <div class='form-group mt-4'>
                                          <label for='fullname'><strong>Full Name</strong></label>
                                          <input type='text' class='form-control col-xs-12 col-sm-12 col-md-12 col-lg-12' readonly id='fullname' value="<?php echo $surname.' '.$firstname.' '.$othername; ?>">
                                      </div>

                                      <!-- Form Row  //-->
                                      <div style='margin-bottom:-5px'>
                                          <label for='dob'><strong>Day & Month of Birth</strong></label>
                                      </div>
                                      <div class='form-row' >
                                            <div class='col'>
                                              <div class='form-group mt-2 '>
                                                <select class="browser-default custom-select" name="dob_day" id="dob_day">
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
                                                <select class="browser-default custom-select" name="dob_month" id="dob_month">
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
                                          <input type='text' class='form-control col-xs-12 col-sm-12 col-md-12 col-lg-12' id='phone' name='phone' value="<?php echo $phone; ?>">
                                      </div>

                                      <div class='form-group mt-1'>
                                          <label for='email'><strong>Email</strong></label>
                                          <input type='text' class='form-control col-xs-12 col-sm-12 col-md-12 col-lg-12' id='email' name='email' value="<?php echo $email; ?>">
                                      </div>

                                      <div class='form-group mt-1'>
                                          <label for='address'><strong>Address</strong></label>
                                          <input type='text' class='form-control col-xs-12 col-sm-12 col-md-12 col-lg-12' id='address' name='address' value="<?php echo $address; ?>" >
                                      </div>

                                      <div><input type='hidden' name='uploaded_passport' id='uploaded_passport' value="<?php if(isset($_SESSION['yearbook_passport'])){ echo $_SESSION['yearbook_passport']; }else{ echo $passport; } ?>"></div>

                                      <div class='form-group mt-1'>
                                          <button type='submit' class='btn btn-sm btn-primary' id='btnSubmit' name='btnSubmit'>Submit</button>
                                      </div>
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

      // file upload
              $("#file").on("change", function(){
                    var property = document.getElementById("file").files[0];
                    var image_name = property.name;

                    var image_extension = image_name.split('.').pop().toLowerCase();

                    if (jQuery.inArray(image_extension,['gif','png','jpg','jpeg'])==-1){
                          alert("Invalid image format. Please select an image file in any of the specified format.");
                    }else{

                        run_file_upload(property);
                    }

              });

// -------------------------------------------------------------------------------------------
// function to load files
    function run_file_upload(property){
          var image_size = property.size;
          image_size = image_size/1024;
          //alert(image_size);
          if (image_size>20000){
              alert("The file is larger than the allowed 20MB size. Please resize and try again.");
          }else{
                  var form_data = new FormData();
                  form_data.append("file", property);
                  //form_data.append("source", 'announcement');
                  //form_data.append("file_type", file_type);

                  var matric_no = $("#matric_no").val();

                  $.ajax({
                      url: '../async/server/file_upload/yearbook_upload_passport.php?source=students_affairs&matric_no='+matric_no,
                      method: "POST",
                      data: form_data,
                      dataType:  'json',
                      contentType: false,
                      cache: false,
                      processData: false,
                      beforeSend: function(){
                          $("#file_uploader").hide();
                          $("#spinner").show();
                      },
                      success: function(data){
                          //console.log("am here");
                          //console.log(data.status);
                          //alert(data);
                          $("#spinner").hide();
                          $("#file_uploader").show();

                          //data = JSON.parse(data);
                          if (data.status=='success'){

                              $("#uploaded_passport").val(data.wp_filename);

                              var img_location = "passports/"+data.wp_filename;

                              console.log(img_location);
                              $("#img_passport").attr("src",img_location);

                              var dob_day = $("#dob_day").val();
                              var dob_month = $("#dob_month").val();
                              var phone = $("#phone").val();
                              var email = $("#email").val();
                              var address = $("#address").val();

                              location.reload(true);
                              var loc = "profile_update.php?dob_day="+dob_day+"&dob_month="+dob_month+"&phone="+phone+"&email="+email+"&address="+address;
                              window.location.href= loc;

                          }

                      }
                  });
          } // end of if
    }
// -------------------------------------------------------------------------------------------





//---------------------------------------------------------------------------------------------

});  // end of document.ready(function())

</script>

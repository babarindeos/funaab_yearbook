  <?php

  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);
  //session_start();


      $page_title = "Student Affairs | YearBook";

      // Core
      require_once("../core/wp_config.php");


      // authentication
      if (!(isset($_SESSION['app_login']) && $_SESSION['app_login'] != '' && $_SESSION['app_login'] == 'dean')) {
          header ("Location: ../index.php");
      }


      // classes
      require_once("../abstract/Database.php");

      require_once("../classes/PDO_QueryExecutor.php");
      require_once("../classes/PDODriver.php");
      require_once("../classes/YearBook.php");
      require_once("../classes/StaffUser.php");
      require_once("../classes/Auth.php");



      // Header
      //require_once("includes/header.php");


      // Navigation

      // Portal WebServices integrated
      require_once("../nav/dean_nav.php");

      //require_once("../includes/funaabWS.php");
      //require_once("../includes/ws_functions.php");
      //require_once("../includes/ws_parameters.php");

      require_once("../functions/FieldSanitizer.php");




//----------------------- Currently active academic session ---------------------------------

        $academic_session = new AcademicSession();
        $get_current_active_session = $academic_session->get_active_session();
        $get_current_active_session = $get_current_active_session->fetch(PDO::FETCH_ASSOC);

        $current_active_session = $get_current_active_session['session'];

//---------------------- End of Academic Session --------------------------------------------


// ------------------------ isPostBack ------------------------------------------------------

$err_flag = 0;
$err_msg = '';

$file_no = $_SESSION['auth_username'];


if (isset($_POST['btnSubmit'])){

  $fullname = FieldSanitizer::inClean($_POST['fullname']);
  $qualifications = FieldSanitizer::inClean($_POST['qualifications']);
  $message = FieldSanitizer::inClean($_POST['message']);
  $uploaded_passport = $_POST['uploaded_passport'];

  //
  // if ($_SESSION['yearbook_passport']){
  //     $uploaded_passport = $_POST['uploaded_passport'];
  // }else{
  //     $uploaded_passport = '';
  // }

  if ($fullname!='' && $qualifications!='' && $message!='' && $uploaded_passport!=''){

        $college = $_SESSION['auth_college'];

        $data_array = array("file_no"=>$file_no, "session"=>$current_active_session, "college"=>$college, "fullname"=>$fullname,
                           "qualifications"=>$qualifications,"uploaded_passport"=>$uploaded_passport, "message"=>$message);

        $yearbook = new YearBook();
        $isDeanData = $yearbook->checkforDeanData($file_no, $current_active_session);
        //echo "Am here: ".$isDeanData->rowCount();

        if ($isDeanData->rowCount()){
            echo "Updating isDeanData";
            $result = $yearbook->updateDeanData($data_array);
                if ($result){
                    $err_flag = 0;
                    $err_msg = "Your Profile has been successfully updated.";
                }else{
                    $err_flag = 1;
                    $err_msg = "There was an error updating your profile";
                }

        }else{
            echo "Inserting";
            $result = $yearbook->createDeanData($data_array);
            if ($result->rowCount()){
                $err_flag = 0;
                $err_msg = "Your Profile has been successfully created.";
            }else{
                $err_flag = 1;
                $err_msg = "There was a problem creating your Profile.";
            }
        } // end of else if

  } // end of if($dob_day)



}




//-------------------------- end of isPostBack ----------------------------------------------



//---------------------------- Retrieve User Data ------------------------------------------
    $fullname = '';
    $qualifications = '';
    $message = '';


    $yearbook = new YearBook();
    $isDeanData = $yearbook->checkforDeanData($file_no, $current_active_session);


    $generic_photo = '';
    if ($isDeanData->rowCount()){
        while($row = $isDeanData->fetch(PDO::FETCH_ASSOC)){

            $fullname = FieldSanitizer::outClean($row['fullname']);
            $qualifications = FieldSanitizer::outClean($row['qualifications']);
            $message = FieldSanitizer::outClean($row['message']);

            //echo 'Passport: '.$row['passport'];
            if ($row['passport']!=''){
                $generic_photo = '../student/passports'.$row['passport'];
                $_SESSION['yearbook_passport'] = $row['passport'];
            }

            //echo $generic_photo;
        }

      //  echo $generic_photo;
    }


//--------------------------- End of retrieve Data ------------------------------------------

 $staff = new StaffUser();
 $get_dean = $staff->get_dean_info($_SESSION['auth_id']);
 $dean_registered_info = $get_dean->fetch(PDO::FETCH_ASSOC);

 $file_no = $dean_registered_info['file_no'];




?>

<div class="container">


    <div class="row" style="margin-top:20px;">




                <!-- Heading pane //-->
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <h4 class='mb-4'>Student YearBook<br><small><?php echo $current_active_session; ?> Academic Session</small></h4>

                    <hr>
                    <!-- Salutation //-->
                    <?php

                        echo "<div class='mb-2'><strong>Welcome, </strong>".$dean_registered_info['fullname']."</div>";

                    ?>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 border rounded text-center mt-3">
                      <?php

                          if (isset($_SESSION['yearbook_passport']))
                          {
                                $generic_photo = "../student/passports/".$_SESSION['yearbook_passport'];
                                //echo "Session: ".$_SESSION['yearbook_passport'];

                          }else{
                                //$generic_photo = "../student/passports/".$passport;

                                if ($generic_photo==''){

                                    $generic_photo = "../images/generic_avatar.png";
                                }


                          }



                          echo "<div class='avatar mx-auto white mt-4'><img width='250px' id='img_passport' src='{$generic_photo}' alt='{$fullname} photo' class='rounded img-fluid border'></div> ";
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
                          <form action="profile_form.php" method="post">


                                      <div class='form-group mt-2'>
                                          <label for='fullname'><strong>Title & Full Name</strong></label>
                                          <input type='text' class='form-control col-xs-12 col-sm-12 col-md-12 col-lg-12' name='fullname' id='fullname' value="<?php echo $fullname ?>">
                                      </div>

                                      <!-- Form Row  //-->
                                      <div class='form-group mt-2'>
                                          <label for='qualifications'><strong>Qualifications</strong></label>
                                          <input type='text' class='form-control col-xs-12 col-sm-12 col-md-12 col-lg-12' name='qualifications' id='qualifications' value="<?php echo $qualifications; ?>">
                                      </div>
                                      <!-- End of Form Row //-->


                                      <div class='form-group mt-1'>
                                          <label for='phone'><strong>Message</strong></label>
                                          <textarea type='text' class='form-control col-xs-12 col-sm-12 col-md-12 col-lg-12' rows='10' id='message' name='message'><?php echo $message; ?></textarea>
                                      </div>



                                      <div><input type='text' name='uploaded_passport' id='uploaded_passport' value="<?php if(isset($_SESSION['yearbook_passport'])){ echo $_SESSION['yearbook_passport']; }else{ echo $passport; } ?>"></div>

                                      <div class='form-group mt-1'>
                                          <button type='submit' class='btn btn-sm btn-primary' id='btnSubmit' name='btnSubmit'>Submit</button>
                                      </div>
                            </form>
                </div>



      </div><!-- end of row //-->




  </div><!-- end of container //-->

        <input id='file_no' type='hidden' value="<?php echo $file_no; ?>" />
        <input id='acad_session' type='hidden' value="<?php echo substr($current_active_session,0,4); ?>" />


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

                  var file_no = $("#file_no").val();
                  var acad_session = $("#acad_session").val();

                  $.ajax({
                      url: '../async/server/file_upload/yearbook_upload_passport.php?source=students_affairs&matric_no='+file_no+'_'+acad_session,
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

                              var img_location = "../student/passports/"+data.wp_filename;

                              console.log(img_location);
                              $("#img_passport").attr("src",img_location);

                              var dob_day = $("#dob_day").val();
                              var dob_month = $("#dob_month").val();
                              var phone = $("#phone").val();
                              var email = $("#email").val();
                              var address = $("#address").val();

                              location.reload(true);
                              var loc = "profile_form.php";
                              //window.location.href= loc;

                          }

                      }
                  });
          } // end of if
    }
// -------------------------------------------------------------------------------------------





//---------------------------------------------------------------------------------------------

});  // end of document.ready(function())

</script>

<link href="https://fonts.googleapis.com/css2?family=Chilanka&family=Sacramento&family=Sansita+Swashed:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
<?php

// get user eligibility
if (!isset($_GET['q']) || $_GET['q']==''){
      header("location: ../my_dashboard.php");
}

$_GET_URL_user_id = explode("-",htmlspecialchars(strip_tags($_GET['q'])));
$_GET_URL_user_id = $_GET_URL_user_id[1];



    $page_title = 'My Profile';

    require_once("../../config/step2/init_wp.php");
    require_once("../../nav/staff_nav.php");
    //require_once("../includes/staff_header.php");

    require_once("../../abstract/User.php");
    require_once("../../classes/StaffUser.php");



    // get user profile information
    $user = new StaffUser();
    $profile = $user->get_staff_by_id($_GET_URL_user_id);
    $names = '';
    //$full_name = ''; $position;
    $avatar = '../images/avatar_100.png';
    foreach($profile as $prof){
        $names = $prof['names'];
        $dept_code = $prof['dept_code'];
        $dept_name = $prof['dept_name'];

        // if ($prof['avatar']!=''){
        //   $avatar = '../avatars/'.$prof['avatar'];
        // }
    }


    //---------------- isPostback ---------------------------------------------
    $err_flag = 0;
    $err_msg = '';

    if (isset($_POST['btnChangePassword'])){

        $current_password = FieldSanitizer::inClean($_POST['current_password']);
        $new_password = FieldSanitizer::inClean($_POST['new_password']);
        $confirm_password = FieldSanitizer::inClean($_POST['confirm_password']);


        $current_password_encrypt = sha1(md5(sha1($current_password)));


        $staff = new StaffUser();
        $is_current_password_correct = $staff->confirm_user_password($_GET_URL_user_id, $current_password_encrypt);

        if ($is_current_password_correct->rowCount()){
            //check for password match
            if ($new_password==$confirm_password){
                  //Check for the length of the password ..must not be less than 6 characters
                  if (strlen($new_password)<6){
                      $err_flag = 1;
                      $err_msg = 'Password must not be less than six (6) characters.';
                  }else{
                      // effect change of password
                      $new_password_encrypt = sha1(md5(sha1($new_password)));
                      $result = $staff->change_user_password($_GET_URL_user_id, $new_password_encrypt);

                      //ascertain the status of the change operation
                      if ($result->rowCount()){
                          $err_flag = 0;
                          $err_msg = 'Your password has been successfully changed.';
                      }else{
                          $err_flag = 1;
                          $err_msg = 'An error occurred changing your password. Contact the Administrator.';
                      }
                  }


            }else{
               $err_flag = 1;
               $err_msg = 'Password mismatch. The new password does not match with the confirm password. Try again.';
            }

        }else{
            $err_flag = 1;
            $err_msg = 'The Current Password entered is wrong';
        }

    }









    //-------------- end of isPostback ----------------------------------------


  ?>


  <!-- Dashboard body //-->
  <div class="container">

      <!-- Page header
      <div class="row">
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 page_header_spacer">
              <h3>Work Circle </h3>
          </div>
      </div>
      end of page header //-->



      <!-- main page area //-->
      <div class="row mt-3">
                  <div class="col-xs-11 col-sm-11 col-md-12 col-lg-12" style='padding:15px;'>
                    <!-- Card -->
                        <div class="card card-cascade wider reverse testimonial-card">

                                <!-- Background color -->
                                <div class="card-up blue-gradient lighten-2">
                                  <!--<img class="card-img-top"
                                      src="https://mdbootstrap.com/img/Photos/Horizontal/Nature/4-col/img%20%28131%29.jpg" alt="Card image cap">
                                      //-->
                                      <div  style='position:absolute;top:53px;left:160px;font-size:25px;color:#ffffff;font-family: Chilanka;'><?php echo $names;?></div>
                                      <div style='position:absolute;top:80px;left:160px;font-size:27px;color:#ffffff;font-family: Sacramento;'><?php echo $dept_name.' ('.$dept_code.')' ;?></div> 
                                      <div style='position:absolute;top:130px;left:160px;font-size:27px;'>
                                            <button type="button" class="btn btn-success btn-rounded btn-sm"><i class="fas fa-pen-alt"></i> Edit Profile</button>

                                      </div>
                                </div>

                                <!-- Avatar -->
                                <div class="avatar white ml-4">
                                <img src="<?php echo $avatar; ?>" class="rounded-circle"
                                  alt="avatar">
                                </div>

                                <!-- Content -->
                                <div class="card-body text-left px-5">
                                    <h4>Change Password</h4>
                                    <div class='row border'>
                                      <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5 mt-3">

                                          <!-- isPostBack Feedback  -->
                                          <div class="md-form">
                                              <?php
                                                  if (isset($_POST['btnChangePassword'])){
                                                        if ($err_flag==1){
                                                              miniErrorAlert($err_msg);
                                                        }else{
                                                              miniSuccessAlert($err_msg);
                                                        }
                                                  }
                                              ?>
                                          </div>
                                          <!-- end of isPostBack feedback //-->


                                         <?php
                                              $formLink = "change_password.php?q=".mask($_GET_URL_user_id);

                                         ?>
                                        <form method="post" action="<?php echo $formLink; ?>" >
                                              <div class="form">
                                                  <div class="form-group">
                                                      <label for="current_password">Current Password</label>
                                                      <input type="password" name="current_password" class="form-control" required >
                                                  </div>

                                                  <!-- new password //-->
                                                  <div class="form-group">
                                                      <label for="new_password">New Password</label>
                                                      <input type="password" name="new_password" class="form-control" required >
                                                  </div>

                                                  <!-- confirm password //-->
                                                  <div class="form-group">
                                                      <label for="confirm_password">Confirm Password</label>
                                                      <input type="password" name="confirm_password" class="form-control" required>
                                                  </div>

                                                  <!-- submit button //-->
                                                  <button type="submit" name="btnChangePassword" class="btn btn-primary btn-sm">Submit</button>

                                              </div>
                                        </form><!-- end of form //-->


                                      </div><!-- end of column //-->

                                    </div><!-- end of row //-->

                                </div><!-- end of card //-->

                        </div>
                    <!-- Card -->
                  </div>

      </div>
      <!-- end of main area //-->


  </div> <!-- end of container //-->

<br/><br/><br/>

<?php

    //footer.php
    require('../../includes/footer.php');
 ?>

<?php
  session_start();

  if (!(isset($_SESSION['app_login']) && $_SESSION['app_login'] != '')) {
       header ("Location: login.php");
  }

  $studentData = $_SESSION['studentData'];



      $page_title = "Login";
      // Core
      require_once("core/config.php");
      // Header
      require_once("includes/header.php");
      // Navigation
      require_once("nav/nav_login.php");




      $err_flag = 0;
      $err_msg = null;
      if (isset($_POST['formLogin'])){
          $username = FieldSanitizer::inClean($_POST['loginUsername']);
          $password = FieldSanitizer::inClean($_POST['loginPassword']);

          if (($username != "") || ($password != "")){

              $auth = new Auth();
              $stmt = $auth->login($username, $password);
              $recordFound = $stmt->rowCount();
              if ($recordFound){

                  // login succeeds
                  $row = $stmt->fetch(PDO::FETCH_ASSOC);

                  //Start session
                  session_start();
                  $_SESSION['ulogin_state'] = 200;
                  $_SESSION['ulogin_id'] = $row['id'];
                  $_SESSION['ulogin_userid'] = $row['user_id'];
                  $_SESSION['ulogin_role'] = $row['role'];
                  $_SESSION['ulogin_fileno'] = $row['file_no'];
                  $_SESSION['ulogin_email'] = $row['email'];


                  //Redirect to appropriate dashboard
                  if ($_SESSION['ulogin_role']=='admin'){
                      header("location: cadmin/admin_dashboard.php");
                  }
                  elseif($_SESSION['ulogin_role']=='hod'){
                      header("location: hod/hod_dashboard.php");
                  }elseif($_SESSION['ulogin_role']=='staff'){
                      header("location: staff/my_dashboard.php");
                  }


              }else{
                 // login fails
                 $err_flag = 1;
                 $err_msg = "Invalid login credentials";
              }

          }else{
              $err_msg = "Username and Password are required.";
              $err_flag = 1;
          }

      }



 ?>

<div class="container-fluid">
    <div class="row" style="margin-top:20px;">

      <!-- left pane //-->
      <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
          <h4 class='mb-4'>SIWES Registration<br><small>2019/2020 Academic Session</small></h4>


          <!-- Registration Form //-->

          <form>
            <!-- Grid row 1 //-->
            <div class="form-row">
                <!-- surname //-->
                <div class="form-group col-md-4">
                    <label for="surname" disabled>Surname</label>
                    <input type='text' class='form-control' id='surname' value="<?php echo $studentData['surname']; ?>" disabled>
                </div>
                <!-- end of surname //-->

                <!-- firstname //-->
                <div class="form-group col-md-4">
                    <label for="firstname" disabled>Firstname</label>
                    <input type='text' class='form-control' id='firstname' value="<?php echo $studentData['firstname']; ?>" disabled>
                </div>
                <!-- end of firstname //-->

                <!-- firstname //-->
                <div class="form-group col-md-4">
                    <label for="othernames" disabled>Othernames</label>
                    <input type='text' class='form-control' id='othernames' value="<?php echo $studentData['othername'] ?>" disabled>
                </div>
                <!-- end of firstname //-->


            </div>
            <!-- end of Grid 1 //-->



            <!-- Grid row 1 //-->
            <div class="form-row">
                <!-- email //-->
                <div class="form-group col-md-8">
                    <label for="email" disabled>Email</label>
                    <input type="email" class="form-control" id="email" value="<?php echo $studentData['email']; ?>" disabled>
                </div>
                <!-- end of email //-->

                <!-- phone //-->
                <div class="form-group col-md-4">
                    <label for="phone" disabled>Phone</label>
                    <input type="phone" class="form-control" id="phone" value="<?php echo $studentData['phone']; ?>" disabled>
                </div>

                <!-- end of phone //-->


            </div>
            <!-- end of Grid row 1 //-->






          </form>





          <!-- end of Registration form //-->




      </div>
      <!-- end of left pane //-->

      <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">


      </div><!-- end of columm //-->



    </div><!-- end of row //-->
</div><!-- end of container //-->

<br/><br/>
<?php
      //footer
      require_once("includes/footer.php");
 ?>

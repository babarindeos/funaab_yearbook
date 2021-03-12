<?php

    $page_title = 'My Dashboard';

    require_once("../core/wp_config.php");
    require_once("../nav/staff_nav.php");
    //require_once("../includes/staff_header.php");

    $user = new StaffUser();


    if (isset($_SESSION['loggedIn_profile_user_id'])){
        // get user profile information



    }else{
        $_SESSION['loggedIn_profile_user_id'] = $_SESSION['ulogin_userid'];
        $_SESSION['loggedIn_profile_file_no'] =   $_SESSION['ulogin_fileno'];

        $user_profile = $user->get_user_by_id($_SESSION['loggedIn_profile_user_id']);
        //print_r($user_profile);

        foreach($user_profile as $up){
            $_SESSION['loggedIn_profile_title'] = $up['title'];
            $_SESSION['loggedIn_profile_firstname'] = $up['first_name'];
            $_SESSION['loggedIn_profile_lastname'] = $up['last_name'];
            $_SESSION['loggedIn_profile_other_names'] = $up['other_names'];
        }


    }



    // Declare Auth class and execute methods
    $auth = new Auth();
    $already_logged_in = $auth->is_firstLogin($_SESSION['ulogin_userid'])->rowCount();
    if ($already_logged_in==0){
        // Retrieve Platform-wide Welcome message
        $notice_board =  new NoticeBoard();
        
              

        


    } // end of already-logged in


  ?>


  <!-- Dashboard body //-->
  <div class="container">

      <!-- Page header //-->
      <div class="row">
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 page_header_spacer">
              <h3>My Dashboard </h3>
              <?php
                  //date_default_timezone_set('Africa/Lagos');
                  //$tokyo = new DateTimeZone('Asia/Tokyo');
                  $nigeria = new DateTimeZone('Africa/Lagos');
                  $now = new DateTime('now', $nigeria);
                  $time = $now->format('g:i A');
                  $hour = $now->format('g');
                  $meridiem = $now->format('A');
                  //echo $time;

                  $salutation = '';
                  if ($meridiem=='AM'){
                      $salutation = "Good morning, ";
                  }else{
                      if ($hour==12 || $hour<4){
                          $salutation = "Good afternoon, ";
                      }else{
                          $salutation = "Good evening, ";
                      }
                  }
                  echo "<span class='font-weight-light'>".$salutation.' '.$_SESSION['loggedIn_profile_title'].' '.$_SESSION['loggedIn_profile_firstname'].' '.$_SESSION['loggedIn_profile_lastname']."</span>";
              ?>
          </div>

      </div>
      <!-- end of page header //-->


  </div> <!-- end of container //-->

<br/><br/><br/>
<input type='hidden' id='is_firstLogin' value="<?php echo $already_logged_in; ?>" />
<?php

    //footer.php
    require('../includes/footer.php');
 ?>
 

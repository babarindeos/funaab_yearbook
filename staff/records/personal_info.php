<?php

    $page_title = 'My Dashboard';

    require_once("../../config/step2/init_wp.php");
    require_once("../../nav/staff_nav.php");
    //require_once("../includes/staff_header.php");

    $user = new StaffUser();


    if (isset($_SESSION['loggedIn_profile_user_id'])){
        // get user profile information



    }else{
        $_SESSION['loggedIn_profile_user_id'] = $_SESSION['ulogin_userid'];
        $_SESSION['loggedIn_profile_file_no'] =   $_SESSION['ulogin_fileno'];

        $user_profile = $user->get_user_by_id($_SESSION['loggedIn_profile_user_id']);
        print_r($user_profile);

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
      <div class="row mb-4">
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 page_header_spacer">
              <h3>Personal Information </h3>
              
          </div>

      </div>
      <!-- end of page header //-->


      <!-- Personal Information //-->


        <!-- full name //-->
        <div class="mb-2" id="full_name">
            <div class="row" id="full_name_view">
                <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                    <strong>Full Name</strong>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
                    <?php
                        echo strtoupper("Mr. Babarinde Oluwaseyi Abiodun"); 
                    ?>
                    <span  class='ml-5'><small> 
                        <i class='far fa-edit'></i> 
                    </small></span>
                </div>
            </div>
            <div id="full_name_edit" style="display:block">
            </div>
        </div>
        <!-- end of full name //-->



        <!-- Date of Birth //-->
        <div class="mb-2" id="dob">
            <div class="row" id="dob_view">
                <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                    <strong>Date of Birth</strong>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
                    <?php
                        echo "2nd June 1980"; 
                    ?>
                    <span  class='ml-5'><small> 
                        <i class='far fa-edit'></i> 
                    </small></span>
                </div>
            </div>
            <div id="dob_edit" style="display:block">
            </div>
        </div>
        <!-- end of Date of Birth //-->




        <!-- Marital Status //-->
        <div class="mb-2" id="phone">
            <div class="row" id="phone_view">
                <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                    <strong>Marital Status</strong>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
                    <?php
                        echo "Married"; 
                    ?>
                    <span  class='ml-5'><small> 
                        <i class='far fa-edit'></i> 
                    </small></span>
                </div>
            </div>
            <div id="phone_edit" style="display:block">
            </div>
        </div>
        <!-- end of Marital Status //-->




        <!-- Phone //-->
        <div class="mb-2" id="phone">
            <div class="row" id="phone_view">
                <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                    <strong>Phone</strong>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
                    <?php
                        echo "+234-803-8875-681"; 
                    ?>
                    <span  class='ml-5'><small> 
                        <i class='far fa-edit'></i> 
                    </small></span>
                </div>
            </div>
            <div id="phone_edit" style="display:block">
            </div>
        </div>
        <!-- end of Phone //-->


        <!-- Email //-->
        <div class="mb-2" id="email">
            <div class="row" id="email_view">
                <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                    <strong>Email</strong>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
                    <?php
                        echo "babarindeos@gmail.com"; 
                    ?>
                    <span  class='ml-5'><small> 
                        <i class='far fa-edit'></i> 
                    </small></span>
                </div>
            </div>
            <div id="email_edit" style="display:block">
            </div>
        </div>
        <!-- end of Email //-->


        <!-- Address //-->
        <div id="address">
            <div class="row" id="address_view">
                <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                    <strong>Address</strong>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
                    <?php
                        echo "#14B Olorunsogo Street, Aso rock, Obantoko, Abeokuta, Ogun State."; 
                    ?>
                    <span  class='ml-5'><small> 
                        <i class='far fa-edit'></i> 
                    </small></span>
                </div>
            </div>
            <div id="address_edit" style="display:block">
            </div>
        </div>
        <!-- end of Address //-->


      <!-- end of Personal Information //-->


  </div> <!-- end of container //-->

<br/><br/><br/>
<input type='hidden' id='is_firstLogin' value="<?php echo $already_logged_in; ?>" />
<?php

    //footer.php
    require('../../includes/footer.php');
 ?>
 

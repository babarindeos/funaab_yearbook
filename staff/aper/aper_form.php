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
              <h3>Annual Personnel Evaluation Performance (APER) </h3>
              
          </div>

      </div>
      <!-- end of page header //-->


      <!-- APER Form //-->
      <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

                        <ul class="stepper" id="feedback-step">
                                <li class="step active">
                                    <div class="step-title waves-effect waves-dark">PART 1</div>
                                        <div class="step-new-content" title="Part 1 - Personal Records">
                                            <div class="row">
                                                <div class="step-content col-md-12 ">                                                        
                                                        <a href="#">1. Full name</a><br/>   
                                                        <a href="#">2. Ministry/Extra-ministerial department</a><br/>   
                                                        <a href="#">3. Personal Particulars</a><br/>
                                                        <a href="#">4. Leave Records</a><br/>
                                                </div>                                             
                                            </div>
                                            <div class="step-actions">
                                                        <a href="aper_form_part1.php" class="waves-effect waves-dark btn btn-sm btn-primary">Load form</a>
                                            </div>
                                            
                                        </div>
                                </li>
                                <li class="step">   
                                    <div class="step-title waves-effect waves-dark">PART 2</div>
                                    <div class="step-new-content">
                                        <div class="row">
                                                <div class="col-md-12 ml-auto">                                                        
                                                            <a href="#">5A. Target Setting</a><br/>   
                                                            <a href="#">5B. Target Setting for the Appraise</a><br/>   
                                                            <a href="#">5C. Achievements of Targets</a><br/>
                                                            <a href="#">6.  Job Description</a><br/>  
                                                            <a href="#">7.  Training Courses/Seminar Attended since Appointment</a><br/>                                                    
                                                            <a href="#">8.  Job Performance</a><br/> 

                                                </div>
                                                <div class="step-actions">
                                                        <a href="aper_form_part2.php" class="waves-effect waves-dark btn btn-sm btn-primary">Load form</a>
                                                </div>
                                        </div>
                                    
                                    </div>
                                </li>
                                <li class="step">
                                    <div class="step-title waves-effect waves-dark">PART 3</div>
                                    <div class="step-new-content">
                                            <div class="row">
                                                    <div class="col-md-12 ml-auto">                                                        
                                                                <a href="#">9. Assessment of Performance</a><br/>   
                                                                <a href="#">10. Aspects of Performance  </a><br/>   
                                                                <a href="#">11. Overall Assessment</a><br/>
                                                                <a href="#">12. Training Needs</a><br/>  
                                                                <a href="#">13.  General Remarks</a><br/>                                                    
                                                                <a href="#">14.  Do you suggest the Officer for</a><br/> 

                                                    </div>
                                                    <div class="step-actions">
                                                            <a href="aper_form_part2.php" class="waves-effect waves-dark btn btn-sm btn-primary">Load form</a>
                                                    </div>
                                            </div>                                            
                                    </div>
                                </li>
                        </ul>
            </div>
      </div>       

      <!-- end of APER Form //-->


  </div> <!-- end of container //-->

<br/><br/><br/>
<input type='hidden' id='is_firstLogin' value="<?php echo $already_logged_in; ?>" />
<?php

    //footer.php
    require('../../includes/footer.php');

 ?>
 
 <!-- Stepper JavaScript -->
 <script type="text/javascript" src="../../lib/js/addons-pro/stepper.js"></script>

 <!-- Stepper JavaScript - minified -->
 <script type="text/javascript" src="../../lib/js/addons-pro/stepper.min.js"></script>

 <script>
       function someFunction() {
            setTimeout(function () {
                $('#feedback-step').nextStep();
            }, 2000);
        }

        $(document).ready(function () {
            $('.stepper').mdbStepper();
        })  
 </script>
 

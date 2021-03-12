<?php

    $page_title = 'APER Form - Part 2';

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
                        <h4> Part 2</h4>
                        <ul class="stepper horizontal" id="feedback-step"  style="height:2000px;">
                                <!-- Step 1 - Personal Records //-->
                                <li class="step active">
                                    <div data-step-label="" class="step-title waves-effect waves-dark">Step 5A</div>
                                        <div class="step-new-content" >
                                            <div class="row" >
                                                <div class="step-content col-md-12" >                                                        
                                                        <?php
                                                            require("aper_form_part2_step5a.php");

                                                        ?>
                                                </div>                                             
                                            </div>
                                            
                                            
                                        </div>
                                </li>
                                <!-- Step 1 - end of Personal Records //-->


                                <!-- Step 2 - Ministry/Extra-ministerial department //-->
                                <li class="step">   
                                    <div class="step-title waves-effect waves-dark">Step 5B</div>
                                    <div class="step-new-content">
                                        <div class="row">
                                                <div class="col-md-12 ml-auto">                                                        
                                                        <?php
                                                            require("aper_form_part2_step5b.php");
                                                        ?>
                                                </div>
                                                
                                        </div>
                                    
                                    </div>
                                </li>
                                <!-- Step 2 - end of Ministry/Extra-ministerial department //-->



                                <!-- Step 3A - Personal Particulars //-->
                                <li class="step">
                                    <div class="step-title waves-effect waves-dark">Step 5C</div>
                                    <div class="step-new-content">
                                        <div class="row">
                                                <div class="col-md-12 ml-auto">                                                        
                                                        <?php
                                                            require("aper_form_part2_step5c.php");
                                                        ?>
                                                </div>                                                
                                        </div>
                                    
                                    </div>
                                </li>
                                <!-- Step 3A - end of Personal Particulars //-->



                                <li class="step">
                                    <div class="step-title waves-effect waves-dark">Step 6</div>
                                    <div class="step-new-content">
                                        <div class="row">
                                                <div class="col-md-12 ml-auto">                                                        
                                                        <?php
                                                            require("aper_form_part2_step6.php");
                                                        ?>
                                                </div>                                                
                                        </div>
                                    
                                    </div>
                                </li>



                                <li class="step">
                                    <div class="step-title waves-effect waves-dark">Step 7</div>
                                    <div class="step-new-content">
                                        <div class="row">
                                                <div class="col-md-12 ml-auto">                                                        
                                                        <?php
                                                            require("aper_form_part2_step7.php");
                                                        ?>
                                                </div>                                                
                                        </div>
                                    
                                    </div>
                                </li>


                                <li class="step">
                                    <div class="step-title waves-effect waves-dark">Step 8</div>
                                    <div class="step-new-content">
                                        <div class="row">
                                                <div class="col-md-12 ml-auto">                                                        
                                                        <?php
                                                            require("aper_form_part2_step8.php");
                                                        ?>
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
 

<script>
    $(document).ready(function () {
        $('#tblQualification').DataTable();
        $('#tblMedicalLeave').DataTable();
        $('#tblMaternityLeave').DataTable();
        $('#tblAnnualCasualLeave').DataTable();

        
        $('.dataTables_length').addClass('bs-select');
    });

</script>
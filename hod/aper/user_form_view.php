<?php
    if (!isset($_GET['q']) || $_GET['q']==''){
        header("location:users.php");
    }else{
        $URL_user_id = explode("-",htmlspecialchars(strip_tags($_GET['q'])) );
        $URL_user_id = $URL_user_id[1];
    }

    $page_title = 'User';



    //require_once("cell_config.php");
    require_once("../../config/step2/init_wp.php");
    require_once("../../nav/hod_nav.php");

    $user = new StaffUser();
    $get_user = $user->get_user_by_id($URL_user_id);

    //get User information
    $user_id = '';
    $title = '';
    $first_name = '';
    $last_name = '';
    $other_names = '';
    $position = '';
    $avatar = '';
    $email = '';
    $role = '';
    $user_category = '';
    $dob = '';
    $designation = '';
    $grade_level = '';
    $phone = '';
    $about = '';
    $date_created = '';
    $date_modified = '';

      // Retrieve and assign data to variable
  foreach($get_user as $row){
      $user_id = $row['id'];
      $title = $row['title'];
      $first_name =$row['first_name'];
      $last_name = $row['last_name'];
      $other_names = $row['other_names'];
      $position = $row['position'];
      $avatar = $row['avatar'];
      $email = $row['email'];
      $role = $row['role'];
      $user_category = $row['user_category'];
      $dob = $row['dob'];
      $designation = $row['designation'];
      $grade_level = $row['grade_level'];
      $phone = $row['phone'];
      $about = $row['about'];
      $date_created = new DateTime($row['date_created']);
      $date_created = $date_created->format('l jS F, Y');
      $date_modified = new DateTime($row['date_modified']);
      $date_modified = $date_modified->format('l jS F, Y');
    }
      // end of retrieval


 ?>


    <!-- Cells body //-->
    <div class="container">
        <!-- Page header //-->
        <div class="row">
            
            <div class="col-xs-10 col-sm-10 col-md-11 col-lg-11 page_header_spacer">
                <h3>APER Form Submission  </h3>
            </div>

        </div>
        <!-- end of page header //-->


        <div class="row">
            
            <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10 py-3 ">
                        <img src="../../images/avatars/avatar-2.jpg" alt="my avatar"
                            class="img-fluid z-depth-1-half rounded-circle" width="70">
                            &nbsp;&nbsp;<?php echo '<span style="font-size:20px;" >'.$title.' '.$first_name.' '.$last_name.' '.$other_names.'</span>' ?>
            </div>
            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 py-3">
                <button class="btn btn-primary btn-md btn-rounded">Grading</button>
            </div>
        </div>


        <!-- main page area //-->
        <!-- APER Form //-->
      <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

                    <!-- Panel Part 1 //-->
                    <div class="card">
                        <div class="card-header">
                            PART 1
                        </div>
                        <div class="card-body">

                            <!--Accordion wrapper-->
                                    <div class="accordion md-accordion" id="accordionEx1" role="tablist" aria-multiselectable="true">

                                            <!-- Accordion card -->
                                            <div class="card">

                                                <!-- Card header -->
                                                <div class="card-header" role="tab" id="headingTwo1">
                                                    <a class="collapsed" data-toggle="collapse" data-parent="#accordionEx1" href="#collapseTwo1"
                                                        aria-expanded="false" aria-controls="collapseTwo1">
                                                        <h5 class="mb-0">
                                                        1. Fullname<i class="fas fa-angle-down rotate-icon"></i>
                                                        </h5>
                                                    </a>
                                                </div>
                                                <!-- end of Card header //-->

                                                <!-- Card body -->
                                                <div id="collapseTwo1" class="collapse" role="tabpanel" aria-labelledby="headingTwo1"
                                                data-parent="#accordionEx1">
                                                    <div class="card-body">
                                                        <!-- full name //-->
                                                    </div>
                                                </div>
                                                <!-- end of Card body //-->

                                            </div>
                                            <!-- Accordion card -->

                                            <!-- Accordion card -->
                                            <div class="card">

                                                <!-- Card header -->
                                                <div class="card-header" role="tab" id="headingTwo2">
                                                <a class="collapsed" data-toggle="collapse" data-parent="#accordionEx1" href="#collapseTwo21"
                                                    aria-expanded="false" aria-controls="collapseTwo21">
                                                    <h5 class="mb-0">
                                                    2. Ministry / Extra-ministerial department <i class="fas fa-angle-down rotate-icon"></i>
                                                    </h5>
                                                </a>
                                                </div>

                                                <!-- Card body -->
                                                <div id="collapseTwo21" class="collapse" role="tabpanel" aria-labelledby="headingTwo21"
                                                data-parent="#accordionEx1">
                                                    <div class="card-body">
                                                        <!-- Ministry //-->
                                                    </div>
                                                </div>
                                                <!-- end of Card body //-->

                                            </div>
                                            <!-- Accordion card -->

                                            <!-- Accordion card -->
                                            <div class="card">

                                                <!-- Card header -->
                                                <div class="card-header" role="tab" id="headingThree31">
                                                    <a class="collapsed" data-toggle="collapse" data-parent="#accordionEx1" href="#personal_particulars"
                                                        aria-expanded="false" aria-controls="collapseThree31">
                                                        <h5 class="mb-0">
                                                        3. Personal Particulars <i class="fas fa-angle-down rotate-icon"></i>
                                                        </h5>
                                                    </a>
                                                </div>
                                                <!-- end of Card header //-->

                                                <!-- Card body -->
                                                <div id="personal_particulars" class="collapse" role="tabpanel" aria-labelledby="headingThree31"
                                                data-parent="#accordionEx1">
                                                    <div class="card-body">
                                                        <!-- Personal particulars //-->
                                                    </div>
                                                </div>
                                                <!-- end of Card body //-->

                                            </div>
                                            <!-- Accordion card -->


                                            <!-- Accordion card -->
                                            <div class="card">

                                                <!-- Card header -->
                                                <div class="card-header" role="tab" id="headingThree31">
                                                    <a class="collapsed" data-toggle="collapse" data-parent="#accordionEx1" href="#leave_records"
                                                        aria-expanded="false" aria-controls="collapseThree31">
                                                        <h5 class="mb-0">
                                                        4. Leave Records  <i class="fas fa-angle-down rotate-icon"></i>
                                                        </h5>
                                                    </a>
                                                </div>
                                                <!-- end of Card header //-->

                                                <!-- Card body -->
                                                <div id="leave_records" class="collapse" role="tabpanel" aria-labelledby="headingThree31"
                                                data-parent="#accordionEx1">
                                                    <div class="card-body">
                                                        <!-- Leave particulars //-->
                                                    </div>
                                                </div>
                                                <!-- end of Card body //-->

                                            </div>
                                            <!-- Accordion card -->

                            </div>
                            <!-- Accordion wrapper -->        



                                
                            
                        </div>
                    </div>
                    <!-- end of Panel Part 1 //-->
                        
            </div><!-- end of column //-->
      </div> <!-- end of row //-->      


      <!--- Part II //-->
      <div class="row mt-1">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

                    <!-- Panel Part 1 //-->
                    <div class="card">
                        <div class="card-header">
                            PART 2
                        </div>
                        <div class="card-body">

                            <!--Accordion wrapper-->
                                    <div class="accordion md-accordion" id="accordionEx1" role="tablist" aria-multiselectable="true">

                                            <!-- Accordion card -->
                                            <div class="card">

                                                <!-- Card header -->
                                                <div class="card-header" role="tab" id="headingTwo1">
                                                    <a class="collapsed" data-toggle="collapse" data-parent="#accordionEx1" href="#collapseTwo122"
                                                        aria-expanded="false" aria-controls="collapseTwo1">
                                                        <h5 class="mb-0">
                                                         5A. Target Setting <i class="fas fa-angle-down rotate-icon"></i>
                                                        </h5>
                                                    </a>
                                                </div>
                                                <!-- end of Card header //-->

                                                <!-- Card body -->
                                                <div id="collapseTwo122" class="collapse" role="tabpanel" aria-labelledby="headingTwo1"
                                                data-parent="#accordionEx1">
                                                    <div class="card-body">
                                                        <!-- full name //-->
                                                    </div>
                                                </div>
                                                <!-- end of Card body //-->

                                            </div>
                                            <!-- Accordion card -->

                                            <!-- Accordion card -->
                                            <div class="card">

                                                <!-- Card header -->
                                                <div class="card-header" role="tab" id="headingTwo2">
                                                <a class="collapsed" data-toggle="collapse" data-parent="#accordionEx1" href="#target_setting_appraise"
                                                    aria-expanded="false" aria-controls="collapseTwo21">
                                                    <h5 class="mb-0">
                                                     5B. Target Setting for the Appraise <i class="fas fa-angle-down rotate-icon"></i>
                                                    </h5>
                                                </a>
                                                </div>

                                                <!-- Card body -->
                                                <div id="target_setting_appraise" class="collapse" role="tabpanel" aria-labelledby="headingTwo21"
                                                data-parent="#accordionEx1">
                                                    <div class="card-body">
                                                        <!-- Ministry //-->
                                                    </div>
                                                </div>
                                                <!-- end of Card body //-->

                                            </div>
                                            <!-- Accordion card -->

                                            <!-- Accordion card -->
                                            <div class="card">

                                                <!-- Card header -->
                                                <div class="card-header" role="tab" id="headingThree31">
                                                    <a class="collapsed" data-toggle="collapse" data-parent="#accordionEx1" href="#achievements_of_targets"
                                                        aria-expanded="false" aria-controls="collapseThree31">
                                                        <h5 class="mb-0">
                                                        5C. Achievements of Targets <i class="fas fa-angle-down rotate-icon"></i>
                                                        </h5>
                                                    </a>
                                                </div>
                                                <!-- end of Card header //-->

                                                <!-- Card body -->
                                                <div id="achievements_of_targets" class="collapse" role="tabpanel" aria-labelledby="headingThree31"
                                                data-parent="#accordionEx1">
                                                    <div class="card-body">
                                                        <!-- Personal particulars //-->
                                                    </div>
                                                </div>
                                                <!-- end of Card body //-->

                                            </div>
                                            <!-- Accordion card -->


                                            <!-- Accordion card -->
                                            <div class="card">

                                                <!-- Card header -->
                                                <div class="card-header" role="tab" id="headingThree31">
                                                    <a class="collapsed" data-toggle="collapse" data-parent="#accordionEx1" href="#job_description"
                                                        aria-expanded="false" aria-controls="collapseThree31">
                                                        <h5 class="mb-0">
                                                        6. Job Description  <i class="fas fa-angle-down rotate-icon"></i>
                                                        </h5>
                                                    </a>
                                                </div>
                                                <!-- end of Card header //-->

                                                <!-- Card body -->
                                                <div id="job_description" class="collapse" role="tabpanel" aria-labelledby="headingThree31"
                                                data-parent="#accordionEx1">
                                                    <div class="card-body">
                                                        <!-- Job Description //-->
                                                    </div>
                                                </div>
                                                <!-- end of Card body //-->

                                            </div>
                                            <!-- Accordion card -->



                                            <!-- Accordion card -->
                                            <div class="card">

                                                <!-- Card header -->
                                                <div class="card-header" role="tab" id="headingThree31">
                                                    <a class="collapsed" data-toggle="collapse" data-parent="#accordionEx1" href="#training_courses"
                                                        aria-expanded="false" aria-controls="collapseThree31">
                                                        <h5 class="mb-0">
                                                        7.  Training Courses/Seminar Attended since Appointment  <i class="fas fa-angle-down rotate-icon"></i>
                                                        </h5>
                                                    </a>
                                                </div>
                                                <!-- end of Card header //-->

                                                <!-- Card body -->
                                                <div id="training_courses" class="collapse" role="tabpanel" aria-labelledby="headingThree31"
                                                data-parent="#accordionEx1">
                                                    <div class="card-body">
                                                        <!-- Job Description //-->
                                                    </div>
                                                </div>
                                                <!-- end of Card body //-->

                                            </div>
                                            <!-- Accordion card -->





                                            <!-- Accordion card -->
                                            <div class="card">

                                                <!-- Card header -->
                                                <div class="card-header" role="tab" id="headingThree31">
                                                    <a class="collapsed" data-toggle="collapse" data-parent="#accordionEx1" href="#job_performance"
                                                        aria-expanded="false" aria-controls="collapseThree31">
                                                        <h5 class="mb-0">
                                                         8.  Job Performance  <i class="fas fa-angle-down rotate-icon"></i>
                                                        </h5>
                                                    </a>
                                                </div>
                                                <!-- end of Card header //-->

                                                <!-- Card body -->
                                                <div id="job_performance" class="collapse" role="tabpanel" aria-labelledby="headingThree31"
                                                data-parent="#accordionEx1">
                                                    <div class="card-body">
                                                        <!-- Job Description //-->
                                                    </div>
                                                </div>
                                                <!-- end of Card body //-->

                                            </div>
                                            <!-- Accordion card -->


                            </div>
                            <!-- Accordion wrapper -->        



                                
                            
                        </div>
                    </div>
                    <!-- end of Panel Part 1 //-->
                        
            </div><!-- end of column //-->
      </div> <!-- end of row //-->   



      <!-- end of Part II //-->

      <!-- end of APER Form //-->        
      <!-- end of main page area //-->







    </div><!-- end of container //-->
    <!-- end of Cells body //-->






    <br/><br/><br/><br/>
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
 

     <script src="../../lib/js/custom/search_tbl.js"></script>

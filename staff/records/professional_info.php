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
              <h3>Professional Information </h3>
              
          </div>

      </div>
      <!-- end of page header //-->


      <!-- Professional Information //-->


        <!-- Qualifications, Institution , year //-->
        <div class="mb-5" id="professional_record" style="display:none;">
            <div class="row" id="new_record">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mb-2">
                    <label for="qualification"><strong>Qualification</strong></label>
                    <input type="text" class="form-control col-md-10 col-lg-10" required />
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mb-2">
                    <label for="qualification"><strong>Institution</strong></label>
                    <input type="text" class="form-control col-md-10 col-lg-10" required />
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                    <label for="qualification"><strong>Year</strong></label>
                    <input type="text" class="form-control col-md-10 col-lg-10" required />
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <button type="button" class="btn btn-sm btn-rounded btn-success" >Save</button>
                    <button id="btn_close" type="button" class="btn btn-sm btn-rounded btn-danger" >Close</button>
                </div>
            </div>   
        </div>
        <!-- end of Qualifications, Institution, year //-->
        

        <div class="row" id="row_add_qualification" >
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-left">
                <button id="btn_add_qualification" type="button" class="btn btn-sm btn-rounded btn-primary" title="Add qualification"> <i class='fas fas-plus'></i> Add Qualification</button>
            </div>
        </div>

        <!-- Table of Qualifications, Institution, year //-->
        <div class="row mb-2" id="tbl_qualification">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <table id="tblData" class="table table-responsive table-striped table-bordered table-sm" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                            <th class="th-sm">SN

                            </th>
                            <th class="th-sm">Qualification

                            </th>
                            <th class="th-sm">Institution

                            </th>
                            <th class="th-sm">Year

                            </th>
                            <th class="th-sm">Action

                            </th>

                            </tr>
                        </thead>
                        <tbody id='tblBody'>
                        </tbody>
                    </table>  
            </div>
            
        </div>
        <!-- end of Table of Qualifications, Institutions, year //-->




      <!-- end of Professional Information //-->


  </div> <!-- end of container //-->

<br/><br/><br/>
<input type='hidden' id='is_firstLogin' value="<?php echo $already_logged_in; ?>" />
<?php

    //footer.php
    require('../../includes/footer.php');
 ?>
 
 <script src="../../lib/js/custom/tblData.js"></script>
 <script>
    $(document).ready(function(){

        // Add Qualification Button
        $("#btn_add_qualification").bind("click", function(){
            $("#professional_record").slideDown(1000);
            $(this).hide();
        });
        // end of Add Qualification Button


        // Button close
        $("#btn_close").bind("click", function(){
            $("#professional_record").slideUp(500);
            $("#btn_add_qualification").show();
        });

        // end of Button close

    });
 </script>
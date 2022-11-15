<?php

    $page_title = 'Student Registration';

    require_once("../../config/step2/init_wp.php");
    require_once("../../nav/admin_nav.php");
    //require_once("../includes/staff_header.php");


    if (!isset($_GET['matric']) || $_GET['matric']=='' ){
        header("location: ../admin_dashboard.php");
    }

    if (!isset($_GET['session']) || $_GET['session']==''){
        header("location: ../admin_dashboard.php");
    }


    $applicant = new Applicant();
    $get_applicant = $applicant->getApplicant($_GET['matric']);

    $get_applicant_info = $get_applicant->fetch(PDO::FETCH_ASSOC);

    $matric_no = $get_applicant_info['regNumber'];
    $surname = $get_applicant_info['surname'];
    $firstname = $get_applicant_info['firstname'];
    $othername = $get_applicant_info['othername'];
    $email = $get_applicant_info['email'];
    $emailFunaab = $get_applicant_info['emailFunaab'];
    $phone = $get_applicant_info['phone'];
    $collegeCode = $get_applicant_info['collegeCode'];
    $deptCode = $get_applicant_info['deptCode'];
    $level = $get_applicant_info['level'];
    $user_photo = $get_applicant_info['photo'];

    $user_photo = substr($user_photo,1);
    $user_photo = "https://portal.unaab.edu.ng{$user_photo}";


    $yearbook = new YearBook();
    $get_yearbook = $yearbook->checkforStudentData($matric_no);

    $get_yearbook_data = $get_yearbook->fetch(PDO::FETCH_ASSOC);
    $dob = $get_yearbook_data['dob'];
    $email_yearbook = $get_yearbook_data['email'];
    $phone_yearbook = $get_yearbook_data['phone'];
    $address = $get_yearbook_data['address'];
    $photo = $get_yearbook_data['photo'];
    $photo = '../../student/passports/'.$photo;




  ?>


  <!-- Dashboard body //-->
  <div class="container">

      <!-- Page header //-->
      <div class="row mb-4">
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 page_header_spacer">
              <h3>Student Profile </h3>

          </div>

      </div>
      <!-- end of page header //-->






      <!-- Payment table //-->
      <div class="row">

        <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8 mt-4">
                    <table class="table table-striped border">

                              <tbody>
                                <tr><td colspan='2'><h5><strong>YearBook Information</strong></h5></td></tr>
                                <tr><td width='20%' style='font-weight:bold'>Date of Birth</td><td><?php echo $dob; ?></td></tr>
                                <tr><td width='20%' style='font-weight:bold'>Email</td><td><?php echo $email_yearbook ; ?></td></tr>
                                <tr><td width='20%' style='font-weight:bold'>Phone</td><td><?php echo $phone_yearbook ; ?></td></tr>
                                <tr><td width='20%' style='font-weight:bold'>Address</td><td><?php echo $address ; ?></td></tr>

                                <tr><td colspan='2'><h5><strong>Portal Information</strong></h5></td></tr>
                                <tr><td width='20%' style='font-weight:bold;'>Matric No.</td><td><?php echo $matric_no; ?></td></tr>
                                <tr><td width='20%' style='font-weight:bold;'>Surname</td><td><?php echo $surname; ?></td></tr>
                                <tr><td width='20%' style='font-weight:bold'>Firstname</td><td><?php echo $firstname; ?></td></tr>
                                <tr><td width='20%' style='font-weight:bold'>Othername</td><td><?php echo $othername; ?></td></tr>
                                <tr><td width='20%' style='font-weight:bold'>Email</td><td><?php echo $email; ?></td></tr>
                                <tr><td width='20%' style='font-weight:bold'>FUNAAB Email</td><td><?php echo $emailFunaab; ?></td></tr>
                                <tr><td width='20%' style='font-weight:bold'>Phone</td><td><?php echo $phone; ?></td></tr>
                                <tr><td width='20%' style='font-weight:bold'>College Code</td><td><?php echo $collegeCode; ?></td></tr>
                                <tr><td width='20%' style='font-weight:bold'>Dept Code</td><td><?php echo $deptCode; ?></td></tr>
                                <tr><td width='20%' style='font-weight:bold'>Level</td><td><?php echo $level; ?></td></tr>

                              </tbody>
                    </table>

        </div>
        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 mt-4 text-center" style='background-color:#f9f9f9'>
                <?php
                      echo "<div class='mt-1'>YearBook Photo</div><div class='avatar mx-auto white mt-1'><img src='{$photo}' alt='{$surname} photo' class='rounded img-fluid border'></div> ";
                      echo "<div class='mt-4'>Portal Photo</div><div class='avatar mx-auto white mt-1'><img src='{$user_photo}' alt='{$surname} photo' class='rounded img-fluid border'></div> ";



                ?>

        </div><!-- end of column //-->
    </div><!-- end of row //-->
    <!-- end of payment table //-->


  </div> <!-- end of container //-->

<br/><br/><br/>
<input type='hidden' id='is_firstLogin' value="<?php echo $already_logged_in; ?>" />
<?php

    //footer.php
    require('../../includes/footer.php');
 ?>
<script src="../../lib/js/custom/tblData.js"></script>

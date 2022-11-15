<?php


    $page_title = 'HOD Access';

    require_once("../../config/step2/init_wp.php");
    require_once("../../nav/admin_nav.php");
    //require_once("../includes/staff_header.php");



    // $acada_session = new AcademicSession();
    // $get_acada_session = $acada_session->get_active_session();
    // $get_current_active_session = $get_acada_session->fetch(PDO::FETCH_ASSOC);
    //
    //
    // $get_current_active_session =  $get_current_active_session['session'];

    $get_active_session =  AcademicSession::active_session();


  ?>


  <!-- Dashboard body //-->
  <div class="container">

      <!-- Page header //-->
      <div class="row mb-4">
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 page_header_spacer">
              <h3>Heads of Departments (HODs) Access </h3>

          </div>

      </div>
      <!-- end of page header //-->

      <!-- Register Dean Access //-->
      <div class="row">
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right">
                <a href='register_hod_access.php' class='btn btn-sm btn-rounded btn-success'><i class="fas fa-user-plus"></i> &nbsp;Register HOD Access</a>
          </div>
      </div>
      <!-- End of Register Dean Access //-->



      <!-- Payment table //-->
      <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                  <?php
                      $yearbook = new YearBook();
                      $get_registered_hod = $yearbook->get_hod_access($get_active_session);
                      //echo "<h4>Records Found: {$records_found}</h4>";

                  ?>

        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

                  <table id='tblData' class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th class="th-sm" >SN</th>
                                <th class="th-sm" >File No.</th>
                                <th class="th-sm" >Fullname</th>
                                <th class="th-sm" >Email</th>
                                <th class="th-sm" >Phone</th>
                                <th class="th-sm" >Date Created</th>

                            </tr>
                        </thead>
                        <tbody id="tblBody">
                            <?php
                                $count = 0;
                                while($row = $get_registered_dean->fetch(PDO::FETCH_ASSOC)){
                                    $count++;
                                    $file_no = $row['file_no'];
                                    $fullname = $row['fullname'];
                                    $email = $row['email'];
                                    $phone = $row['phone'];
                                    $date_created = new DateTime($row['date_created']);
                                    $date_created = $date_created->format('M. jS F, Y');



                                    //$dept_link = "<a class='text-info' href='../department/departments.php?dept_code={$dept_code}&session={$acad_session}'>{$dept_code}</a>";

                                    echo "<tr>";
                                          echo "<td class='text-center' width='5%'>{$count}.</td>";
                                          echo "<td width='10%' class='text-left'>{$file_no}</td>";
                                          echo "<td class='text-left' width='20%'>{$fullname}</td>";
                                          echo "<td class='text-left' width='20%'>{$email}</td>";
                                          echo "<td class='text-left' width='15%'>{$phone}</td>";
                                          echo "<td class='text-left' width='20%'>{$date_created}</td>";
                                    echo "</tr>";

                                }
                                // echo "<tr>";
                                //     echo "<td></td><td class='text-right' style='font-weight:bold;'>Total</td><td class='text-center' style='font-weight:bold;'>{$total_no_of_students}</td>";
                                // echo "</tr>";

                            ?>

                        </tbody>
                  </table>

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

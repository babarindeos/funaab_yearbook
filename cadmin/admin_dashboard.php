<?php
    $page_title = 'Admin Dashboard';

    $link = "../core/wp_config.php";
    $core_path = str_replace("\\","/", ((substr(realpath($link), (strpos(realpath($link),"yearbook")+5)))));

    require("../core/wp_config.php");
    require_once("../nav/admin_nav.php");


    $department = new Department();
    $get_units = $department->get_all_units();

    $acada_session = new AcademicSession();
    $get_acada_session = $acada_session->get_active_session();
    $get_current_active_session = $get_acada_session->fetch(PDO::FETCH_ASSOC);


    $get_current_active_session =  $get_current_active_session['session'];


    $yearbook = new YearBook();
    $get_current_yearbook = $yearbook->get_students($get_current_active_session);



?>
<!-- Dashboard body //-->
<div class="container-fluid">

    <!-- Page header //-->
    <div class="row mb-4">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 page_header_spacer">
            <h3>Dashboard </h3>

        </div>

    </div>
    <!-- end of page header //-->






    <!-- Payment table //-->
    <div class="row">



      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 px-3 py-3 border rounded">

                <div class='mb-3'>
                        <?php
                              echo "<h4>Records Found: ".number_format($get_current_yearbook->rowCount())."</h4>";
                        ?>
                </div>
                <div>
                    <table id='tblData' class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Photo</th>
                                <th scope="col">Names | DOB</th>
                                <th scope="col">Dept | College</th>
                                <th scope="col">Email</th>
                                <th scope="col">Phone</th>
                                <th scope="col">Address</th>
                                <th scope="col">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $counter = 1;
                                while($row = $get_current_yearbook->fetch(PDO::FETCH_ASSOC)){

                                  $acada_session = $row['session'];
                                  $photo = $row['photo'];
                                  $matric_no = $row['matric_no'];
                                  $fullname = $row['fullname'];
                                  $dob = $row['dob'];
                                  $email = $row['email2'];
                                  $phone = $row['phone2'];
                                  $address = $row['address'];
                                  $date_created_raw = new DateTime($row['date_created']);
                                  $date_created = $date_created_raw->format('l jS F, Y');
                                  $time_created = $date_created_raw->format('g:i a');


                                  $deptCode = $row['deptCode'];
                                  $collegeCode = $row['collegeCode'];

                                  $student_profile = "<a class='text-info' href='student/student_profile.php?matric={$matric_no}&session={$acada_session}'>{$fullname}</a>";
                                  $photo_link = "<img src='../student/passports/".$photo."' class='rounded-circle img-fluid' style='width:50px;height:50px;'>";

                                  $deptCode_link = "<a class='text-info' href='department/departments.php?dept_code={$deptCode}&session={$acada_session}'>{$deptCode}</a>";

                                  $collegeCode_link = "<a class='text-info' href='college/college.php?college_code={$collegeCode}&session={$acada_session}'>{$collegeCode}</a>";


                                  echo "<tr>";
                                    echo "<td>{$counter}.</td>";
                                    echo "<td class='text-center'>{$photo_link}<div class='mt-1'>{$matric_no}</div></td>";
                                    echo "<td>{$student_profile}<br/><small>{$dob}</small></td>";
                                    echo "<td width='10%'>{$deptCode_link}<br/>{$collegeCode_link}</td>";
                                    echo "<td width='15%'>{$email}</td>";
                                    echo "<td width='10%'>{$phone}</td>";
                                    echo "<td width='20%'>{$address}</td>";
                                    echo "<td width='15%'>{$date_created}<br/><small>{$time_created}</small></td>";
                                  echo "</tr>";

                                  $counter++;
                                }



                            ?>
                        </tbody>
                    </table>
                </div>


      </div><!-- end of column //-->
  </div><!-- end of row //-->
  <!-- end of payment table //-->


</div> <!-- end of container //-->

<br/><br/><br/>




<?php
    //footer.php
    require('../includes/footer.php');
 ?>
 <script src="../lib/js/custom/tblData.js"></script>

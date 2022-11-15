<?php
    $page_title = "Printer's Dashboard";

    $link = "../core/wp_config.php";
    $core_path = str_replace("\\","/", ((substr(realpath($link), (strpos(realpath($link),"yearbook")+5)))));

    require("../core/wp_config.php");
    require_once("../nav/printer_nav.php");


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


    <div class="row">
      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-4 mb-3">
        <h5 class='font-weight-normal'>Colleges in <?php echo $get_current_active_session; ?> Academic Session</h5>
      </div>
    </div><!-- end of row //-->


  <div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
              <?php
                  $yearbook = new YearBook();
                  $get_colleges = $yearbook->get_all_colleges($get_current_active_session);
                  //echo "<h4>Records Found: {$records_found}</h4>";
              ?>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

              <table id='tblData' class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th class="th-sm" >SN</th>
                            <th class="th-sm" >Colleges</th>
                            <th class="th-sm" >Students</th>


                        </tr>
                    </thead>
                    <tbody id="tblBody">
                        <?php
                            $count = 0;

                            //$acad_session = $_GET['session'];
                            $acad_session = $get_current_active_session;
                            $total_no_of_students = 0;
                            while($row = $get_colleges->fetch(PDO::FETCH_ASSOC)){
                                $count++;
                                $college_code = $row['collegeCode'];


                                $total_no_of_students += $row['collegeCount'];

                                $college_link = "<a class='text-info' href='college/college.php?college_code={$college_code}&session={$acad_session}'>{$college_code}</a>";

                                echo "<tr>";
                                      echo "<td class='text-center' width='10%'>{$count}.</td><td width='50%' class='text-center'>{$college_link}</td><td class='text-center' width='50%'>{$row['collegeCount']}</td>";
                                echo "</tr>";

                            }
                            echo "<tr>";
                                echo "<td></td><td class='text-right' style='font-weight:bold;'>Total</td><td class='text-center' style='font-weight:bold;'>{$total_no_of_students}</td>";
                            echo "</tr>";

                        ?>

                    </tbody>
              </table>

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

<?php
    $page_title = 'Admin Dashboard';

    $link = "../core/wp_config.php";
    $core_path = str_replace("\\","/", ((substr(realpath($link), (strpos(realpath($link),"siwes")+5)))));

    require("../core/wp_config.php");
    require_once("../nav/admin_nav.php");


    $department = new Department();
    $get_units = $department->get_all_units();


    $clearance = new StudentClearance();



?>
<!-- Dashboard body //-->
<div class="container">

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


                <div>
                    <table id='tblData' class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Unit</th>
                                <th scope="col">Submission</th>
                                <th scope="col">Pending</th>
                                <th scope="col">Approved</th>
                                <th scope="col">Declined</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $counter = 1;
                                while($row = $get_units->fetch(PDO::FETCH_ASSOC)){

                                  $unit_name = FieldSanitizer::outClean($row['name']);
                                  $unit_id = $row['id'];

                                  $get_submissions =number_format($clearance->get_no_of_clearance_submission_by_unit($unit_id));
                                  $get_pending = number_format($clearance->get_no_of_awaiting_clearance_in_unit($unit_id));
                                  $get_approved = number_format($clearance->get_no_of_approved_clearance_in_unit($unit_id));
                                  $get_declined = number_format($clearance->get_no_of_declined_clearance_in_unit($unit_id));

                                  $submission_link = "<a class='text-primary' href='clearance/unit_clearance.php?u=".mask($unit_id)."&t=".mask('submission')."'>{$get_submissions}</a>";
                                  $pending_link = "<a class='text-primary' href='clearance/unit_clearance.php?u=".mask($unit_id)."&t=".mask('pending')."'>{$get_pending}</a>";
                                  $approved_link = "<a class='text-primary' href='clearance/unit_clearance.php?u=".mask($unit_id)."&t=".mask('approved')."'>{$get_approved}</a>";
                                  $declined_link = "<a class='text-primary' href='clearance/unit_clearance.php?u=".mask($unit_id)."&t=".mask('declined')."'>{$get_declined}</a>";

                                  echo "<tr>";
                                    echo "<td>{$counter}.</td>";
                                    echo "<td>{$unit_name}</td>";
                                    echo "<td>{$submission_link}</td>";
                                    echo "<td>{$pending_link}</td>";
                                    echo "<td>{$approved_link}</td>";
                                    echo "<td>{$declined_link}</td>";
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

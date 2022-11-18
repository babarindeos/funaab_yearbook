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

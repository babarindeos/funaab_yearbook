<?php

    $page_title = 'Student Registration';

    require_once("../../config/step2/init_wp.php");
    require_once("../../nav/admin_nav.php");
    //require_once("../includes/staff_header.php");




  ?>


  <!-- Dashboard body //-->
  <div class="container">

      <!-- Page header //-->
      <div class="row mb-4">
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 page_header_spacer">
              <h3>Registration </h3>

          </div>

      </div>
      <!-- end of page header //-->






      <!-- Payment table //-->
      <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                  <?php
                      $registration = new Registration();
                      $get_registration = $registration->report_get_registrations();
                      $records_found = $get_registration->rowCount();

                      echo "<h4>Records Found: {$records_found}</h4>";

                  ?>

        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

                  <table id='tblData' class="table table-responsive table-striped table-bordered table-sm" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th class="th-sm" >SN</th>
                                <th class="th-sm" >User Identity</th>
                                <th class="th-sm" >Alt Contact</th>
                                <th class="th-sm" >Parent</th>
                                <th class="th-sm" >NOK</th>
                                <th class="th-sm" >Bank</th>
                                <th class="th-sm" >Date</th>
                            </tr>
                        </thead>
                        <tbody id="tblBody">
                            <?php


                                if ($get_registration->rowCount())
                                {
                                    $counter = 1;

                                    while($row=$get_registration->fetch(PDO::FETCH_ASSOC)){
                                      $fullname_matric = "<div>".$row['surname'].' '.$row['firstname'].' '.$row['othername']."</div><div>[".$row['matric_no']."]</div>";
                                      $contact = "<div><small><i class='far fa-envelope'></i></small> ".$row['alt_email']."</div><div><small><i class='fas fa-phone'></i></small> ".$row['alt_phone']."</div><div class='mt-3'><i class='fas fa-home'></i> ".$row['home_address']."</div>";
                                      $parent = "<div>".FieldSanitizer::outClean($row['parent_names'])."</div><div class='mt-3'>".$row['parent_phone_no']."</div>";
                                      $nok = "<div>".FieldSanitizer::outClean($row['next_of_kin'])."</div><div class='mt-3'>".$row['nok_phone_no']."</div>";
                                      $bank = "<div>".$row['bank_name'].": ".$row['bank_account_no']."</div><div class='mt-3'>".$row['bank_sort_code']."</div>";
                                      $date_raw = new DateTime($row['date_created']);
                                      $date = $date_raw->format('l, jS F, Y');
                                      $time = $date_raw->format('g:i a');

                                      echo "<tr>";
                                      echo "<td class='text-center'>{$counter}.</td>";
                                      echo "<td width='20%'>{$fullname_matric}</td>";
                                      echo "<td width='20%'>{$contact}</td>";
                                      echo "<td width='15%'>{$parent}</td>";
                                      echo "<td width='15%'>{$nok}</td>";
                                      echo "<td width='15%'>{$bank}</td>";
                                      echo "<td width='20%'>{$date}<br/>{$time}</td>";


                                      echo "</tr>";
                                      $counter++;
                                    } // while loop end
                                }


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

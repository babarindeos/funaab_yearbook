<?php

    $page_title = 'Student Payments';

    require_once("../../config/step2/init_wp.php");
    require_once("../../nav/admin_nav.php");
    //require_once("../includes/staff_header.php");




  ?>


  <!-- Dashboard body //-->
  <div class="container">

      <!-- Page header //-->
      <div class="row mb-4">
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 page_header_spacer">
              <h3>Payments </h3>

          </div>

      </div>
      <!-- end of page header //-->






      <!-- Payment table //-->
      <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                  <?php
                      $payment = new Payment();
                      $get_payments = $payment->report_get_payments_confirmed();
                      $records_found = $get_payments->rowCount();

                      echo "<h4>Records Found: {$records_found}</h4>";

                  ?>

        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

                  <table id='tblData' class="table table-responsive table-striped table-bordered table-sm" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th class="th-sm" >SN</th>
                                <th class="th-sm" >User Identity</th>
                                <th class="th-sm" >Contact</th>
                                <th class="th-sm" >Transaction ID</th>
                                <th class="th-sm" >Amount</th>
                                <th class="th-sm" >Date</th>
                            </tr>
                        </thead>
                        <tbody id="tblBody">
                            <?php


                                if ($get_payments->rowCount())
                                {
                                    $counter = 1;

                                    while($row=$get_payments->fetch(PDO::FETCH_ASSOC)){
                                      $fullname_matric = "<div>".$row['surname'].' '.$row['firstname'].' '.$row['othername']."</div><div>[".$row['custID']."]</div>";
                                      $contact = "<div>".$row['email']."</div></div>".$row['phone'].'</div>';
                                      $transactionID = "<div>".$row['transactionID']."</div>";
                                      $amount = "<div>N".number_format($row['amount'],2)."</div><div>N".number_format($row['commission'], 2)."</div>";
                                      $date_raw = new DateTime($row['dateCreated']);
                                      $date = $date_raw->format('l, jS F, Y');
                                      $time = $date_raw->format('g:i a');

                                      echo "<tr>";
                                      echo "<td class='text-center'>{$counter}.</td>";
                                      echo "<td width='30%'>{$fullname_matric}</td>";
                                      echo "<td width='25%'>{$contact}</td>";
                                      echo "<td>{$transactionID}</td>";
                                      echo "<td class='text-right'>{$amount}</td>";
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

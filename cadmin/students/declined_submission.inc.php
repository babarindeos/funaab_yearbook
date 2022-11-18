<table id='tblData3' class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th class="th-sm" >SN</th>
                                <th class="th-sm" > Photo</th>
                                <th class="th-sm" > Session </th>
                                <th class="th-sm" > Fullname</th>
                                <th class="th-sm" > DOB</th>
                                <th class="th-sm" > Date</th>
                                <th class="th-sm" > Action</th>


                            </tr>
                        </thead>
                        <tbody id="tblBody">
                            <?php
                                  $status = 'Declined';
                                  $counter = 1;
                                  $submission = new Submission();
                                  $get_pending_submission_by_session = $submission->get_submission_by_status_and_session($status, $currently_selected_session);


                                  while($row = $get_pending_submission_by_session->fetch(PDO::FETCH_ASSOC)){
                                       extract($row);

                                       $date_created = new DateTime($date_created);
                                       $date_created = $date_created->format('D. jS M., Y  g:i a');

                                       $photo = $photo;

                                       if ($photo!=''){
                                            $photo = "../../student/passports/{$photo}";
                                       }else{
                                            $photo = "../../student/images/user_avatar.png";
                                       }

                                       $photo = "<img  width='50' style='border-radius:50%;' src='{$photo}'>";

                                       $btn_href = "submission_form.php?id=".mask($id)."&sessionid=".mask($_GET_URL_session_id);
                                       $btn_link = "<a class='btn btn-sm btn-primary btn-rounded' href='{$btn_href}'>Open Doc</a>";

                                       echo "<tr>";
                                       echo "<td width='5%' class='text-center'>{$counter}.</td>";
                                       echo "<td class='text-center'>{$photo}</td>";
                                       echo "<td>{$session}</td>";
                                       echo "<td>{$fullname}</td>";
                                       echo "<td>{$dob}</td>";
                                       echo "<td>{$date_created}</td>";
                                       echo "<td class='text-center'>{$btn_link}</td>";
                                       echo "</tr>";
                                       $counter++;
                                  }
                            ?>

                        </tbody>
</table>

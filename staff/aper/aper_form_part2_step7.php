<div class="row border rounded">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 py-4">
        <h4>Step 7 -  Training Courses/Seminar Attended since Appointment</h4>        
    </div>

    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <!-- form //-->

            <form class="px-5">
                
                <!-- Type of Training/Seminar //-->
                <div class="form-row">
                    <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <label for="type_of_training" class="col-form-label text-lg-right">Type of Training/Seminar</label>
                            <input type="text" class="form-control" placeholder="">                                                             
                            
                    </div>
                </div>
                <!-- end of Medical Leave Type //-->

                <!-- Where the training was held //-->
                <div class="form-row">
                    <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <label for="place_of_training" class="col-form-label text-lg-right">Where the training was held</label>
                            <textarea class="form-control" placeholder=""></textarea>                                                           
                            
                    </div>
                </div>
                <!-- end of Where the training was held //-->


                <!-- Period of the Training //-->
                <div class="form-row">
                    <div class="form-group col-xs-12 col-sm-12 col-md-4 col-lg-4">
                        <label for="training_from_date" class="col-form-label"> From (Date)</label>
                        <input type="text" class="form-control" id="training_start_date" >

                    </div>

                    <div class="form-group col-xs-12 col-sm-12 col-md-4 col-lg-4">
                        <label for="training_end_date" class="col-form-label"> To (Date)</label>
                        <input type="text" class="form-control" id="training_end_date" >

                    </div>

                    <div class="form-group col-xs-12 col-sm-12 col-md-4 col-lg-4">
                        <label for="no_of_days" class="col-form-label"> No of Days</label>
                        <input type="text" class="form-control" id="no_of_days" >

                    </div>
                </div>
                <!-- end of period of training //-->

                


                
                        

                <!-- Save button //-->
                <div class="form-group row">
                        
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-10">
                            <button class="btn btn-sm btn-success btn-rounded mb-4">Save</button>
                        </div>
                </div>
                <!-- end of save button //-->

            </form>
            <!-- end of form //-->
    </div>


</div><!-- end of row //-->



<div class="row mt-3">
     <!-- Table of Medical Leave //-->
     <div class="row mb-2" id="tbl_medical_leave">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <table id="tblMedicalLeave" class="table table-responsive table-striped table-bordered table-sm" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                            <th class="th-sm">SN

                            </th>
                            <th class="th-sm">Medical Leave

                            </th>
                            <th class="th-sm">From

                            </th>
                            <th class="th-sm">To

                            </th>
                            <th class="th-sm">No. of Days

                            </th>
                            <th class="th-sm">Action

                            </th>

                            </tr>
                        </thead>
                        <tbody class='tblBody_medical_leave'>
                        </tbody>
                    </table>  
            </div>
            
        </div>
        <!-- end of Table of Qualifications, Institutions, year //-->

</div><!-- end of row //-->




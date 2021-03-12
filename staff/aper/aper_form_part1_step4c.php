<div class="row border rounded">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 py-4">
        <h4>Step 4C -  Annual, Casual Leave</h4>
        
    </div>

    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <!-- form //-->

            <form>
                
                <!-- Medical Leave Type //-->
                <div class="form-group row">
                        <label for="annual_casual_leave" class="col-xs-12 col-sm-12 col-md-12 col-lg-2 col-form-label text-lg-right">Leave</label>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-10">                                
                                    <select class="browser-default custom-select custom-select-md" id="annual_casual_leave" >
                                        <option></option>
                                        <option>Annual</option>
                                        <option>Casual</option>                                       
                                    </select>                                
                        </div> 
                </div>
                <!-- end of Medical Leave Type //-->


                <!-- From Date //-->
                <div class="form-group row">
                        <label for="from_date" class="col-xs-12 col-sm-12 col-md-12 col-lg-2 col-form-label text-lg-right">From (Date)</label>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-10">                                
                                    <input type="text" class="form-control" placeholder="From what date">                               
                        </div>
                </div>
                <!-- end of From Date //-->

                <!-- To Date //-->
                <div class="form-group row">
                        <label for="to_date" class="col-xs-12 col-sm-12 col-md-12 col-lg-2 col-form-label text-lg-right">To (Date)</label>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-10">
                                    <input type="text" class="form-control" placeholder="To what date">
                        </div>
                </div>
                <!-- end of To Date //-->


                <!-- Number of days //-->
                <div class="form-group row">
                        <label for="num_of_days" class="col-xs-12 col-sm-12 col-md-12 col-lg-2 col-form-label text-lg-right">No. of Days</label>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-10">
                                    <input type="text" class="form-control" placeholder="Number of days">
                        </div>
                </div>
                <!-- end of number of days //-->       


                        

                <!-- Save button //-->
                <div class="form-group row">
                        <label for="save_step1" class="col-xs-12 col-sm-12 col-md-12 col-lg-2 col-form-label"></label>
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
     <!-- Table of Annual Casual Leave //-->
     <div class="row mb-2" id="tbl_annual_casual_leave">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <table id="tblAnnualCasualLeave" class="table table-responsive table-striped table-bordered table-sm" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                            <th class="th-sm">SN

                            </th>
                            <th class="th-sm">Leave

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
                        <tbody class='tblBodyAnnualCasualLeave'>
                        </tbody>
                    </table>  
            </div>
            
        </div>
        <!-- end of Table of Annual Casual Leave //-->

</div><!-- end of row //-->




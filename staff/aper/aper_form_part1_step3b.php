<div class="row border rounded">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 py-4">
        <h4>Step 3B -  Qualifications held (Academic, Professional or Technical)</h4>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <!-- form //-->

            <form>
                <!-- Quialification //-->
                <div class="form-group row">
                        <label for="qualification" class="col-xs-12 col-sm-12 col-md-12 col-lg-2 col-form-label text-lg-right">Qualification</label>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-10">                                
                                    <input type="text" class="form-control" id="qualification" placeholder="Qualification">                          
                        </div> 
                </div>
                <!-- end of Qualification //-->


                <!-- Qualification  Type //-->
                <div class="form-group row">
                        <label for="qualification_type" class="col-xs-12 col-sm-12 col-md-12 col-lg-2 col-form-label text-lg-right">Qualification Type</label>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-10">                                
                                    <select class="browser-default custom-select custom-select-md" id="qualification_type" >
                                        <option></option>
                                        <option>Academic</option>
                                        <option>Professional</option>
                                        <option>Technical</option>
                                    </select>                               
                        </div>
                </div>
                <!-- end of Qualification Type //-->

                <!-- Institution //-->
                <div class="form-group row">
                        <label for="institution" class="col-xs-12 col-sm-12 col-md-12 col-lg-2 col-form-label text-lg-right">Institution</label>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-10">
                                    <input type="text" class="form-control" placeholder="Institution">
                        </div>
                </div>
                <!-- end of Institution //-->


                <!-- Year //-->
                <div class="form-group row">
                        <label for="year" class="col-xs-12 col-sm-12 col-md-12 col-lg-2 col-form-label text-lg-right">Year</label>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-10">
                                    <input type="text" class="form-control" placeholder="Year">
                        </div>
                </div>
                <!-- end of Year //-->       


                        

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
     <!-- Table of Qualifications, Institution, year //-->
     <div class="row mb-2" id="tbl_qualification">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <table id="tblQualification" class="table table-responsive table-striped table-bordered table-sm" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                            <th class="th-sm">SN

                            </th>
                            <th class="th-sm">Qualification

                            </th>
                            <th class="th-sm">Institution

                            </th>
                            <th class="th-sm">Year

                            </th>
                            <th class="th-sm">Action

                            </th>

                            </tr>
                        </thead>
                        <tbody id='tblBody_Qualification'>
                        </tbody>
                    </table>  
            </div>
            
        </div>
        <!-- end of Table of Qualifications, Institutions, year //-->

</div><!-- end of row //-->




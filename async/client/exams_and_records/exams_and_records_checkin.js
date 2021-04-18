$(document).ready(function(){

//------------------------ Btn Exams and Records Checkin -------------------------
    $("#btn_exams_and_records_checkin").bind("click", function(){
          //check that all three receipts have been uploaded
          var matric_no = $("#matric_no").val();

          //-----------------------  Ajax --------------------------------------
            $.ajax({
                url: '../async/server/exams_and_records/verify_user_receipts_upload.php?matric_no='+matric_no,
                dataType: 'json',
                contentType: false,
                cache: false,
                beforeSend: function(){},
                success: function(data){
                  if (data.status=='success'){

                      // check in user for clearance
                      var division_id = 9;
                      var unit_id = 48;
                      checkInUserClearance(division_id, unit_id, matric_no)

                  }else{
                      var response = "<div class='alert alert-danger mt-2' role='alert'>" + data.msg +"</div>";
                      $("#exams_and_records_checkin_feedback").html(response);
                  }



                }
            });

          //----------------------- End of Ajax --------------------------------
    });



//------------------------ End of Exams and Records Checkin ---------------------

});



// ------------------   function  ------------------------------------------------------------------
 function checkInUserClearance(division_id, unit_id, matric_no){

   //----------------- Ajax -------------------------------------
   //------------- --------- Ajax call ------------------------------------
   $.ajax({
       url: '../async/server/clearance/checkin.php',
       method: "POST",
       data: {division_id: division_id, unit_id:unit_id, matric_no: matric_no},
       cache: false,
       beforeSend: function(){
           //$("#sports_loader").show();

       },
       success: function(data){
           //$("#my_shopping_cart_pane").html(data);
           if (data==1){
               $("#exams_and_records_loader").hide();
               $("#exams_and_records_pane").html("<div class='px-2'><h5><span class='text-info'>[Awaiting Response]</span> Your form has been submitted for clearance.<br/> Please check back for feedback. Thank you.</h5></div>");

               //change page settings
               $("#exams_and_records_header_icon").attr("class", 'far fa-clock');
               $("#btn_exams_and_records_header").attr("class", 'btn btn-sm m-0 mr-3 p-2 btn-warning');
               $("#btn_exams_and_records_header").attr("title", 'PENDING: Your clarification form has been queued for clearance. Please be patient.');
           }else{
               $("#exams_and_records_loader").hide();
               alert("An error occurred. Please try again.");
           }
       }
   })
   //------------------------ End of Ajax call ----------------------------



 } // end of function

// -------------------------------------------------------------------------------------------------

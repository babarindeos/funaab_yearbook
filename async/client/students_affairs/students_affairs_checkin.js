$(document).ready(function(){

//------------------------- Already paid for yearbook physically  -----------------------------------
  $("#btn_yearbook_paid").bind("click", function(){
      $("#submit_yearbook_proof_pane").toggle();
      $("#yearbook_pay_online_div").toggle();
  })

//----------------------- End of Already alreaedy paid for yearbook physically  ---------------------





//------------------------ Btn Students Affairs Checkin --------------------------------------------
  $("#btn_students_affairs_checkin").on("click", function(){

            // disable and hide button for further Click
            $(this).prop("disabled", true);
            $(this).hide();



            var division_id = 7;
            var unit_id = 45;
            var matric_no = $("#matric_no").val();

            checkInUserClearance(division_id, unit_id, matric_no);
  });

//------------------------ End of Btn Student Affairs Checkin --------------------------------------




// ----------------------  btnSubmit ---------------------------------------------------------------

  $("#btnSubmit").bind("click", function(){

       // disable the submit to avoid duplicate submission
       $(this).prop("disabled", true);


       var yearbook_rrr = $("#yearbook_rrr").val();
       var yearbook_uploaded_file = $("#yearbook_uploaded_file").val();
       var matric_no = $("#matric_no").val();
       var payment_description = 'yearbook';
       var unit_id = 45;

       if (yearbook_rrr!='' && yearbook_uploaded_file!=''){
            //---------------------   Ajax module //-------------------------------------
             $.ajax({
                url: '../async/server/students_affairs/save_file_info.php',
                method: 'POST',
                data: {yearbook_rrr: yearbook_rrr, file:yearbook_uploaded_file, matric_no: matric_no, payment_description: payment_description, unit_id: unit_id},
                dataType: 'json',
                cache: false,
                beforeSend: function(){
                    // Hide and show some panes
                    $("#yearbook_paid_div").hide();
                    $("#submit_yearbook_proof_pane").hide();
                    $("#yearbook_pay_online_div").hide();

                    $("#students_affairs_loader").show();
                },
                success: function(data){

                    if (data.status=='success'){
                        // check in the user for clearance
                        var division_id = 7;
                        checkInUserForClearance(division_id, unit_id, matric_no);

                    }else{
                        alert("An error occurred saving your payment information.\nPlease try again or contact the Site Admin.");
                    }


                }

             });
             //-------------------- End of Ajax module ----------------------------------

       }else{
            alert("Both Remita Retrieval Reference (RRR) and a uploaded copy of receipt is required to be submitted. ");
       }




  });  // of btnSubmit

//--------------------- End of btnSubmit //---------------------------------------------------------


});  // end of document ready



// ------------------   function  ------------------------------------------------------------------
 function checkInUserForClearance(division_id, unit_id, matric_no){

   //----------------- Ajax -------------------------------------
   //------------- --------- Ajax call ------------------------------------
   $.ajax({
       url: '../async/server/clearance/checkin.php',
       method: "POST",
       data: {division_id: division_id, unit_id:unit_id, matric_no: matric_no},
       dataType: 'text',
       cache: false,
       beforeSend: function(){
           //$("#sports_loader").show();

       },
       success: function(data){
           //$("#my_shopping_cart_pane").html(data);
           $("#students_affairs_pane").html("<div class='px-2'><h5><span class='text-info'>[Awaiting Response]</span> Your form has been submitted for clearance.<br/> Please check back for feedback. Thank you.</h5></div>");
           if (data==1){

               $("#students_affairs_loader").hide();
               $("#students_affairs_pane").html("<div class='px-2'><h5><span class='text-info'>[Awaiting Response]</span> Your form has been submitted for clearance.<br/> Please check back for feedback. Thank you.</h5></div>");

               //change page settings
               $("#students_affairs_header_icon").attr("class", 'far fa-clock');
               $("#btn_students_affairs_header").attr("class", 'btn btn-sm m-0 mr-3 p-2 btn-warning');
               $("#btn_students_affairs_header").attr("title", 'PENDING: Your clarification form has been queued for clearance. Please be patient.');
           }else{
               $("#students_affairs_loader").hide();
               alert("An error occurred. Please try again.");
           }
       }
   })
   //------------------------ End of Ajax call ----------------------------



 } // end of function

// -------------------------------------------------------------------------------------------------

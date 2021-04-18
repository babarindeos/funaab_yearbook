// ----------------------  btnSubmit ---------------------------------------------------------------

  $("#alumni_btnSubmit").bind("click", function(){

       // disable the submit to avoid duplicate submission
       $(this).prop("disabled", true);


       var alumni_receipt_no = $("#alumni_receipt_no").val().trim();
       var alumni_uploaded_file = $("#alumni_uploaded_file").val().trim();
       var matric_no = $("#matric_no").val().trim();
       var payment_description = 'Alumni';
       var unit_id = 49;

       
       if (alumni_receipt_no!='' && alumni_uploaded_file!=''){
            //---------------------   Ajax module //-------------------------------------
             $.ajax({
                url: '../async/server/alumni/save_uploaded_file_info.php',
                method: 'POST',
                data: {alumni_receipt_no: alumni_receipt_no, file:alumni_uploaded_file, matric_no: matric_no, payment_description: payment_description, unit_id: unit_id},
                dataType: 'json',
                cache: false,
                beforeSend: function(){
                    // Hide and show some panes
                    $("#alumni_bank_details").hide();
                    $("#submit_alumni_proof_pane").hide();

                    $("#alumni_loader").show();
                },
                success: function(data){

                    if (data.status=='success'){
                        // check in the user for clearance
                        var division_id = 8;
                        alumni_checkInUserForClearance(division_id, unit_id, matric_no);


                    }else{
                        alert("An error occurred saving your payment information.\nPlease try again or contact the Site Admin.");
                    }


                }

             });
             //-------------------- End of Ajax module ----------------------------------

       }else{
            alert("Both Alumni Receipt No. and an uploaded copy of the receipt is required to be submitted. ");
            $("#alumni_btnSubmit").prop("disabled", false);
       }




  });  // of btnSubmit

//--------------------- End of btnSubmit //---------------------------------------------------------





//-------------------------------------------------------------------------------------------------------

// ------------------   function  ------------------------------------------------------------------
 function alumni_checkInUserForClearance(division_id, unit_id, matric_no){

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

           if (data==1){

               $("#alumni_loader").hide();
               $("#alumni_proof_pane").html("<div class='px-2'><h5><span class='text-info'>[Awaiting Response]</span> Your form has been submitted for clearance.<br/> Please check back for feedback. Thank you.</h5></div>");

               //change page settings
               $("#alumni_header_icon").attr("class", 'far fa-clock');
               $("#btn_alumni_header").attr("class", 'btn btn-sm m-0 mr-3 p-2 btn-warning');
               $("#btn_alumni_header").attr("title", 'PENDING: Your clarification form has been queued for clearance. Please be patient.');
           }else{
               $("#alumni_loader").hide();
               alert("An error occurred. Please try again.");
           }
       }
   })
   //------------------------ End of Ajax call ----------------------------



 } // end of function

// -------------------------------------------------------------------------------------------------

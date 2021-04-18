$(document).ready(function(){



  // ----------------------  btnSubmit ---------------------------------------------------------------

    $("#e-records_btnSubmit").bind("click", function(){

         // disable the submit to avoid duplicate submission
         $(this).prop("disabled", true);


         var receipt_rrr = $("#receipt_rrr").val();

         var receipt_uploaded_file = '';
         var receipt_naration = $("#e-records_receipt_upload_type").text();

         //alert(receipt_naration);

         // -------------- Decipher the uploaded file to save --------------------------------
         if (receipt_naration=='Receipt of Certificate'){
            receipt_uploaded_file = $("#e-records_certificate_receipt_uploaded_file").val().trim();
         }else if(receipt_naration=='Receipt of Statement of Result'){
            receipt_uploaded_file = $("#e-records_statement_of_result_receipt_uploaded_file").val().trim();
         }else if(receipt_naration=='Receipt of Academic Gown'){
            receipt_uploaded_file = $("#e-records_academic_gown_receipt_uploaded_file").val().trim();
         }
         //------------- Decipher the uploaded file to save ---------------------------------


         var matric_no = $("#matric_no").val();
         var payment_description = receipt_naration;
         var unit_id = 48;

         //alert(receipt_rrr);
         //alert(receipt_uploaded_file);
         //alert("Length " + receipt_uploaded_file.length);


         if (receipt_rrr!='' && receipt_uploaded_file!='' && receipt_uploaded_file.length>0){
              //---------------------   Ajax module //-------------------------------------
               $.ajax({
                  url: '../async/server/exams_and_records/save_uploaded_file_info.php',
                  method: 'POST',
                  data: {receipt_rrr: receipt_rrr, file:receipt_uploaded_file, matric_no: matric_no, payment_description: payment_description, unit_id: unit_id},
                  dataType: 'json',
                  cache: false,
                  beforeSend: function(){
                      // Hide and show some panes
                      $("#exams_and_records_loader").show();
                  },
                  success: function(data){

                      if (data.status=='success'){
                          // check in the user for clearance
                          //var division_id = 7;
                          //checkInUserClearance(division_id, unit_id, matric_no);
                          $("#exams_and_records_loader").hide();
                          $("#submit_e-records_proof_pane").hide();
                          $("#e-records_activity_notifier").html('');
                          $("#receipt_rrr").val("");
                          // Enable btnSubmit button
                          $("#e-records_btnSubmit").prop("disabled", false);



                          // Modified from the above code
                          //----------- Displayed uploaded file in Upload Area
                          $("#e-records_my_uploaded_receipts").append("<li>" + payment_description + " - " + receipt_uploaded_file + "</li>");


                          // increase uploaded file number on page
                          var uploaded_file_count = $("#no_of_uploaded_exams_and_records_receipts").text();
                          uploaded_file_count++;
                          $("#no_of_uploaded_exams_and_records_receipts").text(uploaded_file_count);

                      }else{
                          alert("An error occurred saving your payment information.\nPlease try again or contact the Site Admin.");
                          // Enable btnSubmit button
                          $("#e-records_btnSubmit").prop("disabled", false);
                      }



                  }

               });
               //-------------------- End of Ajax module ----------------------------------

         }else{
              alert("Both Remita Retrieval Reference (RRR) and a uploaded copy of receipt is required to be submitted. ");
                $("#e-records_btnSubmit").prop("disabled", false);

         }




    });  // of btnSubmit

  //--------------------- End of btnSubmit //---------------------------------------------------------


});

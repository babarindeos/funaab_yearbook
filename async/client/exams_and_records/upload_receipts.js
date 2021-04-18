 $(document).ready(function(){


//--------------------- Div Upload Certificate Receipt Link ---------------------------
  $("#upload_certificate_receipt").bind("click", function(){
        $("#e-records_receipt_upload_type").text("Receipt of Certificate");
        $("#submit_e-records_proof_pane").show();
  })

//-------------------- End of Div Upload Certificare Receipt Link ---------------------


//---------------- Div Upload of Div Upload Notification / Statement of Result ----------
$("#upload_statement_of_result_receipt").bind("click", function(){
      $("#e-records_receipt_upload_type").text("Receipt of Statement of Result");
      $("#submit_e-records_proof_pane").show();
})
//---------------- End of Div Upload Notification /Statement of Result ------------------


//---------------- Div Upload of Div Academic Gown ---------- --------------------------
$("#upload_academic_gown_receipt").bind("click", function(){
      $("#e-records_receipt_upload_type").text("Receipt of Academic Gown");
      $("#submit_e-records_proof_pane").show();
})
//---------------- End of Div Upload Academic Gown ------------------ ------------------



//----------------- File Uploader ----------------------------------------------------
$("#e-records_file_upload_type_document").bind("click",function(){
    $("#e-records_file_uploader").show();
});

$("#e-records_file_upload_type_image").bind("click",function(){
    $("#e-records_file_uploader").show();
    //alert($("#file_upload_type_document").val());
})
//----------------- End of file uploader --------------------------------------------





//---------------------------------------------------------------------------------------------------

      // file upload
      $("#e-records_file").on("change", function(){            

            var property = document.getElementById("e-records_file").files[0];
            var image_name = property.name;

            var image_extension = image_name.split('.').pop().toLowerCase();

            var radioValue = $("input[name='e-records_file_upload_type']:checked").val();
            var file_type = '';
            switch(radioValue){
                case "document":
                    file_type = radioValue;
                    if (jQuery.inArray(image_extension,['pdf'])==-1){
                          alert("Invalid document format. Please select a PDF document.");
                    }else{
                        run_file_upload(file_type, property);
                    }

                    break;

                case "image":
                    file_type = radioValue;
                    if (jQuery.inArray(image_extension,['gif','png','jpg','jpeg'])==-1){
                          alert("Invalid image format. Please select an image file in any of the specified format.");
                    }else{
                        run_file_upload(file_type, property);
                    }

                    break;
            }


      })

// -------------------------------------------------------------------------------------------



// -------------------------------------------------------------------------------------------

      // function to load files
      function run_file_upload(file_type, property){
            var image_size = property.size;
            image_size = image_size/1024;
            //alert(image_size);
            if (image_size>20000){
                alert("The file is larger than the allowed 20MB size. Please resize and try again.");
            }else{
                    var form_data = new FormData();
                    form_data.append("file", property);
                    //form_data.append("source", 'announcement');
                    //form_data.append("file_type", file_type);

                    var matric_no = $("#matric_no").val();
                    var receipt_type = $("#e-records_receipt_upload_type").text();

                    $.ajax({
                        url: '../async/server/file_upload/e-records_upload_file.php?source=exams_and_records&file_type='+file_type+'&matric_no='+matric_no+'&receipt_type='+receipt_type,
                        method: "POST",
                        data: form_data,
                        dataType:  'json',
                        contentType: false,
                        cache: false,
                        processData: false,
                        beforeSend: function(){
                            $("#e-records_file_uploader").hide();
                            $("#e_records_upload_spinner").show();
                        },
                        success: function(data){
                            //console.log("am here");
                            //console.log(data.status);
                            //alert(data);
                            $("#e_records_upload_spinner").hide();

                            //data = JSON.parse(data);
                            if (data.status=='success'){

                                var link_path ='';
                                if (file_type=='document'){
                                    var href_data = "../uploads/exams_and_records/documents/"+data.wp_filename;
                                    link_path = "<a target='_blank' href='"+ href_data +"'>" + data.wp_filename + "</a>";
                                }else{
                                    var href_data = "../uploads/exams_and_records/images/"+data.wp_filename;
                                    link_path = "<a target='_blank' href='"+ href_data +"'>" + data.wp_filename + "</a>";
                                }


                                var msgblock = "<div class='py-3' id='e-records_myuploadedfile'><i class='fas fa-paperclip'></i> " + link_path;
                                msgblock += "</div>";

                                $("#e-records_activity_notifier").html(msgblock);
                                $("#e-records_activity_notifier").show(msgblock);



                                // -----------------------------   Record uploaded filename into textboxes ---------------------
                                if (receipt_type=='Receipt of Certificate'){
                                      $("#e-records_certificate_receipt_uploaded_file").val(data.wp_filename);
                                }else if (receipt_type=='Receipt of Statement of Result'){
                                      $("#e-records_statement_of_result_receipt_uploaded_file").val(data.wp_filename);
                                }else if(receipt_type=='Receipt of Academic Gown'){
                                      $("#e-records_academic_gown_receipt_uploaded_file").val(data.wp_filename);
                                }
                                //----------------------------- End of recording filename into textboxes ------------------------

                            }

                        }
                    });
            } // end of if
      }
// -------------------------------------------------------------------------------------------









}); // end of document ready

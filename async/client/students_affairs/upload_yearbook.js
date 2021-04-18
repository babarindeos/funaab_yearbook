$(document).ready(function(){

      $("#file_upload_type_document").bind("click",function(){
          $("#file_uploader").show();
      });

      $("#file_upload_type_image").bind("click",function(){
          $("#file_uploader").show();
          //alert($("#file_upload_type_document").val());
      })

//---------------------------------------------------------------------------------------------------

      // file upload
      $("#file").on("change", function(){
            var property = document.getElementById("file").files[0];
            var image_name = property.name;

            var image_extension = image_name.split('.').pop().toLowerCase();

            var radioValue = $("input[name='file_upload_type']:checked").val();
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

                    $.ajax({
                        url: '../async/server/file_upload/yearbook_upload_file.php?source=students_affairs&file_type='+file_type+'&matric_no='+matric_no,
                        method: "POST",
                        data: form_data,
                        dataType:  'json',
                        contentType: false,
                        cache: false,
                        processData: false,
                        beforeSend: function(){
                            $("#file_uploader").hide();
                            $("#spinner").show();
                        },
                        success: function(data){
                            //console.log("am here");
                            //console.log(data.status);
                            //alert(data);
                            $("#spinner").hide();

                            //data = JSON.parse(data);
                            if (data.status=='success'){

                                var link_path ='';
                                if (file_type=='document'){
                                    var href_data = "../uploads/students_affairs/documents/"+data.wp_filename;
                                    link_path = "<a target='_blank' href='"+ href_data +"'>" + data.wp_filename + "</a>";
                                }else{
                                    var href_data = "../uploads/students_affairs/images/"+data.wp_filename;
                                    link_path = "<a target='_blank' href='"+ href_data +"'>" + data.wp_filename + "</a>";
                                }

                                var msgblock = "<div class='py-3' id='myuploadedfile'><i class='fas fa-paperclip'></i> " + link_path;
                                msgblock += "</div>";

                                $("#activity_notifier").html(msgblock);
                                $("#yearbook_uploaded_file").val(data.wp_filename);

                            }

                        }
                    });
            } // end of if
      }
// -------------------------------------------------------------------------------------------

// Remove file
    $("#activity_notifier").on("click", "span#deletefile", function(){
        //alert("Delete file");
        $.post("../../async/server/announcement/remove_uploaded_file.php",function(data){
              $("#myuploadedfile_div").remove();
        });
    });





//----------------------------------------------------------------------------------------------

});

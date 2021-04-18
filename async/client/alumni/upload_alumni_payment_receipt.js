$(document).ready(function(){

      $("#alumni_file_upload_type_document").bind("click",function(){
          $("#alumni_file_uploader").show();
      });

      $("#alumni_file_upload_type_image").bind("click",function(){
          $("#alumni_file_uploader").show();
          //alert($("#file_upload_type_document").val());
      })

//---------------------------------------------------------------------------------------------------

// file upload
$("#alumni_file").on("change", function(){
      var property = document.getElementById("alumni_file").files[0];
      var image_name = property.name;

      var image_extension = image_name.split('.').pop().toLowerCase();

      var radioValue = $("input[name='alumni_file_upload_type']:checked").val();
      var file_type = '';
      switch(radioValue){
          case "document":
              file_type = radioValue;
              if (jQuery.inArray(image_extension,['pdf'])==-1){
                    alert("Invalid document format. Please select a PDF document.");
              }else{
                  alumni_execute_file_upload(file_type, property);

              }

              break;

          case "image":
              file_type = radioValue;
              if (jQuery.inArray(image_extension,['gif','png','jpg','jpeg'])==-1){
                    alert("Invalid image format. Please select an image file in any of the specified format.");
              }else{
                  alumni_execute_file_upload(file_type, property);

              }

              break;
      }


})

// -------------------------------------------------------------------------------------------




// function to load files
function alumni_execute_file_upload(file_type, property){
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
                  url: '../async/server/file_upload/alumni_upload_file.php?source=alumni&file_type='+file_type+'&matric_no='+matric_no,
                  method: "POST",
                  data: form_data,
                  dataType:  'json',
                  contentType: false,
                  cache: false,
                  processData: false,
                  beforeSend: function(){
                      $("#alumni_file_uploader").hide();
                      $("#alumni_spinner").show();
                  },
                  success: function(data){
                      //console.log("am here");
                      //console.log(data.status);
                      //alert(data);
                      $("#alumni_spinner").hide();

                      //data = JSON.parse(data);
                      if (data.status=='success'){

                          var link_path ='';
                          if (file_type=='document'){
                              var href_data = "../uploads/alumni/documents/"+data.wp_filename;
                              link_path = "<a target='_blank' href='"+ href_data +"'>" + data.wp_filename + "</a>";
                          }else{
                              var href_data = "../uploads/alumni/images/"+data.wp_filename;
                              link_path = "<a target='_blank' href='"+ href_data +"'>" + data.wp_filename + "</a>";
                          }

                          var msgblock = "<div class='py-3' id='alumni_myuploadedfile'><i class='fas fa-paperclip'></i> " + link_path;
                          msgblock += "</div>";

                          $("#alumni_activity_notifier").html(msgblock);
                          $("#alumni_uploaded_file").val(data.wp_filename);

                      }

                  }
              });
      } // end of if
}
// -------------------------------------------------------------------------------------------



}); // end of document ready

$(document).ready(function(){

  //--------------------------------- Department /Programme //------------------------
      $("#btn_health_center_checkin").on("click",function(){

          // disable and hide button for further Click
          $(this).prop("disabled", true);
          $(this).hide();



          var division_id = 3;
          var unit_id = 41;
          var matric_no = $("#matric_no").val();




          //----------------- Ajax -------------------------------------
          //------------- --------- Ajax call ------------------------------------
          $.ajax({
              url: '../async/server/clearance/checkin.php',
              method: "POST",
              data: {division_id: division_id, unit_id:unit_id, matric_no: matric_no},
              cache: false,
              beforeSend: function(){
                  $("#health_center_loader").show();

              },
              success: function(data){
                  //$("#my_shopping_cart_pane").html(data);
                  if (data==1){
                      $("#health_center_loader").hide();
                      $("#health_center_pane").html("<div class='px-2'><h5><span class='text-info'>[Awaiting Response]</span> Your form has been submitted for clearance.<br/> Please check back for feedback. Thank you.</h5></div>");

                      //change page settings
                      $("#health_center_header_icon").attr("class", 'far fa-clock');
                      $("#btn_health_center_header").attr("class", 'btn btn-sm m-0 mr-3 p-2 btn-warning');
                      $("#btn_health_center_header").attr("title", 'PENDING: Your clarification form has been queued for clearance. Please be patient.');
                  }else{
                      $("#health_center_loader").hide();
                      alert("An error occurred. Please try again.");
                  }
              }
          })
          //------------------------ End of Ajax call ----------------------------
          //----------------- End of Ajax -----------------------------
      });
  //---------------------------------- End of Department Programme ------------------------
});

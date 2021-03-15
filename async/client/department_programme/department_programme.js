$(document).ready(function(){

  //--------------------------------- Department /Programme //------------------------
      $("#btn_department_programme").on("click",function(){

          // disable and hide button for further Click
          $(this).prop("disable", true);
          $(this).hide();



          var division_id = 1;
          var unit_id = 15;
          var matric_no = $("#matric_no").val();




          //----------------- Ajax -------------------------------------
          //------------- --------- Ajax call ------------------------------------
          $.ajax({
              url: '../async/server/clearance/checkin.php',
              method: "POST",
              data: {division_id: division_id, unit_id:unit_id, matric_no: matric_no},
              cache: false,
              beforeSend: function(){
                  $("#department_programme_loader").show();

              },
              success: function(data){
                  //$("#my_shopping_cart_pane").html(data);
                  if (data==1){
                      $("#department_programme_loader").hide();
                      $("#department_programme_pane").html("<div class='px-2'><h5><span class='text-info'>[Awaiting Response]</span> Your form has been submitted for clearance.<br/> Please check back for feedback. Thank you.</h5></div>");

                      //change page settings
                      $("#dept_header_icon").attr("class", 'far fa-clock');
                      $("#btn_dept_header").attr("class", 'btn btn-sm m-0 mr-3 p-2 btn-warning');
                      $("#btn_dept_header").attr("title", 'PENDING: Your clarification form has been queued for clearance. Please be patient.');
                  }else{
                      $("#department_programme_loader").hide();
                      alert("An error occurred. Please try again.");
                  }
              }
          })
          //------------------------ End of Ajax call ----------------------------
          //----------------- End of Ajax -----------------------------
      });
  //---------------------------------- End of Department Programme ------------------------
});

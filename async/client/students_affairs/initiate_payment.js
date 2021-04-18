$(document).ready(function(){

    // Initiate payment
    $("#yearbook_initiate_payment").bind("click", function(){

        // disable button
        $(this).prop("disabled", true);

        var matric_no = $("#matric_no").val();

        //-------------------  Ajax -------------------------------------------------
        $.ajax({
            url: '../async/server/students_affairs/prepayment.php',
            method: "POST",
            data: {matric_no: matric_no},
            dataType: 'json',
            cache: false,
            beforeSend: function(){
                //hide and show some panes
                $("#yearbook_paid_div").hide();
                $("#submit_yearbook_proof_pane").hide();
                $("#yearbook_pay_online_div").hide();
                $("#students_affairs_loader").show();

            },
            success: function(data){

              $("#students_affairs_loader").hide();
              $("#students_affairs_pane").html(data.msg);

            }


        });


        //-------------------- End of Ajax ------------------------------------------

    });





}) // end of document

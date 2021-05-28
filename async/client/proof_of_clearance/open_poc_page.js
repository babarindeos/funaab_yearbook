
function open_poc_page(){
  //var project_cell_id = $(this).attr('id');
  //var cell_id = $(this).attr('id').replace(/\D/g,'');

  var matric_no = $("#matric_no").val();
  var verification_code = $("#verification_code").val();



  var qcode = generateMask(60);
  var zcode = generateMask(60);


let params = 'scrollbars=no, resizable=yes, status=no, addressbar=no, location=no, toolbar=no, menubar=no, width=screen.width, height=screen.height, left=-1000, top=-1000';
  open('proof_of_clearance_completion.php?q='+qcode+'&m='+matric_no+'&z='+zcode+'&v='+verification_code, 'Proof of Clearance', params);
  //window.open('https://javascript.info');

};

//--------------------------------- TblSummary  Click Event -------------------------------------



function generateMask(length){
  // declare all characters
  const characters ='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
  let result = ' ';
  const charactersLength = characters.length;
    for ( let i = 0; i < length; i++ ) {
        result += characters.charAt(Math.floor(Math.random() * charactersLength));
    }
    return result;
}


//-----------------------------------End of Tbl Click Event -----------------------------------

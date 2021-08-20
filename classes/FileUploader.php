<?php

  class FileUploader implements FileUploaderInterface{

      public function __construct(){
         return "Welcome to file uploader";
      }

      public function uploadFile($file_type, $source, $file, $matric_no){

          if ($file['name'] !=''){
              $fileName = $file['name'];  // $_FILES['file']['name']
              $split_name = explode('.', $fileName);
              $extension = end($split_name);
              $today = date('Ymd_H_i_s');
              $wp_name = $matric_no.'_yearbook_receipt_'.$today.rand(100,999).'.'.$extension;

              //$location = "../../../uploads/{$source}/{$wp_name}";
              if ($file_type=='document'){
                  $location = "../../../uploads/{$source}/documents/{$wp_name}";
              }else if($file_type='image'){
                  $location = "../../../uploads/{$source}/images/{$wp_name}";
              }

              $result = move_uploaded_file($file['tmp_name'], $location);

              $response = '';
              if ($result==1){
                  $response  = array("status"=>'success', "wp_filename"=>$wp_name);
              }else{
                  $response = array("status"=>'error', "wp_filename"=>'');
              }

              return $response;

          }

      }


      public function alumni_uploadFile($file_type, $source, $file, $matric_no){

          if ($file['name'] !=''){
              $fileName = $file['name'];  // $_FILES['file']['name']
              $split_name = explode('.', $fileName);
              $extension = end($split_name);
              $today = date('Ymd_H_i_s');
              $wp_name = $matric_no.'_alumni_receipt_'.$today.rand(100,999).'.'.$extension;

              //$location = "../../../uploads/{$source}/{$wp_name}";
              if ($file_type=='document'){
                  $location = "../../../uploads/{$source}/documents/{$wp_name}";
              }else if($file_type='image'){
                  $location = "../../../uploads/{$source}/images/{$wp_name}";
              }

              $result = move_uploaded_file($file['tmp_name'], $location);

              $response = '';
              if ($result==1){
                  $response  = array("status"=>'success', "wp_filename"=>$wp_name);
              }else{
                  $response = array("status"=>'error', "wp_filename"=>'');
              }

              return $response;

          }

      }


      public function erecords_uploadFile($file_type, $source, $file, $matric_no, $receipt_naration){

              if ($file['name'] !=''){
                  $fileName = $file['name'];  // $_FILES['file']['name']
                  $split_name = explode('.', $fileName);
                  $extension = end($split_name);
                  $today = date('Ymd_H_i_s');
                  $wp_name = $matric_no.'_'.$receipt_naration.'_'.$today.rand(100,999).'.'.$extension;

                  //$location = "../../../uploads/{$source}/{$wp_name}";
                  if ($file_type=='document'){
                      $location = "../../../uploads/{$source}/documents/{$wp_name}";
                  }else if($file_type='image'){
                      $location = "../../../uploads/{$source}/images/{$wp_name}";
                  }

                  $result = move_uploaded_file($file['tmp_name'], $location);

                  $response = '';
                  if ($result==1){
                      $response  = array("status"=>'success', "wp_filename"=>$wp_name);
                  }else{
                      $response = array("status"=>'error', "wp_filename"=>'');
                  }

                  return $response;

              }
        }

        public function check_for_file_upload($matric_no, $payment_description){

            // sqlQuery
            $sqlQuery = "Select * from files where matric_no=:matric_no and payment_description=:payment_description";

            $QueryExecutor = new PDO_QueryExecutor();
            $stmt = $QueryExecutor->customQuery()->prepare($sqlQuery);

            // bind Param
            $stmt->bindParam(":matric_no", $matric_no);
            $stmt->bindParam(":payment_description", $payment_description);

            $stmt->execute();

            return $stmt;

        }

        public function retrieve_user_uploaded_files_by_unit($matric_no, $unit_id){
            //sqlQuery
            $sqlQuery = "Select * from files where matric_no=:matric_no and unit_id=:unit_id";

            $QueryExecutor = new PDO_QueryExecutor();
            $stmt = $QueryExecutor->customQuery()->prepare($sqlQuery);

            // bind Param
            $stmt->bindParam(":matric_no", $matric_no);
            $stmt->bindParam(":unit_id", $unit_id);

            $stmt->execute();

            return $stmt;

        }


        public function uploadYearBookPassport($source, $file, $matric_no){

            if ($file['name'] !=''){
                $fileName = $file['name'];  // $_FILES['file']['name']
                $split_name = explode('.', $fileName);
                $extension = end($split_name);
                $today = date('Ymd_H_i_s');
                $wp_name = $matric_no.'.'.$extension;



                $location = "../../../student/passports/{$wp_name}";


                $result = move_uploaded_file($file['tmp_name'], $location);

                $response = '';
                if ($result==1){
                    $response  = array("status"=>'success', "wp_filename"=>$wp_name);
                }else{
                    $response = array("status"=>'error', "wp_filename"=>'');
                }

                return $response;

            }

        }








  }



?>

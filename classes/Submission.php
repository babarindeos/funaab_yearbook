<?php

    class Submission{
        private $sqlQuery;
        private $stmt;
        private $QueryExecutor;

        public function __construct(){
            $this->sqlQuery = null;
            $this->stmt = null;
            $this->QueryExecutor = null;
        }

        public function get_submission_by_status_and_session($status, $session){
            $this->sqlQuery = "Select id, session, matric_no, fullname, dob_day, dob_month, dob, email, phone, address,
                               photo, hoc, status, status_msg, date_created from yearbook where status=:status and session=:session";

            // pdo object
            $this->QueryExecutor = new PDO_QueryExecutor();
            $this->stmt = $this->QueryExecutor->customQuery()->prepare($this->sqlQuery);

            $this->stmt->bindParam(":status", $status);
            $this->stmt->bindParam(":session", $session);
            $this->stmt->execute();

            return $this->stmt;
        }

        public function get_submission_by_id($id){
            $this->sqlQuery = "Select id, session, matric_no, fullname, dob_day, dob_month, dob, email, phone, address,
                               photo, hoc, status, status_msg, date_created from yearbook where id=:id";

            // pdo object
            $this->QueryExecutor = new PDO_QueryExecutor();
            $this->stmt = $this->QueryExecutor->customQuery()->prepare($this->sqlQuery);

            $this->stmt->bindParam(":id", $id);
            $this->stmt->execute();

            return $this->stmt;
        }

        public function clearance($fields){

            $date_modified = date('Y-m-d H:i:s');
            $this->sqlQuery = "Update yearbook set status=:status, status_msg=:status_msg, date_modified=:date_modified where id=:id";

            // pdo object
            $this->QueryExecutor = new PDO_QueryExecutor();
            $this->stmt = $this->QueryExecutor->customQuery()->prepare($this->sqlQuery);

            $this->stmt->bindParam(":id", $fields['id']);
            $this->stmt->bindParam(":status", $fields['status']);
            $this->stmt->bindParam(":status_msg", $fields['status_msg']);
            $this->stmt->bindParam(":date_modified", $date_modified);
            $this->stmt->execute();

            return $this->stmt;
        }

        public static function submission_count($status, $academic_session){

            $sqlQuery = "Select count(id) as recordCount from yearbook where status=:status and session=:session";

            // pdo object
            $QueryExecutor = new PDO_QueryExecutor();
            $stmt = $QueryExecutor->customQuery()->prepare($sqlQuery);

            $stmt->bindParam(":status", $status);
            $stmt->bindParam(":session", $academic_session);

            $stmt->execute();

            $response = '';

            $response = $stmt->fetch(PDO::FETCH_ASSOC);
            $response = $response['recordCount'];


            return $response;
        }

    }



?>

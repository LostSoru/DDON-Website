<?php

class Logging {

    #Log ID 0 = Will Not Be Logged.
    #Log ID 1 = Invalid Page Name Used.
    #Log ID 2 = Page Does Not Exist.
    #Log ID 3 = You Must Be Logged In To View This Page.
    #Log ID 4 = Unable To Find Layout Template.
    #Log ID 5 = Empty Data Submitted.

    //SQL Database Log ID's
    #Log ID 6 = Failed To Insert Data To Database.
    #Log ID 7 = Failed To Update Data In Database.
    #Log ID 8 = Failed To Delete Data From Database.
    #Log ID 9 = Failed To Select Data From Database.
    #Log ID 10 = General Database Error.

    public $no_data;
    public $log_data;
    public $log_id;
    public $logging_id;
    public $log_time;
    public $log_message;

    public function Load_Error_Display($logging_id, $error) {
        global $datetime;

        # If Log Type Is Greater Then 0 Then Log The Data
        if($logging_id > '0') {
            $this->Send_Logging_Data($logging_id, $error->getMessage());
        }

        tassign_array(["ERROR_MESSAGE" => $error->getMessage(), "PAGE_TITLE" => "Error", "ERROR_TIME" => $datetime]);
		tdisplay('error');
    }

    public function Load_Logging_Data() {

    }

    public function Send_Logging_Data($logging_id, $message) {
        $datetime = date('U');

        if(isset($_SESSION['user_ID'])) {
            $user_ID = $_SESSION['user_ID'];
        } else {
            $user_ID = '0';
        }

        $self_url = $_SERVER['HTTP_HOST'];
        $ip = $_SERVER['HTTP_X_REAL_IP'];

        # If Log Type Is Greater Then 0 Then Log The Data
        if($logging_id > '0') {
            try {
                $send_log_sql = "INSERT INTO `site_logs` (`log_type`, `log_user_id`, `log_message`, `log_ip`, `log_time`)
                                    VALUES (:log_type, :log_user_id, :log_message, :log_ip, :log_time)";
                $send_log_params = array("log_type" => $logging_id, "log_user_id" => $user_ID, "log_message" => $message, "log_ip" => $ip, "log_time" => $datetime);
                $send_log = new Database;
                $send_log->query_data($send_log_sql, $send_log_params, "no", "insert");
            } catch(PDOException $e) {
                trigger_error($e->getMessage());
                echo "There was an Error Logging The Logging Error. Got To Love Inceptions Right?";
                die();
            }
        }
    }
}

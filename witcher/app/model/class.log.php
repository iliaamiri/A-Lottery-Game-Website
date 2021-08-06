<?php
namespace Model;

use Config\tables;

class log{
    private $log_files = [
        'Input_Events' => 'input_events.log',
        'Login_Events' => 'login.log',
        'Pdo_Errors' => 'pdo_errors.log'
    ];
    private $log_path;
    private $logs_size_limit_in_bytes = 1073741824;
    function __construct()
    {
        $witcher = new \witcher();
        $this->log_path = $witcher->root()."witcher/storage/logs/";
        date_default_timezone_set('Asia/Tehran');
    }
    // Trace client's IP address and save them into database
    public function traceIp($traced_from){
        $preg = new preg();
        if ($preg->custom('/^[0-9.]*$/i',$_SERVER['REMOTE_ADDR']) == 1){
            $db = new db();
        $tables = new tables();
        $logs_tbl = $tables->MAIN_TABLES['logs_ips'];
        $time = time();
        $sql = $db->db_query("INSERT INTO $logs_tbl (Ip_address,Traced_from,Traced_time) VALUE ('$_SERVER[REMOTE_ADDR]',:trace_from,'$time')");
        $sql->bindParam(':trace_from',$traced_from,\PDO::PARAM_STR);
        $sql->execute();
        return true;
        }else{
            return false;
        }
    }
    // Trace client's Session Id and save them into database
    public function traceSSID(){
        $preg = new preg();
        if ($preg->custom('/^[-,a-zA-Z0-9]{1,128}$/i',session_id()) == 1){
            $tables = new tables();
            $ssid_tbl = $tables->MAIN_TABLES['logs_ssid'];
            $time = time();
            $ssid = session_id();
            $db = new db();
            $db->db_query("INSERT INTO $ssid_tbl (Session_id,Created_timestamp) VALUES ('$ssid','$time')",1);
            return true;
        }else{
            return false;
        }
    }
    public function ClearFilesOrNot(){
        $files = scandir($this->log_path);
        $sum = 0;
        foreach ($files as $file){
            $e = explode(".",$file);
            $end = end($e);
            if ($end == "log"){
                $sum = $sum + filesize($this->log_path.$file);
            }
        }
        if ($sum >= $this->logs_size_limit_in_bytes){
            foreach ($files as $each){
                $e = explode(".",$each);
                $end = end($e);
                if ($end == "log"){
                    file_put_contents($this->log_path.$each,"");
                }
            }
        }
    }
    public function login_logger($username,$action,$password_optional = ""){
        $file = fopen($this->log_path.$this->log_files['Login_Events'],"a");
        $content = "";
        switch ($action){
            case "Success":
                $content = "[".date("m/d/Y - D - G:i:s e O")."] - Login Was Successful for ".$username;
                break;
            case "Failed":
                $content = "[".date("m/d/Y - D - G:i:s e O")."] - Authentication Failed for ".$username;
                break;
            case "Logout":
                $content = $content = "[".date("m/d/Y - D - G:i:s e O")."] - ".$username." Logged out FROM Application";
                break;
            case "Forgot_Password":
                $content = $content = "[".date("m/d/Y - D - G:i:s e O")."] - ".$username." Actioned TO Forgot Password";
                break;
        }
        fwrite($file,$content."\r\n");
        fclose($file);
        return true;
    }
    public function pdo_logger($error){
        $file = fopen($this->log_path.$this->log_files['Pdo_Errors'],"a");
        $content = "[".date("m/d/Y - D - G:i:s e O")."] - ".$error;
        fwrite($file,$content."\r\n");
        fclose($file);
        return true;
    }
}
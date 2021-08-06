<?php
namespace Controller;
use Model\log;
use Model\pager;
use Model\user;
use Model\message;
use Model\preg;
use Model\db;
use Model\views;
/*
 *
 */
class login extends views {
    private $LOG;
    private $Stat = "not login";

    public function start(){
        $views_array= array(parent::setHeader("layouts/header.php"),parent::setPage("login.php"),parent::setFooter("layouts/footer.php"));
        if(isset($_POST['Login'])){
            $loginn = $this->Login();
            if ($loginn == true)
                 goto cont;
        }elseif ($this->is_login() == true){
            $this->Stat = "Logged-in";
        }
        if ($this->Stat == "Logged-in"){
            cont :
            pager::go_page("/");
        }
        parent::Show($views_array);
    }
    public function Identify($id){
        $preg = new preg();
        if ($preg->number($id) == 1){
                $db = new db();
                $sql = $db->db_query("SELECT * FROM $this->table WHERE id = '$id'",1);
                if ($sql->rowCount() == 0){
                    return false;
                    exit();
                }
                $row = $sql->fetch(PDO::FETCH_ASSOC);
                return $row;
        }else{
            return false;
        }
    }
    public function Login(){
        $message = new message();
        if (isset($_POST['Username']) AND isset($_POST['Password']) AND !empty($_POST['Username']) AND !empty($_POST['Password'])){
            $db = new db();
            $preg = new preg();
            $user = new user();
            $logs = new log();
            $username = $_POST['Username'];
            $password = $_POST['Password'];
            $preg_username = $preg->username($username);
            $preg_password = $preg->password($password);
            if ($preg_password === 1 AND $preg_username === 1){
                $password = md5(sha1(md5($password)));
                $user_tbl = $user->user_db_info['db_Table'];
                try{
                    $check = $db->db_query("SELECT * FROM $user_tbl WHERE Username = '$username' AND Password = '$password'",1);
                    if ($check->rowCount() == 0){
                        $logs = new log();
                        $logs->login_logger($username,"Failed",$_POST['Password']);
                        $message->msg_session_prepare("جزثیات وارد شده نامعتبر است.");
                        pager::refresh();
                        exit();
                    }
                    $rows = $check->fetch(\PDO::FETCH_ASSOC);
                    $permissions = $user->user_get_permission(0,$rows['Email']);
                    if ($permissions['Login'] == 1 AND $permissions['Active'] == 1 AND $permissions['role_id'] > -1 ){
                        $_SESSION['Username'] = $username;
                        $_SESSION['Password'] = $password;
                        $_SESSION['Certificate_Code'] = md5(sha1(md5(sha1(md5(sha1(md5(rand(1000,9999))))))));
                        $Last_ip = $_SERVER['REMOTE_ADDR'];
                        $Last_login = date("Y/m/d h:i:sa");
                        $obj = new \OS_BR();
                        $browser=  $obj->showInfo('browser');
                        $db->db_query("UPDATE $user_tbl SET Session_id = '$_SESSION[Certificate_Code]' , Last_ip = '$Last_ip' , Last_Login = '$Last_login' , Last_Browser = '$browser' WHERE Username = '$rows[Username]'",1);
                        $this->LOG = true;
                        $logs->login_logger($username,"Success");
                        return $this->LOG;
                    }else{
                        $message->msg_session_prepare("این کاربر مجوز ورود ندارد.");
                        pager::refresh();
                        exit;
                    }
                }catch (PDOException $e){
                    $logs->pdo_logger($e);
                    $message->msg_session_prepare("مشکل فنی وجود دارد.");
                    exit;
                }
            }
            else{
                $message->msg_session_prepare("مقدار نامعتبر است.");
                pager::refresh();
                exit;
            }
        }elseif (!isset($_POST['Username']) OR !isset($_POST['Password']) OR empty($_POST['Username']) OR empty($_POST['Password'])){
            $message->msg_session_prepare("جزثیات ناکامل است.");
            //pager::refresh();
        }
    }
    public function is_login(){
        $db = new db();
        $preg = new preg();
        $message = new message();
        $user = new user();
        if (isset($_SESSION['Certificate_Code']) AND isset($_SESSION['Username']) AND isset($_SESSION['Password'])){
            $username = $_SESSION['Username'];
            $password = $_SESSION['Password'];
            $preg_username = $preg->username($username);
            $preg_password = $preg->password($password);
            if ($preg_password === 1 AND $preg_username === 1){
                $user_tbl = $user->user_db_info['db_Table'];
                try{
                    $check = $db->db_query("SELECT * FROM $user_tbl WHERE Username = '$username' AND Password = '$password' AND Session_id = '$_SESSION[Certificate_Code]'",1);
                    if ($check->rowCount() == 1){
                        return true;
                    }else{
                        return false;
                    }
                }catch (PDOException $e){
                    die("Error in PDO : ".$e);
                }
            }
            else{
                $message->msg_session_prepare("مقدار نامعتبر است.");
                pager::go_page("http://arashprojet.ow/login");
            }
        }
        elseif (!isset($_SESSION['Certificate_Code']) OR !isset($_SESSION['Username']) OR !isset($_SESSION['Password'])){
            //$message->msg_session_prepare("This user is not logged-in");
            return false;
        }
    }
    public function is_admin(){
        $user = new user();
        if ($this->is_login() == true){
            $permissions = $user->user_get_permission();
            if ($permissions){
                if ($permissions['Admin'] == 1){
                    return true;
                }else{
                    return false;
                }
            }
        }else{
            return "isnot login";
        }
    }
}
<?php
namespace Controller;

use Model\log;
use Model\mail;
use Model\message;
use Model\pager;
use Model\preg;
use Model\user;
use Model\views;

class forgot extends views{
    private $Email = "";
    private $verifycode;
    public function start(){
        $view = [];
        $user = new user();
        if (!isset($_GET['Action'])) {
            if (isset($_POST['ForgotSubmit'])) {
                if (!isset($_POST['Email'])){
                    message::msg_box_session_prepare("لطفا فیلد ایمیل را پر کنید", "warning");
                    pager::refresh();
                }
                if ($this->setEmail($_POST['Email'])) {
                    $askemail = $this->AskEmail();
                    if (!$askemail['status']) {
                        message::msg_box_session_prepare($askemail['details'],"warning");
                        pager::refresh();
                        exit();
                    } else {
                        $this->SetVerifyCode();
                        $getuser = $user->getUserInfoBy('Email',$_POST['Email'])[0];
                         $mail = new \PHPMailer();
                        $mail->setFrom('from@example.com', 'First Last');
                                $message = "
<html>
<body>
<p>HELLO ".$getuser['Username']."</p><br>
<b>HERE IS YOUR VERIFY CODE BELLOW:</b><br>
".$this->verifycode."
</body>
</html>                   
";
                        if ($user->UpdateColumn('VerifyCode',$this->verifycode,"WHERE Email = '".$_POST['Email']."'")){
                        
                                     $mail->Subject = "VERIFY YOUR ACCOUNT";
                                    $mail->setFrom('info@bmbgames.com', '');
                                    $mail->addAddress($_POST['Email'], '');
                                    $mail->msgHTML($message);
                                    $mail->send();
                            $_SESSION['ROLE_STAT'] = "verifying";
                            pager::go_page("/forgot/verify");
                        }else{
                            message::msg_box_session_prepare("ناموفق","danger");
                            pager::refresh();
                            exit();
                        }
                    }
                } else {
                    message::msg_box_session_prepare("ایمیل نامعتبر است.", "warning");
                    pager::refresh();
                }
            } elseif (!isset($_POST['ForgotSubmit']) or !isset($_POST['Email'])) {
                $view = [parent::setHeader("layouts/header.php"), parent::setPage("layouts/home_head.php"), parent::setPage("forgot.php"), parent::setFooter("layouts/footer.php")];
            }
        }elseif (isset($_GET['Action'])){
            switch ($_GET['Action']){
                case "forgotVerify":
                    $view = [parent::setHeader("layouts/header.php"), parent::setPage("layouts/home_head.php"), parent::setPage("forgotVerify.php"), parent::setFooter("layouts/footer.php")];
                    if (isset($_SESSION['OLD_IP']) and isset($_SESSION['ROLE_STAT']) and isset($_SESSION['EMAIL_']) and isset($_COOKIE['_passverify_'])){
                        if ($_SESSION['ROLE_STAT'] != "verifying"){
                            message::msg_box_session_prepare("لطفا درخواست فراموشی را تکمیل کنید","warning");
                            pager::go_page("/forgot");
                            exit();
                        }
                        if (isset($_POST['VerifySubmit'])){
                            $preg = new preg();
                            try{
                                if ($_SESSION['OLD_IP'] != $_SERVER['REMOTE_ADDR']){
                                    throw new \Exception("تقلب در آی پی شناسایی شد.");
                                }
                                if ($_SESSION['ROLE_STAT'] != "verifying"){
                                    throw new \Exception("تقلب در نقش شناسایی شد.");
                                }
                                if (!isset($_POST['Code'])){
                                    throw new \Exception("کد فرستاده نشد.");
                                }
                                if ($preg->md5($_POST['Code']) != 1) {
                                    throw new \Exception("کد نامعتبر است.");
                                }
                                $getuser = $user->getUserInfoBy('Email',$_SESSION['EMAIL_'])[0];
                                if ($getuser['Key_verify'] > 5){
                                    $user->UpdatePermission('role_id','-1',$getuser['Email']);
                                    throw new \Exception("شما بن شدید.");
                                }
                                if (strlen($_POST['Code']) < 6){
                                    throw new \Exception("کد ناکامل است");
                                }
                                $select = $user->getUserInfoBy('VerifyCode',$_POST['Code']);
                                if (count($select) == 0){
                                    $newKey = $getuser['Key_verify'] + 1;
                                    $user->UpdateColumn('Key_verify',$newKey,"WHERE Email = '".$_SESSION['EMAIL_']."'");
                                    throw new \Exception("کد اشتباه است.");
                                }
                    
                                if ($user->UpdateColumn('VerifyCode','NULL',"WHERE Email = '".$_SESSION['EMAIL_']."'")){
                                    $_SESSION['ROLE_STAT'] = "resetting_pass";
                                    pager::go_page("/forgot/resetpass");
                                }else{
                                    throw new \Exception("مراحل تایید دچار مشکل شده. لطفا بعدا ایمیل خود را تایید کنید.");
                                }
                            }catch (\Exception $e){
                                pager::redirect_page('0','/forgot/verify');
                                message::msg_box_session_prepare($e->getMessage(),"warning");
                                exit();
                            }
                        }
                    }elseif (!isset($_SESSION['OLD_IP']) or !isset($_COOKIE['_passverify_']) or !isset($_SESSION['EMAIL_']) or !isset($_SESSION['ROLE_STAT'])){
                        pager::redirect_page('0','/forgot');
                        exit();
                    }
                    break;
                case "changePassword":
                    if (isset($_SESSION['OLD_IP']) and isset($_SESSION['ROLE_STAT']) and isset($_SESSION['EMAIL_']) and isset($_COOKIE['_passverify_'])){
                        $view = [parent::setHeader("layouts/header.php"), parent::setPage("layouts/home_head.php"), parent::setPage("resetpass.php"), parent::setFooter("layouts/footer.php")];
                        if ($_SESSION['ROLE_STAT'] != "resetting_pass"){
                            message::msg_box_session_prepare("لطفا درخواست فراموشی را تکمیل کنید","warning");
                            pager::go_page("/forgot");
                            exit();
                        }
                        if (isset($_POST['ResetPass'])){
                            $preg = new preg();
                            try{
                                if ($_SESSION['OLD_IP'] != $_SERVER['REMOTE_ADDR']){
                                    throw new \Exception("تقلب در آی پی شناسایی شد.");
                                }
                                if ($_SESSION['ROLE_STAT'] != "resetting_pass"){
                                    throw new \Exception("تقلب در نقش شناسایی شد.");
                                }
                                if (!isset($_POST['newpass']) or !isset($_POST['newpasss'])){
                                    throw new \Exception("پسورد فرستاده نشد.");
                                }
                                if ($preg->password($_POST['newpass']) != 1) {
                                    throw new \Exception("پسورد نامعتبر است.");
                                }
                                if ($_POST['newpass'] != $_POST['newpasss']){
                                    throw new \Exception("پسورد ها با یکدیگر مساوی نیستند.");
                                }
                                $newpass = md5(sha1(md5($_POST['newpass'])));
                                $user->UpdateColumn('Password',$newpass,"WHERE Email = '".$_SESSION['EMAIL_']."'");
                                $witcher = new \witcher();
                                $witcher->unsetSession();
                                $witcher->DownWithCookie('_passverify_');
                                pager::redirect_page('0','/login');
                                message::msg_alert("موفق");
                                exit();
                            }catch (\Exception $e){
                                pager::redirect_page('0','/forgot/resetpass');
                                message::msg_box_session_prepare($e->getMessage(),"warning");
                                exit();
                            }
                        }
                    }elseif (!isset($_SESSION['OLD_IP']) or !isset($_COOKIE['_passverify_']) or !isset($_SESSION['EMAIL_']) or !isset($_SESSION['ROLE_STAT'])){
                        pager::redirect_page('0','/forgot');
                        exit();
                    }
                    break;
            }
        }
        parent::Show($view);
    }
    protected function setEmail($email){
        $preg = new preg();
        if ($preg->email($email) == 1 ){
            return $this->Email = $email;
        }
    }
    private function AskEmail(){
            $user = new user();
            $userC = $user->CountUsersBy('Email',$this->Email);
            if ($userC > 0 ){
                $asker_permission = $user->user_get_permission(0,$this->Email);
                if ($asker_permission['Active'] == 1 and $asker_permission['role_id'] >= 0){
                    $_SESSION['OLD_IP'] = $_SERVER['REMOTE_ADDR'];
                    $_SESSION['EMAIL_'] = $this->Email;
                    $_SESSION['ROLE_STAT'] = "checking_email";
                    setcookie('_passverify_',sha1($_SESSION['OLD_IP']).md5($this->Email),time() + 3600 * 48,'/');
                    return ['status' => true,'details' => 'قبول'];
                }else{
                    return ['status' => false,'details' => 'اجازه داده نشد.'];
                }
            }else{
                return ['status' => false,'details' => 'ایمیل یافت نشد.'];
            }
    }
    private function SetVerifyCode(){
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < 7; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        $Id = $randomString;
        return $this->verifycode = $Id;
    }
}
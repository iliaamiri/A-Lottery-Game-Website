<?php
namespace Controller;

use Model\mail;
use Model\message;
use Model\pager;
use Model\preg;
use Model\user;
use Model\views;

class signup extends views{
    private $verifycode;
    private $views;
    public function start(){
        $witcher = new \witcher();
        $witcher->requireController("login");
        $login = new login();
        if ($login->is_login()){
            pager::go_page("/profile");
            exit();
        }else {
            if (isset($_GET['singupAction'])) {
                $this->SignUpActions();
            }elseif (!isset($_GET['singupAction'])) {
                if ($_SERVER['REQUEST_METHOD'] == "POST") {
                    $this->CallbackSubmit();
                }
                $this->SetView([parent::setHeader("layouts/header.php"), parent::setPage("layouts/home_head.php"), parent::setPage("signup.php"), parent::setFooter("layouts/footer.php")]);
            }
            parent::Show($this->views);
        }
    }
    private function SignUpActions(){
        $msg = new message();
        $witcher = new \witcher();
        if (isset($_GET['singupAction'])){
            $user = new user();
            switch ($_GET['singupAction']){
                case 'emailVerify':
                    try{
                        if (!isset($_SESSION['IP_ADDRESS'])){
                            throw new \Exception("ای پی شما مشکوک است.");
                        }
                        if ($_SESSION['IP_ADDRESS'] != $_SERVER['REMOTE_ADDR']){
                            throw new \Exception("ای پی شما مشکوک است.");
                        }
                        if (!isset($_COOKIE['_verifying_'])){
                            throw new \Exception("ایمیل شما یافت نشد.");
                        }
                        if (!isset($_SESSION['EMAIL'])){
                            throw new \Exception("ایمیل شما یافت نشد.");
                        }
                        $role = $user->getUserRoleCats($_SESSION['EMAIL']);
                        if ($role['Role_Id'] < 0){
                            throw new \Exception("شما بن شدید.");
                        }
                        if (sha1(md5($_SESSION['EMAIL']).md5($_SESSION['IP_ADDRESS'])) != $_COOKIE['_verifying_']){
                            throw new \Exception("ایمیل شما یافت نشد.");
                        }
                        $_SESSION['ROLLING_STATUS'] = "ReadyToGetVerifyCode";
                    }catch (\Exception $i ){
                        message::msg_alert($i->getMessage());
                        pager::go_page(HTTP_SERVER);
                    }
                    $this->SetView([parent::setHeader("layouts/header.php"),parent::setPage("layouts/home_head.php"),parent::setPage("verifyUser.php"),parent::setFooter("layouts/footer.php")]);
                    if ($_SERVER['REQUEST_METHOD'] == "POST"){
                        try{
                            if (!isset($_SESSION['ROLLING_STATUS'])){
                                throw new \Exception("تقلب تشخیص داده شد.");
                            }
                            if ($_SESSION['ROLLING_STATUS'] != "ReadyToGetVerifyCode"){
                                throw new \Exception("تقلب تشخیص داده شد.");
                            }
                            if (!isset($_POST['Code'])){
                                throw new \Exception("کد وارد نشده است.");
                            }
                            if (empty($_POST['Code'])){
                                throw new \Exception("کد خالی است.");
                            }
                            // todo check the captcha in here .
                            $preg = new preg();
                            if ($preg->custom('/^[A-Z0-9]*$/i',$_POST['Code']) != 1){
                                throw new \Exception("کد نامعتبر است.");
                            }
                            $lastKey = $user->getUserInfoBy('Email',$_SESSION['EMAIL'])[0]['Key_Try'];
                            if ($lastKey > 5){
                                message::msg_alert("شما بن شدید.");
                                $user->UpdateRolePermission($_SESSION['EMAIL'],'-1');
                                throw new \Exception("شما بن شدید.");
                            }
                            $exist = $user->CountUsersBy('VerifyCode',$_POST['Code']);
                            if ($exist > 0 ){
                                $user->UpdateColumn('Key_Try','0',"WHERE Email = '".$_SESSION['EMAIL']."'");
                                $user->UpdateColumn('VerifyCode',null,"WHERE Email = '".$_SESSION['EMAIL']."'");
                                $user->UpdateRolePermission($_SESSION['EMAIL'],'0');
                                $user->UpdatePermission('Active','1',$_SESSION['EMAIL']);
                                $user->UpdatePermission('Invite','1',$_SESSION['EMAIL']);
                                $user->UpdatePermission('Message','1',$_SESSION['EMAIL']);
                                $witcher->DownWithCookie("_verifying_");
                                $witcher->unsetSession();
                                pager::go_page("/login");
                            }else{
                                $newTry = $lastKey + 1;
                                $user->UpdateColumn('Key_Try',$newTry,"WHERE Email = '".$_SESSION['EMAIL']."'");
                                throw new \Exception("کد اشتباه است. لطفا در وارد کردن کد دقت فرمایید زیرا شما فقط میتوانید 5 بار امتحان کنید.");
                            }
                        }catch (\Exception $e){
                            $msg->msg_session_prepare($e->getMessage());
                        }
                    }
                    break;
            }
        }
    }
    private function CallbackSubmit(){
        $preg = new preg();
        $msg = new message();
        try{
            if (!isset($_POST['Full_Name']) or !isset($_POST['Username']) or !isset($_POST['Password']) or !isset($_POST['rePassword'])){
                throw new \Exception("همه ی مقدار ها باید پر شوند.");
            }
            if ($preg->custom('/^[a-zA-Zا-ی\s]*$/u',$_POST['Full_Name']) != 1 ){
                throw new \Exception("نام و نام خانوادگی نامعتبر است.");
            }
            if ($preg->username($_POST['Username']) != 1 or strlen($_POST['Username']) < 1 or strlen($_POST['Username']) > 300){
                throw new \Exception("نام کاربری نامعتبر است.");
            }
            if ($preg->password($_POST['Password']) != 1 or strlen($_POST['Password']) < 1 or strlen($_POST['Password']) > 300){
                throw new \Exception("پسورد نامعتبر است. ");
            }
            if ($preg->email($_POST['Email']) != 1 or strlen($_POST['Email']) < 1 or strlen($_POST['Email']) > 300){
                throw new \Exception("ایمیل نامعتبر است.");
            }
            $user = new user();
            $email = $_POST['Email'];
            $username = $_POST['Username'];
            $password = $_POST['Password'];
            $fullname = $_POST['Full_Name'];
            if ($user->CountUsersBy('Email',$email) > 0){
                throw new \Exception("این ایمیل وجود دارد.");
            }
            if ($user->CountUsersBy('Username',$username) > 0 ){
                throw new \Exception("این نام کاربری وجود دارد.");
            }
            $data_to_add = [
                'Full_Name' => $fullname,
                'Username' => $username,
                'Password' => $password,
                'Email' => $email,
            ];
            $permissions = [
               $email, 1, 0, 1, 0, 0, 0, 0, 1, 1
            ];
               if ($user->AddUser($data_to_add,$permissions)){
                   //$this->SetVerifyCode();
                   /*$mail = new \PHPMailer();
                   $message = "
<html>
<body>
<p>HELLO ".$username."</p><br>
<b>HERE IS YOUR VERIFY CODE BELLOW:</b><br>
".$this->verifycode."
</body>
</html>                   
";*/
                   //if ($user->UpdateColumn('VerifyCode',$this->verifycode,"WHERE Email = '".$email."'")){
                    /*   $mail->Subject = "VERIFY YOUR ACCOUNT";
                        $mail->setFrom('info@bmbgames.com', '');
                        $mail->addAddress($email, '');
                        $mail->msgHTML($message);
                        $mail->send();*/
                   //    $_SESSION['IP_ADDRESS'] = $_SERVER['REMOTE_ADDR'];
                     //  $_SESSION['EMAIL'] = $email;
                      // setcookie("_verifying_",sha1(md5($email).md5($_SESSION['IP_ADDRESS'])),time() + 3600 * 24,'/');
                       pager::redirect_page('0',"/login");
                       message::msg_session_prepare("خوش آمدید !");
                       exit();
                   /*}else{
                       throw new \Exception("مراحل تایید دچار مشکل شده. لطفا بعدا ایمیل خود را تایید کنید.");
                   }*/
               }else{
                   throw new \Exception("عملیات موفقیت آمیز نبود. مشکل از سایت میباشد.");
               }
        }catch (\Exception $e ){
            $msg->msg_session_prepare($e->getMessage());
            pager::refresh();
            exit();
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
    private function SetView($views){
        return $this->views = $views;
    }
}
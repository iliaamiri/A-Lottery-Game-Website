<?php
namespace Module;

use Model\internal_mail;
use Model\message;
use Model\module;
use Model\pager;
use Model\user;

class add_internal_message extends module {
    private static $internal_mail;
    private $post_index_email_receiver = 'Email_Receiver';
    private $post_index_email_message = 'Texts';
    private $post_index_email_subject = 'Subject';
    function __construct()
    {
        new module();
        parent::$callback_url = "/profile/mail/new";
        $internal_mail = new internal_mail();
        self::$internal_mail = $internal_mail;
    }

    private function set_email_sender(){
        if (self::$internal_mail->setSender_Email(parent::$loggedIn_user['Email']))
            return true;
        else
            return false;
    }
    public function set_email_receiver($email){
        if (count($this->get_receivers()) > 0) {
            $i = 0;
            foreach ($this->get_receivers() as $receiver){
                if ($receiver == $email){
                    $i++;
                }
            }
            if ($i == 1) {
                if (self::$internal_mail->setReceiver_Email($email))
                    return true;
                else
                    return false;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }
    public function set_subject($subject = ""){
        if (self::$internal_mail->setSubject($subject))
            return true;
        else
            return false;
    }
    public function set_message($msg){
        if (self::$internal_mail->setMessage($msg))
            return true;
        else
            return false;
    }
    public function get_receivers(){
        $user = new user();
        $statement = " WHERE ReadMessage = '1' AND ReadUsers = '1' AND Message = '1' and Email != '".parent::$loggedIn_user['Email']."'";
        $receivers = $user->select_from_permission($statement);
        return $receivers;
    }

    public function internal_message_access(){
        $message_permission = parent::$loggedIn_user['Message'];
        $Readmessage_permission = parent::$loggedIn_user['ReadMessage'];
        $Readusers_permission = parent::$loggedIn_user['ReadUsers'];
        if ($message_permission == 1 and $Readmessage_permission == 1 and $Readusers_permission == 1 )
            return true;
        else
            return false;
    }
    public function post_email_receiver(){
        if (isset($_POST[$this->post_index_email_receiver])){
                return true;
        }elseif (!isset($_POST[$this->post_index_email_receiver])){
            return false;
        }
    }
    public function post_message(){
        if (isset($_POST[$this->post_index_email_message])){
            return true;
        }elseif (!isset($_POST[$this->post_index_email_message])){
            return false;
        }
    }
    public function post_subject(){
        if (isset($_POST[$this->post_index_email_subject])){
            return true;
        }elseif (!isset($_POST[$this->post_index_email_subject])){
            return false;
        }
    }

    public function callback(){
        if ($_SERVER['REQUEST_METHOD'] == "POST"){
            try{
                if (!$this->internal_message_access()){
                    throw new \Exception("دسترسی برای پیام داخلی کافی نیست");
                }
                if (!$this->post_email_receiver()){
                    throw new \Exception("ایمیل گیرنده تعیین نشد");
                }
                if (!$this->set_email_receiver($_POST[$this->post_index_email_receiver])){
                    throw new \Exception("ایمیل گیرنده نامعتبر است");
                }
                if (!$this->post_subject()){
                    throw new \Exception("موضوع تعیین نشد");
                }
                if (strlen($_POST[$this->post_index_email_subject]) < 1){
                    throw new \Exception("موضوع تعیین نشد");
                }
                if (!$this->set_subject($_POST[$this->post_index_email_subject])){
                    throw new \Exception("موضوع نامعتبر است");
                }
                if (!$this->post_message()){
                    throw new \Exception("پیغام تعیین نشد");
                }
                if (strlen($_POST[$this->post_index_email_message]) < 1){
                    throw new \Exception("پیام تعیین نشد");
                }
                if (strlen($_POST[$this->post_index_email_message]) > 5000){
                    throw new \Exception("پیام نمیتواند بیش از 5000 کارکتر باشد");
                }
                if (!$this->set_message($_POST[$this->post_index_email_message])){
                    throw new \Exception("پیغام نامعتبر است");
                }
                $this->set_email_sender();
                if (self::$internal_mail->newInternalMessage()){
                    message::msg_box_session_prepare("موفق","success");
                    pager::go_page(parent::$callback_url);
                    exit();
                }else{
                    throw new \Exception("عملیات ناموفق بود");
                }
            }catch (\Exception $e){
                message::msg_box_session_prepare($e->getMessage(),"danger");
                pager::go_page(parent::$callback_url);
                exit();
            }
        }
    }
}
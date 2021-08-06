<?php
namespace Model;

use PHPMailer\PHPMailer\PHPMailer;

class mail{
private $To;
private $From;
private $Message;
private $Subject;
private $Header;
private $mail;

function __constract(){
    $witcher = new \withcer();
    $witcher->requirePlugin("PHPMailerAutoload.php");
    return $this->mail = new \PHPMailer;
}

public function SetTo($email,$name =""){
    return $this->mail->addAddress($email, "");
}
public function SetFrom($email,$firstlast = ""){
    return $this->mail->setFrom($email,$firstlast);
}
public function SetMessage($msg){
    return $this->mail->msgHTML($msg);
}
public function SetSubject($subject){
    return $this->mail->Subject = $subject;
}
public function SetHeaders(){
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= "From: ".$this->From."\r\n";
    return $this->Header = $headers;
}
public function Send(){
    $this->mail = new \PHPMailer;
    $mail->SetTo($to,"test");
$mail->SetFrom($from);
$mail->SetMessage($msg);
$mail->SetSubject($sub);
    if (!$this->mail->send()) {
    return "Mailer Error: " . $this->mail->ErrorInfo;
} else {
    return true;
}
}
}
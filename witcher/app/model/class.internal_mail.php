<?php
namespace Model;

use Config\tables;

class internal_mail{
    private $Sender_Email;
    private $Sender_Nickname;
    private $Receiver_Email;
    private $Receiver_Nickname;
    private $Message;
    private $Subject = "";
    private static $preg;
    private static $db;
    private static $maintbl;

    function __construct()
    {
        self::$preg = new preg();
        self::$db = new db();
        $table = new tables();
        self::$maintbl = $table->MAIN_TABLES['Messages_clients'];
    }

    public function setSender_Email($email){
        if ((preg_match('/^[a-zA-Z0-9_.-@+,]*$/i',$email))) {
            $this->Sender_Email = $email;
            return true;
        }else {
            return false;
        }
    }
    public function setSender_Nickname($nickname){
        if (self::$preg->username($nickname) == 1) {
            $this->Sender_Nickname = $nickname;
            return true;
        }else {
            return false;
        }
    }
    public function setReceiver_Nickname($nickname){
        if (self::$preg->username($nickname) == 1) {
            $this->Receiver_Nickname = $nickname;
            return true;
        }else {
            return false;
        }
    }
    public function setReceiver_Email($email){
        if (self::$preg->email($email) == 1) {
            $this->Receiver_Email = $email;
            return true;
        }else {
            return false;
        }
    }
    public function setMessage($message){
        if (self::$preg->text($message) == 1) {
            $this->Message = html_entity_decode($message);
            return true;
        }else {
            return false;
        }
    }
    public function setSubject($subject){
        if (self::$preg->text($subject) == 1) {
            $this->Subject = $subject;
            return true;
        }else {
            return false;
        }
    }

    public function generateMessage_id(){
        $a = sha1(md5(sha1(md5(sha1(rand(1000,9999)."EKETFLR3949okLSKDCN?!@!++++dd").md5(sha1(rand(1000,9999)))))));
        $b = sha1(md5(md5(sha1(sha1(md5(sha1(md5(sha1($a)))))),'SUPER_SALTY')));
        return sha1($a.$b);
    }

    public function newInternalMessage(){
        $msgid = $this->generateMessage_id();
        $tbl = self::$maintbl;
        $time = time();
        $sql = self::$db->db_query("INSERT INTO $tbl (Email,Sent_To,Subject,Message,Sent_At,Mail_Type,Message_id) VALUES ('$this->Sender_Email','$this->Receiver_Email','$this->Subject',:msg,'$time','Internal','$msgid')");
        $sql->bindValue(':msg',$this->Message,\PDO::PARAM_STR);
        $sql->execute();
        return true;
    }
    public function newInternalReply($msg_id){
        $msgid = $this->generateMessage_id();
        $tbl = self::$maintbl;
        $time = time();
        $sql = self::$db->db_query("INSERT INTO $tbl (Email,Sent_To,Subject,Message,Sent_At,Mail_Type,Reply_id,Message_id) VALUES ('$this->Sender_Email','$this->Receiver_Email','$this->Subject',:msg,'$time','Internal','$msg_id','$msgid')");
        $sql->bindValue(':msg',$this->Message,\PDO::PARAM_STR);
        $sql->execute();
        return true;
    }

    public function newSupportRequest(){
        $msgid = $this->generateMessage_id();
        $tbl = self::$maintbl;
        $time = time();
        $sql = self::$db->db_query("INSERT INTO $tbl (Email,Sent_To,Subject,Message,Sent_At,Mail_Type,Message_id) VALUES ('$this->Sender_Email','$this->Receiver_Nickname','$this->Subject',:msg,'$time','Support','$msgid')");
        $sql->bindValue(':msg',$this->Message,\PDO::PARAM_STR);
        $sql->execute();
        return true;
    }
    public function newSupportReply($msg_id){
        $msgid = $this->generateMessage_id();
        $tbl = self::$maintbl;
        $time = time();
        $sql = self::$db->db_query("INSERT INTO $tbl (Email,Sent_To,Subject,Message,Sent_At,Mail_Type,Reply_id,Message_id) VALUES ('$this->Sender_Email','$this->Receiver_Nickname','$this->Subject',:msg,'$time','Support','$msg_id','$msgid')");
        $sql->bindValue(':msg',$this->Message,\PDO::PARAM_STR);
        $sql->execute();
        return true;
    }

    public function getMessage($msg_id){
        $tbl = self::$maintbl;
        $sql = self::$db->db_query("SELECT * FROM $tbl WHERE Message_id = '$msg_id'",1);
        return $sql->fetch(\PDO::FETCH_ASSOC);
    }
    public function getMessages($statement){
        $tbl = self::$maintbl;
        $sql = self::$db->db_query("SELECT * FROM $tbl $statement",1);
        return $sql->fetchAll(\PDO::FETCH_ASSOC);
    }
    public function getSupportMessages($statement = ""){
        $tbl = self::$maintbl;
        $sql = self::$db->db_query("SELECT * FROM $tbl WHERE Mail_Type = 'Support' $statement",1);
        return $sql->fetchAll(\PDO::FETCH_ASSOC);
    }
    public function getInternalMessages($statement = ""){
        $tbl = self::$maintbl;
        $sql = self::$db->db_query("SELECT * FROM $tbl WHERE Mail_Type = 'Internal' $statement",1);
        return $sql->fetchAll(\PDO::FETCH_ASSOC);
    }
    public function getRepliesOf($msg_id){
        $tbl = self::$maintbl;
        $sql = self::$db->db_query("SELECT * FROM $tbl WHERE Reply_id = '$msg_id'",1);
        return $sql->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function is_seen($msg_id){
        $tbl = self::$maintbl;
        $sql = self::$db->db_query("SELECT * FROM $tbl WHERE Message_id = '$msg_id' AND Read_Status = '1'",1);
        if ($sql->rowCount() > 0)
            return true;
        else
            return false;
    }
    public function is_existed($msg_id){
        $tbl = self::$maintbl;
        $sql = self::$db->db_query("SELECT * FROM $tbl WHERE Message_id = '$msg_id'",1);
        if ($sql->rowCount() > 0)
            return true;
        else
            return false;
    }

    public function change_to_seen($msg_id){
        $tbl = self::$maintbl;
        self::$db->db_query("UPDATE $tbl SET Read_Status = '1' WHERE Message_id = '$msg_id'",1);
        return true;
    }
    public function update($statement){
        $tbl = self::$maintbl;
        self::$db->db_query("UPDATE $tbl SET $statement",1);
        return true;
    }
    public function delete($statement){
        $tbl = self::$maintbl;
        self::$db->db_query("DELETE FROM $tbl $statement",1);
        return true;
    }
}
<?php
namespace Model;

class db{
    // default db
    private $db_username;
    private $db_password;
    private $db_name;
    private $db_host;
    private $db_charset;
    public static $conn;
    private static $db_config;
    function __construct()
    {
        $db_config = new \Config\database();
        self::$db_config = $db_config;
        self::$conn = $this->db_conn();
    }
    private function set_db_name(){
        $this->db_name = self::$db_config->db_name;
    }
    private function set_db_username(){
        $this->db_username = self::$db_config->db_username;
    }
    private function set_db_password(){
        $this->db_password = self::$db_config->db_password;
    }
    private function set_db_host(){
        $this->db_host= self::$db_config->db_host;
    }
    private function set_db_charset(){
        $this->db_charset = self::$db_config->db_charset;
    }
    private function set_db_values(){
        $this->set_db_host();
        $this->set_db_name();
        $this->set_db_username();
        $this->set_db_password();
        $this->set_db_charset();
    }
    public function db_conn()
    {
        $this->set_db_values();
        try {
            $conn = new \PDO("mysql:host=$this->db_host;dbname=$this->db_name;charset=$this->db_charset", $this->db_username, $this->db_password);
            $conn->setAttribute(\PDO::ATTR_ERRMODE,\PDO::ERRMODE_EXCEPTION);
            return $conn;
        } catch (\PDOException $e) {
            echo "<p style='text-align: center;margin-top: 10%;font-size: 19px;cursor: none;'>Connection with database was failed</p>";
            die();
        }
    }
    public function db_conn_custom($array){
        try{
            $conn_custom = new \PDO("mysql:host=$array[hostname];dbname=$array[dbname]",$array['user'],$array['pass']);
            $conn_custom->setAttribute(\PDO::ATTR_ERRMODE,\PDO::ERRMODE_EXCEPTION);
            self::$conn = $conn_custom;
        }catch (\PDOException $e){
            die("ERROR IN Connecting to <b style='color: red;'>".$array['dbname']."</b> PDO Threw : <br>".$e);
        }
    }
    public function db_query($query,$execute = 0){
        try{
            $sql = self::$conn->prepare($query);
            if ($execute == 1){
                $sql->execute();
            }
            return $sql;
        }catch (\PDOException $e){
            die($e);
        }
    }
    public function db_charset($charset){
        self::$conn->exec("SET NAMES ".$charset);
    }
    public function db_fetch($sql){
        $row = $sql->fetch(\PDO::FETCH_ASSOC);
        return $row;
    }
    public function getColumnsName($table){
        try{
            $sql = $this->db_query("SELECT `COLUMN_NAME` FROM `INFORMATION_SCHEMA`.`COLUMNS` WHERE `TABLE_SCHEMA`= $this->db_name AND `TABLE_NAME`= $table ",1);
            if ($sql->rowCount() > 0){
                $row = $this->db_fetch($sql);
                return $row;
            }else{
                throw new \PDOException("this table does not exist or does not any column.");
            }
        }catch (\PDOException $e){
            die($e);
        }
    }
}
<?php
namespace Model;

use Config\tables;

class factor{
    private $FactorNumber;
    private $Email;
    private $Amount;
    private $Method;
    private $comId;
    public $Key;
    private $tbl;
    function __construct()
    {
        $table = new tables();
        return $this->tbl = $table->MAIN_TABLES['payment_factors'];
    }

    public function createFactor(){
        $db = new db();
        $this->setFactorNumber();
        $this->setKey();
        $now = time();
        $db->db_query("INSERT INTO $this->tbl (Factor_number,Tracking_number,Private_Key,Amount,Method,Email,Started_At,Competition_Id) VALUE ('$this->FactorNumber','IsNotSet' ,'$this->Key','$this->Amount','$this->Method','$this->Email','$now','$this->comId')",1);
    }

    /*
        Factor Number Will Be Set Automatically
    */
    private function setFactorNumber(){
        $lastNumber = $this->getLastFactorNumber();
        $newFactorNumber = $lastNumber + 1;
        return $this->FactorNumber = $newFactorNumber;
    }

    /*
     * Email Should Be Set Manually
     */
    public function setEmail($email){
        return $this->Email = $email;
    }

    /*
    * Amount Should Be Set Manually
    */
    public function setAmount($amount){
        return $this->Amount = $amount;
    }

    /*
    * Method Should Be Set Manually
    */
    public function setMethod($method){
        return $this->Method = $method;
    }

    /*
    * ComId Should Be Set Manually
    */
    public function setComId($id){
        return $this->comId = $id;
    }


    private function setKey(){
        if ($this->Email != null and $this->FactorNumber != null)
            return $this->Key = md5(sha1(md5(sha1($this->Email))).sha1($this->FactorNumber));
    }

    public function getFactorNumber($Num){
        return $this->FactorNumber = $Num;
    }

    private function getLastFactorNumber(){
        $db = new db();
        $sql = $db->db_query("SELECT * FROM $this->tbl",1);
        if ($sql->rowCount() == 0){
            return 160000;
        }
        $sql2 = $db->db_query("SELECT MAX(Factor_number) as lastt FROM $this->tbl",1);
        $Last = $sql2->fetch(\PDO::FETCH_COLUMN);
        return $Last;
    }

    public function existFactorsByPrivateKey($key){
        $db = new db;
        $sql = $db->db_query("SELECT * FROM $this->tbl WHERE Private_Key = '$key'",1);
        if (count($sql->fetchAll(\PDO::FETCH_ASSOC)) > 0 )
            return true;
        else
            return false;
    }
    public function FactorsOfUserForComp($Email,$Comp){
        $db = new db();
        $sql = $db->db_query("SELECT * FROM $this->tbl WHERE Email = '$Email' AND Competition_Id = '$Comp'",1);
        return $sql->fetchAll(\PDO::FETCH_ASSOC);
    }
    public function HoverFactorsOfUserForComp($Email,$Comp){
        $db = new db();
        $sql = $db->db_query("SELECT * FROM $this->tbl WHERE Email = '$Email' AND Competition_Id = '$Comp' AND Status = 'Hover'",1);
        return $sql->fetchAll(\PDO::FETCH_ASSOC);
    }
    public function getFactorInformation($Key){
        $db = new db();
        $sql = $db->db_query("SELECT * FROM $this->tbl WHERE Email = '$this->Email' AND Private_Key = '$Key'",1);
        $factor_tbl = $sql->fetch(\PDO::FETCH_ASSOC);
        $gettables = new tables();
        $tables = [$gettables->MAIN_TABLES['Competition_tbl'],$gettables->MAIN_TABLES['Competition_Attributes_tbl']];
        $sql_main_compet = $db->db_query("SELECT $tables[0].* FROM $this->tbl RIGHT JOIN $tables[0] ON $this->tbl.Competition_Id = $tables[0].Competition_Id WHERE $this->tbl.Private_Key = '$factor_tbl[Private_Key]'",1);
        $sql_attr_compet = $db->db_query("SELECT $tables[1].* FROM $this->tbl RIGHT JOIN $tables[1] ON $this->tbl.Competition_Id = $tables[1].Competition_Id WHERE $this->tbl.Private_Key = '$factor_tbl[Private_Key]'",1);
        $result = [$factor_tbl,$sql_main_compet->fetch(\PDO::FETCH_ASSOC),$sql_attr_compet->fetch(\PDO::FETCH_ASSOC)];
        return $result;
    }
    public function getFactorInfoBy($by,$value){
        $db = new db();
        $sql = $db->db_query("SELECT * FROM $this->tbl WHERE $by = '$value'",1);
        if ($sql->rowCount() > 0 ){
            return $sql->fetchAll(\PDO::FETCH_ASSOC);
        }else{
            return false;
        }
    }
    public function updateFactorStatus($status){
        $this->setKey();
        $db = new db();
        $db->db_query("UPDATE $this->tbl SET Status = '$status' WHERE Private_Key = '$this->Key'",1);
        return true;
    }

    public function updateFactorTrackingNumber($TrackNumber,$factor_num){
        $db = new db();
        $db->db_query("UPDATE $this->tbl SET Tracking_number = '$TrackNumber' WHERE Factor_number = '$factor_num'",1);
        return true;
    }

    public function updateEndedAt(){
        $this->setKey();
        $db = new db();
        $now = time();
        $db->db_query("UPDATE $this->tbl SET Ended_At = '$now' WHERE Private_Key = '$this->Key'",1);
        return true;
    }

    public function BurnFactor(){
        $this->setKey();
        $db = new db();
        $now = time();
        $db->db_query("UPDATE $this->tbl SET Ended_At = '$now' , Status = 'Burnt' WHERE Private_Key = '$this->Key'",1);
        return true;
    }
    public function getAll(){
        $db = new db();
        $sql = $db->db_query("SELECT * FROM $this->tbl",1);
        return $sql->fetchAll(\PDO::FETCH_ASSOC);
    }
    public function delete($num){
        $db = new db();
        $db->db_query("DELETE FROM $this->tbl WHERE Factor_number = '$num'",1);
        return true;
    }
}
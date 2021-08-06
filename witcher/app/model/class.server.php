<?php
namespace Model;

use Config\tables;

class server{
    public function getInfoRows(){
        $db = new db();
        $table = new tables();
        $tbl = $table->MAIN_TABLES['server_info'];
        $sql = $db->db_query("SELECT * FROM $tbl",1);
        return $sql->fetchAll(\PDO::FETCH_ASSOC);
    }
    public function updateStatement($query){
        $db = new db();
        $table = new tables();
        $tbl = $table->MAIN_TABLES['server_info'];
        $db->db_query("UPDATE $tbl SET $query",1);
        return true;
    }
}
<?php
namespace Model;
use Config\database;
use Config\tables;

class news {
    public function AddNews($array)
    {
        $preg = new preg();
        $tables = new tables();
        $news_table = $tables->MAIN_TABLES['news'];
        $db = new db();
        $value = "";
        $lastElement = end($array);
        if ($preg->text($array['Brief']) == 1 AND $preg->text($array['Contents']) == 1) {
            foreach ($array as $item => $key) {
                if ($key == $lastElement) {
                    $value .= $key;
                } else {
                    $value .= $key . ',';
                }
            }
            $db->db_query("INSERT INTO $news_table (Title,Image,Published_Date,Category_id,Comment,Status,Visitors,Brief,Contents) VALUE ($value)", 1);
        }
    }
    public function Latest($limit)
    {
        $db = new db();
        $tables = new tables();
        $news_table = $tables->MAIN_TABLES['news'];
        $preg = new preg();
        if ($preg->number($limit) == 1){
            $sql = $db->db_query("SELECT * FROM $news_table WHERE Status = 1 ORDER BY Published_Date DESC LIMIT $limit",1);
            $row = $sql->fetch(\PDO::FETCH_ASSOC);
            return $row;
        }else{
            return false;
        }
    }
    public function GetBy($sort,$limit){
        $db = new db();
        $db_info = new database();
        $table = new tables();
        try{
           //$sql = $db->db_query("SELECT COLUMN_NAME FROM information_schema.columns WHERE table_schema=$db_info->DB_CONFIG['DB_DEFAULT_NAME'] AND table_name=$table->MAIN_TABLES['news'] LIKE $sort",1);
           //$column = $sql->fetch(\PDO::FETCH_ASSOC);
            $sql_get = $db->db_query("SELECT * FROM $table->MAIN_TABLES['news'] ORDER BY $sort DESC LIMIT $limit",1);
            if ($sql_get->rowCount() > 0){
                $rows = $sql_get->fetch(\PDO::FETCH_ASSOC);
                return $rows;
            }else{
                return "Nothing was found from sorting at".$sort;
            }
        }catch (\PDOException $e){
            die($e);
        }
    }
    public function getCategory($by,$by_value){
        $db = new db();
        $table = new tables();
        $categories_tbl = $table->MAIN_TABLES['news_categories'];
        $news_tbl = $table->MAIN_TABLES['news'];
        $sql = $db->db_query("SELECT $news_tbl.*,$categories_tbl.Category_name FROM $categories_tbl LEFT JOIN $news_tbl ON $categories_tbl.Category_id = $news_tbl.Category_id WHERE $by = $by_value" ,1);
        $row = $sql->fetch(\PDO::FETCH_ASSOC);
        return $row;
    }
    public function DeleteNews($by,$value){
        $db = new db();
        $table = new tables();
        $news_tbl = $table->MAIN_TABLES['news'];
        $sql = $db->db_query("DELETE FROM $news_tbl WHERE $by = $value",1);
        if ($sql){
            return true;
        }
        return false;
    }
    public function SelectBy($by,$value,$limit){
        $db = new db();
        $table = new tables();
        $news_tbl = $table->MAIN_TABLES['news'];
        $sql = $db->db_query("SELECT * FROM $news_tbl WHERE $by = $value LIMIT $limit",1);
        if ($sql->rowCount() > 0){
            $row = $sql->fetch(\PDO::FETCH_ASSOC);
            return $row;
        }
        return "KHORD TOO SOORATET!";
    }
    public function SelectAll(){
        $db = new db();
        $table = new tables();
        $news_tbl = $table->MAIN_TABLES['news'];
        $sql = $db->db_query("SELECT * FROM $news_tbl",1);
        if ($sql->rowCount() > 0){
            $row = $sql->fetch(\PDO::FETCH_ASSOC);
            return $row;
        }
        return "KHORD TOO SOORATET!";
    }
}
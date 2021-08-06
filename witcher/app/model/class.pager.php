<?php
namespace Model;

class pager{
    public static function go_page($page){
        header_remove("location:".$page);
        header("location:".$page);
    }
    public static function redirect_page($time,$page){
        header("refresh:".$time.";"."url=".$page);
    }
    public function include_page($page){
        $path = $_SERVER['DOCUMENT_ROOT'];
        $path .= $page;
        include_once($path);
    }
    public static function refresh(){
        header("refresh:0;");
    }
}
<?php
namespace Model;

use Config\tables;

class noticer{
    private $notice_time;
    private $methods;
    private $category_name;
    private $audience_attr = array(
        'Active' => '1',

    );
    public function set_notice_time($time){
        return $this->notice_time = $time;
    }
    public function set_methods($methods){
        return $this->methods = $methods;
    }
    public function set_category_name($category_name){
        return $this->category_name = $category_name;
    }
    public function new_notice($competition_id){
        $db = new db();
        $table = new tables();
        $tbl = $table->MAIN_TABLES['Notice_Competition'];

    }
}
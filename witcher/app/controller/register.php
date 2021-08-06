<?php
namespace Controller;
use Model\pager;
use Model\user;
use Model\message;
use Model\preg;
use Model\db;
use Model\views;
class register extends views {
    public function start(){
        $views_array= array(parent::setPage("admin-panel/admin/signup.php"));
        parent::Show($views_array);
        exit();
    }
    public function register(){

    }
}
<?php
namespace Controller;
use Model\db;
use Model\news as Mnews;
use Config\tables;
use Model\pager;
use Model\user;
use Controller\login;
use Model\views;

class news extends views {
    private $mode;
    public function start(){
        $witcher = new \witcher();
        switch ($this->mode){
            case "Client_home":
                $news = $this->showLatest(4);
                $views_array= array(parent::setPage("news.php"));
                parent::Show($views_array);
                return $news;
                break;
            case "Client_blog":
                $news = $this->viewsClients(10);
                $views_array= array(parent::setPage("blog.php"));
                parent::Show($views_array);
                return $news;
                break;
            case "Admin_panel":
                $user = new user();
                $permission = $user->user_get_permission();
                if ($permission != false){
                    if ($permission['Admin'] == 1){
                        $news = new \Model\news();
                        $row = $news->SelectAll();
                        $views_array = array(parent::setPage("admin/news.php"));
                        parent::Show($views_array);
                        return $row;
                    }else{
                        parent::ErrorHandler("403");
                    }
                }else{
                    parent::ErrorHandler("404");
                }
                break;
        }
    }
    public function setMode($mode){
        $this->mode = $mode;
        return $this->mode;
    }
    private function viewsClients($limit){
        $news = new Mnews();
        return $news->SelectBy('Status',1,$limit);
    }
    private function showLatest($limit){
        $news = new Mnews();
        return $news->Latest($limit);
    }
}
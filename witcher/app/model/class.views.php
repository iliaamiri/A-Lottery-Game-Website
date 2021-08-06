<?php
namespace Model;

class views {
    private $header;
    private $footer;
    private $page;
    private $theme;
    private $title;
    private static $data;
    public function setTitle($title){
        return $this->title = $title;
    }
    public function setHeader($link){
        $this->header = $link;
        return $this->header;
    }
    public function setFooter($link){
        $this->footer = $link;
        return $this->footer;
    }
    public function setPage($link){
        $this->page = $link;
        return $this->page;
    }
    public function setTheme($link){
        $this->theme = $link;
        return $this->theme;
    }
    public static function setData($array){
        self::$data = $array;
    }
    public static function getData(){
        return self::$data;
    }
    function Show($array){
        $stat = array();
        $witcher = new \witcher();
        foreach ($array as $views){
            $fullpath = $witcher->root()."witcher/view/".$views;
            if (file_exists($fullpath)){
                $witcher->requireView($views);
                $stat = array_merge([$views => "Exists"],$stat);
            }else{
                $stat = array_merge([$views => "Does not exist."],$stat);
            }
        }
        return $stat;
    }
    function ErrorHandler($code){
        switch ($code){
            case "404":
               $array = array($this->setPage("errors/404.php"));
               return $this->Show($array);
               break;
            case "403":
                $array = array($this->setPage("errors/403.php"));
                return $this->Show($array);
                break;
        }
    }
}
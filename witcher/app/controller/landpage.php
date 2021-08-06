<?php
namespace Controller;

use Model\message;
use Model\pager;
use Model\preg;
use Model\views;

class landpage extends views {
    private $landpages_path;
    public function start(){
        $witcher = new \witcher();
        $this->setLandpages_Path($witcher->root()."witcher/view/landpages");
        $landpages_values = $this->get_landpage_id();
        if (isset($_GET['SEt_Landpage']) AND !isset($_GET['DELETe_Landpage'])){
            $preg = new preg();
            if ($preg->number($_GET['SEt_Landpage']) == 1){
                $setting_landpage_response = $this->set_landpage($_GET['SEt_Landpage']);
                if ($setting_landpage_response == false){
                    pager::redirect_page('0',"profile?parts=landingpages");
                    message::msg_alert("This landpage doesnot exist.");
                    exit();
                }else{
                    pager::redirect_page('0',"profile?parts=landingpages");
                    message::msg_alert("Your Landpage has been set now! do you want to see it?! Are khodet boro bebing goshade badbakht");
                    exit();
                }
            }else{
                pager::redirect_page('0',"profile?parts=landingpages");
                message::msg_alert("Invalid Id");
                exit();
            }
        }elseif (isset($_GET['DELETe_Landpage']) AND !isset($_GET['SEt_Landpage'])){
            $preg = new preg();
            if ($preg->number($_GET['DELETe_Landpage']) == 1){
                $deleting_landpage_response = $this->Delete_Landpages($_GET['DELETe_Landpage']);
                if ($deleting_landpage_response == false){
                    //pager::redirect_page('0',"profile?parts=landingpages");
                    message::msg_alert("This landpage doesnot exist.");
                    exit();
                }
               // pager::redirect_page('0',"profile?parts=landingpages");
                    message::msg_alert("This landpage has been deleted BY YOU!");
                    //pager::refresh();
            }else{
                //pager::redirect_page('0',"profile?parts=landingpages");
                message::msg_alert("Invalid Id");
                exit();
            }
        }
        return $landpages_values;
    }
    public function Delete_Landpages($id){
        $path = $this->landpages_path."/landpage.".$id.".index.php";
        if (file_exists($path)){
            unlink($path);
            return true;
        }else{
            return false;
        }
    }
    public function get_Files_Names(){
        $scaned_files = scandir($this->landpages_path);
        //return $scaned_files;
        $result = array();
        foreach ($scaned_files as $file){
            $a = explode(".",$file);
            if ($a[0] == "landpage" AND end($a) == "php"){
                $result = array_merge(array($file),$result);
            }
        }
        return $result;
    }
    public function setLandpages_Path($path){
        return $this->landpages_path = $path;
    }
    private function get_landpage_id(){
        $landpages_names = $this->get_Files_Names();
        $id = "";
        $end_of_landpages_names_array = end($landpages_names);
        foreach ($landpages_names as $paths){
            $paths_e = explode(".",$paths);
            if ($paths == $end_of_landpages_names_array){
                $id .= $paths_e[1];
            }else{
                $id .= $paths_e[1].".";
            }
        }
        $result = explode(".",$id);
        return $result;
    }
    private function set_landpage($id){
        $ids = $this->get_landpage_id();
        $i = 0;
        foreach ($ids as $checker){
            if ($id == $checker){
                $i = 1;
            }
        }
        if ($i == 1){
            $witcher = new \witcher();
            $index_path = $witcher->root()."witcher/view/index.php";
            if (file_exists($index_path)){
                $new_name_for_old_landpage = "landpage.".rand().".index.php";
                rename($index_path,$this->landpages_path."/".$new_name_for_old_landpage);
                rename($this->landpages_path."/"."landpage.".$id.".index.php",$index_path);
                return true;
            }
        }else{
            return false;
        }
    }
}
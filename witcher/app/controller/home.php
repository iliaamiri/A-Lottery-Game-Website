<?php
namespace Controller;

use Model\db;
use Model\interfaces;
use Model\server;
use Model\views;
use Config\tables;
class home extends views {
    public function start(){
        $array = array(parent::setHeader("layouts/header.php"),parent::setPage("layouts/slider.php"),parent::setPage("index.php")
        ,parent::setFooter("layouts/footer.php"));
        if (isset($_GET['parts'])){
            switch ($_GET['parts']){
                case "faq":
                    $array = [parent::setHeader("layouts/header.php"),parent::setPage("layouts/home_head.php"),parent::setPage("faq.php"),parent::setFooter("layouts/footer.php")];
                    break;
                case "how-to-play":
                    $array = [parent::setHeader("layouts/header.php"),parent::setPage("layouts/home_head.php"),parent::setPage("how-to-play.php"),parent::setFooter("layouts/footer.php")];
                    break;
            }
        }
        parent::Show($array);
    }
    private function getInformatons(){
        $db = new db();
        $table = new tables();
        $information_tbl = $table->MAIN_TABLES['information'];
        $sql = $db->db_query("SELECT * FROM $information_tbl WHERE Status = 1",1);
        if ($sql->rowCount() > 0 ){
            $row = $sql->fetch(\PDO::FETCH_ASSOC);
            return $row;
            exit();
        }
        return "Didn't found anything.";
    }
    private function getNews(){

    }
    public function getDatas(){
        $comp = new \Model\competition();
        $server = new \Model\server();
        $playable_list = $comp->Check_Competitions()['FO_started'];
        $notstrated_list = $comp->Check_Competitions()['FO_notstarted'];
        $ended = $comp->Check_Competitions()['FO_ends'];
        $datas = [
            'Playable_games' => $playable_list,
            'Not_Started' => $notstrated_list,
            'server_info' => $server->getInfoRows()[0],
            'Ended' => $ended,
            'Latest' => $playable_list
        ];
        return $datas;
    }
    public function getSliders(){
        $interfaces = new interfaces();
        $sliders = $interfaces->GetSlidersByStatement("WHERE Active_Status = '1'");
        return $sliders;
    }
}
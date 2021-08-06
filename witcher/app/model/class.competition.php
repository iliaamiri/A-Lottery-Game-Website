<?php
namespace Model;

use Config\server;
use Config\tables;

class competition{
    private $competition_id;
    private $starts_at;
    private $ends_at;
    private $attributes = ['Active_Status','Tickets_Price','Payment_Methods','User_Limitation','Winner_Num','Notice_For_Participants','Details'];
    public function count_participants($id){
        $db = new db();
        $table = new tables();
        $tbl = array($table->MAIN_TABLES['Competition_tbl'],$table->MAIN_TABLES['Competition_Attributes_tbl'],$table->MAIN_TABLES['Winners_tbl'],$table->MAIN_TABLES['Notice_Competition'],$table->MAIN_TABLES['Tickets_tbl']);
        $sql = $db->db_query("SELECT Owner_Email AS Participants  FROM $tbl[4] WHERE Competition_Id = '$id'",1);
        $row = $sql->fetchAll(\PDO::FETCH_COLUMN);
        $count_participants = array_unique($row);
        return count($count_participants);
    }
    public function set_Competition_Id($manually = 0,$value = ""){
        if ($manually == 1 ){
            $this->competition_id = $value;
        }elseif ($manually == 0 ){
            $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $charactersLength = strlen($characters);
            $randomString = '';
            for ($i = 0; $i < 7; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }
            $Id = $randomString;
            return $this->competition_id = $Id;
        }
    }
    public function set_Starts_At_AND_Ends_At($start_time,$end_time){
        $preg = new preg();
        if ($preg->number($start_time) == 1 AND $preg->number($end_time)) {
            $this->starts_at = $start_time;
            $this->ends_at   = $end_time;
            return ['starts_at' => $this->starts_at,'ends_at' => $this->ends_at];
        }else {
            return false;
        }
    }
    public function getFrom_Competition_tbl_by($id){
        $db = new db();
        $tables = new tables();
        $tbl_name = $tables->MAIN_TABLES['Competition_tbl'];
        $sql = $db->db_query("SELECT * FROM $tbl_name WHERE Competition_Id = '$id'",1);
        return $sql->fetch(\PDO::FETCH_ASSOC);
    }
    public function getFrom_Competition_attributes_by($id){
        $db = new db();
        $tables = new tables();
        $tbl_name = array($tables->MAIN_TABLES['Competition_tbl'],$tables->MAIN_TABLES['Competition_Attributes_tbl']);
        $sql = $db->db_query("SELECT $tbl_name[1].* FROM $tbl_name[1] LEFT JOIN $tbl_name[0] ON $tbl_name[0].Competition_Id = $tbl_name[1].Competition_Id WHERE $tbl_name[1].Competition_Id = '$id'",1);
        if ($sql->rowCount() == 0){
            return false;
        }
        return $sql->fetchAll(\PDO::FETCH_ASSOC);
    }
    public function Check_Competitions()
    {
        $db = new db();
        $tables = new tables();
        $Competition_tbls_names = array($tables->MAIN_TABLES['Competition_tbl'], $tables->MAIN_TABLES['Competition_Attributes_tbl']);
        $now = time();
        $Query_All_Competitions = $db->db_query("SELECT $Competition_tbls_names[0].*,$Competition_tbls_names[1].* FROM $Competition_tbls_names[0] INNER JOIN $Competition_tbls_names[1] ON $Competition_tbls_names[0].Competition_Id = $Competition_tbls_names[1].Competition_Id", 1);
        $Query_Active_Competitions = $db->db_query("SELECT $Competition_tbls_names[0].*,$Competition_tbls_names[1].* FROM $Competition_tbls_names[0] INNER JOIN $Competition_tbls_names[1] ON $Competition_tbls_names[0].Competition_Id = $Competition_tbls_names[1].Competition_Id WHERE $Competition_tbls_names[1].Active_Status = 1",1);
        $Query_NotStarted_Competitions = $db->db_query("SELECT $Competition_tbls_names[0].*,$Competition_tbls_names[1].* FROM $Competition_tbls_names[0] INNER JOIN $Competition_tbls_names[1] ON $Competition_tbls_names[0].Competition_Id = $Competition_tbls_names[1].Competition_Id WHERE $Competition_tbls_names[0].Starts_At > $now AND $Competition_tbls_names[1].Active_Status = '1'",1);
        $Query_Ends_Competition = $db->db_query("SELECT $Competition_tbls_names[0].*,$Competition_tbls_names[1].* FROM $Competition_tbls_names[0] INNER JOIN $Competition_tbls_names[1] ON $Competition_tbls_names[0].Competition_Id = $Competition_tbls_names[1].Competition_Id WHERE $Competition_tbls_names[0].Ends_At < $now ",1);
        $Query_Ends_active_Competition = $db->db_query("SELECT $Competition_tbls_names[0].*,$Competition_tbls_names[1].* FROM $Competition_tbls_names[0] INNER JOIN $Competition_tbls_names[1] ON $Competition_tbls_names[0].Competition_Id = $Competition_tbls_names[1].Competition_Id WHERE $Competition_tbls_names[0].Ends_At < $now AND $Competition_tbls_names[1].Active_Status = '1'",1);
        $Started = $db->db_query("SELECT $Competition_tbls_names[0].*,$Competition_tbls_names[1].* FROM $Competition_tbls_names[0] INNER JOIN $Competition_tbls_names[1] ON $Competition_tbls_names[0].Competition_Id = $Competition_tbls_names[1].Competition_Id WHERE $Competition_tbls_names[0].Starts_At < $now AND $now < $Competition_tbls_names[0].Ends_At",1);

        $Actives_Numbers = $Query_Active_Competitions->rowCount();
        $All_Numbers = $Query_All_Competitions->rowCount();
        $Started_Num = $Started->rowCount();
        $Not_Started_yet = $Query_NotStarted_Competitions->rowCount();
        $Ends_Num = $Query_Ends_Competition->rowCount();

        $rows_Nstarted = $Query_NotStarted_Competitions->fetchAll(\PDO::FETCH_ASSOC);
        $rows_Started = $Started->fetchAll(\PDO::FETCH_ASSOC);
        $rows_Ends = $Query_Ends_Competition->fetchAll(\PDO::FETCH_ASSOC);
        $rows_Ends_actives = $Query_Ends_active_Competition->fetchAll(\PDO::FETCH_ASSOC);
        $results = array(
            'Number_of_active_competitions' => $Actives_Numbers,
            'Number_of_all_competitions' => $All_Numbers,
            'Number_of_Not_started_competitions' => $Not_Started_yet,
            'Number_of_Ends_competitions' => $Ends_Num,
            'Number_of_Started_competitions' => $Started_Num,

            'FO_notstarted' => $rows_Nstarted,
            'FO_started' => $rows_Started,
            'FO_ends' => $rows_Ends,
            'FO_ends_actives' => $rows_Ends_actives
        );
        return $results;
    }
    public function new_competition($competitions_tbl_Array,$competitions_attributes_Array,$winners_tbl_Array){
        $Array1 = $competitions_tbl_Array;
        $Array2 = $competitions_attributes_Array;
        $Array3 = $winners_tbl_Array;
        $db = new db();
        $tables = new tables();
        $tbl = array($tables->MAIN_TABLES['Competition_tbl'],$tables->MAIN_TABLES['Competition_Attributes_tbl'],$tables->MAIN_TABLES['Winners_tbl']);
        $preg = new preg();
        try{
            if ($preg->username($Array1['Started_by']) != 1 OR
                $preg->number($Array2['Winner_Num']) != 1 OR
                $preg->number($Array2['Notice_for_participants']) != 1 OR
                $preg->number($Array2['Tickets_price']) != 1 OR
                $preg->number($Array2['User_Limitation']) != 1 ){
                throw new \Exception("Invalid Values");
            }
            $eArray2=end($Array2);
            $value2 = "";
            foreach ($Array2 as $key=>$value) {
                if ('User_Limitation' == $key) {
                    $value2 .= "'" . $value . "'";
                } else {
                    $value2 .= "'" . $value . "',";
                }
            }
            try {
                //return "INSERT INTO $tbl[1] (Competition_Id,Active_Status,Winners_Num,Notice_for_participants,Tickets_price,Payment_Methods,User_Limitation) VALUE ('$this->competition_id',$value2)";
                $db->db_query("INSERT INTO $tbl[0] (Competition_Id,Starts_At,Ends_At,Started_by,Canceled_At,Image_src,Title) VALUE ('$this->competition_id','$this->starts_at','$this->ends_at','$Array1[Started_by]',NULL ,'$Array1[Image_src]','$Array1[Title]')", 1);
                $db->db_query("INSERT INTO $tbl[1] (Competition_Id,Active_Status,Winners_Num,Notice_for_participants,Tickets_price,Payment_Methods,User_Limitation) VALUE ('$this->competition_id',$value2)", 1);
                $rank_id = 1;
                foreach ($Array3 as $key => $value) {
                    $db->db_query("INSERT INTO $tbl[2] (Competition_Id,Rank_Num,reward) VALUE ('$this->competition_id','$rank_id','$value')", 1);
                    $rank_id++;
                }
                return true;
            }catch (\PDOException $p){
                die($p);
            }
        }catch (\Exception $e){
            return $e;
        }
    }
    public function cancel_competition($id){
        $db = new db();
        $tables = new tables();
        $preg = new preg();
        if ($preg->custom('/^[A-Z0-9]*$/i',$id) != 1){
            return false;
        }
        $tbl = array($tables->MAIN_TABLES['Competition_tbl'],$tables->MAIN_TABLES['Competition_Attributes_tbl']);
        $row = $this->getFrom_Competition_tbl_by($id);
        $row2 = $this->getFrom_Competition_attributes_by($id);
        if (time() < $row['Starts_At']){
            if ($row2[0]['Active_Status'] == 1){
                $now = time();
                $db->db_query("UPDATE $tbl[0] SET Canceled_At = $now WHERE Competition_Id = '$id'",1);
                $db->db_query("UPDATE $tbl[1] SET Active_Status = 0 WHERE Competition_Id = '$id'",1);
                return true;
            }else {
                return false;
            }
        }else {
            return false;
        }
    }
    public function delete_competition($id){
        $db = new db();
        $witcher = new \witcher();
        $tables = new tables();
        $tbl = array($tables->MAIN_TABLES['Competition_tbl'],$tables->MAIN_TABLES['Competition_Attributes_tbl'],$tables->MAIN_TABLES['Winners_tbl']);
        $sql = $db->db_query("SELECT * FROM $tbl[0] WHERE Competition_Id = '$id'",1);
        $row = $sql->fetch(\PDO::FETCH_ASSOC);
        $get_image_src = explode("/",$row['Image_src']);
        $get_image_src = end($get_image_src);
        if ($row['Image_src'] != $this->getDefaultIcon()){
            unlink($witcher->root()."public_html/img/icons/".$get_image_src);
        }
        $db->db_query("DELETE FROM $tbl[0] WHERE Competition_Id = '$id'",1);
        $db->db_query("DELETE FROM $tbl[1] WHERE Competition_Id = '$id'",1);
        $db->db_query("DELETE FROM $tbl[2] WHERE Competition_Id = '$id'",1);
        return true;
    }
    public function expire_competition($competition_id){
        $db = new db();
        $table = new tables();
        $tbl = $table->MAIN_TABLES['Competition_Attributes_tbl'];
        $sql = $db->db_query("UPDATE $tbl SET Active_Status = 0 WHERE Competition_Id = '$competition_id'",1);
        return $sql;
    }
    public function add_notice($competition_id,$text,$time,$method){
        $db = new db();
        $preg = new preg();
        $tables = new tables();
        $tbl = $tables->MAIN_TABLES['Notice_Competition'];
        if ($preg->number($time) != 1 OR $preg->alphabet($competition_id) != 1 OR $preg->alphabet($method,1) != 1 ){
            return false;
        }
        $sql = $db->db_query("INSERT INTO $tbl (Competition_Id,Notice_Message,Notice_Time,Method) VALUE ('$competition_id',:text,'$time','$method')");
        $sql->bindParam(':text',$text,\PDO::PARAM_STR);
        $sql->execute();
        return true;
    }
    public function pull_notice_trigger($competition_id){
        $user = new user();
        $db = new db();
        $table = new tables();
        $tbl = $table->MAIN_TABLES['Notice_Competition'];
        $active_users = $user->getActiveUsers();
        $sql = $db->db_query("SELECT * FROM $tbl WHERE Competition_Id = '$competition_id'",1);
        $row = $sql->fetchAll(\PDO::FETCH_ASSOC);
        //$message = $row['Notice_Messsage'];
        /*if ($row['Method'] == "Email"){
            $emails = $active_users['Email'];
            // Message via Email
        }elseif ($row['Method'] == "Text"){
            // MEssage via Textmessage API
        }*/
    }
    public function getNearest_competition(){
        $db = new db();
        $table = new tables();
        $now = time();
        $tbl = array($table->MAIN_TABLES['Competition_tbl'],$table->MAIN_TABLES['Competition_Attributes_tbl']);
        $sql = $db->db_query("SELECT MIN(Starts_At) as Min FROM $tbl[0] WHERE $now < Starts_At",1);
        $row = $sql->fetch(\PDO::FETCH_ASSOC);
        $sql = $db->db_query("SELECT $tbl[0].*,$tbl[1].* FROM $tbl[1] LEFT JOIN $tbl[0] ON $tbl[0].Competition_Id = $tbl[1].Competition_Id WHERE $tbl[0].Starts_At = '$row[Min]' AND $tbl[1].Active_Status = '1'",1);
        return $row = $sql->fetchAll(\PDO::FETCH_ASSOC);
    }
    public function getLast_competition()
    {
        $db = new db();
        $table = new tables();
        $now = time();
        $tbl = array($table->MAIN_TABLES['Competition_tbl'], $table->MAIN_TABLES['Competition_Attributes_tbl']);
        $sql = $db->db_query("SELECT MAX(Ends_At) as Max FROM $tbl[0] WHERE $now > Ends_At", 1);
        $row = $sql->fetch(\PDO::FETCH_ASSOC);
        $sql = $db->db_query("SELECT $tbl[0].*,$tbl[1].* FROM $tbl[1] LEFT JOIN $tbl[0] ON $tbl[0].Competition_Id = $tbl[1].Competition_Id WHERE Ends_At = '$row[Max]' AND $tbl[1].Active_Status = '1'", 1);
        return $row = $sql->fetchAll(\PDO::FETCH_ASSOC);
    }
    public function getCompetitions_InLimitation($limit_num,$cond = ""){
        $db = new db();
        $table = new tables();
        $tbl = array($table->MAIN_TABLES['Competition_tbl'],$table->MAIN_TABLES['Competition_Attributes_tbl']);
        $sql = $db->db_query("SELECT $tbl[0].* , $tbl[1].* FROM $tbl[0] INNER JOIN $tbl[1] ON $tbl[1].Competition_Id = $tbl[0].Competition_Id $cond LIMIT $limit_num",1);
        return $sql->fetchAll(\PDO::FETCH_ASSOC);
    }
    public function getCompetition_Status($id){
        $competition_info = $this->getFrom_Competition_tbl_by($id);
        $attributes = $this->getFrom_Competition_attributes_by($id);
        $attributes = $attributes[0];
        $Starts_At = $competition_info['Starts_At'];
        $Ends_At = $competition_info['Ends_At'];
        $status = [];
        if (time() < $Starts_At){
            $status = ['status' => 'Not-Begin'];
        }elseif (time() > $Starts_At AND time() < $Ends_At){
            $status = ['status' => 'In-Progress'];
        }elseif (time() > $Ends_At){
            $status = ['status' => 'Expired'];
        }
        $all_statuses = array_merge($status,
        [
            'active_status' => $attributes['Active_Status'],
            'winners_number'=> $attributes['Winners_Num'],
            'notice'        => $attributes['Notice_for_participants'],
            'ticket_price'  => $attributes['Tickets_price'],
            'payment_methods'=>$attributes['Payment_Methods'],
            'user_limitation'=>$attributes['User_Limitation'],
            'starter'       => $competition_info['Started_by'],
            'canceled_at'   => $competition_info['Canceled_At'],
            'image_src'     => $competition_info['Image_src']
        ]);
        return $all_statuses;
    }
    public function getDefaultIcon(){
        $server = new server();
        $port = $server->INFO['Port'];
        $address = $server->INFO['Domain'];
        return $port."://".$address."/img/icon.png";
    }
    public function add_extraTime($competition_id,$time_to_plus_oldone){
        $db = new db();
        $table = new tables();
        $tbl = $table->MAIN_TABLES['Competition_tbl'];
        $row = $this->getFrom_Competition_tbl_by($competition_id);
        $oldTime = $row['Ends_At'];
        $newTime = $oldTime + $time_to_plus_oldone;
        $db->db_query("UPDATE $tbl SET Ends_At = $newTime WHERE Competition_Id = '$competition_id'",1);
    }
    public function change_competition_status($competition_id){
        $db = new db();
        $table = new tables();
        $tbl = array($table->MAIN_TABLES['Competition_tbl'],$table->MAIN_TABLES['Competition_Attributes_tbl']);
        $row = $this->getFrom_Competition_attributes_by($competition_id);
        if ($row['Active_Status'] == 1){
            $db->db_query("UPDATE $tbl[1] SET Active_Status = 0 WHERE Competition_Id = '$row[Competition_Id]'",1);
            return ['status' => 0];
        }elseif ($row['Active_Status'] == 0){
            $db->db_query("UPDATE $tbl[1] SET Active_Status = 1 WHERE Competition_Id = '$row[Competition_Id]'",1);
            return ['status' => 1];
        }
    }
    public function exists_compet($id){
        $db = new db();
        $table = new tables();
        $tbl = $table->MAIN_TABLES['Competition_tbl'];
        $sql = $db->db_query("SELECT * FROM $tbl WHERE Competition_Id = '$id'",1);
        if ($sql->rowCount() > 0){
            return true;
        }else{
            return false;
        }
    }
    public function get_Time_to_start($id){
        $db = new db();
        $table = new tables();
        $tbl = $table->MAIN_TABLES['Competition_tbl'];
        $time = time();
        $sql = $db->db_query("SELECT * FROM $tbl WHERE Competition_Id = '$id' AND Starts_At > $time",1);
        if ($sql->rowCount() > 0){
            $row = $sql->fetch(\PDO::FETCH_ASSOC);
            return $row['Starts_At'] - $time;
        }else{
            return false;
        }
    }
    public function is_this_newest($id){
        $db = new db();
        $table = new tables();
        $tbl = $table->MAIN_TABLES['Competition_tbl'];
        $sql = $db->db_query("SELECT MAX(Starts_At) as max_start FROM $tbl",1);
        if ($sql->rowCount() > 0){
            return $sql->fetch(\PDO::FETCH_ASSOC);
        }else{
            return false;
        }
    }
    public function fill_result($id,$result){
        $db = new db();
        $table = new tables();
        $tbl = $table->MAIN_TABLES['Competition_tbl'];
        $db->db_query("UPDATE $tbl SET Result = '$result' WHERE Competition_Id = '$id'",1);
    }
}
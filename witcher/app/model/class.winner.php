<?php
namespace Model;

use Config\tables;

class winner{
    /*
     * $c_id MUST be define if you want to have a good experience in your application :))
     *
     */
    private $c_id;
    public function set_c_id($id){
        return $this->c_id = $id;
    }
    /*
     *
     * set $c_id to run these functions below
     *
     */
    public function count_winners(){
        $comp = new competition();
        if ($comp->exists_compet($this->c_id) == true){
            $db = new db();
            $table = new tables();
            $tbl = $table->MAIN_TABLES['Winners_tbl'];
            $sql = $db->db_query("SELECT * FROM $tbl WHERE Competition_Id = '$this->c_id'",1);
            return $sql->rowCount();
        }else {
            return false;
        }
    }
    /*
     *
     * set $c_id to run these functions below
     *
     */
    public function biggest_reward(){
        // just returning big_reward value , not whole of the row.
        $db = new db();
        $table = new tables();
        $tbl = $table->MAIN_TABLES['Winners_tbl'];
        $sql = $db->db_query("SELECT MAX(reward) AS big_reward FROM $tbl WHERE Competition_Id = '$this->c_id'",1);
        return $sql->fetch(\PDO::FETCH_ASSOC)['big_reward'];
    }
    public function smallest_reward(){
        // just returning small_reward value , not whole of the row.
        $db = new db();
        $table = new tables();
        $tbl = $table->MAIN_TABLES['Winners_tbl'];
        $sql = $db->db_query("SELECT MIN(reward) AS small_reward FROM $tbl WHERE Competition_Id = '$this->c_id'",1);
        return $sql->fetch(\PDO::FETCH_ASSOC)['small_reward'];
    }
    public function get_winner_users(){
        // just returning winner_users value , not whole of the row.
        $db = new db();
        $table = new tables();
        $tbl = $table->MAIN_TABLES['Winners_tbl'];
        $sql = $db->db_query("SELECT Winner FROM $tbl WHERE Competition_Id = '$this->c_id'",1);
        return $sql->fetchAll(\PDO::FETCH_COLUMN);
    }
    public function ranksAndrewards_winners(){
        $db = new db();
        $table = new tables();
        $tbl = $table->MAIN_TABLES['Winners_tbl'];
        $sql = $db->db_query("SELECT * FROM $tbl WHERE Competition_Id = '$this->c_id'",1);
        $rows = $sql->fetchAll(\PDO::FETCH_ASSOC);
        $result = array();
        foreach ($rows as $row){
            $result = array_merge($result,array($row['Rank_Num'] => $row['reward']));
        }
        return $result;
    }
    public function findMeInWinners($email){
        $db = new db();
        $table = new tables();
        $tbl = $table->MAIN_TABLES['Winners_tbl'];
        $sql = $db->db_query("SELECT * FROM $tbl WHERE Competition_Id = '$this->c_id' AND Winner = '$email'",1);
        if ($sql->rowCount() > 0){
            return $sql->fetchAll(\PDO::FETCH_ASSOC);
        }else{
            return false;
        }
    }
    public function all_about_winners(){
        $db = new db();
        $table = new tables();
        $tbl = $table->MAIN_TABLES['Winners_tbl'];
        $sql = $db->db_query("SELECT * FROM $tbl WHERE Competition_Id = '$this->c_id'",1);
        return $sql->fetchAll(\PDO::FETCH_ASSOC);
    }
    public function update_reward($rank_number,$new_reward){
        $db = new db();
        $table = new tables();
        $tbl = $table->MAIN_TABLES['Winners_tbl'];
        $sql = $db->db_query("UPDATE $tbl SET reward = '$new_reward' WHERE Competition_Id = '$this->c_id' AND Rank_Num = '$rank_number'",1);
        return $sql;
    }
    public function set_winner($rank_number,$winner_id){
        $db = new db();
        $table = new tables();
        $tbl = $table->MAIN_TABLES['Winners_tbl'];
        $sql = $db->db_query("UPDATE $tbl SET Winner = '$winner_id' WHERE Competition_Id = '$this->c_id' AND Rank_Num = '$rank_number'",1);
        return $sql;
    }
    public function add_rank($reward){
        $db = new db();
        $table = new tables();
        $tbl = $table->MAIN_TABLES['Winners_tbl'];
        if ($this->count_winners() > 0){
            $new_rank_num = $this->count_winners() + 1;
        }else {
            $new_rank_num = 1;
        }
        $sql = $db->db_query("INSERT INTO $tbl (Competition_Id,Rank_Num,reward) VALUE ('$this->c_id','$new_rank_num',:reward)");
        $sql->bindParam(':reward',$reward,\PDO::PARAM_INT);
        $sql->execute();
        return $sql;
    }
    public function total_rewards(){
        $db = new db();
        $table = new tables();
        $tbl = $table->MAIN_TABLES['Winners_tbl'];
        $all_winners = $this->all_about_winners();
        $result = 0;
        foreach ($all_winners as $reward){
            $reward = $reward['reward'];
            $result = $result + $reward;
        }
        return $result;
    }
    public function having_winner(){
        $db = new db();
        $table = new tables();
        $tbl = $table->MAIN_TABLES['Winners_tbl'];
        $all_winners = $this->all_about_winners();
        if ($all_winners[0]['Winner'] != null)
            return true;
        else
            return false;
    }

}
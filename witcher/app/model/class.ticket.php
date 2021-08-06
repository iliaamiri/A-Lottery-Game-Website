<?php
namespace Model;

use Config\tables;

class ticket{
    private $Ticket_Key;
    private $Owner_Email;
    private $Competition_Id;
    private $Live_Status;
    public function set_competition_id($id){
        return $this->Competition_Id = $id;
    }
    public function set_owner($email){
        return $this->Owner_Email = $email;
    }
    public function set_live_status($int){
        return $this->Live_Status = $int;
    }
    public function new_ticket(){
        $db = new db();
        $table = new tables();
        $tbl = $table->MAIN_TABLES['Tickets_tbl'];
        $Owner = $this->Owner_Email;
        $Ticket_Key = $this->set_ticket_key();
        $now = time();
        $sql = $db->db_query("INSERT INTO $tbl (Competition_Id,Owner_Email,Live_Status,Ticket_Key,Created_At) VALUE ('$this->Competition_Id',:owner,'$this->Live_Status','$Ticket_Key','$now')");
        $sql->bindParam(':owner',$Owner,\PDO::PARAM_STR);
        $sql->execute();
        return true;
    }
    private function set_ticket_key($manually = 0,$key_value = ""){
        $id = $this->Competition_Id;
        if ($manually == 1 ){
            return $key_value;
        }elseif($manually == 0 ) {
            $a = sha1(md5($id));
            $b = md5(sha1(md5($a)));
            $c = sha1(md5("5te3n0zaHUr"));
            return $this->Ticket_Key = sha1(md5(sha1($b.$c)));
        }
    }
    public function select_random($limit){
        $db = new db();
        $table = new tables();
        $tbl = $table->MAIN_TABLES['Tickets_tbl'];
        $Ticket_Key = $this->set_ticket_key();
        $sql = $db->db_query("SELECT Owner_Email FROM $tbl WHERE Live_Status = 1 AND Ticket_Key = '$Ticket_Key' ORDER BY RAND() LIMIT $limit",1);
        return $sql->fetchAll(\PDO::FETCH_COLUMN);
    }
    public function count_burnt_tickets(){
        $db = new db();
        $table = new tables();
        $tbl = $table->MAIN_TABLES['Tickets_tbl'];
        $sql = $db->db_query("SELECT * FROM $tbl WHERE Live_Status = 0",1);
        return count($sql->fetchAll(\PDO::FETCH_ASSOC));
    }
    public function count_live_tickets(){
        $db = new db();
        $table = new tables();
        $tbl = $table->MAIN_TABLES['Tickets_tbl'];
        $sql = $db->db_query("SELECT * FROM $tbl WHERE Live_Status = 1",1);
        return count($sql->fetchAll(\PDO::FETCH_ASSOC));
    }
    public function get_tickets_data_of_competition(){
        $db = new db();
        $table = new tables();
        $tbl = $table->MAIN_TABLES['Tickets_tbl'];
        $sql = $db->db_query("SELECT * FROM $tbl WHERE Competition_Id = '$this->Competition_Id'",1);
        return $sql->fetchAll(\PDO::FETCH_ASSOC);
    }
    public function get_my_tickets_data_of_competition($add_where = ""){
        $db = new db();
        $table = new tables();
        $tbl = $table->MAIN_TABLES['Tickets_tbl'];
        $this->set_ticket_key();
        $sql = $db->db_query("SELECT * FROM $tbl WHERE Competition_Id = '$this->Competition_Id' AND Owner_Email = '$this->Owner_Email' AND Ticket_Key = '$this->Ticket_Key' $add_where",1);
        return $sql->fetchAll(\PDO::FETCH_ASSOC);
    }
    public function get_owned_tickets($email){
        $db = new db();
        $table = new tables();
        $tbl = $table->MAIN_TABLES['Tickets_tbl'];
        $this->set_owner($email);
        $sql = $db->db_query("SELECT * FROM $tbl WHERE Owner_Email = '$this->Owner_Email'",1);
        return $sql->fetchAll(\PDO::FETCH_ASSOC);
    }
    public function get_tickets_data_of_custom_competition($id){
        $db = new db();
        $table = new tables();
        $tbl = $table->MAIN_TABLES['Tickets_tbl'];
        $sql = $db->db_query("SELECT * FROM $tbl WHERE Competition_Id = '$id'",1);
        return $sql->fetchAll(\PDO::FETCH_ASSOC);
    }
    public function count_tickets_current_competition(){
        $db = new db();
        $table = new tables();
        $tbl = $table->MAIN_TABLES['Tickets_tbl'];
        $sql = $db->db_query("SELECT * FROM $tbl WHERE Competition_Id = '$this->Competition_Id'",1);
        return count($sql->fetchAll(\PDO::FETCH_ASSOC));
    }
    public function count_users_tickets_current_competition(){
        $db = new db();
        $table = new tables();
        $tbl = $table->MAIN_TABLES['Tickets_tbl'];
        $this->set_ticket_key();
        $sql = $db->db_query("SELECT * FROM $tbl WHERE Competition_Id = '$this->Competition_Id' AND Owner_Email = '$this->Owner_Email' AND Ticket_Key = '$this->Ticket_Key'",1);
        return count($sql->fetchAll(\PDO::FETCH_ASSOC));
    }
    public function get_users_tickets_current_competition(){
        $db = new db();
        $table = new tables();
        $tbl = $table->MAIN_TABLES['Tickets_tbl'];
        $sql = $db->db_query("SELECT Owner_Email FROM $tbl WHERE Competition_Id = '$this->Competition_Id'",1);
        $rows = $sql->fetchAll(\PDO::FETCH_COLUMN);
        $rows = array_unique($rows);
        return $rows;
    }
    public function get_total_ticket_values($competition_id){
        $db = new db();
        $table = new tables();
        $comp = new competition();
        $tbl = $table->MAIN_TABLES['Tickets_tbl'];
        $this->Competition_Id = $competition_id;
        $ticket_key = $this->set_ticket_key();
        $sql = $db->db_query("SELECT * FROM $tbl WHERE Competition_Id = '$this->Competition_Id' AND Live_Status = 1",1);
        if ($sql->rowCount() > 0){
            $total_count = $sql->rowCount();
            $ticket_value = $comp->getFrom_Competition_attributes_by($this->Competition_Id);
            $ticket_value = $ticket_value[0]['Tickets_price'];
            return $total_count * $ticket_value;
        }else{
            return false;
        }
    }
    public function having_invalid_key_or_not($competition_id){
        $db = new db();
        $table = new tables();
        $tbl = $table->MAIN_TABLES['Tickets_tbl'];
        $this->Competition_Id = $competition_id;
        $ticket_key = $this->set_ticket_key();
        $sql = $db->db_query("SELECT * FROM $tbl WHERE Competition_Id = '$this->Competition_Id' AND Ticket_Key != '$ticket_key'",1);
        if ($sql->rowCount() > 0){
            return true;
        }else{
            return false;
        }
    }
    public function get_my_tickets_of_all_time(){
        $db = new db();
        $table = new tables();
        $tbl = $table->MAIN_TABLES['Tickets_tbl'];
        $sql = $db->db_query("SELECT * FROM $tbl WHERE Owner_Email = '$this->Owner_Email'",1);
        return $sql->fetchAll(\PDO::FETCH_ASSOC);
    }
    public function get_competitions_which_I_was(){
        $tickets = $this->get_my_tickets_of_all_time();
        $comps = [];
        foreach ($tickets as $ticket) {
             $comps = array_merge($comps,[$ticket['Competition_Id']]);
        }
        $comps = array_unique($comps);
        return $comps;
    }
    private function burn_user_tickets(){
        $db = new db();
        $table = new tables();
        $tbl = $table->MAIN_TABLES['Tickets_tbl'];
        $this->set_ticket_key();
        $db->db_query("UPDATE $tbl SET Live_Status = '0' WHERE Owner_Email = '$this->Owner_Email' AND Ticket_Key = '$this->Ticket_Key'",1);
        return true;
    }
    public function return_user_total_bought(){
        $users = $this->get_users_tickets_current_competition();
        $comp = new competition();
        $wallet = new wallet();
        $comp_info = $comp->getFrom_Competition_attributes_by($this->Competition_Id)[0];
        $ticket_price = $comp_info['Tickets_price'];
        $this->set_competition_id($comp_info['Competition_Id']);
        foreach ($users as $user){
            $this->set_owner($user);
            $wallet->Set_Email($user);
            $ticket_owned = $this->count_users_tickets_current_competition();
            $total = $ticket_owned * $ticket_price;
            $wallet->SumToBalance($total);
            $this->burn_user_tickets();
        }
        return true;
    }
}
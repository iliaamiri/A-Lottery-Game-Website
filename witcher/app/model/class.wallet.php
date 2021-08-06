<?php
namespace Model;


use Config\tables;
use Controller\login;
use Controller\register;

class wallet{
    private $wallet_key;
    private $tbl;
    private $email;
    private $admin_card_number;
    private $withdrawal_day_limit = 3000000;
    function __construct()
    {
        $table = new tables();
        $tbl = $table->MAIN_TABLES['Wallet_tbl'];
        $user = new user();
        $user_info = $user->getUserInfoBy('Email',$this->email);
        if (count($user_info) > 0 ){
            $permission = $user->user_get_permission(0,$user_info['Email']);
            if ($permission['Withdrawal_Limit'] != 0){
                $this->withdrawal_day_limit = $permission['Withdrawal_Limit'];
            }
        }
        return $this->tbl = $tbl;
    }
    public function Set_Email($email){
        return $this->email = $email;
    }
    public function Set_Wallet_Key(){
        $a = md5(sha1(md5(sha1(md5(sha1(md5(sha1(md5("TD-lfl_3030023492909302091991995555525589999")))))))));
        $b = sha1(md5(sha1(md5(sha1(sha1(sha1(md5(sha1(md5(sha1($a)))))))))));
        $c = md5(sha1(md5(sha1(sha1(md5(md5(md5(md5(md5(sha1(sha1(sha1(sha1(sha1($this->email.$b)))))))))))))));
        return $this->wallet_key = sha1(md5(sha1(md5(sha1($a.$b.$c)))));
    }
    public function create_wallet($Data_for_insert){
        $db = new db();
        $this->Set_Email($Data_for_insert['Email']);
        $First_Name = $Data_for_insert['First_Name'];
        $Last_Name = $Data_for_insert['Last_Name'];
        if ($this->Set_Wallet_Key())
            $db->db_query("INSERT INTO $this->tbl (Email,Balance,First_Name,Last_Name,Wallet_Key) VALUES ('$this->email',0,'$First_Name','$Last_Name','$this->wallet_key')",1);
        else
            return false;
    }
    public function Exists_Wallet($by,$value){
        $db = new db();
        $sql = $db->db_query("SELECT * FROM $this->tbl WHERE $by = '$value'",1);
        if ($sql->rowCount() > 0 )
            return true;
        else
            return false;
    }
    public function Is_Valid(){
        $db = new db();
        $this->Set_Email($this->email);
        $this->Set_Wallet_Key();
        $sql = $db->db_query("SELECT Wallet_Key FROM $this->tbl WHERE Wallet_Key = '$this->wallet_key'",1);
        if ($sql->rowCount() > 0 )
            return true;
        else
            return false;
    }
    public function Get_Balance(){
        $db = new db();
        $sql = $db->db_query("SELECT Balance FROM $this->tbl WHERE Email = '$this->email'",1);
        if ($sql->rowCount() > 0 )
            return $sql->fetch(\PDO::FETCH_COLUMN);
        else
            return false;
    }
    public function Get_Person(){
        $db = new db();
        $sql = $db->db_query("SELECT First_Name,Last_Name FROM $this->tbl WHERE Email = '$this->email'",1);
        if ($sql->rowCount() > 0 )
            return $sql->fetch(\PDO::FETCH_ASSOC);
        else
            return false;
    }
    public function Check_Today_Withdrawal_For_User(){
        $db = new db();
        $tbl = new tables();
        $tbl = $tbl->MAIN_TABLES['withdrawal_requests'];
        $now = date("Y-m-d");
        $sql = $db->db_query("SELECT * FROM $tbl WHERE Email = '$this->email'",1);
        $rows = $sql->fetchAll(\PDO::FETCH_ASSOC);
        $amount = 0;
        foreach ($rows as $key => $values){
            $date = date("Y-m-d",$values['Submited_At']);
            if ($now == $date)
                $amount = $amount + $values['Amount'];
        }
        $limit = false;
        if ($amount >= $this->withdrawal_day_limit){
            $limit = true;
        }
        return ['Limit' => $limit,'Amount' => $amount];
    }
    public function SumToBalance($amount){
        $db = new db();
        $tbl = new tables();
        $tbl = [$tbl->MAIN_TABLES['Transactions'],$tbl->MAIN_TABLES['Wallet_tbl']];
        $now = strtotime("today");
        $time = time();
        $newBalance = $this->Get_Balance() + $amount;
        if ($this->Is_Valid()) {
            $db->db_query("INSERT INTO $tbl[0] (Email,Trans_Action,Amount,From_Account,To_Account,Done_At,Exact_Time) VALUE ('$this->email','Deposit','$amount','WEBSITE','$this->wallet_key','$now','$time')", 1);
            $db->db_query("UPDATE $tbl[1] SET Balance = '$newBalance' WHERE Wallet_Key = '$this->wallet_key'", 1);
            return true;
        }else{
            return false;
        }
    }
    public function DecBalance($amount){
        $db = new db();
        $tbl = new tables();
        $tbl = [$tbl->MAIN_TABLES['Transactions'],$tbl->MAIN_TABLES['Wallet_tbl']];
        $now = strtotime("today");
        $time = time();
        $newBalance = $this->Get_Balance() - $amount;
        $db->db_query("INSERT INTO $tbl[0] (Email,Trans_Action,Amount,From_Account,To_Account,Done_At,Exact_Time) VALUE ('$this->email','Spend','$amount','$this->wallet_key','WEBSITE','$now','$time')", 1);
        $db->db_query("UPDATE $tbl[1] SET Balance = '$newBalance' WHERE Wallet_Key = '$this->wallet_key'", 1);
        return true;
    }
    public function Get_Last_Trans($by,$value){
        $db = new db();
        $tbl = new tables();
        $tbl = [$tbl->MAIN_TABLES['Transactions'],$tbl->MAIN_TABLES['Wallet_tbl']];
        $sql = $db->db_query("SELECT MAX($tbl[0].Done_At) as Latest,$tbl[0].* FROM $tbl[1] RIGHT JOIN $tbl[0] ON $tbl[1].Email = $tbl[0].Email WHERE $tbl[1].$by = '$value'",1);
        if ($sql->rowCount() > 0 )
            return $sql->fetchAll(\PDO::FETCH_ASSOC);
        else
            return false;
    }
    public function Get_All(){
        $db = new db();
        $tbl = new tables();
        $tbl = [$tbl->MAIN_TABLES['permissions'],$tbl->MAIN_TABLES['Wallet_tbl']];
        $sql = $db->db_query("SELECT $tbl[0].*,$tbl[1].* FROM $tbl[0] RIGHT JOIN $tbl[1] ON $tbl[0].Email = $tbl[1].Email",1);
        return $sql->fetchAll(\PDO::FETCH_ASSOC);
    }
    public function GetAllTrans(){
        $db = new db();
        $tbl = new tables();
        $tbl = $tbl->MAIN_TABLES['Transactions'];
        $sql = $db->db_query("SELECT * FROM $tbl",1);
        return $sql->fetchAll(\PDO::FETCH_ASSOC);
    }
    public function GetAllDeposits($email){
        $db = new db();
        $tbl = new tables();
        $tbl = $tbl->MAIN_TABLES['Transactions'];
        $sql = $db->db_query("SELECT * FROM $tbl WHERE Trans_Action = 'Deposit' AND Email = '$email '",1);
        return $sql->fetchAll(\PDO::FETCH_ASSOC);
    }
    public function GetDepositsByTime($strTotime){
        $d = strtotime($strTotime);
        $l = strtotime("yesterday",$d);
        $db = new db();
        $tbl = new tables();
        $tbl = $tbl->MAIN_TABLES['Transactions'];
        $sql = $db->db_query("SELECT * FROM $tbl WHERE Email = '$this->email' AND Trans_Action = 'Deposit' AND Done_At < '$d' AND Done_At > '$l'",1);
        $row = $sql->fetchAll(\PDO::FETCH_ASSOC);
        $result = 0;
        foreach ($row as $r){
            $result = $result + $r['Amount'];
        }
        return $result;
    }
    public function GetWithdrawalsByTime($strTotime){
        $d = strtotime($strTotime);
        $l = strtotime("yesterday",$d);
        $db = new db();
        $tbl = new tables();
        $tbl = $tbl->MAIN_TABLES['Transactions'];
        $sql = $db->db_query("SELECT * FROM $tbl WHERE Email = '$this->email' AND Trans_Action = 'Withdrawal' AND Done_At < '$d' AND Done_At > '$l'",1);
        $row = $sql->fetchAll(\PDO::FETCH_ASSOC);
        $result = 0;
        foreach ($row as $r){
            $result = $result + $r['Amount'];
        }
        return $result;
    }
    public function CalculateProfitByCompetition($comp_id){
        $db = new db();
        $comp = new competition();
        $ticket = new ticket();
        $tbl = new tables();
        $winner = new winner();
        $tbls = [$tbl->MAIN_TABLES['Wallet_tbl'],$tbl->MAIN_TABLES['Transactions']];
        $comp_attr = $comp->getFrom_Competition_attributes_by($comp_id)[0];
        $ticket->set_owner($this->email);
        $ticket->set_competition_id($comp_id);
        $winner->set_c_id($comp_id);
        $my_tickets = $ticket->get_my_tickets_data_of_competition("AND Live_Status = '1'");
        if (count($my_tickets) > 0 ) {
            $total_costs = count($my_tickets) * $comp_attr['Tickets_price'];
            $me_in_winners = $winner->findMeInWinners($my_tickets[0]['Owner_Email']);
            if ($me_in_winners == false) {
                return ['Profit' => 0 - $total_costs, 'Spent' => $total_costs];
            }
            $rewards = 0;
            foreach ($me_in_winners as $reward) {
                $rewards = $rewards + $reward['reward'];
            }
            return ['Profit' => $total_costs - $rewards, 'Spent' => $total_costs];
        }else{
            return ['Profit' => 0, 'Spent' => 0];
        }
    }
    public function CalculateWebsiteProfitByCompetition($comp_id){
        $db = new db();
        $comp = new competition();
        $ticket = new ticket();
        $tbl = new tables();
        $winner = new winner();
        //$comp_attrs = $comp->getFrom_Competition_attributes_by($comp_id)[0];
        $winner->set_c_id($comp_id);
        $total_tickets = $ticket->get_total_ticket_values($comp_id);
        $total_rewards = $winner->total_rewards();
        if ($winner->having_winner()){
            return ['Profit' => $total_tickets - $total_rewards];
        }else{
            return ['Profit' => 0];
        }
    }
    public function UpdateColumn($column,$value,$statement){
        $db = new db();
        $tbl = new tables();
        $tbl = $tbl->MAIN_TABLES['Wallet_tbl'];
        $db->db_query("UPDATE $tbl SET $column = '$value' $statement",1);
        return true;
    }
    public function UpdateColumnTrans($column,$value,$statement){
        $db = new db();
        $tbl = new tables();
        $tbl = $tbl->MAIN_TABLES['Transactions'];
        $db->db_query("UPDATE $tbl SET $column = '$value' $statement",1);
        return true;
    }
    public function GetWalletBy($column,$value){
        $db = new db();
        $tbl = new tables();
        $tbl = $tbl->MAIN_TABLES['Wallet_tbl'];
        $sql = $db->db_query("SELECT * FROM $tbl WHERE $column = '$value'",1);
        return $sql->fetchAll(\PDO::FETCH_ASSOC);
    }
    public function Is_Active(){
        $db = new db();
        $tbl = new tables();
        $tbl = $tbl->MAIN_TABLES['Wallet_tbl'];
        $sql = $db->db_query("SELECT * FROM $tbl WHERE Active_Status = '1' AND Email = '$this->email'",1);
        if ($sql->rowCount() > 0 )
            return true;
        else
            return false;
    }
    public function GetTransBy($column,$value){
        $db = new db();
        $table = new tables();
        $tbl = $table->MAIN_TABLES['Transactions'];
        $sql = $db->db_query("SELECT * FROM $tbl WHERE $column = '$value'",1);
        return $sql->fetchAll(\PDO::FETCH_ASSOC);
    }
    public function Delete(){
        $db = new db();
        $tbl = new tables();
        $tbl = $tbl->MAIN_TABLES['Wallet_tbl'];
        $db->db_query("DELETE FROM $tbl WHERE Email = '$this->email'",1);
        return true;
    }
    public function add_withdrawal_request($amount){
        $this->Set_Wallet_Key();
        $db = new db();
        $table = new tables();
        $factor_number = md5(rand(1000,9999));
        $tbl = $table->MAIN_TABLES['withdrawal_requests'];
        $now = time();
        $db->db_query("INSERT INTO $tbl (Email,Wallet_Key,Amount,Status,Submited_At,factor_number) VALUES ('$this->email','$this->wallet_key','$amount','WaitingForAdmin','$now','$factor_number')",1);
        return true;
    }
    public function select_withdrawal_requests($statement = ""){
        $db = new db();
        $table = new tables();
        $tbl = $table->MAIN_TABLES['withdrawal_requests'];
        $sql = $db->db_query("SELECT * FROM $tbl $statement",1);
        return $sql->fetchAll(\PDO::FETCH_ASSOC);
    }
    public function delete_withdrawal_requests($statement){
        $db = new db();
        $table = new tables();
        $tbl = $table->MAIN_TABLES['withdrawal_requests'];
        $db->db_query("DELETE FROM $tbl $statement",1);
        return true;
    }
    public function update_withdrawal_requests($statements){
        $db = new db();
        $table = new tables();
        $tbl = $table->MAIN_TABLES['withdrawal_requests'];
        $db->db_query("UPDATE $tbl SET $statements",1);
        return true;
    }
    public function change_withdrawal_requests_to_done($invoice_key,$email){
        $this->Set_Wallet_Key();
        $db = new db();
        $table = new tables();
        $tbl = $table->MAIN_TABLES['withdrawal_requests'];
        $now = time();
        $db->db_query("UPDATE $tbl SET Invoice_number = '$invoice_key' , Done_At = '$now' , Status = 'Done' WHERE Email = '$email' AND Wallet_Key = '$this->wallet_key'",1);
        return true;
    }
}
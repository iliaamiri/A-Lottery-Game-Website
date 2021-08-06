<?php
namespace Model;

use Config\tables;
use Model\factor;

class payment{
    private $table;
    private $api_key;
    private $callback;
    private $invoice_id;
    private $request_url;
    private $checker_url;
    private $requestt_url;
    function __construct()
    {
        $table = new tables();
        $tbl = $table->MAIN_TABLES['Payment_categories'];
        return $this->table = $tbl;
    }
    public function set_api_key($id){
        $db = new db();
        $sql = $db->db_query("SELECT Api_Key FROM $this->table WHERE Cat_id  = '$id'",1);
        return $this->api_key = $sql->fetch(\PDO::FETCH_ASSOC)['Api_Key'];
    }
    public function requestt_url($id){
        $db = new db();
        $sql = $db->db_query("SELECT Request FROM $this->table WHERE Cat_id  = '$id'",1);
        return $this->requestt_url = $sql->fetch(\PDO::FETCH_ASSOC);
    }
    public function set_callback($link){
        return $this->callback = $link;
    }
    public function set_invoice_id($id){
        return $this->invoice_id = $id;
    }
    private function set_request_url($url){
        return $this->request_url = $url;
    }
    private function set_checker_url($url){
        return $this->checker_url = $url;
    }
    public function send($amount,$factor_number){
        $factor = new factor();
        $payment = new payment();
        $factor_info = $factor->getFactorInfoBy('Private_Key',$factor_number);
        $method_id = $payment->getCatBy('Payment_Method',$factor_info[0]['Method'])[0]['Cat_id'];
        $payment_info = $payment->getCatBy('Cat_Id',$method_id)[0];
        $this->set_api_key($method_id);
        $this->set_callback($payment_info['Callback']);
        $bank_url = $payment->getCatBy('Cat_id',$method_id)[0]['Url'];
        $this->set_request_url($bank_url);
        $this->set_checker_url($payment_info['Checker_url']);
        $preg = new preg();
        $this->requestt_url($method_id);
        $amount = $amount * 10;
        $result = $this->request($amount);
        $result = json_decode($result,1);
        if ($result['status'] == 1){
            if ($preg->custom('/^[a-zA-Z0-9_]*$/i',$result['invoice_key']) == 1) {
                $factor->updateFactorTrackingNumber($result['invoice_key'],$factor_info[0]['Factor_number']);
                $factor->updateFactorStatus("WaitingForPaying");
                pager::go_page($bank_url.$result['invoice_key']);
            }else{
                return 'error : invoice wanted to fuck with us!';
            }
        }else {
            return 'error : '.$result['errorCode'].' - '.$result['errorDescription'];
        }
    }
    public function get(){
        $preg = new preg();
        if ($preg->custom('/^[a-zA-Z0-9_]*$/i',$_POST['invoice_key']) !=  1){
            return "dont fuck with us";
        }
        $this->set_invoice_id($_POST['invoice_key']);
        $factor = new factor();
        $payment = new payment();
        $comp = new competition();
        $factor_info = $factor->getFactorInfoBy('Tracking_number',$this->invoice_id);
        if (count($factor_info) > 0){
            $factor_info = $factor_info[0];
            $comp_info = $comp->getFrom_Competition_attributes_by($factor_info['Competition_Id'])[0];
            $ticket_price = $comp_info['Tickets_price'];
            $ticket = new ticket();
            $payment_info = $payment->getCatBy('Payment_Method',$factor_info['Method']);
            $this->set_api_key($payment_info[0]['Api_Key']);
            $result = $this->check();
            $result = json_decode($result,1);
            if ($result['status'] == 1){
                if ($ticket_price * $factor_info['Amount'] == $result['amount']){
                    $factor->getFactorNumber($factor_info['Factor_number']);
                    $factor->setEmail($factor_info['Email']);
                    $factor->updateFactorStatus("Paid");
                    $ticket->set_competition_id($comp_info['Competition_Id']);
                    $ticket->set_live_status(1);
                    $ticket->set_owner($factor_info['Email']);
                    for ($i = 0;$i < $factor_info['Amount'];$i++) {
                        $ticket->new_ticket();
                    }
                    pager::redirect_page('2',"/profile/ticket");
                    message::msg_alert("SUCCESSFUL. REDIRECTING IN A FUCKING MOMENT!!");
                    exit();
                }else{
                    return "GO FUCK UR SELF BITCH";
                }
            }else{
                return "SEEEEK NABINAMET ";
            }
        }else{
            return "this is not that invoice which I GOT BITCH!";
        }
    }
    public function check(){
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,$this->checker_url);
        curl_setopt($ch,CURLOPT_POSTFIELDS,"api_key=$this->api_key");
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        $res = curl_exec($ch);
        curl_close($ch);
        return $res;
    }
    public function request($amount){
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,$this->requestt_url['Request']);
        curl_setopt($ch,CURLOPT_POSTFIELDS,"api_key=$this->api_key&amount=$amount&return_url=$this->callback");
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        $res = curl_exec($ch);
        curl_close($ch);
        return $res;
    }
    public function get_payment_methods($with_deactives = 1){
        $db = new db();
        $where = "";
        if ($with_deactives == 0){
            $where = "WHERE Status = '1'";
        }
        $sql = $db->db_query("SELECT * FROM $this->table $where",1);
        $row = $sql->fetchAll(\PDO::FETCH_ASSOC);
        return $row;
    }
    public function exists_of_or_fail($array_of_Cat_id,$check_actives = 1){
        $db = new db();
        $where = "";
        if ($check_actives == 1)
            $where = "AND Status = '1'";
        $checks = 0;
        $not_exist = [];
        foreach ($array_of_Cat_id as $cat_id){
            $sql = $db->db_query("SELECT * FROM $this->table WHERE Cat_id = '$cat_id' $where",1);
            $row = $sql->fetchAll(\PDO::FETCH_ASSOC);
            if (count($row) > 0)
                $checks++;
            else
                $not_exist = array_merge($not_exist,[$cat_id]);
        }
        if (count($array_of_Cat_id) == $checks){
            return ['status' => true,'bad_ids' => 0];
        }else{
            return ['status' => false,'bad_ids' => $not_exist];
        }
    }
    public function get_rows_byCat_id($array_of_Cat_id,$check_actives = 0){
        $db = new db();
        $where = "";
        if ($check_actives == 1)
            $where = "AND Status = '1'";
        if ($this->exists_of_or_fail($array_of_Cat_id,$check_actives)['status'] == false){
            return $this->exists_of_or_fail($array_of_Cat_id,$check_actives)['bad_ids'];
        }
        $rows = [];
        foreach ($array_of_Cat_id as $methods){
            $sql = $db->db_query("SELECT * FROM $this->table WHERE Cat_id = '$methods' $where",1);
            $rows = array_merge($rows,[$sql->fetch(\PDO::FETCH_ASSOC)]);
        }
        return $rows;
    }
    public function getPaymentFolder($payment_id){
        $db = new db();
        $tbl = new tables();
        $tbl = $tbl->MAIN_TABLES['Payment_categories'];
        $sql = $db->db_query("SELECT * FROM $tbl WHERE Cat_id = '$payment_id'",1);
        $row = $sql->fetch(\PDO::FETCH_ASSOC);
        $folder_name = $row['Payment_Method'];
        return HTTP_SERVER . "/banks/" . $folder_name;
    }
    public function getPaymentMethodsCatId($competition_id){
        $db = new db();
        $tbl = new tables();
        $tb = [$tbl->MAIN_TABLES['Payment_categories'],$tbl->MAIN_TABLES['Competition_Attributes_tbl']];
        $sql = $db->db_query("SELECT * FROM $tb[1] WHERE Competition_Id = '$competition_id'",1);
        $row = $sql->fetch(\PDO::FETCH_ASSOC);
        $row = $row['Payment_Methods'];
        $row = explode(",",$row);
        $Methods = [];
        foreach ($row as $method){
            $sql2 = $db->db_query("SELECT Cat_id FROM $tb[0] WHERE Payment_Method = '$method'",1);
            $Methods = array_merge($Methods,[$sql2->fetch(\PDO::FETCH_COLUMN)]);
        }
        return $Methods;
    }
    public function getCatBy($column,$value,$statement = ""){
        $db = new db();
        $table = new tables();
        $tbl = $table->MAIN_TABLES['Payment_categories'];
        $sql = $db->db_query("SELECT * FROM $tbl WHERE $column = '$value' $statement",1);
        return $sql->fetchAll(\PDO::FETCH_ASSOC);
    }
    public function getAll(){
        $db = new db();
        $table = new tables();
        $tbl = $table->MAIN_TABLES['Payment_categories'];
        $sql = $db->db_query("SELECT * FROM $tbl",1);
        return $sql->fetchAll(\PDO::FETCH_ASSOC);
    }
    public function updateTbl($changes,$statements){
        $db = new db();
        $table = new tables();
        $tbl = $table->MAIN_TABLES['Payment_categories'];
        $db->db_query("UPDATE $tbl SET $changes $statements",1);
        return true;
    }
    public function newCat($method,$currency,$apikey,$url,$status,$cat,$callback,$checker){
        $db = new db();
        $table = new tables();
        $tbl = $table->MAIN_TABLES['Payment_categories'];
        $db->db_query("INSERT INTO $tbl (Payment_Method,Currency,Cat_id,Status,Api_Key,Url,Callback,Checker_url) VALUES ('$method','$currency','$cat','$status','$apikey','$url','$callback','$checker')",1);
        return true;
    }
}
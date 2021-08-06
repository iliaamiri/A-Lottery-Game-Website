<?php
namespace Module;

use Model\message;
use Model\module;
use Model\pager;
use Model\wallet;

class response_withdrawal_request extends module{
    private static $wallet;
    private $factor_number;
    private $invoice_number;
    private $begger_email;
    private $post_index_invoice_number = 'Invoice_number';
    private $post_index_factor_number = 'factor_number';
    private $getmethod_index_factor_number = 'factor_number';

    private $second_callback = "/profile/withdrawals";

    function __construct()
    {
        new module();
        self::$wallet = new wallet();
    }

    public function set_factor_number(){
        $number = $_GET[$this->getmethod_index_factor_number];
        if (parent::$preg->md5($number) == 1){
            $select_statement = " WHERE factor_number = '".$number."'";
            $select = self::$wallet->select_withdrawal_requests($select_statement);
            if (count($select) > 0 ){
                $this->factor_number = $number;
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }
    public function set_invoice_number($number){
        if (parent::$preg->custom('/^[a-zA-Z0-9_]*$/i',$number) == 1) {
            $this->invoice_number = $number;
            return true;
        }else {
            return false;
        }
    }
    private function set_begger_email(){
        $select_statement = " WHERE factor_number = '".$this->factor_number."'";
        $select = self::$wallet->select_withdrawal_requests($select_statement);
        if (count($select) > 0 ) {
            $this->begger_email = $select['Email'];
            return true;
        }else {
            return false;
        }
    }

    private function getmethod_factor_number(){
        if (isset($_GET[$this->getmethod_index_factor_number]))
            return true;
        elseif (!isset($_GET[$this->getmethod_index_factor_number]))
            return false;
    }
    private function post_invoice_number(){
        if (isset($_POST[$this->post_index_invoice_number]))
            return true;
        elseif (!isset($_POST[$this->post_index_invoice_number]))
            return false;
    }
    private function post_factor_number(){
        if (isset($_POST[$this->post_index_factor_number]))
            return true;
        elseif (!isset($_POST[$this->post_index_factor_number]))
            return false;
    }

    public function get_row(){
        $select_statement = " WHERE factor_number = '".$this->factor_number."'";
        $select = self::$wallet->select_withdrawal_requests($select_statement)[0];
        return $select;
    }
    public function get_status(){
        $row = $this->get_row();
        return $row['Status'];
    }
    public function get_amount(){
        $row = $this->get_row();
        return $row['Amount'];
    }
    public function get_email(){
        $row = $this->get_row();
        return $row['Email'];
    }
    public function get_wallet_balance(){
        self::$wallet->Set_Email($this->get_email());
        return self::$wallet->Get_Balance();
    }

    private function request_valid(){
        $request_row = $this->get_row();
        self::$wallet->Set_Email($request_row['Email']);
        if (self::$wallet->Is_Valid())
            return true;
        else
            return false;
    }
    private function user_wallet_access(){
        $Readusers_permission = parent::$loggedIn_user['ReadUsers'];
        $Writesite_permission = parent::$loggedIn_user['WriteSite'];
        if ($Readusers_permission == 1 and $Writesite_permission == 1 )
            return true;
        else
            return false;
    }
    public function if_ok_begger_amount_with_balance(){
        $amount = $this->get_amount();
        $balance = $this->get_wallet_balance();
        if ($amount <= $balance)
            return true;
        else
            return false;
    }
    private function update_status($status,$invoice){
        $statement = " Status = '".$status."' , Invoice_number = '".$invoice."' WHERE factor_number = '".$this->factor_number."'";
        self::$wallet->update_withdrawal_requests($statement);
        return true;
    }
    public function callback(){
        try{
            if (!$this->getmethod_factor_number()) {
                parent::$callback_url = $this->second_callback;
                throw new \Exception("شماره فاکتور یافت نشد");
            }
            if (!$this->set_factor_number()){
                parent::$callback_url = $this->second_callback;
                throw new \Exception("شماره فاکتور یافت نشد");
            }
            if ($_SERVER['REQUEST_METHOD'] == "POST"){
                parent::$callback_url = "/profile/withdrawals_info?factor_number=".$_GET[$this->getmethod_index_factor_number];
                    if (!$this->user_wallet_access()){
                        parent::$callback_url = $this->second_callback;
                        throw new \Exception("دسترسی شما کافی نیست!");
                    }
                    if (!$this->post_invoice_number()){
                        throw new \Exception("شماره ارجاع یافت نشد");
                    }
                    if (!$this->set_invoice_number($_POST[$this->post_index_invoice_number])){
                        throw new \Exception("شماره ارجاع یافت نشد");
                    }
                    if (strlen($this->invoice_number) < 5){
                        throw new \Exception("شماره ارجاع کامل نیست");
                    }
                    if (!$this->request_valid()){
                        throw new \Exception("کیف پول این کاربر نامعتبر است");
                    }
                    if (!$this->if_ok_begger_amount_with_balance()){
                        throw new \Exception("اعتبار این حساب کمتر از مقدار درخواست شده برای برداشت میباشد");
                    }
                    if ($this->update_status("Done",$this->invoice_number)){
                        message::msg_box_session_prepare("موفق","success");
                        pager::go_page($this->second_callback);
                    }else{
                        throw new \Exception("ناموفق");
                    }
            }
        }catch (\Exception $e){
            message::msg_box_session_prepare($e->getMessage(),"danger");
            pager::go_page(parent::$callback_url);
            exit();
        }
    }
}
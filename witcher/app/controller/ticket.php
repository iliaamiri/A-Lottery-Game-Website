<?php
namespace Controller;

use Model\factor;
use Model\message;
use Model\pager;
use Model\payment;
use Model\preg;
use Model\user;
use Model\views;
use Model\db;
use Model\wallet;

class ticket extends views {
    private $factor_page;
    public function start(){
        $witcher = new \witcher();
        $witcher->requireController("login");
        $witcher->requireController("competition");
        $preg = new preg();
        $comp = new \Model\competition();
        $user = new user();
        $login = new login();
        $factor = new factor();
        $view = [];
        if (isset($_GET['action'])){
            $action = $_GET['action'];
            $data = [];
            switch ($action){
                case "buy":
                    if ($login->is_login()){
                        $ticket = new \Model\ticket();
                        $user_info = $user->user_get_certificate();
                        $permission = $user->user_get_permission();
                        if (isset($_GET['c'])){
                            $view = [parent::setHeader("layouts/header.php"),parent::setPage("layouts/home_head.php"),parent::setPage("newTicket.php"),parent::setFooter("layouts/footer.php")];
                            if (isset($_POST['Submit'])){
                                if ($preg->custom('/^[a-zA-Z0-9]*$/i',$_GET['c'])) {
                                    $comp_info = $comp->getCompetition_Status($_GET['c']);
                                    if ($comp_info['active_status'] == 1 AND $comp_info['status'] == "In-Progress") {
                                        $ticket->set_competition_id($_GET['c']);
                                        if ($comp_info['user_limitation'] > 0){
                                            if ($ticket->count_users_tickets_current_competition() >= $comp_info['user_limitation']) {
                                                pager::redirect_page("0","/ticket/buy");
                                                message::msg_alert("محدودیت شرکت کننده به پایان رسیده است.");
                                                exit();    
                                            }
                                        }
                                            $this->setFactorPage("/factor");
                                            $result = $this->CallBackBuyTicket();
                                            if (!$result['status']) {
                                                message::msg_box_session_prepare($result['cause'],"warning");
                                            }
                                    } else {
                                        echo "competition is not in process";
                                    }
                                }else{
                                    message::msg_box_session_prepare("مسابقه نامعتبراست","danger");
                                    exit();
                                }
                            }
                        }elseif (!isset($_GET['c'])){
                            pager::go_page("/ticket");
                            exit();
                        }
                    }else{
                        pager::go_page("/login");
                    }
                    break;
                case "factor":
                    if ($login->is_login()) {
                        if (isset($_GET['factor'])) {
                            if ($preg->md5($_GET['factor']) == 1) {
                                if ($factor->existFactorsByPrivateKey($_GET['factor'])) {
                                    /*
                                     * Use captcha for getting these actions ( LATER )
                                     *
                                     */
                                    $user_info = $user->user_get_certificate();
                                    $factor->setEmail($user_info['Email']);
                                    $factor_info = $factor->getFactorInformation($_GET['factor']);
                                    $comp_status = $comp->getCompetition_Status($factor_info[0]['Competition_Id']);
                                    if ($comp_status['status'] != "Expired" OR $comp_status['status'] == "In-Progress") {
                                        $checker = $this->check_competition_for_new_ticket($factor_info[0]['Competition_Id'], $user_info['Email']);
                                        if ($checker['status']) {
                                            $data = [
                                                'Factor_info' => $factor_info,
                                                'Comp_Status' => $comp_status,
                                                'User_info' => $user_info
                                            ];
                                            $amount = $factor_info[0]['Amount'] * $comp_status['ticket_price'];
                                            if ($_SERVER['REQUEST_METHOD'] == "POST"){
                                                $payment = new payment();
                                                $payment->send($amount,$_GET['factor']);
                                            }
                                        } else {
                                            message::msg_alert($checker['cause']);
                                        }
                                    } else {
                                        message::msg_alert("این مسابقه شروع نشده است.");
                                    }
                                } else {
                                    message::msg_box_session_prepare("این فاکتور وجود ندارد.","danger");
                                }
                            } else {
                                message::msg_box_session_prepare("شماره نامعتبر است.","danger");
                            }
                            $view = [parent::setPage("factor.php")];
                        }
                    }else{
                        pager::go_page("/login");
                    }
                    break;
                case 'callback':
                    if (isset($_POST['invoice_key'])){
                        $payment = new \Model\payment();
                        var_dump($payment->get());
                    }
                    break;
                case 'deleteFactor':
                    try{
                        if ($login->is_login()) {
                            $user_info = $user->user_get_certificate();
                            if (!isset($_GET['factor'])) {
                                throw new \Exception("شماره فاکتور ست نشده است.");
                            }
                            if ($preg->md5($_GET['factor']) != 1) {
                                throw new \Exception("شماره فاکتور نامعتبر است");
                            }
                            $factor->setEmail($user_info['Email']);
                            $factor_info = $factor->getFactorInformation($_GET['factor']);
                            if ($user_info['Email'] != $factor_info[0]['Email'] OR $factor_info[0]['Status'] == "Burnt") {
                                throw new \Exception("این فاکتور وجود ندارد.");
                            }
                            if ($factor_info[0]['Status'] == "WaitingForPaying") {
                                throw new \Exception("این فاکتور اکنون دیگر قابل لغو شدن نیست.");
                            }
                            $factor->getFactorNumber($factor_info[0]['Factor_number']);
                            $factor->setEmail($user_info['Email']);
                            $factor->BurnFactor();
                            message::msg_alert("DONE");
                        }
                    }catch (\Exception $e){
                        message::msg_alert($e->getMessage());
                    }
                    break;
            }
            parent::Show($view);
            return $data;
        }elseif (!isset($_GET['action'])){
            $view = [parent::setHeader("layouts/header.php"),parent::setPage("layouts/home_head.php"),parent::setPage("tickets.php"),parent::setFooter("layouts/footer.php")];
            parent::Show($view);
        }
    }
    private function setFactorPage($factor){
        return $this->factor_page = $factor;
    }
    private function CallBackBuyTicket(){
        $preg = new preg();
        if (isset($_POST['Submit'])){
            if (isset($_GET['c'])){
                if (isset($_POST['Ticket_Num'])){
                    if ($_POST['Ticket_Num'] > 0 AND $_POST['Ticket_Num'] != null){
                        if ($preg->number($_POST['Ticket_Num']) == 1 ){
                            if ($_POST['Ticket_Num'] > 30){
                                return ['status' => false, 'cause' => 'شما حداکثر 30 تیکت در هر بار خرید میتوانید خریداری کنید.'];
                            }
                            if (isset($_POST['Payment_Method'])){
                                if ($preg->number($_POST['Payment_Method']) == 1 ){
                                    $payment = new payment();
                                    $comp = new \Model\competition();
                                    $factor = new factor();
                                    $user = new user();
                                    $ticket = new \Model\ticket();
                                    $wallet = new wallet();
                                    $comp_attr = $comp->getFrom_Competition_attributes_by($_GET['c'])[0];
                                    $user_info = $user->user_get_certificate();
                                    if ($_POST['Payment_Method'] == "0"){
                                        $wallet->Set_Email($user_info['Email']);
                                        if ($wallet->Exists_Wallet('Email',$user_info['Email']) AND $wallet->Is_Valid() AND $wallet->Is_Active()){
                                            $balance = $wallet->Get_Balance();
                                            $total = $_POST['Ticket_Num'] * $comp_attr['Tickets_price'];
                                            if ($balance >= $total){
                                                if ($wallet->DecBalance($total)){
                                                    $ticket->set_owner($user_info['Email']);
                                                    $ticket->set_live_status(1);
                                                    $ticket->set_competition_id($_GET['c']);
                                                    for ($i = 0;$i < $_POST['Ticket_Num'];$i++){
                                                        $ticket->new_ticket();
                                                    }
                                                    sleep(1);
                                                    pager::redirect_page('2',"/");
                                                    message::msg_alert("خرید موفق بود.");
                                                    exit();
                                                }
                                            }else{
                                                return ['status' => false, 'cause' => 'اعتبار کافی نمی باشد.'];
                                            }
                                        }else{
                                            return ['status' => false,'cause' => 'کیف پول یافت نشد.'];
                                        }
                                    }else {
                                        if ($payment->exists_of_or_fail([$_POST['Payment_Method']], 1)['status'] == true) {
                                            $payment_method = $payment->get_rows_byCat_id([$_POST['Payment_Method']]);
                                            $payment_folder = $payment->getPaymentFolder($_POST['Payment_Method']);
                                            $factor->setAmount($_POST['Ticket_Num']);
                                            $factor->setMethod($payment_method[0]['Payment_Method']);
                                            $factor->setEmail($user_info['Email']);
                                            $factor->setComId($_GET['c']);
                                            $factor->createFactor();
                                            $factor_key = $factor->Key;
                                            pager::go_page($this->factor_page . "?factor=" . $factor_key);
                                        } else {
                                            return ['status' => false, 'cause' => 'این روش پرداخت وجود ندارد.'];
                                        }
                                    }
                                }else{
                                    return ['status' => false,'cause' => 'این روش پرداخت نامعتبر است.'];
                                }
                            }elseif (!isset($_POST['Payment_Method'])){
                                return ['status' => false,'cause' => 'روش پرداخت تعیین نشد.'];
                            }
                        }else{
                            return ['status' => false,'cause' => 'تعداد بلیط نامعتبر است.'];
                        }
                    }else{
                        return ['status' => false,'cause' => 'تعداد بلیط نمیتواند صفر باشد.'];
                    }
                }elseif (!isset($_POST['Ticket_Num'])){
                    return ['status' => false,'cause' => 'تعداد بلیط فرستاده نشد.'];
                }
            }elseif (!isset($_GET['c'])){
                return ['status' => false,'cause' => 'مسابقه یافت نشد.'];
            }
        }
    }
    private function check_competition_for_new_ticket($id,$email){
        $compet = new \Model\competition();
        $result = array();
        if ($compet->exists_compet($id) == true){
            $row = array_merge($compet->getFrom_Competition_tbl_by($id),$compet->getFrom_Competition_attributes_by($id));
            if ($row['Starts_At'] < $row['Ends_At']){
                if ($row['Ends_At'] - $row['Starts_At'] > 600){
                    if ($row['Starts_At'] > time()){
                        $result = ['Error' => 'This competition is not started yet!'];
                    }elseif ($row['Ends_At'] < time()){
                        $result = ['Error' => 'This competition was finished!'];
                    }elseif ($row['Starts_At'] < time() AND time() < $row['Ends_At']){
                        $user = new user();
                        $email_exist = $user->CountUsersBy('Email',$email);
                        if ($email_exist == 1 ){
                            if ($row[0]['Active_Status'] == 1){
                                $result = array("status" => true);
                            }else{
                                $result = ['status'=> false , 'cause' => 'This competition is not active'];
                            }
                        }else {
                            $result = ['status'=> false , 'cause' => 'This Email does not exist!'];
                        }
                    }
                }else {
                    $result = ['status' => false , 'cause' =>'Time is over.See U next game!'];
                }
            }else {
                $result = ['status' => false, 'cause' => 'The competition has some problems. sorry us because of that. If you have any problem Contact with us.'];
            }
        }else {
            $result = ['status' => false, 'cause' => 'This competition does not exist!'];
        }
        return $result;
    }
    private function Give_new_ticket($id,$email){
        $checker = $this->check_competition_for_new_ticket($id,$email);
        if ($checker['status'] == 'Success'){
            $ticket = new \Model\ticket();
            $ticket->set_live_status(1);
            $ticket->set_owner($email);
            $ticket->set_competition_id($id);
            $ticket->new_ticket();
            return true;
        }else {
            return $checker['cause'];
        }
    }
}
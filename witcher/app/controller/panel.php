<?php
namespace Controller;

use Config\tables;
use Model\factor;
use Model\interfaces;
use Model\internal_mail;
use Model\log;
use Model\pager;
use Model\payment;
use Model\server;
use Model\upload;
use Model\user;
use Model\message;
use Model\preg;
use Model\db;
use Model\views;
use Model\wallet;
use Model\winner;
use Module\add_internal_message;
use Module\response_withdrawal_request;

class panel extends views {
    private $Email;
    public function start(){
        $witcher = new \witcher();
        $user = new user();
        $ticket = new \Model\ticket();
        $competition = new \Model\competition();
        $internal_msg = new internal_mail();
        $witcher->requireController("login");
        $witcher->requireModules("panel/both");
        $permission = $this->Permissions();
        $wallet = new \Model\wallet();
        $wallet->Set_Email($permission['Email']);
        if (!$permission){
            $message = new message();
            $message->msg_session_prepare("ورود انجام نشده است.");
            pager::go_page('/login');
            exit;
        }
        if($permission['Admin'] == 1){
            $witcher->requireModules("panel/admin");
            $this->AdminActions();
            $browsers_list = ['Google Chrome','Safari','Firefox','Microsoft',''];
            $page = array(parent::setPage("admin-panel/admin/index.php"));
            $witcher->requireController("competition");
            $user_info = $this->getUserInfos();
            $this->set_email($user_info['Email']);
            /*
             * ticket get values
             */
            $ticket->set_owner($permission['Email']);
            $count_users_tickets = $ticket->count_users_tickets_current_competition();
            /*
             * /ticket get values
             */

            /*
             * Wallets get values
             */
            $all_wallets = $wallet->Get_All();
            /*
             * / Wallet get values
             */
                $datas = array(
                    'Count_users' => $user->CountUsers(),
                    'Count_nearest_compet' => count($competition->getNearest_competition()),
                    'Check_Competitions' => $competition->Check_Competitions(),
                    'user_info' => $user->user_get_certificate(),
                    'user_permissions' => $user->user_get_permission(),
                    'Users_Tickets' => $count_users_tickets,
                    'All_Wallets' => $all_wallets,
                    'Comps_in_limit' => $competition->getCompetitions_InLimitation(6),
                    'Browsers_percentages' => $user->PercentageOfBrowsers($browsers_list),
                    'Support_message_ticket_num' => count($internal_msg->getSupportMessages("AND Read_Status = '0' AND Sent_To = 'Support'"))
                );
                if (isset($_GET['parts'])){
                    $datas = array_merge($datas,$this->set_datas_each_parts());
                }
        }elseif($permission['Admin'] != 1){
            $witcher->requireModules("panel");
            $ticket->set_owner($permission['Email']);
            $user_info = $user->user_get_certificate();
            $wallet->Set_Email($user_info['Email']);
            $wallet_info = ['Exist' => $wallet->Exists_Wallet('Email',$user_info['Email']),'Valid' => $wallet->Is_Valid(),'Info' => ['Balance' => $wallet->Get_Balance(),'Person' => $wallet->Get_Person()],'Status' => $wallet->Is_Active()];
            $page = array(parent::setPage("admin-panel/admin/client-panel.php"));
            $check_competitions = $competition->Check_Competitions();
            $datas = array(
                'Role_Name' => $user->getUserRoleCats($permission['Email'])['Role_Name'],
                'Check_Competitions' => $competition->Check_Competitions(),
                'Owned_tickets' => $ticket->get_owned_tickets($user_info['Email']),
                'Current_Competitions' => $check_competitions['FO_started'],
                'user_info' => $user->user_get_certificate(),
                'user_permissions' => $user->user_get_permission(),
                'profile_complete_percents' => $user->HowCompleteIsProfile($user_info['Email']),
                'wallet' => $wallet_info,
                'compet_which_Iwas' => $ticket->get_competitions_which_I_was()
            );
            if (isset($_GET['parts'])){
                $datas = array_merge($datas,$this->set_datas_each_parts());
            }
        }
        $this->PanelActions();
        if (isset($_GET['logout'])){
            $this->logout();
        }
        parent::Show($page);
        return array_merge($this->getUserInfos(),$this->Permissions(),$datas);
    }
    private function set_email($value){
        return $this->Email = $value;
    }
    private function set_datas_each_parts(){
        $datas = [];
        $user = new user();
        $server = new \Model\server();
        $internal_msg = new \Model\internal_mail();
        $wallet = new wallet();
        $preg = new preg();
        $comp = new \Model\competition();
        $payment = new payment();
        $factor = new factor();
        $interface = new interfaces();
        $user_permission = $user->user_get_permission();
        switch ($_GET['parts']){
            case 'competition':
                $competitions_list = $comp->getCompetitions_InLimitation(10,"ORDER BY competition_attributes.Active_Status");
                $datas = [
                    'get_competitions_in_tenLimit' => $competitions_list,
                    'users_who_have_participate_permission' =>  $user->CountUsersBy_Permission('Participate_Competitions',1),
                    'payment_methods_list' => $payment->get_payment_methods(0)
                ];
                break;
            case 'user_management':
                $list_users = $user->getAll();
                $datas = [
                    'List_Users' => $list_users,
                    'List_Active_Users' => $user->getActiveUsers(),
                    'List_Has_Wallet_Users' => $user->getWhoHasWallet()
                ];
                if ($user_permission['role_id'] == 2) {
                    $this->UserManagementActions();
                }
                break;
            case 'wallet_management':
                $wallet_list = $wallet->Get_All();
                $datas = [
                    'All_wallets' => $wallet_list
                ];
                if ($user_permission['role_id'] == 2) {
                    $this->WalletManagementActions();
                }
                break;
            case 'slider_management':
                $datas = [
                    'Sliders' => $interface->GetSlidersByStatement("")
                ];
                if ($user_permission['role_id'] >= 1 and $user_permission['role_id'] < 3) {
                    $this->SliderManagementActions();
                }
                break;
            case 'slider_info':
                if (isset($_GET['id'])) {
                    if ($preg->number($_GET['id']) == 1){
                    $datas = [
                        'slidersss' => $interface->GetSlidersByStatement("WHERE id = '" . $_GET['id'] . "'")
                    ];
                    if ($user_permission['Admin'] == 1){
                        $this->SliderManagementActions();
                    }
                    }
                }
                break;
            case 'competition_history':
                $datas = [
                'Competitions_history_user' => $comp->Check_Competitions()['FO_ends']];
                break;
            case 'factors_history':
                $user_info = $user->user_get_certificate();
                $factor->setEmail($user_info['Email']);
                $datas = [
                    'Factors_history_user' => $factor->getFactorInfoBy('Email',$user_info['Email'])
                ];
                break;
            case 'trans_management':
                $all_trans = $wallet->GetAllTrans();
                $datas = [
                    'all_trans' => $all_trans
                ];
                break;
            case 'factor_management':
                $factor_details = [];
                if (isset($_GET['factor_num'])) {
                    if ($preg->number($_GET['factor_num']) == 1){
                        $factor_details = $factor->getFactorInfoBy('Factor_number', $_GET['factor_num'])[0];
                        if ($factor_details == false){
                                message::msg_box_session_prepare("فاکتور یافت نشد","warning");
                                pager::go_page('/profile?parts=factor_management');
                                exit(); 
                        }
                        if (isset($_GET['delete'])){
                            if ($factor->delete($_GET['factor_num'])){
                                message::msg_box_session_prepare("این فاکتور حذف شد","success");
                                pager::go_page('/profile?parts=factor_management');
                                exit();
                            }
                        }
                    }else{
                        pager::redirect_page('0','profile?parts=factor_management');
                        message::msg_box_session_prepare("شماره قاکتور نامعتبر است.","warning");
                        exit();
                    }
                }
                $datas = [
                    'factor_details' => $factor_details,
                    'factors' => $factor->getAll()
                ];
                break;
            case "payment_setting":
                $payment_cats = $payment->getAll();
                $datas = [
                    'payment_cats' => $payment_cats
                ];
                if ($user_permission['role_id'] == 2) {
                    $this->PaymentManagementActions();
                }
                break;
            case "server-about":

                $datas = [
                    'server_info' => $server->getInfoRows()
                ];
                if ($user_permission['role_id'] == 2){
                    $this->ServerManagements();
                }
                break;
            case "users_info":
                if (isset($_GET['email'])){
                    if ($preg->email($_GET['email']) == 1){
                        if (count($user->getUserInfoBy('Email',$_GET['email'])) > 0){
                            $datas = [
                              'user' => array_merge($user->getUserInfoBy('Email',$_GET['email'])[0],$user->user_get_permission(0,$_GET['email'])),
                                'roles' => $user->getRoles()
                            ];
                            if ($user_permission['role_id'] == 2) {
                                $this->UserManagementActions();
                            }
                        }
                    }
                }
                break;
            case "wallets_info":
                $wallet = new \Model\wallet();
                if (isset($_GET['email'])){
                    if ($preg->email($_GET['email']) == 1){
                        if (count($user->getUserInfoBy('Email',$_GET['email'])) > 0){
                            $wallet->Set_Email($_GET['email']);
                            $datas = [
                                'wallet' => ['person' => $wallet->Get_Person(),'balance' => $wallet->Get_Balance(),'is_valid' => $wallet->Is_Valid(),'exist' => $wallet->Exists_Wallet('Email',$_GET['email']),'active' => $wallet->Is_Active()]
                            ];
                        }
                        if ($user_permission['role_id'] == 2) {
                                $this->WalletManagementActions();
                        }
                    }
                }
                break;
            case "my_wallet_info":
                $this->WalletClientActions();
                break;
            case "admin_support_messages":
                $support_msg = $internal_msg->getSupportMessages("AND Reply_id = '0' ORDER BY Read_Status");
                $datas = [
                    'support_messages' => $support_msg
                ];
                break;
            case "client_support_messages":
                $support_msg = $internal_msg->getSupportMessages("AND Reply_id = '0' AND Email = '".$user_permission['Email']."'");
                $datas = [
                    'support_messages' => $support_msg
                ];
                break;
            case "new_support_message":
                $this->MessageManagements();
                break;
            case "view_support_message":
                if (isset($_GET['msgid'])) {
                    if ($preg->md5($_GET['msgid']) == 1) {
                        if ($user_permission['role_id'] == 2 or $user_permission['role_id'] == 1) {
                            $message = $internal_msg->getMessage($_GET['msgid']);
                            $replies = $internal_msg->getRepliesOf($_GET['msgid']);
                        }else{
                            $message = $internal_msg->getSupportMessages("AND Email = '".$user_permission['Email']."' AND Message_id = '".$_GET['msgid']."'")[0];
                            $replies = $internal_msg->getRepliesOf($message['Message_id']);
                        }
                        $internal_msg->change_to_seen($_GET['msgid']);
                        $datas = [
                            'message_info' => $message,
                            'replies' => $replies
                        ];
                        $this->MessageManagements();
                    }
                }
                break;
            case 'wallet_history':
                $wallet->Set_Email($user_permission['Email']);
                $history = $wallet->GetTransBy('Email',$user_permission['Email']);
                $datas = [
                    'wallet_history' => $history
                ];
                break;
            case 'withdrawal_management_client':
                $wallet->Set_Email($user_permission['Email']);
                $withdrawal_list = $wallet->select_withdrawal_requests("WHERE Email = '".$user_permission['Email']."' ORDER BY Submited_At");
               /* $managements = $this->WithdrawalRequestManagement_Client();
                if (!$managements['success']){
                    switch ($managements['type']){
                        case 'wallet_error':
                            message::msg_box_session_prepare("خطای کیف پول :".$managements['error'],"danger");
                            pager::go_page("/profile");
                            break;
                        case 'withdrawal_error':
                            message::msg_box_session_prepare("خطای برداشت : ".$managements['error'],"danger");
                            pager::go_page("/profile");
                            break;
                    }
                }*/
                $datas = [
                    'Withdrawals_list' => $withdrawal_list
                ];
                break;
            case 'withdrawal_management_admin':
                $withdrawal_list = $wallet->select_withdrawal_requests("");
                $datas = [
                    'Withdrawals_list' => $withdrawal_list
                ];
                break;
            case 'withdrawals_info':
                $module = new response_withdrawal_request();
                $module->callback();
                $info = $module->get_row();
                $balance = $module->get_wallet_balance();
                $datas = [
                    'withdrawal_info' => $info,
                    'begger_balance' => $balance,
                    'begger_wallet_is_valid' => $module->if_ok_begger_amount_with_balance()
                ];
                break;
            case 'withdrawalWallet':
                $this->WithdrawalRequestActions_Client();
                break;
            case 'add_internal_message':
                $module = new add_internal_message();
                $module->callback();
                $datas = [
                    'receivers_emails' => $module->get_receivers()
                ];
                break;
        }
        return $datas;
    }
    public function logout(){
        $witcher = new \witcher();
        $logs = new log();
        $witcher->requireConfig("tables");
        $login = new login();
        if ($login->is_login() == true){
            $db = new db();
            $table = new tables();
            $user_tbl = $table->MAIN_TABLES['user'];
            $logs->login_logger($_SESSION['Username'],"Logout");
            $witcher->unsetSession(['Certificate_Code','Password','Username']);
            $db->db_query("UPDATE $user_tbl SET Session_id = NULL , Log = 0  WHERE Username = '$_SESSION[Username]'");
            pager::go_page("/");
            exit;
        }else{
            pager::go_page("login");
            exit;
        }
    }
    public function Permissions(){
        $user = new user();
        $login = new login();
        if ($login->is_login() == true){
            $permission = $user->user_get_permission();
            $result = array_merge($permission,array("is_admin"=>$login->is_admin()));
            return $result;
        }else{
            return false;
        }
    }
    private function PanelActions(){
        if (isset($_GET['panelaction'])){
            $preg = new preg();
            $user = new user();
            $wallet = new wallet();
            $user_info = $user->user_get_certificate();
            switch ($_GET['panelaction']){
                case "editProfile":
                    if (isset($_GET['parts'])) {
                        if ($_SERVER['REQUEST_METHOD'] == "POST") {
                            try{
                                $NewPassword = $user_info['Password'];
                                if (isset($_POST['OldPassword'])){
                                    if (!empty($_POST['OldPassword'])){
                                    $oldpass = $_POST['OldPassword'];
                                    if (md5(sha1(md5($oldpass))) != $user_info['Password']){
                                        throw new \Exception("پسورد اشتباه است.");
                                    }
                                    if (!isset($_POST['NewPassword']) or !isset($_POST['rePassword'])){
                                        throw new \Exception("پسورد جدید وارد نشده است.");
                                    }
                                    if (strlen($_POST['NewPassword']) < 1 or strlen($_POST['rePassword']) < 1){
                                        throw new \Exception("پسورد جدید وارد نشده است.");
                                    }
                                    $newpass = $_POST['NewPassword'];
                                    $verifypass = $_POST['rePassword'];
                                    if ($newpass != $verifypass){
                                        throw new \Exception("فیلد های پسورد جدید با یکدیگر مطابقت ندارند.");
                                    }
                                    if ($preg->password($newpass) != 1 or strlen($newpass) > 150){
                                        throw new \Exception("پسورد نامعتبر است.");
                                    }
                                    $NewPassword = md5(sha1(md5($newpass)));
                                    }
                                }
                                $image_src = "";
                                if (isset($_FILES['Profile_Image'])){
                                    if ($_FILES['Profile_Image']['error'] == 0 ) {
                                        $upload = new upload();
                                        if ($_FILES['Profile_Image']['size'] > 300000) {
                                            throw new \Exception("حجم فایل نباید از ۳۰۰ کیلوبایت بیشتر باشد.");
                                        }
                                        $white_list = ['png', 'PNG', 'jpg', 'JPG'];
                                        $target_folder = "public_html/" . $user->Image_src_target;
                                        $newname = rand(100, 999);
                                        $uploader = $upload->Upload($white_list, $newname, $target_folder, $_FILES['Profile_Image']);
                                        if (isset($uploader['status'])) {
                                            if ($uploader['status'] != true) {
                                                throw new \Exception("فایل اپلود نشد.");
                                            }
                                        }
                                        if (strlen($user_info['Profile_Image']) > 0) {
                                            $old_image = explode("/", $user_info['Profile_Image']);
                                            $old_image = end($old_image);
                                            if (file_exists(DIR_PUBLIC . $user->Image_src_target . "/" . $old_image)) {
                                                unlink(DIR_PUBLIC . $user->Image_src_target . "/" . $old_image);
                                            }
                                        }
                                        $image_src = HTTP_SERVER . "/" . $user->Image_src_target . "/" . $upload->file_name . "." . $upload->get_end_file($_FILES['Profile_Image']);
                                    }
                                }
                                $user->UpdateUserTbl($NewPassword,$image_src,$user_info['Email']);
                                message::msg_box_session_prepare("موفق","success");
                            }catch (\Exception $e){
                                pager::redirect_page('0','/profile/editProfile');
                                message::msg_box_session_prepare($e->getMessage(),"danger");
                                exit();
                            }
                        }
                    }
                    break;
                case 'newWallet':
                    if (isset($_GET['parts'])){
                        if ($_GET['parts'] == "my_wallet"){
                            $wallet->Set_Email($user_info['Email']);
                            if (!$wallet->Is_Valid() or !$wallet->Exists_Wallet('Email',$user_info['Email'])){
                                $wallet->create_wallet(['First_Name' => $user_info['First_Name'],'Last_Name' => $user_info['Last_Name'],'Email' => $user_info['Email']]);
                                pager::go_page("/profile/wallet");
                            }
                        }
                    }
                    break;
            }
        }
    }
    public function PartIncluder(){
        $witcher = new \witcher();
        $preg = new preg();
        $wallet = new wallet();
        $user = new user();
        $user_info = $user->user_get_permission();
        if ($user_info['Admin'] == 1 ){
            $home = $witcher->root()."witcher/view/admin-panel/admin/home.php";
        }else{
            $home = $witcher->root()."witcher/view/admin-panel/admin/profile.php";
        }
        if (isset($_GET['parts']) AND strlen($_GET['parts']) < 50){
            $part = $_GET['parts'];
            if ($preg->custom("/^[a-zA-Z0-9_-]*$/i",$part)){
                $path = $witcher->root()."witcher/view/admin-panel/admin/".$part.".php";
                if (file_exists($path)){
                    if ($user_info['Admin'] == 1){
                        $white_list = array("calendar","contacts",
                            "landingpages","news","competition","personal-info","user_management","slider_management",
                            "menu_management","trans_management","wallet_management","news_management","editprofile","factor_management","mail_inbox","server-about",
                            "slider_info","admin_support_messages","view_support_message","withdrawal_management_admin","withdrawals_info",
                            "add_internal_message"
                        );
                    }else{
                        $white_list = array("editprofile","competition_history","buy_tickets","owned_tickets","factors_history",
                            "my_wallet","withdrawalWallet","depositWallet","mail_inbox","new_support_message","view_support_message",
                            "client_support_messages","contact_support","my_wallet_info","withdrawal_management_client"
                        );
                    }
                    if ($user_info['role_id'] == 2){ // if he was ADMINISTRATOR
                        $white_list = array_merge($white_list,[
                            "payment_setting","users_info","wallets_info"
                        ]);
                    }
                    if ($wallet->Exists_Wallet('Email',$user_info['Email'])){
                        $white_list = array_merge($white_list,[
                            "wallet_history"
                        ]);
                    }
                    $i = 0;
                    foreach ($white_list as $white){
                        if ($part == $white){
                            $i++;
                        }
                    }
                    if ($i == 1){
                        include $path;
                        $controller_path = $witcher->root()."witcher/app/controller/".$part.".php";
                        if (file_exists($controller_path)){
                            $name = "\Controller\ ".$part;
                            $name = str_replace(" ","",$name);
                            $object = new $name;
                            $object->start("Admin-panel");
                        }
                    }else{
                        goto home;
                    }
                }else{
                    goto home;
                }
            }else{
                goto home;
            }
        }elseif(!isset($_GET['parts'])){
            home:
            include $home;
        }
    }
    public function start_controller($class){
        $witcher = new \witcher();
        $witcher->requireController($class);
        $name = "\Controller\ ".$class;
        $name = str_replace(" ","",$name);
        $object = new $name;
        return $object->start();
    }
    private function getUserInfos(){
        $user = new user();
        return $user->user_get_certificate();
    }

    private function UserManagementActions(){
        $user = new user();
        $preg = new preg();
        $user_info = $user->user_get_permission();
        $user_role = $user->getUserRoleCats($user_info['Email']);
        if ($_GET['parts'] == "users_info"){
            $edit_user = $user->getUserInfoBy('Email',$_GET['email'])[0];
            $edit_permission = $user->user_get_permission(0,$edit_user['Email']);
            try{
                if ($edit_permission['Admin'] == 1 And $edit_permission['role_id'] == 2){
                    throw new \Exception("این کاربر به علت دسترسی اش نمیتواند مشخصاتش تغییر کند.");
                }
                if ($_SERVER['REQUEST_METHOD'] == "POST"){
                    if (!isset($_POST['Full_Name'])){
                        throw new \Exception("نام و نام خانوادگی فرستاده نشد.");
                    }
                    if (!isset($_POST['Username'])){
                        throw new \Exception("نام کاربری فرستاده نشد.");
                    }
                    if (!isset($_POST['newEmail'])){
                        throw new \Exception("ایمیل فرستاده نشد.");
                    }
                    if ($preg->custom('/^[a-zA-Zا-ی\s]*$/u',$_POST['Full_Name']) != 1){
                        throw new \Exception("نام و نام خانوادگی نامعتبر است.");
                    }
                    if ($preg->email($_POST['newEmail']) != 1){
                        throw new \Exception("نام و نام خانوادگی نامعتبر است.");
                    }
                     if ($preg->username($_POST['Username']) != 1){
                        throw new \Exception("نام کاربری نامعتبر است.");
                    }
                    if ($edit_user['Email'] != $_POST['newEmail']){
                        if ($user->CountUsersBy('Email',$_POST['newEmail']) > 0 ){
                            throw new \Exception("این ایمیل وجود دارد.");
                        }
                    }
                    if ($edit_user['Username'] != $_POST['Username']){
                        if ($user->CountUsersBy('Username',$_POST['Username']) > 0 ){
                            throw new \Exception("این نام کاربری وجود دارد.");
                        }
                    }
                    $newPer = [
                        'Participate_Competitions' => 0,
                        'Login' => 0,
                        'ReadUsers' => 0,
                        'WriteSite'=> 0,
                        'Admin' => 0,
                        'WriteUsers'=> 0,
                        'Message'=> 0,
                        'ReadMessage' => 0,
                        'role_id'  => $edit_permission['role_id']
                    ];
                    if (isset($_POST['Participate_Competitions'])){
                        $newPer['Participate_Competitions'] = 1;
                    }
                    if (isset($_POST['LoginPer'])){
                        $newPer['Login'] = 1;
                    }
                    if (isset($_POST['ReadUsers'])){
                        $newPer['ReadUsers'] = 1;
                    }
                    if (isset($_POST['WriteSite'])){
                        $newPer['WriteSite'] = 1;
                    }
                    if (isset($_POST['Admin'])){
                        $newPer['Admin'] = 1;
                    }
                    if (isset($_POST['WriteUsers'])){
                        $newPer['WriteUsers'] = 1;
                    }
                    if (isset($_POST['Message'])){
                        $newPer['Message'] = 1;
                    }
                    if (isset($_POST['ReadMessage'])){
                        $newPer['ReadMessage'] = 1;
                    }
                    if (isset($_POST['roles'])){
                        if ($preg->number($_POST['roles']) != 1){
                            throw new \Exception("نقش نامعتبر است.");
                        }
                        if (!$user->exist_role($_POST['roles'])){
                            throw new \Exception("نقش مورد نظر شما یافت نشد.");
                        }
                        $newPer['role_id'] = $_POST['roles'];
                    }
                    foreach ($newPer as $per_key => $per_value){
                        $user->UpdatePermission($per_key,$per_value,$edit_user['Email']);
                    }
                    $newpass = $edit_user['Password'];
                    if (isset($_POST['NewPassword'])){
                        if ($preg->password($_POST['NewPassword']) != 1){
                            throw new \Exception("پسورد نامعتبر است.");
                        }
                        if (strlen($_POST['NewPassword']) > 0) {
                            $newpass = md5(sha1(md5($_POST['NewPassword'])));
                        }
                    }
                    $image_src = "";
                    if (isset($_FILES['Profile_Image'])){
                        if ($_FILES['Profile_Image']['error'] == 0 ) {
                            $upload = new upload();
                            if ($_FILES['Profile_Image']['size'] > 300000) {
                                throw new \Exception("حجم فایل نباید از ۳۰۰ کیلوبایت بیشتر باشد.");
                            }
                            $white_list = ['png', 'PNG', 'jpg', 'JPG'];
                            $target_folder = "public_html/" . $user->Image_src_target;
                            $newname = rand(100, 999);
                            $uploader = $upload->Upload($white_list, $newname, $target_folder, $_FILES['Profile_Image']);
                            if (isset($uploader['status'])) {
                                if ($uploader['status'] != true) {
                                    throw new \Exception("فایل اپلود نشد.");
                                }
                            }
                            if (strlen($user_info['Profile_Image']) > 0) {
                                $old_image = explode("/", $user_info['Profile_Image']);
                                $old_image = end($old_image);
                                if (file_exists(DIR_PUBLIC . $user->Image_src_target . "/" . $old_image)) {
                                    unlink(DIR_PUBLIC . $user->Image_src_target . "/" . $old_image);
                                }
                            }
                            $image_src = HTTP_SERVER . "/" . $user->Image_src_target . "/" . $upload->file_name . "." . $upload->get_end_file($_FILES['Profile_Image']);
                        }
                    }
                    $user->UpdateUserTbl($newpass,$image_src,$edit_user['Email'],$_POST['newEmail'],$_POST['Full_Name'],$_POST['Username']);
                    message::msg_box_session_prepare("موفق","success");
                    pager::go_page('/profile?parts=user_management');
                }
            }catch (\Exception $e){
                pager::redirect_page('0','/profile?parts=user_management');
                message::msg_box_session_prepare($e->getMessage(),"danger");
                exit();
            }
        }elseif ($_GET['parts'] == "user_management") {
            if (isset($_GET['Action'])) {
                if (isset($_GET['User_id'])) {
                    $email = $_GET['User_id'];
                    $email_role = $user->user_get_permission(0,$email);
                    if ($preg->email($email) == 0) {
                        pager::redirect_page('0', '/profile?parts=user_management');
                        message::msg_box_session_prepare("ایمیل نا معبتر است.", "danger");
                        exit();
                    }
                    if (count($user->getUserInfoBy("Email", $email)) == 0) {
                        pager::redirect_page('0', '/profile?parts=user_management');
                        message::msg_box_session_prepare("ایمیل مورد نظر یافت نشد.", "warning");
                        exit();
                    }
                    if ($user->getUserRoleCats($email)['role_id'] == 2) {
                        pager::redirect_page('0', '/profile?parts=user_management');
                        message::msg_box_session_prepare("ادمین اصلی نمیتواند دسترسی اش تغییر کند.", "danger");
                        exit();
                    }
                    switch ($_GET['Action']) {
                        case "Change_Active_Permission":
                            if ($user_info['Admin'] == 1) {
                                if ($user_role['role_id'] < 2) {
                                    if ($email_role['Role_Id'] < 1) {
                                        $user->SwitchPermission("Active", "WHERE Email = '" . $email . "'", $email);
                                        if ($email_role['Role_Id'] < 1 and $email_role['Role_Id'] == -1) {
                                            $user->UpdateRolePermission($email, "0");
                                        } elseif ($email_role['Role_Id'] < 1 and $email_role['Role_Id'] == 0) {
                                            $user->UpdateRolePermission($email, "0");
                                        }
                                        pager::redirect_page('0', '/profile?parts=user_management');
                                        message::msg_box_session_prepare("دسترسی ورود کاربر مورد نظر تغییر یاقت.", "success");
                                        exit();
                                    } else {
                                        pager::redirect_page('0', '/profile?parts=user_management');
                                        message::msg_box_session_prepare("شما اجازه تغییر دسترسی این کاربر را ندارید.", "danger");
                                        exit();
                                    }
                                } elseif ($user_role['Role_Id'] == 2) {
                                    $user->SwitchPermission("Active", "WHERE Email = '" . $email . "'", $email);
                                    pager::redirect_page('0', '/profile?parts=user_management');
                                    message::msg_box_session_prepare("دسترسی ورود کاربر مورد نظر تغییر یاقت.", "success");
                                    exit();
                                }
                            } else {
                                pager::redirect_page('0', '/profile?parts=user_management');
                                message::msg_box_session_prepare("شما اجازه تغییر دسترسی این کاربر را ندارید.", "danger");
                                exit();
                            }
                            break;
                        case "Delete":
                            if ($user_info['Admin'] == 1 and $user_info['role_id'] > 0){
                                if ($email_role['Role_Id'] != 2){
                                    if ($user->delete($email_role['Email'])){
                                        pager::redirect_page('0', '/profile?parts=user_management');
                                        message::msg_box_session_prepare("موفق","success");
                                         exit();
                                    }
                                }
                            }else{
                                pager::redirect_page('0', '/profile?parts=user_management');
                                message::msg_box_session_prepare("شما اجازه تغییر دسترسی این کاربر را ندارید.", "danger");
                                exit();
                            }
                            break;
                    }
                }
            } elseif (!isset($_GET['Action'])) {
                if (isset($_POST['ActionNewPass'])) {
                    if (isset($_POST['NewPassword']) AND isset($_POST['email'])) {
                        if ($user_info['WriteUsers'] == 1 AND $user_info['role_id'] >= 2) {
                            if ($preg->password($_POST['NewPassword']) == 1) {
                                if (strlen($_POST['NewPassword']) == 0) {
                                    pager::redirect_page('0', "/profile?parts=user_management");
                                    message::msg_box_session_prepare("پسورد نمیتواند کمتر از 1 کارکتر باشد.", "warning");
                                    exit();
                                } elseif (strlen($_POST['NewPassword']) > 250) {
                                    pager::redirect_page('0', "/profile?parts=user_management");
                                    message::msg_box_session_prepare("پسورد نمیتواند از 250 رقم بیشتر باشد.", "warning");
                                    exit();
                                }
                                $newpass = md5(sha1(md5($_POST['NewPassword'])));
                                $user->UpdateColumn('Password', $newpass, "WHERE Email = '" . $_POST['email'] . "'");
                                pager::redirect_page('0', "/profile?parts=user_management");
                                message::msg_box_session_prepare("موفق", "success");
                                exit();
                            } else {
                                pager::redirect_page('0', "/profile?parts=user_management");
                                message::msg_box_session_prepare("پسورد نامعتبر است.", "warning");
                                exit();
                            }
                        }
                    }
                }
            }
        }
    }
    private function WalletClientActions(){
        if ($_SERVER['REQUEST_METHOD'] == "POST"){
            if (isset($_POST['type'])){
                if ($_POST['type'] == "edit_submit"){
                    try{
                        $preg = new preg();
                        if (!isset($_POST['First_Name'])){
                            throw new \Exception("نام یافت نشد");
                        }
                        if (!isset($_POST['Last_Name'])){
                            throw new \Exception("نام خانوادگی یافت نشد");
                        }
                        $firstname = $_POST['First_Name'];
                        $lastname = $_POST['Last_Name'];
                        if ($preg->custom('/^[a-zA-Zا-ی\s]*$/u',$firstname) != 1){
                            throw new \Exception("نام نامعتبر است.");
                        }
                        if ($preg->custom('/^[a-zA-Zا-ی\s]*$/u',$lastname) != 1){
                            throw new \Exception("نام خانوداگی نامعتبر است.");
                        }
                        $wallet = new wallet();
                        $user = new user();
                        $user_info = $user->user_get_certificate();
                        $firstname_update = $wallet->UpdateColumn('First_Name',$firstname,"WHERE Email = '".$user_info['Email']."'");
                        $lastname_update = $wallet->UpdateColumn('Last_Name',$lastname,"WHERE Email = '".$user_info['Email']."'");
                        if (!$firstname_update or !$lastname_update){
                            throw new \Exception("عملیات موفق نیست");
                        }
                        message::msg_box_session_prepare("موفق","success");
                        pager::go_page("/profile/wallet/edit");
                        exit();
                    }catch (\Exception $e){
                        message::msg_box_session_prepare($e->getMessage(),"warning");
                        pager::go_page("/profile/wallet/edit");
                        exit();
                    }
                }
            }
        }
    }
    private function WalletManagementActions(){
        if ($_GET['parts'] == "wallets_info"){
            if (isset($_GET['email'])){
                $user = new \Model\user();
                $wallet = new \Model\wallet();
                $wallet->Set_Email($_GET['email']);
                if (isset($_GET['action'])){
                    try{
                        $preg = new \Model\preg();
                        $wallet->Set_Wallet_Key();
                        switch($_GET['action']){
                        case "sum":
                            if ($_SERVER['REQUEST_METHOD'] == "POST"){
                                if (!isset($_POST['balance'])){
                                    throw new \Exception("مقدار تعیین نشد");
                                }
                                if ($preg->number($_POST['balance']) != 1){
                                    throw new \Exception("مقدار نامعتبر است");
                                }
                                $balance = $_POST['balance'];
                                if ($balance < 1){
                                    throw new \Exception("مقدار باید بزرگ تر از 0 باشد");
                                }
                                if ($wallet->SumToBalance($balance)){
                                    pager::redirect_page('0','/profile?parts=wallets_info&email='.$_GET['email']);
                                     message::msg_box_session_prepare("عملیات موفقیت آمیز بود","success");
                                    exit();
                                }else{
                                    throw new \Exception("عملیات ناموفق");
                                }
                            }
                            break;
                        case "dec":
                            if ($_SERVER['REQUEST_METHOD'] == "POST"){
                                if (!isset($_POST['balance'])){
                                    throw new \Exception("مقدار تعیین نشد");
                                }
                                if ($preg->number($_POST['balance']) != 1){
                                    throw new \Exception("مقدار نامعتبر است");
                                }
                                $balance = $_POST['balance'];
                                if ($balance < 1){
                                    throw new \Exception("مقدار باید بزرگ تر از 0 باشد");
                                }
                                if ($balance > $wallet->Get_Balance()){
                                    throw new \Exception("مقدار نمیتواند از اعتبار بیشتر باشد");
                                }
                                if ($wallet->DecBalance($balance)){
                                    pager::redirect_page('0','/profile?parts=wallets_info&email='.$_GET['email']);
                                     message::msg_box_session_prepare("عملیات موفقیت آمیز بود","success");
                                    exit();
                                }else{
                                    throw new \Exception("عملیات ناموفق");
                                }
                            }
                            break;
                        case "active":
                            $where = "WHERE Email = '".$_GET['email']."'";
                            $wallet->UpdateColumn('Active_Status', '1', $where);
                            pager::redirect_page('0','/profile?parts=wallets_info&email='.$_GET['email']);
                            message::msg_box_session_prepare("عملیات موفقیت آمیز بود","success");
                            exit();
                            break;
                        case "deactive":
                            $where = "WHERE Email = '".$_GET['email']."'";
                            $wallet->UpdateColumn('Active_Status', '0', $where);
                            pager::redirect_page('0','/profile?parts=wallets_info&email='.$_GET['email']);
                            message::msg_box_session_prepare("عملیات موفقیت آمیز بود","success");
                            exit();
                            break;
                        case "validit":
                            $where = "WHERE Email = '".$_GET['email']."'";
                            $wallet->UpdateColumn('Wallet_Key', $wallet->Set_Wallet_Key(), $where);
                            pager::redirect_page('0','/profile?parts=wallets_info&email='.$_GET['email']);
                            message::msg_box_session_prepare("عملیات موفقیت آمیز بود","success");
                            exit();
                            break;
                        case "delete":
                            if ($wallet->Delete()){
                               pager::redirect_page('0','/profile?parts=wallets_info&email='.$_GET['email']);
                            message::msg_box_session_prepare("عملیات موفقیت آمیز بود","success");
                            exit(); 
                            }else{
                                throw new \Exception("عملیات ناموفق");
                            }
                            break;
                        case "create":
                            $user_permission = $user->user_get_permission(0,$_GET['email']);
                            if ($user_permission['role_id'] == 2){
                                throw new \Exception("ادمین نمیتواند کیف پول داشته باشد");
                            }
                            $create = $wallet->create_wallet(['First_Name' => "", 'Last_Name' => "",'Email' => $_GET['email']]);
                            pager::redirect_page('0','/profile?parts=wallets_info&email='.$_GET['email']);
                            message::msg_box_session_prepare("عملیات موفقیت آمیز بود","success");
                            exit(); 
                            break;
                        } 
                    }catch(\Exception $e){
                        pager::redirect_page('0','/profile?parts=wallets_info&email='.$_GET['email']);
                        message::msg_box_session_prepare($e->getMessage(),"danger");
                        exit();
                    }
                }
                
            }
        }else{
            if (isset($_GET['action'])){
            $preg = new preg();
            $user = new user();
            $wallet = new wallet();
            $witcher = new \witcher();
            if ($_GET['action'] == "Change_all_active"){
                $wallet->UpdateColumn('Active_Status','1',"");
                pager::redirect_page('0','/profile?parts=wallet_management');
                message::msg_box_session_prepare("همه ی کیف پول ها فعال شدند.","success");
                exit();
            }elseif ($_GET['action'] == "Change_all_deactive"){
                $wallet->UpdateColumn('Active_Status','0',"");
                pager::redirect_page('0','/profile?parts=wallet_management');
                message::msg_box_session_prepare("همه ی کیف پول ها غیرفعال شدند.","danger");
                exit();
            }
            if (isset($_GET['wallet_key'])){
                try{
                    if ($preg->md5($_GET['wallet_key']) != 1){
                        throw new \Exception("کلید کیف پول نامعتبر است.");
                    }
                    if (!$wallet->Exists_Wallet('Wallet_Key',$_GET['wallet_key'])){
                        throw new \Exception("این کیف پول وجود ندارد");
                    }
                    $wallet_info = $wallet->GetWalletBy('Wallet_Key',$_GET['wallet_key']);
                    switch ($_GET['action']){
                        case "change_stat":
                            $where = "WHERE Email = '".$wallet_info[0]['Email']."'";
                            if ($wallet_info[0]['Active_Status'] == 1) {
                                $wallet->UpdateColumn('Active_Status', '0', $where);
                                pager::redirect_page('0','/profile?parts=wallet_management');
                                message::msg_box_session_prepare("کیف پول غیرفعال گردید.","success");
                                exit();
                            }else{
                                $wallet->UpdateColumn('Active_Status', '1', $where);
                                pager::redirect_page('0','/profile?parts=wallet_management');
                                message::msg_box_session_prepare("کیف پول فعال گردید.","success");
                                exit();
                            }
                            break;
                        case "add_balance":
                            if (isset($_POST['add_balance'])) {
                                if (isset($_POST['balance'])) {
                                    $balance = $_POST['balance'];
                                    if ($preg->number($balance) != 1) {
                                        throw new \Exception("مبلغ نامعتبر است.");
                                    }
                                    if ($balance <= 0 ){
                                        throw new \Exception("مبلغ کمتر از میزان تعیین شده است.");
                                    }
                                    $wallet->Set_Email($wallet_info[0]['Email']);
                                    if ($wallet->SumToBalance($balance)){
                                        pager::redirect_page('0','/profile?parts=wallet_management');
                                        message::msg_box_session_prepare("عملیات با موفقیت انجام شد.","success");
                                        exit();
                                    }else{
                                        throw new \Exception("عملیات موفقیت امیز نیست.");
                                    }
                                }
                            }
                            break;
                    }
                }catch (\Exception $e){
                    pager::redirect_page('0','/profile?parts=wallet_management');
                    message::msg_box_session_prepare($e->getMessage(),"warning");
                    exit();
                }
            }
        }   
        }
    }
    private function SliderManagementActions(){
            $user = new user();
            $preg = new preg();
            $interfaces = new interfaces();
        if ($_GET['parts'] == "slider_info"){
            if ($_SERVER['REQUEST_METHOD'] == "POST"){
                try{
                    if (!isset($_POST['type'])){
                        throw new \Exception("نوع مشخص نشد");
                    }   
                    if ($preg->number($_GET['id']) != 1){
                        throw new \Exception("شماره اسلایدر نامعتبر است");
                    }
                    switch($_POST['type']){
                        case "main":
                            $slider_rows = $interfaces->GetSlidersByStatement("WHERE id = '" . $_GET['id'] . "'");
                            if (count($slider_rows) > 0) {
                                $slider_info = $interfaces->GetSlidersByStatement("where id = '" . $_GET['id'] . "'");
                                        if (!isset($_POST['Header_Text']) or
                                            !isset($_POST['Content_Text']) or
                                            !isset($_POST['Button_Text']) or
                                            !isset($_POST['Href_Url']) or
                                            !isset($_POST['Button_Color'])) {
                                            throw new \Exception("مقدارهای کافی ست نشده اند.");
                                        }
                                        if (strlen($_POST['Header_Text']) > 250 or strlen($_POST['Content_Text']) > 250 or strlen($_POST['Href_Url']) > 250 ) {
                                            throw new \Exception("عنوان و توضیحات و لینک باید بین 1 کارکتر تا 250 باشند.");
                                        }
                                        $activeStat = 0;
                                        $buttonStat = 0;
                                        if ($_POST['Button_Status'] == "on"){
                                            $buttonStat = 1;
                                        }
                                        if ($_POST['Active_Status'] == "on"){
                                            $activeStat = 1;
                                        }
                                        $headerT = $_POST['Header_Text'];
                                        $contentT = $_POST['Content_Text'];
                                        $buttonText = $_POST['Button_Text'];
                                        $buttonColor = $_POST['Button_Color'];
                                        $hrefUrl = $_POST['Href_Url'];
                                        if ($preg->text($headerT) != 1 or $preg->text($contentT) != 1 or $preg->custom('/^[a-zA-Z0-9آ-ی?!@#$&()-:,.\/_\s]*$/u', $hrefUrl) != 1) {
                                            throw new \Exception("عنوان و توضیحات و لینک نامعتبراند.");
                                        }
                                        $interfaces->SetImagesPath("img/slider");
                                        $interfaces->SetIconPath("img/slider/icon");
                                        $array = [
                                            'Big_Image' => "",
                                            'Icon_Image' => "",
                                            'Active_Status' => $activeStat,
                                            'Button_Status' => $buttonStat,
                                            'Header_Text' => $headerT,
                                            'Content_Text' => $contentT,
                                            'Href_Url' => $hrefUrl,
                                            'Button_Status' => $buttonStat,
                                            'Button_Text' => $buttonText,
                                            'Button_Color' => $buttonColor,
                                            'Published_At' => "",
                                            'Published_By' => $_POST['Published_By']
                                        ];
                                        if (isset($_FILES['Big_Image'])) {
                                            if ($_FILES['Big_Image']['size'] > 300000){
                                                throw new \Exception("حجم فایل نباید بیش از 300 کیلوبایت باشد.");
                                            }
                                            if ($_FILES['Big_Image']['error'] == 0) {
                                                $array['Big_Image'] = $_FILES['Big_Image'];
                                            }
                                        }
                                        if (isset($_FILES['Icon_Image'])) {
                                            if ($_FILES['Icon_Image']['size'] > 300000){
                                                throw new \Exception("حجم فایل نباید بیش از 300 کیلوبایت باشد.");
                                            }
                                            if ($_FILES['Icon_Image']['error'] == 0) {
                                                $array['Icon_Image'] = $_FILES['Icon_Image'];
                                            }
                                        }
                                        $interfaces->SetSliderValues($array);
                                        pager::redirect_page('0', '/profile?parts=slider_info&id='.$_GET['id']);
                                        $interfaces->UpdateSlider($_GET['id'],$_POST['Published_By']);
                                        message::msg_box_session_prepare("موفق","success");
                                        exit();
                               
                            }
                            break;
                        case "action":
                            if (!isset($_POST['action'])){
                                throw new \Exception("نوع عملیات مشخص نشد");
                            }
                            switch ($_POST['action']){
                                case "delete":
                                    
                                    break;
                            }
                            break;
                    }
                }catch(\Exception $e){
                    pager::redirect_page('0', "/profile?parts=slider_info&id=".$_GET['id']);
                    message::msg_box_session_prepare($e->getMessage(),"warning");
                    exit();
                }
            }
        }
    }
    private function PaymentManagementActions(){
        if (isset($_GET['action'])){
            $preg = new preg();
            $payment = new payment();
            switch ($_GET['action']){
                case "edit":
                    if (isset($_GET['id'])){
                        try{
                            if ($preg->number($_GET['id']) != 1){
                                throw new \Exception("ردیف یافت نشد.");
                            }
                            if (!$payment->exists_of_or_fail([$_GET['id']],0)['status']){
                                throw new \Exception("ردیف یافت نشد.");
                            }
                            $id = $_GET['id'];
                            if (isset($_POST['EditSubmit'])){
                                if (!isset($_POST['Method'])){
                                    throw new \Exception("نام متود باید تکمیل شود.");
                                }
                                if ($preg->custom('/^[a-zA-Z0-9ا-ی-_.\s]*$/u',$_POST['Method']) != 1){
                                    throw new \Exception("نام متود نامعتبر است.");
                                }
                                if (!isset($_POST['Currency'])){
                                    throw new \Exception("واحدها باید تکمیل شود.");
                                }
                                if ($preg->custom('/^[a-zA-Z0-9\s]*$/u',$_POST['Currency']) != 1){
                                    throw new \Exception("واحدها نامعتبر است.");
                                }
                                if (!isset($_POST['ApiKey'])){
                                    throw new \Exception("کلید api باید تکمیل شود.");
                                }
                                if ($preg->custom('/^[a-zA-Z0-9]*$/u',$_POST['ApiKey']) != 1){
                                    throw new \Exception("کلید api نامعتبر است.");
                                }
                                if (!isset($_POST['Url'])){
                                    throw new \Exception("لینک باید تکمیل شود.");
                                }
                                if ($preg->custom('/^[a-zA-Z0-9ا-ی-?!#:;&\/_.\s]*$/u',$_POST['Method']) != 1){
                                    throw new \Exception("لینک نامعتبر است.");
                                }
                                if (!isset($_POST['Checker_url'])){
                                    throw new \Exception("لینک باید تکمیل شود.");
                                }
                                if ($preg->custom('/^[a-zA-Z0-9ا-ی-?!#:;&\/_.\s]*$/u',$_POST['Checker_url']) != 1){
                                    throw new \Exception("لینک نامعتبر است.");
                                }
                                if (!isset($_POST['Callback'])){
                                    throw new \Exception("لینک برگشت تعیین نشد.");
                                }
                                if ($preg->custom('/^[a-zA-Z0-9ا-ی-?!#:;&\/_.\s]*$/u',$_POST['Callback']) != 1){
                                    throw new \Exception("لینک نامعتبر است.");
                                }
                                $method = $_POST['Method'];
                                $callback = $_POST['Callback'];
                                $currency = $_POST['Currency'];
                                $apikey = $_POST['ApiKey'];
                                $url = $_POST['Url'];
                                if ($payment->updateTbl("Payment_Method = '".$method."' , Currency = '".$currency."' , Api_Key = '".$apikey."' , Url = '".$url."' , Last_editor = 'ADMINISTRATOR' , Callback = '".$callback."' , Checker_url = '".$_POST['Checker_url']."'","WHERE Cat_id = '".$id."'")){
                                    pager::redirect_page('0','/profile/setting/payments');
                                    message::msg_box_session_prepare("موفق","success");
                                    exit();
                                }else{
                                    throw new \Exception("ناموفق");
                                }
                            }
                        }catch (\Exception $e){
                            pager::redirect_page('0','/profile/setting/payments');
                            message::msg_box_session_prepare($e->getMessage(),"danger");
                            exit();
                        }
                    }
                    break;
                case "changeStat":
                    if (isset($_GET['id'])){
                        try {
                            if ($preg->number($_GET['id']) != 1) {
                                throw new \Exception("ردیف یافت نشد.");
                            }
                            if (!$payment->exists_of_or_fail([$_GET['id']],0)['status']){
                                throw new \Exception("ردیف یافت نشد.");
                            }
                            $id = $_GET['id'];
                            $oldCat = $payment->getCatBy('Cat_id',$_GET['id'])[0];
                            if ($oldCat['Status'] == 1){
                                $payment->updateTbl("Status = '0'","WHERE Cat_id = '".$id."'");
                            }else{
                                $payment->updateTbl("Status = '1'","WHERE Cat_id = '".$id."'");
                            }
                            pager::redirect_page('0','/profile/setting/payments');
                            message::msg_box_session_prepare("موفق","success");
                            exit();
                        }catch (\Exception $i){
                            pager::redirect_page('0','/profile/setting/payments');
                            message::msg_box_session_prepare($i->getMessage(),"danger");
                            exit();
                        }
                    }
                    break;
                case "new":
                        try {
                            if (isset($_POST['NewSubmit'])){
                                if (!isset($_POST['Method'])){
                                    throw new \Exception("نام متود باید تکمیل شود.");
                                }
                                if ($preg->custom('/^[a-zA-Z0-9ا-ی-_.\s]*$/u',$_POST['Method']) != 1){
                                    throw new \Exception("نام متود نامعتبر است.");
                                }
                                if (!isset($_POST['Currency'])){
                                    throw new \Exception("واحدها باید تکمیل شود.");
                                }
                                if ($preg->custom('/^[a-zA-Z0-9\s]*$/u',$_POST['Currency']) != 1){
                                    throw new \Exception("واحدها نامعتبر است.");
                                }
                                if (!isset($_POST['ApiKey'])){
                                    throw new \Exception("کلید api باید تکمیل شود.");
                                }
                                if ($preg->custom('/^[a-zA-Z0-9]*$/u',$_POST['ApiKey']) != 1){
                                    throw new \Exception("کلید api نامعتبر است.");
                                }
                                if (!isset($_POST['Url'])){
                                    throw new \Exception("لینک باید تکمیل شود.");
                                }
                                if ($preg->custom('/^[a-zA-Z0-9ا-ی-?!#&\/_.\s]*$/u',$_POST['Method']) != 1){
                                    throw new \Exception("لینک نامعتبر است.");
                                }
                                if (!isset($_POST['Checker_url'])){
                                    throw new \Exception("لینک باید تکمیل شود.");
                                }
                                if ($preg->custom('/^[a-zA-Z0-9ا-ی-?!#:;&\/_.\s]*$/u',$_POST['Checker_url']) != 1){
                                    throw new \Exception("لینک نامعتبر است.");
                                }
                                if (!isset($_POST['Callback'])){
                                    throw new \Exception("لینک برگشت تعیین نشد.");
                                }
                                if ($preg->custom('/^[a-zA-Z0-9ا-ی-?!#:;&\/_.\s]*$/u',$_POST['Callback']) != 1){
                                    throw new \Exception("لینک نامعتبر است.");
                                }
                                $method = $_POST['Method'];
                                $callback = $_POST['Callback'];
                                $checker= $_POST['Checker_url'];
                                $currency = $_POST['Currency'];
                                $apikey = $_POST['ApiKey'];
                                $url = $_POST['Url'];
                                retry :
                                $cat = rand(1,1000);
                                if ($payment->exists_of_or_fail([$cat],0)['status']){
                                    goto retry;
                                }
                                if ($payment->newCat($method,$currency,$apikey,$url,'1',$cat,$callback,$checker)){
                                    pager::redirect_page('0','/profile/setting/payments');
                                    message::msg_box_session_prepare("موفق","success");
                                    exit();
                                }
                            }
                        }catch (\Exception $a){
                            pager::redirect_page('0','/profile/setting/payments/new');
                            message::msg_box_session_prepare($a->getMessage(),"danger");
                            exit();
                        }
                    break;
            }
        }
    }
    private function AdminActions(){
        if (isset($_GET['panelaction'])) {
            $preg = new preg();
            $user = new user();
            $wallet = new wallet();
            $user_info = $user->user_get_certificate();
            if (isset($_GET['parts'])) {
                switch ($_GET['panelaction']){
                    case "editProfile":
                        if ($_SERVER['REQUEST_METHOD'] == "POST") {
                            try {
                                $image_src = "";
                                if (isset($_FILES['Profile_Image'])) {
                                    if ($_FILES['Profile_Image']['error'] == 0) {
                                        $upload = new upload();
                                        if ($_FILES['Profile_Image']['size'] > 300000) {
                                            throw new \Exception("حجم فایل نباید از ۳۰۰ کیلوبایت بیشتر باشد.");
                                        }
                                        $white_list = ['png', 'PNG', 'jpg', 'JPG'];
                                        $target_folder = "public_html/" . $user->Image_src_target;
                                        $newname = rand(100, 999);
                                        $uploader = $upload->Upload($white_list, $newname, $target_folder, $_FILES['Profile_Image']);
                                        if (isset($uploader['status'])) {
                                            if ($uploader['status'] != true) {
                                                throw new \Exception("فایل اپلود نشد.");
                                            }
                                        }
                                        if (strlen($user_info['Profile_Image']) > 0) {
                                            $old_image = explode("/", $user_info['Profile_Image']);
                                            $old_image = end($old_image);
                                            if (file_exists(DIR_PUBLIC . $user->Image_src_target . "/" . $old_image)) {
                                                unlink(DIR_PUBLIC . $user->Image_src_target . "/" . $old_image);
                                            }
                                        }
                                        $image_src = HTTP_SERVER . "/" . $user->Image_src_target . "/" . $upload->file_name . "." . $upload->get_end_file($_FILES['Profile_Image']);
                                    }
                                }
                                $NewPassword = $user_info['Password'];
                                if (isset($_POST['OldPassword'])) {
                                    if (!empty($_POST['OldPassword'])) {
                                        $oldpass = $_POST['OldPassword'];
                                        if (md5(sha1(md5($oldpass))) != $user_info['Password']) {
                                            throw new \Exception("پسورد اشتباه است.");
                                        }
                                        if (!isset($_POST['NewPassword']) or !isset($_POST['rePassword'])) {
                                            throw new \Exception("پسورد جدید وارد نشده است.");
                                        }
                                        if (strlen($_POST['NewPassword']) < 1 or strlen($_POST['rePassword']) < 1) {
                                            throw new \Exception("پسورد جدید وارد نشده است.");
                                        }
                                        $newpass = $_POST['NewPassword'];
                                        $verifypass = $_POST['rePassword'];
                                        if ($newpass != $verifypass) {
                                            throw new \Exception("فیلد های پسورد جدید با یکدیگر مطابقت ندارند.");
                                        }
                                        if ($preg->password($newpass) != 1 or strlen($newpass) > 150) {
                                            throw new \Exception("پسورد نامعتبر است.");
                                        }
                                        $NewPassword = md5(sha1(md5($newpass)));
                                    }
                                }
                                $user->UpdateUserTbl($NewPassword, $image_src, $user_info['Email']);
                                pager::redirect_page('0', '/profile/editProfile');
                                message::msg_box_session_prepare("موفق","success");
                                exit();
                            } catch (\Exception $e) {
                                pager::redirect_page('0', '/profile/editProfile');
                                message::msg_box_session_prepare($e->getMessage(),"danger");
                                exit();
                            }
                        }
                        break;
                }
            }
        }
    }
    private function ServerManagements(){
            $preg = new preg();
            $user = new user();
                    if (isset($_POST['ServerEditSubmit'])){
                        if (isset($_GET['Action'])) {
                            if (isset($_FILES['Logo_file'])) {
                                $upload = new upload();
                                $name = "logo";
                                $whitelist = ['png', 'PNG'];
                                if ($_FILES['Logo_file']['size'] > 290000) {
                                    pager::redirect_page('0', '/profile/setting/server-about');
                                    message::msg_box_session_prepare("حجم فایل مورد نظر برای آپلود نمیتواند از 290 کلیوبایت بیشتر باشد.", "danger");
                                    exit();
                                }
                                $witcher = new \witcher();
                                if (file_exists($witcher->root() . "public_html/img/logo.png")) {
                                    unlink($witcher->root() . "public_html/img/logo.png");
                                }
                                $uploadfile = $upload->Upload($whitelist, $name, "public_html/img", $_FILES['Logo_file']);
                                if (isset($uploadfile['status'])) {
                                    if (!$uploadfile['status']) {
                                        switch ($uploadfile['cause']) {
                                            case "format":
                                                pager::redirect_page('0', '/profile/setting/server-about');
                                                message::msg_box_session_prepare("فورمت فایل باید png باشد.", "warning");
                                                exit();
                                                break;
                                            case "error_check_failed":
                                                pager::redirect_page('0', '/profile/setting/server-about');
                                                message::msg_box_session_prepare("فایل آپلود نشد.", "warning");
                                                exit();
                                                break;
                                        }
                                    }
                                } else {
                                    pager::redirect_page('0', '/profile/setting/server-about');
                                    message::msg_box_session_prepare("موفق", "success");
                                    exit();
                                }
                            }/*
                            if (isset($_FILES['header_icon_file'])) {
                                $upload = new upload();
                                $name = "headerlogo";
                                $whitelist = ['png', 'PNG','svg','ico'];
                                if ($_FILES['header_icon_file']['size'] > 290000) {
                                    pager::redirect_page('0', '/profile/setting/server-about');
                                    message::msg_box_session_prepare("حجم فایل مورد نظر برای آپلود نمیتواند از 290 کلیوبایت بیشتر باشد.", "danger");
                                    exit();
                                }
                                $witcher = new \witcher();
                                if (file_exists($witcher->root() . "public_html/img/logo.png")) {
                                    unlink($witcher->root() . "public_html/img/headerlogo.png");
                                }
                                $uploadfile = $upload->Upload($whitelist, $name, "public_html/img", $_FILES['Logo_file']);
                                if (isset($uploadfile['status'])) {
                                    if (!$uploadfile['status']) {
                                        switch ($uploadfile['cause']) {
                                            case "format":
                                                pager::redirect_page('0', '/profile/setting/server-about');
                                                message::msg_box_session_prepare("فورمت فایل باید png باشد.", "warning");
                                                exit();
                                                break;
                                            case "error_check_failed":
                                                pager::redirect_page('0', '/profile/setting/server-about');
                                                message::msg_box_session_prepare("فایل آپلود نشد.", "warning");
                                                exit();
                                                break;
                                        }
                                    }
                                } else {
                                    pager::redirect_page('0', '/profile/setting/server-about');
                                    message::msg_box_session_prepare("موفق", "success");
                                    exit();
                                }
                            }*/
                        }
                        try{
                            if (!isset($_POST['Website_Name'])){
                                throw new \Exception("نام وبسایت یافت نشد.");
                            }
                            if (!isset($_POST['Email'])){
                                throw new \Exception("ایمیل پشتیبانی یافت نشد.");
                            }
                            if (!isset($_POST['Telegram'])){
                                throw new \Exception("آدرس تلگرام یافت نشد.");
                            }
                            if ($preg->custom('/^[a-zA-Zآ-ی\s]*$/u',$_POST['Website_Name']) != 1){
                                throw new \Exception("نام وبسایت نامعتبر است.");
                            }
                            if ($preg->email($_POST['Email']) != 1){
                                throw new \Exception("ایمیل پشتیبانی نامعتبر است.");
                            }
                            if ($preg->text($_POST['Telegram']) != 1){
                                throw new \Exception("آدرس تلگرام نامعتبر است.");
                            }
                            $server = new \Model\server();
                            if (!$server->updateStatement("Title = '".$_POST['Website_Name']."' , Email = '".$_POST['Email']."' , Telegram = '".$_POST['Telegram']."' WHERE Status = '1'")){
                                throw new \Exception("عملیات موفقیت آمیز نیست.");
                            }
                            pager::redirect_page('0','/profile/setting/server-about');
                            message::msg_box_session_prepare("موفق","success");
                            exit();
                        }catch (\Exception $e){
                            pager::redirect_page('0','/profile/setting/server-about');
                            message::msg_box_session_prepare($e->getMessage(),"warning");
                            exit();
                        }
                    }
    }
    private function MessageManagements(){
        $parts = $_GET['parts'];
        $user = new user();
        $preg = new preg();
        $internal_msg = new internal_mail();
        $user_permission = $user->user_get_permission();
        $user_info = $user->user_get_certificate();
        switch ($parts){
            case "view_support_message":
                if ($_SERVER['REQUEST_METHOD'] == "POST" and isset($_GET['msgid'])){
                    if (isset($_POST['type'])){
                        if ($_POST['type'] == "replying"){
                            try{
                                if ($preg->md5($_GET['msgid']) != 1){
                                    throw new \Exception("شماره پیام نامعتبر است");
                                }
                                if (!$internal_msg->is_existed($_GET['msgid'])){
                                    throw new \Exception("این پیام وجود ندارد");
                                }
                                if (!isset($_POST['Texts'])){
                                    throw new \Exception("پیام دریافت نشد");
                                }
                                if (strlen($_POST['Texts']) < 9){
                                    throw new \Exception("پیام حداقل باید 10 کارکتر باشد");
                                }
                                if (strlen($_POST['Texts']) > 749){
                                    throw new \Exception("پیام حداکثر باید 780 کارکتر باشد");
                                }
                                if (!$internal_msg->setMessage($_POST['Texts'])){
                                    throw new \Exception("پیام نامعتبر است");
                                }
                                if ($user_permission['role_id'] >= 1){
                                    $nickname = "Support";
                                }else{
                                    $nickname = $user_info['Email'];
                                }
                                if (!$internal_msg->setSender_Email($nickname)){
                                    throw new \Exception("خطای سیستم! لطفا با ادمین تماس بگیرید");
                                }
                                $message_info = $internal_msg->getMessage($_GET['msgid']);
                                if (!$internal_msg->setReceiver_Email($message_info['Email'])){
                                    throw new \Exception("ایمیل دریافت کننده یافت نشد");
                                }
                                if (!$internal_msg->newSupportReply($_GET['msgid'])){
                                    throw new \Exception("موفقیت آمیز نیست");
                                }
                                pager::redirect_page('0','/profile/support_messages/view?msgid='.$_GET['msgid']);
                                message::msg_box_session_prepare("موفق","success");
                                exit();
                            }catch (\Exception $e){
                                pager::redirect_page('0','/profile/support_messages');
                                message::msg_box_session_prepare($e->getMessage(),"warning");
                                exit();
                            }
                        }
                    }
                }
                break;
        }
        if ($user_permission['role_id'] >= 1){
            if (isset($_GET['delete'])){
                if ($internal_msg->delete("WHERE Message_id = '".$_GET['msgid']."'")){
                    pager::redirect_page('0','/profile/support_messages');
                    message::msg_box_session_prepare("موفق","success");
                    exit();
                }
            }
        }else{
            switch ($parts){
                case "new_support_message":
                    if ($_SERVER['REQUEST_METHOD'] == "POST"){
                        try{
                            if (!$internal_msg->setReceiver_Nickname("Support")){
                                throw new \Exception("نام دریافت کننده یافت نشد ( خطای سیستم )");
                            }
                            if (!$internal_msg->setSender_Email($user_permission['Email'])){
                                throw new \Exception("ایمیل فرستنده یافت نشد");
                            }
                            if (!isset($_POST['Subject'])){
                                throw new \Exception("موضوع یافت نشد");
                            }
                            if (!$internal_msg->setSubject($_POST['Subject'])){
                                throw new \Exception("موضوع نامعتبر است");
                            }
                            if (!isset($_POST['Texts'])){
                                throw new \Exception("پیام یافت نشد");
                            }
                            if (!$internal_msg->setMessage($_POST['Texts'])){
                                throw new \Exception("پیام نامعتبر است");
                            }
                            $internal_msg->newSupportRequest();
                            pager::redirect_page('0','/profile/support/new');
                            message::msg_box_session_prepare("موفق","success");
                            exit();
                        }catch (\Exception $e){
                            pager::redirect_page('0','/profile/support/new');
                            message::msg_box_session_prepare($e->getMessage(),"warning");
                            exit();
                        }
                    }
                    break;
            }
        }
    }
    private function WithdrawalRequestManagement_Client(){
        $wallet = new \Model\wallet();
        $user = new user();
        $user_info = $user->user_get_certificate();
        $permission = $user->user_get_permission();
        $wallet->Set_Email($user_info['Email']);
        $wallet_errors = ['type' => 'wallet_error','status' => false,'error' => null,'success' => false];
        try{
            if (!$wallet->Exists_Wallet('Email',$user_info['Email'])){
                throw new \Exception("این کیف پول وجود ندارد");
            }
            if (!$wallet->Is_Valid()){
                throw new \Exception("این کیف پول نامعتبر است");
            }
            if (!$wallet->Is_Active()){
                throw new \Exception("این کیف پول غیرفعال است");
            }
        }catch (\Exception $e){
            $wallet_errors = ['type' => 'wallet_error','status' => true,'error' => $e->getMessage(),'success' => false];
        }
        if (!$wallet_errors['status'] && $wallet_errors['error'] === null){
            $withdrawal_errors = ['type' => 'withdrawal_error','status' => false,'error' => null,'success' => false];
            try{
                $withdrawal_checking = $wallet->Check_Today_Withdrawal_For_User();
                if ($withdrawal_checking['Limit']){
                    throw new \Exception("محدودیت برداشت روزانه (".$withdrawal_checking['Amount'].")");
                }
            }catch (\Exception $e2){
                $withdrawal_errors = ['type' => 'withdrawal_error','status' => true,'error' => $e2->getMessage(),'success' => false];
            }
            if (!$withdrawal_errors['status']){
                return ['type' => 'result','status' => false,'error' => null,'success' => true];
            }else{
                return $withdrawal_errors;
            }
        }else{
            return $wallet_errors;
        }
    }
    private function WithdrawalRequestManagement_Admin(){
        $wallet = new \Model\wallet();
        $user = new user();
        $user_info = $user->user_get_certificate();
        $user_permission = $user->user_get_permission();
    }
    private function WithdrawalRequestActions_Client(){
        $user = new user();
        $preg = new preg();
        $user_info = $user->user_get_certificate();
        $wallet = new wallet();
        if (isset($_GET['withdrawal_request_actions'])){
            switch ($_GET['withdrawal_request_actions']){
                case 'new':
                    $management = $this->WithdrawalRequestManagement_Client();
                    if (!$management['success']){
                        switch ($management['type']){
                            case 'wallet_error':
                                message::msg_box_session_prepare("خطای کیف پول :".$management['error'],"danger");
                                pager::go_page("/profile");
                                break;
                            case 'withdrawal_error':
                                message::msg_box_session_prepare("خطای برداشت : ".$management['error'],"danger");
                                pager::go_page("/profile");
                                break;
                        }
                    }else{
                        if ($_SERVER['REQUEST_METHOD'] == "POST"){
                            try{
                                if (!isset($_POST['amount'])){
                                    throw new \Exception("مبلغ تعیین نشد");
                                }
                                $amount = $_POST['amount'];
                                if ($preg->number($amount) != 1){
                                    throw new \Exception("مبلغ نامعتبر است");
                                }
                                if ($amount < 1000){
                                    throw new \Exception("مبلغ کمتر از 1000 تومان نمیتواند برداشت شود");
                                }
                                $wallet->Set_Email($user_info['Email']);
                                $balance = $wallet->Get_Balance();
                                if ($amount > $balance){
                                    throw new \Exception("موجودی کیف پول کافی نمی باشد");
                                }
                                if ($wallet->add_withdrawal_request($amount)){
                                    message::msg_box_session_prepare("این درخواست ثبت شد","success");
                                    pager::go_page('/profile/wallet/withdrawal');
                                    exit();
                                }
                            }catch (\Exception $e){
                                pager::redirect_page('0','/profile');
                                message::msg_box_session_prepare($e->getMessage(),"warning");
                                exit();
                            }
                        }
                    }
                    break;
            }
        }
    }
}
<?php
namespace Controller;

use Config\server;
use Model\factor;
use Model\message;
use Model\pager;
use Model\payment;
use Model\ticket;
use Model\upload;
use Model\user;
use Model\views;
use Config\tables;
use Model\db;
use Model\preg;
use Model\winner;

class competition extends views {
    public function start($mode = ""){
        $preg = new \Model\preg();
        $comp = new \Model\competition();
        $comp_data = $comp->Check_Competitions();
        if ($mode == "Admin-panel"){
            $this->Actions();
        }elseif ($mode == "New_Ticket") {
        }elseif ($mode == "Tickets"){
            $datas = [];
            if ($comp_data['Number_of_Started_competitions']> 0 ){
                $theMomentCompetsMain = $comp_data['FO_started'];
                $datas = [
                    'Started_Compets' => $theMomentCompetsMain
                ];
            }
            return $datas;
        }elseif ($mode == ""){
             $view = [parent::setHeader("layouts/header.php"),parent::setPage("layouts/home_head.php"),parent::setPage("results.php"),parent::setFooter("layouts/footer.php")];
                parent::Show($view);
        }
    }
    private function Admin_panel_Mode(){

    }
    private function check_competition_for_result_calculation($competition_id){
        $compet = new \Model\competition();
        if ($compet->exists_compet($competition_id) == true){
            $row_data = array_merge($compet->getFrom_Competition_tbl_by($competition_id),$compet->getFrom_Competition_attributes_by($competition_id));
            if ($row_data['Starts_At'] < time() AND time() >= $row_data['Ends_At']){
                if (($row_data[0]['Active_Status']) == 1){
                    $your_delay = time() - $row_data['Ends_At'];
                    return $result = ['status' => true , 'Data' => ['delay' => $your_delay,'winner_num' => $row_data[0]['Winners_Num']]];
                }else {
                    return $result = ['status' => false, 'cause' => 'مسابقه فعال نیست و تمام شده است.','id' => $competition_id];
                }
            }else {
                return $result = ['status' => false , 'cause' => 'در هنگام مسابقه نمیتوان نتیجه را اعلام کرد.','id' => $competition_id];
            }
        }else {
            return $result = ['status' => false, 'cause' => 'مسابقه وجود ندارد!','id' => $competition_id];
        }
    }
    private function Start_calculation_process($id){
        $result = $this->check_competition_for_result_calculation($id);
        if ($result['status'] == true){
            $winners_num = $result['Data']['winner_num'];
            $ticket = new ticket();
            $winner_model = new winner();
            $winner_model->set_c_id($id);
            $comp = new \Model\competition();
            $ticket->set_competition_id($id);
            if ($ticket->count_live_tickets() > 0 AND $ticket->count_tickets_current_competition() > 0){
                if ($comp->getFrom_Competition_attributes_by($id)[0]['Tickets_price'] * $ticket->count_live_tickets() > $winner_model->total_rewards()) {
                    $winners_list = $ticket->select_random($winners_num);
                    $winners_array_list = array();
                    foreach ($winners_list as $key => $value) {
                        $winners_array_list = array_merge($winners_array_list, array(
                             $value
                        ));
                    }
                    return array('status' => true, $winners_array_list);
                }else{
                    return ['status' => false,'cause' => 'تیکت های کافی خریداری نشده است.','alert' => 'not_enough_tickets','id' => $id];
                }
            }else {
                return ['status' => false,'cause' => 'بلیطی برای این مسابقه وجود ندارد. مسابقه بدون برنده تمام شده است.','id' => $id];
            }
        }else {
            return ['status' => false,'cause' => $result['cause'],'id' => $id];
        }
    }
    public function Get_result($competition_id){
        $calculate = $this->Start_calculation_process($competition_id);
        if ($calculate['status']){
            $comp = new \Model\competition();
            $count = count($calculate);
            if ($count > 1){
                if ($comp->getFrom_Competition_attributes_by($competition_id)[0]['Active_Status'] == 1){
                    $winner_model = new winner();
                    $wallet = new \Model\wallet();
                    $comp = new \Model\competition();
                    $rank_id = 1;
                    $winner_model->set_c_id($competition_id);
                    foreach ($calculate[0] as $winner){
                        $winner_model->set_winner($rank_id,$winner);
                        $rank_id++;
                    }
                    $all_winners = $winner_model->all_about_winners();
                    foreach ($all_winners as $winner){
                        $wallet->Set_Email($winner['Winner']);
                        $wallet->SumToBalance($winner['reward']);
                    }
                    $comp->expire_competition($competition_id);
                    return ['status' => true,'details' => ['Competition_id' => $competition_id,'Winner_number' => $count] , 'cause' => 'مسابقه تمام شد و برنده ها اعلام شدند' , 'id' => $competition_id ];
                }else{
                    return ['status' => false,'cause' => 'مسابقه فعال نیست و تمام شده است.','id' => $competition_id];
                }
            }else {
                return $calculate;
            }
        }else{
            return $calculate;
        }
    }
    public function Actions(){
        $login = new login();
        if ($login->is_admin() == true AND $login->is_login() == true){
            if (isset($_GET['Competition_Actions'])){
                $preg = new preg();
                if ($preg->alphabet($_GET['Competition_Actions']) == 1){
                    $action = $_GET['Competition_Actions'];
                    $comp = new \Model\competition();
                    $witcher = new \witcher();
                    if ($action == "Delete"  AND isset($_GET['competition_id'])){
                        $id = $_GET['competition_id'];
                        if ($comp->exists_compet($id) == true AND $comp->cancel_competition($id) != false){
                            $comp->cancel_competition($id);
                            pager::redirect_page('0',"profile?parts=competition");
                            message::msg_box_session_prepare("این مسابقه با موفقیت لغو گردید.","success");
                            exit;
                        }
                        else{
                            pager::redirect_page('0',"profile?parts=competition");
                            message::msg_box_session_prepare("مسابقه قادر به حذف شدن نیست","warning");
                            exit;
                        }
                    }elseif ($action == "Edit"  AND isset($_GET['competition_id'])){
                        $id = $_GET['competition_id'];
                        // include Wizard Form in parts=competition and set for new competition.
                        pager::go_page("/profile/parts=competition&Edit&competition_id=".$id);
                        exit;
                    }elseif ($action == "New"){
                        $witcher->requireView("admin-panel/admin/newCompetition.php");
                    }elseif ($action == "DeleteComp" AND isset($_GET['competition_id'])){
                        $id = $_GET['competition_id'];
                        if ($comp->exists_compet($id)){
                            $status = $comp->getCompetition_Status($id);
                            if ($status['status'] != "In-Progress" or $status['status'] == "Not-Begin"){
                                $delete_statement = $comp->delete_competition($id);
                                if ($delete_statement == true){
                                    pager::redirect_page('0',"profile?parts=competition");
                                    message::msg_box_session_prepare("این مسابقه با موفقیت از دیتابیس حذف گردید.","success");
                                    exit;
                                }else{
                                    pager::redirect_page('0',"profile?parts=competition");
                                    message::msg_box_session_prepare("مشکلی در اپلیکیشن وجود دارد.","danger");
                                    exit;
                                }
                            }else{
                                pager::redirect_page('0',"profile?parts=competition");
                                message::msg_box_session_prepare("مسابقه مورد نظر هنوز فعال است.","warning");
                                exit;
                            }
                        }else{
                            pager::redirect_page('0',"profile?parts=competition");
                            message::msg_box_session_prepare("مسابقه مورد نظر وجود ندارد!","warning");
                            exit;
                        }
                    }
                }else{
                    message::msg_box_session_prepare("مقدار نامعتبر است.","warning");
                }
            }elseif (!isset($_GET['Competition_Actions']) OR !isset($_GET['competition_id'])){
                return false;
            }
        }else{
            return false;
        }
    }
    public function NewCompetition_Submit(){
        $witcher = new \witcher();
        $user = new user();
        $comp = new \Model\competition();
        $permissions = $user->user_get_permission();
        $user_info = $user->user_get_certificate();
        if ($permissions['Admin'] == 1 AND $permissions['WriteSite'] == 1 AND $permissions['ReadUsers'] == 1){
            if ($_SERVER['REQUEST_METHOD'] == "POST"){
                $preg = new preg();
                if (isset($_POST['Comp_Title'])){
                    if ($preg->custom('/^[a-zA-Z0-9ا-ی\s]*$/u',$_POST['Comp_Title']) == 1){
                        if (strlen($_POST['Comp_Title']) <= 50 AND strlen($_POST['Comp_Title']) > 0){
                            if (isset($_POST['reservation-time'])){
                                if ($preg->custom('/^[\/A-Z0-9-:\s]*$/i',$_POST['reservation-time']) == 1){
                                    $time = explode("-",$_POST['reservation-time']);
                                    $Starts_At = strtotime($time[0]);
                                    $Ends_At = strtotime($time[1]);
                                    if ($Starts_At != false AND $Ends_At != false){
                                        if ($Starts_At >= $Ends_At OR $Ends_At - $Starts_At <= 300){
                                            pager::redirect_page('0',"profile?parts=competition&Competition_Actions=New");
                                            message::msg_box_session_prepare("زمان مشخص شده اشتباه است.","warning");
                                            exit;
                                        }else{
                                            if ($Starts_At <= time() OR time() >= $Ends_At){
                                                pager::redirect_page('0',"profile?parts=competition&Competition_Actions=New");
                                                message::msg_box_session_prepare("زمان مشخص شده اشتباه است.","warning");
                                                exit;
                                            }
                                        }
                                        if (isset($_POST['Active_Status'])){
                                            if ($_POST['Active_Status'] == "on"){
                                                $Active_Status = 1;
                                            }else{
                                                $Active_Status = 0;
                                            }
                                        }elseif(!isset($_POST['Active_Status'])){
                                            $Active_Status = 0;
                                        }
                                        if (isset($_POST['Winners_num'])){
                                            $Winner_num = $_POST['Winners_num'];
                                            $preg_checker_winner_num = 0;
                                            foreach ($Winner_num as $wk => $wv){
                                                if ($preg->number($wv) == 1 AND $preg->number($wk) == 1)
                                                    $preg_checker_winner_num++;
                                            }
                                            if ($preg_checker_winner_num == count($Winner_num)){
                                                if (count($Winner_num) > 100){
                                                    pager::redirect_page('0',"profile?parts=competition&Competition_Actions=New");
                                                    message::msg_box_session_prepare("تعداد برنده ها بیش از حد مجاز است.","danger");
                                                    exit;
                                                }else{
                                                    if (isset($_POST['Users_Limitation_Stat'])){
                                                        if ($_POST['Users_Limitation_Stat'] == "on"){
                                                            if (isset($_POST['User_Limitation_Num'])){
                                                                if ($preg->number($_POST['User_Limitation_Num']) == 1){
                                                                    if ($_POST['User_Limitation_Num'] <= 1){
                                                                        pager::redirect_page('0',"profile?parts=competition&Competition_Actions=New");
                                                                        message::msg_box_session_prepare("محدودیت کاربر کمتر از حد مجاز است.","danger");
                                                                        exit;
                                                                    }
                                                                    $all_users = $user->CountUsers();
                                                                    $users_who_can_be_participate = $user->CountUsersBy_Permission('Participate_Competitions',1);
                                                                    $Users_Limitation = $_POST['User_Limitation_Num'];
                                                                    if ($Users_Limitation >= $all_users OR $Users_Limitation >= $users_who_can_be_participate){
                                                                        pager::redirect_page('0',"profile?parts=competition&Competition_Actions=New");
                                                                        message::msg_box_session_prepare("محدودیت کاربر بیش از حد مجاز است.","danger");
                                                                        exit;
                                                                    }
                                                                }else{
                                                                    pager::redirect_page('0',"profile?parts=competition&Competition_Actions=New");
                                                                    message::msg_box_session_prepare("محدودیت کاربر نامعتبر است.","warning");
                                                                    exit;
                                                                }
                                                            }elseif (!isset($_POST['User_Limitation_Num'])){
                                                                pager::redirect_page('0',"profile?parts=competition&Competition_Actions=New");
                                                                message::msg_box_session_prepare("محدودیت کاربر را مشخص کنید.","warning");
                                                                exit;
                                                            }
                                                        }else{
                                                            pager::redirect_page('0',"profile?parts=competition&Competition_Actions=New");
                                                            message::msg_box_session_prepare("محدودیت کاربران نامعتبر است.","warning");
                                                            exit;
                                                        }
                                                    }elseif (!isset($_POST['Users_Limitation_Stat'])){
                                                        $Users_Limitation = 0;
                                                    }
                                                    $File_uploading = [];
                                                    if (isset($_POST['Icon_Uploading_Stat'])){
                                                        if ($_POST['Icon_Uploading_Stat'] == "on"){
                                                            if (isset($_FILES['Icon_image'])){
                                                                if ($_FILES['Icon_image']['error'] > 0 ){
                                                                    pager::redirect_page('0',"profile?parts=competition&Competition_Actions=New");
                                                                    message::msg_box_session_prepare("آیکون مسابقه آپلود نشده است.","danger");
                                                                    exit;
                                                                }elseif ($_FILES['Icon_image']['size'] > 300000){
                                                                    pager::redirect_page('0',"profile?parts=competition&Competition_Actions=New");
                                                                    message::msg_box_session_prepare("سایز فایل باید کمتر از 300 کیلوبایت باشد.","danger");
                                                                    exit;
                                                                }
                                                                $File_uploading = ['upload',$_FILES['Icon_image']];
                                                            }elseif(!isset($_FILES['Icon_image'])){
                                                                pager::redirect_page('0',"profile?parts=competition&Competition_Actions=New");
                                                                message::msg_box_session_prepare("آیکون مسابقه آپلود نشده است.","danger");
                                                                exit;
                                                            }
                                                        }else{
                                                            pager::redirect_page('0',"profile?parts=competition&Competition_Actions=New");
                                                            message::msg_box_session_prepare("آیکون مسابقه آپلود نشده است.","danger");
                                                            exit;
                                                        }
                                                    }elseif (!isset($_POST['Icon_Uploading_Stat'])){
                                                        $File_uploading = ['default',$comp->getDefaultIcon()];
                                                    }
                                                    if (isset($_POST['Ticket_Price'])){
                                                        if ($preg->number($_POST['Ticket_Price']) == 1){
                                                            $Ticket_Price = $_POST['Ticket_Price'];
                                                            if ($Ticket_Price <= 0){
                                                                pager::redirect_page('0',"profile?parts=competition&Competition_Actions=New");
                                                                message::msg_box_session_prepare("قیمت تیکت کمتر از حد مجاز است.","danger");
                                                                exit;
                                                            }else{
                                                                if (isset($_POST['payment_category'])){
                                                                    $Post_Categories = $_POST['payment_category'];
                                                                    $p_i = 0;
                                                                    foreach ($Post_Categories as $preg_checker => $name){
                                                                        if ($preg->number($preg_checker))
                                                                            $p_i++;
                                                                    }
                                                                    if (count($Post_Categories) != $p_i){
                                                                        return $Post_Categories;
                                                                        pager::redirect_page('0',"profile?parts=competition&Competition_Actions=New");
                                                                        message::msg_box_session_prepare("راه پرداخت مشخص شده نامعتبر است.","warning");
                                                                        exit;
                                                                        //return ['status' => false,'cause' => 'Invalid_payment_category'];
                                                                    }
                                                                    $payment = new payment();
                                                                    $Payment_List = $payment->get_payment_methods(0);
                                                                    $Payment_Methods = [];
                                                                    foreach ($Post_Categories as $check_item => $item){
                                                                        foreach ($Payment_List as $Payment_item){
                                                                            if ($check_item == $Payment_item['Cat_id'])
                                                                                $Payment_Methods = array_merge($Payment_Methods,[$Payment_item['Payment_Method']]);
                                                                        }
                                                                    }
                                                                    if (count($Payment_Methods) > 0){
                                                                        $server = new server();
                                                                        $Starter_username = $user_info['Username'];
                                                                        $Starter_email = $user_info['Email'];
                                                                        // file uploading :
                                                                        $uploader = new upload();
                                                                        if (isset($File_uploading[0]) AND $File_uploading[0] == 'upload') {
                                                                            $white_list = ['jpg', 'png', 'PNG', 'JPG'];
                                                                            $target_folder = "public_html/img/icons";
                                                                            $new_name = "icon-" . rand(1000, 9999);
                                                                            $upload = $uploader->Upload($white_list, $new_name, $target_folder, $_FILES['Icon_image']);
                                                                            if (isset($upload['status'])) {
                                                                                if ($upload['status'] == false) {
                                                                                    pager::redirect_page('0', "profile?parts=competition&Competition_Actions=New");
                                                                                    message::msg_box_session_prepare("معتبر است." . "jpg , png" . "فرمت فایل شما نامعتبر است. تنها فرمت های عکس مانند ","warning");
                                                                                    exit;
                                                                                }
                                                                            }
                                                                            $Image_src = $server->INFO['Port']."://".$server->INFO['Domain']."/img/icons/".$upload.".".$uploader->get_end_file($_FILES['Icon_image']);
                                                                        }
                                                                        if (isset($File_uploading[0]) AND $File_uploading[0] == 'default'){
                                                                            $Image_src = $File_uploading[1];
                                                                        }
                                                                        // end file uploading |
                                                                        $Array3_winners_tbl = [];
                                                                        foreach ($Winner_num as $ewk => $ewv){
                                                                            if ($ewv >= 1000){
                                                                                $Array3_winners_tbl = array_merge($Array3_winners_tbl,[$ewk=>$ewv]);
                                                                            }
                                                                        }
                                                                        $Winner_num = count($Array3_winners_tbl);
                                                                        if ($Winner_num == 0){
                                                                            pager::redirect_page('0',"profile?parts=competition&Competition_Actions=New");
                                                                            message::msg_box_session_prepare("برنده ها مشخص نشده است.","danger");
                                                                            exit;
                                                                        }
                                                                        $winner_valid_checker = 0;
                                                                        for ($i = 0;$i < $Winner_num-1;$i++){
                                                                            if ($Array3_winners_tbl[$i] > $Array3_winners_tbl[$i + 1]){
                                                                                $winner_valid_checker++;
                                                                            }
                                                                        }
                                                                        if ($winner_valid_checker != $Winner_num-1){
                                                                            pager::redirect_page('0',"profile?parts=competition&Competition_Actions=New");
                                                                            message::msg_box_session_prepare("ترتیب جایزه ها نامعتبر است. (مقدار جایزه از نفر اول به بعد باید از بزرگ به کوچیک تعیین شده باشد).","warning");
                                                                            exit;
                                                                        }
                                                                        $Array1_competition_tbl_array = [
                                                                            'Started_by' => $Starter_username,
                                                                            'Image_src' => $Image_src,
                                                                            'Title' => $_POST['Comp_Title']
                                                                        ];
                                                                        $Array2_competition_attributes = [
                                                                            'Active_Status' => $Active_Status,
                                                                            'Winner_Num' => $Winner_num,
                                                                            'Notice_for_participants' => 1,
                                                                            'Tickets_price' => $Ticket_Price,
                                                                            'Payment_Methods' => implode(",",$Payment_Methods),
                                                                            'User_Limitation' => $Users_Limitation
                                                                        ];
                                                                        $comp->set_Competition_Id();
                                                                        $comp->set_Starts_At_AND_Ends_At($Starts_At,$Ends_At);
                                                                        if ($comp->new_competition($Array1_competition_tbl_array,$Array2_competition_attributes,$Array3_winners_tbl)){
                                                                            pager::redirect_page('0',"profile?parts=competition&Competition_Actions=New");
                                                                            message::msg_box_session_prepare("مسابقه با موفقیت ساخته شد.","success");
                                                                            exit;
                                                                        }
                                                                    }else{
                                                                        pager::redirect_page('0',"profile?parts=competition&Competition_Actions=New");
                                                                        message::msg_box_session_prepare("راه پرداخت مشخص شده نامعبتر است.","warning");
                                                                        exit;
                                                                    }
                                                                }elseif (!isset($_POST['payment_category'])){
                                                                    pager::redirect_page('0',"profile?parts=competition&Competition_Actions=New");
                                                                    message::msg_box_session_prepare("راه های پرداخت مشخص نشده است.","warning");
                                                                    exit;
                                                                }
                                                            }
                                                        }else{
                                                            pager::redirect_page('0',"profile?parts=competition&Competition_Actions=New");
                                                            message::msg_box_session_prepare("قیمت تیکت نامعتبر است.","warning");
                                                            exit;
                                                        }
                                                    }elseif (!isset($_POST['Ticket_Price'])){
                                                        pager::redirect_page('0',"profile?parts=competition&Competition_Actions=New");
                                                        message::msg_box_session_prepare("قیمت هر تیکت را مشخص نشده است.","warning");
                                                        exit;
                                                    }
                                                }
                                            }else{
                                                pager::redirect_page('0',"profile?parts=competition&Competition_Actions=New");
                                                message::msg_box_session_prepare("شماره برنده ها نامعتبر است.","danger");
                                                exit;
                                            }
                                        }elseif (!isset($_POST['Winners_num'])){
                                            pager::redirect_page('0',"profile?parts=competition&Competition_Actions=New");
                                            message::msg_alert("تعداد برنده ها مشخص نشده اند.");
                                            exit;
                                        }
                                    }else{
                                        pager::redirect_page('0',"profile?parts=competition&Competition_Actions=New");
                                        message::msg_box_session_prepare("مقدار زمان مشخص شده نامعتبر است.","danger");
                                        exit;
                                    }
                                }else{
                                    pager::redirect_page('0',"profile?parts=competition&Competition_Actions=New");
                                    message::msg_box_session_prepare("مقدار زمان مشخص شده نامعتبر است.","danger");
                                    exit;
                                }
                            }
                            elseif (!isset($_POST['reservation-time'])){
                                pager::redirect_page('0',"profile?parts=competition&Competition_Actions=New");
                                message::msg_box_session_prepare("زمان مسابقه مشخص نشده است.","danger");
                                exit;
                            }
                        }else{
                            pager::redirect_page('0',"profile?parts=competition&Competition_Actions=New");
                            message::msg_box_session_prepare("نام مسابقه نباید بیشتر از 50 کارکتر باشد.","danger");
                            exit;
                        }
                    }else{
                        pager::redirect_page('0',"profile?parts=competition&Competition_Actions=New");
                        message::msg_box_session_prepare("نام مسابقه نامعتبر است.","danger");
                        exit;
                    }
                }elseif (!isset($_POST['Comp_Title'])){
                    pager::redirect_page('0',"profile?parts=competition&Competition_Actions=New");
                    message::msg_box_session_prepare("نام مسابقه را مشخص کنید.","warning");
                    exit;
                }
            }elseif (!isset($_POST['Create_new_competition'])){
                return ['status' => false,'cause' => 'no_submit'];
            }
        }else{
            pager::redirect_page('0',"profile?parts=competition");
            message::msg_box_session_prepare("شما اجازه ی ساخت مسابقه را ندارید.","danger");
            exit;
        }
    }
    public function getResultData(){
        $preg = new \Model\preg();
        $comp = new \Model\competition();
        $datas = [];
            if (isset($_GET['results'])){
                if (isset($_GET['c'])){
                if ($preg->custom('/^[a-zA-Z0-9]*$/i',$_GET['c']) == 1){
                $datas = [
                    'compets' => array_merge($comp->getFrom_Competition_tbl_by($_GET['c']),$comp->getFrom_Competition_attributes_by($_GET['c'])[0])
                    ];
                return $datas;
                }
                }elseif(!isset($_GET['c'])){
                    pager::go_page("/");
                }
            }
    }
}
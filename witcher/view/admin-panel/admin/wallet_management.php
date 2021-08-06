<?php
$panel = new \Controller\panel();
$wallet = new \Model\wallet();
$user = new \Model\user();
$datas = $panel->start();
?>
<div class="right_col" role="main">
    <div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
    <br><br>
    <div style="float: right">
    <a href="/profile?parts=wallet_management&action=Change_all_active" class="btn btn-success">فعال کردن همه</a>
    <a href="/profile?parts=wallet_management&action=Change_all_deactive" class="btn btn-danger">غیرفعال کردن همه</a>
    </div>
        <div class="x_panel">
        <div class="x_title">
            <h2>مدیریت کیف پول کاربران</h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                </li>
                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
            </ul>
            <div class="clearfix"></div>
        </div>

        <div class="x_content">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th style="text-align: center!important;">نام</th>
                        <th style="text-align: center!important;">نام خانوادگی</th>
                        <th style="text-align: center!important;">اعتبار</th>
                        <th style="text-align: center!important;">ایمیل</th>
                        <th style="text-align: center!important;">وضعیت</th>
                        <th style="text-align: center!important;">تغییر وضعیت</th>
                        <th style="text-align: center!important;">افزایش اعتبار</th>
                        <th style="text-align: center!important;">تراکنش ها</th>
                        <th style="text-align: center!important;">بیشتر</th>
                    </tr>
                    </thead>
                    <tbody style="text-align: center!important;">
                    <?php foreach ($datas['All_wallets'] as $list_keys => $list_values){
                        $user_list_role = $user->getUserRoleCats($list_values['Email']);
                        if ($user_list_role['Role_Id'] < 2){
                        ?>
                        <tr>
                            <th style="text-align: center!important;"><?=$list_values['First_Name']?></th>
                            <th style="text-align: center!important;"><?=$list_values['Last_Name']?></th>
                            <td>
                                <?=$list_values['Balance']?>
                            </td>
                            <td><?=$list_values['Email']?></td>
                            <td><?php if($list_values['Active_Status'] == 1){echo "فعال";}else{echo "غیرفعال";}?></td>
                            <td>
                                <a href="/profile?parts=wallet_management&action=change_stat&wallet_key=<?=$list_values['Wallet_Key']?>" class="btn btn-<?php if($list_values['Active_Status'] == 1){echo "danger";}else{echo "success";}?>" style="-webkit-border-radius: 100px;-moz-border-radius: 100px;border-radius: 100px;">
                                    <?php if($list_values['Active_Status'] == 1){echo "غیرفعال";}else{echo "فعال";}?>
                                </a>
                            </td>
                            <td><a href="/profile?parts=wallet_management&action=add_balance&wallet_key=<?=$list_values['Wallet_Key']?>" class="btn btn-success" style="border-radius: 100px;">افزایش اعتبار</a></td>
                            <td>
                                <a href="/profile?parts=users_trans_management?wallet_key=<?=$list_values['Wallet_Key']?>" class="btn btn-success" style="-webkit-border-radius: 100px;-moz-border-radius: 100px;border-radius: 100px;">تراکنش ها</a>
                            </td>
                            <td>
                                <a href="/profile?parts=wallets_info&email=<?=$list_values['Email']?>" class="btn btn-success" style="-webkit-border-radius: 100px;-moz-border-radius: 100px;border-radius: 100px;">بیشتر</a>
                            </td>
                            <script>
                                var id = document.getElementById(<?=$list_values['id']?>).getAttribute('id');
                                CountDown(id);
                            </script>
                        </tr>
                    <?php }}?>
                    </tbody>
                </table>
            <?php if (isset($_GET['action'])){
                if ($_GET['action'] == "add_balance"){
                    $wallet_info = $wallet->GetWalletBy('Wallet_Key',$_GET['wallet_key']);
                ?>
            <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" method="post">
                <div class="form-group" style="text-align: center;">
                    <p style="direction: rtl!important;">ایمیل:<?="<b style='margin-right: 10px;'>".$wallet_info[0]['Email']."</b>"?></p>
                    <label class="control-label col-md-4 col-sm-3 col-xs-12" for="first-name" style="direction: rtl!important;">مبلغ (تومان)<span class="required">*</span>
                    </label>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <input type="number" min="0" id="first-name" required="required" class="form-control col-md-7 col-xs-12" placeholder="مقدار را تعیین کنید." name="balance" style="text-align: center;border-radius: 100px;">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-4 col-sm-3 col-xs-12" for="first-name">
                    </label>
                    <div class="col-md-4 col-sm-4 col-xs-12" style="text-align: center;">
                        <input type="submit" id="first-name" required="required" class="btn btn-success" value="شارژ حساب" name="add_balance" style="border-radius:100px;padding: 7px 24px;font-size: 17px;">
                    </div>
                </div>
            </form>
            <?php } } ?>
        </div>
    </div>
</div>
</div>
</div>
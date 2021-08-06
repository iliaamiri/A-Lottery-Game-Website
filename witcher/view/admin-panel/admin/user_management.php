<?php
    $panel = new \Controller\panel();
    $datas = $panel->start();
    $user_permission = $datas['user_permissions'];
    $wallet = new \Model\wallet();
    $user = new \Model\user();
?>
<div class="right_col" role="main">
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
        <div class="x_title">
            <h2>مدیریت کاربران</h2>
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

            <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>نام و نام خانوادگی</th>
                    <th>نام کاربری</th>
                    <th>نوع کابر</th>
                    <th>ایمیل</th>
                    <th>کیف پول</th>
                    <th>وضعیت فعال بودن</th>
                    <th>آخرین برداشت از حساب</th>
                    <th>آخرین ورود به اپلیکیشن</th>
                    <th>آخرین مرورگر</th>
                    <th>آخرین آی پی</th>
                    <th>بیشتر</th>
                     <th>تغییر فعال بودن</th> 
                     <th>حذف</th>
                     <th>ساخت کیف پول</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($datas['List_Users'] as $user_keys => $user_values){
                    ?>
                <tr>
                    <td><?= $user_values['Full_Name']?></td>
                    <td><?= $user_values['Username']?></td>
                    <td><?php switch ($user_values['Admin']){case 1:echo "ادمین";break;case 0:echo "کاربر معمولی";break;default:echo "نامشخص";break;}?></td>
                    <td><?= $user_values['Email']?></td>
                    <td><?php if ($wallet->Exists_Wallet("Email",$user_values['Email'])){echo "<b style='color: limegreen;'>ساخته شده</b>";}else{echo "<b style='color: red;'>ساخته نشده</b>";}?></td>
                    <td><?php switch ($user_values['Active']){case 1:echo "تایید شده";break;case 0:echo "تایید نشده";break;case -1:echo "بن شده";break;default:echo "نامشخص";break;}?></td>
                    <td><?php
                        $last_trans = $wallet->Get_Last_Trans("Email",$user_values['Email'])[0]['Latest'];
                        if ($last_trans){echo date("Y-m-d D H:i:s",$last_trans);}else{echo "انجام نشده است";}?></td>
                    <td><?= $user_values['Last_Login']?></td>
                    <td><?php if ($user_values['Last_Browser'] == null){echo "نامشخص";}else{echo $user_values['Last_Browser'];}?></td>
                    <td><?= $user_values['Last_Ip']?></td>
                    <td>
                        <a href="/profile?parts=users_info&email=<?=$user_values['Email']?>" class="btn btn-primary" style="border-radius: 100px ;">بیشتر</a>
                    </td>
                    <td>
                        <a href="/profile?parts=user_management&Action=Change_Active_Permission&User_id=<?= $user_values['Email']?>" class="btn btn-<?php if ($user_values['Active'] == 1){echo "danger";}else{echo "success";}?>" style="-webkit-border-radius: 100px;-moz-border-radius: 100px;border-radius: 100px;display: block;" <?php if ($user->getUserRoleCats($user_values['Email'])['Role_Id'] == 2){echo "disabled";}?>><?php if ($user_values['Active'] == 1){echo "کم کردن دسترسی";}else{echo "ارتقا دسترسی";}?></a>
                    </td>
                    <Td>
                        <a href="/profile?parts=user_management&Action=Delete&User_id=<?= $user_values['Email']?>" class="btn btn-danger" style="-webkit-border-radius: 100px;-moz-border-radius: 100px;border-radius: 100px;display: block;">حذف</a>
                    </Td>
                    <Td>
                        <?php if (!$wallet->Exists_Wallet('Email',$user_values['Email'])){?>
                        <a href="/profile?parts=wallets_info&email=<?= $user_values['Email']?>&action=create" class= "btn btn-primary" style="-webkit-border-radius: 100px;-moz-border-radius: 100px;border-radius: 100px;display: block;">ساخت کیف پول</a>
                        <?php }else{?>
                        <a href="/profile?parts=wallets_info&email=<?= $user_values['Email']?>" class= "btn btn-success" style="-webkit-border-radius: 100px;-moz-border-radius: 100px;border-radius: 100px;display: block;">تغییر کیف پول</a>
                        <?php }?>
                    </Td>
                    <!--
                    <td>
                        <select name="New_Role">
                            <?php ?>
                            <option value=""></option>
                            <?php?>
                        </select>
                        <a href="/profile?parts=user_management&Action=Change_Role&User_id=<?= $user_values['Email']?>&New_Role=" class="btn btn-success" style="-webkit-border-radius: 100px;-moz-border-radius: 100px;border-radius: 100px;display: block;" <?php if ($user->getUserRoleCats($user_values['Email'])['Role_Id'] == 2){echo "disabled";}?>><?php if ($user_values['Login'] == 1){echo "کم کردن دسترسی";}else{echo "ارتقا دسترسی";}?></a>
                    </td>
                    -->
                </tr>
                <?php }?>
                </tbody>
            </table>


        </div>
    </div>
</div>
</div>
<!-- Datatables -->
<script src="panel/vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="panel/vendors/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="panel/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="panel/vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
<script src="panel/vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
<script src="panel/vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
<script src="panel/vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="panel/vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
<script src="panel/vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="panel/vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
<script src="panel/vendors/datatables.net-scroller/js/dataTables.scroller.min.js"></script>
<script src="panel/vendors/jszip/dist/jszip.min.js"></script>
<script src="panel/vendors/pdfmake/build/pdfmake.min.js"></script>
<script src="panel/vendors/pdfmake/build/vfs_fonts.js"></script>
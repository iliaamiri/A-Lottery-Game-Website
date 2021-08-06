<?php
$panel = new \Controller\panel();
$comp = new \Model\competition();
$data = $panel->start();
$withdrawals_data = $panel->start()['withdrawal_info'];
$is_valid = $data['begger_wallet_is_valid'];
?>
<div class="right_col" role="main">
        <div class="page-title">
            <div class="title_left">
                <h3>کیف پول <a href= "/profile?parts=users_info&email=<?=$withdrawals_data['Email']?>" title="مشخصات کاربر"><?=$withdrawals_data['Email']?></a></h3>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>مشخصات برداشت</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <br />
                        <form class="form-horizontal form-label-left" method="post">
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">شماره فاکتور
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="first-name" value="<?=$withdrawals_data['factor_number']?>" class="form-control col-md-7 col-xs-12" disabled>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">میزان برداشت
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="first-name" value="<?=$withdrawals_data['Amount']?>" class="form-control col-md-7 col-xs-12" disabled>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">اعتبار
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="first-name" value="<?=$data['begger_balance']?> تومان" class="form-control col-md-7 col-xs-12" disabled>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">شماره ارجاع
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="first-name" class="form-control col-md-7 col-xs-12" name="Invoice_number" value="<?=$withdrawals_data['Invoice_number']?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">وضعیت درخواست
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <?php
                                    if ($is_valid) {
                                        ?>
                                        <img src="/panel/src/img/checked.png" alt="checked" style="height: 30px;"> <b style="font-size:17px;">معتبر</b>
                                    <?php } else { \Model\message::msg_box_session_prepare("کیف پول نامعتبر است ! این موضوع را جدی بگیرید!","warning"); ?>
                                        <img src="/panel/src/img/multiply.png" alt="unchecked" style="height: 30px;"> <b style="font-size:17px;">نامعتبر</b>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                    <a href="<?=HTTP_SERVER?>/profile/withdrawals" class="btn btn-primary">لغو و بازگشت</a>
                                    <input type="Submit" class="btn btn-success" value="بروز رسانی" name="Submit" onclick="this.disabled=true;this.form.submit();">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
</div>
        


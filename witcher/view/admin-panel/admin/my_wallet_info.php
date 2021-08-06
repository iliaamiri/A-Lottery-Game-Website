<?php
$panel = new \Controller\panel();
$data = $panel->start();
$person = $data['wallet']['Info']['Person'];
$balance = $data['wallet']['Info']['Balance'];
$is_valid = $data['wallet']['Valid'];
$active = $data['wallet']['Status'];
?>
<div class="right_col" role="main">
        <div class="page-title">
            <div class="pull-right">
                <h3>کیف پول من </h3>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>مشخصات</h2>
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
                        <form  class="form-horizontal form-label-left" method="post" enctype="multipart/form-data">

                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">نام <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="first-name" value="<?=$person['First_Name']?>" required="required" class="form-control col-md-7 col-xs-12" name="First_Name">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">نام  خانوادگی
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="first-name" value="<?=$person['Last_Name']?>" class="form-control col-md-7 col-xs-12" name="Last_Name">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">اعتبار
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="first-name" value="<?=$balance?> تومان" class="form-control col-md-7 col-xs-12" disabled>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">وضعیت
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
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">وضعیت
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <?php
                                    if ($active) {
                                        ?>
                                        <img src="/panel/src/img/checked.png" alt="checked" style="height: 30px;"> <b style="font-size:17px;">فعال</b>
                                    <?php } else { ?>
                                        <img src="/panel/src/img/multiply.png" alt="unchecked" style="height: 30px;"> <b style="font-size:17px;">غیرفعال</b>
                                    <?php } ?>
                                </div>
                            </div>
                            <input type="hidden" name="type" value="edit_submit" >
                            <div class="form-group">
                                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                    <a href="<?=HTTP_SERVER?>/profile/wallet" class="btn btn-primary">لغو و بازگشت</a>
                                    <input type="Submit" class="btn btn-success" value="ذخیره" name="Submit" onclick="this.disabled=true;this.form.submit();">
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
</div>

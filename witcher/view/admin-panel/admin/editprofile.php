<?php
    $panel = new \Controller\panel();
    $user_info = $panel->start()['user_info'];
?>
<div class="right_col" role="main">
<div class="page-title">
    <div class="title_left">
        <h3>تغییر اطلاعات کاربری</h3>
    </div>

    <div class="title_right">
        <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="جست و جو برای...">
                <span class="input-group-btn">
                      <button class="btn btn-default" type="button">برو!</button>
                    </span>
            </div>
        </div>
    </div>
</div>
<div class="clearfix"></div>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>فورم تغییر اطلاعات کاربری </h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="#">تنظیمات 1</a>
                            </li>
                            <li><a href="#">تنظیمات 2</a>
                            </li>
                        </ul>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <br />
                <form  class="form-horizontal form-label-left" method="post" enctype="multipart/form-data">

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">نام و نام خانوادگی<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" id="first-name" value="<?=$user_info['Full_Name']?>" required="required" class="form-control col-md-7 col-xs-12" disabled>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">پسورد قبلی<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input class="date-picker form-control col-md-7 col-xs-12" placeholder="برای تعیین پسورد جدید این فیلد را پر کنید" type="password" name="OldPassword">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">پسورد جدید
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input class="date-picker form-control col-md-7 col-xs-12" type="password" name="NewPassword" placeholder="پسورد جدید">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">تایید پسورد جدید
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input class="date-picker form-control col-md-7 col-xs-12" type="password" name="rePassword" placeholder="تایید پسورد جدید">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">تصویر جدید
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input class="date-picker form-control col-md-7 col-xs-12" type="file" name="Profile_Image">
                        </div>
                    </div>
                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                            <a href="<?=HTTP_SERVER?>/profile" class="btn btn-primary">لغو و بازگشت</a>
                            <button class="btn btn-primary" type="reset">پاک کردن همه</button>
                            <input type="Submit" class="btn btn-success" value="اعمال تغییرات" name="Submit" onclick="this.disabled=true;this.form.submit();">
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
</div>
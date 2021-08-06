<?php
$panel = new \Controller\panel();
$data = $panel->start();
$server_info = $data['server_info'][0];
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
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">نام وبسایت <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" id="first-name" class="form-control col-md-7 col-xs-12" value="<?=$server_info['Title']?>" placeholder="نام وبسیات" name="Website_Name">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">ایمیل پشتیبانی
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" id="first-name" class="form-control col-md-7 col-xs-12" value="<?=$server_info['Email']?>" placeholder="ایمیل پشتیبانی" name="Email">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">تلگرام
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" id="first-name" class="form-control col-md-7 col-xs-12" value="<?=$server_info['Telegram']?>" placeholder="ایمیل پشتیبانی" name="Telegram">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">لوگو
                            </label>
                            برای تغییر لوگو باید <A HREF="/profile/setting/server-about/dochanges" style="font-size: 20px;">این لینک </A> را درخواست کرده باشید.
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input class="date-picker form-control col-md-7 col-xs-12" type="file" name="Logo_file">
                            </div>
                        </div>
                        <div class="ln_solid"></div>
                        <div class="form-group">
                            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                <a href="<?=HTTP_SERVER?>/profile" class="btn btn-primary">لغو و بازگشت</a>
                                <input type="Submit" class="btn btn-success" value="اعمال تغییرات" name="ServerEditSubmit">
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

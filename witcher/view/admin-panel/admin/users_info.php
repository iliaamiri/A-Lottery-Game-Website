<?php
if (isset($_GET['email'])){
    $panel = new \Controller\panel();
    if (isset($panel->start()['user'])){
    $user_info = $panel->start()['user'];
        $role_cats = $panel->start()['roles'];
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
                                    <input type="text" id="first-name" value="<?=$user_info['Full_Name']?>" required="required" class="form-control col-md-7 col-xs-12" name="Full_Name">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">نام کاربری <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="first-name" value="<?=$user_info['Username']?>" required="required" class="form-control col-md-7 col-xs-12" name="Username">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">ایمیل<span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="first-name" value="<?=$user_info['Email']?>" required="required" class="form-control col-md-7 col-xs-12" name="newEmail">
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
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"
                                       style="font-size: 17px;"> اجازه شرکت در مسابقه :
                                </label>
                                <div class="">
                                    <label>
                                        <input  name="Participate_Competitions" type="checkbox" class="js-switch" id="checkbox-10322"
                                               onclick="StatusCheck13442()" <?php if ($user_info['Participate_Competitions'] == 1){echo "checked";}?>/> <b
                                            id="p-123343"><?php if ($user_info['Participate_Competitions'] == 1){echo "دارد";}else{echo "ندارد";}?></b>
                                        <script charset="utf-8">
                                            function StatusCheck13442() {
                                                var checkBox = document.getElementById("checkbox-10322");
                                                var text = document.getElementById("p-123343");
                                                if (checkBox.checked == true) {
                                                    text.innerHTML = "دارد";
                                                } else {
                                                    text.innerHTML = "ندارد";
                                                }
                                            }
                                        </script>
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"
                                       style="font-size: 17px;"> اجازه ورود به سایت :
                                </label>
                                <div class="">
                                    <label>
                                        <input  name="LoginPer" type="checkbox" class="js-switch" id="checkbox-10322"
                                                onclick="StatusCheck13442()" <?php if ($user_info['Login'] == 1){echo "checked";}?>/> <b
                                            id="p-123343"><?php if ($user_info['Login'] == 1){echo "دارد";}else{echo "ندارد";}?></b>
                                        <script charset="utf-8">
                                            function StatusCheck13442() {
                                                var checkBox = document.getElementById("checkbox-10322");
                                                var text = document.getElementById("p-123343");
                                                if (checkBox.checked == true) {
                                                    text.innerHTML = "دارد";
                                                } else {
                                                    text.innerHTML = "ندارد";
                                                }
                                            }
                                        </script>
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"
                                       style="font-size: 17px;"> اجازه خواندن کاربران :
                                </label>
                                <div class="">
                                    <label>
                                        <input  name="ReadUsers" type="checkbox" class="js-switch" id="checkbox-10322"
                                                onclick="StatusCheck13442()" <?php if ($user_info['ReadUsers'] == 1){echo "checked";}?>/> <b
                                            id="p-123343"><?php if ($user_info['ReadUsers'] == 1){echo "دارد";}else{echo "ندارد";}?></b>
                                        <script charset="utf-8">
                                            function StatusCheck13442() {
                                                var checkBox = document.getElementById("checkbox-10322");
                                                var text = document.getElementById("p-123343");
                                                if (checkBox.checked == true) {
                                                    text.innerHTML = "دارد";
                                                } else {
                                                    text.innerHTML = "ندارد";
                                                }
                                            }
                                        </script>
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"
                                       style="font-size: 17px;">اجازه نوشتن سایت :
                                </label>
                                <div class="">
                                    <label>
                                        <input  name="WriteSite" type="checkbox" class="js-switch" id="checkbox-10322"
                                                onclick="StatusCheck13442()" <?php if ($user_info['WriteSite'] == 1){echo "checked";}?>/> <b
                                            id="p-123343"><?php if ($user_info['WriteSite'] == 1){echo "دارد";}else{echo "ندارد";}?></b>
                                        <script charset="utf-8">
                                            function StatusCheck13442() {
                                                var checkBox = document.getElementById("checkbox-10322");
                                                var text = document.getElementById("p-123343");
                                                if (checkBox.checked == true) {
                                                    text.innerHTML = "دارد";
                                                } else {
                                                    text.innerHTML = "ندارد";
                                                }
                                            }
                                        </script>
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"
                                       style="font-size: 17px;">اجازه ادمین ( کاربر با داشتن این دسترسی میتواند پنل مدیریت ادمین را ببیند ) :
                                </label>
                                <div class="">
                                    <label>
                                        <input  name="Admin" type="checkbox" class="js-switch" id="checkbox-10322"
                                                onclick="StatusCheck13442()" <?php if ($user_info['Admin'] == 1){echo "checked";}?>/> <b
                                            id="p-123343"><?php if ($user_info['Admin'] == 1){echo "دارد";}else{echo "ندارد";}?></b>
                                        <script charset="utf-8">
                                            function StatusCheck13442() {
                                                var checkBox = document.getElementById("checkbox-10322");
                                                var text = document.getElementById("p-123343");
                                                if (checkBox.checked == true) {
                                                    text.innerHTML = "دارد";
                                                } else {
                                                    text.innerHTML = "ندارد";
                                                }
                                            }
                                        </script>
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"
                                       style="font-size: 17px;">اجازه نوشتن کاربران ( اضافه کردن، تغییر ، حذف کاربران ) :
                                </label>
                                <div class="">
                                    <label>
                                        <input  name="WriteUsers" type="checkbox" class="js-switch" id="checkbox-10322"
                                                onclick="StatusCheck13442()" <?php if ($user_info['WriteUsers'] == 1){echo "checked";}?>/> <b
                                            id="p-123343"><?php if ($user_info['WriteUsers'] == 1){echo "دارد";}else{echo "ندارد";}?></b>
                                        <script charset="utf-8">
                                            function StatusCheck13442() {
                                                var checkBox = document.getElementById("checkbox-10322");
                                                var text = document.getElementById("p-123343");
                                                if (checkBox.checked == true) {
                                                    text.innerHTML = "دارد";
                                                } else {
                                                    text.innerHTML = "ندارد";
                                                }
                                            }
                                        </script>
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"
                                       style="font-size: 17px;">اجازه فرستادن پیام به ادمین :
                                </label>
                                <div class="">
                                    <label>
                                        <input  name="Message" type="checkbox" class="js-switch" id="checkbox-10322"
                                                onclick="StatusCheck13442()" <?php if ($user_info['Message'] == 1){echo "checked";}?>/> <b
                                            id="p-123343"><?php if ($user_info['Message'] == 1){echo "دارد";}else{echo "ندارد";}?></b>
                                        <script charset="utf-8">
                                            function StatusCheck13442() {
                                                var checkBox = document.getElementById("checkbox-10322");
                                                var text = document.getElementById("p-123343");
                                                if (checkBox.checked == true) {
                                                    text.innerHTML = "دارد";
                                                } else {
                                                    text.innerHTML = "ندارد";
                                                }
                                            }
                                        </script>
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"
                                       style="font-size: 17px;">اجازه خواندن پیام های ادمین :
                                </label>
                                <div class="">
                                    <label>
                                        <input  name="ReadMessage" type="checkbox" class="js-switch" id="checkbox-10322"
                                                onclick="StatusCheck13442()" <?php if ($user_info['ReadMessage'] == 1){echo "checked";}?>/> <b
                                            id="p-123343"><?php if ($user_info['ReadMessage'] == 1){echo "دارد";}else{echo "ندارد";}?></b>
                                        <script charset="utf-8">
                                            function StatusCheck13442() {
                                                var checkBox = document.getElementById("checkbox-10322");
                                                var text = document.getElementById("p-123343");
                                                if (checkBox.checked == true) {
                                                    text.innerHTML = "دارد";
                                                } else {
                                                    text.innerHTML = "ندارد";
                                                }
                                            }
                                        </script>
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">نقش  <span class="required">*</span>
                                </label>
                                <div class="col-md-5">
                                    <?php
                                    if (count($role_cats) == 0) {
                                        echo "!موردی یافت نشد";
                                    } else {
                                        foreach ($role_cats as $cat) {
                                            ?>
                                            <div class="radio">
                                                <label class="">
                                                    <div class="iradio_flat-green" style="position: relative;"><input type="radio" class="flat" <?php if ($cat['Role_Id'] == $user_info['role_id']){echo "checked";}?> value = "<?=$cat['Role_Id']?>" name="roles" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div> <?= $cat['Role_Name'] ?>
                                                </label>
                                            </div>
                                        <?php }
                                    } ?>
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
<?php }}?>

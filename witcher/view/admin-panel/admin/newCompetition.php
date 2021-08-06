<?php
$pan = new \Controller\panel();
$comp = new \Controller\competition();
$comp->NewCompetition_Submit();
$panel = $pan->start();
$user_info = $panel['user_info'];
$user_permissions = $panel['user_permissions'];
$all_users = $panel['Count_users'];
$users_have_permission_to_join_compet = $panel['users_who_have_participate_permission'];
$payment_method_list = $panel['payment_methods_list'];
?>
<div class="row">

    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2 style="font-size: 23px;"> ثبت مسابقه
                    <small> جدید</small>
                </h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                           aria-expanded="false"><i class="fa fa-wrench"></i></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="#">Settings 1</a>
                            </li>
                            <li><a href="#">Settings 2</a>
                            </li>
                        </ul>
                    </li>
                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">


                <!-- Smart Wizard -->
                <p style="float: right;">برای ثبت مسابقه جدید فورم های زیر را پر کنید.</p>
                <form class="form-horizontal form-label-left" method="post" enctype="multipart/form-data">
                    <div id="wizard" class="form_wizard wizard_horizontal">
                        <ul class="wizard_steps">
                            <li>
                                <a href="#step-1">
                                    <span class="step_no">1</span>
                                    <span class="step_descr">
                                             مرحله 1<br/>
                                              <small>مشخصات</small>
                                          </span>
                                </a>
                            </li>
                            <li>
                                <a href="#step-2">
                                    <span class="step_no">2</span>
                                    <span class="step_descr">
                                              مرحله 2<br/>
                                              <small>انتخاب ویژگی ها</small>
                                          </span>
                                </a>
                            </li>
                            <li>
                                <a href="#step-3">
                                    <span class="step_no">3</span>
                                    <span class="step_descr">
                                              مرحله 3<br/>
                                              <small>جزئیات پرداخت و ثبت</small>
                                          </span>
                                </a>
                            </li>
                        </ul>

                        <div id="step-1">
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> زمان شروع و
                                    پایان <span class="required">*</span>
                                </label>
                                <div class="col-md-5">


                                    <fieldset>
                                        <div class="control-group">
                                            <div class="controls">
                                                <div class="input-prepend input-group">
                                                    <span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
                                                    <input type="text" name="reservation-time" id="reservation-time" class="form-control"/>
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>

                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">نام مسابقه<span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="first-name" class="form-control col-md-7 col-xs-12" name="Comp_Title">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> ایمیل شروع
                                    کننده <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="first-name" disabled class="form-control col-md-7 col-xs-12"
                                           value="<?= $user_info['Email'] ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">نام شروع کننده
                                    <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="last-name" disabled class="form-control col-md-7 col-xs-12"
                                           value="<?= $user_info['Username'] ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">داشتن دسترسی
                                    :</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <?php
                                    if ($user_permissions['WriteSite'] AND $user_permissions['ReadUsers']) {
                                        ?>
                                        <img src="panel/src/img/checked.png" alt="checked" style="height: 30px;">
                                    <?php } else {
                                        ?>
                                        <img src="panel/src/img/multiply.png" alt="unchecked" style="height: 30px;">
                                    <?php } ?>
                                </div>
                            </div>
                            <!--
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Gender</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div id="gender" class="btn-group" data-toggle="buttons">
                                        <label class="btn btn-default" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                                            <input type="radio" name="gender" value="male"> &nbsp; Male &nbsp;
                                        </label>
                                        <label class="btn btn-primary" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                                            <input type="radio" name="gender" value="female"> Female
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Date Of Birth <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input id="birthday" class="date-picker form-control col-md-7 col-xs-12" required="required" type="text">
                                </div>
                            </div>-->
                        </div>
                        <div id="step-2" class="form-horizontal form-label-left">
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"
                                       style="font-size: 17px;"> وضعیت :
                                </label>
                                <div class="">
                                    <label>
                                        <input type="checkbox" class="js-switch" id="checkbox-10322"
                                               onclick="StatusCheck13442()" checked name="Active_Status"/> <b
                                                id="p-123343">فعال</b>
                                        <script charset="utf-8">
                                            function StatusCheck13442() {
                                                var checkBox = document.getElementById("checkbox-10322");
                                                var text = document.getElementById("p-123343");
                                                if (checkBox.checked == true) {
                                                    text.innerHTML = "فعال";
                                                } else {
                                                    text.innerHTML = "غیرفعال";
                                                }
                                            }
                                        </script>
                                    </label>
                                </div>
                            </div>
                            <script>
                                $(document).ready(function(){
                                    $('#winner_number').on('change', function() {
                                       this.value;
                                    })
                                });
                                function WinnerSelect() {
                                    $('#heard').change(function(){
                                        var selected = $(this).find('option:selected').attr('id');
                                        $(".winners_input").css("display","none");
                                        $("#winnerInp-"+selected).css("display","block");
                                    });
                                }
                            </script>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"
                                       style="font-size: 20px;"> تعیین برنده ها : <span class="required">*</span>
                                </label>
                                <div class="col-md-4">
                                    <p id="test"></p>
                                    <label for="heard">.جایزه برنده ها را تعیین کنید</label>
                                    <select id="heard" class="form-control" required onclick="WinnerSelect()" style="margin-bottom: 15px;">
                                        <option value="0">جایزه را تعیین گنید</option>
                                        <script charset="utf-8">
                                            var placeholderr = "انتخاب نشده";
                                            for (var a=1;a <= 23;a++){
                                                switch (a){
                                                    case 1:placeholderr="نفر اول";break;case 2:placeholderr="نفر دوم";break;case 3:placeholderr="نفر سوم";break;
                                                    case 4:placeholderr="نفر چهارم";break;case 5:placeholderr="نفر پنجم";break;case 6:placeholderr="نفر ششم";break;
                                                    case 7:placeholderr="نفر هفتم";break;case 8:placeholderr="نفر هشتم";break;case 9:placeholderr="نفر نهم";break;
                                                    case 10:placeholderr="نفر دهم";break;case 11:placeholderr="نفر یازدهم";break;case 12:placeholderr="نفر دوازدهم";break;
                                                    case 13:placeholderr="نفر سیزدهم";break;case 14:placeholderr="نفر چهاردم";break;case 15:placeholderr="نفر پانزدهم";break;
                                                    case 16:placeholderr="نفر شانزدهم";break;case 17:placeholderr="نفر هفتدهم";break;case 18:placeholderr="نفر هجدهم";break;
                                                    case 19:placeholderr="نفر نوزدهم";break;case 20:placeholderr="نفر بیستم";break;case 21:placeholderr="نفر بیست و یکم";break;
                                                    case 22:placeholderr="نفر بیست و دوم";break;case 23:placeholderr="نفر بیست و سوم";break;case 23:placeholderr="نفر بیست و سوم";break;
                                                }
                                                $('#heard').append("<option id='"+a+"'>"+placeholderr+"</option>");
                                            }
                                        </script>
                                    </select>
                                    <div id = "winnersawardsbox">
                                        <script charset="utf-8">
                                            placeholderrr = "انتخاب نشده";
                                            for (var i = 0;i <= 20;i++){
                                                console.log(placeholderrr);
                                                switch (i){
                                                    case 1:placeholderrr="نفر اول";break;case 2:placeholderrr="نفر دوم";break;case 3:placeholderrr="نفر سوم";break;
                                                    case 4:placeholderrr="نفر چهارم";break;case 5:placeholderrr="نفر پنجم";break;case 6:placeholderrr="نفر ششم";break;
                                                    case 7:placeholderrr="نفر هفتم";break;case 8:placeholderrr="نفر هشتم";break;case 9:placeholderrr="نفر نهم";break;
                                                    case 10:placeholderrr="نفر دهم";break;case 11:placeholderrr="نفر یازدهم";break;case 12:placeholderrr="نفر دوازدهم";break;
                                                    case 13:placeholderrr="نفر سیزدهم";break;case 14:placeholderrr="نفر چهاردم";break;case 15:placeholderrr="نفر پانزدهم";break;
                                                    case 16:placeholderrr="نفر شانزدهم";break;case 17:placeholderrr="نفر هفتدهم";break;case 18:placeholderrr="نفر هجدهم";break;
                                                    case 19:placeholderrr="نفر نوزدهم";break;case 20:placeholderrr="نفر بیستم";break;case 21:placeholderrr="نفر بیست و یکم";break;
                                                    case 22:placeholderrr="نفر بیست و دوم";break;case 23:placeholderrr="نفر بیست و سوم";break;case 23:placeholderrr="نفر بیست و سوم";break;
                                                }
                                                $("#winnersawardsbox").append("<input type='number' class='form-control col-md-3 col-xs-12 winners_input' style='display: none;' id='winnerInp-"+i+"' name='Winners_num["+i+"]' placeholder='"+placeholderrr+"' step='1000' min='0'>");
                                            }
                                        </script>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"
                                       style="font-size: 20px;"> محدودیت کاربر : <span class="required">*</span>
                                </label>
                                <div class="">
                                    <label>
                                        <input type="checkbox" class="js-switch" id="checkbox-10323"
                                               onclick="StatusCheck13452()" name="Users_Limitation_Stat"/> <b
                                                id="p-123353">غیر فعال</b>
                                    </label>
                                </div>
                                <div class="col-md-2">
                                    <div style="display:none;" id="limitation_user">
                                        <p>تعداد را مشخص کنید</p>
                                        <input type="number" name="User_Limitation_Num"
                                               class="form-control col-md-7 col-xs-12" placeholder=""
                                               style="font-size: 20px;text-align: center;" min="2">
                                    </div>
                                    <p>کل کاربران: <?= $all_users ?>  </p>
                                    <p>تعداد کاربرانی که میتوانند در مسابقه شرکت
                                        کنند: <?= $users_have_permission_to_join_compet ?></p>
                                </div>
                                <script charset="utf-8">
                                    function StatusCheck13452() {
                                        var checkBox = document.getElementById("checkbox-10323");
                                        var text = document.getElementById("p-123353");
                                        var div = document.getElementById("limitation_user");
                                        if (checkBox.checked == true) {
                                            text.innerHTML = "فعال";
                                            div.style.display = "block";
                                        } else {
                                            text.innerHTML = "غیرفعال";
                                            div.style.display = "none";
                                        }
                                    }
                                </script>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"
                                       style="font-size: 20px;"> آیکون مسابقه :
                                </label>
                                <div>
                                    <label>
                                        <input type="checkbox" class="js-switch" id="checkbox-11622"
                                               onclick="StatusCheck13464()" name="Icon_Uploading_Stat"/> <b
                                                id="p-1923343">عکس پیشفرض</b>
                                    </label>
                                </div>
                                <div class="col-md-2" style="display: none;" id="image_upload-12343">
                                    <input type="file" class="form-control col-md-7 col-xs-12" style="width: 300px;"
                                           name="Icon_image">
                                </div>
                                <script charset="utf-8">
                                    function StatusCheck13464() {
                                        var checkBox = document.getElementById("checkbox-11622");
                                        var text = document.getElementById("p-1923343");
                                        var div = document.getElementById("image_upload-12343");
                                        if (checkBox.checked == true) {
                                            text.innerHTML = "آپلود عکس";
                                            div.style.display = "block";
                                        } else {
                                            text.innerHTML = "عکس پیشفرض";
                                            div.style.display = "none";
                                        }
                                    }
                                </script>
                            </div>
                        </div>
                        <div id="step-3" class="form-horizontal form-label-left">
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> قیمت تیکت :
                                    <span class="required">*</span>
                                </label>
                                <div class="col-md-2">
                                    <input type="number" class="form-control col-md-7 col-xs-12" placeholder="تومان"
                                           name="Ticket_Price" style="direction: rtl!important;" min="1000" step="500">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> روش های
                                    پرداخت : <span class="required">*</span>
                                </label>
                                <div class="col-md-5">
                                    <?php
                                    if (count($payment_method_list) == 0) {
                                        echo "!موردی یافت نشد";
                                    } else {
                                        foreach ($payment_method_list as $method) {
                                            ?>
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" class="flat"
                                                           name="payment_category[<?= $method['Cat_id'] ?>]"> <?= $method['Payment_Method'] ?>
                                                    ( <?= $method['Currency'] ?> )
                                                </label>
                                            </div>
                                        <?php }
                                    } ?>
                                </div>
                            </div>
                        </div>
                        <!--
                        <div id="step-4">
                            <h2 class="StepTitle">Step 4 Content</h2>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                                Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                            </p>
                            <p>
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor
                                in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                            </p>
                            <p>
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor
                                in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                            </p>
                        </div>
                        -->
                </form>
            </div>

            <!-- End SmartWizard Content -->

        </div>
    </div>
</div>
</div>
<!-- Switchery -->
<script src="panel/vendors/switchery/dist/switchery.min.js"></script>
<?php
if (isset($_GET['id'])){
    $panel = new \Controller\panel();
    if (isset($panel->start()['slidersss'])){
        $sliders = $panel->start()['slidersss'][0];
        ?>
        <div class="right_col" role="main">
            <div class="clearfix"></div>
            <div class="row">
                <div class="col-md-6 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>مشخصات اسلایدر </h2>
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
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">عنوان اصلی
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" id="first-name" value="<?=$sliders['Header_Text']?>" class="form-control col-md-7 col-xs-12" name="Header_Text">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">توضیحات
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" id="first-name" value="<?=$sliders['Content_Text']?>" class="form-control col-md-7 col-xs-12" name="Content_Text">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">لینک اسلایدر
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input class="date-picker form-control col-md-7 col-xs-12" type="text" name="Href_Url" placeholder="http://example.com" value = "<?=$sliders['Href_Url']?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">نوشته دکمه
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input class="date-picker form-control col-md-7 col-xs-12" type="text" name="Button_Text" value = "<?=$sliders['Button_Text']?>">
                                    </div>
                                </div>
                                 <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">رنگ دکمه
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input class="date-picker form-control col-md-7 col-xs-12" type="text" name="Button_Color" value = "<?=$sliders['Button_Color']?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">اسلایدر جدید
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input class="date-picker form-control col-md-7 col-xs-12" type="file" name="Big_Image">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">آیکون جدید
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input class="date-picker form-control col-md-7 col-xs-12" type="file" name="Icon_Image">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"
                                           style="font-size: 17px;"> وضعیت:
                                    </label>
                                    <div class="">
                                        <label>
                                            <input  name="Active_Status" type="checkbox" class="js-switch" id="checkbox-10322"
                                                    onclick="StatusCheck13442()" <?php if ($sliders['Active_Status'] == 1){echo "checked";}?>/> <b
                                                id="p-123343"><?php if ($sliders['Active_Status'] == 1){echo "فعال";}else{echo "غیرفعال";}?></b>
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
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"
                                           style="font-size: 17px;"> وضعیت دکمه :
                                    </label>
                                    <div class="">
                                        <label>
                                            <input  name="Button_Status" type="checkbox" class="js-switch" id="checkbox-10322"
                                                    onclick="StatusCheck13442()" <?php if ($sliders['Button_Status'] == 1){echo "checked";}?>/> <b
                                                id="p-123343"><?php if ($sliders['Button_Status'] == 1){echo "فعال";}else{echo "غیرفعال";}?></b>
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
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">انتشار توسط
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input class="date-picker form-control col-md-7 col-xs-12" type="text" name="Published_By" value = "<?=$sliders['Published_By']?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">تاریخ انتشار
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input class="date-picker form-control col-md-7 col-xs-12" type="text" disabled value = "<?=date("Y-m-d H:i:s",$sliders['Published_At'])?>">
                                    </div>
                                </div>
                                 <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">آخرین ویرایش توسط
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input class="date-picker form-control col-md-7 col-xs-12" type="text" name="Last_Edit_By" value = "<?=$sliders['Last_Edit_By']?>">
                                    </div>
                                </div>
                                 <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">تاریخ آخرین ویرایش
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input class="date-picker form-control col-md-7 col-xs-12" type="text" disabled value = "<?=date("Y-m-d H:i:s",$sliders['Last_Edit_At'])?>">
                                    </div>
                                </div>
                                <input type="hidden" name="type" value="main">
                                <div class="ln_solid"></div>
                                <div class="form-group">
                                    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                        <a href="<?=HTTP_SERVER?>/profile?parts=slider_management" class="btn btn-primary">لغو و بازگشت</a>
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

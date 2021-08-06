<?php
    $panel = new \Controller\panel();
    $data = $panel->start();
    $person = $data['wallet']['person'];
    $balance = $data['wallet']['balance'];
    $is_valid = $data['wallet']['is_valid'];
    $active = $data['wallet']['active'];
?>
<div class="right_col" role="main">
    <?php if ($data['wallet']['exist']){?>
        <div class="page-title">
            <div class="title_left">
                <h3>کیف پول <a href= "/profile?parts=users_info&email=<?=$_GET['email']?>" title="مشخصات کاربر"><?=$_GET['email']?></a></h3>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-6 col-sm-12 col-xs-12">
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
                            <!--
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
                            -->
                            <div class="form-group">
                                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                    <a href="<?=HTTP_SERVER?>/profile?parts=user_management" class="btn btn-primary">لغو و بازگشت</a>
                                    <input type="Submit" class="btn btn-success" value="ذخیره" name="Submit" onclick="this.disabled=true;this.form.submit();">
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>عملیات</h2>
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

                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">عملیات <span class="required">*</span>
                                </label>
                                <div class="btn-group">
                      <button type="button" class="btn btn-danger">انجام عملیات</button>
                      <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        <span class="caret"></span>
                        <span class="sr-only">Toggle Dropdown</span>
                      </button>
                      <ul class="dropdown-menu" role="menu">
                        <li><a href="/profile?parts=wallets_info&email=<?=$_GET['email']?>&action=sum">اضافه کردن به اعتبار</a>
                        </li>
                        <li><a href="/profile?parts=wallets_info&email=<?=$_GET['email']?>&action=dec">کسر کردن از اعتبار</a>
                        </li>
                        <?php if ($active){?>
                        <li><a href="/profile?parts=wallets_info&email=<?=$_GET['email']?>&action=deactive">غیرفعال</a>
                        </li>
                        <?php }else{?>
                        <li><a href="/profile?parts=wallets_info&email=<?=$_GET['email']?>&action=active">فعال</a>
                        </li>
                        <?php }?>
                        <li><a href="/profile?parts=wallets_info&email=<?=$_GET['email']?>&action=validit">معتبر سازی</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="/profile?parts=wallets_info&email=<?=$_GET['email']?>&action=delete">حذف کیف پول</a>
                        </li>
                      </ul>
                    </div>
                            </div>
                            <?php if (isset($_GET['action'])){?>
                            <form  class="form-horizontal form-label-left" method="post">
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">مقدار
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="first-name" class="form-control col-md-7 col-xs-12" name="balance" placeholder="مقدار">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                   <!-- <a href = "/profile?parts=wallets_info&email=<?=$_GET['email']?>&action=<?=$_GET['action']?>&submit" class="btn btn-success">ذخیره</a>-->
                                   <input class="btn btn-success" value="ذخیره" name="submit" type="submit">
                                </div>
                            </div>
                            </form>
                            <?php }?>
                        
                    </div>
                </div>
            </div>
        </div>
        <?php }else{?>
        <a href="/profile?parts=wallets_info&email=<?=$_GET['email']?>&action=create" class="btn btn-success" style="border-radius:100px;">ساخت کیف پول</a>
        <?php }?>
    </div>
        
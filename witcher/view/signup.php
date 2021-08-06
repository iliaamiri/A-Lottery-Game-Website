<?php
$msg = new \Model\message();
?>
<div class="footer-container">
    <div class="column">
        <br><br><br><h3 class="headline2 cblue" style="font-size: 37px;">ثبت نام</h3>
        <b><?php $msg->msg_session_show();?></b><br><br>
        <div class="box">
            <form method="post">
                <ul class="form-container" dir="rtl">
                    <li class="form-row">
                        <div class="form-group inverted">
                            <input type="text" name="Full_Name" placeholder="نام و نام خانوادگی" class="field fields s-medium remember" style="width: 340px;text-align: center;font-size: 17px;">
                        </div>
                    </li>
                    <li class="form-row">
                        <div class="form-group inverted">
                            <input type="text" name="Username" placeholder="نام کاربری" class="field fields s-medium remember" style="width: 340px;text-align: center;font-size: 17px;">
                        </div>
                    </li>
                    <li class="form-row">
                        <div class="form-group inverted">
                            <input type="password" name="Password" placeholder="پسورد" class="field fields s-medium remember" style="width: 340px;text-align: center;font-size: 17px;">
                        </div>
                    </li>
                    <li class="form-row">
                        <div class="form-group inverted">
                            <input type="password" name="rePassword" placeholder="تایید پسورد" class="field fields s-medium remember" style="width: 340px;text-align: center;font-size: 17px;">
                        </div>
                    </li>
                    <li class="form-row">
                        <div class="form-group inverted">
                            <input type="text" name="Email" placeholder="ایمیل" class="field fields s-medium remember" style="width: 340px;text-align: center;font-size: 17px;">
                        </div>
                    </li>
                    <li class="form-row">
                        <div class="hidden-mobile" style="width: 100%;">
                            <input type="submit" name="Signup" value="ثبت نام" class="btn btn green" tabindex="3" style="padding:10px 50px;text-align: center;" onclick="this.disabled=true;this.form.submit();"><br>
                            <p class="center"><a href="/login" onclick="clickAndDisable(this)">آیا ثبت نام کرده اید؟</a></p>
                        </div>

                        <div class="hidden-desktop hidden-tablet">
                            <input type="submit" name="Signup" value="ثبت نام" class="btn btn green" tabindex="3" style="padding:10px 50px;text-align: center;" onclick="this.disabled=true;this.form.submit();"><br>
                            <p class="center"><a href="/login" onclick="clickAndDisable(this)">آیا ثبت نام کرده اید؟</a></p>
                        </div>
                    </li>
                </ul>
            </form>
        </div>

        <div class="spacer20 show-tablet"></div>
    </div>

</div>
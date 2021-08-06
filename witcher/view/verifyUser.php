<?php if (isset($_SESSION['ROLLING_STATUS'])){
    if ($_SESSION['ROLLING_STATUS'] == "ReadyToGetVerifyCode"){
        $msg = new \Model\message();
    ?>
<div class="footer-container">
    <div class="column">
        <br><br><br><h3 class="headline2 cblue">ایمیل خود را چک کنید.</h3>
        <p>ایمیل شما : </p><?=$_SESSION['EMAIL']?>

        <div class="box">
            <form method="post">
                <ul class="form-container" dir="rtl">
                    <li class="form-row">
                        <div class="form-group inverted">
                            <input type="password" name="Code" placeholder="کد" class="field fields s-medium remember" style="width: 340px;text-align: center;font-size: 17px;">
                        </div>
                    </li>
                    <!-- todo : captcha in here .-->
                    <li class="form-row">
                        <div class="hidden-mobile" style="width: 100%;">
                            <input type="submit" name="Signup" value="ثبت نام" class="btn btn green" tabindex="3" style="padding:10px 50px;text-align: center;" onclick="this.disabled=true;this.form.submit();"><br>
                        </div>

                        <div class="hidden-desktop hidden-tablet">
                            <p class="center"><a href="/login" onclick="clickAndDisable(this)">ثبت نام کرده اید؟</a></p>
                        </div>
                    </li>
                    <p><?php $msg->msg_session_show();?></p>
                </ul>
            </form>
        </div>

        <div class="spacer20 show-tablet"></div>
    </div>

</div>
<?php }
// todo : show 404 error part .
} ?>

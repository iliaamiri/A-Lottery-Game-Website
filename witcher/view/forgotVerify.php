<?php
?>
<div class="footer-container">
    <?php \Model\message::msg_box_session_show();?>
    <div class="column">
        <br><br><br><h3 class="headline2 cblue" style="font-size: 37px;">کد تایید</h3><br>
        <div class="box">
            <form method="post">
                <ul class="form-container" dir="rtl">
                    <li class="form-row">
                        <div class="form-group inverted">
                            <input type="text" name="Code" placeholder="کد" class="field fields s-medium remember" style="width: 340px;text-align: center;font-size: 17px;">
                        </div>
                    </li>
                    <li class="form-row">
                        <div class="hidden-mobile" style="width: 100%;">
                            <input type="submit" name="VerifySubmit" value="تایید کد" class="btn btn green" tabindex="3" style="padding:10px 50px;text-align: center;" ><br>
                        </div>

                        <div class="hidden-desktop hidden-tablet">
                            <input type="submit" name="VerifySubmit" value="تایید کد" class="btn btn green" tabindex="3" style="padding:10px 50px;text-align: center;"><br>
                        </div>
                    </li>
                </ul>
            </form>
        </div>

        <div class="spacer20 show-tablet"></div>
    </div>

</div>


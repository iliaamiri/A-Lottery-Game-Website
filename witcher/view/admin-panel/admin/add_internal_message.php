<?php
    $panel = new \Controller\panel();
    $datas = $panel->start();
    $receivers = $datas['receivers_emails'];
?>
<!--<script src="https://cdn.ckeditor.com/4.7.2/standard/ckeditor.js"></script>-->
<form method="post">
<div class="right_col" role="main">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="form-group">
            <label class="control-label col-md-1 col-sm-3 col-xs-12" for="first-name">ایمیل گیرنده :
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <select id="heard" class="form-control" required="" name="Email_Receiver">
                    <option value="">انتخاب کنید</option>
                    <?php foreach ($receivers as $receiver){?>
                    <option value="<?=$receiver['Email']?>"><?=$receiver['Email']?></option>
                    <?php }
                    if (count($receivers) == 0){?>
                        <option>موردی یافت نشد</option>
                    <?php }?>
                </select>
            </div>
        </div>
        <div class="x_panel">
            <div class="x_title">
                <h2>پیام جدید</h2>
                <div class="clearfix"></div>
            </div>

                <div class="form-group">
                    <label class="control-label col-md-1 col-sm-3 col-xs-12" for="first-name">موضوع :
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" id="first-name" required="required" class="form-control col-md-7 col-xs-12" placeholder="موضوع" name="Subject">
                    </div>
                </div>
                <div class="x_content">
                    <div id="alerts"></div>
                    <textarea name="Texts" ></textarea>
                    <script>
                        CKEDITOR.replace('Texts');
                    </script>
                    <br><br>

                    <br>
                    <div id="cke_editor" dir="rtl"></div>
                    <br />
                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="submit" class="btn btn-success" value="ثبت" onclick="this.disabled=true;this.form.submit();">
                        </div>
                    </div>
                </div>

        </div>
    </div>
</div>
</form>
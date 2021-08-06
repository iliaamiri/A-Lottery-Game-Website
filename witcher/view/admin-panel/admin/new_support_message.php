<?php
?>
<script src="https://cdn.ckeditor.com/4.7.2/standard/ckeditor.js"></script>

<div class="right_col" role="main">
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
        <div class="x_title">
            <h2>درخواست پشتیبانی</h2>
            <div class="clearfix"></div>
        </div>
        <form method="post">
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
                    <button class="btn btn-primary" type="button">لغو و بازگشت</button>
                    <input type="submit" class="btn btn-success" value="ثبت">
                </div>
            </div>
        </div>
        </form>
    </div>
</div>
</div>

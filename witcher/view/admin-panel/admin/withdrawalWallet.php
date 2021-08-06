<?php
$panel = new \Controller\panel();
$data = $panel->start();
$wallet_info = $data['wallet'];
?>
<div class="right_col" role="main">
    <div class="">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2 style="float: right;font-size: 30px;">برداشت از کیف پول </h2>
                        <div class="clearfix"></div>
                    </div>

                    <div class="x_content">
                        <?php if ($wallet_info['Exist'] AND $wallet_info['Valid'] AND $wallet_info['Status']){?>
                        <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" method="post">
                        <div class="form-group">
                            <p style="text-align: center;font-size: 24px;">          موجودی(تومان):<?="<b style='margin-right: 10px;'>".$wallet_info['Info']['Balance']."</b>"?>           </p>
                            <label class="control-label col-md-4 col-sm-3 col-xs-12" for="first-name" style="direction: rtl!important;font-size: 17px;">مبلغ (تومان)<span class="required">*</span>
                            </label>
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <input type="number" min="1000" step="100" id="first-name" required="required" class="form-control col-md-7 col-xs-12" placeholder="مبلغ را وارد کنید" style="text-align: center;border-radius: 100px;" name="amount">
                            </div>
                        </div>
                            <div class="form-group">
                                <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12"></label>
                                <div class="col-md-6 col-sm-6 col-xs-12" style="display: block;text-align: center;">
                                    <input id="middle-name" class="btn btn-success" type="submit" name="withdrawal" value="برداشت" style="border-radius:100px;padding: 7px 24px;font-size: 17px;">
                                </div>
                            </div>
                        </form>
                        <?php }elseif (!$wallet_info['Status'] AND $wallet_info['Exist']){?>
                            <div style="text-align: center;">
                                <a style="margin: 0 auto;text-align: center;padding: 8px 17px;border-radius: 100px;direction: rtl!important;" class="btn btn-success">کیف پول شما توسط ادمین غیرفعال شده است.</a>
                            </div>
                        <?php } elseif(!$wallet_info['Exist']){?>
                            <div style="text-align: center;">
                                <a href="btn btn-success" style="border-radius: 100px;">ساخت کیف پول</a>
                            </div>
                        <?php }?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

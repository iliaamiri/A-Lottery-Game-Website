<?php
$panel = new \Controller\panel();
$data = $panel->start();
$payment_list = $data['payment_cats'];
?>
<div class="right_col" role="main">
    <div class="page-title">
        <div class="title_left">
            <h3 style="display: inline-block">تنظیمات روش های پرداخت</h3>
            <a href="/profile/setting/payments/add" class="btn btn-success" style="border-radius: 100px;margin-left:50px;">ساخت متود جدید</a>
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
                    <h2>لیست روش های پرداختی </h2>
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
                    <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>نام متود</th>
                            <th>واحد پول</th>
                            <th>وضعیت</th>
                            <th>آخرین ویرایشگر</th>
                            <th>کلید api</th>
                            <th>لینک</th>
                            <th>تغییر وضعیت</th>
                            <th>ویرایش</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($payment_list as $value){?>
                                <tr>
                                <td style="text-align: center!important;"><?=$value['Cat_id']?></td>
                                <td style="text-align: center!important;"><?=$value['Payment_Method']?></td>
                                <td style="text-align: center!important;"><?=$value['Currency']?></td>
                                <td style="text-align: center!important;"><?php if ($value['Status'] == 1){echo "فعال";}else{echo "غیرفعال";}?></td>
                                <td style="text-align: center!important;"><?=$value['Last_editor']?></td>
                                <td style="text-align: center!important;"><?=$value['Api_Key']?></td>
                                <td style="text-align: center!important;"><?=$value['Url']?></td>
                                <td>
                                    <a href="/profile/setting/payments/changeStat?id=<?=$value['Cat_id']?>" class="btn btn-<?php if ($value['Status'] == 1){echo "danger";}else{echo "success";}?>" style="width: 100%;height: 100%;-webkit-border-radius: 100px;-moz-border-radius: 100px;border-radius: 100px;"><?php if ($value['Status'] == 1){echo "غیرفعال";}else{echo "فعال";}?></a>
                                </td>
                                    <td>
                                        <a href="/profile/setting/payments/edit?id=<?=$value['Cat_id']?>" class="btn btn-primary" style="width: 100%;height: 100%;border-radius: 100px;">ویرایش</a>
                                    </td>
                                </tr>
                            <?php }?>
                        </tbody>
                    </table>
                    <?php if (isset($_GET['action'])){if ($_GET['action'] == "edit"){
                        $payment = new \Model\payment();
                        $payment_value = $payment->getCatBy('Cat_id',$_GET['id'])[0];
                        ?>
                    <form  class="form-horizontal form-label-left" method="post">
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">نام متود <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" id="first-name" value="<?=$payment_value['Payment_Method']?>" required="required" class="form-control col-md-7 col-xs-12" placeholder="نام متود" name="Method" title="نام متود هنگام ساخت فاکتور توسط مشتری نمایش داده میشود">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">واحد پول <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" id="first-name" value="<?=$payment_value['Currency']?>" required="required" class="form-control col-md-7 col-xs-12" placeholder="مانند ( Toman , US Dollar )" name="Currency">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">کلید api <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" id="first-name" value="<?=$payment_value['Api_Key']?>" required="required" class="form-control col-md-7 col-xs-12" placeholder="API Key" name="ApiKey" title="کلید api">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">لینک سایت خرید<span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" id="first-name" value="<?=$payment_value['Url']?>" required="required" class="form-control col-md-7 col-xs-12" placeholder="لینک سایت خرید " name="Url" title="http://example.com">
                            </div>
                        </div>
                         <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">لینک  چک کننده سایت خرید<span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" id="first-name" value="<?=$payment_value['Checker_url']?>" required="required" class="form-control col-md-7 col-xs-12" placeholder="لینک سایت خرید " name="Checker_url" title="http://example.com">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">لینک  بازگشت<span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" id="first-name" value="<?=$payment_value['Callback']?>" required="required" class="form-control col-md-7 col-xs-12" placeholder="لینک سایت خرید " name = "Callback" title="http://example.com">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                <a href="<?=HTTP_SERVER?>/profile/setting/payments" class="btn btn-primary">لغو و بازگشت</a>
                                <button class="btn btn-primary" type="reset">پاک کردن همه</button>
                                <input type="Submit" class="btn btn-success" value="اعمال تغییرات" name="EditSubmit">
                            </div>
                        </div>
                    </form>
                    <?php }elseif ($_GET['action'] == "new"){?>
                        <form  class="form-horizontal form-label-left" method="post">
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">نام متود <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="first-name" required="required" class="form-control col-md-7 col-xs-12" placeholder="نام متود" name="Method" title="نام متود هنگام ساخت فاکتور توسط مشتری نمایش داده میشود">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">واحد پول <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="first-name" required="required" class="form-control col-md-7 col-xs-12" placeholder="مانند ( Toman , US Dollar )" name="Currency">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">کلید api <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="first-name"  required="required" class="form-control col-md-7 col-xs-12" placeholder="API Key" name="ApiKey" title="کلید api">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">لینک سایت خرید<span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="first-name" required="required" class="form-control col-md-7 col-xs-12" placeholder="لینک سایت خرید " name="Url" title="http://example.com">
                                </div>
                            </div>
                            <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">لینک  چک کننده سایت خرید<span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" id="first-name" value="<?=$payment_value['Checker_url']?>" required="required" class="form-control col-md-7 col-xs-12" placeholder="لینک سایت خرید " name="Checker_url" title="http://example.com">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">لینک  بازگشت<span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" id="first-name" value="<?=$payment_value['Callback']?>" required="required" class="form-control col-md-7 col-xs-12" placeholder="لینک سایت خرید " name = "Callback" title="http://example.com">
                            </div>
                        </div>
                            <div class="form-group">
                                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                    <a href="<?=HTTP_SERVER?>/profile/setting/payments" class="btn btn-primary">لغو و بازگشت</a>
                                    <button class="btn btn-primary" type="reset">پاک کردن همه</button>
                                    <input type="Submit" class="btn btn-success" value="اعمال تغییرات" name="NewSubmit">
                                </div>
                            </div>
                        </form>
                    <?php }}?>
                </div>
            </div>
        </div>
    </div>
</div>

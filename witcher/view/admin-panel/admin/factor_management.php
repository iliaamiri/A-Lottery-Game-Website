<?php
$panel = new \Controller\panel();
$user = new \Model\user();
$data = $panel->start();
$comp = new \Model\competition();
if (count($data['factors']) > 0 ){
?>
<div class="right_col" role="main">
    <div class="">
        <?php if (!isset($_GET['factor_num'])){?>
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>لیست فاکتورها</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
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
                        <p class="text-muted font-13 m-b-30">

                        </p>

                        <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th style="text-align: center;">شماره فاکتور</th>
                                <th style="text-align: center;">شماره ارجاع</th>
                                <th style="text-align: center;">تعداد </th>
                                <th style="text-align: center;">وضعیت</th>
                                <th style="text-align: center;">تاریخ شروع</th>
                                <th style="text-align: center;">تاریخ پایان</th>
                                <th style="text-align: center;">مسابقه</th>
                                <th style="text-align: center;">چراغ گزارش</th>
                                <th style="text-align: center;">جزئیات</th>
                                <th style="text-align: center;">حذف</th
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($data['factors'] as $factor_value){
                                $comp_info = $comp->getFrom_Competition_tbl_by($factor_value['Competition_Id']);
                                ?>
                                <tr style="text-align: center;">
                                    <td><?= $factor_value['Factor_number']?></td>
                                    <td><?php
                                        if ($factor_value['Tracking_number'] == "IsNotSet"){
                                            echo "تعیین نشده است.";
                                        }
                                        ?></td>
                                    <td><?= $factor_value['Amount']?></td>
                                    <td><?php
                                        switch ( $factor_value['Status']){
                                            case "Burnt":
                                                echo "سوزانده شد";
                                                break;
                                            case "Hover":
                                                echo "معلق";
                                                break;
                                            case "WaitingForPaying":
                                                echo "در انتظار پرداخت";
                                                break;
                                            case "Done":
                                                echo "انجام شد";
                                                break;
                                            default:
                                                echo "نامعلوم";
                                                break;
                                        }
                                        ?></td>
                                    <td><?= date("Y/m/d H:i:s",$factor_value['Started_At'])?></td>
                                    <td><?php if ($factor_value['Ended_At'] == 0){echo "پایان نیافته";}else{echo date("Y/m/d H:i:s",$factor_value['Ended_At']);}?></td>
                                    <td><?php
                                        if ($comp_info['Title'] == ""){
                                            echo "نامعلوم";
                                        }else{
                                            echo $comp_info['Title'];
                                        }
                                        ?></td>
                                    <td><?php if ($factor_value['Report_Lamp'] == 1){echo "<b style='color: red;'>"."گزارش شده."."</b>";}else{echo "گزارش نشده";}?></td>
                                    <td>
                                        <a href="/profile?parts=factor_management&factor_num=<?=$factor_value['Factor_number']?>" class="btn btn-success" style="width: 100%;height: 100%;">جزئیات</a>
                                    </td>
                                    <td>
                                        <a href="/profile?parts=factor_management&factor_num=<?=$factor_value['Factor_number']?>&delete" class="btn btn-danger" style="width: 100%;height: 100%;">حذف</a>
                                    </td>
                                </tr>
                            <?php }?>
                            </tbody>
                        </table>


                    </div>
                </div>
            </div>
        <?php }elseif (isset($_GET['factor_num'])){
            $factor_details = $data['factor_details'];
            $user_info = $user->getUserInfoBy('Email',$factor_details['Email'])[0];
            $competition = array_merge([$comp->getFrom_Competition_tbl_by($factor_details['Competition_Id'])],[$comp->getFrom_Competition_attributes_by($factor_details['Competition_Id'])]);
            ?>
        <div class="page-title">
            <div class="title_left">
                <h3>فاکتور <small>جزئیات</small></h3>
            </div>

            <div class="title_right">
                <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search for...">
                        <span class="input-group-btn">
                      <button class="btn btn-default" type="button">Go!</button>
                    </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2><br></h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
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

                        <section class="content invoice">
                            <!-- title row -->
                            <div class="row">
                                <div class="col-xs-12 invoice-header">
                                    <h1>
                                        <i class="fa fa-globe"></i> WEBSITE FACTOR.
                                        <small class="pull-right">تاریخ: <?=date("Y/m/d",$factor_details['Started_At'])?></small>
                                    </h1>
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- info row -->
                            <div class="row invoice-info">
                                <div class="col-sm-4 invoice-col">
                                    واریز کننده
                                    <address>
                                        <strong><?=$user_info['First_Name']." ".$user_info['Last_Name']?></strong>
                                        <br><?=$user_info['Address']?>
                                        <br>Phone: 1 (804) 123-9876
                                        <br>Email: <?=$user_info['Email']?>
                                    </address>
                                </div>
                                <!-- /.col -->
                                <div class="col-sm-4 invoice-col">
                                    به حساب
                                    <address>
                                        <strong>WEBSITE</strong>
                                        <br><a href="<?=HTTP_SERVER?>">WWW.WEBSITE.COM</a>
                                        <br>Email: SUPPORT@WEBSITE.COM
                                    </address>
                                </div>
                                <!-- /.col -->
                                <div class="col-sm-4 invoice-col">
                                    <b>شمازه فاکتور #<?=$factor_details['Factor_number']?></b>
                                    <br>
                                    <br>
                                    <b>مسابقه:</b><?=$factor_details['Competition_Id']?>
                                    <br>
                                    <b>تاریخ پرداخت:</b><?php if ($factor_details['Ended_At'] == 0){echo "پرداخت نشده.";}else{echo date("Y/m/d",$factor_details['Ended_At']);}?>
                                    <br>
                                    <b>شماره کارت:</b> 968-34567
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->

                            <!-- Table row -->
                            <div class="row">
                                <div class="col-xs-12 table">
                                    <table class="table table-striped">
                                        <thead>
                                        <tr>
                                            <th style="text-align: center;">ردیف</th>
                                            <th style="text-align: center;"> کالا</th>
                                            <th style="text-align: center;">فی</th>
                                            <th style="text-align: center;">تعداد</th>
                                            <th style="text-align: center;">مسابقه</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr style="text-align: center;">
                                            <td>1</td>
                                            <td>بلیط مسابقه</td>
                                            <td><?=$competition['Tickets_price']*10?>  RIALS</td>
                                            <td><?=$factor_details['Amount']?></td>
                                            <td><?=$factor_details['Competition_Id']?></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->

                            <div class="row">
                                <!-- accepted payments column -->
                                <div class="col-xs-6">
                                    <p class="lead">Payment Methods:</p>
                                    <img src="images/visa.png" alt="Visa">
                                    <img src="images/mastercard.png" alt="Mastercard">
                                    <img src="images/american-express.png" alt="American Express">
                                    <img src="images/paypal.png" alt="Paypal">
                                    <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
                                        Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles, weebly ning heekya handango imeem plugg dopplr jibjab, movity jajah plickers sifteo edmodo ifttt zimbra.
                                    </p>
                                </div>
                                <!-- /.col -->
                                <div class="col-xs-6">
                                    <p class="lead">Amount Due 2/22/2014</p>
                                    <div class="table-responsive">
                                        <table class="table">
                                            <tbody>
                                            <tr>
                                                <th style="width:50%">Subtotal:</th>
                                                <td>$250.30</td>
                                            </tr>
                                            <tr>
                                                <th>Tax (9.3%)</th>
                                                <td>$10.34</td>
                                            </tr>
                                            <tr>
                                                <th>Shipping:</th>
                                                <td>$5.80</td>
                                            </tr>
                                            <tr>
                                                <th>قابل پرداخت :</th>
                                                <td> ريال<?=$factor_details['Amount'] * $competition['Tickets_price'] * 10?></td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->

                            <!-- this row will not appear when printing -->
                            <div class="row no-print">
                                <div class="col-xs-12">
                                    <button class="btn btn-default" onclick="window.print();"><i class="fa fa-print"></i> Print</button>
                                    <button class="btn btn-success pull-right"><i class="fa fa-credit-card"></i> Submit Payment</button>
                                    <button class="btn btn-primary pull-right" style="margin-right: 5px;"><i class="fa fa-download"></i> Generate PDF</button>
                                    <a href="/profile?parts=factor_management&factor_num=<?=$_GET['factor_num']?>&delete" class="btn btn-danger pull-right" style="margin-right: 5px;"><i class="fa fa-times"></i> حذف</a>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
        <?php }?>
    </div>
</div>
<?php }?>

<?php
$panel = new \Controller\panel();
$comp = new \Model\competition();
$factor_data = $panel->start()['Factors_history_user'];
?>
<div class="right_col" role="main">
    <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>تاریخچه ها</h3>
            </div>
        </div>

        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>تاریخچه های مسابقات </h2>
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
                            <li><a class="close-link"><i class="fa fa-close"></i></a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th style="text-align: center;font-size: 20px;">شماره فاکتور</th>
                                <th style="text-align: center;font-size: 20px;">شماره پیگیری</th>
                                <th style="text-align: center;font-size: 20px;">روش پرداخت</th>
                                <th style="text-align: center;font-size: 20px;">وضعیت</th>
                                <th style="text-align: center;font-size: 20px;">  تاریخ ساخت</th>
                                <th style="text-align: center;font-size: 20px;">تاریخ پایان</th>
                                <th style="text-align: center;font-size: 20px;">نام مسابقه</th>
                                <th style="text-align: center;font-size: 20px;">پرداخت</th>
                            </tr>
                            </thead>


                            <tbody>
                            <?php
                            if ($factor_data){
                            foreach ($factor_data as $value){
                                //$value = array_merge($value,$comp->getFrom_Competition_attributes_by($value['Competition_Id'])[0]);
                                $compet = $comp->getFrom_Competition_tbl_by($value['Competition_Id']);
                                ?>
                                <tr>
                                    <td style="text-align: center;"><?=$value['Factor_number']?></td>
                                    <td style="text-align: center;font-size: 17px;"><?php if ($value['Tracking_number'] == "IsNotSet"){echo "تعیین نشد";}else{echo $value['Tracking_number'];}?></td>
                                    <td style="text-align: center;"><?=$value['Method']?></td>
                                    <td style="text-align: center;"><?php
                                        switch ( $value['Status']){
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
                                    <td style="text-align: center;"> <?=date("Y-d-m H:i:s",$value['Started_At'])?></td>
                                    <td style="text-align: center;direction: ltr    !important;"> <?=date("Y-d-m H:i:s",$value['Ended_At'])?></td>
                                    <td style="text-align: center;"><?=$compet['Title']?></td>
                                    <td style="text-align: center;"><a href="/factor?factor=<?=$value['Private_Key']?>" target="_blank" class="btn btn-success">پرداخت</a></td>
                                </tr>
                            <?php }}?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div></div>
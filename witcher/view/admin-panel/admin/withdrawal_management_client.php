<?php
$panel = new \Controller\panel();
$comp = new \Model\competition();
$withdrawals_data = $panel->start()['Withdrawals_list'];
?>
<div class="right_col" role="main">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>لیست برداشت ها</h3>
                </div>
            </div>

            <div class="clearfix"></div>

            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
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
                                    <th style="text-align: center;font-size: 20px;">ردیف</th>
                                    <th style="text-align: center;font-size: 20px;">مبلغ</th>
                                    <th style="text-align: center;font-size: 20px;">وضعیت</th>
                                    <th style="text-align: center;font-size: 20px;">شماره ارجاع</th>
                                    <th style="text-align: center;font-size: 20px;">زمان درخواست</th>
                                    <th style="text-align: center;font-size: 20px;">زمان پایان</th>
                                </tr>
                                </thead>

                                <tbody>
                                <?php if ($withdrawals_data){foreach ($withdrawals_data as $value){?>
                                        <tr>
                                            <td style="text-align: center;"><?=$value['id']?></td>
                                            <td style="text-align: center;"><?=$value['Amount']?></td>
                                            <td style="text-align: center;"><?php
                                                switch ( $value['Status']){
                                                    case "WaitingForAdmin":
                                                        echo "در حال انتظار";
                                                        break;
                                                    case "Done":
                                                        echo "انجام شد";
                                                        break;
                                                    default:
                                                        echo "در حال انتظار";
                                                        break;
                                                }
                                                ?></td>
                                            <td style="text-align: center;font-size: 17px;"><?php if ($value['Invoice_number'] == null){echo "تعیین نشد";}else{echo $value['Invoice_number'];}?></td>
                                            <td style="text-align: center;"> <?=date("Y-d-m H:i:s",$value['Submited_At'])?></td>
                                            <td style="text-align: center;direction: ltr    !important;"> <?=date("Y-d-m H:i:s",$value['Done_At'])?></td>
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
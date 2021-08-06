<?php
$panel = new \Controller\panel();
$data = $panel->start();
$wallet_history = $data['wallet_history'];
?>
<div class="right_col" role="main">
    <div class="">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>تاریخچه تراکنش ها</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>
                            <li><a class="close-link"><i class="fa fa-close"></i></a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <table id="datatable-buttons" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th style="text-align: center;">نوع عملیات</th>
                                <th style="text-align: center;">مبلغ</th>
                                <th style="text-align: center;">واریز کننده</th>
                                <th style="text-align: center;">به حساب</th>
                                <th style="text-align: center;">تاریخ انجام</th>
                                <th style="text-align: center;">ساعت</th>
                            </tr>
                            </thead>


                            <tbody>
                            <?php foreach ($wallet_history as $tran_value){?>
                                <tr>
                                    <td style="text-align: center;"><?php
                                        if ($tran_value['Trans_Action'] == "Deposit"){
                                            echo "شارژ";
                                        }else {
                                            echo "برداشت";
                                        }
                                        ?>
                                    </td>
                                    <td style="text-align: center;"><?=$tran_value['Amount']?></td>
                                    <td style="text-align: center;"><?=$tran_value['From_Account']?></td>
                                    <td style="text-align: center;"><?=$tran_value['To_Account']?></td>
                                    <td style="text-align: center;"><?=date("Y/m/d",$tran_value['Done_At'])?></td>
                                    <td style="text-align: center;"><?php if ($tran_value['Exact_Time'] > 0){echo date("H:i:s",$tran_value['Exact_Time']);}else{echo "نامشخص";} ?></td>
                                </tr>
                            <?php }?>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

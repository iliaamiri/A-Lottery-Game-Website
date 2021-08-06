<?php
$panel = new \Controller\panel();
$ticket = new \Model\ticket();
$datas = $panel->start();
?>
<div class="right_col" role="main">
<?php if ($datas['user_permissions']['Participate_Competitions'] == 1){?>
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>مسابقات حالا</h2>
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
                <?php if ($datas['Check_Competitions']['Number_of_Started_competitions'] == 0){?>
                    <p style="text-align: center;direction: rtl!important;cursor: default;">در حال حاضر مسابقه ای آغاز نشده است.</p>
                <?php }else{ $started_list = $datas['Check_Competitions']['FO_started'];
                    ?>
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th style="text-align: center;">نام مسابقه</th>
                            <th style="text-align: center;">زمان باقی مانده</th>
                            <th style="text-align: center;">قیمت تیکت</th>
                            <th style="text-align: center;">نحوه های پرداخت</th>
                            <th style="text-align: center;">بلیط های خریداری شده</th>
                            <th style="text-align: center;">خرید تیکت</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($started_list as $list_keys => $list_values){
                            $ticket->set_competition_id($list_values['Competition_Id']);
                            $Bought_tickets = count($ticket->get_tickets_data_of_competition());
                            ?>
                            <tr>
                                <th style="text-align: center;font-size: 17px;"><?=$list_values['Title']?></th>
                                <td id = "<?=$list_values['id']?>" style="text-align: center;">
                                    <?=date("M d, Y H:i:s",$list_values['Ends_At'])?>
                                </td>
                                <td style="text-align: center;"><?=$list_values['Tickets_price']?>  تومان</td>
                                <td style="text-align: center;"><?=$list_values['Payment_Methods']?></td>
                                <td style="text-align: center;"><?=$Bought_tickets?></td>
                                <td style="text-align: center;"><a href="/ticket/buy?c=<?=$list_values['Competition_Id']?>" class="btn btn-success" target="_blank">خرید تیکت</a></td>
                                <script>
                                    var id = document.getElementById(<?=$list_values['id']?>).getAttribute('id');
                                    CountDown(id);
                                </script>
                            </tr>
                        <?php }?>
                        </tbody>
                    </table>
                <?php }?>
            </div>
        </div>
    </div>
<?php }?>
</div>
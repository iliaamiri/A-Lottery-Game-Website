<?php
    $panel = new \Controller\panel();
    $ticket = new \Model\ticket();
    $winner = new \Model\winner();
    $datas = $panel->start();
    $list = $datas['get_competitions_in_tenLimit'];
?>
<div class="right_col" role="main">
    <div class="">
        <div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
                <a class="btn btn-app" style="border-radius: 100px;" onclick="window.location.reload()">
                    <i class="fa fa-repeat"></i> بارگذاری دوباره
                </a>
                <h3 style="float: right;">مسابقه جدید ترتیب دهید</h3>
                <a href="profile?parts=competition&Competition_Actions=New" class="btn" style="border-radius: 100px;padding: 6px 30px;background: #3ec415;color: white;font-size: 17px;float: right;margin-top: 5px;">مسابقه جدید</a>
                <div class="x_panel">
                    <div class="x_title">
                        <h2>آخرین مسابقات <small>با محدودیت ۱۰ ردیف</small></h2>
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

                        <p>با انتخاب کردن ردیف های مورد نظر می توانید اقداماتی نظیر ( حذف و ادیت کردن ) را انجام دهید.</p>

                        <div class="table-responsive">
                            <table class="table table-striped jambo_table bulk_action">
                                <thead>
                                <tr class="headings">
                                    <th>
                                        <input type="checkbox" id="check-all" class="flat">
                                    </th>
                                    <th class="column-title"  style="text-align: center;">نام مسابقه </th>
                                    <th class="column-title" style="text-align: center;">تاریخ شروع</th>
                                    <th class="column-title" style="text-align: center;">تاریخ پایان</th>
                                    <th class="column-title" style="text-align: center;">محدودیت شرکت کننده</th>
                                    <th class="column-title" style="text-align: center;">تعداد برنده</th>
                                    <th class="column-title" style="text-align: center;">جایزه نفر اول</th>
                                    <th class="column-title" style="text-align: center;">قیمت هر تیکت</th>
                                    <th class="column-title" style="text-align: center;">تیکت های خریداری شده</th>
                                    <th class="column-title" style="text-align: center;">روش های پرداخت</th>
                                    <th class="column-title" style="text-align: center;">ترتیب دهنده</th>
                                    <th class="column-title" style="text-align: center;">وضعیت فعال بودن</th>
                                    <th class="column-title" style="text-align: center;">نتیجه</th>
                                    <th class="column-title no-link last"><span class="nobr">کنسل کردن</span>
                                    <th class="column-title no-link last"><span class="nobr">تغییر</span>
                                    <th class="column-title no-link last"><span class="nobr">حذف</span>
                                    </th>
                                    <th class="bulk-actions" colspan="7">
                                        <a class="antoo" style="color:#fff; font-weight:500;">Bulk Actions ( <span class="action-cnt"> </span> ) <i class="fa fa-chevron-down"></i></a>
                                    </th>
                                </tr>
                                </thead>

                                <tbody>
                                <?php foreach ($list as $item){
                                    $winner->set_c_id($item['Competition_Id']);
                                    $ticket->set_competition_id($item['Competition_Id']);
                                    $biggest = $winner->biggest_reward();
                                    $totaltickets = $ticket->count_tickets_current_competition();
                                ?>
                                    <tr class="even pointer">
                                        <td class="a-center ">
                                            <input type="checkbox" class="flat" name="table_records">
                                        </td>
                                        <td class="a-center"><?= $item['Title']?></td>
                                        <td style="text-align: center;"><?= date("Y-d-m H:i:s",$item['Starts_At'])?></td>
                                        <td style="text-align: center;"><?= date("Y-d-m H:i:s",$item['Ends_At'])?></td>
                                        <td style="text-align: center;"><?php if ($item['User_Limitation'] == 0){echo "ندارد";}else{echo $item['User_Limitation'];}?></td>
                                        <td style="text-align: center;"><?= $item['Winners_Num']?></td>
                                        <td style="text-align: center;"><?= $biggest?> تومان </td>
                                        <td style="text-align: center;"><?= $item['Tickets_price']?> تومان </td>
                                        <td style="text-align: center;"><?= $totaltickets?></td>
                                        <td cstyle="text-align: center;"><?= $item['Payment_Methods'] ?></td>
                                        <td style="text-align: center;"><?= $item['Started_by']?></td>
                                        <td style="text-align: center;">
                                            <?php if ($item['Active_Status'] == 1){echo "<p style='color: #3ec415;'>فعال</p>";}else{echo "<p style='color: red;'>غیرفعال</p>";}?>
                                        </td>
                                        <td class="a-right a-right " style="direction: rtl!important;text-align: center;"><?=$item['Result']?></td>
                                        <td class=" last">
                                            <button onclick="Conf(this.value)" class="btn" style="border-radius:100px;background: #3ec415;color: white;" <?php if ($item['Active_Status'] == 0)echo "disabled";?> value="<?=$item['Competition_Id']?>">لغو</button>
                                            <div>
                                                <a href="profile?parts=competition&Competition_Actions=Delete&competition_id=<?= $item['Competition_Id']?>" style="display: none;">کنسل</a>
                                            </div>
                                        </td>
                                        <td class=" last"><a href="profile?parts=competition&Competition_Actions=Edit&competition_id=<?= $item['Competition_Id']?>" class="btn btn-primary" style="border-radius:100px;">تغییر</a>
                                        <td class=" last"><a href="profile?parts=competition&Competition_Actions=DeleteComp&competition_id=<?= $item['Competition_Id']?>" class="btn btn-danger" style="border-radius:100px;" onclick="clickAndDisable(this)">حذف</a>
                                        </td>
                                    </tr>
                                <?php }?>
                                <script charset="utf-8">
                                    function Conf(link) {
                                        var txt = "profile?parts=competition&Competition_Actions=Delete&competition_id=" + link;
                                        console.log(txt);
                                        var r = confirm("آیا مطمئن هستید؟");
                                        if (r == true) {
                                            window.location = txt;
                                        } else {
                                            return false;
                                        }
                                    }
                                </script>
                                </tbody>
                            </table>
                        </div>


                    </div>
                </div>
            </div>
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
                                    <th>نام مسابقه</th>
                                    <th>زمان باقی مانده</th>
                                    <th>قیمت تیکت</th>
                                    <th>نحوه های پرداخت</th>
                                    <th>تعداد تیکت ها</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($started_list as $list_keys => $list_values){
                                    $ticket->set_competition_id($list_values['Competition_Id']);
                                    $Bought_tickets = count($ticket->get_tickets_data_of_competition());
                                    ?>
                                <tr>
                                    <th><?=$list_values['Title']?></th>
                                    <td id = "<?=$list_values['id']?>">
                                        <?=date("M d, Y H:i:s",$list_values['Ends_At'])?>
                                    </td>
                                    <td><?=$list_values['Tickets_price']?></td>
                                    <td><?=$list_values['Payment_Methods']?></td>
                                    <td><?=$Bought_tickets?></td>
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
</div>
<?php
$panel = new \Controller\panel();
$data = $panel->start();
$support_messages = $data['support_messages'];
?>
<div class="right_col" role="main">
    <div class="">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>درخواست های پشتیبانی</h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <table id="datatable-buttons" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th style="text-align: center;">#</th>
                                <th style="text-align: center;">وضعیت</th>
                                <th style="text-align: center;">فرستنده</th>
                                <th style="text-align: center;">موضوع</th>
                                <th style="text-align: center;">تاریخ</th>
                                <th style="text-align: center;">بررسی</th>
                                <th style="text-align: center;">حذف</th
                            </tr>
                            </thead>


                            <tbody>
                            <?php
                            $row_num = 1;
                            foreach ($support_messages as $mesaage){?>
                                <tr>
                                    <td style="text-align: center;"><?=$row_num?></td>
                                    <td style="text-align: center;height:100px;"><?php if ($mesaage['Read_Status'] == 0 ){echo "خوانده نشده";}else{echo "<img src='/panel/src/img/dcheck.png' style='height:50px;'>";}?></td>
                                    <td style="text-align: center;"><a href="/profile?parts=users_info&email=<?=$mesaage['Email']?>" title="مشخصات"><?=$mesaage['Email']?></a></td>
                                    <td style="text-align: center;"><?=$mesaage['Subject']?></td>
                                    <td style="text-align: center;"><?=date("Y-m-d H:i:s",$mesaage['Sent_At'])?></td>
                                    <td style="text-align: center;"><a href="/profile/support_messages/view?msgid=<?=$mesaage['Message_id']?>" class="btn btn-success">بررسی</a></td>
                                    <td style="text-align: center;"><a href="/profile/support_messages/view?msgid=<?=$mesaage['Message_id']?>&delete" class="btn btn-danger">حذف</a></td>
                                </tr>
                            <?php  $row_num++;}?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

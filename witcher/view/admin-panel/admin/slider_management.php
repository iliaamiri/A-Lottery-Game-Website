<?php
$panel = new \Controller\panel();
$datas = $panel->start();
$sliders = $datas['Sliders'];
?>
<div class="right_col" role="main">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>مدیریت<small>اسلایدر </small></h2>
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
                <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th>ردیف</th>
                        <th>عنوان</th>
                        <th>توضیح</th>
                        <th>اسلایدر</th>
                        <th>آیکون</th>
                        <th>وضعیت</th>
                        <th>لینک بعد کلیک</th>
                        <th>وضعیت دکمه</th>
                        <th>نوشته دکمه</th>
                        <th>رنگ دکمه</th>
                        <th>تاریخ نمایش</th>
                        <th>نمایش توسط</th>
                        <th>آخرین ویرایشگر</th>
                        <th>آخرین ویرایش</th>
                        <th>ویرایش</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $rowNum = 1;
                    foreach ($sliders as $slider_value){?>
                        <tr>
                            <td><?=$rowNum?></td>
                            <td><?=$slider_value['Header_Text']?></td>
                            <td><?=$slider_value['Content_Text']?></td>
                            <td>
                                <img src="<?=$slider_value['Big_Image']?>" style="height: 100px;">
                            </td>
                            <td>
                                <img src="<?=$slider_value['Icon_Image']?>" style="height: 100px;">
                            </td>
                            <td><?php if ($slider_value['Active_Status'] == 1){echo "فعال";}else{echo "غیرفعال";}?></td>
                            <td><?=$slider_value['Href_Url']?></td>
                            <td><?php if ($slider_value['Button_Status'] == 1){echo "فعال";}else{echo "غیرفعال";}?></td>
                            <td><?=$slider_value['Button_Text']?></td>
                            <td><?=$slider_value['Button_Color']?></td>
                            <td><?=date("Y/m/d H:i:s",$slider_value['Published_At'])?></td>
                            <td><?=$slider_value['Published_By']?></td>
                            <td><?=$slider_value['Last_Edit_By']?></td>
                            <td><?=date("Y/m/d H:i:s",$slider_value['Last_Edit_At'])?></td>
                            <td>
                                <a href="/profile?parts=slider_info&id=<?=$slider_value['id']?>" class="btn btn-primary" style="-webkit-border-radius: 100px;-moz-border-radius: 100px;border-radius: 100px;">بیشتر</a>
                            </td>
                        </tr>
                    <?php $rowNum++;}?>
                    </tbody>
                </table>


            </div>
        </div>
    </div>
</div>

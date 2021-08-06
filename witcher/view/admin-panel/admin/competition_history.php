<?php
$panel = new \Controller\panel();
$comp = new \Model\competition();
$winner = new \Model\winner();
$competiton_data = $panel->start()['Competitions_history_user'];
?>
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>تاریخچه ها</h3>
            </div>

            <div class="title_right">
                <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="جست و جو برای">
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
            <table id="datatable-buttons" class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th style="text-align: center;font-size: 20px;">نام مسابقه</th>
                    <th style="text-align: center;font-size: 20px;">وضعیت</th>
                    <th style="text-align: center;font-size: 20px;">زمان شروع</th>
                    <th style="text-align: center;font-size: 20px;">زمان پایان</th>
                    <th style="text-align: center;font-size: 20px;">  آیکون</th>
                    <th style="text-align: center;font-size: 20px;">برنده</th>
                    <th style="text-align: center;font-size: 20px;">جایزه نفر اول</th>
                </tr>
                </thead>


                <tbody>
                <?php foreach ($competiton_data as $value){
                    //$value = array_merge($value,$comp->getFrom_Competition_attributes_by($value['Competition_Id'])[0]);
                    $winner->set_c_id($value['Competition_Id']);
                    $firstplace = $winner->get_winner_users()[0];
                    $firstreward = $winner->biggest_reward();
                    ?>
                <tr>
                    <td style="text-align: center;"><?=$value['Title']?></td>
                    <td style="text-align: center;font-size: 17px;"><?=$value['Result']?></td>
                    <td style="text-align: center;"> <?=date("Y-d-m H:i:s",$value['Starts_At'])?></td>
                    <td style="text-align: center;"> <?=date("Y-d-m H:i:s",$value['Ends_At'])?></td>
                    <td><img src="<?=$value['Image_src']?>" alt="<?=$value['Image_src']?>" style="height: 50px;display: block;margin: 0 auto;"></td>
                    <td style="text-align: center;"><?php if ($firstplace != null){echo $firstplace;}else{echo "برنده اعلام نشده است";}?></td>
                    <td style="text-align: center;"><?=$firstreward?>   TOMAN</td>
                    <script>
                        var id = document.getElementById(<?=$value['id']?>).getAttribute('id');
                        CountDown(id);
                    </script>
                </tr>
                <?php }?>
                </tbody>
            </table>
        </div>
    </div>
</div>
        </div>
    </div></div>
<?php
$panel = new \Controller\panel();
$comp = new \Model\competition();
$winner = new \Model\winner();
$owned_tickets = $panel->start()['Owned_tickets'];
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
                                <th style="text-align: center;font-size: 20px;">وضعیت</th>
                                <th style="text-align: center;font-size: 20px;">نام مسابقه</th>
                                <th style="text-align: center;font-size: 20px;">تاریخ ساخت</th>
                                <th style="text-align: center;font-size: 20px;">  ارزش</th>
                            </tr>
                            </thead>


                            <tbody>
                            <?php foreach ($owned_tickets as $value){
                                //$value = array_merge($value,$comp->getFrom_Competition_attributes_by($value['Competition_Id'])[0]);
                                $ticketprice = $comp->getFrom_Competition_attributes_by($value['Competition_Id'])[0]['Tickets_price'];
                                $compp_info = $comp->getFrom_Competition_tbl_by($value['Competition_Id']);
                                ?>
                                <tr>
                                    <td style="text-align: center;font-size: 17px;"><?php if ($value['Live_Status'] == 1){echo "فعال";}else{echo "غیرفعال";}?></td>
                                    <td style="text-align: center;font-size: 17px;"><?=$compp_info['Title']?></td>
                                    <td style="text-align: center;"> <?=date("Y-d-m H:i:s",$value['Created_At'])?></td>
                                    <td style="text-align: center;"><?=$ticketprice?>   TOMAN</td>
                                </tr>
                            <?php }?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div></div>
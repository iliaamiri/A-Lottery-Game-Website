<?php $controller = new \Controller\panel();
$infos = new \Config\server();
$wallet = new \Model\wallet();
$comp = new \Model\competition();
$user_info = $controller->start();
$comps_inLimit = $user_info['Comps_in_limit'];
$infos = $infos->INFO;
$user_info['Permission'] = "Administrator";
$browsers_percentages = $user_info['Browsers_percentages'];
$support_ticket_num = $user_info['Support_message_ticket_num'];
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="<?=HTTP_SERVER?>/panel/src/img/backend.png" type="image/gif" sizes="16x16">
    <title>پنل ادمین</title>

    <!-- Bootstrap -->
    <link href="<?=HTTP_SERVER?>/panel/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="<?=HTTP_SERVER?>/panel/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="<?=HTTP_SERVER?>/panel/vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- iCheck -->
    <link href="<?=HTTP_SERVER?>/panel/vendors/iCheck/skins/flat/green.css" rel="stylesheet">
	
    <!-- bootstrap-progressbar -->
    <link href="<?=HTTP_SERVER?>/panel/vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">
    <!-- JQVMap -->
    <link href="<?=HTTP_SERVER?>/panel/vendors/jqvmap/dist/jqvmap.min.css" rel="stylesheet"/>
    <!-- bootstrap-daterangepicker -->
    <link href="<?=HTTP_SERVER?>/panel/vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
      <!-- bootstrap-wysiwyg -->
      <link href="<?=HTTP_SERVER?>/panel/vendors/google-code-prettify/bin/prettify.min.css" rel="stylesheet">
      <!-- Select2 -->
      <link href="<?=HTTP_SERVER?>/panel/vendors/select2/dist/css/select2.min.css" rel="stylesheet">
      <!-- Switchery -->
      <link href="<?=HTTP_SERVER?>/panel/vendors/switchery/dist/switchery.min.css" rel="stylesheet">
      <!-- starrr -->
      <link href="<?=HTTP_SERVER?>/panel/vendors/starrr/dist/starrr.css" rel="stylesheet">
    <!-- Custom Theme Style -->
    <link href="<?=HTTP_SERVER?>/panel/build/css/custom.min.css" rel="stylesheet">
      <link href="<?=HTTP_SERVER?>/panel/vendors/dropzone/dist/min/dropzone.min.css" rel="stylesheet">
      <!-- Datatables -->
      <link href="<?=HTTP_SERVER?>/panel/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
      <link href="<?=HTTP_SERVER?>/panel/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
      <link href="<?=HTTP_SERVER?>/panel/vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
      <link href="<?=HTTP_SERVER?>/panel/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
      <link href="<?=HTTP_SERVER?>/panel/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">
      <!-- FONTS CDN
      <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Lato">
      <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Arvo">

      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
      -->
      <script charset="utf-8">
          function clickAndDisable(link) {
              // disable subsequent clicks
              link.onclick = function(event) {
                  event.preventDefault();
              }
          }
          function CountDown(link){
              var inner = document.getElementById(link);
// Set the date we're counting down to
              var countDownDate = new Date(inner.innerHTML).getTime();
                console.log(countDownDate);
                console.log(inner.innerHTML.trim());
// Update the count down every 1 second
              var x = setInterval(function() {

                  // Get todays date and time
                  var now = new Date().getTime();

                  // Find the distance between now an the count down date
                  var distance = countDownDate - now;

                  // Time calculations for days, hours, minutes and seconds
                  var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                  var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                  var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                  var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                  // Output the result in an element with id="demo"
                  document.getElementById(link).innerHTML = days + "d " + hours + "h "
                      + minutes + "m " + seconds + "s ";

                  // If the count down is over, write some text
                  if (distance < 0) {
                      clearInterval(x);
                      document.getElementById(link).innerHTML = "<b style='color: red;'>تمام شد</b>";
                  }
              }, 1000);
          }
      </script>
      <style>
          @font-face {
              font-family: 'Yekan';
              src: url('../../fonts/Yekan.eot?#') format('eot'),
              url('../../fonts/Yekan.woff') format('woff'),
              url('../../fonts/Yekan.ttf') format('truetype');
              font-style:normal;
              font-weight:normal;
          }
          @font-face {
              font-family: 'Nazanin';
              src: url('../../fonts/Nazanin.eot?#') format('eot'),
              url('../../fonts/Nazanin.woff') format('woff'),
              url('../../fonts/Nazanin.ttf') format('truetype');
              font-style:normal;
              font-weight:normal;
          }
          *{
              font-family:'Yekan','B Yekan+';
              direction: ltr;
          }
          .alert {direction: rtl!important;font-size:20px;padding: 10px!important;background-color: #f44336;color: white!important;}.closebtn {margin-left: 15px!important;color: white!important;font-weight: bold!important;float: right!important;font-size: 22px!important;line-height: 20px!important;cursor: pointer!important;transition: 0.3s;}.closebtn:hover {color: black;}.alert.success {background-color: #4CAF50;}
          .alert.info {background-color: #2196F3;}
          .alert.warning {background-color: #ff9800;text-align: right;}
      </style>
      <!-- Jquery cdn
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
      -->
      <script src="<?=HTTP_SERVER?>/panel/vendors/jquery/jqurry3.3.1.js"></script>
  </head>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
              <a href="http://<?= $infos['Domain'];?>" class="site_title"><img src="<?=HTTP_SERVER?>/img/logo.png" style="height: 55px;width: 100%;"></a>
            </div>

            <div class="clearfix"></div>

            <!-- menu profile quick info -->
            <div class="profile clearfix" style="font-family: 'Arvo';">
              <div class="profile_pic">
                <img src="<?php
                if (strlen($user_info['Profile_Image']) > 0){
                    echo $user_info['Profile_Image'];
                }else{
                    echo HTTP_SERVER . "/panel/src/img/profile_image.png";
                }
                ?>" alt="..." class="img-circle profile_img">
              </div>
              <div class="profile_info">
                  <h2><b style="font-size: 40px;"><?= $user_info['Username']?></b></h2>
                  <span>خوش آمدید</span>
                  <h2 style="color: palegreen;font-size: 15px;"><B>"</B><?= $user_info['Permission']?><B>"</B></h2>
              </div>
            </div>
            <!-- /menu profile quick info -->

            <br />

            <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu" style="font-family: 'Lato';">
              <div class="menu_section">
                <h3 style="font-size: 30px;">عمومی</h3>
                <ul class="nav side-menu">
                  <li><a style=""><i class="fa fa-home"></i> خانه <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="/profile">داشبورد</a></li>
                      <li><a href="/profile/editProfile">اطلاعات شخصی</a></li>
                      <li><a href="/profile?parts=competition">مسابقات</a></li>
                    </ul>
                  </li>
                  <li><a style=""><i class="fa fa-pie-chart"></i>مدیریت<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="/profile?parts=user_management">کاربران</a></li>
                      <li><a href="/profile?parts=factor_management">فاکتورها</a></li>
                      <!--<li><a href="/profile?parts=news_management"><span class="label label-success pull-right" style="font-size: 15px;">بزودی</span>اخبار</a></li> todo : do this-->
                      <li><a href="/profile?parts=slider_management">اسلایدر</a></li>
                      <!--<li><a href="/profile?parts=menu_management">منو<span class="label label-success pull-right" style="font-size: 15px;">بزودی</span></a></li>todo : do this-->
                      <li><a href="/profile?parts=trans_management">تراکنش ها</a></li>
                      <li><a href="/profile?parts=wallet_management">کیف پول ها</a></li>
                    </ul>
                  </li>
                    <li><a href="/profile/support_messages"><i class="fa fa-support"></i>پشتیبانی<?php if ($support_ticket_num > 0){?><span class="badge bg-green pull-right"><?=$support_ticket_num?></span><?php }?></a>
                    </li>
                    <li><a href="/profile/withdrawals"><i class="fa fa-money"></i>درخواست های برداشت<span class="badge bg-green pull-right"></span></a>
                    </li>
                    <!--
                    <li><a><i class="fa fa-envelope-o"></i>پیام های داخلی<span class="badge bg-green pull-right"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="/profile/mail/new">جدید<i class="fa fa-mail-forward pull-right"></i></a></li>
                        </ul>
                    </li>
                    todo : kamel kardane in ghesmat
                    -->
                    <!--
                  <li><a><i class="fa fa-desktop"></i> تم وبسایت <span class="fa fa-chevron-down"></span><span class="label label-success pull-right" style="font-size: 15px;">بزودی</span></a>
                    <ul class="nav child_menu">
                      <li><a href="<?=HTTP_SERVER?>">صفحه اصلی سایت</a></li>
                    </ul>
                  </li>
                  -->
                </ul>
              </div>
              <div class="menu_section">
                <h3>تنظیمات</h3>
                <ul class="nav side-menu">
                  <li><a><i class="fa fa-cogs"></i>تنظیمات سرور<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="/profile/setting/server-about">مشخصات</a></li>
                    </ul>
                  </li>
                  <li><a><i class="fa fa-gears"></i> تنظیمات پرداخت <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="/profile/setting/payments">روش های پرداخت</a></li>
                    </ul>
                  </li>
                    <!--
                  <li><a href="/profile?parts=landingpages"><i class="fa fa-laptop"></i> صفحه اصلی <span class="label label-success pull-right" style="font-size: 15px;">بزودی</span></a></li>
                    -->
                    <li><a href="<?=HTTP_SERVER?>"><i class="fa fa-laptop"></i>صفحه اصلی</a></li>
                </ul>
              </div>

            </div>
            <!-- /sidebar menu -->

            <!-- /menu footer buttons -->
            <div class="sidebar-footer hidden-small">
              <a data-toggle="tooltip" data-placement="top" title="تنظیمات سایت" href="/profile/setting/server-about">
                <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
              </a>
                <!--
              <a data-toggle="tooltip" data-placement="top" title="خلاصه">
                <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="Lock">
                <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
              </a>-->
              <a data-toggle="tooltip" data-placement="top" title="خروج" href="/logout" onclick="clickAndDisable(this)">
                <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
              </a>
            </div>
            <!-- /menu footer buttons -->
          </div>
        </div>

        <!-- top navigation -->
        <div class="top_nav">
          <div class="nav_menu">
            <nav>
              <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
              </div>

              <ul class="nav navbar-nav navbar-right">
                <li class="">
                  <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <img src="<?php
                    if (strlen($user_info['Profile_Image']) > 0){
                        echo $user_info['Profile_Image'];
                    }else{
                        echo HTTP_SERVER . "/panel/src/img/profile_image.png";
                    }
                    ?>" alt=""><?= $user_info['Username']?>
                    <span class=" fa fa-angle-down"></span>
                  </a>
                  <ul class="dropdown-menu dropdown-usermenu pull-right">
                    <li><a href="/profile/editProfile"> حساب کاربری</a></li>
                    <li>
                      <a href="/profile/setting/server-about">
                        <span class="badge bg-red pull-right"><i class="fa fa-gears"></i></span>
                        <span>تنظیمات</span>
                      </a>
                    </li>
                      <li><a data-target=".bs-example-modal-lg"  data-toggle="modal">راهنما</a></li>
                    <li><a href="/logout"><i class="fa fa-sign-out pull-right" onclick="clickAndDisable(this)"></i> خروج</a></li>
                  </ul>
                </li>

                <li role="presentation" class="dropdown">
                  <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
                    <i class="fa fa-envelope-o"></i>
                    <span class="badge bg-green"><?=$support_ticket_num?></span>
                  </a>
                    <!--
                  <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">
                    <li>
                      <a>
                        <span class="image"><img src="images/img.jpg" alt="Profile Image" /></span>
                        <span>
                          <span>John Smith</span>
                          <span class="time">3 mins ago</span>
                        </span>
                        <span class="message">
                          Film festivals used to be do-or-die moments for movie makers. They were where...
                        </span>
                      </a>
                    </li>
                    <li>
                      <a>
                        <span class="image"><img src="images/img.jpg" alt="Profile Image" /></span>
                        <span>
                          <span>John Smith</span>
                          <span class="time">3 mins ago</span>
                        </span>
                        <span class="message">
                          Film festivals used to be do-or-die moments for movie makers. They were where...
                        </span>
                      </a>
                    </li>
                    <li>
                      <a>
                        <span class="image"><img src="images/img.jpg" alt="Profile Image" /></span>
                        <span>
                          <span>John Smith</span>
                          <span class="time">3 mins ago</span>
                        </span>
                        <span class="message">
                          Film festivals used to be do-or-die moments for movie makers. They were where...
                        </span>
                      </a>
                    </li>
                    <li>
                      <a>
                        <span class="image"><img src="images/img.jpg" alt="Profile Image" /></span>
                        <span>
                          <span>John Smith</span>
                          <span class="time">3 mins ago</span>
                        </span>
                        <span class="message">
                          Film festivals used to be do-or-die moments for movie makers. They were where...
                        </span>
                      </a>
                    </li>
                    <li>
                      <div class="text-center">
                        <a>
                          <strong>همه پیام ها</strong>
                          <i class="fa fa-angle-right"></i>
                        </a>
                      </div>
                    </li>
                  </ul>
                  -->
                </li>
                  <li role="presentation" class="dropdown">
                      <a href="/profile/mail/inbox" style="background: #1ABB9C;color: white!important;font-size: 15px;">صندوق ورودی</a>
                  </li>

              </ul>
            </nav>
          </div>
            <?php \Model\message::msg_box_session_show();?>
        </div>
        <!-- /top navigation -->

        <!-- page content -->
          <?php $controller->PartIncluder();?>

        <!-- /page content -->
        <!-- footer content -->
        <footer>
          <div class="pull-right">
          <p>Witcher قدزت گرفته از</p>
          </div>
          <div class="clearfix"></div>
          
        </footer>
        <!-- /footer content -->
      </div>
    </div>
    <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel">راهنمای استفاده از پنل</h4>
                </div>
                <div class="modal-body">
                    <h4>Text in a modal</h4>
                    <p>Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor.</p>
                    <p>Aenean lacinia bibendum nulla sed consectetur. Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Donec sed odio dui. Donec ullamcorper nulla non metus auctor fringilla.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">باشه</button>
                    <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
                </div>

            </div>
        </div>
    </div>
    <!-- jQuery -->
    <script src="<?=HTTP_SERVER?>/panel/vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="<?=HTTP_SERVER?>/panel/vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="<?=HTTP_SERVER?>/panel/vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="<?=HTTP_SERVER?>/panel/vendors/nprogress/nprogress.js"></script>
    <!-- Chart.js -->
    <script src="<?=HTTP_SERVER?>/panel/vendors/Chart.js/dist/Chart.min.js"></script>
    <!-- gauge.js -->
    <script src="<?=HTTP_SERVER?>/panel/vendors/gauge.js/dist/gauge.min.js"></script>
    <!-- bootstrap-progressbar -->
    <script src="<?=HTTP_SERVER?>/panel/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
    <!-- bootstrap-wysiwyg -->
    <script src="<?=HTTP_SERVER?>/panel/vendors/bootstrap-wysiwyg/js/bootstrap-wysiwyg.min.js"></script>
    <script src="<?=HTTP_SERVER?>/panel/vendors/jquery.hotkeys/jquery.hotkeys.js"></script>
    <script src="<?=HTTP_SERVER?>/panel/vendors/google-code-prettify/src/prettify.js"></script>
    <!-- iCheck -->
    <script src="<?=HTTP_SERVER?>/panel/vendors/iCheck/icheck.min.js"></script>
    <!-- Skycons -->
    <script src="<?=HTTP_SERVER?>/panel/vendors/skycons/skycons.js"></script>
    <!-- Flot -->
    <script src="<?=HTTP_SERVER?>/panel/vendors/Flot/jquery.flot.js"></script>
    <script src="<?=HTTP_SERVER?>/panel/vendors/Flot/jquery.flot.pie.js"></script>
    <script src="<?=HTTP_SERVER?>/panel/vendors/Flot/jquery.flot.time.js"></script>
    <script src="<?=HTTP_SERVER?>/panel/vendors/Flot/jquery.flot.stack.js"></script>
    <script src="<?=HTTP_SERVER?>/panel/vendors/Flot/jquery.flot.resize.js"></script>
    <!-- Flot plugins -->
    <script src="<?=HTTP_SERVER?>/panel/vendors/flot.orderbars/js/jquery.flot.orderBars.js"></script>
    <script src="<?=HTTP_SERVER?>/panel/vendors/flot-spline/js/jquery.flot.spline.min.js"></script>
    <script src="<?=HTTP_SERVER?>/panel/vendors/flot.curvedlines/curvedLines.js"></script>
    <!-- DateJS -->
    <script src="<?=HTTP_SERVER?>/panel/vendors/DateJS/build/date.js"></script>
    <!-- JQVMap -->
    <script src="<?=HTTP_SERVER?>/panel/vendors/jqvmap/dist/jquery.vmap.js"></script>
    <script src="<?=HTTP_SERVER?>/panel/vendors/jqvmap/dist/maps/jquery.vmap.world.js"></script>
    <script src="<?=HTTP_SERVER?>/panel/vendors/jqvmap/examples/js/jquery.vmap.sampledata.js"></script>
    <!-- bootstrap-daterangepicker -->
    <script src="<?=HTTP_SERVER?>/panel/vendors/moment/min/moment.min.js"></script>
    <script src="<?=HTTP_SERVER?>/panel/vendors/bootstrap-daterangepicker/daterangepicker.js"></script>
    <!-- jQuery Knob -->
    <script src="<?=HTTP_SERVER?>/panel/vendors/jquery-knob/dist/jquery.knob.min.js"></script>
    <!-- Custom Theme Scripts -->
    <script src="<?=HTTP_SERVER?>/panel/build/js/custom.js"></script>
    <script>
        function init_chart_doughnut(){if("undefined"!=typeof Chart&&(console.log("init_chart_doughnut"),$(".canvasDoughnut").length)){
            var a={type:"doughnut",tooltipFillColor:"rgba(51, 51, 51, 0.55)",
                data:{labels:["MicrosoftEdge","Firefox","Opera","Safari","Chrome"],
                    datasets:[{data:[<?=$browsers_percentages['Microsoft']?>,<?=$browsers_percentages['Firefox']?>,<?=$browsers_percentages['']?>,<?=$browsers_percentages['Safari']?>,<?=$browsers_percentages['Google Chrome']?>],
                        backgroundColor:["#BDC3C7","#9B59B6","#E74C3C","#26B99A","#3498DB"],
                        hoverBackgroundColor:["#CFD4D8","#B370CF","#E95E4F","#36CAAB","#49A9EA"]}]},options:{legend:!1,responsive:!1}};$(".canvasDoughnut").each(function(){var b=$(this);new Chart(b,a)})}}
        function init_flot_chart(){

            if( typeof ($.plot) === 'undefined'){ return; }

            console.log('init_flot_chart');



            var arr_data1 = [
                <?php foreach ($comps_inLimit as $comp_values){
                    $starts_at = $comp->getFrom_Competition_tbl_by($comp_values['Competition_Id'])['Starts_At'];
                    ?>
                [gd(<?=date("Y",$starts_at)?>, <?=date("m",$starts_at)?>, <?=date("d",$starts_at)?>), <?=$wallet->CalculateWebsiteProfitByCompetition($comp_values['Competition_Id'])['Profit']?>],
                <?php }?>
            ];

            var arr_data2 = [
                [gd(2012, 1, 1), 82],
                [gd(2012, 1, 2), 23],
                [gd(2012, 1, 3), 66],
                [gd(2012, 1, 4), 9],
                [gd(2012, 1, 5), 119],
                [gd(2012, 1, 6), 6],
                [gd(2012, 1, 7), 9]
            ];

            var arr_data3 = [
                [0, 1],
                [1, 9],
                [2, 6],
                [3, 10],
                [4, 5],
                [5, 17],
                [6, 6],
                [7, 10],
                [8, 7],
                [9, 11],
                [10, 35],
                [11, 9],
                [12, 12],
                [13, 5],
                [14, 3],
                [15, 4],
                [16, 9]
            ];

            var chart_plot_02_data = [];

            var chart_plot_03_data = [
                [0, 1],
                [1, 9],
                [2, 6],
                [3, 10],
                [4, 5],
                [5, 17],
                [6, 6],
                [7, 10],
                [8, 7],
                [9, 11],
                [10, 35],
                [11, 9],
                [12, 12],
                [13, 5],
                [14, 3],
                [15, 4],
                [16, 9]
            ];


            for (var i = 0; i < 30; i++) {
                chart_plot_02_data.push([new Date(Date.today().add(i).days()).getTime(), randNum() + i + i + 10]);
            }


            var chart_plot_01_settings = {
                series: {
                    lines: {
                        show: true,
                        fill: true
                    },
                    splines: {
                        show: true,
                        tension: 0.4,
                        lineWidth: 1,
                        fill: 0.4
                    },
                    points: {
                        radius: 0,
                        show: true
                    },
                    shadowSize: 2
                },
                grid: {
                    verticalLines: true,
                    hoverable: true,
                    clickable: true,
                    tickColor: "#d5d5d5",
                    borderWidth: 1,
                    color: '#fff'
                },
                colors: ["rgba(38, 185, 154, 0.38)", "rgba(3, 88, 106, 0.38)"],
                xaxis: {
                    tickColor: "rgba(51, 51, 51, 0.06)",
                    mode: "time",
                    tickSize: [1, "day"],
                    //tickLength: 10,
                    axisLabel: "Date",
                    axisLabelUseCanvas: true,
                    axisLabelFontSizePixels: 12,
                    axisLabelFontFamily: 'Verdana, Arial',
                    axisLabelPadding: 10
                },
                yaxis: {
                    ticks: 8,
                    tickColor: "rgba(51, 51, 51, 0.06)",
                },
                tooltip: false
            }

            var chart_plot_02_settings = {
                grid: {
                    show: true,
                    aboveData: true,
                    color: "#3f3f3f",
                    labelMargin: 10,
                    axisMargin: 0,
                    borderWidth: 0,
                    borderColor: null,
                    minBorderMargin: 5,
                    clickable: true,
                    hoverable: true,
                    autoHighlight: true,
                    mouseActiveRadius: 100
                },
                series: {
                    lines: {
                        show: true,
                        fill: true,
                        lineWidth: 2,
                        steps: false
                    },
                    points: {
                        show: true,
                        radius: 4.5,
                        symbol: "circle",
                        lineWidth: 3.0
                    }
                },
                legend: {
                    position: "ne",
                    margin: [0, -25],
                    noColumns: 0,
                    labelBoxBorderColor: null,
                    labelFormatter: function(label, series) {
                        return label + '&nbsp;&nbsp;';
                    },
                    width: 40,
                    height: 1
                },
                colors: ['#96CA59', '#3F97EB', '#72c380', '#6f7a8a', '#f7cb38', '#5a8022', '#2c7282'],
                shadowSize: 0,
                tooltip: true,
                tooltipOpts: {
                    content: "%s: %y.0",
                    xDateFormat: "%d/%m",
                    shifts: {
                        x: -30,
                        y: -50
                    },
                    defaultTheme: false
                },
                yaxis: {
                    min: 0
                },
                xaxis: {
                    mode: "time",
                    minTickSize: [1, "day"],
                    timeformat: "%d/%m/%y",
                    min: chart_plot_02_data[0][0],
                    max: chart_plot_02_data[20][0]
                }
            };

            var chart_plot_03_settings = {
                series: {
                    curvedLines: {
                        apply: true,
                        active: true,
                        monotonicFit: true
                    }
                },
                colors: ["#26B99A"],
                grid: {
                    borderWidth: {
                        top: 0,
                        right: 0,
                        bottom: 1,
                        left: 1
                    },
                    borderColor: {
                        bottom: "#7F8790",
                        left: "#7F8790"
                    }
                }
            };


            if ($("#chart_plot_01").length){
                console.log('Plot1');

                $.plot( $("#chart_plot_01"), [ arr_data1 ],  chart_plot_01_settings );
            }


            if ($("#chart_plot_02").length){
                console.log('Plot2');

                $.plot( $("#chart_plot_02"),
                    [{
                        label: "Email Sent",
                        data: chart_plot_02_data,
                        lines: {
                            fillColor: "rgba(150, 202, 89, 0.12)"
                        },
                        points: {
                            fillColor: "#fff" }
                    }], chart_plot_02_settings);

            }

            if ($("#chart_plot_03").length){
                console.log('Plot3');


                $.plot($("#chart_plot_03"), [{
                    label: "Registrations",
                    data: chart_plot_03_data,
                    lines: {
                        fillColor: "rgba(150, 202, 89, 0.12)"
                    },
                    points: {
                        fillColor: "#fff"
                    }
                }], chart_plot_03_settings);

            };

        }
    </script>
 <!-- Dropzone.js -->
    <script src="<?=HTTP_SERVER?>/panel/vendors/dropzone/dist/min/dropzone.min.js"></script>
    <script src="<?=HTTP_SERVER?>/panel/vendors/jQuery-Smart-Wizard/js/jquery.smartWizard.js"></script>
    <!-- starrr -->
    <script src="<?=HTTP_SERVER?>/panel/vendors/starrr/dist/starrr.js"></script>
    <!-- Select2 -->
    <script src="<?=HTTP_SERVER?>/panel/vendors/select2/dist/js/select2.full.min.js"></script>
    <!-- jQuery Tags Input -->
    <script src="<?=HTTP_SERVER?>/panel/vendors/jquery.tagsinput/src/jquery.tagsinput.js"></script>
    <script src="<?=HTTP_SERVER?>/panel/vendors/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="<?=HTTP_SERVER?>/panel/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <script src="<?=HTTP_SERVER?>/panel/vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="<?=HTTP_SERVER?>/panel/vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
    <script src="<?=HTTP_SERVER?>/panel/vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
    <script src="<?=HTTP_SERVER?>/panel/vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="<?=HTTP_SERVER?>/panel/vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="<?=HTTP_SERVER?>/panel/vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
    <script src="<?=HTTP_SERVER?>/panel/vendors/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
    <script src="<?=HTTP_SERVER?>/panel/vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="<?=HTTP_SERVER?>/panel/vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
    <script src="<?=HTTP_SERVER?>/panel/vendors/datatables.net-scroller/js/dataTables.scroller.min.js"></script>
    <script src="<?=HTTP_SERVER?>/panel/vendors/jszip/dist/jszip.min.js"></script>
    <script src="<?=HTTP_SERVER?>/panel/vendors/pdfmake/build/pdfmake.min.js"></script>
    <script src="<?=HTTP_SERVER?>/panel/vendors/pdfmake/build/vfs_fonts.js"></script>
    <!-- Switchery -->
    <script src="<?=HTTP_SERVER?>/panel/vendors/switchery/dist/switchery.min.js"></script>
    <!-- Parsley -->
    <script src="<?=HTTP_SERVER?>/panel/vendors/parsleyjs/dist/parsley.min.js"></script>
    <!-- Autosize -->
    <script src="<?=HTTP_SERVER?>/panel/vendors/autosize/dist/autosize.min.js"></script>
    <!-- jQuery autocomplete -->
    <script src="<?=HTTP_SERVER?>/panel/vendors/devbridge-autocomplete/dist/jquery.autocomplete.min.js"></script>
    <script>
        var close = document.getElementsByClassName("closebtn");
        var i;

        for (i = 0; i < close.length; i++) {
            close[i].onclick = function(){
                var div = this.parentElement;
                div.style.opacity = "0";
                setTimeout(function(){ div.style.display = "none"; }, 600);
            }
        }
    </script>
  </body>
</html>
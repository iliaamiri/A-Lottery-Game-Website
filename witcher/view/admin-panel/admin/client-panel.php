<?php $controller = new \Controller\panel();
$infos = new \Config\server();
$compM = new \Model\competition();
$infos = $infos->INFO;
$user_info = $controller->start();
$user_info['Permission'] = $user_info['Role_Name'];
$wallet = new \Model\wallet();
$wallet->Set_Email($user_info['user_info']['Email']);
$wallet_info = $user_info['wallet'];
$my_compets = $user_info['compet_which_Iwas'];
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>پنل کاربری</title>
      <link rel="icon" href="<?=HTTP_SERVER?>/panel/src/img/backend.png" type="image/gif" sizes="16x16">
    <!-- Bootstrap -->
    <link href="<?=HTTP_SERVER?>/panel/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="<?=HTTP_SERVER?>/panel/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="<?=HTTP_SERVER?>/panel/vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- bootstrap-daterangepicker -->
    <link href="<?=HTTP_SERVER?>/panel/vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="<?=HTTP_SERVER?>/panel/build/css/custom.min.css" rel="stylesheet">
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
      <script>
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
                  document.getElementById(link).innerHTML = days + "روز " + hours + "ساعت "
                      + minutes + "دقیقه " + seconds + "ثانیه ";

                  // If the count down is over, write some text
                  if (distance < 0) {
                      clearInterval(x);
                      document.getElementById(link).innerHTML = "<b style='color: red;'>تمام شد</b>";
                  }
              }, 1000);
          }
      </script>
  </head>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col menu_fixed">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
                <a href="<?= HTTP_SERVER?>" class="site_title"><img src="<?=HTTP_SERVER?>/img/logo.png" style="height: 55px;width: 100%;"></a>
            </div>

            <div class="clearfix"></div>

            <!-- menu profile quick info -->
            <div class="profile clearfix">
              <div class="profile_pic">
                <img src="<?php
                if (strlen($user_info['Profile_Image']) > 0){
                    echo $user_info['Profile_Image'];
                }else{
                    echo HTTP_SERVER . "/panel/src/img/profile_image.png";
                }
                ?>" alt="..." class="img-circle profile_img" style="height:50px;">
              </div>
              <div class="profile_info">
                  <h2><?= $user_info['Full_Name']?></h2>
                <span>خوش آمدید</span>

              </div>
            </div>
            <!-- /menu profile quick info -->

            <br />

            <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                <h3 style="font-size: 24px;">عمومی</h3>
                <ul class="nav side-menu">
                  <li><a><i class="fa fa-user"></i> حساب کاربری <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="/profile">خانه</a></li>
                      <li><a href="/profile/editProfile">تغییر مشخصات</a></li>
                      <li><a href="/profile/ticket/owned">تیکت های من</a></li>
                      <li><a href="/profile/ticket/buy">خرید تیکت</a></li>
                    </ul>
                  </li>
                  <li><a><i class="fa fa-calendar"></i> تاریخچه ها <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="/profile/history/competitions">مسابقات شرکت کرده</a></li>
                      <li><a href="/profile/history/factors">فاکتور ها</a></li>
                        <?php if ($wallet->Exists_Wallet('Email',$user_info['Email'])){?>
                      <li><a href="/profile/history/wallet">کیف پول</a></li>
                        <?php }?>
                      <li><a href="/profile/history/messages">تاریخچه پیام ها</a></li>
                    </ul>
                  </li>
                  <li><a><i class="fa fa-bank"></i> کیف پول <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="/profile/wallet">کیف پول من</a></li>
                      <li><a href="/profile/wallet/withdrawal">برداشت از کیف پول</a></li>
                      <li><a href="/profile/wallet/deposit">شارژ کیف پول</a></li>
                    </ul>
                  </li>
                    <li><a href="/profile/wallet/withdrawal/management"><i class="fa fa-money"></i>برداشت ها </a>
                    </li>
                  <li><a href="<?=HTTP_SERVER?>"><i class="fa fa-laptop"></i>صفحه اصلی </a>
                    </li>
                  </ul>
              </div>
              
              <div class="menu_section">
                <ul class="nav side-menu">
                  <li><a><i class="fa fa-support"></i> پشتیبانی  <span class="fa fa-chevron-down"></span></a>
                   <ul class="nav child_menu">
                      <!--<li><a href="/profile/support/contact">تماس با پشتیبانی</a></li>
                      <li><a href="/profile/support/factor-report">ثبت گزارش فاکتور</a></li>-->
                      <li><a href="/profile/support/new">درخواست پشتیبانی</a></li>
                       <li><a href="/profile/support/messages">لیست درخواست ها</a></li>
                    </ul>
                  </li>
                </ul>
              </div>
              

            </div>
            <!-- /sidebar menu -->

            <!-- /menu footer buttons -->
            <div class="sidebar-footer hidden-small">
                <!--
              <a data-toggle="tooltip" data-placement="top" title="Settings">
                <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="FullScreen">
                <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="Lock">
                <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
              </a>
              -->
              <a data-toggle="tooltip" data-placement="top" title="خروج" href="/logout">
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
                    ?>" style="max-height:50px!important;"><?=$user_info['Full_Name']?>
                    <span class=" fa fa-angle-down"></span>
                  </a>
                  <ul class="dropdown-menu dropdown-usermenu pull-right">
                    <li><a href="/profile"> حساب کاربری</a></li>
                    <li>
                      <a href="javascript:;">
                        <span class="badge bg-red pull-right">ناکامل</span>
                        <span>تنظیمات</span>
                      </a>
                    </li>
                    <li><a data-target=".bs-example-modal-lg"  data-toggle="modal">راهنما</a></li>
                    <li><a href="/logout"><i class="fa fa-sign-out pull-right"></i> خروج</a></li>
                  </ul>
                </li>

                <li role="presentation" class="dropdown">
                  <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
                    <i class="fa fa-envelope-o"></i>
                    <span class="badge bg-green">6</span>
                  </a><!--
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
                          <strong>See All Alerts</strong>
                          <i class="fa fa-angle-right"></i>
                        </a>
                      </div>
                    </li>
                  </ul>-->
                </li>
                  <?php if (!$wallet_info['Exist'] or !$wallet_info['Valid']){?>
                  <li>
                      <a href="/profile/wallet">ساخت کیف پول</a>
                  </li>
                  <?php }else{?>
                      <li>
                         <a style="direction: rtl!important;">موجودی (تومان) :  <?="<b style='font-size: 17px;'>".$wallet_info['Info']['Balance']."</b>"?></a>
                      </li>
                  <?php }?>
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
    <!-- Switchery -->
    <script src="<?=HTTP_SERVER?>/panel/vendors/switchery/dist/switchery.min.js"></script>
    <!-- Custom Theme Scripts -->
    <script src="<?=HTTP_SERVER?>/panel/build/js/custom.js"></script>
    <script>
        function init_morris_charts() {

            if( typeof (Morris) === 'undefined'){ return; }
            console.log('init_morris_charts');

            if ($('#graph_bar').length){

                Morris.Bar({
                    element: 'graph_bar',
                    data: [
                        {device: 'نه روز پیش', geekbench: <?=$wallet->GetDepositsByTime("-9 days")?>},
                        {device: 'هشت روز پیش', geekbench: <?=$wallet->GetDepositsByTime("-8 days")?>},
                        {device: 'هفت روز پیش', geekbench: <?=$wallet->GetDepositsByTime("-7 days")?>},
                        {device: 'شش روز پیش', geekbench: <?=$wallet->GetDepositsByTime("-6 days")?>},
                        {device: 'پنج روز پیش', geekbench: <?=$wallet->GetDepositsByTime("-5 days")?>},
                        {device: 'چهار روز پیش', geekbench: <?=$wallet->GetDepositsByTime("-4 days")?>},
                        {device: 'سه روز پیش', geekbench: <?=$wallet->GetDepositsByTime("-3 days")?>},
                        {device: 'دو روز پیش', geekbench: <?=$wallet->GetDepositsByTime("-2 days")?>},
                        {device: 'روز قبل', geekbench:  <?=$wallet->GetDepositsByTime("-1 day")?>},
                        {device: 'امروز', geekbench: <?=$wallet->GetDepositsByTime("now")?>}
                    ],
                    xkey: 'device',
                    ykeys: ['geekbench'],
                    labels: ['سپرده'],
                    barRatio: 0.4,
                    barColors: ['#26B99A', '#34495E', '#ACADAC', '#3498DB'],
                    xLabelAngle: 35,
                    hideHover: 'auto',
                    resize: true
                });

            }

            if ($('#graph_bar_group').length ){

                Morris.Bar({
                    element: 'graph_bar_group',
                    data: [
                        {"period": "<?=date("Y-m-d",strtotime("-9 days"))?>", "licensed": <?=$wallet->GetDepositsByTime("-9 days")?>, "sorned": <?=$wallet->GetWithdrawalsByTime("-9 days")?>},
                        {"period": "<?=date("Y-m-d",strtotime("-8 days"))?>", "licensed": <?=$wallet->GetDepositsByTime("-8 days")?>, "sorned": <?=$wallet->GetWithdrawalsByTime("-8 days")?>},
                        {"period": "<?=date("Y-m-d",strtotime("-7 days"))?>", "licensed": <?=$wallet->GetDepositsByTime("-7 days")?>, "sorned": <?=$wallet->GetWithdrawalsByTime("-7 days")?>},
                        {"period": "<?=date("Y-m-d",strtotime("-6 days"))?>", "licensed": <?=$wallet->GetDepositsByTime("-6 days")?>, "sorned": <?=$wallet->GetWithdrawalsByTime("-6 days")?>},
                        {"period": "<?=date("Y-m-d",strtotime("-5 days"))?>", "licensed": <?=$wallet->GetDepositsByTime("-5 days")?>, "sorned": <?=$wallet->GetWithdrawalsByTime("-5 days")?>},
                        {"period": "<?=date("Y-m-d",strtotime("-4 days"))?>", "licensed": <?=$wallet->GetDepositsByTime("-4 days")?>, "sorned": <?=$wallet->GetWithdrawalsByTime("-4 days")?>},
                        {"period": "<?=date("Y-m-d",strtotime("-3 days"))?>", "licensed": <?=$wallet->GetDepositsByTime("-3 days")?>, "sorned": <?=$wallet->GetWithdrawalsByTime("-3 days")?>},
                        {"period": "<?=date("Y-m-d",strtotime("-2 days"))?>", "licensed": <?=$wallet->GetDepositsByTime("-2 days")?>, "sorned": <?=$wallet->GetWithdrawalsByTime("-2 days")?>},
                        {"period": "<?=date("Y-m-d",strtotime("-1 day"))?>", "licensed": <?=$wallet->GetDepositsByTime("-1 day")?>, "sorned": <?=$wallet->GetWithdrawalsByTime("-1 day")?>},
                        {"period": "<?=date("Y-m-d",strtotime("now"))?>", "licensed": <?=$wallet->GetDepositsByTime("now")?>, "sorned": <?=$wallet->GetWithdrawalsByTime("now")?>}
                    ],
                    xkey: 'period',
                    barColors: ['#26B99A', '#34495E', '#ACADAC', '#3498DB'],
                    ykeys: ['licensed', 'sorned'],
                    labels: ['سپرده گذاری', 'یرداشت'],
                    hideHover: 'auto',
                    xLabelAngle: 60,
                    resize: true
                });

            }

            if ($('#graphx').length ){

                Morris.Bar({
                    element: 'graphx',
                    data: [
                        {x: '2015 Q1', y: 2, z: 3, a: 4},
                        {x: '2015 Q2', y: 3, z: 5, a: 6},
                        {x: '2015 Q3', y: 4, z: 3, a: 2},
                        {x: '2015 Q4', y: 2, z: 4, a: 5}
                    ],
                    xkey: 'x',
                    ykeys: ['y', 'z', 'a'],
                    barColors: ['#26B99A', '#34495E', '#ACADAC', '#3498DB'],
                    hideHover: 'auto',
                    labels: ['Y', 'Z', 'A'],
                    resize: true
                }).on('click', function (i, row) {
                    console.log(i, row);
                });

            }

            if ($('#graph_area').length ){

                Morris.Area({
                    element: 'graph_area',
                    data: [
                        {period: '2014 Q1', iphone: 2666, ipad: null, itouch: 2647},
                        {period: '2014 Q2', iphone: 2778, ipad: 2294, itouch: 2441},
                        {period: '2014 Q3', iphone: 4912, ipad: 1969, itouch: 2501},
                        {period: '2014 Q4', iphone: 3767, ipad: 3597, itouch: 5689},
                        {period: '2015 Q1', iphone: 6810, ipad: 1914, itouch: 2293},
                        {period: '2015 Q2', iphone: 5670, ipad: 4293, itouch: 1881},
                        {period: '2015 Q3', iphone: 4820, ipad: 3795, itouch: 1588},
                        {period: '2015 Q4', iphone: 15073, ipad: 5967, itouch: 5175},
                        {period: '2016 Q1', iphone: 10687, ipad: 4460, itouch: 2028},
                        {period: '2016 Q2', iphone: 8432, ipad: 5713, itouch: 1791}
                    ],
                    xkey: 'period',
                    ykeys: ['iphone', 'ipad', 'itouch'],
                    lineColors: ['#26B99A', '#34495E', '#ACADAC', '#3498DB'],
                    labels: ['iPhone', 'iPad', 'iPod Touch'],
                    pointSize: 2,
                    hideHover: 'auto',
                    resize: true
                });

            }

            if ($('#graph_donut').length ){

                Morris.Donut({
                    element: 'graph_donut',
                    data: [
                        {label: 'Jam', value: 25},
                        {label: 'Frosted', value: 40},
                        {label: 'Custard', value: 25},
                        {label: 'Sugar', value: 10}
                    ],
                    colors: ['#26B99A', '#34495E', '#ACADAC', '#3498DB'],
                    formatter: function (y) {
                        return y + "%";
                    },
                    resize: true
                });

            }

            if ($('#graph_line').length ){

                Morris.Line({
                    element: 'graph_line',
                    xkey: 'year',
                    ykeys: ['value'],
                    labels: ['Value'],
                    hideHover: 'auto',
                    lineColors: ['#26B99A', '#34495E', '#ACADAC', '#3498DB'],
                    data: [
                        {year: '1', value: <?=$wallet->GetWithdrawalsByTime("-4 days")?>},
                        {year: '2', value: <?=$wallet->GetWithdrawalsByTime("-3 days")?>},
                        {year: '3', value: <?=$wallet->GetWithdrawalsByTime("-2 days")?>},
                        {year: '4', value: <?=$wallet->GetWithdrawalsByTime("-1 day")?>},
                        {year: '5', value: <?=$wallet->GetWithdrawalsByTime("now")?>}
                    ],
                    resize: true
                });

                $MENU_TOGGLE.on('click', function() {
                    $(window).resize();
                });

            }


        };
        function init_charts() {

            console.log('run_charts  typeof [' + typeof (Chart) + ']');

            if( typeof (Chart) === 'undefined'){ return; }

            console.log('init_charts');


            Chart.defaults.global.legend = {
                enabled: false
            };



            if ($('#canvas_line').length ){

                var canvas_line_00 = new Chart(document.getElementById("canvas_line"), {
                    type: 'line',
                    data: {
                        labels: ["January", "February", "March", "April", "May", "June", "July"],
                        datasets: [{
                            label: "My First dataset",
                            backgroundColor: "rgba(38, 185, 154, 0.31)",
                            borderColor: "rgba(38, 185, 154, 0.7)",
                            pointBorderColor: "rgba(38, 185, 154, 0.7)",
                            pointBackgroundColor: "rgba(38, 185, 154, 0.7)",
                            pointHoverBackgroundColor: "#fff",
                            pointHoverBorderColor: "rgba(220,220,220,1)",
                            pointBorderWidth: 1,
                            data: [31, 74, 6, 39, 20, 85, 7]
                        }, {
                            label: "My Second dataset",
                            backgroundColor: "rgba(3, 88, 106, 0.3)",
                            borderColor: "rgba(3, 88, 106, 0.70)",
                            pointBorderColor: "rgba(3, 88, 106, 0.70)",
                            pointBackgroundColor: "rgba(3, 88, 106, 0.70)",
                            pointHoverBackgroundColor: "#fff",
                            pointHoverBorderColor: "rgba(151,187,205,1)",
                            pointBorderWidth: 1,
                            data: [82, 23, 66, 9, 99, 4, 2]
                        }]
                    },
                });

            }


            if ($('#canvas_line1').length ){

                var canvas_line_01 = new Chart(document.getElementById("canvas_line1"), {
                    type: 'line',
                    data: {
                        labels: ["January", "February", "March", "April", "May", "June", "July"],
                        datasets: [{
                            label: "My First dataset",
                            backgroundColor: "rgba(38, 185, 154, 0.31)",
                            borderColor: "rgba(38, 185, 154, 0.7)",
                            pointBorderColor: "rgba(38, 185, 154, 0.7)",
                            pointBackgroundColor: "rgba(38, 185, 154, 0.7)",
                            pointHoverBackgroundColor: "#fff",
                            pointHoverBorderColor: "rgba(220,220,220,1)",
                            pointBorderWidth: 1,
                            data: [31, 74, 6, 39, 20, 85, 7]
                        }, {
                            label: "My Second dataset",
                            backgroundColor: "rgba(3, 88, 106, 0.3)",
                            borderColor: "rgba(3, 88, 106, 0.70)",
                            pointBorderColor: "rgba(3, 88, 106, 0.70)",
                            pointBackgroundColor: "rgba(3, 88, 106, 0.70)",
                            pointHoverBackgroundColor: "#fff",
                            pointHoverBorderColor: "rgba(151,187,205,1)",
                            pointBorderWidth: 1,
                            data: [82, 23, 66, 9, 99, 4, 2]
                        }]
                    },
                });

            }


            if ($('#canvas_line2').length ){

                var canvas_line_02 = new Chart(document.getElementById("canvas_line2"), {
                    type: 'line',
                    data: {
                        labels: ["January", "February", "March", "April", "May", "June", "July"],
                        datasets: [{
                            label: "My First dataset",
                            backgroundColor: "rgba(38, 185, 154, 0.31)",
                            borderColor: "rgba(38, 185, 154, 0.7)",
                            pointBorderColor: "rgba(38, 185, 154, 0.7)",
                            pointBackgroundColor: "rgba(38, 185, 154, 0.7)",
                            pointHoverBackgroundColor: "#fff",
                            pointHoverBorderColor: "rgba(220,220,220,1)",
                            pointBorderWidth: 1,
                            data: [31, 74, 6, 39, 20, 85, 7]
                        }, {
                            label: "My Second dataset",
                            backgroundColor: "rgba(3, 88, 106, 0.3)",
                            borderColor: "rgba(3, 88, 106, 0.70)",
                            pointBorderColor: "rgba(3, 88, 106, 0.70)",
                            pointBackgroundColor: "rgba(3, 88, 106, 0.70)",
                            pointHoverBackgroundColor: "#fff",
                            pointHoverBorderColor: "rgba(151,187,205,1)",
                            pointBorderWidth: 1,
                            data: [82, 23, 66, 9, 99, 4, 2]
                        }]
                    },
                });

            }


            if ($('#canvas_line3').length ){

                var canvas_line_03 = new Chart(document.getElementById("canvas_line3"), {
                    type: 'line',
                    data: {
                        labels: ["January", "February", "March", "April", "May", "June", "July"],
                        datasets: [{
                            label: "My First dataset",
                            backgroundColor: "rgba(38, 185, 154, 0.31)",
                            borderColor: "rgba(38, 185, 154, 0.7)",
                            pointBorderColor: "rgba(38, 185, 154, 0.7)",
                            pointBackgroundColor: "rgba(38, 185, 154, 0.7)",
                            pointHoverBackgroundColor: "#fff",
                            pointHoverBorderColor: "rgba(220,220,220,1)",
                            pointBorderWidth: 1,
                            data: [31, 74, 6, 39, 20, 85, 7]
                        }, {
                            label: "My Second dataset",
                            backgroundColor: "rgba(3, 88, 106, 0.3)",
                            borderColor: "rgba(3, 88, 106, 0.70)",
                            pointBorderColor: "rgba(3, 88, 106, 0.70)",
                            pointBackgroundColor: "rgba(3, 88, 106, 0.70)",
                            pointHoverBackgroundColor: "#fff",
                            pointHoverBorderColor: "rgba(151,187,205,1)",
                            pointBorderWidth: 1,
                            data: [82, 23, 66, 9, 99, 4, 2]
                        }]
                    },
                });

            }


            if ($('#canvas_line4').length ){

                var canvas_line_04 = new Chart(document.getElementById("canvas_line4"), {
                    type: 'line',
                    data: {
                        labels: ["January", "February", "March", "April", "May", "June", "July"],
                        datasets: [{
                            label: "My First dataset",
                            backgroundColor: "rgba(38, 185, 154, 0.31)",
                            borderColor: "rgba(38, 185, 154, 0.7)",
                            pointBorderColor: "rgba(38, 185, 154, 0.7)",
                            pointBackgroundColor: "rgba(38, 185, 154, 0.7)",
                            pointHoverBackgroundColor: "#fff",
                            pointHoverBorderColor: "rgba(220,220,220,1)",
                            pointBorderWidth: 1,
                            data: [31, 74, 6, 39, 20, 85, 7]
                        }, {
                            label: "My Second dataset",
                            backgroundColor: "rgba(3, 88, 106, 0.3)",
                            borderColor: "rgba(3, 88, 106, 0.70)",
                            pointBorderColor: "rgba(3, 88, 106, 0.70)",
                            pointBackgroundColor: "rgba(3, 88, 106, 0.70)",
                            pointHoverBackgroundColor: "#fff",
                            pointHoverBorderColor: "rgba(151,187,205,1)",
                            pointBorderWidth: 1,
                            data: [82, 23, 66, 9, 99, 4, 2]
                        }]
                    },
                });

            }


            // Line chart

            if ($('#lineChart').length ){

                var ctx = document.getElementById("lineChart");
                var lineChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: [
                            <?php foreach ($my_compets as $comp){ $comppp_info = $compM->getFrom_Competition_tbl_by($comp);?>
                                "<?=$comppp_info['Title']?>",
                            <?php }?>
                        ],
                        datasets: [{
                            label: "سود",
                            backgroundColor: "rgba(38, 185, 154, 0.31)",
                            borderColor: "rgba(38, 185, 154, 0.7)",
                            pointBorderColor: "rgba(38, 185, 154, 0.7)",
                            pointBackgroundColor: "rgba(38, 185, 154, 0.7)",
                            pointHoverBackgroundColor: "#fff",
                            pointHoverBorderColor: "rgba(220,220,220,1)",
                            pointBorderWidth: 1,
                            data: [
                                <?php foreach ($my_compets as $compp){?>
                                    <?=$wallet->CalculateProfitByCompetition($compp)['Profit']?>,
                                <?php }?>
                            ]
                        }, {
                            label: "ضرر",
                            backgroundColor: "rgba(3, 88, 106, 0.3)",
                            borderColor: "rgba(3, 88, 106, 0.70)",
                            pointBorderColor: "rgba(3, 88, 106, 0.70)",
                            pointBackgroundColor: "rgba(3, 88, 106, 0.70)",
                            pointHoverBackgroundColor: "#fff",
                            pointHoverBorderColor: "rgba(151,187,205,1)",
                            pointBorderWidth: 1,
                            data: [
                                <?php foreach ($my_compets as $compp){?>
                                <?=$wallet->CalculateProfitByCompetition($compp)['Profit']?>,
                                <?php }?>
                            ]
                        }]
                    },
                });

            }

            // Bar chart

            if ($('#mybarChart').length ){

                var ctx = document.getElementById("mybarChart");
                var mybarChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: ["January", "February", "March", "April", "May", "June", "July"],
                        datasets: [{
                            label: '# of Votes',
                            backgroundColor: "#26B99A",
                            data: [51, 30, 40, 28, 92, 50, 45]
                        }, {
                            label: '# of Votes',
                            backgroundColor: "#03586A",
                            data: [41, 56, 25, 48, 72, 34, 12]
                        }]
                    },

                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true
                                }
                            }]
                        }
                    }
                });

            }


            // Doughnut chart

            if ($('#canvasDoughnut').length ){

                var ctx = document.getElementById("canvasDoughnut");
                var data = {
                    labels: [
                        "Dark Grey",
                        "Purple Color",
                        "Gray Color",
                        "Green Color",
                        "Blue Color"
                    ],
                    datasets: [{
                        data: [120, 50, 140, 180, 100],
                        backgroundColor: [
                            "#455C73",
                            "#9B59B6",
                            "#BDC3C7",
                            "#26B99A",
                            "#3498DB"
                        ],
                        hoverBackgroundColor: [
                            "#34495E",
                            "#B370CF",
                            "#CFD4D8",
                            "#36CAAB",
                            "#49A9EA"
                        ]

                    }]
                };

                var canvasDoughnut = new Chart(ctx, {
                    type: 'doughnut',
                    tooltipFillColor: "rgba(51, 51, 51, 0.55)",
                    data: data
                });

            }

            // Radar chart

            if ($('#canvasRadar').length ){

                var ctx = document.getElementById("canvasRadar");
                var data = {
                    labels: ["Eating", "Drinking", "Sleeping", "Designing", "Coding", "Cycling", "Running"],
                    datasets: [{
                        label: "My First dataset",
                        backgroundColor: "rgba(3, 88, 106, 0.2)",
                        borderColor: "rgba(3, 88, 106, 0.80)",
                        pointBorderColor: "rgba(3, 88, 106, 0.80)",
                        pointBackgroundColor: "rgba(3, 88, 106, 0.80)",
                        pointHoverBackgroundColor: "#fff",
                        pointHoverBorderColor: "rgba(220,220,220,1)",
                        data: [65, 59, 90, 81, 56, 55, 40]
                    }, {
                        label: "My Second dataset",
                        backgroundColor: "rgba(38, 185, 154, 0.2)",
                        borderColor: "rgba(38, 185, 154, 0.85)",
                        pointColor: "rgba(38, 185, 154, 0.85)",
                        pointStrokeColor: "#fff",
                        pointHighlightFill: "#fff",
                        pointHighlightStroke: "rgba(151,187,205,1)",
                        data: [28, 48, 40, 19, 96, 27, 100]
                    }]
                };

                var canvasRadar = new Chart(ctx, {
                    type: 'radar',
                    data: data,
                });

            }


            // Pie chart
            if ($('#pieChart').length ){

                var ctx = document.getElementById("pieChart");
                var data = {
                    datasets: [{
                        data: [120, 50, 140, 180, 100],
                        backgroundColor: [
                            "#455C73",
                            "#9B59B6",
                            "#BDC3C7",
                            "#26B99A",
                            "#3498DB"
                        ],
                        label: 'My dataset' // for legend
                    }],
                    labels: [
                        "Dark Gray",
                        "Purple",
                        "Gray",
                        "Green",
                        "Blue"
                    ]
                };

                var pieChart = new Chart(ctx, {
                    data: data,
                    type: 'pie',
                    otpions: {
                        legend: false
                    }
                });

            }


            // PolarArea chart

            if ($('#polarArea').length ){

                var ctx = document.getElementById("polarArea");
                var data = {
                    datasets: [{
                        data: [120, 50, 140, 180, 100],
                        backgroundColor: [
                            "#455C73",
                            "#9B59B6",
                            "#BDC3C7",
                            "#26B99A",
                            "#3498DB"
                        ],
                        label: 'My dataset'
                    }],
                    labels: [
                        "Dark Gray",
                        "Purple",
                        "Gray",
                        "Green",
                        "Blue"
                    ]
                };

                var polarArea = new Chart(ctx, {
                    data: data,
                    type: 'polarArea',
                    options: {
                        scale: {
                            ticks: {
                                beginAtZero: true
                            }
                        }
                    }
                });

            }
        }
    </script>
    <!-- Dropzone.js -->
    <script src="<?=HTTP_SERVER?>/panel/vendors/dropzone/dist/min/dropzone.min.js"></script>
    <!-- morris.js -->
    <script src="<?=HTTP_SERVER?>/panel/vendors/raphael/raphael.min.js"></script>
    <script src="<?=HTTP_SERVER?>/panel/vendors/morris.js/morris.min.js"></script>
    <script src="<?=HTTP_SERVER?>/panel/vendors/select2/dist/js/select2.full.min.js"></script>
    <!-- Parsley -->
    <script src="<?=HTTP_SERVER?>/panel/vendors/parsleyjs/dist/parsley.min.js"></script>
    <!-- Autosize -->
    <script src="<?=HTTP_SERVER?>/panel/vendors/autosize/dist/autosize.min.js"></script>
    <!-- jQuery autocomplete -->
    <script src="<?=HTTP_SERVER?>/panel/vendors/devbridge-autocomplete/dist/jquery.autocomplete.min.js"></script>
    <!-- starrr -->
    <script src="<?=HTTP_SERVER?>/panel/vendors/starrr/dist/starrr.js"></script>
    <!-- bootstrap-wysiwyg -->
    <script src="<?=HTTP_SERVER?>/panel/vendors/bootstrap-wysiwyg/js/bootstrap-wysiwyg.min.js"></script>
    <script src="<?=HTTP_SERVER?>/panel/vendors/jquery.hotkeys/jquery.hotkeys.js"></script>
    <script src="<?=HTTP_SERVER?>/panel/vendors/google-code-prettify/src/prettify.js"></script>
    <!-- Datatables -->
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
    <!-- Chart.js -->
    <script src="<?=HTTP_SERVER?>/panel/vendors/Chart.js/dist/Chart.min.js"></script>
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
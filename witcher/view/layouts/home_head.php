<?php
$witcher = new \witcher();
$witcher->requireController("home");
$home = new \Controller\home();
$server_info = $home->getDatas()['server_info'];
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta property="fb:app_id" content="246235472079864">
    <meta name="format-detection" content="telephone=no">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title><?=$server_info['Title']?></title>
    <meta name="description" content="">
    <!-- FB meta -->
    <meta property="og:title" content="Lottary Online">
    <meta property="og:description" content="Lottary Online">
    <meta property="og:url" content="#">
    <meta property="og:image" content="https://d3uwcqgr5gxvbk.cloudfront.net/assets/themes/multilotto/img/ml/logo-com-fb.png">
    <meta property="og:site_name" content="#.com - Play lotto on the world's biggest lotteries!">
    <meta property="og:type" content="website">

    <link href="<?=HTTP_SERVER."/"?>css/main.css" rel="stylesheet" media="all" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!--[if lt IE 9]>
    <script src="https://d3uwcqgr5gxvbk.cloudfront.net/assets/themes/multilotto/js/dist/html5shim.min.js" type="text/javascript"></script>
    <![endif]-->
    <!-- OneSignal -->
    <script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" async></script>
    <script>
        var OneSignal = window.OneSignal || [];
        OneSignal.push(["init", {
            appId: "d18b3062-e8ea-44a0-b94b-6e9fdf4078c0",
            autoRegister: true,
            notifyButton: {
                enable: false
            },
            welcomeNotification: {
                disable: true
            },
            persistNotification: false,
            safari_web_id: 'web.onesignal.auto.3a3b4186-8f32-4bbf-a810-be3f3be590a9'
        }]);
    </script>
    <script>
        function CountDown(link){
            var inner = document.getElementById(link);
            var countDownDate = new Date(inner.innerHTML).getTime();
            var x = setInterval(function() {
                var now = new Date().getTime();
                var distance = countDownDate - now;
                var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((distance % (1000 * 60)) / 1000);
                document.getElementById(link).innerHTML = days + "روز " + hours + "ساعت "
                    + minutes + "دقیقه " + seconds + "ثانیه ";
                if (distance < 0) {
                    clearInterval(x);
                    document.getElementById(link).innerHTML = "<b style='color: red;'>تمام شد</b>";
                }
            }, 1000);
        }
    </script>
    <!-- /OneSignal -->
    <script type="text/javascript" src="<?=HTTP_SERVER."/"?>vendor/bootstrap/bootstrap.min.js" async></script>
    <!-- optimizely Tracking -->
    <script src="https://cdn.optimizely.com/js/9268904739.js"></script>
    <!-- CrazyEgg Tracking -->
    <script type="text/javascript" src="//script.crazyegg.com/pages/scripts/0070/4502.js" async="async"></script>
    <style>
        .card {box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);max-width: 300px;margin: auto;text-align: center;}.title {color: grey;font-size: 18px;}*{font-family:'Yekan','B Yekan+';}button {border: none;outline: 0;display: inline-block;padding: 8px;color: white;background-color: #000;text-align: center;cursor: pointer;width: 100%;font-size: 18px;}a {text-decoration: none;font-size: 19px;color: black;}.playable-games{font-size:17px !important;}button:hover, a:hover {opacity: 0.7;}}.alert {direction: rtl!important;font-size:20px;padding: 10px!important;background-color: #f44336;color: white!important;}.closebtn {margin-left: 15px!important;color: white!important;font-weight: bold!important;float: right!important;font-size: 22px!important;line-height: 20px!important;cursor: pointer!important;transition: 0.3s;}.closebtn:hover {color: black;}.alert.success {background-color: #4CAF50;}.alert.info {background-color: #2196F3;}.alert.warning {background-color: #ff9800;text-align: right;}
    </style>
    <script>function clickAndDisable(link) {link.onclick = function(event) {event.preventDefault();}</script>
</head>

<body id="body" class="page lang-en front" data-controller="start" data-action="frontpage">


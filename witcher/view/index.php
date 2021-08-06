<?php $witcher = new witcher();
$witcher->requireController("login");
$login = new \Controller\login();
$home = new \Controller\home();
$winner = new \Model\winner();
$home = $home->getDatas();
$notstrated_comps = $home['Not_Started'];
$ended_comps = $home['Ended'];
$comp = new \Model\competition();
$ticket = new \Model\ticket();
$server_info = $home['server_info'];?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta property="fb:app_id" content="246235472079864">
    <meta name="format-detection" content="telephone=no">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title><?=$server_info['Title']?></title>
    <!-- FB meta -->
    <meta property="og:title" content="<?=$server_info['Title']?>">
    <meta property="og:description" content="">
    <meta property="og:url" content="<?=HTTPS_SERVER?>">
    <meta property="og:type" content="website">
    <!-- /FB meta -->

    <link href="<?=HTTP_SERVER."/"?>css/main.css" rel="stylesheet" media="all" type="text/css" />

    <!--[if lt IE 9]>
    <script src="https://d3uwcqgr5gxvbk.cloudfront.net/assets/themes/multilotto/js/dist/html5shim.min.js" type="text/javascript"></script>
    <![endif]-->
    <script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" async></script>
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
    <!-- /OneSignal --><script type="text/javascript" src="panel/vendor/bootstrap/bootstrap.min.js" async></script><!-- optimizely Tracking --><script src="https://cdn.optimizely.com/js/9268904739.js"></script><!-- CrazyEgg Tracking --><script type="text/javascript" src="//script.crazyegg.com/pages/scripts/0070/4502.js" async="async"></script>
    <style>.card {box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);max-width: 300px;margin: auto;text-align: center;}.title {color: grey;font-size: 18px;}button {border: none;outline: 0;display: inline-block;padding: 8px;color: white; background-color: #000;text-align: center;cursor: pointer;width: 100%;font-size: 18px;}a {text-decoration: none;font-size: 19px;color: black;}.playable-games{font-size:17px !important;} button:hover, a:hover {opacity: 0.7;}</style>
</head>

<body id="body" class="page lang-en front" data-controller="start" data-action="frontpage">
    <div id="wrapper">
     <div id="content">
            <div id="left-column">
                <?php if ($login->is_login() == 0){?>
                <div class="hidden-desktop">
                        <p><a href="<?=HTTP_SERVER?>/signup" class="btn huge green" style="width: 48%; margin-right: 2%;">ثبت نام</a>
                        <a href="<?=HTTP_SERVER?>/login" class="btn huge blue" style="width: 48%;">ورود</a></p>
                    <div class="spacer20"></div></div><?php }?>
                <!-- tabs -->
                <div class="tab-container js-tabs">
                    <!-- tab nav -->
                    <div class="tab-nav-wrapper hidden-mobile">
                        <ul class="tab-nav">
                            <li class="green is-active"><a href="#" class="akz">مسابقات آغاز شده</a></li>
                            <li class="blue"><a href="#" class="akz">درحال نزدیک شدن</a></li>
                            <li class="red"><a href="#" class="akz">نتایج</a></li>
                        </ul>
                    </div>
                    <!-- /tab nav -->
                    <div class="tab-content">
                        <!-- tab - playable games -->
                        <div class="tab is-active">
                            <div class="playable-games">
                                <ul>
                                    <?php foreach ($home['Playable_games'] as $keys_games => $game_values){
                                        $competition_status = $comp->getCompetition_Status($game_values['Competition_Id']);
                                        $status_header = "";
                                        $winner->set_c_id($game_values['Competition_Id']);
                                        $biggest_reward = $winner->biggest_reward();
                                        $times_left_to_start = 0;
                                        $is_newest = $comp->is_this_newest($game_values['Competition_Id']);
                                        $total_tickets = $ticket->get_total_ticket_values($game_values['Competition_Id']);
                                        switch ($competition_status['status']){
                                            case "Not-Begin":
                                                $status_header = "آغاز نشده";
                                                $times_left_to_start = $comp->get_Time_to_start($game_values['Competition_Id']);
                                                break;
                                            case "In-Progress":
                                                $status_header =  "<b style='color: limegreen;text-decoration: underline;'>آغاز شده</b>";
                                                break;
                                            case "Expired":
                                                $status_header =  "منسوخ شده";
                                                break;
                                        }
                                        ?>
                                    <li data-gametypeid="67" >
                                        <div class="logo col1 world-cup-billion" style= "margin-top:28px;">
                                                <span style="">
												<a href="<?=HTTP_SERVER?>/ticket/buy?c=<?=$game_values['Competition_Id']?>"><img src="<?=$game_values['Image_src']?>" alt="World Cup Billion" style="border-radius:100px;"></a>
											</span>
                                            <?php if ($is_newest != false AND $game_values['Starts_At'] == $is_newest['max_start']){
                                                ?>
                                            <div class="new-lottery">جدید</div>
                                            <?php }?>
                                        </div>
                                        <div class="jackpot col2" style = "margin-top:10px;float:right;">
                                            <div class="vertical-align">
                                                    <span class="jackpot-size">
														<a href="http://arashproject/world-cup-billion" class="cgreen"><span class="jackpot-fx-symbol before"><?php if ($total_tickets > 0){echo "تومان";}else{echo "هنوز بلیطی خریداری نشده است.";}?></span><?=$biggest_reward?></a>
                                                    </span>
                                                <?=$status_header?>
                                                <br>
                                                <?php if ($competition_status['status'] == "In-Progress"){?>
                                                    زمان باقی مانده
                                                    <br> <span class="countdown" >
														<a href="<?=HTTP_SERVER?>" class=" hidden-mobile"  data-expiry-text="<?=$status_header?>" id="<?=$game_values['id']?>"><?=date("M d, Y H:i:s",$game_values['Ends_At'])?></a>
														<a href="<?=HTTP_SERVER?>" class=" mobile-countdown visible-mobile" data-expiry-text="<?=$status_header?>" id="<?=$game_values['id']?>"><?=date("M d, Y H:i:s",$game_values['Ends_At'])?></a>
                                                    <script>
                                        var id = document.getElementById(<?=$game_values['id']?>).getAttribute('id');
                                        CountDown(id);</script>
													</span>
                                                <?php }?>
                                            </div>
                                        </div>
                                        <div class="cta col3">
                                            <a href="<?php if ($competition_status['status'] == "In-Progress"){echo HTTP_SERVER . "/ticket/buy?c=".$game_values['Competition_Id'];}else{echo HTTP_SERVER . "ticket";}?>" class="btn big green jurisdiction-1">
                                                <span class="mobile-text visible-mobile">خرید تیکت</span>
                                                <span class="hidden-mobile"><?php if ($competition_status['status'] == "In-Progress"){echo "خرید تیکت -";}?> <?="قیمت هر تیکت".$game_values['Tickets_price']?>تومان</span>
                                            </a>
                                            <span class="hidden-tablet hidden-desktop mobile-amount">تومان<?=$game_values['Tickets_price']?></span>
                                        </div>
                                    </li>
                                    <?php }if (count($home['Playable_games']) == 0){?>
                                        <p style="text-align: center;margin-top : 10px;">موردی یافت نشد</p>
                                    <?php }?>
                                </ul>
                            </div>

                        </div>
                        <!-- /tab - playable games -->
                        <!-- tab - biggest games -->
                        <div class="tab">

                            <div class="front-table">

                                <table>
                                    <thead>
                                    <tr>
                                        <th class="col1">#</th>
                                        <th class="col2" style = "text-align:center!important;">نام مسابقه</th>
                                        <th class="col3" style = "text-align:center!important;">قیمت هر تیکت</th>
                                        <th class="col4" style = "text-align:center!important;">زمان باقی مانده تا آغاز</th>
                                        <th class="col6" style = "text-align:center!important;">محدودیت کاربر</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $rn = 1;
                                        foreach($notstrated_comps as $ncomp_value){?>
                                    <tr class="">
                                        <td class="img"><div class="game-number blue"><?=$rn?></div></td>
                                        <td><a><?=$ncomp_value['Title']?></a></td>
                                        <td class="big" style="text-align:center;"><span class="jackpot-fx-symbol before">TOMAN</span><?=$ncomp_value['Tickets_price']?></td>
                                        <td class="big" id="<?=$ncomp_value['id']?>"><?=date("M d, Y H:i:s",$ncomp_value['Starts_At'])?></td>
                                        <td><a href="#" class="btn small green"><?php if ($ncomp_value['User_Limitation'] == 0){echo "ندارد";}else{echo $ncomp_value['User_Limitation'];}?> </a></td>
                                    </tr>
                                    <script>var id = document.getElementById(<?=$ncomp_value['id']?>).getAttribute('id');CountDown(id);</script>
                                    <?php $rn++;}?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- /tab - biggest games -->
                        <!-- tab - closing games -->
                        <div class="tab">
                            <div class="front-table">
                             <table>
                                    <thead>
                                    <tr>
                                        <th class="col1">#</th>
                                        <th class="col2"></th>
                                        <th class="col3" style="text-align:center;">مسابقه</th>
                                        <th class="col4" style="text-align:center;">جایزه نفر اول</th>
                                        <th class="col5" style="text-align:center;">نفر اول</th>
                                        <th class="col6" style="text-align:center;">بیشتر..</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $row_numm = 1;foreach($ended_comps as $ended_comp){
                                        if ($row_numm < 11){
                                        $winner->set_c_id($ended_comp['Competition_Id']);
                                        $first = $winner->get_winner_users()[0];
                                    ?>
                                    <tr>
                                        <td class="img"><div class="game-number blue"><?=$row_numm?></div></td>
                                        <td class="img"><span class="flags-sprite flags-uk"></span></td>
                                        <td><a href="<?=HTTP_SERVER?>"><?=$ended_comp['Title']?></a></td>
                                        <td class="big"><a><span class="jackpot-fx-symbol before">تومان</span></a><?=$winner->biggest_reward();?></td>
                                        <td><?php if ($first == null){echo "تعیین نشده";}else{echo $first;}?></td>
                                        <td style = "text-align:center;"><a href="/results?c=<?=$ended_comp['Competition_Id']?>" class="btn btn-large green" style="border-radius:100px;padding:7px 15px;">بیشتر</a></td>
                                    </tr>
                                    <?php $row_numm++;}}?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- /tab - closing games -->
                    </div>
                </div>
                <!-- /tabs -->
                <div class="spacer20"></div>
            </div>
            <div class="hidden-tablet hidden-mobile" id="right-column">
                <?php
                if ($login->is_login() == 0){
                ?>
                <!-- user login -->
                <div class="login-container">
                    <div class="login-top"><span class="akz">ورود</span></div>
                    <div class="login-body">
                        <form id="signinform" action="<?=HTTP_SERVER?>/login" method="post">
                            <input type="text" name="Username" value="" class="field" autocomplete="off" placeholder="نام کاربری" tabindex="1" required>
                            <input type="password" name="Password" value="" class="field" placeholder="پسورد" tabindex="2" required>
                            <input type="submit" name="Login" value="ورود" class="btn btn blue" style="display: inline-block;width: 50%;padding: 6px 30px;">
                            <div class="spacer20"></div>
                            <a href="/forgot" class="text">آیا پسورد خود را فراموش کرده اید؟</a><br>
                            <a href="/signup" class="btn green" style="padding: 6px 30px;display: block">ثبت نام</a>
                        </form>
                    </div>
                </div>
                    <!-- /user login -->
                <?php }else{
                    $userr = new \Model\user();
                    $user = $userr->user_get_certificate();
                    $perm = $userr->user_get_permission();
                    ?>
                <!-- profile -->
                    <div class="card">
                        <img src="<?php if (strlen($user['Profile_Image']) > 0){echo $user['Profile_Image'];}else{echo HTTP_SERVER . "/panel/src/img/profile_image.png";}?>" style="width:100%">
                        <h1><?= $user['Username']?></h1>
                        <p class="title"><?=$user['Email']?></p>
                        <?php if (!$login->is_admin()){?>
                        <p><button style="background: #00d656;" onclick="location.href = '<?=HTTP_SERVER?>/profile/wallet/withdrawal';">برداشت حساب</button></p>
                        <?php }?>
                    </div>
                <!-- /profile -->
                <?php } ?>
                <!-- testimonials -->
                <div class="js-trustpilot-reviews">
                </div>
                <!-- /testimonials -->
                <!-- help bumpers -->
                <div class="front-entries">
                    <a href="/faq" class="akz">
                        <span class="fas fa-comments faq"></span>
                        <span class="txt">سوالات متداول</span>
                    </a>
                </div>
                <div class="front-entries">
                    <a href="/how-to-play" class="akz">
                        <span class="fas fa-info-circle howto"></span>
                        <span class="txt">چطور در مسابقه شرکت کنم</span>
                    </a>
                </div>
                <!-- /help bumpers -->
                <!-- statistics box -->
                <div class="statistics-box">
                <div class="taglines">
                        <h3 class="tagline first-tagline">میخوای برنده باشی؟</h3></h3>
                        <h3 class="tagline second-tagline">شانست رو امتحان کن</h3></div><div style="text-align: center;"><a href="#" class="btn big green">کلیک کن</a></div></div>
                </div>
                <!-- /biggest jackpots -->
            </div>
        </div>
    </div>
    <!-- /inner wrapper -->
</body>
</html>
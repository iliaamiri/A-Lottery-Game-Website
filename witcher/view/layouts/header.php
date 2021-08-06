<?php $witcher = new witcher();$witcher->requireController("login");$witcher->requireController("home");$login = new \Controller\login();$home = new \Controller\home();$home_data = $home->getDatas();
$latest_comp = $home_data['Latest'];
?>
<nav class="responsive-main-menu js-responsive-menu hidden-desktop">
    <div class="menu-wrapper first-menu js-first-menu" data-scrollerorder="0" data-scroller>
        <ul>
            <li class="menu-item"><a href="<?=HTTP_SERVER?>"><span class="fa fa-home"></span>خانه</a></li>
            <?php if ($login->is_login() == 0){?>
            <li class="menu-item menu-item--casino">
                <span class="menu-item-casino-bg"></span>
                <a href="<?=HTTP_SERVER?>/ticket">
                    <span class="fas fa-life-ring"></span>
                    خرید بلیط								</a>
            </li>
            <li class="menu-item menu-item--casino menu-submenu-anchor">
                <span class="menu-item-casino-bg"></span>
                <a href="<?=HTTP_SERVER?>" class="js-submenu-toggle" data-target="allscratchcards">نتایج قرعه کشی</a>
            </li>
             <li class="menu-item"><a href="<?=HTTP_SERVER?>/login" class="cblue">ورود</a></li>
                <li class="menu-item"><a href="<?=HTTP_SERVER?>/signup" class="cgreen">ثبت نام</a></li>
                <?php }else{?>
                 <li class="menu-item"><a href="<?=HTTP_SERVER?>/ticket"><span class="fas fa-phone"></span>خرید بلیط</a></li>
                  <li class="menu-item"><a href="<?=HTTP_SERVER?>/profile/"><span class="fas fa-phone"></span>تراکنش ها</a></li>
                   <li class="menu-item"><a href="<?=HTTP_SERVER?>/profile/wallet/withdrawal"><span class="fas fa-phone"></span>برداشت جایزه</a></li>
                    <li class="menu-item"><a href="<?=HTTP_SERVER?>/profile/support"><span class="fas fa-phone"></span>لیست برداشت جایزه</a></li>
                <li class="menu-item menu-submenu-anchor"><a href="#" class="js-submenu-toggle" data-target="results"><span class="fas fa-info-circle"></span>نتایج</a></li>
                 <li class="menu-item"><a href="<?=HTTP_SERVER?>/profile/support"><span class="fas fa-phone"></span>قرعه کشی</a></li>
                    <li class="menu-item"><a href="<?=HTTP_SERVER?>/profile" class="cblue">حساب کاربری</a></li>
                    <li class="menu-item"><a href="<?=HTTP_SERVER?>/profile/support/contact" class="cblue">پشتیبانی</a></li>
                    <li class="menu-item"><a href="<?=HTTP_SERVER?>/logout" class="cblue">خروج</a></li>
                <?php }?>
        </ul>
    </div>
    <div class="menu-wrapper sub-menu js-submenu" data-scrollerorder="1" data-submenu="allscratchcards" data-scroller>
        <ul>
            <li class="menu-item menu-back"><a href="#" class="js-submenu-toggle" data-target="allscratchcards">قبل</a></li>
            <li class="menu-item">
                <a href="<?=HTTP_SERVER?>" class="">زیر منوها</a>
            </li>
        </ul>
    </div>
</nav>
<div class="responsive-top-bar js-responsive-top-bar hidden-desktop">
    <a href="javascript:;" class="toggle-menu-wrapper js-toggle-menu-wrapper">
        <div class="menu-burger js-menu-burger"></div>
        <span class="menu-txt">منو</span>
    </a>
    <a href="<?=HTTP_SERVER?>" class="responsive-logo"><img src="<?=HTTP_SERVER?>/img/logo.png" alt="<?=HTTP_SERVER?>"></a>
</div>
<!-- outer wrapper -->
<div class="outer-wrapper js-outer-wrapper" id="outer-wrapper">
    <header class="header-container hidden-tablet hidden-mobile js-header-container">
        <div class="header-wrapper">
            <a href="<?=HTTP_SERVER?>" id="logo"><img src="<?=HTTP_SERVER?>/img/logo.png" height="57" width="151" alt="<?=HTTP_SERVER?>"></a>
            <div class="top">
                <?php if ($login->is_login() == 0){?>
                <a href="<?=HTTP_SERVER?>/login" class="top-item btn blue big">ورود</a>
                <a href="<?=HTTP_SERVER?>/signup" class="top-item btn green big">ثبت نام</a>
                <?php }else{?>
                    <a href="<?=HTTP_SERVER?>/profile" class="top-item btn green big">حساب کاربری</a>
                    <a href="<?=HTTP_SERVER?>/logout" class="top-item btn red big">خروج</a>
                <?php }?>
            </div>
        </div>
        <nav class="desktop-main-menu">
            <div class="main-menu-wrapper"><?php if ($login->is_login() == 1){?>
                <div class="menu-item"><a href="<?=HTTP_SERVER?>">صفحه اصلی</a></div>
                <div class="btn-menu-item menu-item--casino menu-submenu"><a href="<?=HTTP_SERVER?>/ticket" class="btn-casino">خرید بلیط</a></div>
                <div class="menu-item"><a href="<?=HTTP_SERVER?>/profile/wallet/withdrawal">برداشت جایزه</a></div>
                <div class="menu-item"><a href="<?=HTTP_SERVER?>/profile/wallet/withdrawal">لیست برداشت جایزه</a></div>
                <div class="menu-item"><a href="<?=HTTP_SERVER?>/profile/wallet/withdrawal">نتایج</a></div>
                 <div class="menu-item"><a href="<?=HTTP_SERVER?>/profile/wallet/withdrawal">قرعه کشی</a></div><?php }else{?>
                <div class="menu-item"><a href="<?=HTTP_SERVER?>">صفحه اصلی</a></div>
                <div class="menu-item"><a href="<?=HTTP_SERVER?>/profile/wallet/withdrawal">نتایج قرعه کشی</a></div>
                <div class="btn-menu-item menu-item--casino menu-submenu"><a href="<?=HTTP_SERVER?>/profile/wallet/deposit" class="btn-casino">خرید بلیط</a></div><?php }?>
                <?php if (count($latest_comp) > 0 ){?>
                <div class="menu-item menu-item--casino"><a class="btn-casino" href="<?=HTTP_SERVER?>/ticket/buy?c=<?=$latest_comp[0]['Competition_Id']?>">شرکت در آخرین مسابقه</a></div>
                <?php }?>
            </div>
        </nav>
    </header>
    <div class="menu-spacer hidden-tablet hidden-mobile"></div>
</div>
<?php $home = new \Controller\home();$sliders = $home->getSliders();?>
<div class="front-slider-wrapper">
    <div class="front-slider cycle-slideshow js-start-slider" data-cycle-timeout="5000" data-cycle-slides=".slider-pane">
        <?php foreach ($sliders as $slider_value){?>
            <div class="slider-pane campaign-slider-panel  ">
                <a href="<?=$slider_value['Href_Url']?>">
                    <div class="campaign-container" style="background-image:url(<?=$slider_value['Big_Image']?>);">
                        <div class="campaign-container-section" style="margin-top: 5%;"><img src="<?=$slider_value['Icon_Image']?>" alt="Mega Millions Max">
                            <div class="jackpot-huge" style="font-family:'yekan'!important;color:white;"><?=$slider_value['Content_Text']?></div>
                        </div>
                        <?php if ($slider_value['Button_Status'] == 1){?>
                            <div class="btn huge" style="background-color: <?=$slider_value['Button_Color']?>!important;"><?=$slider_value['Button_Text']?></div>
                        <?php }?>
                    </div>
                </a>
            </div>
        <?php }?>
    </div>
</div>
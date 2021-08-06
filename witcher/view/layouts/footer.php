<footer class="footer-container">
    <div class="footer-wrapper">
        <div class="section--disclaimer">
            <div class="disclaimer-age-limit akz">
                <span>شانس خود را امتحان کنید و میلیاردر شوید!</span><br>
                <img src="https://d3uwcqgr5gxvbk.cloudfront.net/assets/themes/multilotto/img/footer-age-limit.png" alt="شما باید بالای 18 سال سن داشته باشید تا در مسابقه شرکت کنید."> 		</div>
            <p style="font-family:'yekan'!important;">شانس خود را امتحان کنید</p>
        </div>
        <!-- payment methods -->
        <div class="section--payment">
            <a href="javascript:;" class="methods-spr dinersclub" data-target="dinersclub"></a>
        </div>
        <!-- /payment methods -->
        <!-- trust -->
        <div class="section--trust">
            <img src="https://d3uwcqgr5gxvbk.cloudfront.net/assets/themes/multilotto/img/trusted-site.png" alt="100% Trusted site 2012-2016">
        </div>
        <!-- /trust -->

        <!-- copyright -->
        <div class="section--copyright">
            <p style="font-family:'yekan'!important;"> قدرت گرفته از Witcher</p>
        </div>
        <!-- /copyright -->
    </div>
</footer>
<div class="app-promotion-wrapper">
    <a href="javascript:" class="app-promotion-desktop js-app-promotion-download" style="padding: 9px 20px;">
        <!--<span class="app-promotion-desktop-icon"><i class="fas fa-mobile" aria-hidden="true"></i></span>-->
        <span class="app-promotion-desktop-icon"><img src="https://d3uwcqgr5gxvbk.cloudfront.net/assets/themes/multilotto/images/landpage/app-fa-mobile.gif?v=847" style="height:24px;"></span>
        <span class="app-promotion-desktop-text">App</span>
    </a>

    <div class="app-promotion-mobile" style="display:none;">
        <!-- H5 pages  -->
        <div class="app-promotion-mobile-text js-promote-h5-mobile" style="display:none;">
            <div class="app-promotion-mobile-text-1">Install Our App Today!</div>
            <div class="app-promotion-mobile-text-2">Dream Jackpots Anytime, Anywhere!</div>
            <a class="app-promotion-mobile-text-btn btn green big js-app-promotion-download" href="javascript:">
                <i class="fas fa-mobile-alt" aria-hidden="true"></i>
                <span class="btn-text">Download</span>
            </a>
        </div>
        <!-- H5App pages  -->
        <div class="app-promotion-mobile-text js-promote-h5app-mobile" style="display:none;">
            <div class="app-promotion-mobile-text-1">New version
            </div>
            <div class="app-promotion-mobile-text-2">This is a great optimized version, so we hope you would like our new version.
            </div>
            <a class="app-promotion-mobile-text-btn btn green big js-app-promotion-download" href="javascript:">
                <i class="fas fa-mobile-alt" aria-hidden="true"></i>
                <span class="btn-text">Download</span>
            </a>
        </div>
        <a id="closeButton" onclick="closeButton(); setCookie('app_promotion_shown', 1)">x</a>
    </div>
    <input type="hidden" id="app_promotion_ml" value="">
</div>
<div class="help-request-wrapper">
    <div class="help-request-form js-help-request-form" style="display: none;">
        <div class="help-top-bar akz">Contact us</div>
        <div class="resp-msg js-resp-msg" style="display: none;"></div>
    </div>

    <div class="toggle-help-request js-toggle-help-request_open">
        <span class="help-desktop-icon"><i class="far fa-question-circle" aria-hidden="true"></i></span>
        <span class="help-desktop-text">Help</span>
    </div>
</div>
<!-- /outer wrapper -->
<script src="https://d3uwcqgr5gxvbk.cloudfront.net/assets/themes/multilotto/js/jquery-3.2.1.min.js?v=c9f5aeeca3" type="text/javascript"></script>
    <script src="https://d3uwcqgr5gxvbk.cloudfront.net/assets/themes/multilotto/js/i18n.min.js?v=f8b360e8ca" type="text/javascript"></script>
    <script src="https://d3uwcqgr5gxvbk.cloudfront.net/assets/themes/multilotto/js/plugins.min.js?v=c0d4821dc2" type="text/javascript"></script>
    <script src="https://d3uwcqgr5gxvbk.cloudfront.net/assets/themes/multilotto/js/main.min.js?v=bd637ffc41" type="text/javascript"></script>
    <script src="https://d3uwcqgr5gxvbk.cloudfront.net/assets/themes/multilotto/js/timeago/jquery.timeago.js" type="text/javascript"></script>
    <script type="text/javascript">
        $.countdown.regional['en'] = {
            labels: ['years', 'months', 'weeks', 'days', 'hours', 'minutes', 'seconds'],
            labels1: ['year', 'month', 'week', 'day', 'hour', 'minute', 'second'],
            compactLabels: ['Å', 'M', 'V', 'D', 'H', 'M', 'S'],
            whichLabels: null,
            timeSeparator: ':',
            isRTL: false
        };
        $.countdown.setDefaults($.countdown.regional['en']);

        $(document).ready(function() {
            Multilotto.init();
        });

    </script>
    <script>var close = document.getElementsByClassName("closebtn");var i;for (i = 0; i < close.length; i++) {close[i].onclick = function(){var div = this.parentElement;div.style.opacity = "0";setTimeout(function(){ div.style.display = "none"; }, 600);}}</script>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>Login</title>
    <meta name="description" content="!">
                            <!-- FB meta -->
    <meta property="og:title" content="">
    <meta property="og:description" content="!">
    <meta property="og:url" content="http://bmbgames.com/login">
    <meta property="og:image" content="https://d3uwcqgr5gxvbk.cloudfront.net/assets/themes/multilotto/img/ml/logo-com-fb.png">
    <meta property="og:site_name" content="Multilotto.com - Play lotto on the world's biggest lotteries!">
    <meta property="og:type" content="website">
    <!-- /FB meta -->
      <link href="css/main.css" rel="stylesheet" media="all" type="text/css" />
      <script>
            var readyStateCheckInterval = setInterval(function() {
                if (document.readyState === 'complete') {
                    clearInterval(readyStateCheckInterval);
                    // document ready
                    var cb = function() {
        };
            var raf = requestAnimationFrame || mozRequestAnimationFrame || webkitRequestAnimationFrame || msRequestAnimationFrame;
            if (raf) raf(cb);
            else window.addEventListener("load", cb);
          }
        }, 100);</script>
      
    <!--[if lt IE 9]>
    <script src="https://d3uwcqgr5gxvbk.cloudfront.net/assets/themes/multilotto/js/dist/html5shim.min.js" type="text/javascript"></script>
    <![endif]-->
    <!-- OneSignal -->
              <!--<script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" async></script>-->
      <script src="vendor/OneSignalSDK.js"></script>
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
          <!-- /OneSignal -->
                        <!--    TrustPilot for langingpages: 2for1 & subscription    -->
        <script type="text/javascript" src="//widget.trustpilot.com/bootstrap/v5/tp.widget.bootstrap.min.js" async></script>
      
      <!-- SaleCycle -->
                  <!-- /SaleCycle -->
    
                <!-- optimizely Tracking -->
          <script src="https://cdn.optimizely.com/js/9268904739.js"></script>
          <!-- CrazyEgg Tracking -->
          <script type="text/javascript" src="//script.crazyegg.com/pages/scripts/0070/4502.js" async="async"></script>
            
  </head>
  <body id="body" class="page lang-en" data-controller="" data-action="">

    <!-- Google Tag Manager (noscript) -
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-KQKFJFL" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    


      <!-- inner wrapper -->
      <div id="wrapper">

                    
        <!-- site notice -->
                  <!-- /site notice -->

        <!-- game notice -->
                  <!-- /game notice -->
<div id="content" class="clearfix">
	
	<section>
		<h2 class="headline1 akz">ورود یا ثبت نام</h2>
		<div class="spacer20 show-desktop"></div>
		<div class="signin-container">

			<div class="column">
				<h3 class="headline2 cblue">ورود</h3>
				<p>اگر قبلا ثبت نام کرده اید لطفا فرم ورود را تکمیل نمایید.</p>

				<div class="box">
					<form method="post">
							<!--	<input type="hidden" name="nonce" value="27edd6fe6930debc54ef79e6e52f15284d4c6606354f9c52eada4774de62ecb70d5b22ff406f6b05cdadaf7e0a515feefbace4c95ecb4e7ee0a1bd634a0fb08c">
		<input type="hidden" name="key" value="eGh3VDF0VkdqRnI1VWVNUVp6MHFzWFFmSVhrRVBHS1lUcFVqaFlxY3hOUFh5YStWRDZUd05SQllSVUIvQXdBWA=="> -->
						<ul class="form-container" dir="rtl">
							<li class="form-row">
                                <div class="form-group inverted">
                                    <input type="text" name="Username" placeholder="نام کاربری" class="field fields s-medium remember" tabindex="1" autocomplete="off" required title="لطفا این فیلد را پر کنید.">
                                </div>
							</li>

							<li class="form-row">
                                <div class="form-group inverted">
                                    <input type="password" name="Password" id="password" placeholder="پسورد" class="field s-medium fields" tabindex="2" required title="لطفا این فیلد را پر کنید.">
                                </div>
							</li>

							<li class="form-row">
								<div class="hidden-mobile" style="width: 100%;">
                                    <p><?php
                                            $msg = new \Model\message();
                                            $msg->msg_session_show();
                                        ?></p>
									<a href="/forgot">آیا پسورد خود را فراموش کرده اید؟</a>
									<!--<button type="submit" name="Submit" class="btn big blue  fright" value="1" tabindex="3">Log In</button>-->
									<input type="submit" name="Login" class="btn blue"  value="ورود" style="padding:6px 50px;margin-right:40px;font-size: 20px;">
								</div>
								<div class="hidden-desktop hidden-tablet">
                                    <input type="submit" name="Login" class="btn btn blue"  value="ورود" tabindex="3" style="padding:14px 50px;margin-left:40px;">
									<p class="center"><a href="/forgot">آیا پسورد خود را فراموش کرده اید؟</a></p>
								</div>
							</li>
						</ul>
					</form>
				</div>

				<div class="spacer20 show-tablet"></div>
			</div>

			<div class="column show-desktop">
				<h3 class="headline2 cblue">کاربر جدید</h3>

				<b style="font-size: 20px;">همین حالا! ثبت نام کنید!</b>

				<div class="hidden-mobile">
					<a href="signup" class="btn huge green">ثبت نام</a>
				</div>

				<div class="hidden-desktop hidden-tablet">
					<a href="signup" class="btn huge full green static">Sign Up</a>
				</div>
			</div>

		</div>
	</div>
</div>

  </div>
  <!-- /inner wrapper -->

    <!--            -->    </body>
</html>

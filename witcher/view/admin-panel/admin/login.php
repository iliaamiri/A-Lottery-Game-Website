<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>ورود</title>
      <link href="images/header-image.png" rel="shortcut icon">
    <!-- Bootstrap -->
    <link href="panel/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="panel/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="panel/vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- Animate.css -->
    <link href="panel/vendors/animate.css/animate.min.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="panel/build/css/custom.min.css" rel="stylesheet">
    <link href="panel/build/css/fonts.css" rel="stylesheet">
      <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Lato">
  </head>

  <body class="login">
    <div>
      <a class="hiddenanchor" id="signup"></a>
      <a class="hiddenanchor" id="signin"></a>

      <div class="login_wrapper">
        <div class="animate form login_form">
          <section class="login_content" dir="rtl">
            <form method="post" style="font-family: 'Lato','yekan';">
              <h1 style="font-family: 'yekan';font-size: 40px;">ورود</h1>
                <?php $message = new \Model\message();$message->msg_session_show(1);?>
              <div>
                <input type="text" class="form-control" placeholder="نام کاربری" required="" name="Username"/>
              </div>
              <div>
                <input type="password" class="form-control" placeholder="پسورد" required="" name="Password"/>
              </div>
              <div>
                <input type="submit" name="Login" class="btn btn-default submit" value="ورود">
                <a class="reset_pass" href="resetpass">پسورد خود را فراموش کردید؟</a>
              </div>

              <div class="clearfix"></div>

              <div class="separator">
                <p class="change_link">New to site?
                  <a href="register" class="to_register"> Create Account </a>
                </p>

                <div class="clearfix"></div>
                <br />

                <div>
                  <h1><a href="http://khakbazproject.ow"><img src="images/logoh.png" alt="" style="height: 100px;"></a></h1>
                  <p dir="ltr">©<?= date('Y')?> All Rights Reserved. Drkhakbaz.ir is a Business Website. Privacy and Terms</p>
                    <p>Powered By EILI</p>
                </div>
              </div>
            </form>
          </section>
        </div>
      </div>
    </div>
  </body>
</html>

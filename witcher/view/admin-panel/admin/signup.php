<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>ثبت نام</title>
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
</head>

<body class="login">
<div>
    <a class="hiddenanchor" id="signup"></a>
    <a class="hiddenanchor" id="signin"></a>

    <div class="login_wrapper">

        <div id="register" class="animate form login_form">
            <section class="login_content" dir="rtl">
                <form method="post">
                    <h1>ثبت نام</h1>
                    <div>
                        <input type="text" class="form-control" placeholder="نام کاربری" required="" name="data[Username]"/>
                    </div>
                    <div>
                        <input type="email" class="form-control" placeholder="ایمیل" required="" name="data[Email]"/>
                    </div>
                    <div>
                        <input type="password" class="form-control" placeholder="پسورد" required="" name="data[Password]"/>
                    </div>
                    <div>
                        <input type="text" class="form-control" placeholder="سن" required="" name="data[Age]"/>
                    </div>
                    <div>
                        <input type="radio" class="" placeholder="" required="" style="display: inline-block;float: left;" name="data[Sex]"/>Male
                        <br>
                        <input type="radio" class="" placeholder="" required="" style="display: inline-block;float: left;" name="data[Sex]"/>Female
                    </div>
                    <div>
                        <input type="submit" name="Signup" class="btn btn-default submit" value="ثبت نام">
                    </div>

                    <div class="clearfix"></div>

                    <div class="separator">
                        <p class="change_link">Already a member ?
                            <a href="login" class="to_register"> Log in </a>
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

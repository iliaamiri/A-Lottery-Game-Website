<?php
    $ticket = new \Controller\ticket();
    $data = $ticket->start();
?>
<html>
<head>
    <title>factor</title>
    <style>
        .alert {direction: rtl!important;font-size:20px;padding: 10px!important;background-color: #f44336;color: white!important;}.closebtn {margin-left: 15px!important;color: white!important;font-weight: bold!important;float: right!important;font-size: 22px!important;line-height: 20px!important;cursor: pointer!important;transition: 0.3s;}.closebtn:hover {color: black;}.alert.success {background-color: #4CAF50;}
        .alert.info {background-color: #2196F3;}
        .alert.warning {background-color: #ff9800;text-align: right;}
    </style>
</head>
<body>
<?php //\Model\message::msg_box_session_show();
\Model\message::msg_box_session_show();
?>
<?php if (isset($data['Factor_info'])){?>
<form method= "post">
    <label>Factor Number : </label><?=$data['Factor_info'][0]['Factor_number']?><br>
    <label>Amount : </label><?=$data['Factor_info'][0]['Amount'] * $data['Comp_Status']['ticket_price']?>تومان
    <br><label>Method : </label><?=$data['Factor_info'][0]['Method']?>
    <br><label>Competition id : </label><?=$data['Factor_info'][0]['Competition_Id']?>
    <br><label>Your Email : </label><?=$data['User_info']['Email']?>
    <br><label>Your Username : </label><?=$data['User_info']['Username']?><Br>
    <input type="submit" value ="تکمیل خرید" name="continue" class="btn btn-success " onclick="this.disabled=true;this.form.submit()"  > 
</form>
<?php }?>
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

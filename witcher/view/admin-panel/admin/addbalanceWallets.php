<?php
$wallet = new \Model\wallet();
$wallet_info = $wallet->GetWalletBy('Wallet_Key',$_GET['wallet_key']);
?>
<form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" method="post">
<div class="form-group">
    <p style="direction: rtl!important;"><?=$wallet_info[0]['Email']?>ایمیل:</p>
    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">First Name <span class="required">*</span>
    </label>
    <div class="col-md-6 col-sm-6 col-xs-12">
        <input type="number" min="0" id="first-name" required="required" class="form-control col-md-7 col-xs-12" placeholder="مقدار را تعیین کنید." name="balance">
    </div>
</div>
    <div class="form-group">
        <div class="col-md-6 col-sm-6 col-xs-12">
            <input type="submit" id="first-name" required="required" class="form-control col-md-7 col-xs-12" placeholder="مقدار را تعیین کنید." name="balance">
        </div>
    </div>
</form>
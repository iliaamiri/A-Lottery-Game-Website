<?php
    $comp = new \Model\competition();
    $payment = new \Model\payment();
    $comp_controller = new \Controller\competition();
    $data = $comp_controller->start("Tickets");
    if (isset($_GET['c'])){
        if ($comp->exists_compet($_GET['c'])){
        $comp_attr = $comp->getFrom_Competition_attributes_by($_GET['c'])[0];
        $comp_info = $comp->getFrom_Competition_tbl_by($_GET['c']);
        $comp_data = array_merge($comp_info,$comp_attr);
?>
<div class="footer-container">
    <div class="column">
        <?php \Model\message::msg_box_session_show();?>
        <br><br><h3 class="headline2 cblue">خرید بلیط</h3>
        <p>با خرید هرچه بیشتر بلیط شانس خود را در مسابقه افزایش دهید.</p>

        <div class="box">
            <form method="post">
                <ul class="form-container" dir="rtl">
                    خرید از طریق
                    <select name="Payment_Method" style="margin-bottom: 10px;border-radius:3px;">
                        <option value="0">WALLET</option>
                        <?php
                            $payment_methods_available = $payment->getPaymentMethodsCatId($comp_data['Competition_Id']);
                                ?>
                                <option value="<?=$payment->getCatBy('Payment_Method',$comp_data['Payment_Methods'])[0]['Cat_id']?>"><?=$comp_data['Payment_Methods']?></option>
                    </select>
                    <li class="form-row">
                        <div class="form-group inverted">
                            <p><b>قیمت هر تیکت: </b><i><?=$comp_data['Tickets_price']?>TOMAN</i></p>
                            <input type="number" min="1" name="Ticket_Num" placeholder="تعداد" class="field fields s-medium remember" style="width: 200px;text-align: center;font-size: 17px;">
                        </div>
                    </li>
                    <li class="form-row">
                        <div class="hidden-mobile" style="width: 100%;">
                            <!--<button type="submit" name="Submit" class="btn big blue  fright" value="1" tabindex="3">Log In</button>-->
                            <input type="submit" name="Submit" class="btn btn green" value="خرید" tabindex="3" style="padding:10px 50px;text-align: center;">
                        </div>

                        <div class="hidden-desktop hidden-tablet">
                            <input type="submit" name="Submit" class="btn btn blue" value="BUY" tabindex="3" style="padding:14px 50px;">
                            <p class="center"><a href="#forgot-password" onclick="clickAndDisable(this)">آیا پسورد خود را فراموش کرده اید؟</a></p>
                        </div>
                    </li>
                </ul>
            </form>
        </div>

        <div class="spacer20 show-tablet"></div>
    </div>

</div>
<?php }}?>

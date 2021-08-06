<?php
/* ALiNezamifar.Com */
if(isset($_POST['price'])){
include_once('lib/nusoap.php');
$terminalId		= "3536778";					// Terminal ID
$userName		= "lian99";					// Username
$userPassword	= "32529262";					// Password
$orderId		= time();						// Order ID
$amount 		= $_POST['price'];						// Price / Rial
$localDate		= date('Ymd');					// Date
$localTime		= date('Gis');					// Time
$additionalData	= '';
$callBackUrl	= "http://ap-lian.ir/mellat/callback.php";	// Callback URL
$payerId		= 0;

//-- تبديل اطلاعات به آرايه براي ارسال به بانک
$parameters = array(
	'terminalId' 		=> $terminalId,
	'userName' 			=> $userName,
	'userPassword' 		=> $userPassword,
	'orderId' 			=> $orderId,
	'amount' 			=> $amount,
	'localDate' 		=> $localDate,
	'localTime' 		=> $localTime,
	'additionalData' 	=> $additionalData,
	'callBackUrl' 		=> $callBackUrl,
	'payerId' 			=> $payerId);

$client = new nusoap_client('https://bpm.shaparak.ir/pgwchannel/services/pgw?wsdl');
$namespace='http://interfaces.core.sw.bps.com/';
$result 	= $client->call('bpPayRequest', $parameters, $namespace);
//-- بررسي وجود خطا
if ($client->fault)
{
	//-- نمايش خطا
	echo "There was a problem connecting to Bank";
	exit;
} 
else
{
	$err = $client->getError();
	if ($err)
	{
		//-- نمايش خطا
		echo "Error : ". $err;
		exit;
	} 
	else
	{
		$res 		= explode (',',$result);
		$ResCode 	= $res[0];
		if ($ResCode == "0")
		{
			//-- انتقال به درگاه پرداخت
			echo '<form name="myform" action="https://bpm.shaparak.ir/pgwchannel/startpay.mellat" method="POST">
					<input type="hidden" id="RefId" name="RefId" value="'. $res[1] .'">
				</form>
				<script type="text/javascript">window.onload = formSubmit; function formSubmit() { document.forms[0].submit(); }</script>';
			exit;
		}
		else
		{
			//-- نمايش خطا
			echo "Error : ". $result;
			exit;
		}
	}
}
}
?>
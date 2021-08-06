<?php
//Prepare data
session_start();
include_once("function.php");

$key="ZRH/7pM08f9CPdPEctRpF3BIFvhAQfid";
$MerchantId="000000140329212";
$TerminalId="24032990";
$Amount=$_GET['amount']."0"; //Rials
$OrderId= rand(10,999999);
$LocalDateTime=date("m/d/Y g:i:s a");
$ReturnUrl="http://ap-lian.ir/sadad/verify.php";
$SignData=encrypt_pkcs7("$TerminalId;$OrderId;$Amount","$key");
$data = array('TerminalId'=>$TerminalId,
              'MerchantId'=>$MerchantId,
              'Amount'=>$Amount,
              'SignData'=> $SignData,
	      'ReturnUrl'=>$ReturnUrl,
	      'LocalDateTime'=>$LocalDateTime,
	      'OrderId'=>$OrderId);
$str_data = json_encode($data);
$res=CallAPI('https://sadad.shaparak.ir/vpg/api/v0/Request/PaymentRequest',$str_data);
$arrres=json_decode($res);
if($arrres->ResCode==0)
{
	$Token= $arrres->Token;
	$url="https://sadad.shaparak.ir/VPG/Purchase?Token=$Token";
	header("Location:$url");
}
else
	die($arrres->Description);


?>
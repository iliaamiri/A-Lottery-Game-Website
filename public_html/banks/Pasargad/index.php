<?php 
require_once("RSAProcessor.class.php"); 

$processor = new RSAProcessor("certificate.xml",RSAKeyType::XMLFile);
$merchantCode = 4438078; // كد پذيرنده
$terminalCode = 1615355; // كد ترمينال
$amount = 1000000; // مبلغ فاكتور
$redirectAddress = "http://ap-lian.ir/pasargad/getresult.php"; 

$invoiceNumber = 102; //شماره فاكتور
$timeStamp = date("Y/m/d H:i:s");
$invoiceDate = date("Y/m/d H:i:s"); //تاريخ فاكتور
$action = "1003"; 	// 1003 : براي درخواست خريد 
$data = "#". $merchantCode ."#". $terminalCode ."#". $invoiceNumber ."#". $invoiceDate ."#". $amount ."#". $redirectAddress ."#". $action ."#". $timeStamp ."#";
$data = sha1($data,true);
$data =  $processor->sign($data); // امضاي ديجيتال 
$result =  base64_encode($data); // base64_encode 
?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
  <head>
  </head>
  <body>

<form Id='Form2' Method='post' Action='https://pep.shaparak.ir/gateway.aspx'>
	invoiceNumber<input type='text' name='invoiceNumber' value='<?= $invoiceNumber ?>' /><br />
	invoiceDate<input type='text' name='invoiceDate' value='<?= $invoiceDate ?>' /><br />
	amount<input type='text' name='amount' value='<?= $amount ?>' /><br />
	terminalCode<input type='text' name='terminalCode' value='<?= $terminalCode ?>' /><br />
	merchantCode<input type='text' name='merchantCode' value='<?= $merchantCode ?>' /><br />
	redirectAddress<input type='text' name='redirectAddress' value='<?= $redirectAddress ?>' /><br />
	timeStamp<input type='text' name='timeStamp' value='<?= $timeStamp ?>' /><br />
	action<input type='text' name='action' value='<?= $action ?>' /><br />
	sign<input type='text' name='sign' value='<?= $result ?>' /><br />
	<input type='submit' name='submit' value='Checkout' />
</form>
  </body>
</html>

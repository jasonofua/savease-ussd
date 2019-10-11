<?php
require 'vendor/autoload.php';
use GuzzleHttp\Client;
// use GuzzleHttp\Client;
// use GuzzleHttp\Psr7\Request;
// Reads the variables sent via POST from our gateway
$sessionId   = $_POST["sessionId"];
$serviceCode = $_POST["serviceCode"];
$phoneNumber = $_POST["phoneNumber"];
$text        = $_POST["text"];
$str_arr = explode ("*", $text);
$num = count($str_arr);
$userResponse=trim(end($str_arr));

$str2 = substr($phoneNumber, 4);
$newString = $str2.substr(0, 3) + "XXXX" + $str2.substr(3+4);
$client = new \GuzzleHttp\Client();

if ($text == ""){
    $response  = "CON What would you want to do \n";
    $response .= "1. Verify Voucher \n";
    $response .= "2. Get Balance \n";
    $response .= "3. Make Deposit \n";
    $response .= "4. Transfer Funds \n";
}else if($text == "1"){
    $response  = "CON Enter Voucher Pin";    
}else if($num >= 2){

if($str_arr[0] == "1"){
    require_once('../lib/nusoap.php');
        $wsdl   = "http://savease.ng/webservice1.asmx?wsdl";
        $client = new nusoap_client($wsdl, 'wsdl');
        $error = $client->getError();
	if ($error)
	{
		echo $error; die();
	}
    $action = "VerifyPin";
    $result = array();
	if (isset($action))
	{
		$result['response'] = $client->call($action,array("inputParame"=>$str_arr[1]));
	}
        $response = "END ".$result['response']['VerifyPinResult'];  
}else if ($str_arr[0] == "3"){

    if ($num == 2){
        if ($str_arr[1] == "1"){
            $response = "CON Enter voucher pin and narration seperated by a comma (,) ";
    
        }else{
            $response = "CON Enter the reciever account number and voucher pin and narration seperated by a comma (,) ";
        }
    }else if ($num >2 && $str_arr[1] == "1"){
        $str_arrDeposit = explode (",", $str_arr[2]);
        require_once('../lib/nusoap.php');
        $wsdl   = "http://savease.ng/webservice1.asmx?wsdl";
        $client = new nusoap_client($wsdl, 'wsdl');
        $error = $client->getError();
	if ($error)
	{
		echo $error; die();
	}
    $action = "saveDepositUSSD";
    $result = array();
	if (isset($action))
	{
		$result['response'] = $client->call($action,array("in_acctNo"=>$str2,"in_cardpin"=>$str_arrDeposit[0],"in_naration"=>$str_arrDeposit[1]));
    }
   
    if ($result['response']['saveDepositUSSDResult'] == 1){

        $responses = $client->post('https://www.bulksmsnigeria.com/api/v1/sms/create?api_token=9Pc1XtdCYg43wdJ6AlbCSCyTlLqc2voEFpl9DvmUq0zcKJTDbdE4aOYOPtzz&from=SAVEASE&to='.$phoneNumber.'&body=Your Acct Has Been Credited  By SAVEASE DEPOSIT - (Transaction Ref)CR&dnd=2');
   // $url = "https://www.bulksmsnigeria.com/api/v1/sms/create?api_token=9Pc1XtdCYg43wdJ6AlbCSCyTlLqc2voEFpl9DvmUq0zcKJTDbdE4aOYOPtzz&from=SAVEASE&to=".$phoneNumber."&body=Your Acct Has Been Credited  By SAVEASE DEPOSIT - (Transaction Ref)CR&dnd=2";

  

        $response = "END Your deposit was successful. ".$responses;
    
         
    }else{
        $response = "END Your deposit was unsuccessful. "; 
    }
        

    }else {
        $str_arrDeposit = explode (",", $str_arr[2]);

       // $response = "END Your details ".$str_arrDeposit[1]; 

        require_once('../lib/nusoap.php');
        $wsdl   = "http://savease.ng/webservice1.asmx?wsdl";
        $client = new nusoap_client($wsdl, 'wsdl');
        $error = $client->getError();
	if ($error)
	{
		echo $error; die();
	}
    $action = "saveDepositUSSD";
    $result = array();
	if (isset($action))
	{
		$result['response'] = $client->call($action,array("in_acctNo"=>$str_arrDeposit[0],"in_cardpin"=>$str_arrDeposit[1],"in_naration"=>$str_arrDeposit[2]));
    }
    
    if ($result['response']['saveDepositUSSDResult'] == 1){
        $response = "END Your deposit was successful. "; 
    }else{
        $response = "END Your deposit was unsuccessful. "; 
    }
        
    }

    

}else if ($str_arr[0] == "4"){
    if ($num == 2){

        require_once('../lib/nusoap.php');
        $wsdl   = "http://savease.ng/webservice1.asmx?wsdl";
        $client = new nusoap_client($wsdl, 'wsdl');
        $error = $client->getError();
	if ($error)
	{
		echo $error; die();
	}
    $action = "getNameOnDeposit";
    $result = array();
	if (isset($action))
	{
		$result['response'] = $client->call($action,array("in_saveaseid"=>$str_arr[1]));
	}
        $response = "CON  You are about to transfer funds to ".$result['response']['getNameOnDepositResult']."  Enter the amount, narration and your pin all seperated by a comma (,)";  



    }else if ($num > 2){
          $str_arrTransfer = explode (",", $str_arr[2]);

        require_once('../lib/nusoap.php');
        $wsdl   = "http://savease.ng/webservice1.asmx?wsdl";
        $client = new nusoap_client($wsdl, 'wsdl');
        $error = $client->getError();
	if ($error)
	{
		echo $error; die();
	}
    $action = "transferFundUSSD";
    $result = array();
	if (isset($action))
	{
		$result['response'] = $client->call($action,array("amountTransfered"=>$str_arrTransfer[0],"beneficiaryAccount"=>$str_arr[1],"saveaseid"=>$str2,"in_naration"=>$str_arrTransfer[1],"userpin"=>$str_arrTransfer[2]));
    }
    
    if ($result['response']['transferFundUSSDResult'] == 1){
        $response = "END Your transfer was successful. "; 
    }else if ($result['response']['transferFundUSSDResult'] == 0){
        $response = "END Your transfer was unsuccessful. "; 
    }else if ($result['response']['transferFundUSSDResult'] == 2){
        $response = "END Invalid Pin ";
    }else if ($result['response']['transferFundUSSDResult'] == 3){
        $response = "END Insuffiecient balance ";
    }

    }

}
    
}else if ($text == "2"){
    require_once('../lib/nusoap.php');
        $wsdl   = "http://savease.ng/webservice1.asmx?wsdl";
        $client = new nusoap_client($wsdl, 'wsdl');
        $error = $client->getError();
	if ($error)
	{
		echo $error; die();
	}
    $action = "getBalz";
    $result = array();
	if (isset($action))
	{
		$result['response'] = $client->call($action,array("saveaseID"=>$str2));
	}
        $response = "END Your Savease account is : N ".$result['response']['getBalzResult'];  
}else if ($text == "3") {
    $response  = "CON Select Account Type \n";
    $response .= "1. Self \n";
    $response .= "2. Savease Account \n";
}else if ($text == "4"){
    $response = "CON Enter reciever account number ";

}

// Echo the response back to the API
header('Content-type: text/plain');
echo $response;

?>

<?php
require_once('../lib/nusoap.php');

// Reads the variables sent via POST from our gateway
$sessionId   = $_POST["sessionId"];
$serviceCode = $_POST["serviceCode"];
$phoneNumber = $_POST["phoneNumber"];
$text        = $_POST["text"];

if ($text == ""){
    $response  = "CON What would you want to do \n";
    $response .= "1. Verify Voucher \n";
    $response .= "2. My phone number";
}else{
    $str_arr = explode ("*", $text);
    $num = count($str_arr);
    
    if($num = 1 && $str_arr[0] == "1"){
        $response  = "CON Enter Voucher Pin";

    }

    if($num = 2 && $str_arr[0] == "1"){
        $wsdl   = "http://savease.ng/webservice1.asmx?wsdl";
        $client = new nusoap_client($wsdl, 'wsdl');

        $error = $client->getError();

        $json	  = '{"inputParame":'. $str_arr[2] . '}';
	
	if ($error)
	{
		echo $error; die();
	}
	
    $action = "VerifyPin";
    
    $result = array();

	if (isset($action))
	{
		$result['response'] = $client->call($action, "");
	}
    echo $result['response']['VerifyPinResult'];


        $response = "".$result['response']['VerifyPinResult'];

    }





    
}



// Echo the response back to the API
header('Content-type: text/plain');
echo $response;

?>

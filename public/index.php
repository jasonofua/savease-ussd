<?php


// Reads the variables sent via POST from our gateway
$sessionId   = $_POST["sessionId"];
$serviceCode = $_POST["serviceCode"];
$phoneNumber = $_POST["phoneNumber"];
$text        = $_POST["text"];
$str_arr = explode ("*", $text);
$num = count($str_arr);
$userResponse=trim(end($str_arr));

if ($text == ""){
    $response  = "CON What would you want to do \n";
    $response .= "1. Verify Voucher \n";
    $response .= "2. My phone number";
}else if($text == "1"){
    $response  = "CON Enter Voucher Pin".$userResponse;

    
}else if($num == 2){

if($str_arr[0] == "1"){
    require_once('../lib/nusoap.php');
        $wsdl   = "http://savease.ng/webservice1.asmx?wsdl";
        $client = new nusoap_client($wsdl, 'wsdl');

        $error = $client->getError();

        $json	  = '{"inputParame":123456780975}';
	
	if ($error)
	{
		echo $error; die();
	}
	
    $action = "VerifyPin";
    
    $result = array();

	if (isset($action))
	{
		$result['response'] = $client->call($action, $json);
	}

        $response = "END".$result['response']['VerifyPinResult'];
   
}
    
    
}



// Echo the response back to the API
header('Content-type: text/plain');
echo $response;

?>

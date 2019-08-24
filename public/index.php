<?php
require_once('../lib/nusoap.php');


$wsdl   = "http://savease.ng/webservice1.asmx?wsdl";
$client = new nusoap_client($wsdl, 'wsdl');

$error = $client->getError();

$json	  = '{"inputParame":"1234567898765"}';
	
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
// Reads the variables sent via POST from our gateway
    echo $result['response']['VerifyPinResult'];


    echo "<h3>Output : </h3>";
	echo $result['response'];
	echo "<h2>Request</h2>";
	echo "<pre>" . htmlspecialchars($client->request, ENT_QUOTES) . "</pre>";
	echo "<h2>Response</h2>";
	echo "<pre>" . htmlspecialchars($client->response, ENT_QUOTES) . "</pre>";

    ?>


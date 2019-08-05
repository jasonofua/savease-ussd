<?php
// Reads the variables sent via POST from our gateway
    $config = new SoapClient("http://savease.ng/webservice1.asmx?wsdl");

$sessionId   = $_POST["sessionId"];
$serviceCode = $_POST["serviceCode"];
$phoneNumber = $_POST["phoneNumber"];
$text        = $_POST["text"];
$textValue   = explode ("*", $text);
$level = count($textValue);

if ($text == "") {
    // This is the first request. Note how we start the response with CON
    $response  = "CON What would you want to do \n";
    $response .= "1. Verify Pin \n";
    $response .= "2. Register \n";
    $response .= "3. Account Balance \n";
    $response .= "4. Make Deposit \n";
    $response .= "5. Transfer \n";
    $response .= "6. Withdraw fund \n";
    $response .= "7. Buy Pin ";

} 

// Echo the response back to the API
header('Content-type: text/plain');
echo $response;
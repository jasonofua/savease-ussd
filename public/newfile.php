<?php
// Reads the variables sent via POST from our gateway
    $config = new SoapClient("http://savease.ng/webservice1.asmx?wsdl");

$sessionId   = $_POST["sessionId"];
$serviceCode = $_POST["serviceCode"];
$phoneNumber = $_POST["phoneNumber"];
$text        = $_POST["text"];
$textValue   = explode ("*", $text);
$level = count($textValue);




// Echo the response back to the API
header('Content-type: text/plain');
echo $level;
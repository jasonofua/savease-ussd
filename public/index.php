<?php

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
    $response  = "CON What would you want to do".$str_arr[0];
}



// Echo the response back to the API
header('Content-type: text/plain');
echo $response;

?>

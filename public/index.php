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
    $userResponse=trim(end($str_arr));

    if($num = 1 && $str_arr[0] == "1"){
        $response  = "CON Enter Voucher Pin".$userResponse;

    }else {
        $response  = "CON next".$userResponse;
    }

    
}



// Echo the response back to the API
header('Content-type: text/plain');
echo $response;

?>

<?php
// Reads the variables sent via POST from our gateway
$sessionId   = $_POST["sessionId"];
$serviceCode = $_POST["serviceCode"];
$phoneNumber = $_POST["phoneNumber"];
$text        = $_POST["text"];

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

} else if ($text == "1") {
    // Business logic for first level response
    $response = "CON Enter Voucher Pin \n";
   

} else if ($text == "2") {
    // Business logic for first level response
    // This is a terminal request. Note how we start the response with END
    $response = "END Registering with phone number ";

}else if ($text == "3") {
    // Business logic for first level response
    $balance  = "KES 10,000";

    // This is a terminal request. Note how we start the response with END
    $response = "END Your balance is ".$balance;
   

} else if ($text == "4") {
    // Business logic for first level response
    // This is a terminal request. Note how we start the response with END
    $response  = "CON Enter Deposit Type \n";
    $response .= "1. Self Deposit \n";
    $response .= "2. Savease Wallet";

}else if ($text == "5") {
    // Business logic for first level response
    $response  = "CON Enter Transfer Type \n";
    $response .= "1. Savease Wallet \n";

   

} else if ($text == "6") {
    // Business logic for first level response
    // This is a terminal request. Note how we start the response with END
    $response  = "CON Enter Bank name \n";
    
}else if ($text == "7") {
    // Business logic for first level response
    $response = "CON Enter Voucher amount \n";
   

} else if($text == "1*1") { 
    // This is a second level response where the user selected 1 in the first instance
    $accountNumber  = "ACC1001";

    // This is a terminal request. Note how we start the response with END
    $response = "END Your account number is ".$accountNumber;

} else if ( $text == "1*2" ) {
    // This is a second level response where the user selected 1 in the first instance
    $balance  = "KES 10,000";

    // This is a terminal request. Note how we start the response with END
    $response = "END Your balance is ".$balance;
}

// Echo the response back to the API
header('Content-type: text/plain');
echo $response;
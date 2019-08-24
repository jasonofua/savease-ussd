<?php
// Reads the variables sent via POST from our gateway
    $config = new SoapClient("http://savease.ng/webservice1.asmx?wsdl");
    $result = $config->__soapCall('VerifyPin', array('inputParame' => "1234567898765"));
    var_dump($result);




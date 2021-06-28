
<?php
    // Receive JSON
    $request = file_get_contents("php://input");

    // Decode JSON
    $request = json_decode($request, true);

    // Log parameters to a file
    file_put_contents("ipnlog.txt", "id:" . $request["id"] . " action:" . $request["action"] . " timestamp:" . $request["timestamp"] . " type:" . $request["type"] . " binancecoinaddress:" . $request["binancecoinaddress"] . " contractaddress:" . $request["contractaddress"] . " amount:" . $request["amount"] . "\r\n", FILE_APPEND);

    // Tell API that the IPN has been received successfully. This is very important! Otherwise you will receive notifications 10 times for every deposit.
    header("Content-Type: application/json");
    $response = ["ok" => true];
    $response = json_encode($response);
    echo $response;
?>


<?php
# ----- REPLACE THE VARIABLES BELOW WITH YOUR DATA -----
$apikey = "6a93f7a23ca71b3a6e505dcf643ab00b0bc058eb"; // API Key in your account panel
$contractaddress = "CONTRACTADDRESS"; // Smart contract address of the Token
$from = "SENDERADDRESS"; // Binancecoin address you want to send from (must have been created with Chaingateway.io)
$to = "RECEIVERADDRESS"; // Receiving Binancecoin address
$password = "PASSWORD"; // Password of the Binancecoin address (which you specified when you created the address)
$amount = "55.89"; // Amount of Tokens to send
# -------------------------------------------------------

# Define function endpoint
$ch = curl_init("https://eu.bsc.chaingateway.io/v1/sendToken");

# Setup request to send json via POST. This is where all parameters should be entered.
$payload = json_encode( array("contractaddress" => $contractaddress, "from" => $from, "to" => $to, "password" => $password, "amount" => $amount) );
curl_setopt( $ch, CURLOPT_POSTFIELDS, $payload );
curl_setopt( $ch, CURLOPT_HTTPHEADER, array("Content-Type:application/json", "Authorization: " . $apikey));

# Return response instead of printing.
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );

# Send request.
$result = curl_exec($ch);
curl_close($ch);

# Decode the received JSON string
$resultdecoded = json_decode($result, true);

# Print the transaction id of the transaction
echo $resultdecoded["txid"];
?>

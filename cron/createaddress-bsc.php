
<?php
# ----- REPLACE THE VARIABLES BELOW WITH YOUR DATA -----
$apikey = "6a93f7a23ca71b3a6e505dcf643ab00b0bc058eb"; // API Key in your account panel
$password = '0c28d1a3d3103ae041d3fc3dfd0c367a7c080a11'; // Secure password for the Ethereum address you are creating
# -------------------------------------------------------


# Define function endpoint
$ch = curl_init("https://eu.bsc.chaingateway.io/v1/newAddress");

# Setup request to send json via POST. This is where all parameters should be entered.
$payload = json_encode( array("password" => $password) );
curl_setopt( $ch, CURLOPT_POSTFIELDS, $payload );
curl_setopt( $ch, CURLOPT_HTTPHEADER, array("Content-Type:application/json", "Authorization: " . $apikey));

# Return response instead of printing.
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
# Send request.
$result = curl_exec($ch);
curl_close($ch);
// # Decode the received JSON string
$resultdecoded = json_decode($result, true);

// # Print the new generated address to the screen
echo $resultdecoded["binancecoinaddress"];
// return true;
?>

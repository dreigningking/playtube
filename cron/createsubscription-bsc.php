
<?php
# ----- REPLACE THE VARIABLES BELOW WITH YOUR DATA -----
$apikey = "85e75eba20fa32fcb95a56c23cb6254bcadf8c09"; // API Key in your account panel
$contractaddress = "0xc4d256be28aa38c02c7c249d50d48749cc5c6c7a"; // Contract address of the token you want to watch
$binancecoinaddress = "0xe03ea6db7A825d211D82e4146ff8cDa35c626928"; // Binancecoin address you want to watch
$url = "https://tube.exenox.tech/cron/ipnreceiver.php"; // URL where you want to receive updates
# -------------------------------------------------------


# Define function endpoint
$ch = curl_init("https://eu.bsc.chaingateway.io/v1/subscribeAddress");

# Setup request to send json via POST. This is where all parameters should be entered.
$payload = json_encode( array("contractaddress" => $contractaddress, "binancecoinaddress" => $binancecoinaddress, "url" => $url) );
curl_setopt( $ch, CURLOPT_POSTFIELDS, $payload );
curl_setopt( $ch, CURLOPT_HTTPHEADER, array("Content-Type:application/json", "Authorization: " . $apikey));

# Return response instead of printing.
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );

# Send request.
$result = curl_exec($ch);
curl_close($ch);

# Decode the received JSON string
$resultdecoded = json_decode($result, true);

# Print status of request (should be true if it worked)
echo $resultdecoded["ok"];
?>

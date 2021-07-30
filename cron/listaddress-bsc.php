
<?php
# ----- REPLACE THE VARIABLES BELOW WITH YOUR DATA -----
$apikey = "85e75eba20fa32fcb95a56c23cb6254bcadf8c09"; // API Key in your account panel
# -------------------------------------------------------


# Define function endpoint
$ch = curl_init("https://eu.bsc.chaingateway.io/v1/listAddresses");

curl_setopt( $ch, CURLOPT_HTTPHEADER, array("Content-Type:application/json", "Authorization: " . $apikey));

# Return response instead of printing.
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );

# Send request.
$result = curl_exec($ch);
curl_close($ch);

# Decode the received JSON string
// $resultdecoded = json_decode($result, true);

# Print the new generated address to the screen
echo $result;
?>


<?php
// require '../assets/includes/functions_general.php';
require '../assets/includes/functions_general.php';
require '../assets/includes/tables.php';
require '../config.php';

    // Receive JSON
   // $request = file_get_contents("php://input");
    $result = ['id' => 345,'action'=>'deposit', 'timestamp'=>'2021-07-01 22:50:45' ,'type'=>'BEP-20' ,'binancecoinaddress'=>'0xe03ea6db7A825d211D82e4146ff8cDa35c626928', 'contractaddress'=>'0xc4d256be28aa38c02c7c249d50d48749cc5c6c7a','from'=>"0x33d5a7f388b1aa58a935ece946cb45cfc8505bdf", 'amount'=>'500.000000000000000000'];
    $request = json_encode($result);
    // Decode JSON
    $request = json_decode($request, true);

    // Log parameters to a file
    // file_put_contents("ipnlog.txt", "id:" . $request["id"] . " action:" . $request["action"] . " timestamp:" . $request["timestamp"] . " type:" . $request["type"] . " binancecoinaddress:" . $request["binancecoinaddress"] . " contractaddress:" . $request["contractaddress"] . " amount:" . $request["amount"] . "\r\n", FILE_APPEND);
    // file_put_contents("ipnlog.txt", print_r($request,true). "\r\n", FILE_APPEND);
    
    $mysqli     = new mysqli($sql_db_host, $sql_db_user, $sql_db_pass, $sql_db_name);
    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }
    $sql = "SELECT * FROM ".T_TOKEN_TRANS." WHERE `id`=1";
    if ($mysqli->query($sql) === TRUE) {
        echo "New searched successfully";
      } else {
        echo "Error: " . $sql . "<br>" . $mysqli->error;
      }
      
      $mysqli->close();
    // Tell API that the IPN has been received successfully. This is very important! Otherwise you will receive notifications 10 times for every deposit.
    header("Content-Type: application/json");
    $response = ["ok" => true];
    $response = json_encode($response);
    echo $response;
?>

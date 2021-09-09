
<?php

require_once('./assets/init.php');
// echo "helloworld";
//$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

$payments  = $db->where('status',['waiting','confirming','confirmed','sending','partially_paid',''] , 'IN')->get(T_NOW_PAYMENTS);
foreach($payments as $payment){
     
    // SEND STATUS REQUEST
    $url = "https://api.nowpayments.io/v1/payment/$payment->payment_id";

    $ch = curl_init();  
 
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
    // curl_setopt($ch, CURLOPT_HTTPHEADER, array('x-api-key: V6A763W-XZF46J5-PQJBGQN-3H97ESP','Content-Type: application/json')); 
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('x-api-key: A7M40XV-CG1448Z-KVVED3G-NW3V0TK','Content-Type: application/json')); 
    $result = curl_exec($ch);
    curl_close($ch);
   /// DECODE REQUEST
    $obj = json_decode($result);
    $db->where('payment_id',$payment->payment_id)->update(T_NOW_PAYMENTS,array(
        'status' => $obj->payment_status
    )); 
    if($obj->payment_status == "finished" && $obj->actually_paid != 0){
        $user = $db->where('id',$payment->user_id)->getOne(T_USERS);
        $newbalance = $user->balance + $obj->actually_paid;
        $db->where('payment_id',$payment->payment_id)->update(T_USERS,array(
            'balance' => $newbalance
        )); 
    }

}
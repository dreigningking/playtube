<?php 
if (IS_LOGGED == false) {
    $data = array(
        'status' => 400,
        'error' => 'Not logged in'
    );
    echo json_encode($data);
    exit();
}




if (!empty($_GET['type']) && $_GET['type'] == 'token-address-create') {
	$user = $db->where('id',$pt->user->id)->where('active',1)->getOne(T_USERS);
	$password = $user->password;
	$response = require './cron/createaddress-bsc.php';
	if($response){
		//$created = $db->where('id',$user->id)->update(T_USERS,array('crypto_wallet_address' => $result,'crypto_wallet_secret'=> $user->password));
		$data['status'] = 200;
	}else{
		$data = array(
			'status' => 400,
			'error' => 'Something bad happened'
		);
	}
	$data['result'] = $response;
	header("Content-type: application/json");
	echo json_encode($data);
	exit();
	
}



//Manage pro system from admin side

// if (PT_IsAdmin() && !empty($_GET['first'])) {
// 	if ($_GET['first'] == 'remove_expired') {
// 		$data['status'] = 400;
// 		$expired_subs   = $db->where('expire',time(),'<')->get(T_PAYMENTS);
// 		$update         = array('is_pro' => 0,'verified' => 0);
// 		foreach ($expired_subs as $subscriber){
// 			$db->where('id',$subscriber->user_id)->update(T_USERS,$update);
// 			$db->where('user_id',$subscriber->user_id)->update(T_VIDEOS,array('featured' => 0));
// 		}
// 		$data['status'] = 200;
// 	}
// }



// if ($first == 'paystack') {

// 	if (!empty($_POST['email']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
// 		$price = $sum * 100;

// 		$callback_url = PT_Link("aj/go_pro/paystack_paid?amount=".$price);
// 		$result = array();
// 	    $reference = uniqid();

// 		//Set other parameters as keys in the $postdata array
// 		$postdata =  array('email' => $_POST['email'], 'amount' => $price,"reference" => $reference,'callback_url' => $callback_url);
// 		$url = "https://api.paystack.co/transaction/initialize";

// 		$ch = curl_init();
// 		curl_setopt($ch, CURLOPT_URL,$url);
// 		curl_setopt($ch, CURLOPT_POST, 1);
// 		curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($postdata));  //Post Fields
// 		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// 		$headers = [
// 		  'Authorization: Bearer '.$pt->config->paystack_secret_key,
// 		  'Content-Type: application/json',

// 		];
// 		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

// 		$request = curl_exec ($ch);

// 		curl_close ($ch);

// 		if ($request) {
// 		    $result = json_decode($request, true);
// 		    if (!empty($result)) {
// 				 if (!empty($result['status']) && $result['status'] == 1 && !empty($result['data']) && !empty($result['data']['authorization_url']) && !empty($result['data']['access_code'])) {
// 				 	$db->where('id',$pt->user->id)->update(T_USERS,array('paystack_ref' => $reference));
// 				  	$data['status'] = 200;
// 				  	$data['url'] = $result['data']['authorization_url'];
// 				}
// 				else{
// 			        $data['message'] = $result['message'];
// 				}
// 			}
// 			else{
// 				$data['message'] = $lang->error_msg;
// 			}
// 		}
// 		else{
// 			$data['message'] = $lang->error_msg;
// 		}
// 	}
// 	else{
// 		$data['message'] = $lang->please_check_details;
// 	}
// }
// if ($first == 'paystack_paid') {
// 	$payment  = CheckPaystackPayment($_GET['reference']);
// 	if ($payment) {

// 		$update = array('is_pro' => 1,'verified' => 1);
// 	    $go_pro = $db->where('id',$pt->user->id)->update(T_USERS,$update);
// 	    if ($go_pro === true) {
// 	    	$payment_data         = array(
// 	    		'user_id' => $pt->user->id,
// 	    		'type'    => 'pro',
// 	    		'amount'  => $sum,
// 	    		'date'    => date('n') . '/' . date('Y'),
// 	    		'expire'  => strtotime("+30 days")
// 	    	);

// 	    	$db->insert(T_PAYMENTS,$payment_data);
// 	    	$db->where('user_id',$pt->user->id)->update(T_VIDEOS,array('featured' => 1));
// 	    	$_SESSION['upgraded'] = true;
// 	    	header('Location: ' . PT_Link('go_pro'));
// 	    	exit();
// 	    }
// 	    else{
// 	    	header('Location: ' . PT_Link('go_pro'));
// 	    	exit();
// 	    }
//     } else {
//         header('Location: ' . PT_Link('go_pro'));
// 	    exit();
//     }
// }
// if ($first == 'paystack_pay_to_see') {
// 	if (!empty($_POST['video_id']) && is_numeric($_POST['video_id'])) {
// 		$video = PT_GetVideoByID($_POST['video_id'], 0,0,2);
// 		if (!empty($video)) {
// 			$text = "";
// 			if (!empty($_POST['pay_type']) && $_POST['pay_type'] == 'rent' && !empty($video->rent_price)) {
// 				$total = $video->rent_price;
// 				$text = "&pay_type=rent";
// 			}
// 			else{
// 				$total = $video->sell_video;
// 			}
// 			$price = $total * 100;

// 			$callback_url = PT_Link("aj/go_pro/paystack_paid_to_see?video_id=".$video->id.$text);
// 			$result = array();
// 		    $reference = uniqid();

// 			//Set other parameters as keys in the $postdata array
// 			$postdata =  array('email' => $_POST['email'], 'amount' => $price,"reference" => $reference,'callback_url' => $callback_url);
// 			$url = "https://api.paystack.co/transaction/initialize";

// 			$ch = curl_init();
// 			curl_setopt($ch, CURLOPT_URL,$url);
// 			curl_setopt($ch, CURLOPT_POST, 1);
// 			curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($postdata));  //Post Fields
// 			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// 			$headers = [
// 			  'Authorization: Bearer '.$pt->config->paystack_secret_key,
// 			  'Content-Type: application/json',

// 			];
// 			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

// 			$request = curl_exec ($ch);

// 			curl_close ($ch);

// 			if ($request) {
// 			    $result = json_decode($request, true);
// 			    if (!empty($result)) {
// 					 if (!empty($result['status']) && $result['status'] == 1 && !empty($result['data']) && !empty($result['data']['authorization_url']) && !empty($result['data']['access_code'])) {
// 					 	$db->where('id',$pt->user->id)->update(T_USERS,array('paystack_ref' => $reference));
// 					  	$data['status'] = 200;
// 					  	$data['url'] = $result['data']['authorization_url'];
// 					}
// 					else{
// 				        $data['message'] = $result['message'];
// 					}
// 				}
// 				else{
// 					$data['message'] = $lang->error_msg;
// 				}
// 			}
// 			else{
// 				$data['message'] = $lang->error_msg;
// 			}
// 		}
// 		else{
// 			$data['message'] = $lang->error_msg;
// 		}
// 	}
// 	else{
// 		$data['message'] = $lang->error_msg;
// 	}
// }
// if ($first == 'paystack_paid_to_see') {
// 	$data['status'] = 500;
// 	$video_id       = (!empty($_GET['video_id']) && is_numeric($_GET['video_id'])) ? PT_Secure($_GET['video_id']) : 0;

//     if (!empty($video_id)) {
//     	$video = PT_GetVideoByID($video_id, 0,0,2);
//     	if (!empty($video)) {
//     		$payment  = CheckPaystackPayment($_GET['reference']);
// 			if ($payment) {

// 				$notify_sent = false;
// 	    		if (!empty($video->is_movie)) {

// 	    			$payment_data         = array(
// 			    		'user_id' => $video->user_id,
// 			    		'video_id'    => $video->id,
// 			    		'paid_id'  => $pt->user->id,
// 			    		'admin_com'    => 0,
// 			    		'currency'    => $paypal_currency,
// 			    		'time'  => time()
// 			    	);
// 			    	if (!empty($_GET['pay_type']) && $_GET['pay_type'] == 'rent') {
// 		    			$payment_data['type'] = 'rent';
// 		    			$total = $video->rent_price;
// 		    		}
// 		    		else{
// 		    			$total = $video->sell_video;
// 		    		}
// 		    		$payment_data['amount'] = $total;
// 		    		$db->insert(T_VIDEOS_TRSNS,$payment_data);
// 	    		}
// 	    		else{

// 		    		if (!empty($_GET['pay_type']) && $_GET['pay_type'] == 'rent') {
// 		    			$admin__com = $pt->config->admin_com_rent_videos;
// 			    		if ($pt->config->com_type == 1) {
// 			    			$admin__com = ($pt->config->admin_com_rent_videos * $video->rent_price)/100;
// 			    			$paypal_currency = $paypal_currency.'_PERCENT';
// 			    		}
// 			    		$payment_data         = array(
// 				    		'user_id' => $video->user_id,
// 				    		'video_id'    => $video->id,
// 				    		'paid_id'  => $pt->user->id,
// 				    		'amount'    => $video->rent_price,
// 				    		'admin_com'    => $pt->config->admin_com_rent_videos,
// 				    		'currency'    => $paypal_currency,
// 				    		'time'  => time(),
// 				    		'type' => 'rent'
// 				    	);
// 				    	$balance = $video->rent_price - $admin__com;
// 		    		}
// 		    		else{
// 		    			$admin__com = $pt->config->admin_com_sell_videos;
// 			    		if ($pt->config->com_type == 1) {
// 			    			$admin__com = ($pt->config->admin_com_sell_videos * $video->sell_video)/100;
// 			    			$paypal_currency = $paypal_currency.'_PERCENT';
// 			    		}

// 			    		$payment_data         = array(
// 				    		'user_id' => $video->user_id,
// 				    		'video_id'    => $video->id,
// 				    		'paid_id'  => $pt->user->id,
// 				    		'amount'    => $video->sell_video,
// 				    		'admin_com'    => $pt->config->admin_com_sell_videos,
// 				    		'currency'    => $paypal_currency,
// 				    		'time'  => time()
// 				    	);
// 				    	$balance = $video->sell_video - $admin__com;

// 		    		}
			    		
// 			    	$db->insert(T_VIDEOS_TRSNS,$payment_data);
			    	
// 			    	$db->rawQuery("UPDATE ".T_USERS." SET `balance` = `balance`+ '".$balance."' , `verified` = 1 WHERE `id` = '".$video->user_id."'");
// 			    }
// 			    if ($notify_sent == false) {
// 			    	$uniq_id = $video->video_id;
// 	                $notif_data = array(
// 	                    'notifier_id' => $pt->user->id,
// 	                    'recipient_id' => $video->user_id,
// 	                    'type' => 'paid_to_see',
// 	                    'url' => "watch/$uniq_id",
// 	                    'video_id' => $video->id,
// 	                    'time' => time()
// 	                );
	                
// 	                pt_notify($notif_data);
// 			    }

// 		    	header('Location: ' . $video->url);
// 		    	exit();
// 		    } else {
// 		        header('Location: ' . $video->url);
// 			    exit();
// 		    }
//     	}
//     }
// 	header('Location: ' . PT_Link(''));
// 	exit();
// }
// if ($first == 'paystack_check_subscribe') {
// 	$data['status'] = 500;
// 	$user_id       = (!empty($_GET['user_id']) && is_numeric($_GET['user_id'])) ? PT_Secure($_GET['user_id']) : 0;


//     if (!empty($user_id)) {
//     	$user = PT_UserData($user_id);
//     	$payment  = CheckPaystackPayment($_GET['reference']);
//     	if (!empty($user) && $user->subscriber_price > 0 && $payment) {

//     		$admin__com = ($pt->config->admin_com_subscribers * $user->subscriber_price)/100;
//     		$paypal_currency = $paypal_currency.'_PERCENT';
//     		$payment_data         = array(
// 	    		'user_id' => $user_id,
// 	    		'video_id'    => 0,
// 	    		'paid_id'  => $pt->user->id,
// 	    		'amount'    => $user->subscriber_price,
// 	    		'admin_com'    => $pt->config->admin_com_subscribers,
// 	    		'currency'    => $paypal_currency,
// 	    		'time'  => time(),
// 	    		'type' => 'subscribe'
// 	    	);
// 	    	$db->insert(T_VIDEOS_TRSNS,$payment_data);
// 	    	$balance = $user->subscriber_price - $admin__com;
// 	    	$db->rawQuery("UPDATE ".T_USERS." SET `balance` = `balance`+ '".$balance."' WHERE `id` = '".$user_id."'");
// 	    	$insert_data         = array(
// 	            'user_id' => $user_id,
// 	            'subscriber_id' => $pt->user->id,
// 	            'time' => time(),
// 	            'active' => 1
// 	        );
// 	        $create_subscription = $db->insert(T_SUBSCRIPTIONS, $insert_data);
// 	        if ($create_subscription) {

// 	            $notif_data = array(
// 	                'notifier_id' => $pt->user->id,
// 	                'recipient_id' => $user_id,
// 	                'type' => 'subscribed_u',
// 	                'url' => ('@' . $pt->user->username),
// 	                'time' => time()
// 	            );

// 	            pt_notify($notif_data);
// 	        }

// 	    	header('Location: ' . $user->url);
// 	    	exit();
//     	}
    	
//     }
// 	header('Location: ' . PT_Link(''));
// 	exit();
// }

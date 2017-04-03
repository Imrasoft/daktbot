<?php
//echo "Hello Welcome to DaktariBot."; 

$accessToken = "EAAVagxco9MkBADZABFBiJMXDpC9FLT5vZAvGKe9nRGix7DCjJ6578xxvbsJB3ykbP8lWHUjKFBoUc8WuRT0Ozksfdzifuh0CKWhkGRFc02zmdzE294uE3sXaIa909o8ebS4LtVNiqn7P8Hzj2XDWB6tqEWz3eUSwGSRDVfkgZDZD";

if(isset($_REQUEST['hub_challenge'])) {
  $challenge = $_REQUEST['hub_challenge'];
  $token = $_REQUEST['hub_verify_token'];
}

if($token =="daktariToken") {
  echo $challenge;
}


$input = json_decode(file_get_contents('php://input'), true);

$userID =input['entry'][0]['messaging'][0]['sender']['id'];

$message =input['entry'][0]['messaging'][0]['message']['text'];

echo $userID." and ".$message;


$url = "https://graph.facebook.com/v2.6/me/messages?access_token=$accessToken";

$jsonData ="{
  'recipient': {
    'id': $userID
   },
  'message': {
    'text': hello, Thank you for contacting us, How may I help you?'
   }, 
}"

$ch = curl_init($url);

curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);

if(!empty($input['entry'][0]['messaging'][0]['message'])) {
  curl_exec($ch);
}

/*curl -X POST -H "Content-Type: application/json" -d '{
  "recipient":{
  	"id":"USER_ID"
  },
  "message":{
  	"text":"hello, world!"
  }
}' "https://graph.facebook.com/v2.6/me/messages?access_token=PAGE_ACCESS_TOKEN"    */

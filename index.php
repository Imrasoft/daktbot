
<?php

// Report all errors except E_NOTICE
// This is the default value set in php.ini
error_reporting(E_ALL & ~E_NOTICE);

$VERIFY_TOKEN = 'daktariToken';
$PAGE_ACCESS_TOKEN = 'EAAVagxco9MkBAEOEIoZAr9DsHhx4H5Vm8JEElH1KSvfRDXiZCg3l30nKo1ljZAQfr10OSRum1zxNSR8zdqxgzXZC15FZAK3UKweG2f2ZCUEpwifjWUnBvlZAer1GE12CfS9EuzblRNjRzWsdKEcqZAdhLShpyiuMIAgC4WuxYHKTowZDZD';

$challenge = $_REQUEST['hub_challenge'];
$verify_token = $_REQUEST['hub_verify_token'];
if ($verify_token === $VERIFY_TOKEN) {
  	//If the Verify token matches, return the challenge.
  	echo $challenge;
}else {
	
	// **************************
	//Part A  ******************************************************************
	//Paste part A into index.php 

	    $input = json_decode(file_get_contents('php://input'), true);
		// Get the Senders Page Scoped ID
		$sender = $input['entry'][0]['messaging'][0]['sender']['id'];
		// Get the message text sent
		$message = $input['entry'][0]['messaging'][0]['message']['text'];

		if(!empty($message)){
			if($message == 'image-preg'){
				send_image_message($sender,'/images/preg.jpg', $PAGE_ACCESS_TOKEN);
			}
			elseif($message == 'ambulance' || 'Ambulance'){
				send_template_message($sender,' https://897a2060.ngrok.io/daktaribot/images/ambulance.jpg', $PAGE_ACCESS_TOKEN);
			}
			elseif($message == 'hospital' || 'Hospital'){
				send_image_message($sender,' https://897a2060.ngrok.io/daktaribot/images/hospital.jpg', $PAGE_ACCESS_TOKEN);
			}
			elseif($message == 'doctor' || 'Doctor'){
				send_button_template($sender,' https://897a2060.ngrok.io/daktaribot/images/doctor.png', $PAGE_ACCESS_TOKEN);
			}
			elseif($message == 'template-davis'){
				send_template_message($sender,'http://www.tmcg.co.ug/wp-content/uploads/2016/03/Davis-Musinguzi-300x300.jpg', $PAGE_ACCESS_TOKEN);
			}
			else{
				send_text_message($sender, "Thanks for your message", $PAGE_ACCESS_TOKEN);
			}
		}



	// END OF PART A  *********************************************************

	// **************************

	print "Hello World!"; // Please delete this line on step 8.
	//echo '<img src="/images/preg.jpg" alt="Preg Image" />';

}


// **************************
//Part B  *****************************************************************
//Paste part B into index.php 


function send_message($access_token, $payload) {
	// Send/Recieve API
	$url = 'https://graph.facebook.com/v2.6/me/messages?access_token=' . $access_token;
	// Initiate the curl
	$ch = curl_init($url);
	// Set the curl to POST
	curl_setopt($ch, CURLOPT_POST, 1);
	// Add the json payload
	curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
	// Set the header type to application/json
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
	// SSL Settings
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	// Send the request
	$result  = curl_exec($ch);
	//Return the result
	return $result;
}

function build_text_message_payload($sender, $message){
	// Build the json payload data
	$jsonData = '{
	    "recipient":{
	        "id":"' . $sender . '"
	    }, 
	    "message":{
	        "text": "'. $message .'"
	    }

	}';
	return $jsonData;
}

function send_text_message($sender, $message, $access_token){
	$jsonData = build_text_message_payload($sender, $message);
	$result = send_message($access_token, $jsonData);
	return $result;
}

// TODO: Step 9 - Complete this function
// https://developers.facebook.com/docs/messenger-platform/send-api-reference/image-attachment
function build_image_message_payload($sender, $image_url){
	// Build the json payload data
	$jsonData = '{
	    "recipient":{
	        "id":"' . $sender . '"
	    }, 
	    "message":{
	        "attachment":{
		      "type":"image",
		      "payload":{
		        "url":"'.$image_url.'"
		      }
		    }
		}

	}';
	return $jsonData;
}

function send_image_message($sender, $image_url, $access_token){
	$jsonData = build_image_message_payload($sender, $image_url);
	$result = send_message($access_token, $jsonData);
	return $result;
}

// END OF PART B  *******************************************************
// **************************

//my addition. 
//Templates

function build_template_message_payload($sender, $image_url){
  // Build the json payload data
  $jsonData = '{
      "recipient":{
          "id":"' . $sender . '"
      },
      "message": {
      "attachment": {
        "type": "template",
        "payload": {
          "template_type": "generic",
          "elements": [
            {
              "title": " Road Ambulance ",
              "image_url": "'.$image_url.'",
              "subtitle": "Road Ambulance Service Providers",
              "buttons": [
                {
                  "type": "web_url",
                  "url": "http://www.thegmp.biz/joannah",
                  "title": "Get Information"
                }, 
                {
                  "type": "postback",
                  "title": "Call Ambulance",
                  "payload": "USER_DEFINED_PAYLOAD"
                }
              ]
            },
			{
              "title": " Air Ambulance ",
              "image_url": "https://897a2060.ngrok.io/daktaribot/images/air.jpg",
              "subtitle": "Air Ambulance Service Providers",
              "buttons": [
                {
                  "type": "web_url",
                  "url": "http://www.thegmp.biz/joannah",
                  "title": "Get Information"
                }, 
                {
                  "type": "postback",
                  "title": "Call Ambulance",
                  "payload": "USER_DEFINED_PAYLOAD"
                }
              ]
            },
            {
              "title": " Water Ambulance ",
              "image_url": "https://897a2060.ngrok.io/daktaribot/images/boat.jpg",
              "subtitle": "Water Ambulance Service Providers",
              "buttons": [
                {
                  "type": "web_url",
                  "url": "http://www.thegmp.biz",
                  "title": "Get Information"
                }, 
                {
                  "type": "postback",
                  "title": "More",
                  "payload": "USER_DEFINED_PAYLOAD"
                },
              ]
              }
          ]
        }
      }
    }

  }';
  return $jsonData;
}

function send_template_message($sender, $image_url, $access_token){
  $jsonData = build_template_message_payload($sender, $image_url);
  $result = send_message($access_token, $jsonData);
  return $result;
}

?>

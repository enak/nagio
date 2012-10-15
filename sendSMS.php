<?php	

	// Requires the Twilio-PHP library from twilio.com/docs/libraries
	require "./twilio-php/Services/Twilio.php";
	
	function sendSMS($number, $message){
		// Set the AccountSid and AuthToken from www.twilio.com/user/account
		$AccountSid = "ACda88a60e21d3977e0280feae8e7548e5";
		$AuthToken = "bfd50ef8dc45f9188edb617206704d31";
	
		// Create a new Twilio Rest Client
		$client = new Services_Twilio($AccountSid, $AuthToken);
	
		// create(#PHONE_NUMBER_OF_TWILIO, #PHONE_NUMBER_TO_SEND_TO, #MESSAGE_TO_BE_SENT)
		$sms = $client->account->sms_messages->create("240-949-7989", $number, "$message");
	}
?>

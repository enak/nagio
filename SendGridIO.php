<?php
//Include The SendGrid Package
include './sendgrid-php/SendGrid_loader.php';
function sentEmail($uaddress,$raddress,$subject,$content)
{
	// Seting Up A New SendGrid User with the UserName,Password
	$sendgrid = new SendGrid('HackRU','HackRU');
	$mail = new SendGrid\Mail();
	// 
	$mail->addTo($raddress)->
	// Sender
	setFrom($uaddress)->
	// Subject
	setSubject($subject)->
	// Content
	setText('')->
	setHtml('<strong>'.$content.'t</strong>');
	// confirm mail sent
	$sendgrid->web->send($mail);
}
?>

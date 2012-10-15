<?php
	//include './getNews.php';

	//Connect & Select
	$con = mysql_connect("stevekaneus.ipagemysql.com","nagio","nagio_hackRU2012") or die (mysql_error());
	mysql_select_db("nagiodb",$con);
	
	//Select rows; row for nagee as the texter, row2 for the nagger as the texter
	$inDB = mysql_query("SELECT * FROM nags WHERE nagee_phone='".$_POST['From']."'", $con);
	$row = mysql_fetch_array($inDB);
	$inDB2 = mysql_query("SELECT * FROM nags WHERE nagger_phone='".$_POST['From']."'", $con);
	$row2 = mysql_fetch_array($inDB2);
	
	if($row) {
		if(strtolower($row['password']) == strtolower($_POST['Body'])) {
			$text.="I'll stop nagging you now.";
			mysql_query("DELETE FROM nags WHERE nagId=".$row['nagId'], $con);
		}
		if($row['nagger_name'] == "") {
			$text="Wrong password, get the password from the person at " . $row['nagger_phone'] . ".";
		} else {
			$text="Wrong password, get the password from " . $row['nagger_name'] . " their number is " . $row['nagger_phone'] . ".";
		}
	}
	
	if($row2) {
		if("password" == strtolower($_POST['Body'])) {
			$pw = $row2['password'];
			$text.="Your password is " . $pw;
		}
	}
	
	/*if("news" == strtolower($_POST['Body'])) {
			$link = getNewsLink("'".$_POST['FromZip']."'");
			echo $link;
			$text = "Your news link: " . $link;
	}*/

	mysql_close($con);
	
	//Directive from Twilio
	header("content-type: text/xml");
	echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
?>


<Response>
<Sms><?php echo $text; ?></Sms>
</Response>

<?php
// get the two php file require to run this script
require './SendGridIO.php';
require './sendSMS.php';
// connect to the domain of the database
$con = mysql_connect("stevekaneus.ipagemysql.com","nagio","nagio_hackRU2012") or die (mysql_error());
mysql_select_db("nagiodb",$con);
// get data from table nags
	$data = mysql_query("SELECT * FROM nags") or die (mysql_error());
// loop through all the data in database
	while($row = mysql_fetch_array($data))
	{
		// echo out data to confirm the necessary information for time
		echo "<br /><br />Current ID: " . $row['nagId']. "<br />";
		$CURRENT_TIMESTAMP = mysql_query("SELECT CURRENT_TIMESTAMP() AS currTime", $con);
		$CURRENT_TIMESTAMP = mysql_fetch_array($CURRENT_TIMESTAMP);
		echo $CURRENT_TIMESTAMP['currTime'] . "<br />";
		// echo out data to confirm the necessary information for timediff
		$createDiff = "SELECT TIMEDIFF('".$CURRENT_TIMESTAMP['currTime'] ."','". $row['creationDate']."') AS createDif";
		echo "createDiff= " .$createDiff ."<br />";
		$createDiff = mysql_query($createDiff, $con);
		$createDiff = mysql_fetch_array($createDiff);
		$createDiff = $createDiff['createDif'];
		echo "createDiff= " .$createDiff ."<br />";
		$createDiff = "SELECT TIME_TO_SEC('". $createDiff ."') AS creatediffsec";
		echo $createDiff;
		$createDiff = mysql_query($createDiff, $con);
		echo "createDiff= " .$createDiff ."<br />";
		$createDiff = mysql_fetch_array($createDiff);
		$createDiff=$createDiff['creatediffsec'];
		// echo out data before and after conversion
		echo "createDiff= " .$createDiff ."<br />";
		$createDiff = $createDiff/60;
		echo "createDiff= " .$createDiff ."<br />";
		// check if duration has pass if it pass remove the request from database
		if($createDiff>=$row['duration'])
		{
			$sql = "DELETE FROM nags WHERE NagId=".$row['nagId'];
			echo $sql;
			mysql_query("DELETE FROM nags WHERE NagId=".$row['nagId'], $con);
		}
		// more data checking through echoing
		$sql = "SELECT TIMEDIFF('". $CURRENT_TIMESTAMP['currTime'] ."','". $row['lastNag'] ."') AS timediff";
		echo $sql . "<br />";
		$timeDiff = mysql_query($sql, $con);
		$timeDiff = mysql_fetch_array($timeDiff);
		echo "First Time: ". $timeDiff['timediff'] . "</br >";
		$timeDiff = mysql_query("SELECT TIME_TO_SEC('". $timeDiff['timediff'] ."') AS timediffsec", $con);
		$timeDiff = mysql_fetch_array($timeDiff);
		$timeDiff = $timeDiff['timediffsec']/60;
		echo "The timediff = " . $timeDiff . "</br >";

		// check if enough time has passed by checking the requested interval with time passed
		if($timeDiff >= $row['interval'])
		{
			sentEmail($row['nagger_email'],$row['nagee_email'],"Nag From: ".$row['nagger_name'], $row['message']);
			sendSMS($row['nagee_phone'], $row['message']);
		
			$sql="UPDATE `nags` SET `lastNag`=CURRENT_TIMESTAMP() WHERE nagId=".$row['nagId'];
			mysql_query($sql, $con);
		}
		else
			echo "Not sending yet.<br />";
		
		/*$headers = "MIME-Version: 1.0\n";
		$headers .= "Content-type: text/plain; charset=UTF-8\n";
		$headers .= "From: ".$row['nagger_email']."\n";
		$headers .= "Reply-To: ".$row['nagger_email']."\n";
		mail($row['nagee_email'], "Nag From: ".$row['nagger_name'], $row['message'], $headers);	*/
		echo $row['nagger_name'] . "<br />\n";
		echo $row['nagger_email'] . "<br />\n";
		echo $row['nagger_phone'] . "<br />\n";
		echo $row['nagee_name'] . "<br />\n";
		echo $row['nagee_email'] . "<br />\n";
		echo $row['nagee_phone'] . "<br />\n";
		echo "duration " . $row['duration'] . "<br />\n";
		echo "interval " . $row['interval'] . "<br />\n";
		echo $row['message'] . "<br />\n";
	}
	// Close out of the database
	mysql_close($con);
?>

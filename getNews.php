
<?php
//function getNewsLink($zip){
	$zip='08831';
	$key = 'ffjeya4pe2h5rfsyr2fkgetf';
	$secret = 'sw4gKe7rGe';
	$timestamp = time();
	$sig = urlencode(md5($key . $secret . $timestamp));
	$url ="http://news-api.patch.com/v1.1/zipcodes/".$zip."/stories?dev_key=".$key."&sig=".$sig;
	echo $url."</br>";
	$response = file_get_contents("'".$url."'");
	if($response==false)
		echo "problem";
	else
		echo $response;

	if (function_exists('curl_init')) {
		echo "curl exists";
	   // initialize a new curl resource
	   $ch = curl_init(); 
	
	   // set the url to fetch
	   curl_setopt($ch, CURLOPT_URL, $url); 
	
	   // don't give me the headers just the content
	   curl_setopt($ch, CURLOPT_HEADER, 0); 
	
	   // return the value instead of printing the response to browser
	   curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
	
	   // use a user agent to mimic a browser
	   curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.7.5) Gecko/20041107 Firefox/1.0'); 
	
	   $content = curl_exec($ch); 
	   $articles = json_decode($content, true);
		  /*
			while (list($field, $value) = each($articles)) 
			{
				echo "<div>$field $value</div>\n";
				if(is_array($value))
				{
					echo $value."\n";
					while (list($field1, $value1) = each($value)) 
						echo "\t<div>$field1 $value1</div>\n";
				}
			}
		*/	
		 
		echo $articles['stories'][0]['story_url'];
		curl_close($ch);
	   //echo $content;
	   // remember to always close the session and free all resources 
	} else {
	   // curl library is not installed so we better use something else
	   echo "no curl";
	}
//}
?>
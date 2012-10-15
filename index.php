<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>Nag.io</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width">

        <link rel="stylesheet" href="css/bootstrap.min.css">
        <style>
            body {
                padding-top: 60px;
                padding-bottom: 40px;
            }
        </style>
        <link rel="stylesheet" href="css/bootstrap-responsive.min.css">
        <link rel="stylesheet" href="css/main.css">

        <script src="js/vendor/modernizr-2.6.1-respond-1.1.0.min.js"></script>
    </head>
    <body>
        <!--[if lt IE 7]>
            <p class="chromeframe">You are using an outdated browser. <a href="http://browsehappy.com/">Upgrade your browser today</a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to better experience this site.</p>
        <![endif]-->

        <!-- This code is taken from http://twitter.github.com/bootstrap/examples/hero.html -->

        <div class="navbar navbar-inverse navbar-fixed-top">
            <div class="navbar-inner">
                <div class="container">
                    <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </a>
                    <a class="brand" href="#">Nag.io</a>
                    <div class="nav-collapse collapse">
                        <ul class="nav">
                        <li><a href="nagged/">Getting nagged?</a></li>
                        <li><a href="http://www.hackru.org/">HackRU</a></li>
                        <li><a href="https://www.hackerleague.org/hackathons/hackru-fall-2012">HackerLeague</a></li>
                        </ul>
                    </div><!--/.nav-collapse -->
                </div>
            </div>
        </div>

        <div class="container">
        	<?php
        			require './SendGridIO.php';
        			require './sendSMS.php';
				if(isset($_POST['register']))
				{
					$con = mysql_connect('stevekaneus.ipagemysql.com', 'nagio', 'nagio_hackRU2012'); 
					if (!$con) { 
						die('Could not connect: ' . mysql_error()); 
					} 
					//echo 'Connected successfully'; 
					mysql_select_db(nagiodb); 
				
					$name = $_POST['name'];
					$email = $_POST['email'];
					$phone = $_POST['phone'];
					$nameNag = $_POST['nameNag'];
					$emailNag = $_POST['emailNag'];
					$phoneNag = $_POST['phoneNag'];
					$duration = $_POST['duration'];
					$hours = $_POST['hours'];
					$minutes = $_POST['minutes'];
					$message = $_POST['message'];
					$password = $_POST['password'];
					
					$interval = $minutes + ($hours * 60);
					
					if($phoneNag != "")
					{
						if($phone == "")
						{
							echo "<div class=\"alert alert-failure\">If you enter a phone number to nag, you must enter your phone number. Click back to add to the form.</div>";
							$kill=true;
						}
					}
					if($emailNag != "")
					{
						if($email == "")
						{
							echo "<div class=\"alert alert-failure\">If you enter an email to nag, you must enter your email address. Click back to add to the form.</div>";
							$kill=true;
						}
					}
					if($phoneNag != "")
					{
						$checkForEntry = "SELECT * FROM nags WHERE nagee_phone='+1$phoneNag'";
						//echo "<div class=\"alert alert-info\">$checkForEntry</div>";
						$checkForEntry = mysql_query($checkForEntry, $con);
					}
					if($emailNag != "")
					{
						$checkForEntry1 = "SELECT * FROM nags WHERE nagee_email='$emailNag'";
						//echo "<div class=\"alert alert-info\">$checkForEntry1</div>";
						$checkForEntry1 = mysql_query($checkForEntry1, $con);
					}
					if($kill!=true)
						if(mysql_fetch_array($checkForEntry)||mysql_fetch_array($checkForEntry1))
							echo "<div class=\"alert alert-failure\">The nagee you entered is already being nagged.</div>";
						else
						{
							$sql = "INSERT INTO `nags` (`nagger_name`, `nagger_email`, `nagger_phone`, `nagee_name`, `nagee_email`, `nagee_phone`, `duration`, `interval`, `lastNag`, `creationDate`, `message`,`password`) 
						VALUES ('$name', '$email', '+1$phone', '$nameNag', '$emailNag', '+1$phoneNag', $duration, $interval, CURRENT_TIMESTAMP(), CURRENT_TIMESTAMP(), '$message', '$password');";
							
							//echo "<br />".$sql."<br />";
						
							$sql = mysql_query($sql, $con);
								sentEmail($email, $emailNag,"Nag From: ".$name, $message);
								sendSMS($phoneNag, $message);
							
								$sql="UPDATE `nags` SET `lastNag`=CURRENT_TIMESTAMP() WHERE nagId=".$row['nagId'];
								mysql_query($sql, $con);
							if($sql)
								echo "<div class=\"alert alert-success\">Nag Success!!</div>";
							else
								echo mysql_error($con);
								
							//nagio_hackRU2012
						}
					mysql_close($con);
				}
				if(isset($_GET['site']))
				{
					echo "
					<div class=\"alert alert-info\"><h1>url: http://www.stevekane.us/nagio or http://goo.gl/RcxEr </h1></div>";
					
				}
			?>
        	
            <!-- Main hero unit for a primary marketing message or call to action -->
            <div class="hero-unit hidden-phone">
                <h1>Introducing Nag.io!</h1>
                <p>Are you tired of nagging your friends to do something? Try Nag.io instead.</p>
                <p>We'll send the emails and text messages for you.</p>
                <p>Getting nagged? Click here to make it <a href="nagged/" class="btn btn-danger btn-large">stop</a></p>
            </div>
            <div class="visible-phone page-header">
                <h1>Introducing Nag.io!</h1>
                <p>Are you tired of nagging your friends to do something? Try Nag.io instead.</p>
                <p>We'll send the emails and text messages for you.</p>
                <p>Getting nagged? Click here to make it <a href="nagged/" class="btn btn-danger">stop</a></p>
            </div>

            <!-- Example row of columns -->
            <form id="nagForm" method="post" action=".">
            <div class="row">
                <div class="span4">
                    <legend>Nagger</legend>
					<label>Name</label>
					<input type="text" name="name" placeholder="Type something…">
					<label>Email Address</label>
					<input type="text" name="email" placeholder="Type something…">
					<label>Cell Phone</label>
					<input type="text" name="phone" placeholder="5555555555">
					<label id="pwLabel">Password</label>
					<input type="text" name="password" placeholder="cheese">
                </div>
                <div class="span4">
					<legend>Nagee</legend>
					<label>Name</label>
					<input type="text" name="nameNag" placeholder="Type something…">
					<label>Email Address</label>
					<input type="text" name="emailNag" onblur="validateEmail();" placeholder="Type something…">
					<label>Cell Phone</label>
					<input type="text" name="phoneNag" onblur="validateNumber();" placeholder="5555555555">
               </div>
                <div class="span4">
					<legend>The Nag</legend>
					<label>Duration</label>
					<input type="text" name="duration" onblur="validateTime();" placeholder="minutes">
					<label>Iteration</label>
					<label>Hours</label>
					<input type="text" name="hours" onblur="validateTime();" placeholder="hours">
					<label>Minutes</label>
					<input type="text" name="minutes" onblur="validateTime();" placeholder="minutes">
					<label>Message</label>
					<textarea name="message" rows="3"></textarea>
					<br />
					<button type="submit" name="register" class="btn">Submit</button>
                </div>
                </form>
            </div>
            <hr>

            <footer>
                <p>&copy; Nagio 2012</p>
            </footer>

        </div> <!-- /container -->

        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.8.2.min.js"><\/script>')</script>

        <script src="js/vendor/bootstrap.min.js"></script>

        <script src="js/main.js"></script>
        <script src="js/nagio.js"></script>

        <script>
            var _gaq=[['_setAccount','UA-XXXXX-X'],['_trackPageview']];
            (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
            g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
            s.parentNode.insertBefore(g,s)}(document,'script'));
        </script>
    </body>
</html>

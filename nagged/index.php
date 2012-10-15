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

        <link rel="stylesheet" href="../css/bootstrap.min.css">
        <style>
            body {
                padding-top: 60px;
                padding-bottom: 40px;
            }
        </style>
        <link rel="stylesheet" href="../css/bootstrap-responsive.min.css">
        <link rel="stylesheet" href="../css/main.css">

        <script src="../js/vendor/modernizr-2.6.1-respond-1.1.0.min.js"></script>
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
                    <a class="brand" href="../">Nag.io</a>
                    <div class="nav-collapse collapse">
                        <ul class="nav">
                            <li><a href="../">Home</a></li>
                            <li class="active"><a href=".">Getting nagged?</a></li>
                            <!-- <li><a href="#about">Sign In</a></li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <b class="caret"></b></a>
                                <ul class="dropdown-menu">
                                    <li><a href="#">Action</a></li>
                                    <li><a href="#">Another action</a></li>
                                    <li><a href="#">Something else here</a></li>
                                    <li class="divider"></li>
                                    <li class="nav-header">Nav header</li>
                                    <li><a href="#">Separated link</a></li>
                                    <li><a href="#">One more separated link</a></li>
                                </ul>
                            </li>-->
                        </ul>
                    </div><!--/.nav-collapse -->
                </div>
            </div>
        </div>

        <?php
        /*while (list($field, $value) = each($_POST)) 
        {
        	echo "<div class=\"alert alert-info\">$field $value</div>";
        }*/
        if(isset($_POST['removePhone'])||isset($_POST['removeEmail']))
        {
        	$con = mysql_connect('stevekaneus.ipagemysql.com', 'nagio', 'nagio_hackRU2012'); 
        	mysql_select_db(nagiodb); 
			if (!$con) { 
				die('Could not connect: ' . mysql_error()); 
			} 
			if(isset($_POST['removePhone']))
			{
				$phone = "SELECT nagId FROM nags WHERE nagee_phone='+1". $_POST['nagPhone'] . "'";
				$phone = mysql_query($phone, $con);
				if($phone = mysql_fetch_array($phone))
				{
					$phone = "DELETE FROM nags WHERE nagId=" . $phone['nagId'] ;
					mysql_query($phone, $con);
					echo "<div class=\"alert alert-success\">Nag removed!</div>";
				}
				else
					echo "<div class=\"alert alert-failure\">This number is not currently getting nagged.</div>";
			}
			if(isset($_POST['removeEmail']))
			{
				$email = "SELECT nagId FROM nags WHERE nagee_email='+1". $_POST['nagEmail'] . "'";
				$email = mysql_query($email, $con);
				if($email = mysql_fetch_array($email))
				{
					$email = "DELETE FROM nags WHERE nagId=" . $email['nagId'] ;
					mysql_query($email, $con);
					echo "<div class=\"alert alert-success\">Nag removed!</div>";
				}
				else
					echo "<div class=\"alert alert-failure\">This email address is not currently getting nagged.</div>";
			}
			//echo "<div class=\"alert alert-success\">Nag removed!</div>";
			mysql_close($con);
		}
        ?>
        
        <div class="page-header"><h4>Enter your email address or phone number to delete yourself from the database.</h4></div>
        
        <div class="container">
		<form method="post" action=".">
			<label>Phone Number</label>
			<input type="text" name="nagPhone" placeholder="5555555555">
			<br />
			<button type="submit" name="removePhone" class="btn">Submit</button>
		</form>
		<form method="post" action=".">
			<label>Email Address</label>
			<input type="text" name="nagEmail" placeholder="somewhere@domain.aa">
			<br />
			<button type="submit" name="removeEmail" class="btn">Submit</button>
		</form>
            <hr>
            <footer>
                <p>&copy; Nagio 2012</p>
            </footer>
        </div> <!-- /container -->

        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="../js/vendor/jquery-1.8.2.min.js"><\/script>')</script>
        <script src="../js/vendor/bootstrap.min.js"></script>
        <script src="../js/main.js"></script>

        <script>
            var _gaq=[['_setAccount','UA-XXXXX-X'],['_trackPageview']];
            (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
            g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
            s.parentNode.insertBefore(g,s)}(document,'script'));
        </script>
    </body>
</html>

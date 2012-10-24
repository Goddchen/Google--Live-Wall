<?php
	if(!isset($_REQUEST['query'])) {
?>
	<html>
	<head>
		<link rel="stylesheet" type="text/css" href="style.css">
		<title>Google+ Live Wall</title>
	</head>
	<body>
		<div id="header">
			<?php include("header.php"); ?>
		</div>
		<div id="content_container">
			<p>
				<form action="index.php" method="GET">
					Query: <input type="text" name="query" /><br>
					Order By: <select name="orderBy">
						<option value=""></option>
						<option value="recent" selected>Recent</option>
						<option value="best">Best</option>
					</select><br>
					Language: <select name="language">
						<option value="" selected></option>
						<option value="en">English</option>
						<option value="de">German</option>
					</select><br>
					<input type="submit" />
				</form>
			</p>
		</div>
		<div id="footer">
			<?php include("footer.php"); ?>
		</div>
	</body>
	</html>
<?php 
	} else {
		$query = $_REQUEST['query'];
		$plusurl = "https://www.googleapis.com/plus/v1/activities?query=".urlencode($query)."&maxResults=20&key=AIzaSyAFnC4wup5dShT-Zdu_csL6Ag05IGp307U";
		if(isset($_REQUEST['language']) && "" !== $_REQUEST['language']) {
			$plusurl .= "&language=".$_REQUEST['language'];
		}
		if(isset($_REQUEST['orderBy']) && "" !== $_REQUEST['orderBy']) {
			$plusurl .= "&orderBy=".$_REQUEST['orderBy'];
		}
?>
	<html>
	<head>
		<title>Google+ Live Wall for <?php echo($query); ?></title>
		<link rel="stylesheet" type="text/css" href="style.css">
		<script src="js/gpluswall.js"></script>
		<script src="http://code.jquery.com/jquery-1.8.2.min.js"></script>
		<script src="https://github.com/phstc/jquery-dateFormat/raw/master/jquery.dateFormat-1.0.js"></script>
		<script type="text/javascript" src="https://apis.google.com/js/plusone.js">
			{"parsetags": "explicit"}
		</script>
		<script type="text/javascript">
			$(document).ready(function() {
				var plusUrl = "<?php echo($plusurl); ?>";
				var interval = setInterval(function() { updatePosts(plusUrl); }, 60*1000);
				updatePosts(plusUrl);
				$("#interval").change(function() {
				clearInterval(interval);
					interval = setInterval(function() { updatePosts(plusUrl); }, 1000*$(this).val());
				});
			});
		</script>
	</head>
	<body>
		<div id="header">
			<?php include("header.php"); ?>
		</div>
		<div id="content_container">
			<div id="posts" />
		</div>
		<div id="footer">	
			<?php include("footer.php"); ?>
		</div>
	</body>
	</html>
<?php
	}
?>
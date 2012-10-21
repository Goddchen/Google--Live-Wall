<?php
	if(!isset($_REQUEST['query'])) die("query not set");
	$query = $_REQUEST['query'];
	$plusurl = "https://www.googleapis.com/plus/v1/activities?query=".urlencode($query)."&maxResults=20&orderBy=recent&key=AIzaSyAFnC4wup5dShT-Zdu_csL6Ag05IGp307U";
?>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="style.css">
	<script src="http://code.jquery.com/jquery-1.8.2.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			function updatePosts() {
				$.getJSON(
					"<?php echo($plusurl); ?>",
					function (data) {
						$("#posts").text("");
						$.each(data.items, function(i, item) {
							$("#posts").append(
								"<div class='post'>"
								+ item.published + "<br>"
								+ "<a href='" + item.actor.url + "'><img src='" + item.actor.image.url + "'></a><br>"
								+ "<a href='" + item.actor.url + "'>" + item.actor.displayName + "</a><br><br>"
								+ item.object.content + "<br><br><hr><br><br></div>");
						});
				});
			}
			var interval = setInterval(updatePosts, 60*1000);
			updatePosts();
			$("#interval").change(function() {
			clearInterval(interval);
				interval = setInterval(updatePosts, 1000*$(this).val());
			});
		});
	</script>
</head>
<body>
	<h1>Google+ Wall for "<?php echo($query); ?>"</h1>
	<p>
		Update Interval: <select id="interval">
			<option value="10">10 Seconds</option>
			<option value="60" selected>1 Minute</option>
		</select>
	</p>
	<div id="posts" />
</body>
</html>
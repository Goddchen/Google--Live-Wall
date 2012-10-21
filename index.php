<?php
	if(!isset($_REQUEST['query'])) die("query not set");
	$query = $_REQUEST['query'];
	$plusurl = "https://www.googleapis.com/plus/v1/activities?query=".urlencode($query)."&maxResults=20&orderBy=recent&key=AIzaSyAFnC4wup5dShT-Zdu_csL6Ag05IGp307U";
?>
<html>
<head>
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
								item.published + "<br>"
								+ "<a href='" + item.actor.url + "'><img src='" + item.actor.image.url + "'></a><br>"
								+ "<a href='" + item.actor.url + "'>" + item.actor.displayName + "</a><br><br>"
								+ item.object.content + "<br><br><hr><br><br>");
						});
				});
			}
			setInterval(updatePosts, 60*1000);
			updatePosts();
		});
	</script>
</head>
<body>
	<h1>Google+ Wall for "<?php echo($query); ?>"</h1>
	<div id="posts" />
</body>
</html>
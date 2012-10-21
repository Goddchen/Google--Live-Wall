<?php
	if(!isset($_REQUEST['query'])) {
?>
	<html>
	<head>
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>
	<body>
		<h1>Google+ Live Wall</h1>
		<div id="content_container">
			<p>
				<form action="index.php" method="GET">
					<label for="query">Query </label>
					<input type="text" name="query" />
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
		$plusurl = "https://www.googleapis.com/plus/v1/activities?query=".urlencode($query)."&maxResults=20&orderBy=recent&key=AIzaSyAFnC4wup5dShT-Zdu_csL6Ag05IGp307U";
?>
	<html>
	<head>
		<link rel="stylesheet" type="text/css" href="style.css">
		<script src="http://code.jquery.com/jquery-1.8.2.min.js"></script>
		<script type="text/javascript">
			$(document).ready(function() {
				function reverseSort(a, b) {
					return a.published > b.published;
				}
				
				function updatePosts() {
					$.getJSON(
						"<?php echo($plusurl); ?>",
						function (data) {
							data.items.sort(reverseSort);
							$.each(data.items, function(i, item) {
								if(!$("#post-" + item.id).length) {
									var newPost = 
										"<div class='post' id='post-" + item.id + "'>"
										+ item.published + "<br>"
										+ "<a href='" + item.actor.url + "'><img src='" + item.actor.image.url + "'></a><br>"
										+ "<a href='" + item.actor.url + "'>" + item.actor.displayName + "</a><br><br>"
										+ item.object.content + "<br><br>";
										if(item.object.attachments) {
											$.each(item.object.attachments, function(i, attachment) {
												if(attachment.objectType === "photo" && attachment.fullImage && attachment.fullImage.height && attachment.fullImage.width) {
													newPost += "<img width='320' src='" + attachment.fullImage.url + "' /><br><br>";
												}
											});
										}
									newPost += "<hr><br><br></div>";
									$("#posts").prepend(newPost);
								}
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
		<div id="content_container">
			<p>
				Update Interval: <select id="interval">
					<option value="10">10 seconds</option>
					<option value="60" selected>1 minute</option>
					<option value="300">5 minutes</option>
					<option value="600">10 minutes</option>
				</select>
			</p>
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
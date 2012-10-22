<?php
	if(!isset($_REQUEST['query'])) {
?>
	<html>
	<head>
		<link rel="stylesheet" type="text/css" href="style.css">
		<title>Google+ Live Wall</title>
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
		<title>Google+ Live Wall for <?php echo($query); ?></title>
		<link rel="stylesheet" type="text/css" href="style.css">
		<script src="http://code.jquery.com/jquery-1.8.2.min.js"></script>
		<script type="text/javascript">
			$(document).ready(function() {
				function reverseSort(a, b) {
					// Example: 2012-10-21T13:56:28.000Z
					var aDate = Date.parse(a.published);
					var bDate = Date.parse(b.published);
					return aDate - bDate;
				}
				
				function updatePosts() {
					$.getJSON(
						"<?php echo($plusurl); ?>",
						function (data) {
							data.items.sort(reverseSort);
							$.each(data.items, function(i, item) {
								if(!$("#post-" + item.id).length) {
									var newPost = 
										"<div class='post' id='post-" + item.id + "'><p>"
										+ "<a href='" + item.url + "'>" + item.published + "</a><br>"
										+ "<a href='" + item.actor.url + "'><img src='" + item.actor.image.url + "'></a><br>"
										+ "<a href='" + item.actor.url + "'>" + item.actor.displayName + "</a><br><br>"
										+ item.object.content + "<br><br>";
										if(item.object.attachments) {
											$.each(item.object.attachments, function(i, attachment) {
												if(attachment.objectType === "photo" && attachment.fullImage && attachment.fullImage.height && attachment.fullImage.width) {
													newPost += "<a href='" + attachment.fullImage.url + "' target='_blank'><img width='320' src='" + attachment.fullImage.url + "' /></a><br><br>";
												} else if(attachment.objectType === "photo" && attachment.fullImage && (!attachment.fullImage.height || !attachment.fullImage.width)) {
													newPost += "<img src='" + attachment.image.url + "' /><br><br>";
												} else if(attachment.objectType === "video") {
													newPost += "<iframe class='youtube-player' type='text/html' width='480' height='288' src='"+attachment.embed.url+"' frameborder='0'></iframe><br><br>";
												}
											});
										}
									newPost += "<g:plusone href='" + item.url + "'></g:plusone><br>";
									newPost += "</p></div>";
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
		<!-- Place this tag after the last +1 button tag. -->
		<script type="text/javascript">
		  (function() {
			var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
			po.src = 'https://apis.google.com/js/plusone.js';
			var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
		  })();
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
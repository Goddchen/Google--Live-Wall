function reverseSort(a, b) {
	// Example: 2012-10-21T13:56:28.000Z
	var aDate = Date.parse(a.published);
	var bDate = Date.parse(b.published);
	return aDate - bDate;
}

function updatePosts(plusUrl) {
	$.getJSON(
		plusUrl,
		function (data) {
			data.items.sort(reverseSort);
			$.each(data.items, function(i, item) {
				if(!$("#post-" + item.id).length) {
					var newPost = 
						"<div class='post' id='post-" + item.id + "'><p>"
						+ "<table width='100%'><tr><td style='text-align:center,top;' width='100px'>"
						+ "<a href='" + item.url + "'>" + $.format.date(Date.parse(item.published), "yyyy-MM-dd HH:mm:ss") + "</a><br>"
						+ "<a href='" + item.actor.url + "'><img src='" + item.actor.image.url + "'></a><br>"
						+ "<a href='" + item.actor.url + "'>" + item.actor.displayName + "</a>";
						if(item.object.actor) {
							newPost += "<br><i>Originally posted by " + item.object.actor.displayName + "</i>";
						}
						newPost += "</td><td>";
						if(item.object.content.length > 0) {
							newPost += item.object.content + "<br><br>";
						}
						if(item.object.attachments) {
							$.each(item.object.attachments, function(i, attachment) {
								if(attachment.objectType === "article") {
									newPost += "<br><a href='" + attachment.url + "'>" + attachment.displayName + "</a><br>" + attachment.content + "<br>";
								} else if(attachment.objectType === "photo") {
									if(attachment.fullImage && "https:" !== attachment.fullImage.url) {
										newPost += "<img class='post_image' width='320' src='" + attachment.fullImage.url + "' />"; 
									} else if(attachment.image) {
										newPost += "<img class='post_image' width='320' src='" + attachment.image.url + "' />"; 
									}
								} else if(attachment.objectType === "video") {
									newPost += "<br><iframe class='youtube-player' type='text/html' width='480' height='288' src='"+attachment.embed.url+"' frameborder='0'></iframe><br>";
								}
							});
						}
					newPost += "<p><div id='post-plusone-"+item.id+"'><g:plusone href='" + item.url + "' width='400' annotation='inline'></g:plusone></div></p>";
					newPost += "</td></table></p></div>";
					$("#posts").prepend(newPost);
					$("#post-"+item.id).slideDown();
					gapi.plusone.go("post-plusone-"+item.id);
				}
			});
	});
}
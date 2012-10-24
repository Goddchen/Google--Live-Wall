<div style="float: left; width: 100%;">
	<h1>Google+ Live Wall
	<?php
		if(isset($query)) {
			echo("for \"$query\"");
		}
	?>
	</h1>
	<?php
		if(isset($query)) {
		?>		
		<p>
			Update Interval:
			<select id="interval">
				<option value="10">10 seconds</option>
				<option value="60" selected>1 minute</option>
				<option value="300">5 minutes</option>
				<option value="600">10 minutes</option>
			</select>
		</p>
		<?php
		}
	?>
</div>
<div class="topright">
	<!-- Place this tag where you want the badge to render. -->
	<g:plus width="400" href="//plus.google.com/110660004375811502712" rel="publisher"></g:plus>
	<!-- Place this render call where appropriate. -->
	<script type="text/javascript">gapi.plus.go();</script>
</div>
		<div class="top-bar">
			<form action="">
				<input type="text" placeholder="Post quick update to the cloud..." />
				<a href="/user" class="email">[user.email]</a>
			</form>
			<a class="home hvr-radial-in" href="/"><img src="/admin/files/img/ico/home.png"/></a>
			<a class="messages" href=""><span class="notifications new">0</span></a>
		</div>
		<div class="left-bar">
		
			<div class="cf">
			<form id="mediaupload" action="/media" method="post" enctype="multipart/form-data">
				<a href="/media" class="hvr-bounce-to-right left-nav">Media</a> <span>|</span> <a class="hvr-bounce-to-right" href="#" onclick="$(this).next().click();">Upload Media</a>
				<input type="file" name="file[]" style="display:none;" id="file" multiple="multiple" />
			</form>
			</div>
			
			<script>
				$(document).on('change', '#file', function(){ $('#mediaupload').submit(); });
			</script>
			
			<div class="cf"><a href="/comments" class="hvr-bounce-to-right left-nav">Comments</a> <span>|</span> <a class="hvr-bounce-to-right" href="">Write Comment</a></div>
			<div class="cf"><a href="/posts" class="hvr-bounce-to-right left-nav">Posts</a> <span>|</span> <a class="hvr-bounce-to-right" href="">Write Post</a></div>
			<div class="cf"><a href="/pages" class="hvr-bounce-to-right left-nav">Pages</a> <span>|</span> <a class="hvr-bounce-to-right" href="">Write Page</a></div>
			
			<hr/>
			
			<div class="cf"><a class="hvr-bounce-to-right" href="/plugins">Browse Plugins</a></div>
			<div class="cf"><a class="hvr-bounce-to-right" href="/themes">Browse Themes</a></div>

			<hr/>
			
			<div class="cf"><a class="hvr-bounce-to-right" href="/settings">Settings</a></div>

			<hr/>
			
			<div class="cf"><a class="hvr-bounce-to-right logout" href="/admin/logout">Logout</a></div>
		</div>

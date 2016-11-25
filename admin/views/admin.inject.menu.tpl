		<div class="top-bar">
			<form action="">
				<input type="text" placeholder="Post quick update to the cloud..." />
				<a href="/user" class="email">[user.email]</a>
			</form>
			<a class="home hvr-radial-in" href="/"><img src="/admin/files/img/ico/home.png"/></a>
			<a class="messages" href=""><span class="notifications new">0</span></a>
		</div>
		<div class="left-bar">
		
			<form id="mediaupload" action="/media" method="post" enctype="multipart/form-data">
				<a class="hvr-bounce-to-right" href="#" onclick="$(this).next().click();">Upload Media</a>
				<input type="file" name="file[]" style="display:none;" id="file" multiple="multiple" />
			</form>
			
			<script>
				$(document).on('change', '#file', function(){ $('#mediaupload').submit(); });
			</script>
			
			<a class="hvr-bounce-to-right" href="">Write Comment</a>
			<a class="hvr-bounce-to-right" href="">Write Post</a>
			<a class="hvr-bounce-to-right" href="">Write Page</a>
			
			<hr/>
			
			<a class="hvr-bounce-to-right" href="">Browse Plugins</a>
			<a class="hvr-bounce-to-right" href="">Browse Themes</a>

			<hr/>
			
			<a class="hvr-bounce-to-right" href="">Settings</a>

			<hr/>
			
			<a class="hvr-bounce-to-right logout" href="/admin/logout">Logout</a>
		</div>

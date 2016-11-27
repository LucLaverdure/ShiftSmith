		<div class="top-bar admin-bar">
			<form action="">
				<input type="text" placeholder="Post quick update to the cloud..." />
				<a href="/user" class="email">[user.email]</a>
			</form>
			<a class="home hvr-radial-in" href="/"><img src="/admin/files/img/ico/home.png"/></a>
			<a class="messages" href=""><span class="notifications new">0</span></a>
		</div>
		<div class="left-bar admin-bar">
		
			<div class="cf dreamforgery">
				<span class="quick-forge-ico admin-ico"></span>
				<a href="/admin/dreamforgery" class="hvr-bounce-to-right left-nav">Dream Forgery</a>
				<span class="quick-forge-admin admin-ico"></span>
				<a href="/admin/dreamforgery" class="quick-forge hvr-bounce-to-right"><span style="font-size:30px;">&#8614;</span> Quick Forge</a>
			</div>

			<hr/>
			
			<span class="media-upload-admin"></span>
			<div class="cf">
			<form id="mediaupload" action="/media" method="post" enctype="multipart/form-data">
				<a href="/media" class="hvr-bounce-to-right left-nav">Media Gallery</a>
				<span class="media-upload-admin-sub admin-ico"></span>
				<a class="upload-media-link hvr-bounce-to-right" href="#" onclick="$(this).next().click();"><span style="font-size:30px;">&#8614;</span> Upload </a>
				<input type="file" name="file[]" style="display:none;" id="file" multiple="multiple" />
			</form>
			</div>
			
			<script>
				$(document).on('change', '#file', function(){ $('#mediaupload').submit(); });
			</script>
			
			<hr/>
			
			<span class="chatbox-admin admin-ico"></span>
			<a class="hvr-bounce-to-right chatbox-link" href="/admin/comments">Chatbox</a>
			
			<hr />
			
			<span class="plugins-admin admin-ico"></span>
			<div class="cf"><a class="hvr-bounce-to-right" href="/plugins">Browse Plugins</a></div>
			
			<hr />
			<span class="theme-admin admin-ico"></span>
			<div class="cf"><a class="hvr-bounce-to-right" href="/themes">Browse Themes</a></div>

			<hr/>
			
			<span class="translate-admin admin-ico"></span>
			<div class="cf"><a class="hvr-bounce-to-right" href="/translate">Translate Interface</a></div>

			<hr/>

			<span class="settings-admin admin-ico"></span>
			<div class="cf"><a class="hvr-bounce-to-right" href="/settings">Settings</a></div>

			<hr/>
			
			<span class="logout-admin admin-ico"></span>
			<div class="cf"><a class="hvr-bounce-to-right logout" href="/admin/logout">Logout</a></div>
			
			<a href="#" class="fold-admin hvr-skew-backward"><img src="/admin/files/img/fold.png" height="35" height="35" /></a>

		</div>
		<a href="#" class="unfold-admin hvr-grow"><img src="/admin/files/img/unfold.png" height="75" height="75" /></a>

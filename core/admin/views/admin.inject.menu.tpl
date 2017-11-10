		<div class="top-bar admin-bar">
			<form action="">
				<input type="text" placeholder="Post quick update to the cloud..." />
				<a href="/user" class="email">[user.email]</a>
			</form>
			<a class="home hvr-grow" href="/">
				<img src="/core/admin/files/img/ico/home.png" style="float:left;" />
				<span style="float:left;">
					<span class="quick-forge-ico admin-ico"></span><span class="title-left">Shift</span><span class="title-right">Smith</span>
				</span>
			</a>
			<a class="messages" href=""><span class="notifications new">0</span></a>
		</div>
		<div class="left-bar admin-bar">

			<a href="/core/admin/shiftsmith" class="hvr-bounce-to-right" title="Create content with the Forge"><span class="quick-forge-ico admin-ico"></span><span class="title-right tidy-up">Forge</span></a>
			
			<a class="upload-media-link hvr-bounce-to-right" href="/core/admin/forged">
				<span class="media-upload-admin-sub quick-forge-ico"></span>
				<span style="font-size:30px;">&#8614;</span> <span class="title-right tidy-up">Forged</span>
			</a>

		
			<div class="cf">
				<form id="mediaupload" action="/media" method="post" enctype="multipart/form-data">
					<a href="/media" class="hvr-bounce-to-right">
						<span class="media-upload-admin"></span>
						<span class="title-right tidy-up">Media Gallery</span>
					</a>
					<a class="upload-media-link hvr-bounce-to-right" href="#" onclick="$(this).next().click();">
						<span class="media-upload-admin-sub admin-ico"></span>
						<span style="font-size:30px;">&#8614;</span> <span class="title-right tidy-up">Upload</span>
					</a>
					<input type="file" name="file[]" style="display:none;" id="file" multiple="multiple" />
				</form>
			</div>
			
			<script>
				$(document).on('change', '#file', function(){ $('#mediaupload').submit(); });
			</script>
			
			<hr/>
			
			
			<a href="/core/admin/shiftwalk" class="hvr-bounce-to-right"><span class="chatbox-admin admin-ico"></span><span class="title-right tidy-up">Shift Tree</span></a>

			
			<a href="/core/admin/comments" class="hvr-bounce-to-right"><span class="chatbox-admin admin-ico"></span><span class="title-right tidy-up">ChatBox</span></a>
			
			<hr />
			
			<div class="cf"><a class="hvr-bounce-to-right" href="/plugins"><span class="plugins-admin admin-ico"></span><span class="title-right tidy-up">Plugins</span></a></div>
			
			<hr />
			
			<div class="cf"><a class="hvr-bounce-to-right" href="/themes"><span class="theme-admin admin-ico"></span><span class="title-right tidy-up">Themes</span></a></div>

			<hr/>
			
			
			<div class="cf"><a class="hvr-bounce-to-right" href="/translate"><span class="translate-admin admin-ico"></span><span class="title-right tidy-up">Translations</span></a></div>

			<hr/>
			
			<div class="cf"><a class="hvr-bounce-to-right" href="/settings"><span class="settings-admin admin-ico"></span><span class="title-right tidy-up">Settings</span></a></div>

			<hr/>
			
			<div class="cf"><a class="hvr-bounce-to-right logout" href="/core/admin/logout"><span class="logout-admin admin-ico"></span><span class="title-right tidy-up">Logout</span></a></div>
			
			<a href="#" class="fold-admin hvr-skew-backward"><img src="/core/admin/files/img/fold.png" height="35" height="35" /></a>

		</div>
		<a href="#" class="unfold-admin hvr-grow"><img src="/core/admin/files/img/unfold.png" height="75" height="75" /></a>

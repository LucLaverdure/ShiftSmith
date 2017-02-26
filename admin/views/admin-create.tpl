[admin-header.tpl]

	<form method="post" action="" enctype="multipart/form-data">
	
			<div class="parallax-window sub" data-parallax="scroll" data-image-src="/admin/files/img/login-bg.png">

					<div class="wrapper-login cf">
						<h2>Forged - Database entries</h2>
			[if:'[prompt.message]' != '']
						<div class="message">[prompt.message]</div>
			[endif]

			[if:'[prompt.error]' != '']
						<div class="error">[prompt.error]</div>
			[endif]
					</div>
			</div>

			<div class="wrapper">
					
					<div class="breadcrumbs"><a href="/user" class="breadcrumbs">Administration</a> &gt; Account Creation</div>

[if:'[prompt.message]' != '']
			<div class="message">[prompt.message]</div>
[endif]

[if:'[prompt.error]' != '']
			<div class="error">[prompt.error]</div>
[endif]
			
			<form id="thisform" action="/user" method="post">
		
				<label>
					<h2 class="header-block required"><span></span>Email</h2>
					<input id="forge-url" class="forge-url" type="text" value="[trigger.email]" name="trigger.url" />
				</label>

				<label>
					<h2 class="header-block required"><span></span>Password</h2>
					<input id="forge-url" class="forge-url" type="text" value="[trigger.password]" name="trigger.password" />
				</label>

				<label>
					<h2 class="header-block required"><span></span>Repeat Password</h2>
					<input id="forge-url" class="forge-url" type="text" value="[trigger.email]" name="trigger.password2" />
				</label>
				
			</form>	
			
				<a href="#" onclick="$('#thisform').submit();" class="button login-button hvr-shutter-in-horizontal">
				Create Admin Account</a>

			</div>
			
			
		</div>
</div>
</div></div></body>

[admin-footer.tpl]
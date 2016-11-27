[admin-header.tpl]
	
		<div class="login">

			<div id="stage" style="">
				<div id="spinner" class="logo"></div>
			</div>

			<div class="hideonhover">
			
			<h1>[prompt.title]</h1>
			
[if:'[prompt.message]' != '']
			<div class="message">[prompt.message]</div>
[endif]

[if:'[prompt.error]' != '']
			<div class="error">[prompt.error]</div>
[endif]

			<form id="thisform" action="/user" method="post">
		
				<p class="login-input"><label>Email: <input type="text" name="email" class="input-email-login" placeholder="admin@luclaverdure.com" /></label></p>
				<p class="login-input"><label>Password: <input type="password" name="password" class="input-email-login" /></label></p>
			
				<input type="hidden" name="login_entry" value="true" />
			
			</form>	
			
			</div>
			
			<p><a href="#" class="button login-button hvr-shutter-in-horizontal">Login</a></p>
			
		</div>

[admin-footer.tpl]
[admin-header.tpl]
<form id="thisform" action="/user" method="post">
<div class="parallax-window" data-parallax="scroll" data-image-src="/admin/files/img/login-bg.png">
	<h1 class="hero">ShiftSmith</h1>
	<h2>User Login</h2>

		<div class="wrapper-login">

[if:'[prompt.message]' != '']
		<div class="message">[prompt.message]</div>
[endif]

[if:'[prompt.error]' != '']
		<div class="error">[prompt.error]</div>
[endif]
		
		
			<p class="login-input"><label><span>Email:</span> <input type="text" name="email" class="input-email-login" placeholder="admin@luclaverdure.com" /></label></p>
			<p class="login-input"><label><span>Password:</span> <input type="password" name="password" class="input-email-login" /></label></p>
		
			<input type="hidden" name="login_entry" value="true" />
			
			<a href="#" class="button login-button">Login</a>
		</div>	


</div>
</form>	
<div class="download-hero">
	<div class="wrapper">
		<span class="letspa">Free, Fast, Friendly!</span>
	</div>
</div>


</div>
</div>

[admin-footer.tpl]
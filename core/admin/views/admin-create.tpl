[admin-header.tpl]
<form id="thisform" action="/user" method="post">
<div class="parallax-window" data-parallax="scroll" data-image-src="/core/admin/files/img/login-bg.png">
	<h1 class="hero">ShiftSmith</h1>
	<h2>Create Admin Account</h2>

		<div class="wrapper-login">


[if:'[prompt.message]' != '']
			<div class="message">[prompt.message]</div>
[endif]

[if:'[prompt.error]' != '']
			<div class="error">[prompt.error]</div>
[endif]
			
			<p class="login-input"><label><span>New Admin Email:</span> <input type="text" name="trigger.email" class="input-email-login" placeholder="admin@luclaverdure.com" /></label></p>
			<p class="login-input"><label><span>New Admin Password:</span> <input type="password" name="trigger.password"  class="input-email-login" /></label></p>
			<p class="login-input"><label><span>Repeat Password:</span> <input type="password" name="trigger.password2"  class="input-email-login" /></label></p>

			<input type="hidden" name="trigger.entry" value="true" />
			
			<input type="submit" class="button login-button" value="Login" />
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

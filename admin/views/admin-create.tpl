[admin-header.tpl]
	
		<div class="login">

			<div class="hideonhover">
			
			<h1 style="border-radius:50px;background:#aaaaff;padding:20px;box-sizing:border-box;color:#fff;">[prompt.title]</h1>

[if:'[prompt.message]' != '']
			<div class="message">[prompt.message]</div>
[endif]

[if:'[prompt.error]' != '']
			<div class="error">[prompt.error]</div>
[endif]
			
			<form id="thisform" action="/user" method="post">
		
				<p style="background:#fff;padding:10px;border-radius:5px;width:100%;box-sizing:border-box;"><label>Email: <input type="text" name="email"  style="width:90%;" /></label></p>
				<p style="background:#fff;padding:10px;border-radius:5px;width:100%;box-sizing:border-box;"><label>Password: <input type="password" name="password" style="width:90%;"/></label></p>
				<p style="background:#fff;padding:10px;border-radius:5px;width:100%;box-sizing:border-box;"><label>Password (repeat): <input type="password" name="password2" style="width:90%;"/></label></p>
			
			</form>	
			
			</div>
			
			<p><a href="#" onmouseenter="$('.hideonhover').css('opacity','0.6');" 
			onmouseleave="$('.hideonhover').css('opacity','1');"
			onclick="$('#thisform').submit();"
			class="button login-button hvr-shutter-in-horizontal">Create Admin Account</a></p>
			
		</div>

[admin-footer.tpl]
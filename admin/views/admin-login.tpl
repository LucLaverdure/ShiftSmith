[admin-header.tpl]
<body class="admin">

	<div style="" class="cf">
	
		<div style="max-width:1024px;width:100%;margin:0 auto;" class="cf">
		
	
<div class="highlight cf">
				<div class="inner-wrapper cf">
					<div class="header">
						<div class="head-left">
							<div id="stage" style="">
								<div id="spinner" class="logo"></div>
							</div>
							<a href="/">
								<h1>
<span class="title-left">Shift</span><span class="title-right">Smith</span>
</h1>
							</a>
						</div>
					</div>
				</div>
			</div>

			<div class="login">

			<div class="hideonhover">
			
			<h3>User Login</h3>

			<form id="thisform" action="/user" method="post">

[if:'[prompt.message]' != '']
			<div class="message">[prompt.message]</div>
[endif]

[if:'[prompt.error]' != '']
			<div class="error">[prompt.error]</div>
[endif]
			
				<p class="login-input"><label>Email: <input type="text" name="email" class="input-email-login" placeholder="admin@luclaverdure.com" /></label></p>
				<p class="login-input"><label>Password: <input type="password" name="password" class="input-email-login" /></label></p>
			
				<input type="hidden" name="login_entry" value="true" />
			
			</form>	
			
			</div>
			
			<p><a href="#" class="button login-button hvr-shutter-in-horizontal"><img src="/admin/files/img/key.png" alt="key">Login</a></p>
			
		</div>
</div>
</div>
</body>
[admin-footer.tpl]
[admin/header.tpl]
<form action="" method="post">
	<div class="login-box cf">
		<div class="login cf">
			<div class="logo"></div>
			<div class="login title-heads">
				<h1>Dream Forgery</h1>
				<h2>Administration</h2>
			</div>
		</div>
		<div class="login login-list">
			<p><label><span style="display:none;">Invalid </span>Admin Email: <input id="email" type="text" name="email" value="[user.email]" placeholder="user@dreamforgery.com" /></label></p>
			<p><label><span style="display:none;">Invalid </span>Password: <input id="password" type="password" name="password" /></label></p>
			<p><label><span style="display:none;">Invalid </span>Password (type again): <input id="password2" type="password" name="password2" /></label></p>
			<p><input type="submit" value="Create User" /></p>
		</div>
	</div>
</form>
	<script>
		setTimeout(function() {
			if ('[misc.fail]'=='redbg') {
				if ('[user.email]' != '') {
					$('.login-box').addClass('redbg');
					$('.login span').fadeIn('fast');
				}
			} else if ('[misc.fail]'=='greenbg') {
				$('.login-box').removeClass('redbg');
				$('.login-box').addClass('greenbg');
				$('.login-list').html('Please check your email to confirm the admin account.');
			}
		}, 100);
		$('#email').keydown(function() {
			$('.login-box').removeClass('redbg');
			$('.login span').fadeOut('fast');
		});
		$('#password').keydown(function() {
			$('.login-box').removeClass('redbg');
			$('.login span').fadeOut('fast');
		});
		
	</script>

[admin/footer.tpl]

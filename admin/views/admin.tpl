[webapp/admin/views/header.tpl]
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
			<p><label><span style="display:none;">Invalid </span>Email: <input id="email" type="text" name="email" value="[user.email]" placeholder="user@dreamforgery.com" /></label></p>
			<p><label><span style="display:none;">Invalid </span>Password: <input id="password" type="password" name="password" /></label></p>
			<p><input type="submit" value="Login" /></p>
		</div>
	</div>
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
			} else if ('[misc.fail]'=='greenbg2') {
				$('.login-box').removeClass('redbg');
				$('.login-box').addClass('greenbg');
				$('.login-list').html('Email activated successfully. <a href="/admin">Click here</a> to login as an administrator.');
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
</form>
[webapp/admin/views/footer.tpl]

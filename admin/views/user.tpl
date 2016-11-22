[admin/adminHeader.tpl]
<div class="login">

	<h1 style="border-radius:50px;background:#aaaaff;padding:20px;">[glob.title]</h1>
	
	<form action="/user" method="post">

	<div data-img-src="/files/img/landscapes/home.jpg" class="char-bg" styl;e="min-height:500px;"></div>
	
	<p style="background:#fff;padding:10px;border-radius:5px;width:90%;"><label>Email: <input type="text" name="email"  style="width:90%;" /></label></p>
	<p style="background:#fff;padding:10px;border-radius:5px;width:90%;"><label>Password: <input type="password" name="password" style="width:90%;"/></label></p>
	<p style="background:#fff;padding:10px;border-radius:5px;width:90%;"><label>Password (repeat): <input type="password" name="password2" style="width:90%;"/></label></p>
	
	<p style="border-radius:5px;padding:20px;background:orange;text-align:center;"><a href="/" style="background:orange;color:#fff;font-size:20px;width:100%;display:block;">Login</a></a></p>
	
	</form>	
	
</div>
[admin/adminFooter.tpl]
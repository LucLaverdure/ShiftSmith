[admin-header.tpl]
		<style>
			.line a.del {
				display:block !important;
			}
		</style>
<div class="parallax-window sub" data-parallax="scroll" data-image-src="/admin/files/img/login-bg.png">
		<div class="wrapper-login cf">
			<h1>Comments</h1>
[if:'[prompt.message]' != '']
			<div class="message">[prompt.message]</div>
[endif]

[if:'[prompt.error]' != '']
			<div class="error">[prompt.error]</div>
[endif]
		</div>
		[admin-panel.tpl]
		<div class="wrapper">
			<div class="plugin-box">
				<div class="chatterbox"></div>
			</div>
		</div>
</div>

[admin-footer.tpl]
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

		</div>

[admin-footer.tpl]
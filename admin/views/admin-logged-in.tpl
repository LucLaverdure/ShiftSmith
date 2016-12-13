[admin-header.tpl]
<body class="shiftsmith">

	<div style="" class="cf">
	
		<div style="max-width:1024px;width:100%;margin:0 auto;" class="cf">
	
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
</div></div></body>

[admin-footer.tpl]
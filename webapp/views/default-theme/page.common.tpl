[default-theme/header.tpl]

<div class="parallax-window sub" data-parallax="scroll" data-image-src="/files/img/home-bg.jpg">
	<h1 class="hero">ShiftSmith - [page.title]</h1>
</div>

<div class="wrapper features-area cf">
	<div>
		[page.body]
	</div>

	[for:posts]
		<div>
			<h2>[posts.title]</h2>
			<div>
				[posts.body]
			</div>
		</div>
	[end:posts]
	
</div>

[default-theme/footer.tpl]
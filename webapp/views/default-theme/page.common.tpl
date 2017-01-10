[default-theme/header.tpl]

<div class="inner-wrapper" id="mvc">

	<h1>[page.title]</h1>

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
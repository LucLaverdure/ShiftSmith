
[admin-header.tpl]

<div class="parallax-window sub" data-parallax="scroll" data-image-src="/core/admin/files/img/login-bg.png">

		<div class="wrapper cf">
			<h1 class="hero">[prompt.title]</h1>
[if:'[prompt.message]' != '']
			<div class="message">[prompt.message]</div>
[endif]

[if:'[prompt.error]' != '']
			<div class="error">[prompt.error]</div>
[endif]
		</div>
</div>

[admin-panel.tpl]

<div class="content docs-list">
	<div id="pie">
	</div>
</div>

<script type="text/javascript">
var pie = new d3pie("pie", {
	header: {
		title: {
			text: "Content Tags",
			fontSize: 24
		}
	},
	labels : {
		"mainLabel": {
			"fontSize": 24
		},
		"percentage": {
			"fontSize": 24
		}
	},
	data: {
		content: [
			[for:d3data]
			{ label: '[d3data.value]', value: [d3data.valcount]},
			[end:d3data]
		]
	}
});
</script>
[admin-footer.tpl]
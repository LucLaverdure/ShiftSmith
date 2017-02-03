[admin-header.tpl]
<div class="parallax-window sub" data-parallax="scroll" data-image-src="/admin/files/img/login-bg.png">

		<div class="wrapper-login cf">
			<h2>[prompt.title]</h2>
[if:'[prompt.message]' != '']
			<div class="message">[prompt.message]</div>
[endif]

[if:'[prompt.error]' != '']
			<div class="error">[prompt.error]</div>
[endif]
		</div>
</div>

<div class="wrapper admin-panel">
	<div class="left-col">
		<p><span class="letspa">Administration</span></p>
		<form id="mediaupload" action="/media" method="post" enctype="multipart/form-data">
		<ul>
			<li class="branch"><a href="/admin/forge">Dashboard</a></li>
			<li class="branch"><a href="/admin/forge">Forge</a></li>
			<li><a href="/admin/forged">&gt; Forged</a></li>
			<li class="branch"><a href="/admin/forge">Upload Media</a></li>
			<li><a href="/admin/media">&gt; Gallery</a></li>
			<li class="branch"><a href="/admin/comments">Comments</a></li>
			<li class="branch"><a href="/admin/plugins">Plugins</a></li>
			<li class="branch"><a href="/admin/themes">Themes</a></li>
			<li class="branch"><a href="/admin/translate">Translations</a></li>
			<li class="branch"><a href="/admin/settings">Settings</a></li>
			<li class="branch"><a href="/admin/logout">Logout</a></li>
		</ul>
		</form>
	</div>
		
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
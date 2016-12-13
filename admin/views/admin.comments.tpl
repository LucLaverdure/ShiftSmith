[admin-header.tpl]
<body class="shiftsmith">

	<div style="" class="cf">
	
		<div style="max-width:1024px;width:100%;margin:0 auto;" class="cf">
		

	<h1>Comments</h1>

	[for:box]
		<h1>[box.room_id] Chatbox</h1>
		chatbox[[box.room_id]]
		<span class="del"></span>
	[end:box]
</div>
</div>
</body>	
[admin-footer.tpl]
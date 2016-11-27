[admin-header.tpl]

	<h1>Comments</h1>

	[for:box]
		<h1>[box.room_id] Chatbox</h1>
		chatbox[[box.room_id]]
		<span class="del"></span>
	[end:box]
	
[admin-footer.tpl]
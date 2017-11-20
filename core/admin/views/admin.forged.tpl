[admin-header.tpl]

	<form method="post" action="" enctype="multipart/form-data">
	
			<div class="parallax-window sub" data-parallax="scroll" data-image-src="/core/admin/files/img/login-bg.png">

						<div class="wrapper">
							<h1 class="hero">Forged</h1>
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
					<div class="breadcrumbs"><a href="/user" class="breadcrumbs">Administration</a> &gt; <a href="/admin/forged">Forged</a> &gt; Database entries</div>
					
					<h2>Database Entries</h2>
				<form action="" method="post">
					<div class="forged">
						<div class="head cf">
							<div class="cell">URL Trigger</div>
							<div class="cell">Title</div>
							<div class="cell">Tags</div>
							<div class="cell operations">Actions</div>
						</div>
						<div class="action-box">
							With Selected:
							<select name="action">
								<option value="del">Delete</option>
							</select>
							<input type="submit" value="Process" />
						</div>
					[for:forged]
						<div class="row cf">
							<div class="cell chk"><input type="checkbox" name="chkItem[]" class="itemSel" value="[forged.content.id]" /></div>
							<div class="cell">[forged.content.url]&nbsp;</div>
							<div class="cell">[forged.content.title]&nbsp;</div>
							<div class="cell">[forged.tags]&nbsp;</div>
							<div class="cell operations">
								[forged.content.edit]
								&mdash;
								<a href="[forged.content.url]" class="hvr-wobble-skew hvr-grow">View</a>
								&mdash;
								<a href="/admin/del/db/[forged.content.id]" class="delete hvr-wobble-skew hvr-grow">Delete</a>
							</div>
						</div>
					[end:forged]
						<div class="action-box">
							With Selected:
							<select name="action">
								<option value="del">Delete</option>
							</select>
							<input type="submit" value="Process" />
						</div>
					</div>
				</form>
					<h2>File Entries</h2>
					
					<div class="forged">
						<div class="head cf">
							<div class="cell">Controller</div>
							<div class="cell">Filename</div>
							<div class="cell operations">Actions</div>
						</div>
						
						<div class="file-forged">
						[for:forgedfile]
							<div class="row cf">
								<div class="cell">[forgedfile.name]&nbsp;</div>
								<div class="cell filename">[forgedfile.filename]&nbsp;</div>
								<div class="cell operations">
									<a href="/admin/file/editor?filename=[forgedfile.filename]" class="hvr-wobble-skew hvr-grow">Edit Controller</a>
								&mdash;
									<a href="/admin/shiftsmith/delete/[forged.id]" class="delete hvr-wobble-skew hvr-grow">Delete</a>
								</div>
							</div>
						[end:forgedfile]
						</div>
					</div>
			</div>

</form>

[admin-footer.tpl]
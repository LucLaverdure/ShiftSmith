[admin-header.tpl]
<body class="shiftsmith">

	<form method="post" action="" enctype="multipart/form-data">
	
	<div style="" class="cf">
	
		<div style="max-width:1024px;width:100%;margin:100px auto;" class="cf">
		
				<div class="admin-panel">

					<!-- Title Of Page (Not input)-->
					<h1 class="create" style="font-weight:800;">
						<img src="/admin/files/img/ico/forge.png" title="Forge" />
						Forged Items
					</h1>
					
					<h2>Database entries</h2>
					
					<div class="forged">
						<div class="head cf">
							<div class="cell">URL Trigger</div>
							<div class="cell">Title</div>
							<div class="cell">Actions</div>
						</div>
						<hr/>
					[for:forged]
						<div class="row cf">
							<div class="cell">[forged.url]&nbsp;</div>
							<div class="cell">[forged.title]&nbsp;</div>
							<div class="cell">
								<a href="/admin/shiftsmith/[forged.id]" class="hvr-wobble-skew hvr-grow">Edit</a>
								|
								<a href="[forged.url]" class="hvr-wobble-skew hvr-grow">View</a>
								|
								<a href="/admin/del/db/[forged.id]" class="delete hvr-wobble-skew hvr-grow">Delete</a>
							</div>
						</div>
					[end:forged]
					</div>

					<h2>Controller (File) Entries</h2>

					<div class="forged">
						<div class="head cf">
							<div class="cell">Controller</div>
							<div class="cell">Filename</div>
							<div class="cell">Actions</div>
						</div>
						<hr/>
						<div class="file-forged">
						[for:forgedfile]
							<div class="row cf">
								<div class="cell">[forgedfile.name]&nbsp;</div>
								<div class="cell">[forgedfile.filename]&nbsp;</div>
								<div class="cell" style="float:right;">
									<a href="/admin/file/editor?filename=[forgedfile.filename]" class="hvr-wobble-skew hvr-grow">Edit Controller</a>
									|
									<a href="/admin/shiftsmith/delete/[forged.id]" class="delete hvr-wobble-skew hvr-grow">Delete</a>
								</div>
							</div>
						[end:forgedfile]
						</div>
					</div>

					
					
				</div>
		</div>
</body>

[admin-footer.tpl]
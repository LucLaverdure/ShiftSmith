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
								<a href="/admin/shiftsmith/[forged.id]">Edit</a>
								|
								<a href="[forged.url]">View</a>
							</div>
						</div>
					[end:forged]
					</div>
					
				</div>
		</div>
</body>

[admin-footer.tpl]
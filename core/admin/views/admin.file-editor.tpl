[admin-header.tpl]
<body class="shiftsmith">

	<form method="post" action="" enctype="multipart/form-data">
	
	<div class="cf">
	
		<div style="max-width:1024px;width:100%;margin:100px auto;" class="cf">
		
				<div class="admin-panel">

					<!-- Title Of Page (Not input)-->
					<h1 class="create" style="font-weight:800;">
						<img src="/core/admin/files/img/ico/forge.png" title="Forge" />
						File Editor
					</h1>
					
					<h2>[file.name]</h2>
					
					<textarea id="ckeditor" name="body" placeholder="Write your story here.">[file.contents]</textarea>
										
					<script type="text/javascript">

					// Replace the <textarea id="editor1"> with a CKEditor
					// instance, using default configuration.
					$(function() {
						CKEDITOR.config.allowedContent = true;
						CKEDITOR.config.startupMode = 'source';
						CKEDITOR.config.protectedSource.push(/<\?[\s\S]*?\?>/g);
						CKEDITOR.replace( 'ckeditor' );
					});
					
				</div>
				
		</div>
		<div class="save-wrapper">
			<div style="max-width:1024px;width:100%;margin:0px auto;" class="cf">
					<p class="pipeline">
						<a href="#" onclick="$(this).parents('form').submit();" class="process-button download-button hvr-grow">
							<img src="/core/admin/files/img/save.png" alt="Submit &amp; Save" />
							<span class="title-left">Save</span> <span class="title-right">It!</span>
						</a>
					</p>
			</div>		
		</div>
</body>

[admin-footer.tpl]
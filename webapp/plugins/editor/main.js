function initEditor() {
	tinymce.remove();
	tinymce.init({
		branding: false,
		closeOnEscape: false,
		selector:'*[data-edit]',
		menubar: false,
		inline: true,
		plugins: [
			'lists',
			'autolink',
			'link'
		],
		fixed_toolbar_container: "#main-p",
		powerpaste_word_import: 'clean',
		powerpaste_html_import: 'clean',
		toolbar: [
			'undo redo | bold italic underline | link | fontselect fontsizeselect',
			'forecolor backcolor | alignleft aligncenter alignright alignfull | numlist bullist outdent indent'
		]
	});
}
setInterval(function(){ 
	$(".tox").each(function() {
		if (parseInt($(this).css("top"), 10) < 0) {
			$(this).css("top", "auto");
			$(this).css("bottom", "0");
		}
	});
}, 1000);
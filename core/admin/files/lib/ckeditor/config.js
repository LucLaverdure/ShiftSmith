/**
 * @license Copyright (c) 2003-2016, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
	config.height = '500px';
	config.protectedSource.push( /<\?php[\s\S]*/g );   // PHP Code
	config.protectedSource.push( /<%[\s\S]*?%>/g );   // ASP Code
	config.protectedSource.push( /(]+>[\s|\S]*?<\/asp:[^\>]+>)|(]+\/>)/gi );   // ASP.Net Code
};

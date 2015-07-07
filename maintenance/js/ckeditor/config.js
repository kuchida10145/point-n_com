/**
 * @license Copyright (c) 2003-2013, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.html or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
	config.language = 'ja';

	//config.filebrowserBrowseUrl = '/maintenance/js/kcfinder/browse.php?type=files';
	//config.filebrowserUploadUrl = '/maintenance/js/kcfinder/upload.php?type=files';

		// Remove some buttons, provided by the standard plugins, which we don't
	// need to have in the Standard(s) toolbar.
	config.removeButtons = 'Underline,Subscript,Superscript';

	// Se the most common block elements.
	config.format_tags = 'p;h1;h2;h3;pre';

	// Make dialogs simpler.
	config.removeDialogTabs = 'image:advanced;link:advanced';
	//
	config.enterMode = CKEDITOR.ENTER_BR;
	config.allowedContent = true;
	
	

	
config.toolbar = [
	{ name: 'editing', groups: [ 'find', 'selection', 'spellchecker' ] },
	
	
	{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ], items: [ 'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', 'TextColor','-', 'RemoveFormat' ] },
	/*{ name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ], items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl', ] },*/
	//{ name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ], items: [ 'NumberedList', 'BulletedList', '-', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl', ] },
	{ name: 'links', items: [ 'Link', 'Unlink'] },
	//{ name: 'insert', items: [ 'Table', 'HorizontalRule',  'SpecialChar', ] },
	'/',
	{ name: 'document', groups: [ 'mode', 'document', 'doctools' ], items: [ 'Source'] },
	//{ name: 'styles', items: [ 'Styles', 'Format', 'Font', 'FontSize' ] },
	//{ name: 'styles', items: [ 'Styles'] },
	//{ name: 'colors', items: [ 'TextColor', 'BGColor' ] },
	//{ name: 'tools', items: [ 'Maximize', 'ShowBlocks' ] },
	{ name: 'others', items: [ '-' ] },
];


};

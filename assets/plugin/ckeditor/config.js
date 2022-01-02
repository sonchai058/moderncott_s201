/**
 * @license Copyright (c) 2003-2015, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
	config.skin = 'office2013';
	
	config.contentsCss = location.protocol+"//"+ location.host+'/lptechnic/assets/plugin/ckeditor/fontsset.css';
	config.font_names = 'Thai Sans Lite/ThaiSansLite;' + config.font_names;
	config.font_names = 'DSNPatPongExtend/DSN PatPong Extend;' + config.font_names;
};

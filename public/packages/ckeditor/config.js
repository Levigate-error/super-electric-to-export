/**
 * @license Copyright (c) 2003-2018, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see https://ckeditor.com/legal/ckeditor-oss-license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
    // config.extraPlugins = 'uploadimage';
    // config.imageUploadUrl = '/uploader/upload.php?type=Images';
    config.filebrowserUploadUrl = '/upload-image';
    // config.extraPlugins = 'html5video';
    config.extraPlugins = 'html5video,widget,widgetselection,clipboard,lineutils';
};

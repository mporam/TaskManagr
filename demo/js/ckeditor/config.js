/**
 * @license Copyright (c) 2003-2013, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.html or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
	config.font_defaultLabel = 'Arial';
	config.fontSize_defaultLabel = '12px';
	config.allowedContent = true;
	config.extraPlugins = 'youtube';

   config.filebrowserBrowseUrl = '/orbit-admin/media/kcfinder/browse.php?type=files';
   config.filebrowserImageBrowseUrl = '/orbit-admin/media/kcfinder/browse.php?type=images';
   config.filebrowserFlashBrowseUrl = '/orbit-admin/media/kcfinder/browse.php?type=flash';
   config.filebrowserUploadUrl = '/orbit-admin/media/kcfinder/upload.php?type=files';
   config.filebrowserImageUploadUrl = '/orbit-admin/media/kcfinder/upload.php?type=images';
   config.filebrowserFlashUploadUrl = '/orbit-admin/media/kcfinder/upload.php?type=flash';
};
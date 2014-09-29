/*
 * Admin Scripts File
 * Author: Matthew Stumphy
 * Runs in the admin area
*/

function projectVideoVisibility($) {
	$('#_senna_project_gallery_images_repeat .cmb2_option').each(function() {
		if ($(this).prop('checked')) {
			$(this).closest('.cmb-nested').find('.cmb-type-oembed').slideDown();
		} else {
			$(this).closest('.cmb-nested').find('.cmb-type-oembed').slideUp();
		}
	})
}

jQuery(document).ready(function($) {
	projectVideoVisibility($);
	$('#_senna_project_gallery_images_repeat').on('change', '.cmb2_option', function() {
		projectVideoVisibility($)
	});
}); /* end of as page load scripts */


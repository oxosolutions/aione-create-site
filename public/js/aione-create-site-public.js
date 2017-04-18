(function( $ ) {
	'use strict';

	/**
	 * All of the code for your public-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */
	 
	jQuery(document).ready(function () {
	
		jQuery('#create_website_form').validate({ // initialize the plugin
			rules: {
				create_website_form_site_url: {
					required: true,
					minlength: 4
				},
				create_website_form_site_title: {
					required: true,
				},
				captcha_value: {
					required: true,
					minlength: 6
				}
			}
		});
		
	});

	jQuery("#create_website_form_site_url").bind("change paste keyup", function() {
		jQuery(this).val(jQuery(this).val().toLowerCase().replace(/ /g, '').replace(/[\*\^\'\!\+\/\=\@\#\$\&\`\~\,\.\/\<\>\%\(\)\_\-\;\:\"|?]/g,''));
		var suffixLeft = jQuery(this).textWidth() + 12;
		if(suffixLeft > 12 && suffixLeft <= 305){
			jQuery("#create_website_form_site_url_suffix").css('left', suffixLeft + 'px');
			jQuery("#create_website_form_site_url_suffix").css('color','#454545');
		} else if(suffixLeft > 305){
			jQuery("#create_website_form_site_url_suffix").css('left', '305px');
			jQuery("#create_website_form_site_url_suffix").css('color','#454545');		
		} else {
			jQuery("#create_website_form_site_url_suffix").css('left', '120px');
			jQuery("#create_website_form_site_url_suffix").css('color','#b8b8b8');
		}
	});
	
	jQuery.fn.textWidth = function(text, font) {
		if (!jQuery.fn.textWidth.fakeEl) jQuery.fn.textWidth.fakeEl = jQuery('<span>').hide().appendTo(document.body);
		jQuery.fn.textWidth.fakeEl.text(text || this.val() || this.text()).css('font', font || this.css('font'));
		return jQuery.fn.textWidth.fakeEl.width();
	};	
	 
	 
	 

})( jQuery );

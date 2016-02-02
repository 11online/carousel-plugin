jQuery(document).ready(function() {

	jQuery('.sortable').sortable();

	var slideCount = 1;
	jQuery("#addSlide").click(function() {
		jQuery(".slideGroup:last").after(
			"<tbody class=\"slideGroup\"><tr><td><h2>New Slide</h2></td></tr><tr><td><label for=\"carousel_image_array\">Image Url</label></td><td><input class=\"newSlide" + slideCount + "\" name=\"carousel_image_array[]\" type=\"text\"><input class=\"upload_image_button button\" id=\"newSlide" + slideCount + "\" type=\"button\" value=\"Upload Image\" /></td></tr><tr><td><label for=\"carousel_message_array\">Caption</label></td><td><input name=\"carousel_message_array[]\" type=\"text\"></td></tr><tr><td><label for=\"carousel_link_array\">Link</label></td><td><input name=\"carousel_link_array[]\" type=\"text\"></td></tr><tr class=\"deleteSlide\"><td><a class=\"button button-primary\">Delete This Slide</a></td></tr></tbody>"
		);
		slideCount++;
		jQuery(".deleteSlide").click(function() {
			jQuery(this).parent(".slideGroup").remove();
		});
		jQuery('.upload_image_button').click(function(e) {
			var self = jQuery(this);
			uploadImage(e, self);
		});
	});
	jQuery(".deleteSlide").click(function() {
		jQuery(this).parent(".slideGroup").remove();
	});
  var custom_uploader;
  var className;


  jQuery('.upload_image_button').click(function(e) {
		var self = jQuery(this);
		uploadImage(e, self);
	});

	function uploadImage(e, self) {

    e.preventDefault();
    // so we know where to put the image later
    className = self.attr('id');

    //If the uploader object has already been created, reopen the dialog
    if (custom_uploader) {
        custom_uploader.open();
        return;
    }

    //Extend the wp.media object
    custom_uploader = wp.media.frames.file_frame = wp.media({
        title: 'Choose Image',
        button: {
            text: 'Choose Image'
        },
        multiple: false
    });

    //When a file is selected, grab the URL and set it as the text field's value
    custom_uploader.on('select', function() {
        attachment = custom_uploader.state().get('selection').first().toJSON();
        jQuery('.' + className).val(attachment.url);
    });

    //Open the uploader dialog
    custom_uploader.open();

  }
});

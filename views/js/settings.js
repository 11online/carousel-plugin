jQuery(document).ready(function() {

	jQuery('.sortable').sortable();

	var slideCount = 1;
	jQuery("#addSlide").click(function() {
		jQuery(".slideGroup:last").after(
			"<tbody class=\"slideGroup\"><tr><td><h2>New Slide</h2></td></tr><tr><td><label for=\"quote_message_array\">Caption</label></td><td><input name=\"quote_message_array[]\" type=\"text\"></td></tr><tr class=\"deleteSlide\"><td><a class=\"button button-primary\">Delete This Slide</a></td></tr></tbody>"
		);
		slideCount++;
		jQuery(".deleteSlide").click(function() {
			jQuery(this).parent(".slideGroup").remove();
		});
	});
	jQuery(".deleteSlide").click(function() {
		jQuery(this).parent(".slideGroup").remove();
	});
});

elgg.provide('elgg.event_manager');

elgg.event_manager.edit_questions_add_field = function(form) {
	$(form).find("input[type='submit']").hide();
	var guid = $(form).find('input[name="question_guid"]').val();
	
	elgg.action('event_manager/question/edit', {
		data: $(form).serialize(), 
		success: function(data) {
			$.colorbox.close();
			
			if(guid) {
				$('#question_' + guid).replaceWith(data.output);
			} else {
				$('.event_manager_registrationform_fields').append(data.output);
			}
		},
		error: function() {
			$(form).find("input[type='submit']").show();
		}
	});
};

elgg.event_manager.edit_questions_init = function() {
	
	$('.event_manager_registrationform_fields').sortable({
		axis: 'y',
		tolerance: 'pointer',
		opacity: 0.8,
		forcePlaceholderSize: true,
		forceHelperSize: true,
	});
	
	$(document).on('click', '.event_manager_questions_delete', function(e) {
		if (e.isDefaultPrevented()) {
			return;
		}
		$(this).parents('.elgg-item-object-eventregistrationquestion').eq(0).remove();
	});

	$(document).on('change', '#event_manager_registrationform_question_fieldtype', function() {
		var type = $(this).val();
		var $parent = $(this).parents('.elgg-item-object-eventregistrationquestion').eq(0);
		if (type == 'Radiobutton' || type == 'Dropdown') {
			$parent.find('.event_manager_registrationform_select_options').show();
		} else {
			$parent.find('.event_manager_registrationform_select_options').hide();
		}
		
		$.colorbox.resize();
	});
};

elgg.register_hook_handler('init', 'system', elgg.event_manager.edit_questions_init);
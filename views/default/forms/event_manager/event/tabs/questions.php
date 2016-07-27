<?php
$event = elgg_extract('entity', $vars);
if (empty($event)) {
	echo elgg_echo('no event, save first');
	return;
}

elgg_load_js('lightbox');
elgg_load_css('lightbox');
elgg_require_js('event_manager/edit_questions');

// Have to do this for private events
$ia = elgg_set_ignore_access(true);

$output = elgg_view_entity_list($event->getRegistrationFormQuestions(), [
	'list_class' => 'event_manager_registrationform_fields',
	'item_view' => 'forms/event_manager/registrationform/question',
]);

$output .= elgg_view('output/url', [
	'href' => 'javascript:void(0);',
	'data-colorbox-opts' => json_encode([
		'href' => elgg_normalize_url('events/registrationform/question?event_guid=' . $event->guid)
	]),
	'class' => 'elgg-button elgg-button-action elgg-lightbox',
	'text' => elgg_echo('event_manager:editregistration:addfield'),
]);

elgg_set_ignore_access($ia);

echo $output;
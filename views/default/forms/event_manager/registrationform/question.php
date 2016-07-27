<?php

$question = elgg_extract('entity', $vars);
if (!($question instanceof \EventRegistrationQuestion)) {
	return;
}

$event = $question->getContainerEntity();
if (!($event instanceof \Event)) {
	return;
}

$question_guid = $question->guid;

$fieldtype = null;
$fieldoptions = null;
$required = null;
$guid = null;

if ($question instanceof EventRegistrationQuestion) {
	// assume day edit mode
	$guid = $question->getGUID();
	$title = $question->title;
	$fieldtype = $question->fieldtype;
	$required = $question->required;
	$fieldoptions = $question->fieldoptions;
}

if (empty($title)) {
	$title = elgg_echo('event_manager:editregistration:addfield:title');
}

$form_body .= elgg_view('input/hidden', ['name' => 'question_guid', 'value' => $question_guid]);

$question_label = elgg_echo('event_manager:editregistration:question');
$question_label .= elgg_view_input('checkboxes', [
	'name' => 'required',
	'value' => $required,
	'options' => [elgg_echo('event_manager:registrationform:editquestion:required') => '1'],
	'field_class' => 'float-alt man elgg-subtext',
]);
$form_body .= elgg_view_input('text', [
	'label' => $question_label,
	'name' => 'questiontext',
	'value' => $title,
	'field_class' => 'mbs',
]);

$form_body .= '<div class="elgg-col elgg-col-1of4">';
$form_body .= elgg_view_input('select', [
	'label' => elgg_echo('event_manager:editregistration:fieldtype'),
	'id' => 'event_manager_registrationform_question_fieldtype',
	'value' => $fieldtype,
	'name' => 'fieldtype',
	'options' => ['Textfield', 'Textarea', 'Dropdown', 'Radiobutton'],
	'field_class' => 'man',
]);

$form_body .= '</div>';
$form_body .= '<div class="elgg-col elgg-col-3of4">';
$field_class = ['event_manager_registrationform_select_options', 'man'];
if (!in_array($fieldtype, ['Radiobutton', 'Dropdown'])) {
	$field_class[] = 'hidden';
}
$form_body .= elgg_view_input('text', [
	'label' => elgg_echo('event_manager:editregistration:fieldoptions'),
	'name' => 'fieldoptions',
	'value' => $fieldoptions,
	'placeholder' => elgg_echo('event_manager:editregistration:commasepetared'),
	'field_class' => $field_class,
]);
$form_body .= '</div>';

$delete_question = elgg_view('output/url', [
	'href' => 'javascript:void(0);',
	'text' => elgg_view_icon('delete'),
	'class' => 'event_manager_questions_delete',
	'confirm' => elgg_echo('deleteconfirm'),
	'is_action' => false,
]);

echo elgg_view_image_block(elgg_view_icon('arrows', 'link'), $form_body, ['image_alt' => $delete_question]);

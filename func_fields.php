<?php

function sws_manage_items_ck_acfgroup_exists($type='acf-field-group',$name="sws_manage_items_field_group") {
	$exists = false;
	$field_groups = get_posts(array('post_type'=>'acf-field-group'));
	if ($field_groups) {
		//error_log(print_r($field_groups,true),0);
		foreach ($field_groups as $field_group) {
			if (($field_group->post_type == $type) && ($field_group->post_name==$name)) {
				$exists = true;
				error_log($type."|".$name. " EXISTS!",0);
			}
		}
	} 
	if (!$exists) { error_log ($type."|".$name. " DOES NOT EXIST!",0); }
	return $exists;
}

function sws_manage_items_create_acfgroup() { 
	$test=sws_manage_items_ck_acfgroup_exists();
	if (function_exists('acf_add_local_field_group')  && ($test==false)) {

		acf_add_local_field_group(array(
			'key' => 'sws_manage_items_field_group',
			'title' => 'Manage Items',
			'fields' => array(
				array(
					'key' => 'sws_manage_items_field_1',
					'label' => 'IMPORTANT NOTE',
					'name' => '',
					'type' => 'message',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'message' => 'Type the title for your item in the field above <i class="fas fa-arrow-circle-up"></i>. This will be the text displayed to link to it. <strong>Please be sure to assign one or more categories to your item at right.</strong>',
					'new_lines' => 'wpautop',
					'esc_html' => 0,
				),
				array(
					'key' => 'sws_manage_items_field_2',
					'label' => 'Item Type',
					'name' => 'mgr_type',
					'type' => 'radio',
					'instructions' => '',
					'required' => 1,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'choices' => array(
						'doc' => 'Upload (document)',
						'vid' => 'Video',
						'link' => 'Link',
					),
					'allow_null' => 0,
					'other_choice' => 0,
					'default_value' => 'doc',
					'layout' => 'horizontal',
					'return_format' => 'value',
					'save_other_choice' => 0,
				),
				array(
					'key' => 'sws_manage_items_field_3',
					'label' => 'Upload Document (or choose from Media Library)',
					'name' => 'mgr_url',
					'type' => 'file',
					'instructions' => '',
					'required' => 1,
					'conditional_logic' => array(
						array(
							array(
								'field' => 'sws_manage_items_field_2',
								'operator' => '==',
								'value' => 'doc',
							),
						),
					),
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'return_format' => 'url',
					'library' => 'all',
					'min_size' => '',
					'max_size' => '',
					'mime_types' => '',
				),
				array(
					'key' => 'sws_manage_items_field_4',
					'label' => 'Video URL',
					'name' => 'mgr_url',
					'type' => 'text',
					'instructions' => 'Your library can manage items from Vimeo, YouTube, or Facebook. Make sure to include the <strong>https://</strong> or <strong>https://</strong> part of the URL.',
					'required' => 1,
					'conditional_logic' => array(
						array(
							array(
								'field' => 'sws_manage_items_field_2',
								'operator' => '==',
								'value' => 'vid',
							),
						),
					),
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'maxlength' => '',
				),
				array(
					'key' => 'sws_manage_items_field_5',
					'label' => 'Link URL',
					'name' => 'mgr_url',
					'type' => 'text',
					'instructions' => 'Paste the link to whatever you\'re wanting to include in your Manager. Make sure that you include the <strong>http://</strong> or <strong>https://</strong> part. If you\'re linking to a video, please choose the VIDEO item type.',
					'required' => 1,
					'conditional_logic' => array(
						array(
							array(
								'field' => 'sws_manage_items_field_2',
								'operator' => '==',
								'value' => 'link',
							),
						),
					),
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'maxlength' => '',
				),
				array(
					'key' => 'sws_manage_items_field_6',
					'label' => 'Link Date',
					'name' => 'mgr_date',
					'type' => 'date_picker',
					'instructions' => 'Defaults to today\'s date; if you want to indicate the date of an article, you can change that here.',
					'required' => 0,
					'conditional_logic' => array(
						array(
							array(
								'field' => 'sws_manage_items_field_2',
								'operator' => '==',
								'value' => 'link',
							),
						),
					),
					'wrapper' => array(
						'width' => '50',
						'class' => '',
						'id' => '',
					),
					'display_format' => 'Y-m-d',
					'return_format' => 'Y-m-d',
					'first_day' => 0,
				),
				array(
					'key' => 'sws_manage_items_field_7',
					'label' => '',
					'name' => '',
					'type' => 'message',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'message' => 'OPTIONAL: Type a description of your item below <i class="fas fa-arrow-circle-down"></i>',
					'new_lines' => 'wpautop',
					'esc_html' => 0,
				),
			),
			'location' => array(
				array(
					array(
						'param' => 'post_type',
						'operator' => '==',
						'value' => 'item',
					),
				),
			),
			'menu_order' => 0,
			'position' => 'acf_after_title',
			'style' => 'default',
			'label_placement' => 'top',
			'instruction_placement' => 'label',
			'hide_on_screen' => array(
				0 => 'permalink',
				1 => 'excerpt',
				2 => 'discussion',
				3 => 'comments',
				4 => 'revisions',
				5 => 'slug',
				6 => 'author',
				7 => 'format',
				8 => 'page_attributes',
				9 => 'featured_image',
				10 => 'tags',
				11 => 'send-trackbacks',
			),
			'active' => true,
			'description' => '',
		));

	} else { error_log("=======================ERROR!================",0); }
}
?>
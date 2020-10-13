<?php



// SHORTCODE FOR Displaying Items
function sws_mg_items_display_func($atts) {
	$a=shortcode_atts(array(
	  'list_title' => 'In Other News...',
	  'mgr_type' => 'link',
	  'category' => 'covid-19',
	  'sort_by' => 'post_date',
	  'sort_order' => 'DESC',
	  'limit' => 15
	), $atts);
	// NOTE TO SELF: SHORTCODE_ATTS DOESN'T LIKE UPPERCASE!!!!
	
	$args =  array( 
		'post_type'			=> 'item',
		'posts_per_page' 	=> $a['limit'],
		'order' 			=> $a['sort_order'],
		'orderby' 			=> $a['sort_by'],
		'meta_query'		=> array (
			array(
				'key'		=>	'mgr_type',
				'value'		=>	$a['mgr_type'],
				'compare'	=>	'LIKE',
				)
			),
	);
	
	$myItems = new WP_Query($args);

	ob_start();	
	if ($myItems->have_posts() ) :
	
	
?><h4><?php echo $a['list_title']; ?></h4><?php	


	switch($a['mgr_type']) {
		default:
		?><ul><?php

		while ( $myItems->have_posts() ) :
			$myItems->the_post();
		?><li><a href="<?php echo get_field('mgr_url'); ?>" target='_blank'><?php echo get_the_title(); ?></a></li><?php
		endwhile;
	
		?></ul><?php
		break;
	}

	ob_end_clean();

	endif;

}

// register shortcode
add_shortcode('sws_display_items', 'sws_mg_items_display_func'); 


?>
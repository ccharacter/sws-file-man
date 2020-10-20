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

	//ob_start();	
	if ($myItems->have_posts() ) :
	
		$mytext="<h3 class='c-block__heading-title u-theme--color--darker'>".$a['list_title']."</h3>";	


	switch($a['mgr_type']) {
		default:
			$mytext.="<ul>";
			
			while ( $myItems->have_posts() ) :
				$myItems->the_post();
				$mytext.="<li><a href=\"".get_field('mgr_url')."\" target='_blank'>".get_the_title()."</a></li>";
			
			endwhile;
		
			$mytext.="</ul>";
		break;
	}

	endif;
	
	$myCats=wp_list_categories( array('hide_title_if_empty'=>true,'show_count'=>1,'echo'=>0));
	
	return $mytext."<hr />".$myCats;
}

// register shortcode
add_shortcode('sws_display_items', 'sws_mg_items_display_func'); 


?>